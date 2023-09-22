<?php
/**
 * Shlib - programming library
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2017
 * @package     shlib
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     0.3.1.661
 * @date        2018-01-15
 */

// Security check to ensure this file is being included by a parent file.
defined('_JEXEC') or die();

class ShlHtmlContent_Image
{
	const IMAGE_SEARCH_NONE = 0;
	const IMAGE_SEARCH_FIRST = 1;
	const IMAGE_SEARCH_LARGEST = 2;

	/**
	 * Get an image size from the file
	 *
	 * @param $url
	 *
	 * @return array Width/height of the image, 0/0 if not found
	 */
	public static function getImageSize($url)
	{
		static $rootPath = '';
		static $pathLength = 0;
		static $rootUrl = '';
		static $rootLength = 0;
		static $protocoleRelRootUrl = '';
		static $protocoleRelRootLength = 0;

		if (empty($rootPath))
		{
			$rootUrl = Juri::root();
			$rootLength = JString::strlen($rootUrl);
			$protocoleRelRootUrl = str_replace(array('https://', 'http://'), '//', $rootUrl);
			$protocoleRelRootLength = JString::strlen($protocoleRelRootUrl);
			$rootPath = JUri::base(true);
			$pathLength = JString::strlen($rootPath);
			if (JFactory::getApplication()->isAdmin())
			{
				$rootPath = str_replace('/administrator', '', $rootPath);
			}
		}

		// default values ?
		$dimensions = array('width' => 0, 'height' => 0);

		// build the physical path from the URL
		if (JString::substr($url, 0, $rootLength) == $rootUrl)
		{
			$cleanedPath = self::trimQuery(JString::substr($url, $rootLength));
		}
		else if (!empty($rootPath) && JString::substr($url, 0, $pathLength) == $rootPath)
		{
			$cleanedPath = self::trimQuery(JString::substr($url, $pathLength));
		}
		else if (JString::substr($url, 0, 2) == '//' && JString::substr($url, 0, $protocoleRelRootLength) == $protocoleRelRootUrl)
		{
			// protocol relative URL
			$cleanedPath = self::trimQuery(JString::substr($url, $protocoleRelRootLength));
		}
		else if (ShlSystem_Route::isFullyQUalified($url))
		{
			// a URL, but not on this site, try to download it and read its size
			$remoteDimensions = self::getCachedRemoteImageDimensions($url);
			return empty($remoteDimensions) ? $dimensions : $remoteDimensions;
		}
		else
		{
			$cleanedPath = self::trimQuery($url);
		}

		$cleanedPath = !empty($rootPath) && substr($cleanedPath, 0, $pathLength) == $rootPath ? substr($url, $pathLength) : $cleanedPath;
		$imagePath = JPATH_ROOT . '/' . $cleanedPath;
		if (file_exists($imagePath))
		{
			$imageInfos = getimagesize($imagePath);
			if (!empty($imageInfos))
			{
				$dimensions = array('width' => $imageInfos[0], 'height' => $imageInfos[1]);
			}
		}
		return $dimensions;
	}

	private static function trimQuery($url)
	{
		$bits = explode('?', $url);
		$trimmed = $bits[0];

		return $trimmed;
	}

	public static function getCachedRemoteImageDimensions($url)
	{
		$key = JFile::makeSafe($url);

		// was it cached?
		$dimensionsCache = JCache::getInstance(
			'output',
			array(
				'caching' => 1,
				'lifetime' => 10080,
				'defaultgroup' => 'shlib_remote_img_size',
			)
		);
		$cachedDimensions = $dimensionsCache->get($key);
		if (!empty($cachedDimensions))
		{
			return $cachedDimensions;
		}

		$dimensionsRead = self::getRemoteImageDimensions($url);

		// format response
		if (is_array($dimensionsRead))
		{
			$cachedDimensions = $dimensionsRead;
			$dimensionsCache->store($cachedDimensions, $key);
		}

		return $cachedDimensions;
	}

	/**
	 * Read a remote image site. Result should be cached for some time
	 * by the calling party, as this is an expensive operation.
	 *
	 * @param array  $dimensions
	 * @param string $url
	 *
	 * @return array|bool|mixed
	 */
	public static function getRemoteImageDimensions($url)
	{
		$dimensions = false;
		$lockKey = JFile::makeSafe($url);

		// get lock cache object
		$lockCache = JCache::getInstance(
			'output',
			array(
				'caching' => 1,
				'lifetime' => 1,
				'defaultgroup' => 'shlib_remote_img_lock',
			)
		);

		$storedLock = $lockCache->get($lockKey);
		if (!empty($storedLock))
		{
			return $dimensions;
		}
		$lockCache->store($url, $lockKey);

		// use utility class to fetch remote image
		$sizeReader = new ShlHtmlContentRemoteimage_Fasterimage();
		$dimensionsRead = $sizeReader->getSize($url);

		// clear lock
		$lockCache->remove($lockKey);

		// format response
		if (is_array($dimensionsRead))
		{
			$dimensions = array('width' => $dimensionsRead[0], 'height' => $dimensionsRead[1]);
		}

		return $dimensions;
	}

	/**
	 * Lookup an image tag in some html content, and returns the src attribute,
	 * based on a selection process:
	 * - none, first found or largest image selection
	 * - an array of minimal width/height the image must have to be included in the selection process
	 *
	 * @param string $content the raw content
	 * @param int    $selectionMode one of this class constant for search mode
	 * @param array  $requiredSize a minimal width/height specification
	 *
	 * @return string image URL, as found in the content (ie relative or absolute)
	 */
	public static function getBestImage($content, $selectionMode = self::IMAGE_SEARCH_NONE, $requiredSize)
	{
		$bestImage = '';

		// save time if no image in content
		if (empty($content) || strpos($content, '<img') === false || $selectionMode == self::IMAGE_SEARCH_NONE)
		{
			return $bestImage;
		}

		// check for a "disable auto search tag" in content
		if (strpos($content, '{disable_auto_meta_image_detection}') !== false)
		{
			return $bestImage;
		}

		// collect images, and select one according to settings
		$regex = '#<img([^>]*)>#Uum';
		$found = preg_match_all($regex, $content, $matches, PREG_SET_ORDER);
		if (!empty($found))
		{
			$bestImageSize = 0;
			foreach ($matches as $match)
			{
				$imageUrl = '';
				if (!empty($match[1]))
				{
					jimport('joomla.utilities.utility');
					$attributes = JUtility::parseAttributes($match[1]);
					if (!empty($attributes['src']))
					{
						$imageUrl = $attributes['src'];
					}
				}
				if (!empty($imageUrl))
				{
					// validate size (200x200)
					$imageSize = self::getImageSize($imageUrl);

					// is it big enough?
					if (
						(!empty($imageSize['width']) && (!empty($imageSize['width']) && $imageSize['width'] >= $requiredSize['width']))
						&&
						(!empty($imageSize['height']) && (!empty($imageSize['height']) && $imageSize['height'] >= $requiredSize['height']))
					)

					{
						if (self::IMAGE_SEARCH_FIRST == $selectionMode)
						{
							// we got a winner
							$bestImage = $imageUrl;
							break;
						}
						else
						{
							// looking for the biggest one
							// store current image size
							$currentImageSize = (int) $imageSize['width'] + (int) $imageSize['height'];
							if ($currentImageSize > $bestImageSize)
							{
								$bestImage = $imageUrl;
								$bestImageSize = $currentImageSize;
							}
						}
					}
				}
			}
		}

		return $bestImage;
	}
}

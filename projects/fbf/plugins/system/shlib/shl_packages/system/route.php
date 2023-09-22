<?php
/**
 * Shlib - programming library
 *
 * @author       Yannick Gaultier
 * @copyright    (c) Yannick Gaultier 2017
 * @package      shlib
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version      0.3.1.661
 * @date        2018-01-15
 */

defined('_JEXEC') or die;

/**
 * Route helper
 *
 */
class ShlSystem_Route
{

	public static $canonicalDomain = null;

	/**
	 * Turn a relative-to-page URL into an absolute one, using the site canonical domain if any
	 *
	 * @param      $url
	 * @param bool $forceDomain if URL is already absolute, we won't fully qualify it with a domain (if relativen we
	 * still prepend the full domain
	 * @param null $isAdmin If === true or === false, disable using JApplication::isAdmin, for testing
	 *
	 * @return string
	 */
	public static function absolutify($url, $forceDomain = false, $isAdmin = null)
	{
		static $basePath = null;
		static $base = null;
		if (is_null($basePath))
		{
			$basePath = JUri::base(true);
			$base = JUri::base();
		}

		// is it already absolute?
		if (self::isFullyQualified($url))
		{
			return $url;
		}

		if (substr($url, 0, 1) == '/')
		{
			if ($forceDomain)
			{
				// make sure the base path is not added twice (for sites in a subfolder)
				if (JString::substr($url, 0, JString::strlen($basePath)) == $basePath)
				{
					$url = JString::substr($url, JString::strlen($basePath));
				}

				$url = self::getCanonicalDomain() . $url;
			}

			return $url;
		}

		// relative URL, make it fully qualified
		$currentBase = $base;
		if ($isAdmin === true || ($isAdmin !== false && JFactory::getApplication()->isAdmin()))
		{
			$currentBase = JString::substr($base, 0, -14);
		}

		return $currentBase . $url;
	}

	/**
	 * Make a url fully qualified and protocol relative
	 *
	 * @param string $url
	 *
	 * @return mixed|string
	 */
	public static function makeProtocolRelative($url)
	{
		$url = self::absolutify($url, true);
		$url = preg_replace('#^https?:\/\/#', '//', $url);

		return $url;
	}

	/**
	 * Finds if a URL is fully qualified, ie starts with a scheme.
	 * Protocal-relative URLs are considered fully qualified.
	 *
	 * @param $url
	 *
	 * @return bool
	 */
	public static function isFullyQualified($url)
	{
		$isFullyQualified =
			substr($url, 0, 2) == '//'
			||
			preg_match(
				'#^[a-zA-Z0-9\-]+:\/\/.*#',
				$url
			);

		return $isFullyQualified;
	}

	/**
	 * Builds and return the canonical domain of the page, taking into account
	 * the optional canonical domain in SEF plugin, and including the base path, if any
	 * Can be called from admin side, to get front end links, by passing true as param
	 *
	 *
	 * @param null $isAdmin If === true or === false, disable using JApplication::isAdmin, for testing
	 *
	 * @return null|string
	 */
	public static function getCanonicalDomain($isAdmin = null)
	{
		if (is_null(self::$canonicalDomain))
		{
			$sefPlgParams = ShlSystem_Joomla::getExtensionParams('plg_sef', array('type' => 'plugin', 'folder' => 'system', 'element' => 'sef'));
			$canonicalParam = JString::trim($sefPlgParams->get('domain', ''));
			if (empty($canonicalParam))
			{
				$base = JUri::base();
				if ($isAdmin === true || ($isAdmin !== false && JFactory::getApplication()->isAdmin()))
				{
					$base = JString::substr($base, 0, -14);
				}
				self::$canonicalDomain = $base;
			}
			else
			{
				self::$canonicalDomain = $canonicalParam;
			}
			self::$canonicalDomain = JString::trim(self::$canonicalDomain, '/');
		}

		return self::$canonicalDomain;
	}

	/**
	 * Execute a URL match rule agains a request URL,a nd returns any match.
	 *
	 * Rule specs:
	 * * => any URL
	 * xxxx => exactly 'xxxxx'
	 * xxx?yyy => 'xxx' + any character + 'yyy'
	 * xxx*yyy => 'xxx' + any string + 'yyy'
	 * *xxxx => any string + 'xxxxx'
	 * xxxx* => 'xxxx' + any string
	 * *xxxx* => any string + 'xxxxx' + any string
	 * *xxxx*yyyy => any string + 'xxxxx' + any string + 'yyyy'
	 *
	 * @param string $rule
	 * @param string $path the path relative to the root of the site, starting with a /
	 *
	 * @return array
	 */
	public static function urlRuleMatch($rule, $path, $wildChar = '*', $singleChar = '?', $regexpChar = '~')
	{
		// shortcuts
		if ($wildChar == $rule)
		{
			// simulate a regexp match
			return array(
				$path,
				$path
			);
		}

		// build a reg exp based on rule
		if (JString::substr($rule, 0, 1) == $regexpChar)
		{
			// this is a regexp, use it directly
			$regExp = $rule;
		}
		else
		{
			// actually build the reg exp
			$saneStarBits = array();
			$starBits = explode($wildChar, $rule);
			foreach ($starBits as $sBit)
			{
				// same thing with ?
				$questionBits = explode($singleChar, $sBit);
				$saneQBit = array();
				foreach ($questionBits as $qBit)
				{
					$saneQBit[] = preg_quote($qBit);
				}

				$saneStarBits[] = implode($singleChar, $saneQBit);
			}

			// each part has been preg_quoted
			$sanitized = implode($wildChar, $saneStarBits);
			$regExp = str_replace($singleChar, '(.)', $sanitized);
			$regExp = str_replace($wildChar, '(.*)', $regExp);
			$regExp = '~^' . $regExp . '$~uU';
		}

		// execute and return
		preg_match($regExp, $path, $matches);

		return $matches;
	}

	/**
	 * Execute a URL match rule agains a request URL,a nd returns a boolean if a match occured.
	 *
	 * Rule specs:
	 * * => any URL
	 * xxxx => exactly 'xxxxx'
	 * xxx?yyy => 'xxx' + any character + 'yyy'
	 * xxx*yyy => 'xxx' + any string + 'yyy'
	 * *xxxx => any string + 'xxxxx'
	 * xxxx* => 'xxxx' + any string
	 * *xxxx* => any string + 'xxxxx' + any string
	 * *xxxx*yyyy => any string + 'xxxxx' + any string + 'yyyy'
	 *
	 * @param string $rule
	 * @param string $path the path relative to the root of the site, starting with a /
	 */
	public static function isUrlRuleMatch($rule, $path, $wildChar = '*', $singleChar = '?', $regexpChar = '~')
	{
		$matches = self::urlRuleMatch($rule, $path, $wildChar, $singleChar, $regexpChar);

		return !empty($matches[0]);
	}
}

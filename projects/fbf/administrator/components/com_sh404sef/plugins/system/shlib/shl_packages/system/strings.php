<?php
/**
 * Shlib - programming library
 *
 * @author       Yannick Gaultier
 * @copyright    (c) Yannick Gaultier 2017
 * @package      shlib
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version      0.3.1.661
 * @date                2018-01-15
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Provide a few string manipulation methods
 *
 * @since    0.2.1
 *
 */
class ShlSystem_Strings
{
	const NONE = 'none';
	const LOWERCASE = 'lowercase';
	const UPPERCASE = 'uppercase';
	const UCFIRST = 'ucfirst';

	/**
	 * Performs a preg_replace, wrapping it to catch errors
	 * caused by bad characters or otherwise
	 *
	 * @param string $pattern RegExp pattern
	 * @param string $replace RegExp replacement
	 * @param string $subject RegExp subject
	 * @param string $ref Optional reference, to be logged in case of error
	 *
	 * @return    string    the result of preg_replace operation
	 */
	public static function pr($pattern, $replace, $subject, $ref = '')
	{
		static $pageUrl = null;

		$tmp = preg_replace($pattern, $replace, $subject);
		if (is_null($tmp))
		{
			$pageUrl = is_null($pageUrl) ? (empty($_SERVER['REQUEST_URI']) ? '' : ' on page ' . $_SERVER['REQUEST_URI']) : $pageUrl;
			ShlSystem_Log::error(
				'shlib', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__,
				'RegExp failed: invalid character' . $pageUrl . (empty($ref) ? '' : ' (' . $ref . ')')
			);
			return $subject;
		}
		else
		{
			return $tmp;
		}
	}

	/**
	 * Format into K and M for large number
	 * 0 -> 9999 : literral
	 * 10 000 -> 999999 : 10K -> 999,9K (max one decimal)
	 * > 1000 000 : 1M -> 1,9M (max 1 decimals)
	 *
	 * @param $n
	 * @param $format
	 */
	public static function formatIntForTitle($n)
	{
		if ($n < 10000)
		{
			return (int) $n;
		}
		else if ($n < 1000000)
		{
			$n = $n / 100.0;
			$n = floor($n) / 10;
			$n = sprintf('%.1f', $n) . 'K';
		}
		else
		{
			$n = $n / 100000;
			$n = floor($n) / 10;
			$n = sprintf('%.1f', $n) . 'M';
		}

		return $n;
	}

	/**
	 * Explode a string about a delimiter, then store each part
	 * into an array, after trimming characters at both ends
	 * Only non-empty cleaned items are added to the returned array
	 *
	 * @param        $string
	 * @param string $delimiter
	 * @param string $caseHandling none | lowercase | uppercase | ufcirst
	 *
	 * @return array
	 */
	public static function stringToCleanedArray($string, $delimiter = ',', $caseHandling = self::NONE)
	{
		$output = array();
		$bits = explode($delimiter, $string);
		if (!empty($bits))
		{
			foreach ($bits as $bit)
			{
				$cleaned = JString::trim($bit);
				if (!empty($cleaned))
				{
					switch ($caseHandling)
					{
						case self::LOWERCASE:
							$output[] = JString::strtolower($cleaned);
							break;
						case self::UPPERCASE:
							$output[] = JString::strtoupper($cleaned);
							break;
						case self::UCFIRST:
							$output[] = JString::ucfirst($cleaned);
							break;
						default:
							$output[] = $cleaned;
							break;
					}
				}
			}
		}

		return $output;
	}
}

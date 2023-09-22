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
defined('_JEXEC') or die;

/**
 * A set of timesaving php functions
 *
 * @author  weeblr
 */

if (!function_exists('wbArrayGet'))
{
	/**
	 * Get a value by key from an array, defaulting to
	 * a provided value if key doesn't exist.
	 * Key can be an array of keys, which are then
	 * traversed
	 *
	 * @param array $array
	 * @param       $keys
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	function wbArrayGet($array, $keys, $default = null)
	{
		if (empty($keys) && $keys !== 0)
		{
			return $array;
		}

		if (!is_array($array))
		{
			return $default;
		}

		if (!is_array($keys) && isset($array[$keys]))
		{
			return $array[$keys];
		}

		if (is_array($keys))
		{
			$current = $array;
			foreach ($keys as $key)
			{
				if (!is_array($current) || !array_key_exists($key, $current))
				{
					return $default;
				}

				$current = $current[$key];
			}

			return $current;
		}

		return $default;
	}
}

if (!function_exists('wbArrayIsSet'))
{
	/**
	 * Find if an array has a specifi key.
	 * Key can be an array of keys, which are then
	 * traversed
	 *
	 * @param array $array
	 * @param mixed $keys
	 *
	 * @return bool
	 */
	function wbArrayIsSet($array, $keys)
	{
		if (empty($keys) && $keys !== 0)
		{
			return false;
		}

		if (!is_array($array))
		{
			return false;
		}

		if (!is_array($keys) && isset($array[$keys]))
		{
			return true;
		}

		if (is_array($keys))
		{
			$current = $array;
			foreach ($keys as $key)
			{
				if (!array_key_exists($key, $current))
				{
					return false;
				}

				$current = $current[$key];
			}

			return true;
		}

		return false;
	}
}

if (!function_exists('wbArrayIsEmpty'))
{
	/**
	 * Get a value by key from an array and check if it is empty.
	 *
	 * @param array $array
	 * @param       $keys
	 *
	 * @return bool
	 */
	function wbArrayIsEmpty($array, $keys)
	{
		$value = wbArrayGet($array, $keys, null);

		return empty($value);
	}
}

if (!function_exists('wbArrayIsEqual'))
{
	/**
	 * Get a value by key from an array and check if it is equal to a given value
	 *
	 * @param array $array
	 * @param       $keys
	 * @param mixed $value
	 * @param bool  $strict
	 *
	 * @return bool
	 */
	function wbArrayIsEqual($array, $keys, $value, $strict = false)
	{
		$actualValue = wbArrayGet($array, $keys, null);

		return $strict ? $actualValue === $value : $actualValue == $value;
	}
}

if (!function_exists('wbArraySet'))
{
	/**
	 * Set a value by key from an array.
	 * Key can be an array of keys, which are then
	 * traversed
	 *
	 * @param array $array
	 * @param mixed $keys
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	function wbArraySet($array, $keys, $value)
	{
		if (!is_array($array))
		{
			$array = array();
		}

		if (is_scalar($keys))
		{
			// end recursion
			$array[$keys] = $value;

			return $array;
		}
		if (!is_array($keys))
		{
			// objects?
			return $array;
		}

		// current iteration key
		$key = array_shift($keys);

		if (!empty($keys))
		{
			if (!isset($array[$key]) || !is_array($array[$key]))
			{
				$array[$key] = array();
			}
			$array[$key] = wbArraySet($array[$key], $keys, $value);
		}
		else
		{
			$array[$key] = $value;
		}

		return $array;
	}
}

if (!function_exists('wbArrayKeyAppend'))
{
	/**
	 * Append a string to an array member
	 * If not existing, the array member is created
	 *
	 * @param array  $array
	 * @param mixed  $key
	 * @param string $value
	 *
	 * @throws InvalidArgumentException
	 * @return mixed
	 */
	function wbArrayKeyAppend(&$array, $key, $value, $glue = '')
	{
		if (empty($key))
		{
			return;
		}
		if (!is_array($array) && !empty($array))
		{
			throw new \InvalidArgumentException('Trying to initialize an array key, while not an array and not empty');
		}
		else if (!is_array($array))
		{
			throw new \InvalidArgumentException('Trying to initialize an array key, while not an array');
		}

		$array[$key] = empty($array[$key]) ? $value : $array[$key] . $glue . $value;
	}
}

if (!function_exists('wbArrayKeyInit'))
{
	/**
	 * Set initial value of an array member
	 * only if it doesn't exist already
	 * Replaces:
	 * $array['key'] = isset($array['key'] ? $array['key'] : "some value";
	 *
	 * @param array $array
	 * @param mixed $key
	 * @param mixed $default
	 *
	 * @throws InvalidArgumentException
	 * @return mixed
	 */
	function wbArrayKeyInit(&$array, $key, $default)
	{
		if (empty($key) || isset($array[$key]))
		{
			return;
		}
		if (!is_array($array) && !empty($array))
		{
			throw new \InvalidArgumentException('Trying to initialize an array key, while not an array and not empty');
		}
		else if (!is_array($array))
		{
			$array = array();
		}

		$array[$key] = $default;
	}
}

if (!function_exists('wbArrayKeyMerge'))
{
	/**
	 * Merges an array with one of the values of an associative array
	 * initializing it if that key doesn't exists already
	 *
	 * Replaces:
	 * $array['key'] = isset($array['key'] ? array_merge($array['key'], $newArray) : $newArray;
	 *
	 * Note: if the key exists, but doesn't contain an array, its value is casted to an array
	 * Note: if the passed "$array" is actually not an array, it's left untouched
	 *
	 * @param array $array
	 * @param mixed $key
	 * @param array $toMerge
	 */
	function wbArrayKeyMerge(&$array, $key, $toMerge)
	{
		$array = empty($array) ? array() : $array;
		if (is_array($array))
		{
			$array[$key] = empty($array[$key]) ? (array) $toMerge : array_merge((array) $array[$key], (array) $toMerge);
		}
	}
}

if (!function_exists('wbArrayFilterByKey'))
{
	/**
	 * Filter an associative array, returning only keys listed
	 * in the second parameter
	 *
	 * @param array $data
	 * @param array $keyList
	 *
	 * @return array
	 */
	function wbArrayFilterByKey($data, $keyList)
	{
		// return untouched if invalid params
		if (!is_array($data) || !is_array($keyList))
		{
			return $data;
		}

		$filtered = array();
		foreach ($data as $key => $value)
		{
			if (in_array($key, $keyList))
			{
				$filtered[$key] = $value;
			}
		}

		return $filtered;
	}
}

if (!function_exists('wbArrayMerge'))
{
	/**
	 * Merges  arrays, checking that they are indeed arrays
	 *
	 * @param [array, array, ...]
	 *
	 * @return array
	 */
	function wbArrayMerge()
	{
		$args = func_get_args();
		$merged = array();
		foreach ($args as $array)
		{
			$merged = array_merge($merged, (array) $array);
		}

		return $merged;
	}
}

if (!function_exists('wbInitEmpty'))
{
	/**
	 * Return passed value if not empty, default otherwise
	 *
	 * @param mixed $value
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	function wbInitEmpty($value, $default)
	{
		return empty($value) ? $default : $value;
	}
}

if (!function_exists('wbDump'))
{
	function wbDump($value, $name = '', $asString = false, $newLine = '<br />', $codeWrapper = '<pre>%s</pre>')
	{
		$back = debug_backtrace(false);
		if (count($back) > 1)
		{
			$caller = wbArrayGet($back[1], 'class', '-') . ' | ' . wbArrayGet($back[1], 'function', '-') . ' | ' . wbArrayGet($back[0], 'line', '-');
		}
		else
		{
			$caller = '';
		}
		$output = '';
		$name = empty($name) ? 'Var dump' : $name;
		$output .= $newLine . '<b>' . $name . ': </b><small>(' . $caller . ')</small>' . $newLine;
		$output .= sprintf($codeWrapper, is_null($value) ? 'null' : print_r($value, true));
		$output .= $newLine;

		echo $asString ? null : $output;

		return $output;
	}
}

if (!function_exists('wbLog'))
{
	function wbLog($message, $includeBacktrace = null, $newLine = '<br />', $codeWrapper = '<pre>%s</pre>')
	{
		if (!defined('WBLIB_LOG_TO_SCREEN') || WBLIB_LOG_TO_SCREEN === false)
		{
			return;
		}

		// include backtrace if globally set, or based on call argument
		if (defined('WBLIB_LOG_TO_SCREEN_INCLUDE_BACKTRACE') && WBLIB_LOG_TO_SCREEN_INCLUDE_BACKTRACE !== false && $includeBacktrace !== false)
		{
			$includeBacktrace = true;
		}

		if ($includeBacktrace)
		{
			$back = debug_backtrace(false);
			$message .= $newLine . sprintf($codeWrapper, print_r($back, true));
		}

		echo $message . $newLine;
	}
}

if (!function_exists('wbContains'))
{
	function wbContains($haystack, $needles)
	{
		if (is_string($needles))
		{
			return !empty($needles) && JString::strpos($haystack, $needles) !== false;
		}
		else if (is_array($needles))
		{
			foreach ($needles as $needle)
			{
				if (!empty($needle) && JString::strpos($haystack, $needle) !== false)
				{
					return true;
				}
			}
		}

		return false;
	}
}

if (!function_exists('wbStartsWith'))
{
	function wbStartsWith($haystack, $needles)
	{
		if (is_string($needles))
		{
			return !empty($needles) && 0 === JString::strpos($haystack, $needles);
		}
		else if (is_array($needles))
		{
			foreach ($needles as $needle)
			{
				if (!empty($needle) && 0 === JString::strpos($haystack, $needle))
				{
					return true;
				}
			}
		}

		return false;
	}
}

if (!function_exists('wbEndsWith'))
{
	function wbEndsWith($haystack, $needles)
	{
		if (is_string($needles))
		{
			return !empty($needles) && JString::substr($haystack, -JString::strlen($needles)) == $needles;
		}
		else if (is_array($needles))
		{
			foreach ($needles as $needle)
			{
				if (!empty($needle) && JString::substr($haystack, -JString::strlen($needle)) == $needle)
				{
					return true;
				}
			}
		}

		return false;
	}
}

if (!function_exists('wbRTrim'))
{
	function wbRTrim($string, $toTrim)
	{
		if (wbEndsWith($string, $toTrim))
		{
			$string = JString::substr($string, 0, -JString::strlen($toTrim));
		}

		return $string;
	}
}

if (!function_exists('wbLTrim'))
{
	function wbLTrim($string, $toTrim)
	{
		if (wbStartsWith($string, $toTrim))
		{
			$string = JString::substr($string, JString::strlen($toTrim));
		}

		return $string;
	}
}

if (!function_exists('wbJoin'))
{
	/**
	 * Join hopefully strings with a glue string
	 * Warning: empty strings are removed prior to joining
	 *
	 * @param string $glue the string to use to glue things
	 * @param        mixed variable numbers or aguments te be joined
	 *
	 * @return mixed
	 */
	function wbJoin($glue)
	{
		$args = func_get_args();

		// get glue out
		array_shift($args);

		return join(array_filter($args), $glue);
	}
}

if (!function_exists('wbDotJoin'))
{
	/**
	 * Join (hopefully) strings with dots
	 * Warning: empty strings are removed prior to joining
	 *
	 * @param string    $glue the string to use to glue things
	 * @param \variable $mixed numbers or aguments te be joined
	 *
	 * @return mixed
	 */
	function wbDotJoin()
	{
		$args = func_get_args();

		return join(array_filter($args), '.');
	}
}

if (!function_exists('wbSlashJoin'))
{
	/**
	 * Join (hopefully) strings with dots
	 * Warning: empty strings are removed prior to joining
	 *
	 * @param string    $glue the string to use to glue things
	 * @param \variable $mixed numbers or aguments te be joined
	 *
	 * @return mixed
	 */
	function wbSlashJoin()
	{
		$args = func_get_args();

		return join(array_filter($args), '/');
	}
}

if (!function_exists('wbDot2Slash'))
{
	/**
	 * Replace dots with slashes in a string
	 *
	 * @param $string
	 *
	 * @return mixed
	 */
	function wbDot2Slash($string)
	{
		return str_replace('.', '/', $string);
	}
}

if (!function_exists('wbWith'))
{
	/**
	 * Returns the object passed.
	 * Allow creating and using an object in one go
	 * as in:
	 *
	 * wbWith(new Someclass())->someMethod();
	 *
	 * @param $object
	 *
	 * @return mixed
	 */
	function wbWith($object)
	{
		return $object;
	}
}

if (!function_exists('wbAbridge'))
{
	/**
	 * @package     Joomla.Platform
	 * @subpackage  HTML
	 *
	 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE
	 */
	/**
	 * HTML helper class for rendering manipulated strings.
	 *
	 * @package     Joomla.Platform
	 * @subpackage  HTML
	 * @since       11.1
	 */
	/**
	 * Abridges text strings over the specified character limit. The
	 * behavior will insert an ellipsis into the text replacing a section
	 * of variable size to ensure the string does not exceed the defined
	 * maximum length. This method is UTF-8 safe.
	 *
	 * For example, it transforms "Really long title" to "Really...title".
	 *
	 * Note that this method does not scan for HTML tags so will potentially break them.
	 *
	 * @param   string  $text The text to abridge.
	 * @param   integer $length The maximum length of the text (default is 50).
	 * @param   integer $intro The maximum length of the intro text (default is 30).
	 * @param string    $bridge the string to use to bridge
	 *
	 * @return  string   The abridged text.
	 *
	 * @since   11.1
	 */
	function wbAbridge($text, $length = 50, $intro = 30, $bridge = '...')
	{
		// Abridge the item text if it is too long.
		if (JString::strlen($text) > $length)
		{
			// Determine the remaining text length.
			$remainder = $length - ($intro + JString::strlen($bridge));

			// Extract the beginning and ending text sections.
			$beg = JString::substr($text, 0, $intro);
			$end = JString::substr($text, JString::strlen($text) - $remainder);

			// Build the resulting string.
			$text = $beg . $bridge . $end;
		}

		return $text;
	}
}

if (!function_exists('wbGetProtectedProperty'))
{
	/**
	 * Fetch a private or protected property from an object
	 *
	 * @param string  $className
	 * @param string  $propertyName
	 * @param object  $instance
	 * @param boolean $static
	 *
	 * @return mixed property value, or null
	 */
	function wbGetProtectedProperty($className, $propertyName, $instance, $static = false)
	{
		static $_classesCache = array();
		static $_propertiesCache = array();

		if (version_compare(phpversion(), '5.3', 'ge'))
		{
			try
			{
				if (empty($_propertiesCache[$className . $propertyName]))
				{
					if (empty($_classesCache[$className]))
					{
						$_classesCache[$className] = new ReflectionClass($className);
					}
					$_propertiesCache[$className . $propertyName] = $_classesCache[$className]->getProperty($propertyName);
					$_propertiesCache[$className . $propertyName]->setAccessible(true);
				}
				$propertyValue = $static ? $_propertiesCache[$className . $propertyName]->getStaticValue($instance)
					: $_propertiesCache[$className . $propertyName]->getValue($instance);
			}
			catch (Exception $e)
			{
				ShlSystem_Log::error('sh404sef', __CLASS__ . '/' . __METHOD__ . '/' . __LINE__ . ': ' . $e->getMessage());
				$propertyValue = null;
			}
		}
		else
		{
			if (!$static)
			{
				// poor man's reflection, pre 5.3.0
				$dump = print_r($instance, true);
				$propertytag = '[' . $propertyName . ':protected]';
				$bits = explode($propertytag, $dump);
				$bit = $bits[1];
				$bits = explode('[_', $bit);
				$bit = str_replace('=>', '', $bits[0]);
				$propertyValue = trim($bit);
			}
			else
			{
				$propertyValue = null;
			}
		}

		return $propertyValue;
	}
}

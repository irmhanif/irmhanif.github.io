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
 * Simple hook system
 *
 */
class ShlHook
{
	private static $hooks = array();

	private static $hooksStack = array();

	private static $hooksRuns = array();

	/**
	 * Look for, and include_once if found, a wb_functions.php file that can
	 * contains user provided code.
	 *
	 * Default search path is:
	 *
	 * {root}/templates/{current_template}/html/wb_functions.php
	 *
	 * If a path is provided, it is used instead, as in:
	 * {provided_full_path}/wb_functions.php
	 *
	 * @param string $path Root path to search for the wb_functions.php file.
	 * @param string $fileName Optional file name to include instead of wb_functions.php
	 *
	 * @return bool
	 */
	public static function load($path = '', $fileName = 'wb_functions.php')
	{
		if (empty($path))
		{
			$path = JPATH_ROOT . '/libraries/weeblr';
		}
		$path = rtrim($path, '/\\');
		$fullPath = $path . '/' . $fileName;
		if (file_exists($fullPath))
		{
			include_once $fullPath;
			return true;
		}

		return false;
	}

	/**
	 * Add a hook, identified by a dot-joined id (weeblramp.some_name)
	 * and a callback
	 *
	 * @param string   $id Dot-joined unique identifier for the hook
	 * @param Callable $callback Callback that was passed to add method
	 * @param int      $priority Higher priorities are executed first. Default to 100.
	 *
	 * @return bool True if hook was added
	 **/
	public static function add($id, $callback, $priority = 100)
	{
		$added = false;

		if (!empty($id) && is_string($id) && is_callable($callback))
		{
			$priority = (int) $priority;
			self::$hooks[$id] = empty(self::$hooks[$id]) ? array() : self::$hooks[$id];
			self::$hooks[$id][$priority] = empty(self::$hooks[$id][$priority]) ? array() : self::$hooks[$id][$priority];
			self::$hooks[$id][$priority][] = array(
				'callback' => $callback,
				'hash' => self::hash($callback)
			);

			// re-order by priority
			krsort(self::$hooks[$id]);

			$added = true;
		}
		return $added;
	}

	/**
	 * Remove a callback for a given hook
	 *
	 * @param string   $id Dot-joined unique identifier for the hook
	 * @param Callable $callback Callback that was passed to add method
	 * @param int|null $priority Optional param to restrict removal to a given priority level
	 *
	 * @return bool True if hook was removed
	 **/
	public static function remove($id, $callback, $priority = null)
	{
		$removed = false;

		// cannot remove it hook does not exist
		if (!array_key_exists($id, self::$hooks))
		{
			return $removed;
		}

		// do not remove a hook that is being executed
		if (in_array($id, self::$hooksStack))
		{
			return $removed;
		}

		$hash = self::hash($callback);
		if (is_null($priority))
		{
			// if no priority was specified, we remove the hook
			// callback from all priority levels
			foreach (self::$hooks[$id] as $priority => $hookRecord)
			{
				$removed = self::removeCallback($id, $priority, $hash);
				if ($removed)
				{
					break;
				}
			}
		}
		else
		{
			// a priority was specified, we only remove the callback
			// from that priority
			$removed = self::removeCallback($id, $priority, $hash);
		}

		return $removed;
	}

	/**
	 * @param string $id Dot-joined unique identifier for the hook
	 * @param int    $priority Restrict removal to a given priority level
	 * @param string $hash
	 *
	 * @return bool true if callback was remo
	 */
	private static function removeCallback($id, $priority, $hash)
	{
		$removed = false;
		foreach (self::$hooks[$id][$priority] as $index => $hookRecord)
		{
			if ($hash == $hookRecord['hash'])
			{
				$removed = true;
				unset(self::$hooks[$id][$priority][$index]);
			}
		}

		return $removed;
	}

	/**
	 * Builds a unique hash for a callable callback
	 *
	 * @param Callable $callback
	 *
	 * @return string
	 */
	private static function hash($callback)
	{
		$hash = is_object($callback) ? spl_object_hash($callback) : md5(serialize($callback));
		return $hash;
	}

	/**
	 * Execute all callbacks registered for a hook id
	 * in order of priority
	 * Params can be modified by the callback, if so defined
	 * Execution can return values
	 *
	 * @param string $id Dot-joined unique identifier for the hook
	 *
	 * @return mixed|null
	 **/
	public static function run()
	{
		self::execute(false, func_get_args());
	}

	/**
	 * Execute all callbacks registered for a hook id
	 * in order of priority
	 * A value must be returned, which will normally be assigned
	 * by caller to replace current value
	 *
	 * @param string $id Dot-joined unique identifier for the hook
	 * @param mixed  $currentValue Current value of variable, to be modified
	 *
	 * @return mixed
	 **/
	public static function filter()
	{
		return self::execute(true, func_get_args());
	}

	/**
	 * Execute all callbacks registered for a hook id
	 * in order of priority
	 * A value must be returned, which will normally be assigned
	 * by caller to replace current value
	 *
	 * @param array $params
	 *
	 * @return mixed
	 **/
	private static function execute($filter, $params)
	{
		// remove the filter id from params array
		$id = array_shift($params);

		// default returned value
		$currentValue = null;
		if (count($params) > 0)
		{
			$currentValue = $params[0];
		}

		// invalid hook id
		if (!is_string($id))
		{
			return $currentValue;
		}

		// no hook registered
		if (empty(self::$hooks[$id]))
		{
			return $currentValue;
		}

		// already running. We don't allow nesting
		if (in_array($id, self::$hooksStack))
		{
			return $currentValue;
		}
		self::$hooksStack[] = $id;

		// increase run counter
		self::$hooksRuns[$id] = isset(self::$hooksRuns[$id]) ? self::$hooksRuns[$id]++ : 1;

		// iterate over registered hook handlers
		foreach (self::$hooks[$id] as $priority => $callbackList)
		{
			foreach ($callbackList as $callbackRecord)
			{
				if ($filter)
				{
					$params[0] = call_user_func_array($callbackRecord['callback'], $params);
				}
				else
				{
					call_user_func_array($callbackRecord['callback'], $params);
				}
			}
		}

		$newValue = null;
		if ($filter)
		{
			$newValue = isset($params[0]) ? $params[0] : null;
		}

		array_pop(self::$hooksStack);

		return $newValue;
	}
}

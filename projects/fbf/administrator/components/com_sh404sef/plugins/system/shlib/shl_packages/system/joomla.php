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
class ShlSystem_Joomla
{
	public static function getExtensionParams($extension, $options, $forceRead = false)
	{
		static $_params = array();

		if (!isset($_params[$extension]) || $forceRead)
		{
			try
			{
				$oldParams = ShlDbHelper::selectResult('#__extensions', 'params', $options);
				$_params[$extension] = new JRegistry();
				$_params[$extension]->loadString($oldParams);
			}
			catch (Exception $e)
			{
				$_params[$extension] = new JRegistry();
				ShlSystem_Log::error('shlib', '%s::%d: %s', __METHOD__, __LINE__, $e->getMessage());
			}
		}

		return $_params[$extension];
	}

	/**
	 * Save a joomla parameters object to the #__extensions table.
	 *
	 * @param JRegistry $params
	 * @param array $options
	 *
	 * @return bool
	 */
	public static function saveExtensionParams($params, $options)
	{
		try
		{
			ShlDbHelper::update('#__extensions', array('params' => (string) $params), $options);
			return true;
		}
		catch (Exception $e)
		{
			ShlSystem_Log::error('shlib', '%s::%d: %s', __METHOD__, __LINE__, $e->getMessage());
			return false;
		}
	}
}

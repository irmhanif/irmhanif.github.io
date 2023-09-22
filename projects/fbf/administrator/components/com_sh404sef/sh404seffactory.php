<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.13.2.3783
 * @date        2018-01-25
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC'))
{
	die('Direct Access to this location is not allowed.');
}

/**
 * A factory class to assist in handling our objects
 *
 * @author  weeblr
 */
abstract class Sh404sefFactory
{
	public static function getController($name = 'default', $config = array(), $prefix = 'Sh404sef')
	{
		// if no name, use default
		$name = empty($name) ? 'default' : $name;

		// find about controller class name
		// warning : if prefix is no 'Sh404sef', need to include the class file first
		// autoloader won't autoload it otherwise
		$controllerClass = ucfirst($prefix) . 'Controller' . ucfirst($name);

		// instantiate our class
		$controller = new $controllerClass($config);

		return $controller;
	}

	/**
	 * Get a Extplugin object for the requested extension
	 * If no specific plugin is found, the default, generic
	 * public is used instead
	 *
	 * @param string $option the Joomla! component name. Should begin with "com_"
	 *
	 * @return object Sh404sefExtpluginBaseextplugin descendant
	 */
	public static function &getExtensionPlugin($option)
	{
		static $_plugins = array();

		if (empty($option))
		{
			$option = 'default';
		}

		// plugin is cached, check if we already created
		// the plugin for $option
		if (empty($_plugins[$option]))
		{
			// build the class name for this plugin
			// autolaoder will find the appropriate file and load it
			// if not loaded
			if ($option !== 'default' && strpos($option, 'com_') !== 0)
			{
				$option = 'com_' . $option;
			}
			$className = 'Sh404sefExtplugin' . ucfirst(strtolower($option));

			// does this class exists?
			$sefConfig = &Sh404sefFactory::getConfig();
			if (class_exists($className, $autoload = true))
			{
				// instantiate plugin
				$_plugins[$option] = new $className($option, $sefConfig);
			}
			else
			{
				// else use generic plugin
				$_plugins[$option] = new Sh404sefExtpluginDefault($option, $sefConfig);
			}
		}

		// return cached plugin
		return $_plugins[$option];
	}

	/**
	 * Create and return an object holding a set of
	 * data on the current request
	 *
	 * @param object $pageInfo
	 */
	public static function &getPageInfo()
	{
		static $_instance = null;

		if (is_null($_instance))
		{
			$_instance = new Sh404sefClassPageinfo();
		}

		return $_instance;
	}

	/**
	 *
	 * Creates and return an object holding
	 * sh404SEF current configuration
	 *
	 */
	public static function &getConfig($reset = false)
	{
		static $_config = null;

		if (empty($_config) || $reset)
		{ // config not read yet
			$_config = new shSEFConfig($reset);
		}
		return $_config;
	}

	/**
	 *
	 * Gets a program configuration object
	 * Contains hardcoded program setup
	 * independant from user config
	 *
	 */
	public static function getPConfig()
	{
		static $_pconfig = null;

		if (empty($_pconfig))
		{ // config not read yet
			$_pconfig = new Sh404sefConfiguration();
		}
		return $_pconfig;
	}

	/**
	 *
	 * Creates a unique helper to
	 * assist in J! versions
	 * compatibility management
	 *
	 */
	public static function &getCompatHelper()
	{
		static $_helper = null;

		if (empty($_helper))
		{ // config not read yet

			if (version_compare(JVERSION, '3', 'ge'))
			{
				$mainVersion = '3';
			}
			else
			{
				$mainVersion = '2';
			}
			$className = 'ShcompatHelperJ' . $mainVersion;
			$_helper = new $className();
		}

		return $_helper;
	}

	/**
	 * Create and return an object holding a set of
	 * data on the current request
	 *
	 * @param JUri $uri
	 */
	public static function &getRedirector($uri = null)
	{
		static $_instance = null;

		if (is_null($_instance))
		{
			$_instance = new Sh404sefModelRedirector(
				$uri,
				self::getConfig(),
				JFactory::getConfig()
			);
		}

		return $_instance;
	}
}

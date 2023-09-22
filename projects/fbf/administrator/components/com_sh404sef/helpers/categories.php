<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author       Yannick Gaultier
 * @copyright    (c) Yannick Gaultier - Weeblr llc - 2018
 * @package      sh404SEF
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version      4.13.2.3783
 * @date        2018-01-25
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC'))
{
	die('Direct Access to this location is not allowed.');
}

class Sh404sefHelperCategories
{
	// class cache to hold "uncategorized" category details per extension
	public static $uncategorizedCat = array();

	/**
	 *
	 * Get details of the "Uncategorized" category for a given extension,
	 * storing the result in a cache variable
	 *
	 * @param string $extension full name of extension, ie "com_content"
	 */
	public static function getUncategorizedCat($extension = 'com_content')
	{
		// if not already in cache
		if (!isset(self::$uncategorizedCat[$extension]))
		{

			try
			{
				// read details from database
				self::$uncategorizedCat[$extension] = ShlDbHelper::selectObject('#__categories', '*', 'parent_id > 0 and extension = ? and path = ? and level = ?', array($extension, 'uncategorised', 1));
			}
			catch (Exception $e)
			{

				self::$uncategorizedCat[$extension] = null;
			}
		}

		return self::$uncategorizedCat[$extension];
	}

}


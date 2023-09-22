<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_trip
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Fixed_trip helper.
 *
 * @since  1.6
 */
class Fixed_tripHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_FIXED_TRIP_TITLE_DATECATEGORIES'),
			'index.php?option=com_fixed_trip&view=datecategories',
			$vName == 'datecategories'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FIXED_TRIP_TITLE_TYPE_CATEGORIES'),
			'index.php?option=com_fixed_trip&view=type_categories',
			$vName == 'type_categories'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FIXED_TRIP_TITLE_CREATE_TRIPS'),
			'index.php?option=com_fixed_trip&view=create_trips',
			$vName == 'create_trips'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FIXED_TRIP_TITLE_CREATE_PLANNINGS'),
			'index.php?option=com_fixed_trip&view=create_plannings',
			$vName == 'create_plannings'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FIXED_TRIP_TITLE_CREATE_DAYS'),
			'index.php?option=com_fixed_trip&view=create_days',
			$vName == 'create_days'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FIXED_TRIP_TITLE_TRIPFLIGHTS'),
			'index.php?option=com_fixed_trip&view=tripflights',
			$vName == 'tripflights'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FIXED_TRIP_TITLE_PLACE_OF_DEPARTURES'),
			'index.php?option=com_fixed_trip&view=place_of_departures',
			$vName == 'place_of_departures'
		);


	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_fixed_trip';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}


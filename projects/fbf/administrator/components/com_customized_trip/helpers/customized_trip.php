<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Customized_trip
 * @author     vikram <vikram.zinavo@gmail.com>
 * @copyright  2018 vikram
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Customized_trip helper.
 *
 * @since  1.6
 */
class Customized_tripHelper
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
			JText::_('COM_CUSTOMIZED_TRIP_TITLE_CUSTOMIZED_TRIPS'),
			'index.php?option=com_customized_trip&view=customized_trips',
			$vName == 'customized_trips'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CUSTOMIZED_TRIP_TITLE_FLIGHTS'),
			'index.php?option=com_customized_trip&view=flights',
			$vName == 'flights'
		);
			JHtmlSidebar::addEntry(
			JText::_('COM_CUSTOMIZED_TRIP_TITLE_HOTELS'),
			'index.php?option=com_customized_trip&view=hotels',
			$vName == 'hotels'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CUSTOMIZED_TRIP_TITLE_TRNASPORTS'),
			'index.php?option=com_customized_trip&view=trnasports',
			$vName == 'trnasports'
		);
		JHtmlSidebar::addEntry(
			JText::_('Place of departure'),
			'index.php?option=com_customized_trip&view=places',
			$vName == 'places'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CUSTOMIZED_TRIP_TITLE_MINBUDGETS'),
			'index.php?option=com_customized_trip&view=minbudgets',
			$vName == 'minbudgets'
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

		$assetName = 'com_customized_trip';

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


<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Trips
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_trips'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Trips', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('TripsHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'trips.php');

$controller = JControllerLegacy::getInstance('Trips');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

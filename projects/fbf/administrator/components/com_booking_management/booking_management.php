<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Booking_management
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_booking_management'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Booking_management', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('Booking_managementHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'booking_management.php');

$controller = JControllerLegacy::getInstance('Booking_management');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

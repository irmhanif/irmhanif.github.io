<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Trips
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Trips', JPATH_COMPONENT);
JLoader::register('TripsController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Trips');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

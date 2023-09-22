<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Common_price_management
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Common_price_management', JPATH_COMPONENT);
JLoader::register('Common_price_managementController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Common_price_management');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

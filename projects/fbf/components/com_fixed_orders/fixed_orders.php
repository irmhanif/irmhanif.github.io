<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_orders
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2019 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Fixed_orders', JPATH_COMPONENT);
JLoader::register('Fixed_ordersController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Fixed_orders');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

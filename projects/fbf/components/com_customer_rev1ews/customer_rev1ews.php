<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Customer_rev1ews
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2019 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Customer_rev1ews', JPATH_COMPONENT);
JLoader::register('Customer_rev1ewsController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Customer_rev1ews');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Keeper_profile
 * @author     vikram <vikram.zinavo@gmail.com>
 * @copyright  2018 vikram
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Keeper_profile', JPATH_COMPONENT);
JLoader::register('Keeper_profileController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Keeper_profile');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

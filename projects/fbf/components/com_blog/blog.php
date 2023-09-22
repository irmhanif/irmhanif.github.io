<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Blog
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2018 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Blog', JPATH_COMPONENT);
JLoader::register('BlogController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Blog');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

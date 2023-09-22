<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Document
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2019 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Document', JPATH_COMPONENT);
JLoader::register('DocumentController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Document');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

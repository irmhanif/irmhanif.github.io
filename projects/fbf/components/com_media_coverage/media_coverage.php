<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Media_coverage
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2019 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Media_coverage', JPATH_COMPONENT);
JLoader::register('Media_coverageController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Media_coverage');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Media_coverage
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2019 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_media_coverage'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Media_coverage', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('Media_coverageHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'media_coverage.php');

$controller = JControllerLegacy::getInstance('Media_coverage');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

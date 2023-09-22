<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Common_price_management
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_common_price_management'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Common_price_management', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('Common_price_managementHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'common_price_management.php');

$controller = JControllerLegacy::getInstance('Common_price_management');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_orders
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2019 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_fixed_orders'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Fixed_orders', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('Fixed_ordersHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'fixed_orders.php');

$controller = JControllerLegacy::getInstance('Fixed_orders');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

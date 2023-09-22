<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Partners
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2019 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_partners'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Partners', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('PartnersHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'partners.php');

$controller = JControllerLegacy::getInstance('Partners');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

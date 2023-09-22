<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Document
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2019 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_document'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Document', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('DocumentHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'document.php');

$controller = JControllerLegacy::getInstance('Document');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.13.2.3783
 * @date        2018-01-25
 */


defined('_JEXEC') or die;

/**
 * This layout only insert javascript to close a modal windows
 */

if (empty($displayData->refreshAfter))
{
	$timeout = 1500;
}
else if ($displayData->refreshAfter == 'now')
{
	$timeout = 0;
}
else
{
	$timeout = $displayData->refreshAfter;
}

// where to send parent?
$refreshTo = empty($displayData->refreshTo) ? 'window.parent.location.href' : $displayData->refreshTo;

// modal title
$modalTitle = empty($displayData->modalTitle) ? JText::_('COM_SH404SEF_PLEASE_WAIT', true) : JText::_($displayData->modalTitle, true);

// close a modal window
if (empty($timeout))
{
	JFactory::getDocument()->addScriptDeclaration('window.parent.location.href=' . $refreshTo);
}
else if ($timeout != 'never')
{
	JFactory::getDocument()
		->addScriptDeclaration(
			'
			shlBootstrap.setModalTitleFromModal("' . $modalTitle . '");
			setTimeout( function() {
			window.parent.location.href=window.parent.location.href;
				}, ' . $timeout . ');
		');
}

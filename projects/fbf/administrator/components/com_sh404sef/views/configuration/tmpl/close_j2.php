<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * This layout only insert javascript to close a modal windows
 */

// close a modal window
JFactory::getDocument()
	->addScriptDeclaration(
		'
			setTimeout( function() {
			window.parent.location.href=window.parent.location.href;
			window.parent.SqueezeBox.close();
				}, 1500);
		');

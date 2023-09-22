<?php
/**
 * @copyright	Copyright (c) 2014 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * System - Login Popup Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	ExtStore.LoginPopup
 */
class plgSystemLoginPopup extends JPlugin {

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct(&$subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);
	}

	/**
	 * onAfterRoute hook.
	 */
	function onAfterRoute() {
		if (JFactory::getApplication()->isSite()) {
			JHtml::_('behavior.keepalive');
			JHtml::_('jquery.framework');

			JHtml::_('script', 'plg_system_loginpopup/script.js', false, true);
			JHtml::_('stylesheet', 'plg_system_loginpopup/style.css', false, true);

			$selector	= str_replace('\'', '"', $this->params->get('selector', 'a[href="#login"], a[href="#logout"]'));
			$offsetTop	= (int) $this->params->get('offset_top', 50);

			$script	= <<<SCRIPT
jQuery(document).ready(function() {
	ExtStore.LoginPopup.offset_top	= $offsetTop;
	jQuery('$selector').click(function(event) {
		ExtStore.LoginPopup.open();

		event.stopPropagation();
		event.preventDefault();
	});

	jQuery('#lp-overlay, .lp-close').click(function() {
		ExtStore.LoginPopup.close();
	});
});
SCRIPT;
			JFactory::getDocument()->addScriptDeclaration($script);
		}
	}

	/**
	 * onAfterRender hook.
	 */
	function onAfterRender() {
		$app	= JFactory::getApplication();

		if ($app->isSite()) {
			$this->loadLanguage();
			$user	= JFactory::getUser();

			if ($user->id) {
				$layout		= 'logout';
			} else {
				$layout		= 'login';
			}

			$html	= JLayoutHelper::render($layout, $this->params, dirname(__FILE__) . '/layouts');
			$body	= $app->getBody();
			$body	= preg_replace('~</body[^>]*>~', $html . '$0', $body);

			$app->setBody($body);
		}
	}
}
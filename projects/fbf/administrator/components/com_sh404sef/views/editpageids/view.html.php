<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author       Yannick Gaultier
 * @copyright    (c) Yannick Gaultier - Weeblr llc - 2018
 * @package      sh404SEF
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version      4.13.2.3783
 * @date        2018-01-25
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC'))
{
	die();
}

class Sh404sefViewEditpageids extends ShlMvcView_Base
{
	// we are in 'pageids' view
	protected $_context = 'pageids';

	public function display($tpl = null)
	{
		// get Joomla version prefix to load appropriate layout files
		$this->joomlaVersionPrefix = Sh404sefHelperGeneral::getJoomlaVersionPrefix();

		// add our own css
		$document = JFactory::getDocument();
		ShlHtml_Manager::getInstance($document)
		               ->addAssets($document)
		               ->addSpinnerAssets($document);

		// add modal css and js
		ShlHtmlBs_helper::addBootstrapCss(JFactory::getDocument());
		ShlHtmlBs_helper::addBootstrapJs(JFactory::getDocument());

		JHTML::_('behavior.tooltip');

		JHtml::styleSheet(Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/' . $this->joomlaVersionPrefix . '_list.css');
		JHtml::styleSheet(Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/' . $this->joomlaVersionPrefix . '_editurl.css');

		JHtml::script(Sh404sefHelperGeneral::getComponentUrl() . '/assets/js/shajax_modal_form.js');
		JHtml::script(Sh404sefHelperGeneral::getComponentUrl() . '/assets/js/shurls.js');

		$this->layoutRenderer = array();
		$this->layoutRenderer['custom'] = new ShlMvcLayout_File('com_sh404sef.form.fields.custom', sh404SEF_LAYOUTS);
		$this->layoutRenderer['shlegend'] = new ShlMvcLayout_File('com_sh404sef.configuration.fields.legend', sh404SEF_LAYOUTS);

		// now display normally
		parent::display($this->joomlaVersionPrefix);
	}
}

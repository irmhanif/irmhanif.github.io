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

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC'))
{
	die('Direct Access to this location is not allowed.');
}

jimport('joomla.application.component.view');

class Sh404sefViewEditnotfound extends ShlMvcView_Base
{
	// we are in 'editurl' view
	protected $_context = 'editnotfound';

	public function display($tpl = null)
	{
		// version prefix
		$this->joomlaVersionPrefix = Sh404sefHelperGeneral::getJoomlaVersionPrefix();

		$this->refreshAfter = JFactory::getApplication()->input->getCmd('refreshafter');

		// get model and update context with current
		$model = $this->getModel();
		$model->updateContext($this->_context . '.' . $this->getLayout());

		// get url id
		$notFoundUrlId = JFactory::getApplication()->input->getInt('notfound_url_id');

		// read url data from model
		$url = $model->getUrl($notFoundUrlId);

		// and push url into the template for display
		$this->url = $url;

		// add modal css and js
		ShlHtmlBs_helper::addBootstrapCss(JFactory::getDocument());
		ShlHtmlBs_helper::addBootstrapJs(JFactory::getDocument());

		// add title
		JToolbarHelper::title('sh404SEF: ' . JText::_('COM_SH404SEF_NOT_FOUND_ENTER_REDIRECT'));

		// CSS
		JHtml::styleSheet(Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/configuration.css');
		JHtml::styleSheet(Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/j3_list.css');

		// add tooltips
		// @TODO replace with a viable jQuery equivalent
		JHTML::_('behavior.tooltip');

		// insert bootstrap theme
		ShlHtml_Manager::getInstance()->addAssets(JFactory::getDocument());

		// link to  custom javascript
		JHtml::script(Sh404sefHelperGeneral::getComponentUrl() . '/assets/js/' . $this->joomlaVersionPrefix . '_edit.js');
		JHtml::script(Sh404sefHelperGeneral::getComponentUrl() . '/assets/js/shajax_modal_form.js');

		// add our own css
		JHtml::styleSheet(Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/' . $this->joomlaVersionPrefix . '_editurl.css');

		// now display normally
		parent::display($this->joomlaVersionPrefix);
	}
}

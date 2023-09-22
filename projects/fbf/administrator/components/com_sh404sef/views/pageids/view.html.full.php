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
	die('Direct Access to this location is not allowed.');
}

jimport('joomla.application.component.view');

class Sh404sefViewPageids extends ShlMvcView_Base
{
	// we are in 'urls' view
	protected $_context = 'pageids';

	public function display($tpl = null)
	{
		// version prefix
		$this->joomlaVersionPrefix = Sh404sefHelperGeneral::getJoomlaVersionPrefix();
		$this->footerText = JText::sprintf(
			'COM_SH404SEF_FOOTER_' . strtoupper(Sh404sefConfigurationEdition::$id),
			Sh404sefFactory::getConfig()->version, Sh404sefConfigurationEdition::$name, date('Y')
		);

		// get model and update context with current
		$model = ShlMvcModel_Base::getInstance('urls', 'Sh404sefModel');
		$model->setContext($this->_context . '.' . $this->getLayout());

		// display type: simple for very large sites/slow slq servers
		$config = Sh404sefFactory::getConfig();

		// if set for a slowServer, display simplified version of the url manager
		$this->slowServer = $config->slowServer;

		// store it
		$model = $this->setModel($model, true);

		// read data from model
		$list = $model
			->getList(
				(object) array(
					'layout'             => $this->getLayout(),
					'getPageId'          => true,
					'simpleUrlList'      => true,
					'slowServer'         => $config->slowServer,
					'requestedUrlFilter' => 'pageid',
					'hide404Urls'        => true,
					'include_ext_shurls' => true
				)
			);

		// and push it into the view for display
		$this->items = $list;
		$this->itemCount = count($this->items);
		$this->pagination = $model
			->getPagination(
				(object) array('layout' => $this->getLayout(), 'getPageId' => true, 'simpleUrlList' => true, 'slowServer' => $config->slowServer)
			);
		$options = $model->getDisplayOptions();
		$this->options = $options;
		$this->helpMessage = JText::_('COM_SH404SEF_PAGEID_HELP');

		// add our own css
		JHtml::styleSheet(Sh404sefHelperGeneral::getComponentUrl() . '/assets/css/' . $this->joomlaVersionPrefix . '_list.css');
		if (Sh404sefHelperHtml::setFixedTemplate())
		{
			JHtml::script(Sh404sefHelperGeneral::getComponentUrl() . '/assets/js/j3.js');
		}

		// add modal css and js
		ShlHtmlBs_helper::addBootstrapCss(JFactory::getDocument());
		ShlHtmlBs_helper::addBootstrapJs(JFactory::getDocument());

		// add display filters
		$this->_addFilters();

		// variable for modal, not used in 3..x+
		$params = array();

		// render submenu sidebar
		$this->sidebar = Sh404sefHelperHtml::renderSubmenu();

		// insert bootstrap theme
		ShlHtml_Manager::getInstance()->addAssets(JFactory::getDocument());

		// build the toolbar
		$toolbarMethod = '_makeToolbar' . ucfirst($this->getLayout() . ucfirst($this->joomlaVersionPrefix));
		if (is_callable(array($this, $toolbarMethod)))
		{
			$this->$toolbarMethod($params);
		}

		// now display normally
		parent::display($this->joomlaVersionPrefix);
	}

	/**
	 * Create toolbar for default layout view
	 *
	 * @param midxed $params
	 */
	private function _makeToolbarDefaultJ3($params = null)
	{
		// add title
		JToolbarHelper::title('sh404SEF: ' . JText::_('COM_SH404SEF_PAGEIDS_MANAGER'), 'sh404sef-toolbar-title');

		// add "New url" button
		$bar = JToolBar::getInstance('toolbar');

		// prepare configuration button
		$bar->addButtonPath(SHLIB_ROOT_PATH . 'toolbarbutton');

		// add page id
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['editurl'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-plus';
		$params['checkListSelection'] = false;
		$url = 'index.php?option=com_sh404sef&c=pageids&view=editpageids&tmpl=component';
		$bar
			->appendButton(
				'J3popuptoolbarbutton', 'new', JText::_('JTOOLBAR_NEW'), $url, $params['size']['x'], $params['size']['y'], $top = 0,
				$left = 0, $onClose = '', $title = '', $params
			);

		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['import'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-upload';
		$params['checkListSelection'] = false;
		$url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=import&opsubject=pageids';
		$bar
			->appendButton(
				'J3popuptoolbarbutton', 'import', JText::_('COM_SH404SEF_IMPORT_BUTTON'), $url, $params['size']['x'],
				$params['size']['y'], $top = 0, $left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_IMPORTING_TITLE'), $params
			);

		// add import button
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['export'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-download';
		$params['checkListSelection'] = false;
		$url = 'index.php?option=com_sh404sef&c=wizard&task=start&tmpl=component&optype=export&opsubject=pageids';
		$bar
			->appendButton(
				'J3popuptoolbarbutton', 'export', JText::_('COM_SH404SEF_EXPORT_BUTTON'), $url, $params['size']['x'],
				$params['size']['y'], $top = 0, $left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_EXPORTING_TITLE'), $params
			);

		// separator
		JToolBarHelper::spacer(20);

		// add delete button
		$params = array();
		$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['confirm'];
		$params['buttonClass'] = 'btn btn-small';
		$params['iconClass'] = 'icon-trash';
		$params['checkListSelection'] = true;
		$url = 'index.php?option=com_sh404sef&c=pageids&task=confirmdelete&tmpl=component';
		$bar
			->appendButton(
				'J3popuptoolbarbutton', 'delete', JText::_('JTOOLBAR_DELETE'), $url, $params['size']['x'], $params['size']['y'], $top = 0,
				$left = 0, $onClose = '', $title = JText::_('COM_SH404SEF_CONFIRM_TITLE'), $params
			);

		if (Sh404sefHelperAcl::userCan('sh404sef.view.configuration'))
		{
			// separator
			JToolBarHelper::spacer(20);

			// prepare configuration button
			$params = array();
			$params['class'] = 'modaltoolbar btn-success';
			$params['size'] = Sh404sefFactory::getPConfig()->windowSizes['configuration'];
			$params['buttonClass'] = 'btn-success btn btn-small modal';
			$params['iconClass'] = 'icon-options';
			$url = 'index.php?option=com_sh404sef&tmpl=component&c=configuration&view=configuration&component=com_sh404sef&hidemainmenu=1';
			$bar
				->appendButton(
					'J3popuptoolbarbutton', 'configj3', JText::_('COM_SH404SEF_CONFIGURATION'), $url, $params['size']['x'],
					$params['size']['y'], $top = 0, $left = 0, $onClose = '', $title = '', $params
				);
		}
	}

	private function _makeOptionsSelect($options)
	{
		$selects = new StdClass();

		// component list
		$current = $options->filter_component;
		$name = 'filter_component';
		$selectAllTitle = JText::_('COM_SH404SEF_ALL_COMPONENTS');
		$selects->components = Sh404sefHelperHtml::buildComponentsSelectList(
			$current, $name, $autoSubmit = true, $addSelectAll = true,
			$selectAllTitle
		);

		// language list
		$current = $options->filter_language;
		$name = 'filter_language';
		$selectAllTitle = JText::_('COM_SH404SEF_ALL_LANGUAGES');
		$selects->languages = Sh404sefHelperHtml::buildLanguagesSelectList($current, $name, $autoSubmit = true, $addSelectAll = true, $selectAllTitle);

		// select custom
		$current = $options->filter_url_type;
		$name = 'filter_url_type';
		$selectAllTitle = JText::_('COM_SH404SEF_ALL_URL_TYPES');
		$data = array(
			array('id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_CUSTOM, 'title' => JText::_('COM_SH404SEF_ONLY_CUSTOM')),
			array('id' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_AUTO, 'title' => JText::_('COM_SH404SEF_ONLY_AUTO'))
		);
		$selects->filter_url_type = Sh404sefHelperHtml::buildSelectList(
			$data, $current, $name, $autoSubmit = true, $addSelectAll = true,
			$selectAllTitle
		);

		return $selects;
	}

	private function _addFilters()
	{
		// component selector
		JHtmlSidebar::addFilter(
			JText::_('COM_SH404SEF_ALL_COMPONENTS'), 'filter_component',
			JHtml::_('select.options', Sh404sefHelperGeneral::getComponentsList(), 'element', 'name', $this->options->filter_component, true)
		);

		// language list
		JHtmlSidebar::addFilter(
			JText::_('COM_SH404SEF_ALL_LANGUAGES'), 'filter_language',
			JHtml::_(
				'select.options', JHtml::_('contentlanguage.existing', $all = false, $translate = true), 'value', 'text',
				$this->options->filter_language, false
			)
		);

		// select custom
		$data = array(
			array('value' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_CUSTOM, 'text' => JText::_('COM_SH404SEF_ONLY_CUSTOM')),
			array('value' => Sh404sefHelperGeneral::COM_SH404SEF_ONLY_AUTO, 'text' => JText::_('COM_SH404SEF_ONLY_AUTO'))
		);
		JHtmlSidebar::addFilter(
			JText::_('COM_SH404SEF_ALL_URL_TYPES'), 'filter_url_type',
			JHtml::_('select.options', $data, 'value', 'text', $this->options->filter_url_type, true)
		);

		// Select Requested/not Requested/ Requested or not
		$data = array(
			array('value' => Sh404sefHelperGeneral::SHOW_REQUESTED, 'text' => JText::_('COM_SH404SEF_SHOW_REQUESTED_URLS')),
			array('value' => Sh404sefHelperGeneral::SHOW_NOT_REQUESTED, 'text' => JText::_('COM_SH404SEF_SHOW_NEVER_REQUESTED_URLS'))
		);
		JHtmlSidebar::addFilter(
			JText::_('COM_SH404SEF_SHOW_REQUESTED_OR_NOT'), 'filter_requested_urls',
			JHtml::_('select.options', $data, 'value', 'text', $this->options->filter_requested_urls, true)
		);
	}
}

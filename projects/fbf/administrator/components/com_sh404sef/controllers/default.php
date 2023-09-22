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
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

jimport('joomla.application.component.controller');

Class Sh404sefControllerDefault extends Sh404sefClassBasecontroller
{

	protected $_context = 'com_sh404sef.dashboard';

	/**
	 * Display the view
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Set the default view name in case it's missing
		$this->_setDefaults();

		// then display normally
		parent::display($cachable, $urlparams);
	}

	/**
	 * Browse through security log files
	 * and update statistics, stored in
	 * general config file for quick access
	 */
	public function updatesecstats()
	{
		// Set the default view name in case it's missing
		$this->_setDefaults();

		Sh404sefHelperSecurity::updateSecStats();

		parent::display();
	}

	/**
	 * Update statistics, based on data stored in
	 * general config file for quick access
	 */
	public function showsecstats()
	{
		// Set the default view name in case it's missing
		$this->_setDefaults();

		parent::display();
	}

	/**
	 * Show updates information, w/o actually
	 * checking for updates
	 */
	public function showupdates()
	{
		// Set the default view name in case it's missing
		$this->_setDefaults();

		parent::display();
	}

	public function info()
	{
		// Set the default view name in case it's missing
		$this->_setDefaults();

		// set the layout for info display
		JFactory::getApplication()->input->set('layout', 'info');

		// default display
		parent::display();
	}

	public function updateMessageCenter()
	{
		// get currently store
		try
		{
			if (!JSession::checkToken())
			{
				throw new Exception('Invalid token.');
			}
			$messageList = ShlMsg_Manager::getInstance()->get(array('scope' => 'com_sh404sef', 'acknowledged' => false));
			$renderedMessages = ShlMvcLayout_Helper::render('shlib.msg.list', array('msgs' => $messageList, 'id' => 'com_sh404sef-cp-msg-container'), SHLIB_LAYOUTS_PATH);

			$response = array(
				'success' => true,
				'html'    => $renderedMessages,
				'message' => '',
				'hash' => md5($renderedMessages)
			);
		}
		catch (Exception $e)
		{
			$response = array(
				'success' => false,
				'html'    => '',
				'message' => $e->getMessage()
			);
		}

		echo json_encode($response);

		return;
	}

	private function _setDefaults()
	{
		$app = JFactory::getApplication();

		$viewName = $app->input->getWord('view');
		if (empty($viewName))
		{
			$app->input->set('view', 'default');
		}
		$layout = $app->input->getWord('layout');
		if (empty($layout))
		{
			$app->set('layout', 'default');
		}
	}
}

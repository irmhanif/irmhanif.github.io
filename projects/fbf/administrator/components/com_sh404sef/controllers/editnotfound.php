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

Class Sh404sefControllerEditnotfound extends Sh404sefClassBaseeditcontroller
{

	protected $_context        = 'com_sh404sef.editnotfound';
	protected $_editController = 'editnotfound';
	protected $_editView       = 'editnotfound';
	protected $_editLayout     = 'default';
	protected $_defaultModel   = 'editnotfound';
	protected $_defaultView    = 'editnotfound';

	protected $_returnController = 'urls';
	protected $_returnTask       = '';
	protected $_returnView       = 'default';
	protected $_returnLayout     = 'view404';

	/**
	 * Handle creating a redirect from the 404 requests
	 * manager.
	 */
	public function newredirect()
	{
		// find and store edited item id . should be 0, as this is a new url
		$app = JFactory::getApplication();
		$cid = $app->input->getArray(array('cid' => 'int'));
		$cid = wbArrayGet($cid, 'cid', array());
		$this->_id = wbArrayGet($cid, 0);

		// need to get the view to push the url data into it
		$viewName = $app->input->getWord('view');
		if (empty($viewName))
		{
			$app->set('view', $this->_defaultView);
		}

		$document = JFactory::getDocument();

		$viewType = $document->getType();
		$viewName = $app->input->getCmd('view');
		$this->_editView = $viewName;
		$view = $this->getView($viewName, $viewType, '', array('base_path' => $this->basePath));

		// Call the base controller to do the rest
		$this->display();
	}

	public function save()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$app = JFactory::getApplication();

		// save incoming data
		$this->_editData = $app->input->post->getArray();

		// find and store edited item id
		$this->_id = $app->input->getInt('id');

		// perform saving of incoming data
		$savedId = $this->_doSave($this->_editData);

		if (empty($savedId))
		{
			$response = array(
				'status'  => false,
				'message' => JText::sprintf('JERROR_SAVE_FAILED', $this->getError()),
			);
			ShlSystem_Http::render(
				200,
				json_encode(
					$response
				),
				'application/json'
			);
		}

		$response = array(
			'status' => true,
		);
		$response['message'] = JText::_('COM_SH404SEF_ELEMENT_SAVED');
		ShlSystem_Http::render(
			200,
			json_encode(
				$response
			),
			'application/json'
		);

		return true;
	}
}

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

Class Sh404sefControllerEditurl extends Sh404sefClassBaseeditcontroller
{

	protected $_context        = 'com_sh404sef.editurl';
	protected $_editController = 'editurl';
	protected $_editView       = 'editurl';
	protected $_editLayout     = 'default';
	protected $_defaultModel   = 'editurl';
	protected $_defaultView    = 'editurl';

	protected $_returnController = 'urls';
	protected $_returnTask       = '';
	protected $_returnView       = 'urls';
	protected $_returnLayout     = 'default';

	public function save()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$input = JFactory::getApplication()->input;

		// save incoming data
		$this->_editData = $input->post->getArray();

		// find and store edited item id
		$this->_id = $input->getInt('id');

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

	/**
	 * Redirect to a confirmation page showing in
	 * a popup window
	 */
	public function confirmdelete($deleteDuplicates = false)
	{
		// find and store edited item id
		$app = JFactory::getApplication();
		$cid = $app->input->getArray(array('cid' => 'int'));
		$cid = wbArrayGet($cid, 'cid', array());

		// Set the view name and create the view object
		$viewName = 'confirm';
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewLayout = $app->input->getCmd('layout', $this->_defaultLayout);

		$view = $this->getView($viewName, $viewType, '', array('base_path' => $this->basePath));

		// push url id(s) into the view
		$view->cid = $cid;

		// tell it what to display
		$view->mainText = JText::sprintf('COM_SH404SEF_CONFIRM_URL_DELETION', count($cid));

		// and who's gonna handle the request
		$view->actionController = $this->_editController;

		// Get/Create the model
		if ($model = $this->getModel($this->_defaultModel, 'Sh404sefModel'))
		{
			// store initial context in model
			$model->setContext($this->_context);

			// Push the model into the view (as default)
			$view->setModel($model, true);

			// check if delete duplicates requested
			$view->task = $deleteDuplicates ? 'confirmeddeldup' : 'delete';
		}

		// Set the layout
		$view->setLayout($viewLayout);

		// Display the view
		$view->display();
	}

	/**
	 * GO to confirmation of url and duplicates deletion
	 */
	public function confirmdeletedeldup()
	{
		$this->confirmdelete($deleteDuplicates = true);
	}

	/**
	 * 404 urls deletion is same as regular urls
	 */
	public function confirmdelete404()
	{
		$this->confirmdelete();
	}

	public function confirmed($deleteDuplicates = false)
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		// find and store edited item id
		$app = JFactory::getApplication();
		$cid = $app->input->getArray(array('cid' => 'int'));
		$cid = wbArrayGet($cid, 'cid', array());

		// check invalid data
		if (!is_array($cid) || count($cid) < 1 || $cid[0] == 0)
		{
			$this->setRedirect($this->_getDefaultRedirect(), JText::_('COM_SH404SEF_SELECT_ONE_URL'));
		}

		// now perform url deletion
		// get the model to do it, actually
		// Get/Create the model
		if ($model = $this->getModel($this->_defaultModel, 'Sh404sefModel'))
		{
			// store initial context in model
			$model->setContext($this->_context);

			// call the delete method on our list
			if ($deleteDuplicates)
			{
				$model->deleteByIdsWithDuplicates($cid);
			}
			else
			{
				$model->deleteByIds($cid);
			}

			// check errors and enqueue them for display if any
			$errors = $model->getErrors();
			if (!empty($errors))
			{
				$this->enqueuemessages($errors, 'error');
			}
		}

		// V3: we redirect to the close page, as ajax is not used anymore to save
		$failure = array(
			'url'     => 'index.php?option=com_sh404sef&tmpl=component&c=editurl&view=editurl&layout=refresh&refreshafter=8000',
			'message' => $model->getError()
		);
		$success = array(
			'url'     => 'index.php?option=com_sh404sef&tmpl=component&c=editurl&view=editurl&layout=refresh',
			'message' => JText::_('COM_SH404SEF_ELEMENT_DELETED')
		);
		if (!empty($errors))
		{
			// Save failed, go back to the screen and display a notice.
			$this->setRedirect(JRoute::_($failure['url'], false), $failure['message'], 'error');
			return false;
		}

		$this->setRedirect(JRoute::_($success['url'], false), $success['message'], 'message');
		return true;
	}

	public function confirmeddeldup()
	{
		$this->confirmed($deleteDuplicates = true);
	}

	/**
	 * Hook for the "confirmed" task, until our
	 * confirm view is a bit more flexible
	 */
	public function delete()
	{
		$this->confirmed();
	}

}

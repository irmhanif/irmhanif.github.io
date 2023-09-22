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

Class Sh404sefControllerDuplicates extends Sh404sefClassBasecontroller
{
	protected $_context           = 'com_sh404sef.duplicates';
	protected $_defaultModel      = 'duplicates';
	protected $_defaultView       = 'duplicates';
	protected $_defaultController = 'duplicates';
	protected $_defaultTask       = '';
	protected $_defaultLayout     = 'default';

	protected $_returnController = 'urls';
	protected $_returnTask       = '';
	protected $_returnView       = 'urls';
	protected $_returnLayout     = 'default';

	/**
	 * Redirect to a confirmation page showing in
	 * a popup window
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$app = JFactory::getApplication();

		// find and store edited item id
		$cid = $app->input->getArray(array('cid' => 'int'));
		$cid = wbArrayGet($cid, 'cid', array());

		// Set the view name and create the view object
		$viewName = 'duplicates';
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewLayout = $app->input->getCmd('layout', $this->_defaultLayout);

		$view = $this->getView($viewName, $viewType, '', array('base_path' => $this->basePath));

		// Get/Create the model
		if ($model = $this->getModel('duplicates', 'Sh404sefModel'))
		{
			// store initial context in model
			$model->setContext($this->_context);

			// store the sef url id
			$model->setState('sefId', wbArrayGet($cid, 0));

			// Push the model into the view (as default)
			$view->setModel($model, true);
		}

		// Set the layout
		$view->setLayout($viewLayout);

		// Display the view
		$view->display();
	}

	public function makemainurl()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		$app = JFactory::getApplication();

		// find and store edited item id
		$cid = $app->input->getArray(array('cid' => 'int'));
		$cid = wbArrayGet($cid, 'cid', array());

		// check invalid data
		if (!is_array($cid) || count($cid) != 1 || intval($cid[0]) == 0)
		{
			$redirect = array('c' => "duplicates", 'tmpl' => 'component', 'cid[]' => $app->input->getInt('mainurl_id'));
			$this->setRedirect($this->_getDefaultRedirect($redirect), JText::_('COM_SH404SEF_SELECT_ONE_URL'), 'error');

			// send back response through default view
			$this->display();
		}

		// now make that url the main url
		// while also setting the previous
		// with this url current rank
		// get the model to do it, actually
		// Get/Create the model
		if ($model = $this->getModel($this->_defaultModel, 'Sh404sefModel'))
		{
			// store initial context in model
			$model->setContext($this->_context);

			// call the delete method on our list
			$model->makeMainUrl(intval(wbArrayGet($cid, 0)));

			// check errors and enqueue them for display if any
			$errors = $model->getErrors();

			// V3: we redirect to the close page, as ajax is not used anymore to save
			$failure = array(
				'url'     => 'index.php?option=com_sh404sef&c=duplicates&view=duplicates&tmpl=component',
				'message' => JText::sprintf('JERROR_SAVE_FAILED', $this->getError())
			);
			$success = array(
				'url'     => 'index.php?option=com_sh404sef&tmpl=component&c=duplicates&view=duplicates&layout=refresh',
				'message' => JText::_('COM_SH404SEF_ELEMENT_SAVED')
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

		// send back response through default view
		$this->display();
	}
}

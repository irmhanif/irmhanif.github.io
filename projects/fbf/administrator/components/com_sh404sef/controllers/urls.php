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

Class Sh404sefControllerUrls extends Sh404sefClassBasecontroller
{
	protected $_context           = 'com_sh404sef.urls';
	protected $_defaultModel      = 'urls';
	protected $_defaultView       = 'urls';
	protected $_defaultController = 'urls';
	protected $_defaultTask       = '';
	protected $_defaultLayout     = 'default';

	protected $_returnController = 'urls';
	protected $_returnTask       = '';
	protected $_returnView       = 'urls';
	protected $_returnLayout     = 'default';

	/**
	 * Handles confirmation for "Purge urls" action
	 *
	 */
	public function confirmpurge()
	{
		// use actual method shared with "purge selected" feature
		$this->_doConfirmPurge('auto');
	}

	/**
	 * Handles confirmation for "Purge selected urls" action
	 *
	 */
	public function confirmpurgeselected()
	{
		// use actual method shared with "purge" feature
		$this->_doConfirmPurge('selected');
	}

	/**
	 * Handles confirmation for "Purge urls" action
	 *
	 */
	public function confirmpurge404()
	{
		// use actual method shared with "purge selected" feature
		$this->_doConfirmPurge('404');
	}

	/**
	 * Hook for the "confirmed" task, until our
	 * confirm view is a bit more flexible
	 */
	public function delete()
	{
		$this->confirmed();
	}

	/**
	 * Handles actions confirmed through the confirmation box
	 */
	public function confirmed()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit('Invalid Token');

		// collect type of purge to make
		$type = JFactory::getApplication()->input->getCmd('delete_type');

		switch ($type)
		{
			case 'auto':
				break;
			case 'selected':
				break;
			case '404':
				break;
			default:
				$this->setError('Invalid data');
				$this->display();
				break;
		}

		// now perform url deletion
		// get the model to do it, actually
		// Get/Create the model
		$error = '';
		if ($model = $this->getModel($this->_defaultModel, 'Sh404sefModel'))
		{
			// store initial context in model
			$model->setContext('com_sh404sef.urls.urls.default');

			// call the delete method on our list
			$model->purge($type);

			// check errors and enqueue them for display if any
			$error = $model->getError();
			if (!empty($error))
			{
				$this->setError($error);
			}
		}

		// V3: we redirect to the close page, as ajax is not used anymore to save
		$failure = array('url' => 'index.php?option=com_sh404sef&c=urls&view=confirm&layout=refresh&refreshafter=8000&tmpl=component', 'message' => $error);
		$success = array(
			'url'     => 'index.php?option=com_sh404sef&c=urls&view=confirm&layout=refresh&tmpl=component',
			'message' => JText::_('COM_SH404SEF_SUCCESSPURGE')
		);
		if (!empty($error))
		{
			// Save failed, go back to the screen and display a notice.
			$this->setRedirect(JRoute::_($failure['url'], false), $failure['message'], 'error');
			return false;
		}

		$this->setRedirect(JRoute::_($success['url'], false), $success['message'], 'message');
		return true;
	}

	/**
	 * Redirect to a confirmation page showing in
	 * a popup window
	 */
	private function _doConfirmPurge($type = 'auto')
	{
		// Set the view name and create the view object
		$viewName = 'confirm';
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewLayout = JFactory::getApplication()->input->getCmd('layout', $this->_defaultLayout);

		$view = $this->getView($viewName, $viewType, '', array('base_path' => $this->basePath));

		// and who's gonna handle the request
		$view->actionController = $this->_defaultController;

		// Get/Create the model
		if ($model = $this->getModel($this->_defaultModel, 'Sh404sefModel'))
		{
			// store context of the main url view in the model
			$model->setContext('com_sh404sef.urls.urls.default');

			// Push the model into the view (as default)
			$view->setModel($model, true);
		}

		// tell it what to display
		// we only purge automatic sef urls, count that
		$numberOfUrls = $model->getUrlsCount($type);

		// if nothing to do, say so and return to main page
		if (empty($numberOfUrls))
		{
			// don't forget to delete url cache, just in case
			Sh404sefHelperCache::purge();

			// then do redirect
			$view->redirectTo = $this->_getDefaultRedirect();
			$view->message = JText::_('COM_SH404SEF_NORECORDS');
		}
		else
		{
			// calculate the message and some hidden data to be passed
			// through the confirmation box
			switch ($type)
			{
				case 'selected':
					$mainText = JText::sprintf('COM_SH404SEF_CONFIRM_PURGE_URLS_SELECTED', $numberOfUrls);
					break;
				case '404':
					$mainText = JText::sprintf('COM_SH404SEF_CONFIRM_PURGE_URLS_404', $numberOfUrls);
					break;
				case 'auto':
					$mainText = JText::sprintf('COM_SH404SEF_CONFIRM_PURGE_URLS', $numberOfUrls);
				default:
					break;
			}

			$hiddenText = '<input type="hidden" name="delete_type" value="' . $type . '" />';

			// push that into the view
			$view->mainText = $mainText;
			$view->hiddenText = $hiddenText;
		}
		// Set the layout
		$view->setLayout($viewLayout);

		// Display the view
		$view->display();
	}
}

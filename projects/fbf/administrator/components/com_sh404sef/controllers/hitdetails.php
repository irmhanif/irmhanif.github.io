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

Class Sh404sefControllerHitdetails extends Sh404sefClassBasecontroller
{
	protected $_context           = 'com_sh404sef.hitdetails';
	protected $_defaultModel      = 'hitdetails';
	protected $_defaultView       = 'hitdetails';
	protected $_defaultController = 'hitdetails';
	protected $_defaultTask       = '';
	protected $_defaultLayout     = 'default';

	protected $_returnController = 'urls';
	protected $_returnTask       = '';
	protected $_returnView       = 'urls';
	protected $_returnLayout     = 'view404';

	public function display($cachable = false, $urlparams = false)
	{
		$this->_context .= '.' . JFactory::getApplication()->input->get('request_type');
		return parent::display($cachable, $urlparams);
	}

	// @TODO: implement display() to set return view and layout based on request type

	public function purgedetails()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// collect input data : which url needs to be redirected ?
		$app = JFactory::getApplication();
		$urlId = $app->input->getInt('url_id');
		$requestType = $app->input->getCmd('request_type');

		// get model and ask it to do the job
		$model = $this->getModel($this->_defaultModel);
		$model->purgeDetails($urlId, $requestType);

		// check errors
		$error = $model->getError();
		if (!empty($error))
		{
			$this->setError($error);
		}

		if (version_compare(JVERSION, '3.0', 'ge'))
		{
			// V3: we redirect to the close page, as ajax is not used anymore to save
			$failure = array('url'     => 'index.php?option=com_sh404sef&c=hitdetails&view=hitdetails&tmpl=component',
			                 'message' => $error);
			$success = array('url'     => 'index.php?option=com_sh404sef&c=hitdetails&view=hitdetails&tmpl=component&layout=refresh',
			                 'message' => JText::sprintf('COM_SH404SEF_HIT_DETAILS_PURGE_SUCCESS', $model->getUrl($urlId)->requested_url));
			if (!empty($error))
			{
				// Save failed, go back to the screen and display a notice.
				$this->setRedirect(JRoute::_($failure['url'], false), $failure['message'], 'error');
				return false;
			}

			$this->setRedirect(JRoute::_($success['url'], false), $success['message'], 'message');
			return true;
		}
		else
		{
			// standard display
			$this->display();
		}
	}
}

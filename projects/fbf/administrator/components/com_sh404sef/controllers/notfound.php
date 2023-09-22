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

Class Sh404sefControllerNotfound extends Sh404sefClassBasecontroller
{
	protected $_context           = 'com_sh404sef.notfound';
	protected $_defaultModel      = 'notfound';
	protected $_defaultView       = 'notfound';
	protected $_defaultController = 'notfound';
	protected $_defaultTask       = '';
	protected $_defaultLayout     = 'default';

	protected $_returnController = 'urls';
	protected $_returnTask       = '';
	protected $_returnView       = 'urls';
	protected $_returnLayout     = 'view404';

	public function selectnfredirect()
	{
		$app = JFactory::getApplication();

		// collect input data : which url needs to be redirected ?
		$notFoundUrlId = $app->input->getInt('notfound_url_id');

		// which URL to redirect to?
		$cid = $app->input->getArray(array('cid' => 'int'));
		$cid = wbArrayGet($cid, 'cid', array());

		if (count($cid) > 1)
		{
			// more than one target url selected, display error
			$this->setError(JText::_('COM_SH404SEF_SELECT_ONLY_ONE_URL_TO_REDIRECT'));
			$this->display();
			return;
		}
		// only one url, use it
		$targetUrlId = $cid[0];
		if (empty($targetUrlId))
		{
			// bad url, probably not an integer was passed
			$this->setError(JText::_('COM_SH404SEF_INVALID_REDIRECT_TARGET_ID'));
			$this->display();
			return;
		}

		// get model and ask it to do the job
		$model = $this->getModel($this->_defaultModel);
		$model->redirectNotFoundUrl($notFoundUrlId, $targetUrlId);

		// check errors
		$error = $model->getError();
		if (!empty($error))
		{
			$this->setError($error);
		}

		// V3: we redirect to the close page, as ajax is not used anymore to save
		$failure = array(
			'url'     => 'index.php?option=com_sh404sef&c=notfound&view=notfound&tmpl=component',
			'message' => $error
		);
		$success = array(
			'url'     => 'index.php?option=com_sh404sef&c=notfound&view=notfound&tmpl=component&layout=refresh',
			'message' => JText::_('COM_SH404SEF_ELEMENT_SAVED')
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
}

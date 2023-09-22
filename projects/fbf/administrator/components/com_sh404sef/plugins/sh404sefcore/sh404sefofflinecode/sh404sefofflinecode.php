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

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

$app = JFactory::getApplication();
if (!$app->isAdmin())
{
	$app->registerEvent('onAfterRoute', 'plgSh404sefofflinecode');
}

/**
 * Output a correct response code when site is offline
 * to let know search engines that site data
 * should not be discarded or discounted
 */
function plgSh404sefofflinecode()
{
	$app = JFactory::getApplication();

	// are we in the backend, or not offline ?
	if (!defined('SH404SEF_IS_RUNNING') || $app->isAdmin() || !$app->getCfg('offline'))
	{
		return;
	}

	// get plugin params
	$plugin = JPluginHelper::getPlugin('sh404sefcore', 'sh404sefofflinecode');
	$pluginParams = new JRegistry;
	$pluginParams->loadString($plugin->params);

	$disallowAdminAccess = $pluginParams->get('disallowAdminAccess', 0);

	if (!$disallowAdminAccess)
	{
		// admins are allowed, lets check if current user
		// is an admin, or if user is trying to log in
		$user = JFactory::getUser();
		$option = $app->input->getCmd('option');
		$task = $app->input->getCmd('task');
		if (!empty($user->id))
		{
			$loggingIn = true;
		}
		else if ($option == 'com_users' && $task == 'user.login')
		{
			// Check for request forgeries
			JSession::checkToken() or jexit('Invalid Token');
			$loggingIn = true;
		}
		// provide bypass for Akeeba, to allow backup while in offline mode
		// not as secure, but I surrender
		else if ($option == 'com_akeeba')
		{
			$loggingIn = true;
		}
		else
		{
			$loggingIn = false;
		}

		// if already logged inadmin, or admin logging in, let it go
		if ($loggingIn)
		{
			return true;
		}
	}

	// need to render offline screen
	$document = JFactory::getDocument();
	if ($disallowAdminAccess)
	{
		// admins not allowed, use our own
		// simplified template. Most likely being hacked so
		// close doors as much as possible
		$directory = JPATH_ROOT . '/plugins/sh404sefcore/sh404sefofflinecode/layouts';
		$data = ShlMvcLayout_Helper::render(
			'sh404sefofflinecode.offline_template',
			array(
				'direction' => $document->getDirection(),
				'language' => $document->getLanguage()
			),
			$directory
		);
	}
	else
	{
		// admin can access, use Joomla! offline template,
		// that includes a login form
		$template = $app->getTemplate();
		$file = 'offline.php';
		$directory = JPATH_THEMES;
		$params = array('template' => $template, 'file' => $file, 'directory' => $directory);
		$data = $document->render($app->getCfg('caching'), $params);
	}

	// header : service unavailable
	JResponse::setHeader('HTTP/1.0 503', true);

	// give it some time
	$retryAfter = $pluginParams->get('retry_after_delay', 7400);

	// set header
	Jresponse::setheader('Retry-After', gmdate('D, d M Y H:i:s', time() + $retryAfter) . ' GMT');

	// echo document
	JResponse::setBody($data);
	echo JResponse::toString($app->getCfg('gzip'));

	// and terminate
	$app->close();
}

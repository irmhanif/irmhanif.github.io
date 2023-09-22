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

defined('_JEXEC') or die;

/**
 * This layout displays message or error, insde a bootstrap alert box
 */

if (!empty($displayData->message))
{
	if (is_array($displayData->message))
	{
		foreach ($displayData->message as $message)
		{
			echo ShlHtmlBs_Helper::alert($message, $type = 'success', empty($displayData->doNotDismissMessage) ? true : false);
		}
	}
	else
	{
		echo ShlHtmlBs_Helper::alert($displayData->message, $type = 'success', empty($displayData->doNotDismissMessage) ? true : false);
	}
}
if (method_exists($displayData, 'getError'))
{
	$error = $displayData->getError();
	if (!empty($error))
	{
		echo ShlHtmlBs_Helper::alert($error, $type = 'error', empty($displayData->doNotDismissMessage) ? true : false);
	}
}

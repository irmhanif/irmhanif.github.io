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

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = &Sh404sefFactory::getConfig();
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin($lang, $shLangName, $shLangIso, $option);
if ($dosef == false)
{
	return;
}
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - adjust as needed ----------------------------------------
$shLangIso = shLoadPluginLanguage('com_comprofiler', $shLangIso, '_SH404SEF_CB_VIEW_USER_DETAILS');
// ------------------  load language file - adjust as needed ----------------------------------------

if (!function_exists('shIsCB2'))
{
	function shIsCB2()
	{

		static $isCB2 = null;

		if (is_null($isCB2))
		{
			// Load the local XML file first to get the local version
			$xmlFile = JPATH_ROOT . '/administrator/components/com_comprofiler/comprofiler.xml';
			$xml = ShlSystem_Xml::fromFile($xmlFile);
			$version = (string) $xml->version;
			$isCB2 = version_compare($version, '2', 'ge');
		}

		return $isCB2;
	}
}

shRemoveFromGETVarsList('option');
if (!empty($lang))
{
	shRemoveFromGETVarsList('lang');
}
if (!empty($limit))
{
	shRemoveFromGETVarsList('limit');
}
if (isset($limitstart))
{
	shRemoveFromGETVarsList('limitstart');
}

$task = isset($task) ? $task : null;
if (shIsCB2())
{
	$task = isset($task) || !isset($view) ? $task : $view;
	if (isset($task) && isset($view))
	{
		shRemoveFromGETVarsList('view');
	}
}
$Itemid = isset($Itemid) ? $Itemid : null;

// insert comp name from user input in backend
$shCBName = shGetComponentPrefix($option);
$shCBName = empty($shCBName) ? getMenuTitle($option, $task, $Itemid, null, $shLangName) : $shCBName;
$shCBName = (empty($shCBName) || $shCBName == '/') ? 'CB' : $shCBName; // V 1.2.4.t

// do something about that Itemid thing  V 1.2.4.m
if (!preg_match('/Itemid=[0-9]+/iu', $string))
{ // if no Itemid in non-sef URL
	//if (eregi('Itemid=[0-9]+', $string) === false) { // if no Itemid in non-sef URL
	if ($sefConfig->shInsertGlobalItemidIfNone && !empty($shCurrentItemid))
	{
		$string .= '&Itemid=' . $shCurrentItemid;  // append current Itemid
		$Itemid = $shCurrentItemid;
		shAddToGETVarsList('Itemid', $Itemid);
	}
	if ($sefConfig->shInsertTitleIfNoItemid)
	{
		$title[] = $shCBName;
		// prevent from adding another time
		$sefConfig->shInsertCBName = false;
	}
	$shItemidString = '';
	if ($sefConfig->shAlwaysInsertItemid && (!empty($Itemid) || !empty($shCurrentItemid)))
	{
		$shItemidString = JText::_('COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX') . $sefConfig->replacement
			. (empty($Itemid) ? $shCurrentItemid : $Itemid);
	}
}
else
{  // if Itemid in non-sef URL
	$shItemidString = $sefConfig->shAlwaysInsertItemid ?
		JText::_('COM_SH404SEF_ALWAYS_INSERT_ITEMID_PREFIX') . $sefConfig->replacement . $Itemid
		: '';
	if ($sefConfig->shAlwaysInsertMenuTitle)
	{
		//global $Itemid; V 1.2.4.g we want the string option, not current page !
		$title[] = $shCBName;
		// prevent from adding another time
		$sefConfig->shInsertCBName = false;
	}
}

if (!empty($Itemid))
{
	shRemoveFromGETVarsList('Itemid');
}

$task = isset($task) ? @$task : null;

switch (strtolower($task))
{
	case 'userdetails':
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		}
		$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_VIEW_USER_DETAILS'];
		// add user name to URL if requested to do so. User id is in $user
		if (!empty($user) && $sefConfig->shCBInsertUserName)
		{

			try
			{
				$result = ShlDbHelper::selectResult(
					'#__users'
					, array(($sefConfig->shCBUseUserPseudo ? 'user' : '') . 'name')
					, array('id' => $user)
				);
			}
			catch (Exception $e)
			{
				ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
			}

			$title[] = empty($result) ?  // no name available
				$sh_LANG[$shLangIso]['_SH404SEF_CB_USER'] . $sefConfig->replacement . $user // put ID
				: ($sefConfig->shCBInsertUserId ? $user . $sefConfig->replacement . $result : $result); // if name, put ID only if requested
			shRemoveFromGETVarsList('user');
		}
		shRemoveFromGETVarsList('task');
		break;
	case 'userslist':
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		}
		$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_VIEW_USERS_LIST'];
		// manage listid
		if (!empty($listid))
		{

			try
			{
				$result = ShlDbHelper::selectObject(
					'#__comprofiler_lists'
					, array('listid', 'title')
					, array('listid' => $listid)
				);
			}
			catch (Exception $e)
			{
				ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
			}

			$title[] = empty($result) ?  // no name available
				$sh_LANG[$shLangIso]['_SH404SEF_CB_LIST'] . $sefConfig->replacement . $listid // put ID
				: $result->title; // if name, put ID only if requested
			shRemoveFromGETVarsList('listid');
		}
		shRemoveFromGETVarsList('task');
		if (isset($searchmode) && empty($searchmode))
		{
			shRemoveFromGETVarsList('searchmode');
		}
		break;
	case 'reportuser':
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		}
		$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_REPORT_USER'];
		// add user name if set to do so / user id is in $uid
		if ($sefConfig->shCBInsertUserName)
		{

			try
			{
				$result = ShlDbHelper::selectResult(
					'#__users'
					, array(($sefConfig->shCBUseUserPseudo ? 'user' : '') . 'name')
					, array('id' => $uid)
				);
			}
			catch (Exception $e)
			{
				ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
			}

			$title[] = empty($result) ?  // no name available
				$sh_LANG[$shLangIso]['_SH404SEF_CB_USER'] . $sefConfig->replacement . $uid // put ID
				: ($sefConfig->shCBInsertUserId ? $uid . $sefConfig->replacement . $result : $result); // if name, put ID only if requested
			shRemoveFromGETVarsList('uid');
		}
		shRemoveFromGETVarsList('task');
		break;
	case 'banprofile' :
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		}
		switch ($act)
		{
			case 0:
				$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_USER_UNBAN'];
				shRemoveFromGETVarsList('act');
				shRemoveFromGETVarsList('task');
				break;
			case 1:
				$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_USER_BAN'];
				shRemoveFromGETVarsList('act');
				shRemoveFromGETVarsList('task');
				break;
			case 2:
				$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_USER_BAN_REQUEST'];
				shRemoveFromGETVarsList('act');
				shRemoveFromGETVarsList('task');
				break;
		}
		// add user name if set to do so / user id is in $uid
		if ($sefConfig->shCBInsertUserName)
		{

			try
			{
				$result = ShlDbHelper::selectResult(
					'#__users'
					, array(($sefConfig->shCBUseUserPseudo ? 'user' : '') . 'name')
					, array('id' => $uid)
				);
			}
			catch (Exception $e)
			{
				ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
			}

			$title[] = empty($result) ?  // no name available
				$sh_LANG[$shLangIso]['_SH404SEF_CB_USER'] . $sefConfig->replacement . $uid // put ID
				: ($sefConfig->shCBInsertUserId ? $uid . $sefConfig->replacement . $result : $result); // if name, put ID only if requested
			shRemoveFromGETVarsList('uid');
		}
		break;
	case 'confirm':
		$dosef = false;
		break;
	case 'logout':
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		}
		if (!empty($sh_LANG[$shLangIso]['_SH404SEF_CB_REGISTRATION']))
		{
			$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_REGISTRATION'];
		}
		$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_LOGOUT'];
		shRemoveFromGETVarsList('task');
		break;
	case 'userprofile':
		if ($sefConfig->shCBShortUserURL)
		{
			if (!empty($user))
			{
				try
				{
					$result = ShlDbHelper::selectResult(
						'#__users'
						, array(($sefConfig->shCBUseUserPseudo ? 'user' : '') . 'name')
						, array('id' => $user)
					);
				}
				catch (Exception $e)
				{
					ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
				}
			}

			$title[] = empty($result) ?  // no name available
				$sh_LANG[$shLangIso]['_SH404SEF_CB_USER'] . (empty($user) ? '' : $sefConfig->replacement . $user) : $result;
			$title[] = '/';
			shRemoveFromGETVarsList('user');
		}
		else
		{
			if ($sefConfig->shInsertCBName)
			{
				$title[] = $shCBName;
			}
			$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_VIEW_USER_PROFILE'];
			// add user name to URL if requested to do so. User id is in $user
			if ($sefConfig->shCBInsertUserName && !empty($user))
			{  // V 1.2.4.r

				try
				{
					$result = ShlDbHelper::selectResult(
						'#__users'
						, array(($sefConfig->shCBUseUserPseudo ? 'user' : '') . 'name')
						, array('id' => $user)
					);
				}
				catch (Exception $e)
				{
					ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
				}

				$title[] = empty($result) ?  // no name available
					$sh_LANG[$shLangIso]['_SH404SEF_CB_USER'] . $sefConfig->replacement . $user // put ID
					: ($sefConfig->shCBInsertUserId ? $user . $sefConfig->replacement . $result : $result); // if name, put ID only if requested
				shRemoveFromGETVarsList('user');
			}
		}
		shRemoveFromGETVarsList('task');
		break;
	case 'manageconnections':
		$dosef = false;
		break;
	case 'login':
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		}
		if (!empty($sh_LANG[$shLangIso]['_SH404SEF_CB_REGISTRATION']))
		{
			$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_REGISTRATION'];
		}
		$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_LOGIN'];
		shRemoveFromGETVarsList('task');
		break;
	case 'lostpassword':
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		}
		// optional first part of URL, to be set in language file
		if (!empty($sh_LANG[$shLangIso]['_SH404SEF_CB_REGISTRATION']))
		{
			$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_REGISTRATION'];
		}
		$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_LOST_PASSWORD'];
		shRemoveFromGETVarsList('task');
		break;
	case 'registers':
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		}
		// optional first part of URL, to be set in language file
		if (!empty($sh_LANG[$shLangIso]['_SH404SEF_CB_REGISTRATION']))
		{
			$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_REGISTRATION'];
		}
		$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_REGISTER'];
		shRemoveFromGETVarsList('task');
		break;
	case 'moderatebans':
		$dosef = false;
		break;
	case 'moderatereports':
		$dosef = false;
		break;
	case 'moderateimages':
		$dosef = false;
		break;
	case 'pendingapprovaluser':
		$dosef = false;
		break;
	case 'useravatar':
		$do = isset($do) ? @$do : null;
		switch (strtolower($do))
		{
			case 'deleteavatar':
				if ($sefConfig->shInsertCBName)
				{
					$title[] = $shCBName;
				}
				$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_DELETE_AVATAR'];
				shRemoveFromGETVarsList('do');
				shRemoveFromGETVarsList('task');
				break;
			default:
				if ($sefConfig->shInsertCBName)
				{
					$title[] = $shCBName;
				}
				$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_MANAGE_AVATAR'];
				shRemoveFromGETVarsList('task');
				break;
		}
		break;
	case 'emailuser':
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		}
		$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_EMAIL_USER'];
		// add user name if set to do so / user id is in $uid
		if ($sefConfig->shCBInsertUserName)
		{

			try
			{
				$result = ShlDbHelper::selectResult(
					'#__users'
					, array(($sefConfig->shCBUseUserPseudo ? 'user' : '') . 'name')
					, array('id' => $uid)
				);
			}
			catch (Exception $e)
			{
				ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
			}

			$title[] = empty($result) ?  // no name available
				$sh_LANG[$shLangIso]['_SH404SEF_CB_USER'] . $sefConfig->replacement . $uid // put ID
				: ($sefConfig->shCBInsertUserId ? $uid . $sefConfig->replacement . $result : $result); // if name, put ID only if requested
			shRemoveFromGETVarsList('uid');
		}
		shRemoveFromGETVarsList('task');
		break;
	case 'teamcredits':
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		}
		$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_TEAM_CREDITS'];
		shRemoveFromGETVarsList('task');
		break;
	case '':
		if ($sefConfig->shInsertCBName)
		{
			$title[] = $shCBName;
		} // V 1.2.4.t
		$title[] = $sh_LANG[$shLangIso]['_SH404SEF_CB_MAIN_PAGE'];
		shRemoveFromGETVarsList('task');
		break;
	default:
		$dosef = false;
		break;
}

// V 1.2.4.s : fix for CB not passing $limit value in some URL : breaks pagination
if (isset($limitstart) && empty($limit))
{
	if (shIsCB2() && !empty($listid))
	{
		try
		{
			$result = ShlDbHelper::selectResult(
				'#__comprofiler_lists'
				, array('params')
				, array('listid' => $listid)
			);
			if (!empty($result))
			{
				$_params = json_decode($result);
				$limit = isset($_params->list_limit) ? $_params->list_limit : $JFactory::getApplication()->getCfg('list_limit', 10);;
			}
		}
		catch (Exception $e)
		{
			ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
		}
	}
	else
	{
		if (empty($ueConfig))
		{
			$sh_CB_joomla_adminpath = sh404SEF_ABS_PATH . 'administrator';
			$sh_CB_adminpath = $sh_CB_joomla_adminpath . '/components/com_comprofiler';
			include($sh_CB_adminpath . "/ue_config.php");
		}
		$limit = $ueConfig['num_per_page'];
	}

	shAddToGETVarsList('limit', $limit);
	shRemoveFromGETVarsList('limit');
}

// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef)
{
	$string = shFinalizePlugin(
		$string, $title, $shAppendString, $shItemidString,
		(isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
		(isset($shLangName) ? @$shLangName : null)
	);
}
// ------------------  standard plugin finalize function - don't change ---------------------------


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

define('sh404SEF_DEBUG_HONEY_POT', false);

function shDoSecurityChecks($query = '', $fullCheck = true)
{
	$sefConfig = Sh404sefFactory::getConfig();

	if (!$sefConfig->shSecEnableSecurity)
	{
		return '';
	}

	$shQuery = empty($query) ? (empty($_SERVER['QUERY_STRING']) ? '' : $_SERVER['QUERY_STRING']) : $query;

	// IP checks
	$ip = ShlSystem_Http::getVisitorIpAddress();
	$uAgent = empty($_SERVER['HTTP_USER_AGENT']) ? '' : $_SERVER['HTTP_USER_AGENT'];

	// ip White/Black listing
	$shWhiteListedIp = shCheckIPList($ip, $sefConfig->ipWhiteList);
	if (!$shWhiteListedIp)
	{
		if (shCheckIPList($ip, $sefConfig->ipBlackList))
		{
			shDoRestrictedAccess('Blacklisted IP');
		}
	}

	// UserAgent White/Black listing
	$whiteListedUAgent = shCheckUAgentList($uAgent, $sefConfig->uAgentWhiteList);
	if (!$whiteListedUAgent)
	{
		if (shCheckUAgentList($uAgent, $sefConfig->uAgentBlackList))
		{
			shDoRestrictedAccess('Blacklisted user agent');
		}
	}

	if (!$shWhiteListedIp && !$whiteListedUAgent && $fullCheck)
	{
		shDoAntiFloodCheck($ip);
	}

	// url content checks
	$halt = 0;
	while (true)
	{
		// allow for multiple url decode
		$last = $shQuery;
		$shQuery = urldecode($shQuery);

		// do our tests
		$shQuery = str_replace('&amp;', '&', $shQuery);

		// bad content in query string
		$c = shCheckConfigVars($shQuery);
		if ($c)
		{
			shDoRestrictedAccess($c . ' in URL');
		}
		$c = shCheckBase64($shQuery);
		if ($c)
		{
			shDoRestrictedAccess($c . ' in URL');
		}
		$c = shCheckScripts($shQuery);
		if ($c)
		{
			shDoRestrictedAccess($c . ' in URL');
		}
		$c = shCheckStandardVars($_GET);
		if ($c)
		{
			shDoRestrictedAccess($c . ' in URL');
		}
		$c = shCheckImgTxtCmd($shQuery); // V x
		if ($c)
		{
			shDoRestrictedAccess($c . ' in URL');
		}

		// Check whether the last decode is equal to the previous one
		if ($shQuery == $last)
		{
			// Break out of the while if the URI is stable.
			break;
		}
		else
		{
			if (++$halt > 10)
			{
				// Runaway check. URI has been seriously compromised.
				shDoRestrictedAccess('Multiple level of url encode');
			}
		}
	}

	if (!$fullCheck)
	{
		return;
	}
	// don't check POST and/or Honey pot if second check

	// check POST variables
	if ($sefConfig->shSecCheckPOSTData)
	{
		$c = shCheckStandardVars($_POST);
		if ($c)
		{
			shDoRestrictedAccess($c . ' in POST');
		}
		foreach ($_POST as $key => $value)
		{
			if (!is_array($value))
			{
				shDoPOSTCheck($key, $value);
			}
			else
			{
				foreach ($value as $subKey => $subValue)
				{
					if (!is_array($subValue))
					{
						shDoPOSTCheck($subKey, $subValue);
					}
				}
			}
		}
	}

	// do Project Honey Pot check
	if (!$shWhiteListedIp && $sefConfig->shSecCheckHoneyPot)
	{
		shDoHoneyPotCheck($ip);
	}
}

function shDoPOSTCheck($key, $value)
{
	$c = shCheckConfigVars($key . '=' . $value);
	if ($c)
	{
		shDoRestrictedAccess($c . ' in POST');
	}
	$c = shCheckBase64($key . '=' . $value);
	if ($c)
	{
		shDoRestrictedAccess($c . ' in POST');
	}
	$c = shCheckScripts($key . '=' . $value);
	if ($c)
	{
		shDoRestrictedAccess($c . ' in POST');
	}
	$c = shCheckImgTxtCmd($key . '=' . $value); // V x
	if ($c)
	{
		shDoRestrictedAccess($c . ' in POST');
	}
}

function shSendEmailToAdmin($logData)
{
	if (!sh404SEF_SEC_MAIL_ATTACKS_TO_ADMIN)
	{
		return;
	}
	$mainframe = JFactory::getApplication();

	$subject = str_replace('%sh404SEF_404_SITE_NAME%', $mainframe->getCfg('sitename'), sh404SEF_SEC_EMAIL_TO_ADMIN_SUBJECT);

	$logText = '';
	foreach ($logData as $key => $text)
	{
		$logText .= "\n" . $key . "\t\t" . ' :: ' . shSecOutput(JString::trim($text));
	}
	$body = str_replace('%sh404SEF_404_SITE_URL%', Sh404sefFactory::getPageInfo()->getDefaultFrontLiveSite(), sh404SEF_SEC_EMAIL_TO_ADMIN_BODY);
	$body = str_replace('%sh404SEF_404_ATTACK_DETAILS%', $logText, $body);
	if (!defined('_ISO'))
	{
		define('_ISO', 'charset=iso-8859-1');
	}
	jimport('joomla.mail.mail');
	JMail::sendMail($mainframe->getCfg('mailfrom'), $mainframe->getCfg('fromname'), $mainframe->getCfg('mailfrom'), $subject, $body);
}

function shLogToSecFile($logData)
{
	$shNum = 12 * (intval(date('Y')) - 2000) + intval(date('m')); // number current month
	$fileName = 'sh404sef/sec/log_' . date('Y') . '-' . date('m') . '-' . 'sh404SEF_security_log' . '.' . $shNum . '.log.php';
	$options = array('text_entry_format' => "{DATE}\t{TIME}\t{CAUSE}\t{C-IP}\t{USER}\t{USER_AGENT}\t{REQUEST_METHOD}\t{REQUEST_URI}\t{COMMENT}",
	                 'text_file'         => $fileName);

	jimport('joomla.error.log');
	JLog::addLogger($options, JLog::INFO, array('sh404sef_sec'));

	$entry = new JLogEntry('');
	foreach ($logData as $key => $value)
	{
		$entry->$key = $value;
	}
	$entry->category = 'sh404sef_sec';
	// and add it
	JLog::add($entry, JLog::INFO, 'sh404sef_sec');
}

function shCleanUpSecLogFiles()
{ // delete security log files older than param

	$sefConfig = Sh404sefFactory::getConfig();
	if (mt_rand(1, SH404SEF_PAGES_TO_CLEAN_LOGS) != 1)
	{
		return;
	}
	// probability = 1/SH404SEF_PAGES_TO_CLEAN_LOGS
	$curMonth = 12 * (intval(date('Y')) - 2000) + intval(date('m'));
	if ($sefConfig->shSecLogAttacks)
	{
		if ($handle = @opendir(JPATH_ROOT . '/logs/sh404sef/sec'))
		{
			while (false !== ($file = readdir($handle)))
			{
				$matches = array();
				if ($file != '.' && $file != '..' && preg_match('/\.[0-9]*\./', $file, $matches))
				{
					$fileNum = JString::trim($matches[0], '.');
					if ($curMonth - $fileNum > $sefConfig->monthsToKeepLogs)
					{
						@unlink(JPATH_ROOT . '/logs/sh404sef/sec/' . $file);
						ShlSystem_Log::debug('sh404sef', 'Erasing security log file : ' . $file);
					}
				}
			}
			closedir($handle);
		}
	}
}

function shDoRestrictedAccess($causeText, $comment = '', $displayEntrance = false)
{
	$sefConfig = Sh404sefFactory::getConfig();

	if ($sefConfig->shSecLogAttacks)
	{ // log what's happening
		$logData = array();
		$logData['DATE'] = ShlSystem_Date::getSiteNow('Y-m-d');
		$logData['TIME'] = ShlSystem_Date::getSiteNow('H:i:s');
		$logData['CAUSE'] = shSecOutput($causeText);
		$logData['C-IP'] = empty($_SERVER['REMOTE_ADDR']) ? '-' : $_SERVER['REMOTE_ADDR'];
		if ($_SERVER['REMOTE_ADDR'] != 'localhost' && $_SERVER['REMOTE_ADDR'] != '::1')
		{
			$name = getHostByAddr($_SERVER['REMOTE_ADDR']);
		}
		else
		{
			$name = '-';
		}
		$logData['NAME'] = $name;
		$logData['USER_AGENT'] = empty($_SERVER['HTTP_USER_AGENT']) ? '-' : $_SERVER['HTTP_USER_AGENT'];
		$logData['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];
		$logData['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
		$logData['COMMENT'] = $comment;

		shLogToSecFile($logData);

		// V x : we can possibly send email to site admin, but not log
		shSendEmailToAdmin($logData);
	}

	// actually restrict access
	if (!headers_sent())
	{
		header('HTTP/1.0 403 FORBIDDEN');
	}
	echo '<h1>Forbidden access</h1>';
	if ($displayEntrance)
	{
		?>
		<script type="text/javascript">
			function setcookie(name, value, expires, path, domain, secure) {
				// set time in milliseconds
				var today = new Date();
				today.setTime(today.getTime());

				if (expires) {
					expires = expires * 1000 * 60 * 60 * 24;
				}
				var expires_date = new Date(today.getTime() + (expires));

				document.cookie = name + "=" + escape(value) +
					( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
					( ( path ) ? ";path=" + path : "" ) +
					( ( domain ) ? ";domain=" + domain : "" ) +
					( ( secure ) ? ";secure" : "" );
			}
			function letmein() {
				setcookie('sh404SEF_user_click_notabot', 'true', 1, '/', '', '');
				location.reload(true);
			}
		</script>
		<?php echo $sefConfig->shSecEntranceText; ?>
		<a href="javascript:letmein()">&gt;&gt;&gt;&gt;&gt;&gt;</a>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<p>
			<font size="2" color="grey"><?php echo $sefConfig->shSecSmellyPotText; ?><a
					href="http://planetozh.com/smelly.php">&gt;&gt;</a> </font>
		</p>
		<?php
	}
	else
	{
		echo '<p><font size="2" color="grey">(' . $causeText . ')</font></p>';
	}
	JFactory::getApplication()->close(403);
}

function shCheckConfigVars($query)
{
	if (empty($query))
	{
		return '';
	}
	if (preg_match('/mosConfig_[a-zA-Z_]{1,21}=/iu', $query))
	{
		return 'mosConfig_var';
	}
	else
	{
		return '';
	}
}

function shCheckBase64($query)
{
	if (empty($query))
	{
		return '';
	}
	if (preg_match('/base64_encode.*\(.*\)/iu', $query))
	{
		return 'Base 64 encoded data';
	}
	else
	{
		return '';
	}
}

function shCheckScripts($query)
{
	if (empty($query))
	{
		return '';
	}
	if (preg_match('/(\<).*script[^A-Za-z0-9]*(\>)/iu', $query))
	{
		return '<script> tag';
	}
	else
	{
		return;
	}
}

function shCheckImgTxtCmd($query)
{
	if (empty($query))
	{
		return '';
	}
	$badCmds = array('gif\?cmd', 'gif&cmd', 'jpg\?cmd', 'jpg&cmd', 'txt\?cmd', 'txt&cmd', 'txt\?');
	foreach ($badCmds as $badCmd)
	{
		if (preg_match('/' . $badCmd . '/iu', $query))
		{
			return 'Image file name with command';
		}
	}
	return;
}

function shCheckStandardVars($_ARRAY)
{
	$sefConfig = Sh404sefFactory::getConfig();

	foreach ($_ARRAY as $k => $v)
	{
		$k = str_replace('amp;', '', $k); // if &amp;XXX is passed, then $_GET will have amp;XXX as a key !
		if (in_array($k, $sefConfig->shSecOnlyNumVars))
		{
			if (!empty($v) && !is_numeric($v))
			{
				return 'Var not numeric: ' . $k;
			}
		}
		if (in_array(strToLower($k), $sefConfig->shSecAlphaNumVars))
		{
			if (preg_match('/[^._a-zA-Z0-9]/iu', $v))
			{
				return 'Var not alpha-numeric: ' . $k;
			}
		}
		if (in_array(strToLower($k), $sefConfig->shSecNoProtocolVars))
		{
			// attempt to pass some URL
			if (preg_match('#(http|https|ftp):\/\/#isu', $v))
			{
				return 'Var contains outbound link: ' . $k;
			}
		}
	}
	return '';
}

function shCheckIpRange($ip, $ipExp)
{
	if (empty($ip) || empty($ipExp))
	{
		return false;
	}
	$exp = '/^' . str_replace('\*', '[0-9]{1,3}', preg_quote($ipExp)) . '/'; // allow * wild card
	return preg_match($exp, $ip);
}

function shCheckIPList($ip, $ipList)
{
	if (empty($ip) || empty($ipList))
	{
		return false;
	}
	foreach ($ipList as $ipInList)
	{
		if (shCheckIpRange($ip, $ipInList))
		{
			return true;
		}
	}
	return false;
}

function shCheckUAgentList($uAgent, $uAgentList)
{
	if (empty($uAgent) || empty($uAgentList))
	{
		return false;
	}
	return in_array($uAgent, $uAgentList);
}

/* ADAPTED FROM
 Script Name: Simple PHP http:BL implementation
Script URI: http://planetozh.com/blog/my-projects/honey-pot-httpbl-simple-php-script/
Description: Simple script to check an IP against Project Honey Pot's database and let only legitimate users access your script
Author: Ozh
Version: 1.0
Author URI: http://planetozh.com/
 */

function shDoHoneyPotCheck($ip)
{
	$sefConfig = Sh404sefFactory::getConfig();
	if (empty($_COOKIE['sh404SEF_user_click_notabot']) && empty($_COOKIE['sh404SEF_auto_notabot']))
	{
		sh_ozh_httpbl_check($ip);
	}
	else
	{
		if ($sefConfig->shSecLogAttacks // log what's happening
			&& !empty($_COOKIE['sh404SEF_user_click_notabot'])
		)
		{
			$logData = array();
			$logData['DATE'] = ShlSystem_Date::getSiteNow('Y-m-d');
			$logData['TIME'] = ShlSystem_Date::getSiteNow('H:i:s');
			$logData['CAUSE'] = 'Honey Pot but user clicked';
			$logData['C-IP'] = ShlSystem_Http::getVisitorIpAddress();
			if ($_SERVER['REMOTE_ADDR'] != 'localhost' && $_SERVER['REMOTE_ADDR'] != '::1')
			{
				$name = getHostByAddr($_SERVER['REMOTE_ADDR']) . '-';
			}
			else
			{
				$name = '-';
			}
			$logData['NAME'] = $name;
			$logData['USER_AGENT'] = empty($_SERVER['HTTP_USER_AGENT']) ? '-' : $_SERVER['HTTP_USER_AGENT'];
			$logData['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];
			$logData['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
			$logData['COMMENT'] = '';

			shLogToSecFile($logData);
		}
	}
}

function sh_ozh_httpbl_check($ip)
{
	$sefConfig = Sh404sefFactory::getConfig();
	//$ip='203.144.160.250';  // bad address
	//$ip = '84.103.202.172';     // good address
	// build the lookup DNS query
	// Example : for '127.9.1.2' you should query 'abcdefghijkl.2.1.9.127.dnsbl.httpbl.org'
	$lookup = $sefConfig->shSecHoneyPotKey . '.' . implode('.', array_reverse(explode('.', $ip))) . '.dnsbl.httpbl.org';
	// check query response
	$result = explode('.', gethostbyname($lookup));
	if ($result[0] == 127)
	{
		// query successful !
		$activity = $result[1];
		$threat = $result[2];
		$type = $result[3];
		$typemeaning = '';
		if ($type == 0)
		{
			$typemeaning .= 'Search Engine, ';
		}
		if ($type & 1)
		{
			$typemeaning .= 'Suspicious, ';
		}
		if ($type & 2)
		{
			$typemeaning .= 'Harvester, ';
		}
		if ($type & 4)
		{
			$typemeaning .= 'Comment Spammer, ';
		}
		$typemeaning = JString::trim($typemeaning, ', ');

		//echo "$type : $typemeaning of level $threat <br />";
		$block = false;

		// Now determine some blocking policy
		if (($type >= 4 && $threat > 0) // Comment spammer with any threat level
			|| ($type < 4 && $threat > 20) // Other types, with threat level greater than 20
		)
		{
			$block = true;
		}

		if ($block)
		{
			shDoRestrictedAccess('Caught by Honey Pot Project',
				'Type = ' . $type . ' | Threat= ' . $threat . ' | Act.= ' . $activity . ' | ' . $typemeaning, true);
			JFactory::getApplication()->close(403);
		}
		else
		{ // always set cookie to save time at next visit
			setCookie('sh404SEF_auto_notabot', 'OK', time() + 86400, '/');
		}
	}
	// debug info
	if (sh404SEF_DEBUG_HONEY_POT)
	{
		$logData = array();
		$logData['DATE'] = ShlSystem_Date::getSiteNow('Y-m-d');
		$logData['TIME'] = ShlSystem_Date::getSiteNow('H:i:s');
		$logData['CAUSE'] = 'Debug: project Honey Pot response';
		$logData['C-IP'] = ShlSystem_Http::getVisitorIpAddress();
		if ($_SERVER['REMOTE_ADDR'] != 'localhost' && $_SERVER['REMOTE_ADDR'] != '::1')
		{
			$name = getHostByAddr($_SERVER['REMOTE_ADDR']) . '-';
		}
		else
		{
			$name = '-';
		}
		$logData['NAME'] = $name;
		$logData['USER_AGENT'] = empty($_SERVER['HTTP_USER_AGENT']) ? '-' : $_SERVER['HTTP_USER_AGENT'];
		$logData['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];
		$logData['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
		$logData['COMMENT'] = 'PHP query result = ' . $result[0];;

		shLogToSecFile($logData);
	}
}

function shDoAntiFloodCheck($ip)
{
	$sefConfig = Sh404sefFactory::getConfig();

	if (!$sefConfig->shSecActivateAntiFlood || empty($sefConfig->shSecAntiFloodPeriod) || ($sefConfig->shSecAntiFloodOnlyOnPOST && empty($_POST))
		|| empty($sefConfig->shSecAntiFloodCount) || empty($ip)
	)
	{
		return;
	}

	// disable for requests coming from same site, including ajax calls
	// coming from jomsocial
	// activate if using JomSocial on your site, removing the /* and */ marks surrounding the next few lines
	/*
	
	$referrer =  empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
	if (!empty($referrer) && strpos( $referrer, Sh404sefFactory::getPageInfo()->getDefaultFrontLiveSite()) === 0) {
	if (!empty($_POST['option']) && $_POST['option'] == 'community'
	    && !empty( $_POST['task']) && $_POST['task'] == 'azrul_ajax') {
	return;
	}
	}
	
	 */

	// end of Jomsocial specific code

	$nextId = 1;
	$cTime = time();
	$count = 0;
	$floodData = shReadFile(sh404SEF_ADMIN_ABS_PATH . 'security/sh404SEF_AntiFlood_Data.dat');
	if (!empty($floodData))
	{
		// find next id
		$lastRec = $floodData[count($floodData) - 1];
		$lastRecId = explode(',', $lastRec);
		if (!empty($lastRecId))
		{
			$nextId = intval($lastRecId[0]) + 1;
		}
		// trim flood data : remove lines older than set time limit
		foreach ($floodData as $data)
		{
			$rec = explode(', ', $data);
			if (empty($rec[2]) || ($cTime - intVal($rec[2]) > $sefConfig->shSecAntiFloodPeriod))
			{
				unset($floodData[$count]);
			}
			$count++;
		}
		$floodData = array_filter($floodData);
	}
	// we have only requests made in the last $sefConfig->shSecAntiFloodPeriod seconds left in $floodArray
	$count = 0;
	if (!empty($floodData))
	{
		foreach ($floodData as $data)
		{
			$rec = explode(',', $data);
			if (!empty($rec[1]) && JString::trim($rec[1]) == $ip)
			{
				$count++;
			}
		}
	}
	// log current request
	$floodData[] = $nextId . ', ' . $ip . ', ' . $cTime;
	// write to file;
	$saveData = implode("\n", $floodData);
	shSaveFile(sh404SEF_ADMIN_ABS_PATH . 'security/sh404SEF_AntiFlood_Data.dat', $saveData);

	if ($count >= $sefConfig->shSecAntiFloodCount)
	{
		shDoRestrictedAccess('Flooding',
			$count . ' requests in less than ' . $sefConfig->shSecAntiFloodPeriod . ' seconds (max = ' . $sefConfig->shSecAntiFloodCount . ')');
	}
}

function shSecOutput($string)
{

	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

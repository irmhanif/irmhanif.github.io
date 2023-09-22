<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.13.2.3783
 * @date		2018-01-25
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
 * sh404SEF system plugin
 *
 * @author
 */
class plgSystemShmobile extends JPlugin
{
	/**
	 * Checks whether a request is coming from mobile device
	 *
	 * @return boolean true if current page request is from a known mobile device
	 */
	static public function isMobileRequest()
	{
		// get joomla application object
		$app = JFactory::getApplication();

		// check shLib is available
		if (!defined('SHLIB_VERSION'))
		{
			if ($app->isSite())
			{
				$app
					->enqueuemessage(
						' <br />sh404SEF requires the shLib system plugin to be enabled, but you appear to have disabled it. Please enable it again!',
						'error');
			}
			return false;
		}

		static $isMobile = null;
		static $defaultRecords = array(
			array('start' => 0, 'stop' => 0,
				'string' => '/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile|o2|opera m(ob|in)i|palm( os)?|p(ixi|re)\/|plucker|pocket|psp|smartphone|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce; (iemobile|ppc)|xiino/i'),
			array('start' => 0, 'stop' => 4,
				'string' => '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i'));

		// look first for a query var
		if (is_null($isMobile))
		{
			$queryVar = $app->input->getString('sh404sef_override_mobile_detection', '', 'GET');
			switch ($queryVar)
			{
				case 'force_desktop':
				case 'force_mobile':
					$isMobile = $queryVar == 'force_mobile';
					break;
			}
		}

		if (!is_null($isMobile))
		{
			// if we already have a decision, that was because of a request var:

			// 1 - set a cookie, so that decision is maintained
			setCookie('sh404sef_override_mobile_detection', $isMobile ? 'force_mobile' : 'force_desktop', time() + 7 * 86400, '/');

			// 2 - add a canonical tag to the page, to avoid search engines penalties
			global $shCanonicalTag;
			$pageInfo = sh404sefFactory::getPageInfo();
			$shCanonicalTag = $pageInfo->currentSefUrl;
			$shCanonicalTag = Sh404sefHelperUrl::clearUrlVar($shCanonicalTag, 'sh404sef_override_mobile_detection');
		}

		// then look for a cookie
		if (is_null($isMobile))
		{

			// search Joomla! cookie vars
			$cookieFlag = $app->input->getString('sh404sef_override_mobile_detection', null, 'cookie');
			switch ($cookieFlag)
			{
				case 'force_desktop':
				case 'force_mobile':
					$isMobile = $cookieFlag == 'force_mobile';
					break;
			}
		}

		// look for a mobile search engine crawler
		if (is_null($isMobile))
		{
			// now auto-detect
			jimport('joomla.environment.browser');
			$browser = JBrowser::getInstance();
			$userAgent = strtolower($browser->getAgentString());
			if (!empty($userAgent))
			{
				$searchEnginesMobileAgents = array('Googlebot-Mobile');
				$remoteConfig = Sh404sefHelperUpdates::getRemoteConfig($forced = false);
				$remotes = empty($remoteConfig->config['searchenginesmobileagents']) ? array() : $remoteConfig->config['searchenginesmobileagents'];
				$agents = array_unique(array_merge($searchEnginesMobileAgents, $remotes));
				// adjust to Google mobile new user agent string for mobiles
				// http://googlewebmastercentral.blogspot.fr/2014/01/a-new-googlebot-user-agent-for-crawling.html
				if (strpos($userAgent, 'googlebot') !== false && strpos($userAgent, 'mobile') !== false)
				{
					$isMobile = true;
				}
				else
				{
					foreach ($agents as $agent)
					{
						if (strpos($userAgent, strtolower($agent)) !== false)
						{
							$isMobile = true;
							break;
						}
					}
				}
			}
		}

		if (is_null($isMobile))
		{
			// now auto-detect
			jimport('joomla.environment.browser');
			$browser = JBrowser::getInstance();
			$isMobile = $browser->isMobile();
			$userAgent = strtolower($browser->getAgentString());
			// detection code adapted from http://detectmobilebrowser.com/
			$remoteConfig = Sh404sefHelperUpdates::getRemoteConfig($forced = false);
			$remotesRecords = empty($remoteConfig->config['mobiledetectionstrings']) ? array() : $remoteConfig->config['mobiledetectionstrings'];
			$records = empty($remotes) ? $defaultRecords : $remotesRecords;
			foreach ($records as $record)
			{
				$isMobile = $isMobile
					|| (empty($record['stop']) ? preg_match($record['string'], substr($userAgent, $record['start']))
						: preg_match($record['string'], substr($userAgent, $record['start'], $record['stop'])));
			}

		}

		// tell page information object about this
		if ($isMobile)
		{
			Sh404sefFactory::getPageInfo()->isMobileRequest = $isMobile;
		}

		return $isMobile;
	}

	public function onAfterRoute()
	{
		// get joomla application object
		$app = JFactory::getApplication();

		// check shLib is available
		if (!defined('SHLIB_VERSION'))
		{
			return;
		}

		if ($app->isAdmin())
		{
			return;
		}

		$enabled = $this->params->get('mobile_switch_enabled', 0);

		// check for mobile user
		if ($enabled)
		{
			// Issue a Vary HTTP header, to tell crawlers, cache and proxies
			// that content is changing based on user agent
			JResponse::setHeader('Vary', 'User-Agent');

			// switch to another template if request is from a mobile device
			$isMobile = self::isMobileRequest();
			if ($isMobile)
			{
				$template = $this->params->get('mobile_template', '');
				$this->_setTemplate($template);
			}
		}

	}

	protected function _setTemplate($tpl = null)
	{
		if (empty($tpl))
		{
			return;
		}
		else
		{
			$app = JFactory::getApplication();
			$app->setTemplate($tpl);
			if (!defined('SHMOBILE_MOBILE_TEMPLATE_SWITCHED'))
			{
				define('SHMOBILE_MOBILE_TEMPLATE_SWITCHED', 1);
			}
		}

	}

}

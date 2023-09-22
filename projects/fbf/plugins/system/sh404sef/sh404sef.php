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

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * sh404SEF system plugin
 *
 * @author
 */
class plgSystemSh404sef extends JPlugin
{
	static $_template = '';

	public function onAfterInitialise()
	{
		// prevent warning on php5.3+
		$this->_fixTimeWarning();

		// get joomla application object
		$app = JFactory::getApplication();

		// check shLib is available
		if (!defined('SHLIB_VERSION'))
		{
			$msg = 'sh404SEF requires the shLib system plugin to be enabled, but you appear to have disabled it. Please enable it again!';
			if ($app->isAdmin())
			{

				$app->enqueuemessage($msg, 'error');
			}
			return;
		}

		// register our autoloader
		$this->_registerAutoloader();
		if (!defined('SH404SEF_AUTOLOADER_LOADED'))
		{
			$msg = 'sh404SEF autoloader failed to initialize, sh404SEF cannot start.';
			if ($app->isAdmin())
			{
				$app->enqueuemessage($msg, 'error');
			}
			ShlSystem_Log::error('sh404sef', $msg);
			return;
		}

		// init hooks
		ShlHook::load('', 'sh404sef_functions.php');

		// create the unique page info object, and initialize it
		$pageInfo = Sh404sefFactory::getPageInfo();
		$pageInfo->init();

		// base class
		$baseClassFile = JPATH_ADMINISTRATOR . '/components/com_sh404sef/sh404sef.class.php';
		if (file_exists($baseClassFile))
		{
			include_once($baseClassFile);
		}
		else
		{
			$msg = 'sh404SEF base class file is missing or unreadable: ' . $baseClassFile . ', sh404SEF cannot start.';
			if ($app->isAdmin())
			{
				$app->enqueueMessage($msg, 'error');
			}
			ShlSystem_Log::error('sh404sef', $msg);
			return;
		}

		// define a default path for loading layouts
		ShlMvcLayout_Helper::$defaultBasePath = sh404SEF_LAYOUTS;

		// get our configuration
		$sefConfig = &Sh404sefFactory::getConfig();

		// hook for a few SEO hacks
		if ($sefConfig->Enabled && $app->isSite())
		{
			$this->_hacks();
		}

		// security layer
		$secLayerFile = JPATH_ROOT . '/components/com_sh404sef/shSec.php';
		if (!$app->isAdmin() && $sefConfig->shSecEnableSecurity && shFileExists($secLayerFile))
		{
			include_once($secLayerFile);

			// do security checks
			shDoSecurityChecks();
			shCleanUpSecLogFiles(); // see setting in class file for clean up frequency
		}
		else
		{
			if ($sefConfig->shSecEnableSecurity && !shFileExists($secLayerFile))
			{
				$msg = 'sh404SEF security layer file is missing or unreadable: ' . $secLayerFile . ', sh404SEF security feature will not operate properly.';
				if ($app->isAdmin())
				{
					$app->enqueueMessage($msg);
				}
				ShlSystem_Log::error('sh404sef', $msg);
				return;
			}
		}

		// optionnally collect page creation time
		if (!$app->isAdmin() && $sefConfig->analyticsEnableTimeCollection)
		{
			jimport('joomla.error.profiler');
			// creating the profiler object will start the counter
			$profiler = JProfiler::getInstance('sh404sef_profiler');
		}

		// load plugins, as per configuration
		$this->_loadPlugins($type = 'sh404sefcore');

		// load extension plugins, created by others
		$this->_loadPlugins($type = 'sh404sefextplugins');

		// hook to be able to install other SEF extension plugins
		//Sh404sefHelperExtplugins::loadInstallAdapters();

		// another hook to allow other SEF extensions language file to be loaded
		Sh404sefHelperExtplugins::loadLanguageFiles();

		if (!$sefConfig->Enabled)
		{
			// go away if not enabled
			return;
		}

		if (!defined('SH404SEF_IS_RUNNING'))
		{
			DEFINE('SH404SEF_IS_RUNNING', 1);
		}

		if (!$app->isAdmin())
		{
			// setup our JPagination replacement, so as to bring
			// back # of items per page in the url, in order
			// to properly calculate pagination
			// will only work if php > 5, so test for that
			if (version_compare(phpversion(), '5.0') >= 0)
			{
				// this register the old file, but do not load it if PHP5
				// will prevent further calls to the same jimport()
				// to actually do anything, because the 'joomla.html.pagination' key
				// is now registered statically in Jloader::import()
				jimport('joomla.html.pagination');
				// now we can register our own path
				JLoader::register('JPagination', JPATH_ADMINISTRATOR . '/components/com_sh404sef/pagination.php');
			}

			// attach parse and build rules to Joomla router
			$joomlaRouter = $app->getRouter();
			$pageInfo->router = new Sh404sefClassRouter();
			if (version_compare(JVERSION, '3.4', 'ge'))
			{
				$joomlaRouter->attachParseRule(array($pageInfo->router, 'preprocessParseRule'), JRouter::PROCESS_BEFORE);
			}
			$joomlaRouter->attachParseRule(array($pageInfo->router, 'parseRule'));
			$joomlaRouter->attachBuildRule(array($pageInfo->router, 'buildRule'));

			// pretend SEF is on, mostly for Joomla SEF plugin to work
			// as it checks directly 'sef' value in config, instead of
			// using $router->getMode()
			JFactory::$config->set('sef', 1);

			// perform startup operations, such as detecting request caracteristics
			// and checking redirections
			$uri = JURI::getInstance();
			$pageInfo->router->startup($uri);
		}
	}

	public function onAfterRoute()
	{
		if (defined('SH404SEF_IS_RUNNING'))
		{
			// set template, to perform alternate template output, if set to
			$app = JFactory::getApplication();
			if (!$app->isAdmin())
			{
				$this->_setAlternateTemplate();
			}
		}
	}

	public function onAfterDispatch()
	{
		if (defined('SH404SEF_IS_RUNNING'))
		{
			$app = JFactory::getApplication();

			if (!$app->isAdmin())
			{
				// reset alternate template
				$this->_resetAlternateTemplate();

				// create shurl on the fly for this page
				// if not already done
				if (Sh404sefConfigurationEdition::$id == 'full' && JFactory::getDocument()->getType() == 'html')
				{
					// shortlinks
					Sh404sefHelperShurl::updateShurls();
				}

				// insert (some) meta data
				if (JFactory::getDocument()->getType() == 'html' && Sh404sefFactory::getConfig()->shMetaManagementActivated)
				{
					Sh404sefHelperMetadata::includeMetaPlugin();
					$pageInfo = Sh404sefFactory::getPageInfo();
					if (!preg_match('/(&|\?)lang=[a-zA-Z]{2,3}/iuU', $pageInfo->currentNonSefUrl))
					{
						// no lang string, let's add default
						$shTemp = explode('-', $pageInfo->currentLanguageTag);
						$shLangTemp = $shTemp[0] ? $shTemp[0] : 'en';
						$pageInfo->currentNonSefUrl .= '&lang=' . $shLangTemp;
					}
					Sh404sefHelperMetadata::insertMetaData();
				}
			}
		}
	}

	/**
	 * Optionally operate searches of adjustment on page content
	 *
	 * @param   string  $context The context of the content being passed to the plugin.
	 * @param   mixed   &$row An object with a "text" property or the string to be processed.
	 * @param   mixed   &$params Additional parameters.
	 * @param   integer $page Optional page number. Unused. Defaults to zero.
	 *
	 * @return  boolean    True on success.
	 */
	public function onContentPrepare($context, &$row, &$params, $page = 0)
	{
		// Don't run this plugin when the content is being indexed
		if ($context == 'com_finder.indexer')
		{
			return true;
		}
		if (JFactory::getApplication()->isAdmin())
		{
			return true;
		}

		if (!defined('SH404SEF_IS_RUNNING'))
		{
			return true;
		}

		// should we spend time on this?
		$config = Sh404sefFactory::getConfig();
		if (is_object($row))
		{
			$row->text = $this->searchOGPImage($row->text, $config, $context, $row);
			if($config->autoBuildDescription)
			{
				Sh404sefHelperMetadata::buildAutoDescription($context, $row->text, $params, $page);
			}
		}
		else
		{
			$row = $this->searchOGPImage($row, null, $config);
			if($config->autoBuildDescription)
			{
				Sh404sefHelperMetadata::buildAutoDescription($context, $row, $params, $page);
			}
		}

		return true;
	}

	public function onAfterRender()
	{
		if (defined('SH404SEF_IS_RUNNING'))
		{
			$config = Sh404sefFactory::getConfig();
			$document = JFactory::getDocument();

			if (JFactory::getApplication()->isAdmin())
			{
				if (version_compare(JVERSION, '3.0', 'ge'))
				{
					// are we on an edit page?
					$app = JFactory::getApplication();
					$option = $app->input->getCmd('option');
					$view = $app->input->getCmd('view');
					$layout = $app->input->getCmd('layout');
					if ($layout == 'edit'
						&& (($option == 'com_content' && $view == 'article') || ($option == 'com_categories' && $view == 'category')
							|| ($option == 'com_contact' && $view == 'contact') || ($option == 'com_newsfeeds' && $view == 'newsfeed')
							|| ($option == 'com_weblinks' && $view == 'weblink'))
					)
					{
						// variations in field name
						if ($option == 'com_newsfeeds' || $option == 'com_contact')
						{
							$titleFieldName = 'jform_name';
						}
						else
						{
							$titleFieldName = 'jform_title';
						}
						// attach an input counter to the title input boxes
						if ($document->getType() == 'html')
						{
							$page = JResponse::getBody();
							// insert css and js
							$link = '';
							$cssLink = ShlHtml_Manager::getInstance()->getMediaLink('bs', 'css');
							if (strpos($page, $cssLink) === false)
							{
								$link .= '<link rel="stylesheet" href="' . $cssLink . '" type="text/css" />';
							}
							$jsLink = ShlHtml_Manager::getInstance()->getMediaLink('bs', 'js');
							if (strpos($page, $jsLink) === false)
							{
								$link .= "\n" . '<script src="' . $jsLink . '" type="text/javascript" ></script>';
							}
							if (!empty($link))
							{
								$page = str_replace('</head>', $link . '</head>', $page);
							}

							// insert custom js to attach counters to title and metadesc fields
							$script = ShlHtmlBs_Helper::renderInputCounter(
								$titleFieldName,
								Sh404sefFactory::getPConfig()->metaDataSpecs['metatitle-joomla-be']
							);
							$script .= ShlHtmlBs_Helper::renderInputCounter(
								'jform_metadesc',
								Sh404sefFactory::getPConfig()->metaDataSpecs['metadesc-joomla-be']
							);
							$page = str_replace('</body>', $script . '</body>', $page);
							JResponse::setBody($page);
						}
					}
				}

				return;
			}

			// modify page content on the fly
			if ($document->getType() == 'html')
			{
				// search for images for OGP, only if previous attempts have failed
				if ($config->shMetaManagementActivated && ($config->enableOpenGraphData || $config->enableTwitterCards))
				{
					$content = $this->searchOGPImage(JResponse::getBody(), $config);
					JResponse::setBody($content);
				}

				// return if no seo optim to perform
				if ($config->shMetaManagementActivated || Sh404sefHelperAnalytics::isEnabled())
				{
					// now execute most content rewriting
					$include = JPATH_ROOT . '/components/com_sh404sef/shPageRewrite.php';
					include_once $include;
				}

				// insert redirect message after automatic 404 redirect
				$message404 = JFactory::getSession()->get('wb_sh404sef_404_redirect_message');
				JFactory::getSession()->set('wb_sh404sef_404_redirect_message', null);
				if (!empty($message404))
				{
					$renderedMessage = ShlMvcLayout_Helper::render('com_sh404sef.general.error_404_redirect_msg', $message404, sh404SEF_LAYOUTS);
					if (!empty($renderedMessage))
					{
						$page = JResponse::getBody();
						$page = str_replace('</body>', $renderedMessage . '</body>', $page);
						JResponse::setBody($page);
					}
				}
			}
		}
	}

	private function searchOGPImage($content, $config, $context = '', $contentObject = null)
	{
		// 1 - custom meta data
		$customData = Sh404sefHelperMetadata::getCustomMetaDataFromDb();
		if ($customData->og_enable == SH404SEF_OPTION_VALUE_NO
			|| ($customData->og_enable == SH404SEF_OPTION_VALUE_USE_DEFAULT && $config->enableOpenGraphData == SH404SEF_OPTION_VALUE_NO)
		)
		{
			// OGP is disabled on this page
			return $content;
		}

		if (!empty($customData->og_image))
		{
			// user set an image already
			return $content;
		}

		// 2 - Full or Intro image (only for com_content)
		if ('com_content.article' == $context)
		{
			$bestImage = Sh404sefHelperOgp::detectComContentImages($contentObject);
			if (!empty($bestImage))
			{
				$customData->og_image = $bestImage;
			}
		}

		// 2Bis - Same for K2 - if ('com_k2.item' == $context)
		{
			$bestImage = Sh404sefHelperOgp::detectComK2Images($contentObject);
			if (!empty($bestImage))
			{
				$customData->og_image = $bestImage;
			}
		}

		if (!empty($customData->og_image))
		{
			// there is a
			return $content;
		}

		// 3 - Automatic detection, largest or first
		$bestImage = ShlHtmlContent_Image::getBestImage($content, $config->ogImageDetection, Sh404sefFactory::getPConfig()->facebookImageSize);
		if (!empty($bestImage))
		{
			$customData->og_image = $bestImage;
		}

		// in all case, remove the optional disable tag
		$content = str_replace('{disable_auto_meta_image_detection}', '', $content);

		return $content;
	}

	/**
	 * A set of SEO hacks that don't fit elsewhere
	 * as we usually want a very quick response and
	 * avoid wasted resources
	 *
	 */
	protected function _hacks()
	{
	}

	/**
	 * Decide whether we should force language (to default)
	 * to counter Joomla! incorrect language selection
	 *
	 * @param $app
	 *
	 * @return bool
	 */
	protected function _shouldForceLanguage($app)
	{
		// we should force language if:
		// 1 - lang code is removed on default language
		// update 2015-04: no, even if language is not removed, we must force language
		// as Joomla always accept any language for / !!!
		// 2 - the request doesn't start with a (non-default) language code

		// don't break browser language detection
		$langCookie = $app->input->cookie->get(JApplication::getHash('language'), null);
		if (empty($langCookie) && $app->getDetectBrowser())
		{
			return false;
		}

		// don't set lang on (forms) POST
		if ($app->input->getMethod() == "POST" && count($app->input->post) != 0)
		{
			return false;
		}

		// now does request start with a valid language code
		$pageInfo = Sh404sefFactory::getPageInfo();
		$base = JUri::getInstance()->base();
		$request = wbLTrim($pageInfo->currentSefUrl, $base);
		$urlLanguageCode = explode('/', $request);
		$urlLanguageCode = $urlLanguageCode[0];
		if (Sh404sefHelperLanguage::validateSefLanguageCode($urlLanguageCode))
		{
			return false;
		}

		return true;
	}

	protected function _shouldSetHomePageLanguage($app)
	{
		// don't break browser language detection
		$langCookie = $app->input->cookie->get(JApplication::getHash('language'), null);
		if (empty($langCookie) && $app->getDetectBrowser())
		{
			return false;
		}

		// don't set lang on (forms) POST
		if ($app->input->getMethod() == "POST" && count($app->input->post) == 0)
		{
			return false;
		}

		$pageInfo = Sh404sefFactory::getPageInfo();
		$base = JUri::getInstance()->base();
		$request = wbLTrim($pageInfo->currentSefUrl, $base);

		// easy, just home page
		if ($request == '')
		{
			return true;
		}

		// might be some home page variation: simple, just /index.php
		if ($request == 'index.php')
		{
			return true;
		}

		// other home page variation: index.php?lang=xx: comply with that
		$langCodeInUrl = Sh404sefHelperUrl::getUrlLang($request);
		if (!empty($langCodeInUrl))
		{
			return false;
		}

		// other home page variation: index.php?val1=xx&val2=yy, we should set language
		$bits = explode('?', $request);
		if (!empty($bits) && $bits['0'] == 'index.php')
		{
			return true;
		}

		return false;
	}

	/**
	 * Load and register the plugins currently activated by webmaster
	 *
	 * @return none
	 */
	protected function _loadPlugins($type)
	{
		// required joomla library
		jimport('joomla.plugin.helper.php');

		// import the plugin files
		$status = JPluginHelper::importPlugin($type);

		return $status;
	}

	/**
	 * Register our autoloader function with PHP
	 */
	protected function _registerAutoloader()
	{

		$autoloaderFile = JPATH_ADMINISTRATOR . '/components/com_sh404sef/helpers/autoloader.php';

		// add our own
		if (file_exists($autoloaderFile))
		{
			// get Joomla autloader out
			spl_autoload_unregister("__autoload");

			include $autoloaderFile;
			$registered = spl_autoload_register(array('Sh404sefAutoloader', 'doAutoload'));

			// stitch back Joomla's at the end of the list
			if (function_exists("__autoload"))
			{
				spl_autoload_register("__autoload");
			}

			if (!defined('SH404SEF_AUTOLOADER_LOADED'))
			{
				define('SH404SEF_AUTOLOADER_LOADED', 1);
			}
		}
		else
		{
			$app = JFactory::getApplication();
			if ($app->isAdmin())
			{
				$app->enqueueMessage('sh404SEF autoloader file is missing or unreadable: ' . $autoloaderFile, 'error');
			}
		}
	}

	protected function _fixTimeWarning()
	{
		// prevent timezone not set warnings to appear all over,
		// especially for PHP 5.3.3+
		$serverTimezone = @date_default_timezone_get();
		@date_default_timezone_set($serverTimezone);
	}

	protected function _setAlternateTemplate()
	{
		$app = JFactory::getApplication();
		$sefConfig = Sh404sefFactory::getConfig();

		if (!defined('SHMOBILE_MOBILE_TEMPLATE_SWITCHED') && !empty($sefConfig->alternateTemplate))
		{
			// global on/off switch
			self::$_template = $app->getTemplate(); // save current template
			$app->setTemplate($sefConfig->alternateTemplate);
		}
	}

	protected function _resetAlternateTemplate()
	{
		$app = JFactory::getApplication();
		$sefConfig = Sh404sefFactory::getConfig();

		if (!defined('SHMOBILE_MOBILE_TEMPLATE_SWITCHED') && !empty($sefConfig->alternateTemplate))
		{
			// global on/off switch
			if (empty(self::$_template))
			{
				return;
			}
			$app->setTemplate(self::$_template); // restore old template
		}
	}

	private function getLangCookieTime()
	{
		$cookieTime = 0;
		$languageFilterPlugin = JPluginHelper::getPlugin('system', 'languagefilter');
		if (!empty($languageFilterPlugin))
		{
			$params = new JRegistry($languageFilterPlugin->params);
			if ($params->get('lang_cookie', 1) == 1)
			{
				$cookieTime = time() + 365 * 86400;
			}
		}
		return $cookieTime;
	}
}

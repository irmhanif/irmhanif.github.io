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
	die();
}

class Sh404sefModelRedirector
{
	/**
	 * Whether to redirect or insert a canonical when using an alias.
	 */
	const TARGET_TYPE_REDIRECT = 0;
	const TARGET_TYPE_CANONICAL = 1;

	/**
	 * If there are less placeholders in alias target than in alias source, in which direction
	 * replacement should take place?
	 */
	const REPLACEMENT_DIRECTION_END_TO_START = 0;
	const REPLACEMENT_DIRECTION_START_TO_END = 1;
	/**
	 * @var object stores sh404SEF config.
	 */
	private $config;

	/**
	 * @var JRegistry Stores Joomla configuration.
	 */
	private $jconfig;

	/**
	 * @var JUri Stores the current request URI.
	 */
	private $uri;

	/**
	 * @var array Stores the wildcard alias rules set by user.
	 */
	private $wildcardAliases;

	/**
	 * @var array Stores the rules that matched the current request.
	 */
	private $matchedRules = array();

	/**
	 * @var bool Stores whether a URL was triggered.
	 */
	private $aliasFound = false;

	/**
	 * @var array The alias rule that should be executed.
	 */
	private $aliasToExecute = null;

	/**
	 * @var array Stores the wildcard strings that can be used in a wildcard alias.
	 */
	static public $aliasesWildcardsChars = array('{*}', '{?}');

	/**
	 * Stores external information.
	 *
	 * @param $uri
	 * @param $config
	 * @param $jconfig
	 */
	public function __construct($uri, $config, $jconfig)
	{
		$this->uri = $uri;
		$this->config = $config;
		$this->jconfig = $jconfig;

		$this->loadMatchRules();
	}

	/**
	 * Loads all aliases rules that match the current request.
	 *
	 * @return $this
	 */
	private function loadMatchRules()
	{
		// requestPathAndQuery HAS the query string in it
		$requestPathAndQuery = str_replace(
			JURI::root() . $this->getRewritePrefix(),
			'',
			$this->getCurrentRequestUrl()
		);

		if (empty($requestPathAndQuery))
		{
			$requestPathAndQuery = '/';
		}

		$parts = explode('?', $requestPathAndQuery, 2);
		$path = empty($parts) ? '' : array_shift($parts);
		$path = rawurldecode($path);
		$queryString = empty($parts) ? '' : array_shift($parts);

		try
		{
			$this->findHardcodedMatchedRules($requestPathAndQuery, $path, $queryString)
			     ->findWildcardMatchedRules($requestPathAndQuery, $path, $queryString);
		}
		catch (Exception $e)
		{
			// if error, just log
			ShlSystem_Log::error(
				'sh404sef', '%s::%d: %s', __METHOD__, __LINE__,
				'Error checking redirect aliases: ' . $e->getMessage()
			);
		}

		return $this;
	}

	/**
	 * Checks whether any kind of alias matches the passed request,
	 * and perform the redirect if any.
	 *
	 */
	public function redirectFromAlias()
	{
		// shortcut: no redirect on POST
		if ('POST' == JFactory::getApplication()->input->getMethod())
		{
			return;
		}

		try
		{
			$this->redirectFromAliases('hardcoded')
			     ->redirectFromAliases('wildcard');
		}
		catch (Exception $e)
		{
			// if error, just log
			ShlSystem_Log::error(
				'sh404sef', '%s::%d: %s', __METHOD__, __LINE__,
				'Error checking redirect aliases: ' . $e->getMessage()
			);
		}
	}

	/**
	 * Finds and store all the hardcoded aliases redirect rules that match the current URI.
	 * Those rules target is a non-sef URL that has an sh404SEF SEF record.
	 *
	 * @param string $requestPath
	 * @param string $path
	 * @param string $queryString
	 *
	 * @return $this
	 */
	private function findHardcodedMatchedRules($requestPath, $path, $queryString)
	{
		if (!isset($this->matchedRules['hardcoded']))
		{
			$this->matchedRules['hardcoded'] = array();

			// build sql query, we may check both path and full query
			$sql = 'SELECT * FROM ?? WHERE ?? = 1 and (?? = ?';
			$nameQuoted = array(
				'#__sh404sef_aliases',
				'state',
				'alias'
			);
			$quoted = array(
				$requestPath
			);

			$isNonSefRequest = wbStartsWith($requestPath, 'index.php?option=');
			if ($isNonSefRequest)
			{
				// a non-sef, let's try with the router version
				$sef = JRoute::_($requestPath);
				$sef = wbLTrim($sef, JUri::base(true));
				$sef = JString::ltrim($sef, '/');
				$sql .= ' or ?? = ?';
				$nameQuoted[] = 'alias';
				$quoted[] = $sef;
			}

			// path different from full url requested, means there is a query string
			else if (!empty($path) && $path != $requestPath)
			{
				$sql .= ' or ?? = ?';
				$nameQuoted[] = 'alias';
				$quoted[] = $path;
				if (JString::substr($path, -1) != '/')
				{
					// getPath will trim trailing / so we must try also with it
					$sql .= ' or ?? = ?';
					$nameQuoted[] = 'alias';
					$quoted[] = $path . '/';
				}
			}

			$sql .= ')';

			// finally order by user selected ordering
			$sql .= ' order by ?? asc';
			$nameQuoted[] = 'ordering';

			$aliasRecord = ShlDbHelper::quoteQuery($sql, $nameQuoted, $quoted)->loadObject();
			if (!empty($aliasRecord))
			{
				$trimmedAlias = JString::trim($aliasRecord->alias);
				if ($trimmedAlias == 'index.php' || $trimmedAlias == '/' || empty($trimmedAlias))
				{
					$aliasRecord = null;
				}
			}

			// do the redirect, after checking a few conditions
			if (!empty($aliasRecord))
			{
				// if match occured on full requested URL, or this is a non-sef or this is a canonilca, not a redirect: no need to re-append the query string
				// to the target URL.
				$queryString = $aliasRecord->target_type == self::TARGET_TYPE_CANONICAL || $isNonSefRequest || $aliasRecord->newurl == $requestPath ? '' : $queryString;

				//$this->doAliasRedirect($requestPath, $aliasRecord, array(), $queryString);
				$this->matchedRules['hardcoded'][] = array(
					'rule'         => $aliasRecord,
					'request_path' => $requestPath,
					'matches'      => array(),
					'query_string' => $queryString
				);
			}
		}

		return $this;
	}

	/**
	 * Finds and store all the wildcard aliases redirect rules that match the current URI.
	 *
	 * @param string $requestPath
	 * @param string $path
	 * @param string $queryString
	 *
	 * @return $this
	 */
	private function findWildcardMatchedRules($requestPath, $path, $queryString)
	{
		if (!isset($this->matchedRules['wildcard']))
		{
			$isNonSefRequest = wbStartsWith($requestPath, 'index.php?option=');
			$this->matchedRules['wildcard'] = array();

			if (is_null($this->wildcardAliases))
			{
				$this->wildcardAliases = ShlDbHelper::selectObjectList(
					'#__sh404sef_aliases',
					'*',
					'state = 1 and (type = ? or type = ?)',
					array(
						Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_WILDCARD,
						Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_CUSTOM
					)
				);
				$this->wildcardAliases = empty($this->wildcardAliases) ? array() : $this->wildcardAliases;
			}
			foreach ($this->wildcardAliases as $wildcardsAliasRecord)
			{
				// test the full URL
				$matches = ShlSystem_Route::urlRuleMatch($wildcardsAliasRecord->alias, $requestPath, $wildChar = '{*}', $singleChar = '{?}', $regexpChar = '~');
				if (!empty($matches[0]))
				{
					$this->matchedRules['wildcard'][] = array(
						'rule'         => $wildcardsAliasRecord,
						'request_path' => $requestPath,
						'matches'      => $matches,
						'query_string' => ''
					);
				}

				// test the path only
				$matches = ShlSystem_Route::urlRuleMatch($wildcardsAliasRecord->alias, $path, $wildChar = '{*}', $singleChar = '{?}', $regexpChar = '~');
				if (!empty($matches[0]))
				{
					// if match occured on full requested URL, or this is a non-sef or this is a canonilca, not a redirect: no need to re-append the query string
					// to the target URL.
					$queryString = $wildcardsAliasRecord->target_type == self::TARGET_TYPE_CANONICAL || $isNonSefRequest || $wildcardsAliasRecord->newurl == $requestPath ? '' : $queryString;
					$this->matchedRules['wildcard'][] = array(
						'rule'         => $wildcardsAliasRecord,
						'request_path' => $requestPath,
						'matches'      => $matches,
						'query_string' => $queryString
					);
				}
			}
		}

		return $this;
	}

	/**
	 * Checks whether any wildcard alias match the request.
	 * Used after the simple, hardcoded aliases have been checked.
	 *
	 * @param string $requestPath
	 * @param string $path
	 * @param string $queryString
	 *
	 * @return $this
	 */
	private function redirectFromAliases($type)
	{
		if (empty($this->matchedRules[$type]))
		{
			return $this;
		}

		foreach ($this->matchedRules[$type] as $matchedRule)
		{
			if ($this->aliasFound)
			{
				break;
			}
			$this->executeAlias(
				$matchedRule
			);
		}

		return $this;
	}

	/**
	 * Performs the actual redirect to an alias.
	 *
	 * @param array $matchedRule Definition of the rule that matched to trigger this alias.
	 */
	protected function executeAlias($matchedRule)
	{
		$aliasRecord = wbArrayGet($matchedRule, 'rule');
		if (!empty($aliasRecord))
		{
			$destUrl = $this->buildAliasTarget(
				$aliasRecord,
				$this->getCurrentRequestUrl(),
				wbArrayGet($matchedRule, 'matches'),
				wbArrayGet($matchedRule, 'query_string')
			);

			/**
			 * Filter the target destination just before sh404SEF execute an alias rule (redirect or canonical insertion).
			 * Returning an empty string will prevent the alias rule to be executed.
			 * @api
			 * @package sh404SEF\filter\routing
			 * @var sh404sef_redirect_alias
			 * @since   4.12.0
			 *
			 * @param string   $destUrl The computed target URL.
			 * @param string   $requestPath The path requested.
			 * @param string   $queryString The query string requested.
			 * @param stdClass $aliasRecord The alias definition that triggered the redirect/canonical
			 *
			 * @return array
			 */
			$destUrl = ShlHook::filter(
				'sh404sef_redirect_alias',
				$destUrl,
				wbArrayGet($matchedRule, 'request_path'),
				wbArrayGet($matchedRule, 'query_string'),
				$aliasRecord
			);

			if (!empty($destUrl))
			{
				// log alias execution (only for redirects)
				$this->logAliasExecution(
					wbArrayGet($matchedRule, 'request_path'),
					$aliasRecord,
					$destUrl
				);

				// do redirect
				ShlSystem_Log::debug('sh404sef', 'Aliasing to ' . $destUrl . ' from ' . wbArrayGet($matchedRule, 'request_path') . ' with a ' . ($aliasRecord->target_type == self::TARGET_TYPE_CANONICAL ? 'canonical' : 'redirect'));

				switch ($aliasRecord->target_type)
				{
					case self::TARGET_TYPE_REDIRECT:
						ShlSystem_Http::redirectPermanent($destUrl);
						break;
					case self::TARGET_TYPE_CANONICAL:
						$this->aliasFound = true;
						$this->aliasToExecute = ShlSystem_Route::absolutify($destUrl, $forceDomain = true);
						break;
				}
			}
		}
	}

	/**
	 * Getter for the alias to execute, if any.
	 *
	 * @return array
	 */
	public function getAliasToExecute()
	{
		return $this->aliasToExecute;
	}

	/**
	 * Logs an alias execution, just before using it. Only applies to redirects.
	 *
	 * @param string   $requestPath
	 * @param stdClass $aliasRecord
	 * @param string   $destUrl
	 */
	private function logAliasExecution($requestPath, $aliasRecord, $destUrl)
	{
		if ($aliasRecord->target_type == self::TARGET_TYPE_REDIRECT)
		{
			// update alias hits counter
			ShlDbHelper::update(
				'#__sh404sef_aliases',
				array('hits' => $aliasRecord->hits + 1),
				array('id' => $aliasRecord->id)
			);

			// record a detailed log of the alias, if set to
			if ($this->config->logAliasesHits)
			{
				$recorder = Sh404sefModelReqrecorder::getInstance(
					Sh404sefModelReqrecorder::REQUEST_ALIAS
				);
				$recorder->record($requestPath, $destUrl);
			}
		}
	}

	/**
	 * Run a few tests to decide whether a redirect should be allowed,
	 * and build the target URL.
	 *
	 * @param stdClass $aliasRecord
	 * @param string   $incomingUrl
	 * @param array    $matches
	 * @param string   $queryString
	 *
	 * @return bool|string
	 */
	private function buildAliasTarget($aliasRecord, $incomingUrl, $matches, $queryString)
	{
		if ('POST' == JFactory::getApplication()->input->getMethod())
		{
			return false;
		}

		$redirectTarget = $this->getExpandedAliasTarget($aliasRecord, $matches);

		if (empty($redirectTarget) || $redirectTarget == $incomingUrl)
		{
			return false;
		}

		switch (true)
		{
			// redirect to home page
			case $redirectTarget == sh404SEF_HOMEPAGE_CODE:
				if (!empty($this->config->shForcedHomePage))
				{
					$redirectTarget = $this->config->shForcedHomePage;
				}
				else
				{
					$redirectTarget = $this->getHomepageUrl();
				}
				break;
			// redirect target is a non-sef url, route it
			case wbStartsWith($redirectTarget, 'index.php'):
				$shUri = new JURI($redirectTarget);
				$shOriginalUri = clone ($shUri);
				$redirectTarget = shSefRelToAbs($redirectTarget, '', $shUri, $shOriginalUri) . $shUri->toString(array('query'));
				break;
			// directly use the redirect target
			default:
				break;
		}

		// re-append query string if it was the path that matched, not the actual full request URL
		if (!empty($redirectTarget) && !empty($queryString))
		{
			$redirectTarget .= wbContains($redirectTarget, '?') ?
				'&' . $queryString
				:
				'?' . $queryString;
		}

		$redirectTarget = $this->prepareUrlForRedirect($redirectTarget);
		if (
			$redirectTarget != $incomingUrl
			||
			$aliasRecord->target_type == self::TARGET_TYPE_CANONICAL
		)
		{
			return $redirectTarget;
		}

		return false;
	}

	/**
	 * Expand the alias record newurl that can have wildcard into its final form.
	 *
	 * sample-{*}-more-{*}-end -> sample-{*}-new-{*}-end
	 *
	 * @param stdClass $aliasRecord
	 * @param array    $matches
	 *
	 * @return string
	 */
	private function getExpandedAliasTarget($aliasRecord, $matches)
	{
		// for most aliases, redirect target is directly the stored one
		$redirectTarget = $aliasRecord->newurl;

		/**
		 * Filter replacement direction of wildcard charecters if there are less placeholders in alias target than in alias source.
		 *
		 * @api
		 * @package sh404SEF\filter\routing
		 * @var sh404sef_redirect_alias_replacement_direction
		 * @since   4.12.0
		 *
		 * @param string   $replacementDirection The direction to use when doing wildcard replacement.
		 * @param stdClass $aliasRecord The alias definition that triggered the redirect/canonical
		 *
		 * @return array
		 */
		$replacementDirection = ShlHook::filter(
			'sh404sef_redirect_alias_replacement_direction',
			self::REPLACEMENT_DIRECTION_END_TO_START,
			$aliasRecord
		);

		switch ($aliasRecord->type)
		{
			case Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_CUSTOM:

				if (wbStartsWith($aliasRecord->alias, '~'))
				{
					// user entered a raw regular expression, we don't interfere
					break;
				}
				// if there are wildcards, and the incoming request URL have some matches
				// we can inject them in the redirect target
				if (
					wbContains($redirectTarget, self::$aliasesWildcardsChars)
					&&
					count($matches) > 1
				)
				{
					// insert back, starting from the end
					if (!empty($matches))
					{
						switch ($replacementDirection)
						{
							case self::REPLACEMENT_DIRECTION_START_TO_END:
								// inject back the matching elements in the same order
								// until none is available
								array_shift($matches);
								if (!empty($matches))
								{
									$redirectTarget = preg_replace_callback(
										'~\{([?|*])\}~',
										function ($targetMatches) use (&$matches) {

											$value = empty($matches) ? '' : array_shift($matches);

											return $value;
										},
										$redirectTarget
									);
								}
								break;
							default:
								// inject back matching elements, in reverse order, starting from the end of the URL.
								$redirectTarget = JString::strrev($redirectTarget);
								$matches = array_reverse($matches);
								$redirectTarget = preg_replace_callback(
									'~\}([?|*])\{~',
									function ($targetMatches) use (&$matches) {

										$value = empty($matches) ? '' : array_shift($matches);

										$value = JString::strrev($value);
										return $value;
									},
									$redirectTarget
								);

								$redirectTarget = JString::strrev($redirectTarget);
								break;
						}
					}
				}
				break;
			default:
				break;
		}

		return $redirectTarget;
	}

	/**
	 * Minor touch up to the target URL.
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	private function prepareUrlForRedirect($url)
	{

		$url = str_replace('&amp;', '&', $url);

		$url = ShlSystem_Route::absolutify($url);

		$url = wbRTrim($url, '//');

		return $url;
	}

	/**
	 * Computes the full URL of the site home page.
	 *
	 * @return string
	 */
	private function getHomepageUrl()
	{
		static $home = null;

		if (is_null($home))
		{
			$home = JString::rtrim(
				JUri::getInstance()->base(),
				'/'
			);
			$home = wbRTrim($home, '/administrator');
		}

		return $home;
	}

	private function getRewritePrefix()
	{
		static $prefix = null;

		if (is_null($prefix))
		{
			if (!$this->jconfig->get('sef_rewrite', 0))
			{
				$prefix .= 'index.php/';
			}
		}
		return $prefix;
	}

	private function getCurrentRequestUrl()
	{
		static $currentRequestUrl = null;

		if (is_null($currentRequestUrl))
		{
			$currentRequestUrl = wbGetProtectedProperty('Juri', 'uri', $this->uri);
		}

		return $currentRequestUrl;
	}
}

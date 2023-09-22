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

class Sh404sefModelAliases extends Sh404sefClassBaselistModel
{
	protected $_context      = 'sh404sef.aliases';
	protected $_defaultTable = 'aliases';
	protected $text_prefix   = 'COM_SH404SEF_ALIASES';

	/**
	 * Save a list of aliases as entered by user in backend to the database
	 *
	 * @param string $aliasList data from an html textarea field
	 * @param string $nonSefUrl the non sef url to which aliases are attached
	 *
	 * @return boolean true on success
	 */
	public function saveFromInput($aliasList, $nonSefUrl, $targetType = Sh404sefModelRedirector::TARGET_TYPE_REDIRECT)
	{
		// split aliases from raw input data into an array
		$aliasList = ShlSystem_Strings::stringToCleanedArray($aliasList, "\n");

		try
		{
			// delete them all. We should do a transaction, but not worth it
			if (Sh404sefModelRedirector::TARGET_TYPE_CANONICAL != $targetType)
			{
				ShlDbHelper::delete('#__sh404sef_aliases', array('newurl' => $nonSefUrl));
			}
			else
			{
				ShlDbHelper::delete('#__sh404sef_aliases', array('alias' => $aliasList[0]));
			}

			// Write new aliases.
			if (!empty($aliasList[0]))
			{
				$badChars = array("\r\n", "\n", "\r", ' ');
				foreach ($aliasList as $alias)
				{
					// remove end of line chars
					$alias = str_replace($badChars, '', $alias);
					// if something left, try insert it into DB
					if (!empty($alias))
					{
						// first check value is not invalid
						// either the alias already exists
						// or same SEF url already exists
						try
						{
							$count = 0;
							// do we have the same SEF URL? not allowed for redirects, but ok for canonicals.
							if (Sh404sefModelRedirector::TARGET_TYPE_CANONICAL != $targetType)
							{
								$count = ShlDbHelper::count('#__sh404sef_urls', 'id', 'oldurl = ? and newurl <> ?', array($alias, ''));
							}

							if (empty($count))
							{
								$count = ShlDbHelper::count('#__sh404sef_aliases', '*', array('alias' => $alias));
							}
						}
						catch (Exception $e)
						{
							$count = 0;
						}

						// we might rename a URL to an existing one (ie creating a duplicate). In such case,
						// the alias should not be attached to the current non-sef, but instead to the "main" URL,
						// the one that has rank 0
						if (empty($count))
						{
							// 1 - what's the SEF for the current non-sef alias target?
							$sef = ShlDbHelper::selectObject('#__sh404sef_urls', '*', 'newurl = ? and oldurl <> ""', array($nonSefUrl));

							// 2 - we now have the rigth SEF record to direct the alias to
							if (!empty($sef))
							{
								$mainNonSefUrl = ShlDbHelper::selectObject('#__sh404sef_urls', '*', 'oldurl = ? and newurl <> "" and rank = 0', array($sef->oldurl));
								if (!empty($mainNonSefUrl))
								{
									// attach the alias to this "main" URL instead of provided one
									$nonSefUrl = $mainNonSefUrl->newurl;
								}
							}
						}

						// if ok, insert into db
						if (empty($count))
						{
							$aliasObject = JTable::getInstance($this->_defaultTable, 'Sh404sefTable');
							$aliasObject->bind(
								array(
									'newurl'      => $nonSefUrl,
									'alias'       => $alias,
									'target_type' => $targetType
								)
							);
							$aliasObject->store();
						}
						else
						{
							// alias already exists either as an alias or a SEF url
							$this->setError(JText::sprintf('COM_SH404SEF_ALIAS_ALREADY_EXISTS', $alias));
						}
					}
				}
			}
		}
		catch (Exception $e)
		{
			ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
			$this->setError($e->getMessage());
		}

		// return true if no error
		$error = $this->getErrors();

		return empty($error);
	}

	/**
	 * Saves (or delete) a canonical redirect. Used when editing a single URL in the admin.
	 *
	 * @param string $canonicalTarget
	 * @param string $sourceUrl
	 */
	public function saveCanonical($canonicalTarget, $sourceUrl)
	{
		if (empty($sourceUrl))
		{
			return true;
		}

		if (empty($canonicalTarget))
		{
			ShlDbHelper::delete(
				'#__sh404sef_aliases',
				array(
					'alias'       => $sourceUrl,
					'target_type' => Sh404sefModelRedirector::TARGET_TYPE_CANONICAL
				)
			);

			return true;
		}

		// insert or update
		$sourceUrl = Sh404sefHelperGeneral::getSefFromNonSef(
			$sourceUrl
		);
		$sourceUrl = wbLTrim(
			$sourceUrl,
			JUri::root()
		);
		$sourceUrl = empty($sourceUrl) ? '/' : $sourceUrl;
		$this->saveFromInput(
			$sourceUrl,
			$canonicalTarget,
			Sh404sefModelRedirector::TARGET_TYPE_CANONICAL
		);
		$error = $this->getError();

		return empty($error);
	}

	/**
	 * Read data from model and turns it into
	 * a string suitable for display in a text area field
	 *
	 * @param array $options key/value pairs to restrict data selection
	 */
	public function getDisplayableList($options)
	{
		// get raw data
		$rawList = $this->getList($options, $returnZeroElement = false, $forcedLimitstart = null, $forcedLimit = 5000);

		// make a simple string suitable for editing in a text area input field
		$displayableList = '';
		if (!empty($rawList))
		{
			foreach ($rawList as $alias)
			{
				$displayableList .= shUrlSafeDisplay($alias->alias) . "\n";
			}
		}

		return $displayableList;
	}

	/**
	 * Purge urls from database (and cache)
	 * either all automatic, or according to current
	 * sef url list page select options as stored in
	 * in session
	 *
	 * @param unknown_type $type
	 */
	public function purge($type = 'auto')
	{
		// make sure we use latest user state
		$this->_updateContextData();

		// call the appropriate sub-method to get the db query
		$methodName = '_getPurgeQuery' . ucfirst($type);
		if (is_callable(array($this, $methodName)))
		{
			$deleteQuery = $this->$methodName();
		}
		else
		{
			$this->setError('Invalid method call _purge' . $type);

			return;
		}

		try
		{
			// then run the query
			$this->_db->setQuery($deleteQuery);
			$this->_db->execute();
		}
		catch (Exception $e)
		{
			ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
			$this->setError('Internal database error # ' . $e->getMessage());
		}

		// reset limit and limitstart variables, to avoid
		// issue when displaying again results
		$this->_setState('limitstart', 0);
		$this->_setState('limit', 0);
	}

	public function getAliasesCount($which = 'auto')
	{
		switch (strtolower($which))
		{
			// we want to read all automatic urls (include duplicates)
			case 'auto':
				try
				{
					$numberOfUrls = ShlDbHelper::count(
						$this->_getTableName(), '*',
						'type = ? or type = ?',
						array(
							Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS,
							Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_WILDCARD,
							Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_CUSTOM
						)
					);
				}
				catch (Exception $e)
				{
					$numberofUrls = 0;
				}
				break;

			// we want to read urls as per current selection input fields
			// ie : component, language, custom, ...
			case 'selected':
				$numberOfUrls = $this->getTotal();
				break;

			default:
				$numberOfUrls = 0;
				break;
		}

		return intval($numberOfUrls);
	}

	/**
	 * Finds the sef url record to which an
	 * alias record, identified by its id,
	 * elongs to
	 *
	 * @param integer $aliasId
	 */
	public function getUrlByAliasId($aliasId)
	{
		$aliasId = empty($aliasId) ? 0 : intval($aliasId);
		$query = 'select r.* from ' . $this->_db->quoteName('#__sh404sef_urls') . ' as r' . ' left join '
			. $this->_db->quoteName('#__sh404sef_aliases') . ' as a' . ' on a.' . $this->_db->quoteName('newurl') . ' = r.'
			. $this->_db->quoteName('newurl') . ' where a.' . $this->_db->quoteName('id') . ' = ' . $this->_db->Quote($aliasId) . ' order by '
			. $this->_db->quoteName('rank');
		try
		{
			$this->_db->setQuery($query);
			$url = $this->_db->loadObject();
		}
		catch (Exception $e)
		{
			ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
			$this->setError('Internal database error # ' . $e->getMessage());
		}

		return $url;
	}

	/**
	 * Gets alist of current filters and sort options which have
	 * been applied when building up the data
	 * @override
	 * @return object the list ov values as object properties
	 */
	public function getDisplayOptions()
	{
		$options = parent::getDisplayOptions();

		// get additional options vs base class

		// component used in url
		$options->filter_component = $this->_getState('filter_component');
		// show all/only one language
		$options->filter_language = $this->_getState('filter_language');
		// alias type
		$options->filter_target_type = $this->_getState('filter_target_type');
		// requested/not requested
		$options->filter_requested_urls = $this->_getState('filter_requested_urls');

		// return cached instance
		return $options;
	}

	protected function _buildListSelect($options)
	{
		// array to hold select clause parts
		$select = array();

		// get options
		$select[] = ' select a.*, r.oldurl';

		// add from  clause
		$select[] = 'from ' . $this->_getTableName() . ' as a';

		// aggregate clauses
		$select = (count($select) ? implode(' ', $select) : '');

		return $select;
	}

	protected function _buildListWhere($options)
	{
		// array to hold where clause parts
		$where = array();

		// get set of filters applied to the current view
		$filters = $this->getDisplayOptions();

		// only aliases, no pageid
		$where[] = '(a.type = ' . $this->_db->Quote(Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS)
			. ' or '
			. 'a.type = ' . $this->_db->Quote(Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_WILDCARD)
			. ' or '
			. 'a.type = ' . $this->_db->Quote(Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_CUSTOM)
			. ')';

		// are we reading aliases for one specific url ?
		$newurl = $this->_getOption('newurl', $options);
		if (!empty($newurl))
		{
			$where[] = 'a.newurl = ' . $this->_db->Quote($newurl);
		}
		else
		{
			// we read them all, except possibly the home page aliases
			$includeHomeData = $this->_getOption('includeHomeData', $options);
			if (empty($includeHomeData))
			{
				$where[] = 'a.newurl != ' . $this->_db->Quote(sh404SEF_HOMEPAGE_CODE);
			}
		}

		// add search all urls term if any
		if (!empty($filters->search_all))
		{ // V 1.2.4.q added search URL feature
			jimport('joomla.utilities.string');
			$searchTerm = $this->_cleanForQuery(JString::strtolower($filters->search_all));
			$where[] = " (LOWER(a.alias)  LIKE '%" . $searchTerm . "%' OR " . "LOWER(r.newurl)  LIKE '%" . $searchTerm . "%')";
		}

		// components check
		if (!empty($filters->filter_component))
		{
			$where[] = "LOWER(a.newurl)  LIKE '%option=" . $this->_cleanForQuery($filters->filter_component) . "%'";
		}

		// language check
		if (!empty($filters->filter_language))
		{
			$where[] = "LOWER(a.newurl)  LIKE '%lang=" . $this->_cleanForQuery(Sh404sefHelperLanguage::getUrlCodeFromTag($filters->filter_language)) . "%'";
		}

		if ($filters->filter_target_type != 'all')
		{
			$where[] = 'a.target_type = ' . $this->_db->Quote($filters->filter_target_type);
		}

		if (!empty($filters->filter_requested_urls))
		{
			switch ($filters->filter_requested_urls)
			{
				case Sh404sefHelperGeneral::SHOW_REQUESTED:
					$where[] = 'a.hits > 0';
					break;
				case Sh404sefHelperGeneral::SHOW_NOT_REQUESTED:
					$where[] = 'a.hits = 0';
					break;
			}
		}

		// aggregate clauses
		$where = (count($where) ? ' WHERE ' . implode(' AND ', $where) : '');

		return $where;
	}

	protected function _buildListJoin($options)
	{
		// array to hold join clause parts
		$join = array();

		// read also the sef url
		$join[] = 'left join ' . $this->_db->quoteName('#__sh404sef_urls') . ' as r';
		$join[] = 'on r.' . $this->_db->quoteName('newurl') . ' = a.' . $this->_db->quoteName('newurl');

		// aggregate clauses
		$join = (count($join) ? ' ' . implode(' ', $join) : '');

		return $join;
	}

	protected function _buildListOrderBy($options)
	{
		// build query fragment
		$orderBy = ' order by ordering asc';

		return $orderBy;
	}

	protected function _getTableName()
	{
		return '#__sh404sef_aliases';
	}

	/**
	 * Provides context data definition, to be used by context handler
	 * Should be overriden by descendant
	 */
	protected function _getContextDataDef()
	{
		$contextData = parent::_getContextDataDef();

		// define context data to be retrieved. Cannot be done at class level,
		// as some default values are dynamic
		$addedContextData = array(
			// redefined default sort order
			array('name' => 'filter_order', 'html_name' => 'filter_order', 'default' => 'ordering', 'type' => 'string')
			// component used in url
			,
			array('name' => 'filter_component', 'html_name' => 'filter_component', 'default' => '', 'type' => 'string')
			// show all/only one language
			,
			array('name' => 'filter_language', 'html_name' => 'filter_language', 'default' => '', 'type' => 'string')
			// target type
			,
			array('name' => 'filter_target_type', 'html_name' => 'filter_target_type', 'default' => '', 'type' => 'string')
			// requested/not requested
			,
			array('name' => 'filter_requested_urls', 'html_name' => 'filter_requested_urls', 'default' => '', 'type' => 'string')
		);

		return array_merge($contextData, $addedContextData);
	}

	/**
	 * Delete all automatically generated url records
	 * from database and cache
	 */
	private function _getPurgeQueryAuto()
	{
		// delete from database
		$query = 'delete from ' . $this->_db->quoteName($this->_getTableName())
			. ' where type = '
			. $this->_db->Quote(Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS)
			. ' or type = '
			. $this->_db->Quote(Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_WILDCARD)
			. ' or type = '
			. $this->_db->Quote(Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_CUSTOM);

		return $query;
	}

	private function _getPurgeQuerySelected()
	{
		// a 2 steps process : first collect those urls id we need
		// in accordance with select drop-down lists
		// then combine it with a delete query
		$options = null;
		$query = $this->_buildListQuery($options);

		// collect only the ids
		$queryIds = 'select t.id from (' . $query . ') as t';

		// start delete query
		$deleteQuery = 'delete from ' . $this->_db->quoteName($this->_getTableName()) . ' where id = any (' . $queryIds . ')';

		return $deleteQuery;
	}
}

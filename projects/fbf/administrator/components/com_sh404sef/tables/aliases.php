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

jimport('joomla.database.table');

class Sh404sefTableAliases extends JTable
{
	const URLTYPE_ALIAS = 0;
	const URLTYPE_ALIAS_WILDCARD = 1;
	const URLTYPE_ALIAS_CUSTOM = 2;

	/**
	 * Current row id
	 *
	 * @var   integer
	 * @access  public
	 */
	public $id = 0;

	/**
	 * Non-sef url associated with the alias
	 *
	 * @var   string
	 * @access  public
	 */
	public $newurl = '';

	/**
	 * Alias to the non-sef url associated with the alias
	 *
	 * @var   string
	 * @access  public
	 */
	public $alias = '';

	/**
	 * Type of alias
	 *
	 * Can be
	 *   Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS (=0) for a regular alias
	 *   Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_WILDCARD (=1) for an alias that has wildcard caracters
	 *   Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_CUSTOM (=2) for an alias that has wildcard caracters AND
	 * wildcard target: source-{*} -> target-{*}
	 * @var   integer
	 * @access  public
	 */
	public $type = self::URLTYPE_ALIAS;

	/**
	 * @var int Number of hits
	 */
	public $hits = 0;

	/**
	 * @var int redirect or canonical
	 */
	public $target_type = 0;

	/**
	 * @var int Ordering of aliases execution
	 */
	public $ordering = 0;

	/**
	 * @var int For future use: published state
	 */
	public $state = 1;

	/**
	 * Object constructor
	 *
	 * @access public
	 *
	 * @param object $db JDatabase object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__sh404sef_aliases', 'id', $db);
	}

	/**
	 * Pre-save checks
	 */
	public function check()
	{
		$this->newurl = JString::trim($this->newurl);
		if(empty($this->newurl))
		{
			$this->setError(
				JText::_('COM_SH404SEF_ALIASES_INVALID_ALIAS_EMPTY')
			);
			return false;
		}
		$this->alias = JString::trim($this->alias);
		if(empty($this->alias))
		{
			$this->setError(
				JText::_('COM_SH404SEF_ALIASES_INVALID_TARGET') . ' ' . JText::_('COM_SH404SEF_TT_CREATE_ALIAS_TARGET_URL_SPEC')
			);
			return false;
		}

		// condition : we can't have 2 records with same alias. So if user
		// wants to save a record with a pre-existing alias, this has to be
		// for the same non-sef url found in the existing record, or else
		// that's an error
		// if existing,

		$existingAlias = ShlDbHelper::selectObject(
			$this->_tbl,
			'*',
			array('alias' => $this->alias)
		);
		if (!empty($existingAlias) && (empty($this->id) || $this->id != $existingAlias->id))
		{
			$this->setError(JText::_('COM_SH404SEF_ALIAS_ALREADY_EXISTS'));
			return false;
		}

		// alias target can be a non-sef, but without wildcards
		if (
			wbStartsWith($this->newurl, 'index.php?')
			&&
			wbContains($this->newurl, Sh404sefModelRedirector::$aliasesWildcardsChars)
		)
		{

			$this->setError(
				JText::_('COM_SH404SEF_ALIASES_INVALID_TARGET') . ' ' . JText::_('COM_SH404SEF_TT_CREATE_ALIAS_TARGET_URL_SPEC')
			);
			return false;
		}

		return true;
	}

	public function bind($src, $ignore = array())
	{
		$result = parent::bind($src, $ignore);

		// adjust alias type based on content if user input
		if (wbStartsWith($this->newurl, array('http://', 'https://')))
		{
			$type = self::URLTYPE_ALIAS_CUSTOM;
		}
		else if (wbContains($this->alias, Sh404sefModelRedirector::$aliasesWildcardsChars))
		{
			$type = wbContains($this->newurl, Sh404sefModelRedirector::$aliasesWildcardsChars) ?
				self::URLTYPE_ALIAS_CUSTOM
				:
				self::URLTYPE_ALIAS_WILDCARD;
		}
		else
		{
			$type = self::URLTYPE_ALIAS;
		}

		$this->type = $type;

		return $result;
	}

	public function store($updateNulls = false)
	{
		//set ordering to max ordering
		if (empty($this->ordering))
		{
			$maxOrdering = ShlDbHelper::selectResult(
				'#__sh404sef_aliases',
				'ordering',
				'', array(),
				array(
					'ordering' => 'desc'
				)
			);
			$this->ordering = $maxOrdering + 1;
		}
		return parent::store($updateNulls);
	}

}

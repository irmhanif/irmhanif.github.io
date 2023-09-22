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

// No Permission
defined('_JEXEC') or die('Restricted Access');

// Database class, extends JDatabase
class AceDatabase {

	protected static $_dbo;

	protected function __construct() {
		self::$_dbo = self::getDBO();
	}

	public static function getInstance() {
		static $instance;
		
		if (!isset($instance)) {
			$instance = new AceDatabase();
		}

		return $instance;
	}

	public static function getDBO() {
		if (!isset(self::$_dbo)) {
			self::$_dbo = ShlDbHelper::getDb();
		}
	}
	
	//
	// Quote
	//
	public function quote($text, $escaped = true) {
		self::getDBO();
		$result = self::$_dbo->Quote($text, $escaped);
		
		self::showError();
	
		return $result;
	}
	
	//
	// Escape
	//
	public function getEscaped($text, $extra = false) {
		self::getDBO();
		$result = self::$_dbo->escape($text, $extra);
		
		self::showError();
	
		return $result;
	}
	
	//
	// Run
	//
	public function query($query) {
		// Run query
		self::getDBO();
		self::$_dbo->setQuery($query);
		$result = self::$_dbo->query();
		
		self::showError();
	
		return $result;
	}
	
	//
	// Single value result
	//
	public function loadResult($query) {
		// Run query
		self::getDBO();
		self::$_dbo->setQuery($query);
		$result = self::$_dbo->loadResult();
		
		self::showError();

		return $result;
	}
	
	//
	// Single row results
	//
	public function loadRow($query) {
		// Run query
		self::getDBO();
		self::$_dbo->setQuery($query);
		$result = self::$_dbo->loadRow();
		
		self::showError();

		return $result;
	}
	
	public function loadAssoc($query) {
		// Run query
		self::getDBO();
		self::$_dbo->setQuery($query);
		$result = self::$_dbo->loadAssoc();
		
		self::showError();

		return $result;
	}
	
	public function loadObject($query) {
		// Run query
		self::getDBO();
		self::$_dbo->setQuery($query);
		$result = self::$_dbo->loadObject();
		
		self::showError();

		return $result;
	}
	
	//
	// Single column results
	//
	public function loadResultArray($query, $index = 0) {
		// Run query
		self::getDBO();
		self::$_dbo->setQuery($query);
		$result = self::$_dbo->loadResultArray($index);
		
		self::showError();

		return $result;
	}

	//
	// Multi-Row results
	//
	public function loadRowList($query, $offset = 0, $limit = 0) {
		// Run query
		self::getDBO();
		self::$_dbo->setQuery($query, $offset, $limit);
		$result = self::$_dbo->loadRowList();
		
		self::showError();

		return $result;
	}
	
	public function loadAssocList($query, $key = '', $offset = 0, $limit = 0) {
		// Run query
		self::getDBO();
		self::$_dbo->setQuery($query, $offset, $limit);
		$result = self::$_dbo->loadAssocList($key);
		
		self::showError();

		return $result;
	}

	public function loadObjectList($query, $key = '', $offset = 0, $limit = 0) {
		// Run query
		self::getDBO();
		self::$_dbo->setQuery($query, $offset, $limit);
		$result = self::$_dbo->loadObjectList($key);
		
		self::showError();

		return $result;
	}
	
	protected function showError() {
		if (AcesefFactory::getConfig()->show_db_errors == 1) {
			if (self::$_dbo->getErrorNum()) {
				throw new Exception(__METHOD__.' failed. ('.self::$_dbo->getErrorMsg().')');
			}
		}
	}
}

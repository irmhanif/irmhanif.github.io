<?php
/**
 * Shlib - programming library
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2017
 * @package     shlib
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     0.3.1.661
 * @date        2018-01-15
 */
/* Security check to ensure this file is being included by a parent file.*/
defined('_JEXEC') or die;

/**
 * Generic log to database
 *
 * ShlDb_Log::log(
 *   'downloads',  // scope
 *    array(
 *       'name_1' => 'value_1',
 *       'name_2' => 'value_2',
 *       'name_3' => 'value_3',
 *       'name_4' => 'value_4',
 *       'name_5' => 'value_5',
 *       'name_6' => 'value_6',
 *    ),
 *    $user = null
 * );
 *
 * The values to use as index are defined at instance creation:
 *
 * ShlDb_Log::create(
 *   'downloads'  // scope
 *    array(      // indices
 *      'name_3',
 *      'name_5'
 *    )
 * );
 *
 * The indices (max 3) are listed when creating the logger. In this example,
 * assuming $data[..] is passed to be logged, then its values with keys name_3 and name_5
 * will be used as index, being stored in the, respectively, key_1 and key_2 columns
 * (the last key_3 column being left empty)
 *
 * Scope is used to identify the logger instance and thus db table to use.
 * When logging an item, a secondary scope is passed and stored in the scope column. That way, the same db table/logger
 * instance can host multiple data type - even though the key_1,key_2,key_3 will have to be the same. This is really
 * equivalent to having a 4rth index, mut more readable maybe?
 *
 */
class ShlDb_Log
{
	/**
	 * Default db table name
	 *
	 *
	 * CREATE TABLE `<table_name>`
	 * (
	 * `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	 * `scope` VARCHAR(180) NOT NULL,
	 * `description` VARCHAR(255) NOT NULL,
	 * `key_1` VARCHAR(180) NOT NULL,
	 * `key_2` VARCHAR(180) NOT NULL,
	 * `key_3` VARCHAR(180) NOT NULL,
	 * `data` LONGTEXT NOT NULL,
	 * `user_id` INT NOT NULL,
	 * `user_name` VARCHAR (100) NOT NULL,
	 * `user_email` VARCHAR (100) NOT NULL,
	 * `created_at`  DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
	 * );
	 * CREATE INDEX `scope` ON `<table_name>` (`scope`);
	 * CREATE INDEX `user_name` ON `<table_name>` (`user_name`);
	 * CREATE INDEX `key_1` ON `<table_name>` (`key_1`);
	 * CREATE INDEX `key_2` ON `<table_name>` (`key_2`);
	 * CREATE INDEX `key_3` ON `<table_name>` (`key_3`);
	 *
	 */

	/**
	 * Cache for current user id
	 *
	 * @var int
	 */
	protected $userId = null;

	/**
	 * Cache for current user email
	 *
	 * @var string
	 */
	protected $userEmail = '';

	/**
	 * Cache for current user name
	 *
	 * @var string
	 */
	protected $userName = '';

	/**
	 * The global scope name for this logger
	 *
	 * @var string
	 */
	protected $scope = '';

	/**
	 * An array listing data keys to be used as indexed data
	 *
	 * @var array
	 */
	protected $indices = array();

	/**
	 * @var string name of db table to hold keystore values
	 */
	protected $tableName = '';

	/**
	 * Singleton
	 *
	 * @var ShlDbKeystore
	 */
	private static $instance = array();

	/**
	 * Public creation method for a logger
	 *
	 * @param string $scope Name of logger, used to derive table name
	 * @param array  $indices List of data keys to be used as index
	 *
	 * @return ShlDbKeystore
	 */
	public static function create($scope, $indices = array())
	{
		if (empty(self::$instance[$scope]))
		{
			self::$instance[$scope] = new self(
				$scope,
				$indices
			);
		}

		return self::$instance[$scope];
	}

	/**
	 * Store parameters for the logger
	 *
	 * @param $scope
	 * @param $indices
	 */
	protected function __construct($rawScope, $indices)
	{
		if (empty($rawScope))
		{
			$message = 'Trying to create a database logger with an empty scope.';
			ShlSystem_Log::error('shLib', __METHOD__ . ': shLib: ' . $message);
			throw new InvalidArgumentException(
				$message
			);
		}
		$this->scope = $rawScope;
		$this->tableName = '#__wbl_log_' . preg_replace('/[^a-zA-Z0-9_-]+/', '', $this->scope);
		$this->indices = $indices;
	}

	/**
	 * Get a specific instance of a logger
	 *
	 * @param string $scope
	 *
	 * @return ShlDb_Log
	 *
	 * @throws InvalidArgumentException
	 */
	protected static function get($scope)
	{
		if (empty(self::$instance[$scope]))
		{
			ShlSystem_Log::error('shLib', __METHOD__ . ': shLib: Trying to log to a database logger (' . $scope . ') that has not yet been created.');
			return false;
		}

		return self::$instance[$scope];
	}

	/**
	 *
	 * ShlDb_Log::log(
	 *   'downloads',
	 *    array(
	 *       'name_1' => 'value_1',
	 *       'name_2' => 'value_2',
	 *       'name_3' => 'value_3',
	 *       'name_4' => 'value_4',
	 *       'name_5' => 'value_5',
	 *       'name_6' => 'value_6',
	 *    )
	 * );
	 *
	 * The values to use as index are defined at instance creation
	 *
	 * @param string    $subScope
	 * @param string    $description
	 * @param mixed     $data
	 * @param int|JUser $user Id or user object of the requester. Default to current user of not provided
	 */
	public function log(
		$subScope,
		$description,
		$data,
		$user = null
	)
	{
		// get logger, fail immediately if not created
		// this is logged by the get() method
		$logger = self::get($this->scope);
		if (empty($logger))
		{
			return false;
		}

		$written = $logger->write(
			$subScope,
			$description,
			$data,
			$user
		);

		return $written;
	}

	/**
	 * Internal method to write a log record to database
	 *
	 * @params string $subScope The scope for this specific item
	 * @param string $description
	 * @param mixed  $data Object or Array of data
	 */
	protected function write($subScope, $description, $data, $user)
	{
		$dbData = array(
			'scope' => $subScope,
			'description' => $description,
			'data' => json_encode($data),
			'created_at' => ShlSystem_Date::getUTCNow(),
			'timestamp' => $this->getTimestamp()
		);

		$dbData = array_merge(
			$dbData,
			$this->getUserData($user),
			$this->getIndices($data)
		);

		// insert or update the record in database
		ShlDbHelper::insert(
			$this->tableName,
			$dbData
		);
	}

	/**
	 * Builds an array of user data, to be stored. If not user is provided
	 * then currently logged in one is used
	 *
	 * @param int|JUser $user
	 *
	 * @return array
	 */
	protected function getUserData($user)
	{
		if (!is_object($user))
		{
			// getUser requires a real NULL to fetch current user
			$user = empty($user) ? null : (int) $user;
			$user = JFactory::getUser($user);
		}

		if (empty($user) || empty($user->id))
		{
			$userData = array(
				'user_id' => '0',
				'user_name' => 'n/a',
				'user_email' => 'n/a',
			);
		}
		else
		{
			$userData = array(
				'user_id' => $user->id,
				'user_name' => $user->email,
				'user_email' => $user->username,
			);
		}

		return $userData;
	}

	/**
	 * Finds the data set indexable properties and prepare an array
	 * with them, ready to be written to database
	 *
	 * @param mixed $data
	 *
	 * @return array
	 */
	protected function getIndices($data)
	{
		$indices = array();

		for ($counter = 0; $counter < 3; $counter++)
		{
			$value = '';
			$keyName = wbArrayGet($this->indices, $counter, '');
			if (!empty($keyName))
			{
				if (is_array($data))
				{
					$value = wbArrayGet($data, $keyName, '');
				}
				else if (is_object($data))
				{
					$value = empty($data->{$keyName}) ? '' : $data->{$keyName};
				}
			}

			$indices['key_' . ($counter + 1)] = $value;
		}

		return $indices;
	}

	private function getTimestamp()
	{
		$t = microtime();
		$timestamp = substr($t, 11) + substr($t, 0, 9);
		return $timestamp;
	}
}

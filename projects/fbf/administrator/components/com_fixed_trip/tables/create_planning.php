<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_trip
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;
/**
 * create_planning Table class
 *
 * @since  1.6
 */
class Fixed_tripTablecreate_planning extends JTable
{
	
	/**
	 * Constructor
	 *
	 * @param   JDatabase  &$db  A database connector object
	 */
	public function __construct(&$db)
	{
		JObserverMapper::addObserverClassToClass('JTableObserverContenthistory', 'Fixed_tripTablecreate_planning', array('typeAlias' => 'com_fixed_trip.create_planning'));
		parent::__construct('#__fixed_trip_planning', 'id', $db);
	}

	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param   array  $array   Named array
	 * @param   mixed  $ignore  Optional array or list of parameters to ignore
	 *
	 * @return  null|string  null is operation was satisfactory, otherwise returns an error
	 *
	 * @see     JTable:bind
	 * @since   1.5
	 */
	public function bind($array, $ignore = '')
	{
	    $date = JFactory::getDate();
		$task = JFactory::getApplication()->input->get('task');
	    
		$input = JFactory::getApplication()->input;
		$task = $input->getString('task', '');

		if ($array['id'] == 0 && empty($array['created_by']))
		{
			$array['created_by'] = JFactory::getUser()->id;
		}

		if ($array['id'] == 0 && empty($array['modified_by']))
		{
			$array['modified_by'] = JFactory::getUser()->id;
		}

		if ($task == 'apply' || $task == 'save')
		{
			$array['modified_by'] = JFactory::getUser()->id;
		}

		// Support for multiple field: days1
		if (isset($array['days1']))
		{
			if (is_array($array['days1']))
			{
				$array['days1'] = implode(',',$array['days1']);
			}
			elseif (strpos($array['days1'], ',') != false)
			{
				$array['days1'] = explode(',',$array['days1']);
			}
			elseif (strlen($array['days1']) == 0)
			{
				$array['days1'] = '';
			}
		}
		else
		{
			$array['days1'] = '';
		}

		// Support for multiple field: days2
		if (isset($array['days2']))
		{
			if (is_array($array['days2']))
			{
				$array['days2'] = implode(',',$array['days2']);
			}
			elseif (strpos($array['days2'], ',') != false)
			{
				$array['days2'] = explode(',',$array['days2']);
			}
			elseif (strlen($array['days2']) == 0)
			{
				$array['days2'] = '';
			}
		}
		else
		{
			$array['days2'] = '';
		}

		// Support for multiple field: days3
		if (isset($array['days3']))
		{
			if (is_array($array['days3']))
			{
				$array['days3'] = implode(',',$array['days3']);
			}
			elseif (strpos($array['days3'], ',') != false)
			{
				$array['days3'] = explode(',',$array['days3']);
			}
			elseif (strlen($array['days3']) == 0)
			{
				$array['days3'] = '';
			}
		}
		else
		{
			$array['days3'] = '';
		}

		// Support for multiple field: days4
		if (isset($array['days4']))
		{
			if (is_array($array['days4']))
			{
				$array['days4'] = implode(',',$array['days4']);
			}
			elseif (strpos($array['days4'], ',') != false)
			{
				$array['days4'] = explode(',',$array['days4']);
			}
			elseif (strlen($array['days4']) == 0)
			{
				$array['days4'] = '';
			}
		}
		else
		{
			$array['days4'] = '';
		}

		// Support for multiple field: days5
		if (isset($array['days5']))
		{
			if (is_array($array['days5']))
			{
				$array['days5'] = implode(',',$array['days5']);
			}
			elseif (strpos($array['days5'], ',') != false)
			{
				$array['days5'] = explode(',',$array['days5']);
			}
			elseif (strlen($array['days5']) == 0)
			{
				$array['days5'] = '';
			}
		}
		else
		{
			$array['days5'] = '';
		}

		// Support for multiple field: days6
		if (isset($array['days6']))
		{
			if (is_array($array['days6']))
			{
				$array['days6'] = implode(',',$array['days6']);
			}
			elseif (strpos($array['days6'], ',') != false)
			{
				$array['days6'] = explode(',',$array['days6']);
			}
			elseif (strlen($array['days6']) == 0)
			{
				$array['days6'] = '';
			}
		}
		else
		{
			$array['days6'] = '';
		}

		// Support for multiple field: days7
		if (isset($array['days7']))
		{
			if (is_array($array['days7']))
			{
				$array['days7'] = implode(',',$array['days7']);
			}
			elseif (strpos($array['days7'], ',') != false)
			{
				$array['days7'] = explode(',',$array['days7']);
			}
			elseif (strlen($array['days7']) == 0)
			{
				$array['days7'] = '';
			}
		}
		else
		{
			$array['days7'] = '';
		}

		// Support for multiple field: days8
		if (isset($array['days8']))
		{
			if (is_array($array['days8']))
			{
				$array['days8'] = implode(',',$array['days8']);
			}
			elseif (strpos($array['days8'], ',') != false)
			{
				$array['days8'] = explode(',',$array['days8']);
			}
			elseif (strlen($array['days8']) == 0)
			{
				$array['days8'] = '';
			}
		}
		else
		{
			$array['days8'] = '';
		}

		// Support for multiple field: days9
		if (isset($array['days9']))
		{
			if (is_array($array['days9']))
			{
				$array['days9'] = implode(',',$array['days9']);
			}
			elseif (strpos($array['days9'], ',') != false)
			{
				$array['days9'] = explode(',',$array['days9']);
			}
			elseif (strlen($array['days9']) == 0)
			{
				$array['days9'] = '';
			}
		}
		else
		{
			$array['days9'] = '';
		}

		// Support for multiple field: days10
		if (isset($array['days10']))
		{
			if (is_array($array['days10']))
			{
				$array['days10'] = implode(',',$array['days10']);
			}
			elseif (strpos($array['days10'], ',') != false)
			{
				$array['days10'] = explode(',',$array['days10']);
			}
			elseif (strlen($array['days10']) == 0)
			{
				$array['days10'] = '';
			}
		}
		else
		{
			$array['days10'] = '';
		}

		// Support for multiple field: days11
		if (isset($array['days11']))
		{
			if (is_array($array['days11']))
			{
				$array['days11'] = implode(',',$array['days11']);
			}
			elseif (strpos($array['days11'], ',') != false)
			{
				$array['days11'] = explode(',',$array['days11']);
			}
			elseif (strlen($array['days11']) == 0)
			{
				$array['days11'] = '';
			}
		}
		else
		{
			$array['days11'] = '';
		}

		// Support for multiple field: days12
		if (isset($array['days12']))
		{
			if (is_array($array['days12']))
			{
				$array['days12'] = implode(',',$array['days12']);
			}
			elseif (strpos($array['days12'], ',') != false)
			{
				$array['days12'] = explode(',',$array['days12']);
			}
			elseif (strlen($array['days12']) == 0)
			{
				$array['days12'] = '';
			}
		}
		else
		{
			$array['days12'] = '';
		}

		// Support for multiple field: days13
		if (isset($array['days13']))
		{
			if (is_array($array['days13']))
			{
				$array['days13'] = implode(',',$array['days13']);
			}
			elseif (strpos($array['days13'], ',') != false)
			{
				$array['days13'] = explode(',',$array['days13']);
			}
			elseif (strlen($array['days13']) == 0)
			{
				$array['days13'] = '';
			}
		}
		else
		{
			$array['days13'] = '';
		}

		// Support for multiple field: days14
		if (isset($array['days14']))
		{
			if (is_array($array['days14']))
			{
				$array['days14'] = implode(',',$array['days14']);
			}
			elseif (strpos($array['days14'], ',') != false)
			{
				$array['days14'] = explode(',',$array['days14']);
			}
			elseif (strlen($array['days14']) == 0)
			{
				$array['days14'] = '';
			}
		}
		else
		{
			$array['days14'] = '';
		}

		// Support for multiple field: days15
		if (isset($array['days15']))
		{
			if (is_array($array['days15']))
			{
				$array['days15'] = implode(',',$array['days15']);
			}
			elseif (strpos($array['days15'], ',') != false)
			{
				$array['days15'] = explode(',',$array['days15']);
			}
			elseif (strlen($array['days15']) == 0)
			{
				$array['days15'] = '';
			}
		}
		else
		{
			$array['days15'] = '';
		}

		// Support for multiple field: days16
		if (isset($array['days16']))
		{
			if (is_array($array['days16']))
			{
				$array['days16'] = implode(',',$array['days16']);
			}
			elseif (strpos($array['days16'], ',') != false)
			{
				$array['days16'] = explode(',',$array['days16']);
			}
			elseif (strlen($array['days16']) == 0)
			{
				$array['days16'] = '';
			}
		}
		else
		{
			$array['days16'] = '';
		}

		// Support for multiple field: days17
		if (isset($array['days17']))
		{
			if (is_array($array['days17']))
			{
				$array['days17'] = implode(',',$array['days17']);
			}
			elseif (strpos($array['days17'], ',') != false)
			{
				$array['days17'] = explode(',',$array['days17']);
			}
			elseif (strlen($array['days17']) == 0)
			{
				$array['days17'] = '';
			}
		}
		else
		{
			$array['days17'] = '';
		}

		// Support for multiple field: days18
		if (isset($array['days18']))
		{
			if (is_array($array['days18']))
			{
				$array['days18'] = implode(',',$array['days18']);
			}
			elseif (strpos($array['days18'], ',') != false)
			{
				$array['days18'] = explode(',',$array['days18']);
			}
			elseif (strlen($array['days18']) == 0)
			{
				$array['days18'] = '';
			}
		}
		else
		{
			$array['days18'] = '';
		}

		// Support for multiple field: days19
		if (isset($array['days19']))
		{
			if (is_array($array['days19']))
			{
				$array['days19'] = implode(',',$array['days19']);
			}
			elseif (strpos($array['days19'], ',') != false)
			{
				$array['days19'] = explode(',',$array['days19']);
			}
			elseif (strlen($array['days19']) == 0)
			{
				$array['days19'] = '';
			}
		}
		else
		{
			$array['days19'] = '';
		}

		// Support for multiple field: days20
		if (isset($array['days20']))
		{
			if (is_array($array['days20']))
			{
				$array['days20'] = implode(',',$array['days20']);
			}
			elseif (strpos($array['days20'], ',') != false)
			{
				$array['days20'] = explode(',',$array['days20']);
			}
			elseif (strlen($array['days20']) == 0)
			{
				$array['days20'] = '';
			}
		}
		else
		{
			$array['days20'] = '';
		}

		if (isset($array['params']) && is_array($array['params']))
		{
			$registry = new JRegistry;
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata']))
		{
			$registry = new JRegistry;
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}

		if (!JFactory::getUser()->authorise('core.admin', 'com_fixed_trip.create_planning.' . $array['id']))
		{
			$actions         = JAccess::getActionsFromFile(
				JPATH_ADMINISTRATOR . '/components/com_fixed_trip/access.xml',
				"/access/section[@name='create_planning']/"
			);
			$default_actions = JAccess::getAssetRules('com_fixed_trip.create_planning.' . $array['id'])->getData();
			$array_jaccess   = array();

			foreach ($actions as $action)
			{
                if (key_exists($action->name, $default_actions))
                {
                    $array_jaccess[$action->name] = $default_actions[$action->name];
                }
			}

			$array['rules'] = $this->JAccessRulestoArray($array_jaccess);
		}

		// Bind the rules for ACL where supported.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$this->setRules($array['rules']);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * This function convert an array of JAccessRule objects into an rules array.
	 *
	 * @param   array  $jaccessrules  An array of JAccessRule objects.
	 *
	 * @return  array
	 */
	private function JAccessRulestoArray($jaccessrules)
	{
		$rules = array();

		foreach ($jaccessrules as $action => $jaccess)
		{
			$actions = array();

			if ($jaccess)
			{
				foreach ($jaccess->getData() as $group => $allow)
				{
					$actions[$group] = ((bool)$allow);
				}
			}

			$rules[$action] = $actions;
		}

		return $rules;
	}

	/**
	 * Overloaded check function
	 *
	 * @return bool
	 */
	public function check()
	{
		// If there is an ordering column and this is a new row then get the next ordering value
		if (property_exists($this, 'ordering') && $this->id == 0)
		{
			$this->ordering = self::getNextOrder();
		}
		
		

		return parent::check();
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param   mixed    $pks     An optional array of primary key values to update.  If not
	 *                            set the instance property value is used.
	 * @param   integer  $state   The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param   integer  $userId  The user id of the user performing the operation.
	 *
	 * @return   boolean  True on success.
	 *
	 * @since    1.0.4
	 *
	 * @throws Exception
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		ArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k)
			{
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else
			{
				throw new Exception(500, JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
			}
		}

		// Build the WHERE clause for the primary keys.
		$where = $k . '=' . implode(' OR ' . $k . '=', $pks);

		// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time'))
		{
			$checkin = '';
		}
		else
		{
			$checkin = ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
		}

		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE `' . $this->_tbl . '`' .
			' SET `state` = ' . (int) $state .
			' WHERE (' . $where . ')' .
			$checkin
		);
		$this->_db->execute();

		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
		{
			// Checkin each row.
			foreach ($pks as $pk)
			{
				$this->checkin($pk);
			}
		}

		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks))
		{
			$this->state = $state;
		}

		return true;
	}

	/**
	 * Define a namespaced asset name for inclusion in the #__assets table
	 *
	 * @return string The asset name
	 *
	 * @see JTable::_getAssetName
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return 'com_fixed_trip.create_planning.' . (int) $this->$k;
	}

	/**
	 * Returns the parent asset's id. If you have a tree structure, retrieve the parent's id using the external key field
	 *
	 * @param   JTable   $table  Table name
	 * @param   integer  $id     Id
	 *
	 * @see JTable::_getAssetParentId
	 *
	 * @return mixed The id on success, false on failure.
	 */
	protected function _getAssetParentId(JTable $table = null, $id = null)
	{
		// We will retrieve the parent-asset from the Asset-table
		$assetParent = JTable::getInstance('Asset');

		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();

		// The item has the component as asset-parent
		$assetParent->loadByName('com_fixed_trip');

		// Return the found asset-parent-id
		if ($assetParent->id)
		{
			$assetParentId = $assetParent->id;
		}

		return $assetParentId;
	}

	/**
	 * Delete a record by id
	 *
	 * @param   mixed  $pk  Primary key value to delete. Optional
	 *
	 * @return bool
	 */
	public function delete($pk = null)
	{
		$this->load($pk);
		$result = parent::delete($pk);
		
		return $result;
	}
}

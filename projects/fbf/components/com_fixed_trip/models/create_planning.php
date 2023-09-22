<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_trip
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

use Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;

/**
 * Fixed_trip model.
 *
 * @since  1.6
 */
class Fixed_tripModelCreate_planning extends JModelItem
{
    public $_item;

        
    
        
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return void
	 *
	 * @since    1.6
	 *
	 */
	protected function populateState()
	{
		$app  = Factory::getApplication('com_fixed_trip');
		$user = Factory::getUser();

		// Check published state
		if ((!$user->authorise('core.edit.state', 'com_fixed_trip')) && (!$user->authorise('core.edit', 'com_fixed_trip')))
		{
			$this->setState('filter.published', 1);
			$this->setState('filter.archived', 2);
		}

		// Load state from the request userState on edit or from the passed variable on default
		if (Factory::getApplication()->input->get('layout') == 'edit')
		{
			$id = Factory::getApplication()->getUserState('com_fixed_trip.edit.create_planning.id');
		}
		else
		{
			$id = Factory::getApplication()->input->get('id');
			Factory::getApplication()->setUserState('com_fixed_trip.edit.create_planning.id', $id);
		}

		$this->setState('create_planning.id', $id);

		// Load the parameters.
		$params       = $app->getParams();
		$params_array = $params->toArray();

		if (isset($params_array['item_id']))
		{
			$this->setState('create_planning.id', $params_array['item_id']);
		}

		$this->setState('params', $params);
	}

	/**
	 * Method to get an object.
	 *
	 * @param   integer $id The id of the object to get.
	 *
	 * @return  mixed    Object on success, false on failure.
     *
     * @throws Exception
	 */
	public function getItem($id = null)
	{
            if ($this->_item === null)
            {
                $this->_item = false;

                if (empty($id))
                {
                    $id = $this->getState('create_planning.id');
                }

                // Get a level row instance.
                $table = $this->getTable();

                // Attempt to load the row.
                if ($table->load($id))
                {
                    

                    // Check published state.
                    if ($published = $this->getState('filter.published'))
                    {
                        if (isset($table->state) && $table->state != $published)
                        {
                            throw new Exception(JText::_('COM_FIXED_TRIP_ITEM_NOT_LOADED'), 403);
                        }
                    }

                    // Convert the JTable to a clean JObject.
                    $properties  = $table->getProperties(1);
                    $this->_item = ArrayHelper::toObject($properties, 'JObject');

                    
                } 
            }
        
            

		if (isset($this->_item->created_by))
		{
			$this->_item->created_by_name = Factory::getUser($this->_item->created_by)->name;
		}

		if (isset($this->_item->modified_by))
		{
			$this->_item->modified_by_name = Factory::getUser($this->_item->modified_by)->name;
		}

		if (!empty($this->_item->days1))
		{
			$this->_item->days1 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS1_OPTION_' . $this->_item->days1);
		}

		if (!empty($this->_item->days2))
		{
			$this->_item->days2 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS2_OPTION_' . $this->_item->days2);
		}

		if (!empty($this->_item->days3))
		{
			$this->_item->days3 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS3_OPTION_' . $this->_item->days3);
		}

		if (!empty($this->_item->days4))
		{
			$this->_item->days4 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS4_OPTION_' . $this->_item->days4);
		}

		if (!empty($this->_item->days5))
		{
			$this->_item->days5 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS5_OPTION_' . $this->_item->days5);
		}

		if (!empty($this->_item->days6))
		{
			$this->_item->days6 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS6_OPTION_' . $this->_item->days6);
		}

		if (!empty($this->_item->days7))
		{
			$this->_item->days7 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS7_OPTION_' . $this->_item->days7);
		}

		if (!empty($this->_item->days8))
		{
			$this->_item->days8 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS8_OPTION_' . $this->_item->days8);
		}

		if (!empty($this->_item->days9))
		{
			$this->_item->days9 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS9_OPTION_' . $this->_item->days9);
		}

		if (!empty($this->_item->days10))
		{
			$this->_item->days10 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS10_OPTION_' . $this->_item->days10);
		}

		if (!empty($this->_item->days11))
		{
			$this->_item->days11 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS11_OPTION_' . $this->_item->days11);
		}

		if (!empty($this->_item->days12))
		{
			$this->_item->days12 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS12_OPTION_' . $this->_item->days12);
		}

		if (!empty($this->_item->days13))
		{
			$this->_item->days13 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS13_OPTION_' . $this->_item->days13);
		}

		if (!empty($this->_item->days14))
		{
			$this->_item->days14 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS14_OPTION_' . $this->_item->days14);
		}

		if (!empty($this->_item->days15))
		{
			$this->_item->days15 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS15_OPTION_' . $this->_item->days15);
		}

		if (!empty($this->_item->days16))
		{
			$this->_item->days16 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS16_OPTION_' . $this->_item->days16);
		}

		if (!empty($this->_item->days17))
		{
			$this->_item->days17 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS17_OPTION_' . $this->_item->days17);
		}

		if (!empty($this->_item->days18))
		{
			$this->_item->days18 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS18_OPTION_' . $this->_item->days18);
		}

		if (!empty($this->_item->days19))
		{
			$this->_item->days19 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS19_OPTION_' . $this->_item->days19);
		}

		if (!empty($this->_item->days20))
		{
			$this->_item->days20 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS20_OPTION_' . $this->_item->days20);
		}

            return $this->_item;
        }

	/**
	 * Get an instance of JTable class
	 *
	 * @param   string $type   Name of the JTable class to get an instance of.
	 * @param   string $prefix Prefix for the table class name. Optional.
	 * @param   array  $config Array of configuration values for the JTable object. Optional.
	 *
	 * @return  JTable|bool JTable if success, false on failure.
	 */
	public function getTable($type = 'Create_planning', $prefix = 'Fixed_tripTable', $config = array())
	{
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_fixed_trip/tables');

		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Get the id of an item by alias
	 *
	 * @param   string $alias Item alias
	 *
	 * @return  mixed
	 */
	public function getItemIdByAlias($alias)
	{
            $table      = $this->getTable();
            $properties = $table->getProperties();
            $result     = null;

            if (key_exists('alias', $properties))
            {
                $table->load(array('alias' => $alias));
                $result = $table->id;
            }
            
                return $result;
            
	}

	/**
	 * Method to check in an item.
	 *
	 * @param   integer $id The id of the row to check out.
	 *
	 * @return  boolean True on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function checkin($id = null)
	{
		// Get the id.
		$id = (!empty($id)) ? $id : (int) $this->getState('create_planning.id');
                
		if ($id)
		{
			// Initialise the table
			$table = $this->getTable();

			// Attempt to check the row in.
			if (method_exists($table, 'checkin'))
			{
				if (!$table->checkin($id))
				{
					return false;
				}
			}
		}

		return true;
                
	}

	/**
	 * Method to check out an item for editing.
	 *
	 * @param   integer $id The id of the row to check out.
	 *
	 * @return  boolean True on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function checkout($id = null)
	{
		// Get the user id.
		$id = (!empty($id)) ? $id : (int) $this->getState('create_planning.id');

                
		if ($id)
		{
			// Initialise the table
			$table = $this->getTable();

			// Get the current user object.
			$user = Factory::getUser();

			// Attempt to check the row out.
			if (method_exists($table, 'checkout'))
			{
				if (!$table->checkout($user->get('id'), $id))
				{
					return false;
				}
			}
		}

		return true;
                
	}

	/**
	 * Publish the element
	 *
	 * @param   int $id    Item id
	 * @param   int $state Publish state
	 *
	 * @return  boolean
	 */
	public function publish($id, $state)
	{
		$table = $this->getTable();
                
		$table->load($id);
		$table->state = $state;

		return $table->store();
                
	}

	/**
	 * Method to delete an item
	 *
	 * @param   int $id Element id
	 *
	 * @return  bool
	 */
	public function delete($id)
	{
		$table = $this->getTable();

                
                    return $table->delete($id);
                
	}

	
}

<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Document
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2019 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Document model.
 *
 * @since  1.6
 */
class DocumentModelCommunication extends JModelAdmin
{
	/**
	 * @var      string    The prefix to use with controller messages.
	 * @since    1.6
	 */
	protected $text_prefix = 'COM_DOCUMENT';

	/**
	 * @var   	string  	Alias to manage history control
	 * @since   3.2
	 */
	public $typeAlias = 'com_document.communication';

	/**
	 * @var null  Item data
	 * @since  1.6
	 */
	protected $item = null;

        
        
        
        
        
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return    JTable    A database object
	 *
	 * @since    1.6
	 */
	public function getTable($type = 'Communication', $prefix = 'DocumentTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      An optional array of data for the form to interogate.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  JForm  A JForm object on success, false on failure
	 *
	 * @since    1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
            // Initialise variables.
            $app = JFactory::getApplication();

            // Get the form.
            $form = $this->loadForm(
                    'com_document.communication', 'communication',
                    array('control' => 'jform',
                            'load_data' => $loadData
                    )
            );

            

            if (empty($form))
            {
                return false;
            }

            return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return   mixed  The data for the form.
	 *
	 * @since    1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_document.edit.communication.data', array());

		if (empty($data))
		{
			if ($this->item === null)
			{
				$this->item = $this->getItem();
			}

			$data = $this->item;
                        

			// Support for multiple or not foreign key field: user_id
			$array = array();

			foreach ((array) $data->user_id as $value)
			{
				if (!is_array($value))
				{
					$array[] = $value;
				}
			}
			if(!empty($array)){

			$data->user_id = $array;
			}

			// Support for multiple or not foreign key field: quote
			$array = array();

			foreach ((array) $data->quote as $value)
			{
				if (!is_array($value))
				{
					$array[] = $value;
				}
			}
			if(!empty($array)){

			$data->quote = $array;
			}
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed    Object on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function getItem($pk = null)
	{
            
            if ($item = parent::getItem($pk))
            {
                // Do any procesing on fields here if needed
            }

            return $item;
            
	}

	/**
	 * Method to duplicate an Communication
	 *
	 * @param   array  &$pks  An array of primary key IDs.
	 *
	 * @return  boolean  True if successful.
	 *
	 * @throws  Exception
	 */
	public function duplicate(&$pks)
	{
		$user = JFactory::getUser();

		// Access checks.
		if (!$user->authorise('core.create', 'com_document'))
		{
			throw new Exception(JText::_('JERROR_CORE_CREATE_NOT_PERMITTED'));
		}

		$dispatcher = JEventDispatcher::getInstance();
		$context    = $this->option . '.' . $this->name;

		// Include the plugins for the save events.
		JPluginHelper::importPlugin($this->events_map['save']);

		$table = $this->getTable();

		foreach ($pks as $pk)
		{
                    
			if ($table->load($pk, true))
			{
				// Reset the id to create a new record.
				$table->id = 0;

				if (!$table->check())
				{
					throw new Exception($table->getError());
				}
				
				if (!empty($table->document1))
				{
					if (is_array($table->document1))
					{
						$table->document1 = implode(',', $table->document1);
					}
				}
				else
				{
					$table->document1 = '';
				}

				if (!empty($table->document2))
				{
					if (is_array($table->document2))
					{
						$table->document2 = implode(',', $table->document2);
					}
				}
				else
				{
					$table->document2 = '';
				}

				if (!empty($table->document3))
				{
					if (is_array($table->document3))
					{
						$table->document3 = implode(',', $table->document3);
					}
				}
				else
				{
					$table->document3 = '';
				}

				if (!empty($table->document4))
				{
					if (is_array($table->document4))
					{
						$table->document4 = implode(',', $table->document4);
					}
				}
				else
				{
					$table->document4 = '';
				}

				if (!empty($table->document5))
				{
					if (is_array($table->document5))
					{
						$table->document5 = implode(',', $table->document5);
					}
				}
				else
				{
					$table->document5 = '';
				}

				if (!empty($table->document6))
				{
					if (is_array($table->document6))
					{
						$table->document6 = implode(',', $table->document6);
					}
				}
				else
				{
					$table->document6 = '';
				}

				if (!empty($table->document7))
				{
					if (is_array($table->document7))
					{
						$table->document7 = implode(',', $table->document7);
					}
				}
				else
				{
					$table->document7 = '';
				}

				if (!empty($table->document8))
				{
					if (is_array($table->document8))
					{
						$table->document8 = implode(',', $table->document8);
					}
				}
				else
				{
					$table->document8 = '';
				}

				if (!empty($table->document9))
				{
					if (is_array($table->document9))
					{
						$table->document9 = implode(',', $table->document9);
					}
				}
				else
				{
					$table->document9 = '';
				}

				if (!empty($table->document10))
				{
					if (is_array($table->document10))
					{
						$table->document10 = implode(',', $table->document10);
					}
				}
				else
				{
					$table->document10 = '';
				}


				// Trigger the before save event.
				$result = $dispatcher->trigger($this->event_before_save, array($context, &$table, true));

				if (in_array(false, $result, true) || !$table->store())
				{
					throw new Exception($table->getError());
				}

				// Trigger the after save event.
				$dispatcher->trigger($this->event_after_save, array($context, &$table, true));
			}
			else
			{
				throw new Exception($table->getError());
			}
                    
		}

		// Clean cache
		$this->cleanCache();

		return true;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @param   JTable  $table  Table Object
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			if (@$table->ordering === '')
			{
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__document_communication');
				$max             = $db->loadResult();
				$table->ordering = $max + 1;
			}
		}
	}
}

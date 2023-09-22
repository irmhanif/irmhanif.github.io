<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_trip
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Fixed_trip records.
 *
 * @since  1.6
 */
class Fixed_tripModelCreate_plannings extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see        JController
	 * @since      1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'ordering', 'a.ordering',
				'state', 'a.state',
				'created_by', 'a.created_by',
				'modified_by', 'a.modified_by',
				'reference', 'a.reference',
				'title', 'a.title',
				'days1', 'a.days1',
				'days2', 'a.days2',
				'days3', 'a.days3',
				'days4', 'a.days4',
				'days5', 'a.days5',
				'days6', 'a.days6',
				'days7', 'a.days7',
				'days8', 'a.days8',
				'days9', 'a.days9',
				'days10', 'a.days10',
				'days11', 'a.days11',
				'days12', 'a.days12',
				'days13', 'a.days13',
				'days14', 'a.days14',
				'days15', 'a.days15',
				'days16', 'a.days16',
				'days17', 'a.days17',
				'days18', 'a.days18',
				'days19', 'a.days19',
				'days20', 'a.days20',
			);
		}

		parent::__construct($config);
	}

        
        
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 *
	 * @since    1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
            $app  = Factory::getApplication();
		$list = $app->getUserState($this->context . '.list');

		$ordering  = isset($list['filter_order'])     ? $list['filter_order']     : null;
		$direction = isset($list['filter_order_Dir']) ? $list['filter_order_Dir'] : null;

		$list['limit']     = (int) Factory::getConfig()->get('list_limit', 20);
		$list['start']     = $app->input->getInt('start', 0);
		$list['ordering']  = $ordering;
		$list['direction'] = $direction;

		$app->setUserState($this->context . '.list', $list);
		$app->input->set('list', null);

            // List state information.
            parent::populateState($ordering, $direction);

            $app = Factory::getApplication();

            $ordering  = $app->getUserStateFromRequest($this->context . '.ordercol', 'filter_order', $ordering);
            $direction = $app->getUserStateFromRequest($this->context . '.orderdirn', 'filter_order_Dir', $ordering);

            $this->setState('list.ordering', $ordering);
            $this->setState('list.direction', $direction);

            $start = $app->getUserStateFromRequest($this->context . '.limitstart', 'limitstart', 0, 'int');
            $limit = $app->getUserStateFromRequest($this->context . '.limit', 'limit', 0, 'int');

            if ($limit == 0)
            {
                $limit = $app->get('list_limit', 0);
            }

            $this->setState('list.limit', $limit);
            $this->setState('list.start', $start);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
            // Create a new query object.
            $db    = $this->getDbo();
            $query = $db->getQuery(true);

            // Select the required fields from the table.
            $query->select(
                        $this->getState(
                                'list.select', 'DISTINCT a.*'
                        )
                );

            $query->from('`#__fixed_trip_planning` AS a');
            
		// Join over the users for the checked out user.
		$query->select('uc.name AS uEditor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		// Join over the created by field 'modified_by'
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
            
		if (!Factory::getUser()->authorise('core.edit', 'com_fixed_trip'))
		{
			$query->where('a.state = 1');
		}

            // Filter by search in title
            $search = $this->getState('filter.search');

            if (!empty($search))
            {
                if (stripos($search, 'id:') === 0)
                {
                    $query->where('a.id = ' . (int) substr($search, 3));
                }
                else
                {
                    $search = $db->Quote('%' . $db->escape($search, true) . '%');
                }
            }
            

            // Add the list ordering clause.
            $orderCol  = $this->state->get('list.ordering', "a.id");
            $orderDirn = $this->state->get('list.direction', "ASC");

            if ($orderCol && $orderDirn)
            {
                $query->order($db->escape($orderCol . ' ' . $orderDirn));
            }

            return $query;
	}

	/**
	 * Method to get an array of data items
	 *
	 * @return  mixed An array of data on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
		
		foreach ($items as $item)
		{

			$item->days1 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS1_OPTION_' . strtoupper($item->days1));

			$item->days2 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS2_OPTION_' . strtoupper($item->days2));

			$item->days3 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS3_OPTION_' . strtoupper($item->days3));

			$item->days4 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS4_OPTION_' . strtoupper($item->days4));

			$item->days5 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS5_OPTION_' . strtoupper($item->days5));

			$item->days6 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS6_OPTION_' . strtoupper($item->days6));

			$item->days7 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS7_OPTION_' . strtoupper($item->days7));

			$item->days8 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS8_OPTION_' . strtoupper($item->days8));

			$item->days9 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS9_OPTION_' . strtoupper($item->days9));

			$item->days10 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS10_OPTION_' . strtoupper($item->days10));

			$item->days11 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS11_OPTION_' . strtoupper($item->days11));

			$item->days12 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS12_OPTION_' . strtoupper($item->days12));

			$item->days13 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS13_OPTION_' . strtoupper($item->days13));

			$item->days14 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS14_OPTION_' . strtoupper($item->days14));

			$item->days15 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS15_OPTION_' . strtoupper($item->days15));

			$item->days16 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS16_OPTION_' . strtoupper($item->days16));

			$item->days17 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS17_OPTION_' . strtoupper($item->days17));

			$item->days18 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS18_OPTION_' . strtoupper($item->days18));

			$item->days19 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS19_OPTION_' . strtoupper($item->days19));

			$item->days20 = JText::_('COM_FIXED_TRIP_CREATE_PLANNINGS_DAYS20_OPTION_' . strtoupper($item->days20));
		}

		return $items;
	}

	/**
	 * Overrides the default function to check Date fields format, identified by
	 * "_dateformat" suffix, and erases the field if it's not correct.
	 *
	 * @return void
	 */
	protected function loadFormData()
	{
		$app              = Factory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;

		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && $this->isValidDate($value) == null)
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}

		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_FIXED_TRIP_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

	/**
	 * Checks if a given date is valid and in a specified format (YYYY-MM-DD)
	 *
	 * @param   string  $date  Date to be checked
	 *
	 * @return bool
	 */
	private function isValidDate($date)
	{
		$date = str_replace('/', '-', $date);
		return (date_create($date)) ? Factory::getDate($date)->format("Y-m-d") : null;
	}
}

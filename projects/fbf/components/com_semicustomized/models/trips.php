<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Semicustomized
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2018 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Semicustomized records.
 *
 * @since  1.6
 */
class SemicustomizedModelTrips extends JModelList
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
				'title', 'a.title',
				'peoplecapacity', 'a.peoplecapacity',
				'carrousselselection', 'a.carrousselselection',
				'shortdescription', 'a.shortdescription',
				'longdescription', 'a.longdescription',
				'keeperconsumer', 'a.keeperconsumer',
				'nokeeperconsumer', 'a.nokeeperconsumer',
				'transportconsumer', 'a.transportconsumer',
				'notransportconsumer', 'a.notransportconsumer',
				'hotelconsumer', 'a.hotelconsumer',
				'nohotelconsumer', 'a.nohotelconsumer',
				'planning1', 'a.planning1',
				'dayplanning1', 'a.dayplanning1',
				'planning2', 'a.planning2',
				'dayplanning2', 'a.dayplanning2',
				'planning3', 'a.planning3',
				'dayplanning3', 'a.dayplanning3',
				'planning4', 'a.planning4',
				'dayplanning4', 'a.dayplanning4',
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
        parent::populateState('a.ordering', 'asc');

        $context = $this->getUserStateFromRequest($this->context . '.context', 'context', 'com_content.article', 'CMD');
        $this->setState('filter.context', $context);

        // Split context into component and optional section
        $parts = FieldsHelper::extract($context);

        if ($parts)
        {
            $this->setState('filter.component', $parts[0]);
            $this->setState('filter.section', $parts[1]);
        }
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

            $query->from('`#__semicustomized_trip` AS a');
            
		// Join over the users for the checked out user.
		$query->select('uc.name AS uEditor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		// Join over the created by field 'modified_by'
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
            
		if (!Factory::getUser()->authorise('core.edit', 'com_semicustomized'))
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

			$item->carrousselselection = JText::_('COM_SEMICUSTOMIZED_TRIPS_CARROUSSELSELECTION_OPTION_' . strtoupper($item->carrousselselection));

			$item->keeperconsumer = JText::_('COM_SEMICUSTOMIZED_TRIPS_KEEPERCONSUMER_OPTION_' . strtoupper($item->keeperconsumer));

			$item->nokeeperconsumer = JText::_('COM_SEMICUSTOMIZED_TRIPS_NOKEEPERCONSUMER_OPTION_' . strtoupper($item->nokeeperconsumer));

			$item->transportconsumer = JText::_('COM_SEMICUSTOMIZED_TRIPS_TRANSPORTCONSUMER_OPTION_' . strtoupper($item->transportconsumer));

			$item->notransportconsumer = JText::_('COM_SEMICUSTOMIZED_TRIPS_NOTRANSPORTCONSUMER_OPTION_' . strtoupper($item->notransportconsumer));

			$item->hotelconsumer = JText::_('COM_SEMICUSTOMIZED_TRIPS_HOTELCONSUMER_OPTION_' . strtoupper($item->hotelconsumer));

			$item->nohotelconsumer = JText::_('COM_SEMICUSTOMIZED_TRIPS_NOHOTELCONSUMER_OPTION_' . strtoupper($item->nohotelconsumer));

			$item->planning1 = JText::_('COM_SEMICUSTOMIZED_TRIPS_PLANNING1_OPTION_' . strtoupper($item->planning1));

			$item->planning2 = JText::_('COM_SEMICUSTOMIZED_TRIPS_PLANNING2_OPTION_' . strtoupper($item->planning2));

			$item->planning3 = JText::_('COM_SEMICUSTOMIZED_TRIPS_PLANNING3_OPTION_' . strtoupper($item->planning3));

			$item->planning4 = JText::_('COM_SEMICUSTOMIZED_TRIPS_PLANNING4_OPTION_' . strtoupper($item->planning4));
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
			$app->enqueueMessage(JText::_("COM_SEMICUSTOMIZED_SEARCH_FILTER_DATE_FORMAT"), "warning");
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

<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Payment_message
 * @author     vikram <vikram.zinavo@gmail.com>
 * @copyright  2018 vikram
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Payment_message.
 *
 * @since  1.6
 */
class Payment_messageViewMessages extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		Payment_messageHelper::addSubmenu('messages');

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function addToolbar()
	{
		$state = $this->get('State');
		$canDo = Payment_messageHelper::getActions();

		JToolBarHelper::title(JText::_('COM_PAYMENT_MESSAGE_TITLE_MESSAGES'), 'messages.png');

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/message';

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('message.add', 'JTOOLBAR_NEW');

				if (isset($this->items[0]))
				{
					JToolbarHelper::custom('messages.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
				}
			}

			if ($canDo->get('core.edit') && isset($this->items[0]))
			{
				JToolBarHelper::editList('message.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom('messages.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('messages.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			elseif (isset($this->items[0]))
			{
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'messages.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('messages.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				JToolBarHelper::custom('messages.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', 'messages.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash('messages.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_payment_message');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_payment_message&view=messages');
	}

	/**
	 * Method to order fields 
	 *
	 * @return void 
	 */
	protected function getSortFields()
	{
		return array(
			'a.`id`' => JText::_('JGRID_HEADING_ID'),
			'a.`ordering`' => JText::_('JGRID_HEADING_ORDERING'),
			'a.`state`' => JText::_('JSTATUS'),
			'a.`flightyesnormalpayment`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FLIGHTYESNORMALPAYMENT'),
			'a.`firstinstalment_fyn`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FIRSTINSTALMENT_FYN'),
			'a.`finalinstalment_fyn`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FINALINSTALMENT_FYN'),
			'a.`flight_no_normalpayment`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_NO_NORMALPAYMENT'),
			'a.`firstinstalment_fnn`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FIRSTINSTALMENT_FNN'),
			'a.`finalinstalment_fnn`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FINALINSTALMENT_FNN'),
			'a.`flight_yes_split_payment`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_YES_SPLIT_PAYMENT'),
			'a.`firstinstalment_fys`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FIRSTINSTALMENT_FYS'),
			'a.`finalinstalment_fys`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FINALINSTALMENT_FYS'),
			'a.`flight_no_splitpayment`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_NO_SPLITPAYMENT'),
			'a.`finalquotation_fns`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FINALQUOTATION_FNS'),
			'a.`flightyespartipayment`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FLIGHTYESPARTIPAYMENT'),
			'a.`flight_no_parti_payment`' => JText::_('COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_NO_PARTI_PAYMENT'),
		);
	}

    /**
     * Check if state is set
     *
     * @param   mixed  $state  State
     *
     * @return bool
     */
    public function getState($state)
    {
        return isset($this->state->{$state}) ? $this->state->{$state} : false;
    }
}

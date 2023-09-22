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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'administrator/components/com_payment_message/assets/css/payment_message.css');
$document->addStyleSheet(JUri::root() . 'media/com_payment_message/css/list.css');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $user->authorise('core.edit.state', 'com_payment_message');
$saveOrder = $listOrder == 'a.`ordering`';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_payment_message&task=messages.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'messageList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();
?>

<form action="<?php echo JRoute::_('index.php?option=com_payment_message&view=messages'); ?>" method="post"
	  name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>

            <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

			<div class="clearfix"></div>
			<table class="table table-striped" id="messageList">
				<thead>
				<tr>
					<?php if (isset($this->items[0]->ordering)): ?>
						<th width="1%" class="nowrap center hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', '', 'a.`ordering`', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                        </th>
					<?php endif; ?>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value=""
							   title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
					</th>
					<?php if (isset($this->items[0]->state)): ?>
						<th width="1%" class="nowrap center">
								<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.`state`', $listDirn, $listOrder); ?>
</th>
					<?php endif; ?>

									<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_ID', 'a.`id`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHTYESNORMALPAYMENT', 'a.`flightyesnormalpayment`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FIRSTINSTALMENT_FYN', 'a.`firstinstalment_fyn`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FINALINSTALMENT_FYN', 'a.`finalinstalment_fyn`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_NO_NORMALPAYMENT', 'a.`flight_no_normalpayment`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FIRSTINSTALMENT_FNN', 'a.`firstinstalment_fnn`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FINALINSTALMENT_FNN', 'a.`finalinstalment_fnn`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_YES_SPLIT_PAYMENT', 'a.`flight_yes_split_payment`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FIRSTINSTALMENT_FYS', 'a.`firstinstalment_fys`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FINALINSTALMENT_FYS', 'a.`finalinstalment_fys`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_NO_SPLITPAYMENT', 'a.`flight_no_splitpayment`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FINALQUOTATION_FNS', 'a.`finalquotation_fns`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHTYESPARTIPAYMENT', 'a.`flightyespartipayment`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_NO_PARTI_PAYMENT', 'a.`flight_no_parti_payment`', $listDirn, $listOrder); ?>
				</th>

					
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate  = $user->authorise('core.create', 'com_payment_message');
					$canEdit    = $user->authorise('core.edit', 'com_payment_message');
					$canCheckin = $user->authorise('core.manage', 'com_payment_message');
					$canChange  = $user->authorise('core.edit.state', 'com_payment_message');
					?>
					<tr class="row<?php echo $i % 2; ?>">

						<?php if (isset($this->items[0]->ordering)) : ?>
							<td class="order nowrap center hidden-phone">
								<?php if ($canChange) :
									$disableClassName = '';
									$disabledLabel    = '';

									if (!$saveOrder) :
										$disabledLabel    = JText::_('JORDERINGDISABLED');
										$disableClassName = 'inactive tip-top';
									endif; ?>
									<span class="sortable-handler hasTooltip <?php echo $disableClassName ?>"
										  title="<?php echo $disabledLabel ?>">
							<i class="icon-menu"></i>
						</span>
									<input type="text" style="display:none" name="order[]" size="5"
										   value="<?php echo $item->ordering; ?>" class="width-20 text-area-order "/>
								<?php else : ?>
									<span class="sortable-handler inactive">
							<i class="icon-menu"></i>
						</span>
								<?php endif; ?>
							</td>
						<?php endif; ?>
						<td class="hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<?php if (isset($this->items[0]->state)): ?>
							<td class="center">
								<?php echo JHtml::_('jgrid.published', $item->state, $i, 'messages.', $canChange, 'cb'); ?>
</td>
						<?php endif; ?>

										<td>

					<?php echo $item->id; ?>
				</td>				<td>

					<?php echo $item->flightyesnormalpayment; ?>
				</td>				<td>
				<?php if (isset($item->checked_out) && $item->checked_out && ($canEdit || $canChange)) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->uEditor, $item->checked_out_time, 'messages.', $canCheckin); ?>
				<?php endif; ?>
				<?php if ($canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_payment_message&task=message.edit&id='.(int) $item->id); ?>">
					<?php echo $this->escape($item->firstinstalment_fyn); ?></a>
				<?php else : ?>
					<?php echo $this->escape($item->firstinstalment_fyn); ?>
				<?php endif; ?>

				</td>				<td>

					<?php echo $item->finalinstalment_fyn; ?>
				</td>				<td>

					<?php echo $item->flight_no_normalpayment; ?>
				</td>				<td>

					<?php echo $item->firstinstalment_fnn; ?>
				</td>				<td>

					<?php echo $item->finalinstalment_fnn; ?>
				</td>				<td>

					<?php echo $item->flight_yes_split_payment; ?>
				</td>				<td>

					<?php echo $item->firstinstalment_fys; ?>
				</td>				<td>

					<?php echo $item->finalinstalment_fys; ?>
				</td>				<td>

					<?php echo $item->flight_no_splitpayment; ?>
				</td>				<td>

					<?php echo $item->finalquotation_fns; ?>
				</td>				<td>

					<?php echo $item->flightyespartipayment; ?>
				</td>				<td>

					<?php echo $item->flight_no_parti_payment; ?>
				</td>

					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="boxchecked" value="0"/>
            <input type="hidden" name="list[fullorder]" value="<?php echo $listOrder; ?> <?php echo $listDirn; ?>"/>
			<?php echo JHtml::_('form.token'); ?>
		</div>
</form>
<script>
    window.toggleField = function (id, task, field) {

        var f = document.adminForm, i = 0, cbx, cb = f[ id ];

        if (!cb) return false;

        while (true) {
            cbx = f[ 'cb' + i ];

            if (!cbx) break;

            cbx.checked = false;
            i++;
        }

        var inputField   = document.createElement('input');

        inputField.type  = 'hidden';
        inputField.name  = 'field';
        inputField.value = field;
        f.appendChild(inputField);

        cb.checked = true;
        f.boxchecked.value = 1;
        window.submitform(task);

        return false;
    };
</script>
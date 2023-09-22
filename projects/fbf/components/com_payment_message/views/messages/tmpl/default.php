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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_payment_message') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'messageform.xml');
$canEdit    = $user->authorise('core.edit', 'com_payment_message') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'messageform.xml');
$canCheckin = $user->authorise('core.manage', 'com_payment_message');
$canChange  = $user->authorise('core.edit.state', 'com_payment_message');
$canDelete  = $user->authorise('core.delete', 'com_payment_message');
?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post"
      name="adminForm" id="adminForm">

	
	<table class="table table-striped" id="messageList">
		<thead>
		<tr>
			<?php if (isset($this->items[0]->state)): ?>
				<th width="5%">
	<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
</th>
			<?php endif; ?>

							<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHTYESNORMALPAYMENT', 'a.flightyesnormalpayment', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FIRSTINSTALMENT_FYN', 'a.firstinstalment_fyn', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FINALINSTALMENT_FYN', 'a.finalinstalment_fyn', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_NO_NORMALPAYMENT', 'a.flight_no_normalpayment', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FIRSTINSTALMENT_FNN', 'a.firstinstalment_fnn', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FINALINSTALMENT_FNN', 'a.finalinstalment_fnn', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_YES_SPLIT_PAYMENT', 'a.flight_yes_split_payment', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FIRSTINSTALMENT_FYS', 'a.firstinstalment_fys', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FINALINSTALMENT_FYS', 'a.finalinstalment_fys', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_NO_SPLITPAYMENT', 'a.flight_no_splitpayment', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FINALQUOTATION_FNS', 'a.finalquotation_fns', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHTYESPARTIPAYMENT', 'a.flightyespartipayment', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PAYMENT_MESSAGE_MESSAGES_FLIGHT_NO_PARTI_PAYMENT', 'a.flight_no_parti_payment', $listDirn, $listOrder); ?>
				</th>


							<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_PAYMENT_MESSAGE_MESSAGES_ACTIONS'); ?>
				</th>
				<?php endif; ?>

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
		<?php foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_payment_message'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_payment_message')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

				<?php if (isset($this->items[0]->state)) : ?>
					<?php $class = ($canChange) ? 'active' : 'disabled'; ?>
					<td class="center">
	<a class="btn btn-micro <?php echo $class; ?>" href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_payment_message&task=message.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
	<?php if ($item->state == 1): ?>
		<i class="icon-publish"></i>
	<?php else: ?>
		<i class="icon-unpublish"></i>
	<?php endif; ?>
	</a>
</td>
				<?php endif; ?>

								<td>

					<?php echo $item->id; ?>
				</td>
				<td>

					<?php echo $item->flightyesnormalpayment; ?>
				</td>
				<td>
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->uEditor, $item->checked_out_time, 'messages.', $canCheckin); ?>
				<?php endif; ?>
				<a href="<?php echo JRoute::_('index.php?option=com_payment_message&view=message&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->firstinstalment_fyn); ?></a>
				</td>
				<td>

					<?php echo $item->finalinstalment_fyn; ?>
				</td>
				<td>

					<?php echo $item->flight_no_normalpayment; ?>
				</td>
				<td>

					<?php echo $item->firstinstalment_fnn; ?>
				</td>
				<td>

					<?php echo $item->finalinstalment_fnn; ?>
				</td>
				<td>

					<?php echo $item->flight_yes_split_payment; ?>
				</td>
				<td>

					<?php echo $item->firstinstalment_fys; ?>
				</td>
				<td>

					<?php echo $item->finalinstalment_fys; ?>
				</td>
				<td>

					<?php echo $item->flight_no_splitpayment; ?>
				</td>
				<td>

					<?php echo $item->finalquotation_fns; ?>
				</td>
				<td>

					<?php echo $item->flightyespartipayment; ?>
				</td>
				<td>

					<?php echo $item->flight_no_parti_payment; ?>
				</td>


								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_payment_message&task=messageform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_payment_message&task=messageform.remove&id=' . $item->id, false, 2); ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></a>
						<?php endif; ?>
					</td>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_payment_message&task=messageform.edit&id=0', false, 0); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_PAYMENT_MESSAGE_ADD_ITEM'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

<?php if($canDelete) : ?>
<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {

		if (!confirm("<?php echo JText::_('COM_PAYMENT_MESSAGE_DELETE_MESSAGE'); ?>")) {
			return false;
		}
	}
</script>
<?php endif; ?>

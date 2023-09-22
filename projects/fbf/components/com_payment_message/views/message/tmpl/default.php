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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_payment_message');

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_payment_message'))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FLIGHTYESNORMALPAYMENT'); ?></th>
			<td><?php echo nl2br($this->item->flightyesnormalpayment); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_QUOTATION_REQUESTFYN'); ?></th>
			<td><?php echo nl2br($this->item->quotation_requestfyn); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FINALQUOTATION_FYN'); ?></th>
			<td><?php echo nl2br($this->item->finalquotation_fyn); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FIRSTINSTALMENT_FYN'); ?></th>
			<td><?php echo nl2br($this->item->firstinstalment_fyn); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FINALINSTALMENT_FYN'); ?></th>
			<td><?php echo nl2br($this->item->finalinstalment_fyn); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_TRIPFYN'); ?></th>
			<td><?php echo nl2br($this->item->tripfyn); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FLIGHT_NO_NORMALPAYMENT'); ?></th>
			<td><?php echo nl2br($this->item->flight_no_normalpayment); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_QUOTATION_REQUESTFNN'); ?></th>
			<td><?php echo nl2br($this->item->quotation_requestfnn); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FINALQUOTATION_FNN'); ?></th>
			<td><?php echo nl2br($this->item->finalquotation_fnn); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FIRSTINSTALMENT_FNN'); ?></th>
			<td><?php echo nl2br($this->item->firstinstalment_fnn); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FINALINSTALMENT_FNN'); ?></th>
			<td><?php echo nl2br($this->item->finalinstalment_fnn); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_TRIP_FNN'); ?></th>
			<td><?php echo nl2br($this->item->trip_fnn); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FLIGHT_YES_SPLIT_PAYMENT'); ?></th>
			<td><?php echo nl2br($this->item->flight_yes_split_payment); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_QUOTATION_REQUESTFYS'); ?></th>
			<td><?php echo nl2br($this->item->quotation_requestfys); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FINALQUOTATION_FYS'); ?></th>
			<td><?php echo nl2br($this->item->finalquotation_fys); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FIRSTINSTALMENT_FYS'); ?></th>
			<td><?php echo nl2br($this->item->firstinstalment_fys); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FINALINSTALMENT_FYS'); ?></th>
			<td><?php echo nl2br($this->item->finalinstalment_fys); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_TRIPFYS'); ?></th>
			<td><?php echo nl2br($this->item->tripfys); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FLIGHT_NO_SPLITPAYMENT'); ?></th>
			<td><?php echo nl2br($this->item->flight_no_splitpayment); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_QUOTATION_REQUESTFNS'); ?></th>
			<td><?php echo nl2br($this->item->quotation_requestfns); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FINALQUOTATION_FNS'); ?></th>
			<td><?php echo nl2br($this->item->finalquotation_fns); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FLIGHTYESPARTIPAYMENT'); ?></th>
			<td><?php echo nl2br($this->item->flightyespartipayment); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PAYMENT_MESSAGE_FORM_LBL_MESSAGE_FLIGHT_NO_PARTI_PAYMENT'); ?></th>
			<td><?php echo nl2br($this->item->flight_no_parti_payment); ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_payment_message&task=message.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_PAYMENT_MESSAGE_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_payment_message.message.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_PAYMENT_MESSAGE_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_PAYMENT_MESSAGE_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_PAYMENT_MESSAGE_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_payment_message&task=message.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_PAYMENT_MESSAGE_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>
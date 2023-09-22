<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Common_price_management
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_common_price_management');

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_common_price_management'))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_COMMON_PRICE_MANAGEMENT_FORM_LBL_PRICEMANAGEMENT_GST'); ?></th>
			<td><?php echo $this->item->gst; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_COMMON_PRICE_MANAGEMENT_FORM_LBL_PRICEMANAGEMENT_F_FIRT_INSTALLMENT'); ?></th>
			<td><?php echo $this->item->f_firt_installment; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_COMMON_PRICE_MANAGEMENT_FORM_LBL_PRICEMANAGEMENT_F_FIRST_INST_DATE'); ?></th>
			<td><?php echo $this->item->f_first_inst_date; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_COMMON_PRICE_MANAGEMENT_FORM_LBL_PRICEMANAGEMENT_F_FINAL_INSTALLMENT'); ?></th>
			<td><?php echo $this->item->f_final_installment; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_COMMON_PRICE_MANAGEMENT_FORM_LBL_PRICEMANAGEMENT_F_FINAL_INST_DATE'); ?></th>
			<td><?php echo $this->item->f_final_inst_date; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_common_price_management&task=pricemanagement.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_COMMON_PRICE_MANAGEMENT_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_common_price_management.pricemanagement.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_COMMON_PRICE_MANAGEMENT_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_COMMON_PRICE_MANAGEMENT_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_COMMON_PRICE_MANAGEMENT_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_common_price_management&task=pricemanagement.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_COMMON_PRICE_MANAGEMENT_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>
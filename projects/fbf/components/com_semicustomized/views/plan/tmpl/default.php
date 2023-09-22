<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Semicustomized
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2018 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_semicustomized');

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_semicustomized'))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_REFERENCE'); ?></th>
			<td><?php echo $this->item->reference; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_TITLE'); ?></th>
			<td><?php echo $this->item->title; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_HOTELTITLE1'); ?></th>
			<td><?php echo $this->item->hoteltitle1; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_HOTELPRICE1'); ?></th>
			<td><?php echo $this->item->hotelprice1; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_EXTRAROOM1'); ?></th>
			<td><?php echo $this->item->extraroom1; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_MAXROOMCAPACITY'); ?></th>
			<td><?php echo $this->item->maxroomcapacity; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_HOTELTITLE2'); ?></th>
			<td><?php echo $this->item->hoteltitle2; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_PRICEPERROOM2'); ?></th>
			<td><?php echo $this->item->priceperroom2; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_EXTRAROOM2'); ?></th>
			<td><?php echo $this->item->extraroom2; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_MAXROOMCAPACITY2'); ?></th>
			<td><?php echo $this->item->maxroomcapacity2; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_HOTELTITLE3'); ?></th>
			<td><?php echo $this->item->hoteltitle3; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_PRICEPERROOM3'); ?></th>
			<td><?php echo $this->item->priceperroom3; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_EXTRAROOM3'); ?></th>
			<td><?php echo $this->item->extraroom3; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_MAXROOMCAPACITY3'); ?></th>
			<td><?php echo $this->item->maxroomcapacity3; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_TRANSPORTPRICEL1'); ?></th>
			<td><?php echo $this->item->transportpricel1; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_TRANSPORTCAPACITY1'); ?></th>
			<td><?php echo $this->item->transportcapacity1; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_TRANSPORTPRICE2'); ?></th>
			<td><?php echo $this->item->transportprice2; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_TRANSPORTCAPACITY2'); ?></th>
			<td><?php echo $this->item->transportcapacity2; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_TRANSPORTPRICE3'); ?></th>
			<td><?php echo $this->item->transportprice3; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_TRANSPORTCAPACITY3'); ?></th>
			<td><?php echo $this->item->transportcapacity3; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_TRANSPORTPRICE4'); ?></th>
			<td><?php echo $this->item->transportprice4; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_TRANSPORTCAPACITY4'); ?></th>
			<td><?php echo $this->item->transportcapacity4; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_SEMICUSTOMIZED_FORM_LBL_PLAN_KEEPERPRICE1'); ?></th>
			<td><?php echo $this->item->keeperprice1; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_semicustomized&task=plan.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_SEMICUSTOMIZED_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_semicustomized.plan.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_SEMICUSTOMIZED_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_SEMICUSTOMIZED_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_SEMICUSTOMIZED_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_semicustomized&task=plan.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_SEMICUSTOMIZED_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>
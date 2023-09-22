<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_trip
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_fixed_trip');

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_fixed_trip'))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_REFERENCE'); ?></th>
			<td><?php echo $this->item->reference; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_TITLE'); ?></th>
			<td><?php echo $this->item->title; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS1'); ?></th>
			<td><?php echo $this->item->days1; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS2'); ?></th>
			<td><?php echo $this->item->days2; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS3'); ?></th>
			<td><?php echo $this->item->days3; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS4'); ?></th>
			<td><?php echo $this->item->days4; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS5'); ?></th>
			<td><?php echo $this->item->days5; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS6'); ?></th>
			<td><?php echo $this->item->days6; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS7'); ?></th>
			<td><?php echo $this->item->days7; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS8'); ?></th>
			<td><?php echo $this->item->days8; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS9'); ?></th>
			<td><?php echo $this->item->days9; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS10'); ?></th>
			<td><?php echo $this->item->days10; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS11'); ?></th>
			<td><?php echo $this->item->days11; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS12'); ?></th>
			<td><?php echo $this->item->days12; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS13'); ?></th>
			<td><?php echo $this->item->days13; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS14'); ?></th>
			<td><?php echo $this->item->days14; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS15'); ?></th>
			<td><?php echo $this->item->days15; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS16'); ?></th>
			<td><?php echo $this->item->days16; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS17'); ?></th>
			<td><?php echo $this->item->days17; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS18'); ?></th>
			<td><?php echo $this->item->days18; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS19'); ?></th>
			<td><?php echo $this->item->days19; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_CREATE_PLANNING_DAYS20'); ?></th>
			<td><?php echo $this->item->days20; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_fixed_trip&task=create_planning.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_FIXED_TRIP_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_fixed_trip.create_planning.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_FIXED_TRIP_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_FIXED_TRIP_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_FIXED_TRIP_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_fixed_trip&task=create_planning.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_FIXED_TRIP_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>
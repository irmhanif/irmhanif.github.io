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
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_DATECATEGORY_TITLE'); ?></th>
			<td><?php echo $this->item->title; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_DATECATEGORY_PICTURE'); ?></th>
			<td>
			<?php
			foreach ((array) $this->item->picture as $singleFile) : 
				if (!is_array($singleFile)) : 
					$uploadPath = 'date_category' . DIRECTORY_SEPARATOR . $singleFile;
					 echo '<a href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank">' . $singleFile . '</a> ';
				endif;
			endforeach;
		?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_DATECATEGORY_START_DATE'); ?></th>
			<td><?php echo $this->item->start_date; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_FIXED_TRIP_FORM_LBL_DATECATEGORY_END_DATE'); ?></th>
			<td><?php echo $this->item->end_date; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_fixed_trip&task=datecategory.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_FIXED_TRIP_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_fixed_trip.datecategory.'.$this->item->id)) : ?>

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
			<a href="<?php echo JRoute::_('index.php?option=com_fixed_trip&task=datecategory.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_FIXED_TRIP_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>
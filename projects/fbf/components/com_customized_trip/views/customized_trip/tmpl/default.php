<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Customized_trip
 * @author     vikram <vikram.zinavo@gmail.com>
 * @copyright  2018 vikram
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_customized_trip');

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_customized_trip'))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_TRIP_TITTLE'); ?></th>
			<td><?php echo $this->item->trip_tittle; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_PICTURE'); ?></th>
			<td>
			<?php
			foreach ((array) $this->item->picture as $singleFile) : 
				if (!is_array($singleFile)) : 
					$uploadPath = 'customized_event' . DIRECTORY_SEPARATOR . $singleFile;
					 echo '<a href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank">' . $singleFile . '</a> ';
				endif;
			endforeach;
		?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_DESCRIPTION'); ?></th>
			<td><?php echo nl2br($this->item->description); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_TITTLE_LINK1'); ?></th>
			<td><?php echo $this->item->tittle_link1; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_LINK_TO_BLOG1'); ?></th>
			<td><?php echo $this->item->link_to_blog1; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_TITTLE_LINK2'); ?></th>
			<td><?php echo $this->item->tittle_link2; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_LINK_TO_BLOG2'); ?></th>
			<td><?php echo $this->item->link_to_blog2; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_TITTLE_LINK3'); ?></th>
			<td><?php echo $this->item->tittle_link3; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_LINK_TO_BLOG3'); ?></th>
			<td><?php echo $this->item->link_to_blog3; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_TITTLE_LINK4'); ?></th>
			<td><?php echo $this->item->tittle_link4; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_LINK_TO_BLOG4'); ?></th>
			<td><?php echo $this->item->link_to_blog4; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_FLIGHT'); ?></th>
			<td><?php echo $this->item->flight; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_KEEPER'); ?></th>
			<td><?php echo $this->item->keeper; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_TRNASPORT'); ?></th>
			<td><?php echo $this->item->trnasport; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_CUSTOMIZED_TRIP_FORM_LBL_CUSTOMIZED_TRIP_PLACEOFDEPARTURE'); ?></th>
			<td><?php echo $this->item->placeofdeparture; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_customized_trip&task=customized_trip.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_CUSTOMIZED_TRIP_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_customized_trip.customized_trip.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_CUSTOMIZED_TRIP_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_CUSTOMIZED_TRIP_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_CUSTOMIZED_TRIP_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_customized_trip&task=customized_trip.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_CUSTOMIZED_TRIP_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>
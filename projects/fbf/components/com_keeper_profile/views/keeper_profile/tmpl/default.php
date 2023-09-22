<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Keeper_profile
 * @author     vikram <vikram.zinavo@gmail.com>
 * @copyright  2018 vikram
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_keeper_profile');

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_keeper_profile'))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_KEEPER_PROFILE_FORM_LBL_KEEPER_PROFILE_KEEPER_NAME'); ?></th>
			<td><?php echo $this->item->keeper_name; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_KEEPER_PROFILE_FORM_LBL_KEEPER_PROFILE_KEEPER_IMAGE'); ?></th>
			<td>
			<?php
			foreach ((array) $this->item->keeper_image as $singleFile) : 
				if (!is_array($singleFile)) : 
					$uploadPath = 'keeper_profile' . DIRECTORY_SEPARATOR . $singleFile;
					 echo '<a href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank">' . $singleFile . '</a> ';
				endif;
			endforeach;
		?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_KEEPER_PROFILE_FORM_LBL_KEEPER_PROFILE_KEEPER_SHORT_DES'); ?></th>
			<td><?php echo nl2br($this->item->keeper_short_des); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_KEEPER_PROFILE_FORM_LBL_KEEPER_PROFILE_KEEPER_DETAIL_DES'); ?></th>
			<td><?php echo nl2br($this->item->keeper_detail_des); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_KEEPER_PROFILE_FORM_LBL_KEEPER_PROFILE_KEEPER_CONTACT'); ?></th>
			<td><?php echo $this->item->keeper_contact; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_KEEPER_PROFILE_FORM_LBL_KEEPER_PROFILE_KEEPER_LOCATION'); ?></th>
			<td><?php echo $this->item->keeper_location; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_keeper_profile&task=keeper_profile.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_KEEPER_PROFILE_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_keeper_profile.keeper_profile.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_KEEPER_PROFILE_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_KEEPER_PROFILE_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_KEEPER_PROFILE_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_keeper_profile&task=keeper_profile.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_KEEPER_PROFILE_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>
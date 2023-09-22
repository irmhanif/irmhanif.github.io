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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_keeper_profile', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_keeper_profile/js/form.js');

$user    = JFactory::getUser();
$canEdit = Keeper_profileHelpersKeeper_profile::canUserEdit($this->item, $user);


?>

<div class="keeper_profile-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(JText::_('COM_KEEPER_PROFILE_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h1><?php echo JText::sprintf('COM_KEEPER_PROFILE_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
		<?php else: ?>
			<h1><?php echo JText::_('COM_KEEPER_PROFILE_ADD_ITEM_TITLE'); ?></h1>
		<?php endif; ?>

		<form id="form-keeper_profile"
			  action="<?php echo JRoute::_('index.php?option=com_keeper_profile&task=keeper_profile.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
	<?php echo $this->form->renderField('keeper_name'); ?>

	<?php echo $this->form->renderField('keeper_image'); ?>

				<?php if (!empty($this->item->keeper_image)) : ?>
					<?php $keeper_imageFiles = array(); ?>
					<?php foreach ((array)$this->item->keeper_image as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'keeper_profile' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $keeper_imageFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[keeper_image_hidden]" id="jform_keeper_image_hidden" value="<?php echo implode(',', $keeper_imageFiles); ?>" />
	<?php echo $this->form->renderField('keeper_short_des'); ?>

	<?php echo $this->form->renderField('keeper_detail_des'); ?>

	<?php echo $this->form->renderField('keeper_contact'); ?>

	<?php echo $this->form->renderField('keeper_location'); ?>

			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_keeper_profile&task=keeper_profileform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_keeper_profile"/>
			<input type="hidden" name="task"
				   value="keeper_profileform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>

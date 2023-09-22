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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_customized_trip', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_customized_trip/js/form.js');

$user    = JFactory::getUser();
$canEdit = Customized_tripHelpersCustomized_trip::canUserEdit($this->item, $user);


?>

<div class="customized_trip-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(JText::_('COM_CUSTOMIZED_TRIP_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h1><?php echo JText::sprintf('COM_CUSTOMIZED_TRIP_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
		<?php else: ?>
			<h1><?php echo JText::_('COM_CUSTOMIZED_TRIP_ADD_ITEM_TITLE'); ?></h1>
		<?php endif; ?>

		<form id="form-customized_trip"
			  action="<?php echo JRoute::_('index.php?option=com_customized_trip&task=customized_trip.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
	<?php echo $this->form->renderField('trip_tittle'); ?>

	<?php echo $this->form->renderField('picture'); ?>

				<?php if (!empty($this->item->picture)) : ?>
					<?php $pictureFiles = array(); ?>
					<?php foreach ((array)$this->item->picture as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'customized_event' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $pictureFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[picture_hidden]" id="jform_picture_hidden" value="<?php echo implode(',', $pictureFiles); ?>" />
	<?php echo $this->form->renderField('description'); ?>

	<?php echo $this->form->renderField('tittle_link1'); ?>

	<?php echo $this->form->renderField('link_to_blog1'); ?>

	<?php echo $this->form->renderField('tittle_link2'); ?>

	<?php echo $this->form->renderField('link_to_blog2'); ?>

	<?php echo $this->form->renderField('tittle_link3'); ?>

	<?php echo $this->form->renderField('link_to_blog3'); ?>

	<?php echo $this->form->renderField('tittle_link4'); ?>

	<?php echo $this->form->renderField('link_to_blog4'); ?>

	<?php echo $this->form->renderField('flight'); ?>

	<?php echo $this->form->renderField('keeper'); ?>

	<?php echo $this->form->renderField('trnasport'); ?>

	<?php echo $this->form->renderField('placeofdeparture'); ?>

			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_customized_trip&task=customized_tripform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_customized_trip"/>
			<input type="hidden" name="task"
				   value="customized_tripform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>

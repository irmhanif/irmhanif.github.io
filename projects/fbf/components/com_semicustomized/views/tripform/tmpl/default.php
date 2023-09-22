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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_semicustomized', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_semicustomized/js/form.js');

$user    = JFactory::getUser();
$canEdit = SemicustomizedHelpersSemicustomized::canUserEdit($this->item, $user);


?>

<div class="trip-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(JText::_('COM_SEMICUSTOMIZED_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h1><?php echo JText::sprintf('COM_SEMICUSTOMIZED_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
		<?php else: ?>
			<h1><?php echo JText::_('COM_SEMICUSTOMIZED_ADD_ITEM_TITLE'); ?></h1>
		<?php endif; ?>

		<form id="form-trip"
			  action="<?php echo JRoute::_('index.php?option=com_semicustomized&task=trip.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
	<?php echo $this->form->renderField('title'); ?>

	<?php echo $this->form->renderField('image'); ?>

				<?php if (!empty($this->item->image)) : ?>
					<?php $imageFiles = array(); ?>
					<?php foreach ((array)$this->item->image as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'trip_gallery' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $imageFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[image_hidden]" id="jform_image_hidden" value="<?php echo implode(',', $imageFiles); ?>" />
	<?php echo $this->form->renderField('peoplecapacity'); ?>

	<?php echo $this->form->renderField('carrousselselection'); ?>

	<?php echo $this->form->renderField('shortdescription'); ?>

	<?php echo $this->form->renderField('longdescription'); ?>

	<?php echo $this->form->renderField('keeperconsumer'); ?>

	<?php echo $this->form->renderField('nokeeperconsumer'); ?>

	<?php echo $this->form->renderField('transportconsumer'); ?>

	<?php echo $this->form->renderField('notransportconsumer'); ?>

	<?php echo $this->form->renderField('hotelconsumer'); ?>

	<?php echo $this->form->renderField('nohotelconsumer'); ?>

	<?php echo $this->form->renderField('planning1'); ?>

	<?php echo $this->form->renderField('dayplanning1'); ?>

	<?php echo $this->form->renderField('planning2'); ?>

	<?php echo $this->form->renderField('dayplanning2'); ?>

	<?php echo $this->form->renderField('planning3'); ?>

	<?php echo $this->form->renderField('dayplanning3'); ?>

	<?php echo $this->form->renderField('planning4'); ?>

	<?php echo $this->form->renderField('dayplanning4'); ?>

			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_semicustomized&task=tripform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_semicustomized"/>
			<input type="hidden" name="task"
				   value="tripform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>

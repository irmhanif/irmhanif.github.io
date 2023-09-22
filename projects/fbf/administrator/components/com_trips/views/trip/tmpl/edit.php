<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Trips
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_trips/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'trip.cancel') {
			Joomla.submitform(task, document.getElementById('trip-form'));
		}
		else {
			
			if (task != 'trip.cancel' && document.formvalidator.isValid(document.id('trip-form'))) {
				
				Joomla.submitform(task, document.getElementById('trip-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>
<a href="<?php echo JURI::root(); ?>administrator/index.php?option=com_trips">Back</a>
<form
	action="<?php echo JRoute::_('index.php?option=com_trips&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="trip-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_TRIPS_TITLE_TRIP', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>				<?php echo $this->form->renderField('trip_img'); ?>

				<?php if (!empty($this->item->trip_img)) : ?>
					<?php $trip_imgFiles = array(); ?>
					<?php foreach ((array)$this->item->trip_img as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'trips' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $trip_imgFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[trip_img_hidden]" id="jform_trip_img_hidden" value="<?php echo implode(',', $trip_imgFiles); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('trip_title'); ?>
				<?php echo $this->form->renderField('trip_desc'); ?>
				<?php echo $this->form->renderField('banner_image'); ?>

				<?php if (!empty($this->item->banner_image)) : ?>
					<?php $banner_imageFiles = array(); ?>
					<?php foreach ((array)$this->item->banner_image as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'banner_image' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $banner_imageFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[banner_image_hidden]" id="jform_banner_image_hidden" value="<?php echo implode(',', $banner_imageFiles); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('detail_page'); ?>

				<?php echo $this->form->renderField('rupee'); ?>
				
					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>


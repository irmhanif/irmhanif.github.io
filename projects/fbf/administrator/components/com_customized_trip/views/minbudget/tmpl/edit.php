<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Customized_trip
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2018 Subash R
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
$document->addStyleSheet(JUri::root() . 'media/com_customized_trip/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'minbudget.cancel') {
			Joomla.submitform(task, document.getElementById('minbudget-form'));
		}
		else {
			
			if (task != 'minbudget.cancel' && document.formvalidator.isValid(document.id('minbudget-form'))) {
				
				Joomla.submitform(task, document.getElementById('minbudget-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_customized_trip&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="minbudget-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CUSTOMIZED_TRIP_TITLE_MINBUDGET', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>				<?php echo $this->form->renderField('d1'); ?>
				<?php echo $this->form->renderField('d2'); ?>
				<?php echo $this->form->renderField('d3'); ?>
				<?php echo $this->form->renderField('d4'); ?>
				<?php echo $this->form->renderField('d5'); ?>
				<?php echo $this->form->renderField('d6'); ?>
				<?php echo $this->form->renderField('d7'); ?>
				<?php echo $this->form->renderField('d8'); ?>
				<?php echo $this->form->renderField('d9'); ?>
				<?php echo $this->form->renderField('d10'); ?>
				<?php echo $this->form->renderField('d11'); ?>
				<?php echo $this->form->renderField('d12'); ?>
				<?php echo $this->form->renderField('d13'); ?>
				<?php echo $this->form->renderField('d14'); ?>
				<?php echo $this->form->renderField('d15'); ?>
				<?php echo $this->form->renderField('d16'); ?>
				<?php echo $this->form->renderField('d17'); ?>
				<?php echo $this->form->renderField('d18'); ?>
				<?php echo $this->form->renderField('d19'); ?>
				<?php echo $this->form->renderField('d20'); ?>


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

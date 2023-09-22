<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Payment_message
 * @author     vikram <vikram.zinavo@gmail.com>
 * @copyright  2018 vikram
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
$document->addStyleSheet(JUri::root() . 'media/com_payment_message/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'message.cancel') {
			Joomla.submitform(task, document.getElementById('message-form'));
		}
		else {
			
			if (task != 'message.cancel' && document.formvalidator.isValid(document.id('message-form'))) {
				
				Joomla.submitform(task, document.getElementById('message-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_payment_message&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="message-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_PAYMENT_MESSAGE_TITLE_MESSAGE', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>				<?php echo $this->form->renderField('flightyesnormalpayment'); ?>
				<?php echo $this->form->renderField('quotation_requestfyn'); ?>
				<?php echo $this->form->renderField('finalquotation_fyn'); ?>
				<?php echo $this->form->renderField('firstinstalment_fyn'); ?>
				<?php echo $this->form->renderField('finalinstalment_fyn'); ?>
				<?php echo $this->form->renderField('tripfyn'); ?>
				<?php echo $this->form->renderField('flight_no_normalpayment'); ?>
				<?php echo $this->form->renderField('quotation_requestfnn'); ?>
				<?php echo $this->form->renderField('finalquotation_fnn'); ?>
				<?php echo $this->form->renderField('firstinstalment_fnn'); ?>
				<?php echo $this->form->renderField('finalinstalment_fnn'); ?>
				<?php echo $this->form->renderField('trip_fnn'); ?>
				<?php echo $this->form->renderField('flight_yes_split_payment'); ?>
				<?php echo $this->form->renderField('quotation_requestfys'); ?>
				<?php echo $this->form->renderField('finalquotation_fys'); ?>
				<?php echo $this->form->renderField('firstinstalment_fys'); ?>
				<?php echo $this->form->renderField('finalinstalment_fys'); ?>
				<?php echo $this->form->renderField('tripfys'); ?>
				<?php echo $this->form->renderField('flight_no_splitpayment'); ?>
				<?php echo $this->form->renderField('quotation_requestfns'); ?>
				<?php echo $this->form->renderField('finalquotation_fns'); ?>
				<?php echo $this->form->renderField('firstinstalment_fns'); ?>
				<?php echo $this->form->renderField('finalinstalment_fns'); ?>
				<?php echo $this->form->renderField('tripfns'); ?>
				
				<?php echo $this->form->renderField('flightyespartipayment'); ?>
				<?php echo $this->form->renderField('quotation_requestfyp'); ?>
				<?php echo $this->form->renderField('finalquotation_fyp'); ?>
				<?php echo $this->form->renderField('firstinstalment_fyp'); ?>
				<?php echo $this->form->renderField('finalinstalment_fyp'); ?>
				<?php echo $this->form->renderField('tripfyp'); ?>
				
				<?php echo $this->form->renderField('flight_no_parti_payment'); ?>
				
				<?php echo $this->form->renderField('quotation_requestfnp'); ?>
				<?php echo $this->form->renderField('finalquotation_fnp'); ?>
				<?php echo $this->form->renderField('firstinstalment_fnp'); ?>
				<?php echo $this->form->renderField('finalinstalment_fnp'); ?>
				<?php echo $this->form->renderField('tripfnp'); ?>

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

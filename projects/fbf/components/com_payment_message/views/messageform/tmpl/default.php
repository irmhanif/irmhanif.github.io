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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_payment_message', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_payment_message/js/form.js');

$user    = JFactory::getUser();
$canEdit = Payment_messageHelpersPayment_message::canUserEdit($this->item, $user);


?>

<div class="message-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(JText::_('COM_PAYMENT_MESSAGE_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h1><?php echo JText::sprintf('COM_PAYMENT_MESSAGE_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
		<?php else: ?>
			<h1><?php echo JText::_('COM_PAYMENT_MESSAGE_ADD_ITEM_TITLE'); ?></h1>
		<?php endif; ?>

		<form id="form-message"
			  action="<?php echo JRoute::_('index.php?option=com_payment_message&task=message.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
	<?php echo $this->form->renderField('flightyesnormalpayment'); ?>

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

	<?php echo $this->form->renderField('flightyespartipayment'); ?>

	<?php echo $this->form->renderField('flight_no_parti_payment'); ?>

			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_payment_message&task=messageform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_payment_message"/>
			<input type="hidden" name="task"
				   value="messageform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>

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

<div class="plan-edit front-end-edit">
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

		<form id="form-plan"
			  action="<?php echo JRoute::_('index.php?option=com_semicustomized&task=plan.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
	<?php echo $this->form->renderField('reference'); ?>

	<?php echo $this->form->renderField('title'); ?>

	<?php echo $this->form->renderField('hoteltitle1'); ?>

	<?php echo $this->form->renderField('hotelprice1'); ?>

	<?php echo $this->form->renderField('extraroom1'); ?>

	<?php echo $this->form->renderField('maxroomcapacity'); ?>

	<?php echo $this->form->renderField('hoteltitle2'); ?>

	<?php echo $this->form->renderField('priceperroom2'); ?>

	<?php echo $this->form->renderField('extraroom2'); ?>

	<?php echo $this->form->renderField('maxroomcapacity2'); ?>

	<?php echo $this->form->renderField('hoteltitle3'); ?>

	<?php echo $this->form->renderField('priceperroom3'); ?>

	<?php echo $this->form->renderField('extraroom3'); ?>

	<?php echo $this->form->renderField('maxroomcapacity3'); ?>

	<?php echo $this->form->renderField('transportpricel1'); ?>

	<?php echo $this->form->renderField('transportcapacity1'); ?>

	<?php echo $this->form->renderField('transportprice2'); ?>

	<?php echo $this->form->renderField('transportcapacity2'); ?>

	<?php echo $this->form->renderField('transportprice3'); ?>

	<?php echo $this->form->renderField('transportcapacity3'); ?>

	<?php echo $this->form->renderField('transportprice4'); ?>

	<?php echo $this->form->renderField('transportcapacity4'); ?>

	<?php echo $this->form->renderField('keeperprice1'); ?>

			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_semicustomized&task=planform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_semicustomized"/>
			<input type="hidden" name="task"
				   value="planform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>

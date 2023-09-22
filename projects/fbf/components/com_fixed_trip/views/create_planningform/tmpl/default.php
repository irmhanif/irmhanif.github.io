<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_trip
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
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
$lang->load('com_fixed_trip', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_fixed_trip/js/form.js');

$user    = JFactory::getUser();
$canEdit = Fixed_tripHelpersFixed_trip::canUserEdit($this->item, $user);


?>

<div class="create_planning-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(JText::_('COM_FIXED_TRIP_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h1><?php echo JText::sprintf('COM_FIXED_TRIP_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
		<?php else: ?>
			<h1><?php echo JText::_('COM_FIXED_TRIP_ADD_ITEM_TITLE'); ?></h1>
		<?php endif; ?>

		<form id="form-create_planning"
			  action="<?php echo JRoute::_('index.php?option=com_fixed_trip&task=create_planning.save'); ?>"
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

	<?php echo $this->form->renderField('days1'); ?>

	<?php echo $this->form->renderField('days2'); ?>

	<?php echo $this->form->renderField('days3'); ?>

	<?php echo $this->form->renderField('days4'); ?>

	<?php echo $this->form->renderField('days5'); ?>

	<?php echo $this->form->renderField('days6'); ?>

	<?php echo $this->form->renderField('days7'); ?>

	<?php echo $this->form->renderField('days8'); ?>

	<?php echo $this->form->renderField('days9'); ?>

	<?php echo $this->form->renderField('days10'); ?>

	<?php echo $this->form->renderField('days11'); ?>

	<?php echo $this->form->renderField('days12'); ?>

	<?php echo $this->form->renderField('days13'); ?>

	<?php echo $this->form->renderField('days14'); ?>

	<?php echo $this->form->renderField('days15'); ?>

	<?php echo $this->form->renderField('days16'); ?>

	<?php echo $this->form->renderField('days17'); ?>

	<?php echo $this->form->renderField('days18'); ?>

	<?php echo $this->form->renderField('days19'); ?>

	<?php echo $this->form->renderField('days20'); ?>

			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_fixed_trip&task=create_planningform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_fixed_trip"/>
			<input type="hidden" name="task"
				   value="create_planningform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>

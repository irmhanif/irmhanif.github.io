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

<div class="create_trip-edit front-end-edit">
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

		<form id="form-create_trip"
			  action="<?php echo JRoute::_('index.php?option=com_fixed_trip&task=create_trip.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
	<?php echo $this->form->renderField('title'); ?>

	<?php echo $this->form->renderField('description'); ?>

	<?php echo $this->form->renderField('type'); ?>

	<?php echo $this->form->renderField('date_of_departure1'); ?>

	<?php echo $this->form->renderField('price_person1'); ?>

	<?php echo $this->form->renderField('price_single_room_extra1'); ?>

	<?php echo $this->form->renderField('cost_hotel1'); ?>

	<?php echo $this->form->renderField('cost_activites1'); ?>

	<?php echo $this->form->renderField('cost_transport1'); ?>

	<?php echo $this->form->renderField('pdfplanning1'); ?>

				<?php if (!empty($this->item->pdfplanning1)) : ?>
					<?php $pdfplanning1Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning1 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $pdfplanning1Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[pdfplanning1_hidden]" id="jform_pdfplanning1_hidden" value="<?php echo implode(',', $pdfplanning1Files); ?>" />
	<?php echo $this->form->renderField('seat_available1'); ?>

	<?php echo $this->form->renderField('keeper1'); ?>

	<?php echo $this->form->renderField('transport1'); ?>

	<?php echo $this->form->renderField('hotel1'); ?>

	<?php echo $this->form->renderField('inclusion1'); ?>

	<?php echo $this->form->renderField('noinclusion1'); ?>

	<?php echo $this->form->renderField('planning1'); ?>

	<?php echo $this->form->renderField('number_of_day1'); ?>

	<?php echo $this->form->renderField('pdfplanning2'); ?>

				<?php if (!empty($this->item->pdfplanning2)) : ?>
					<?php $pdfplanning2Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning2 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $pdfplanning2Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[pdfplanning2_hidden]" id="jform_pdfplanning2_hidden" value="<?php echo implode(',', $pdfplanning2Files); ?>" />
	<?php echo $this->form->renderField('pdfplanning3'); ?>

				<?php if (!empty($this->item->pdfplanning3)) : ?>
					<?php $pdfplanning3Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning3 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $pdfplanning3Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[pdfplanning3_hidden]" id="jform_pdfplanning3_hidden" value="<?php echo implode(',', $pdfplanning3Files); ?>" />
	<?php echo $this->form->renderField('pdfplanning4'); ?>

				<?php if (!empty($this->item->pdfplanning4)) : ?>
					<?php $pdfplanning4Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning4 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $pdfplanning4Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[pdfplanning4_hidden]" id="jform_pdfplanning4_hidden" value="<?php echo implode(',', $pdfplanning4Files); ?>" />
	<?php echo $this->form->renderField('pdfplanning5'); ?>

				<?php if (!empty($this->item->pdfplanning5)) : ?>
					<?php $pdfplanning5Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning5 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $pdfplanning5Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[pdfplanning5_hidden]" id="jform_pdfplanning5_hidden" value="<?php echo implode(',', $pdfplanning5Files); ?>" />
	<?php echo $this->form->renderField('pdfplanning6'); ?>

				<?php if (!empty($this->item->pdfplanning6)) : ?>
					<?php $pdfplanning6Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning6 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $pdfplanning6Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[pdfplanning6_hidden]" id="jform_pdfplanning6_hidden" value="<?php echo implode(',', $pdfplanning6Files); ?>" />
			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_fixed_trip&task=create_tripform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_fixed_trip"/>
			<input type="hidden" name="task"
				   value="create_tripform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>

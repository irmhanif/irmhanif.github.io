<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Customer_rev1ews
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2019 Subash R
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
$lang->load('com_customer_rev1ews', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_customer_rev1ews/js/form.js');

$user    = JFactory::getUser();
$canEdit = Customer_rev1ewsHelpersCustomer_rev1ews::canUserEdit($this->item, $user);


?>

<div class="rev1ew-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(JText::_('COM_CUSTOMER_REV1EWS_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h1><?php echo JText::sprintf('COM_CUSTOMER_REV1EWS_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
		<?php else: ?>
			<h1><?php echo JText::_('COM_CUSTOMER_REV1EWS_ADD_ITEM_TITLE'); ?></h1>
		<?php endif; ?>

		<form id="form-rev1ew"
			  action="<?php echo JRoute::_('index.php?option=com_customer_rev1ews&task=rev1ew.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
	<?php echo $this->form->renderField('uid'); ?>

	<?php echo $this->form->renderField('reviewvalue'); ?>

	<?php echo $this->form->renderField('reviewtext'); ?>

	<?php echo $this->form->renderField('image'); ?>

				<?php if (!empty($this->item->image)) : ?>
					<?php $imageFiles = array(); ?>
					<?php foreach ((array)$this->item->image as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'review_gallery' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $imageFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<input type="hidden" name="jform[image_hidden]" id="jform_image_hidden" value="<?php echo implode(',', $imageFiles); ?>" />
	<?php echo $this->form->renderField('tittle'); ?>

			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_customer_rev1ews&task=rev1ewform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_customer_rev1ews"/>
			<input type="hidden" name="task"
				   value="rev1ewform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>

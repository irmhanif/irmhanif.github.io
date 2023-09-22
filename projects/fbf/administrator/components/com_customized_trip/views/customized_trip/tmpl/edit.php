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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
// JHtml::_('formbehavior.chosen', 'select');
// JHtml::_('behavior.keepalive');

$db = JFactory::getDbo();

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_customized_trip/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'customized_trip.cancel') {
			Joomla.submitform(task, document.getElementById('customized_trip-form'));
		}
		else {
			
			if (task != 'customized_trip.cancel' && document.formvalidator.isValid(document.id('customized_trip-form'))) {
				
				Joomla.submitform(task, document.getElementById('customized_trip-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_customized_trip&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="customized_trip-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CUSTOMIZED_TRIP_TITLE_CUSTOMIZED_TRIP', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>				<?php echo $this->form->renderField('trip_tittle'); ?>
				<?php echo $this->form->renderField('picture'); ?>

				<?php if (!empty($this->item->picture)) : ?>
					<?php $pictureFiles = array(); ?>
					<?php foreach ((array)$this->item->picture as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'customized_event' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $pictureFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[picture_hidden]" id="jform_picture_hidden" value="<?php echo implode(',', $pictureFiles); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('description'); ?>
				<?php echo $this->form->renderField('tittle_link1'); ?>
				<?php echo $this->form->renderField('link_to_blog1'); ?>
				<?php echo $this->form->renderField('tittle_link2'); ?>
				<?php echo $this->form->renderField('link_to_blog2'); ?>
				<?php echo $this->form->renderField('tittle_link3'); ?>
				<?php echo $this->form->renderField('link_to_blog3'); ?>
				<?php echo $this->form->renderField('tittle_link4'); ?>
				<?php echo $this->form->renderField('link_to_blog4'); ?>
<!-- <div class="control-group">
<div class="control-label"><label id="jform_flight-lbl" for="jform_flight">
	Flight</label>
</div>
	<div class="controls">
		<select id="jform_flight" name="jform[flight]">
		<option value="">Select flight</option>
		<?php
$sql2="SELECT * FROM `#__flightdetails` WHERE state='1'";
$db->setQuery($sql2);
$res2=$db->loadObjectList();

   foreach($res2 as $value)
        {
        $title = $value->flight_name;
        $id =$value->id;
         echo '<option value='.$id.'>'.$title.'</option>';
        }
   ?>
		</select>
	</div>
</div>

<div class="control-group">
		<div class="control-label">
		<label id="jform_keeper-lbl" for="jform_keeper">keeper</label>
	</div>
	<div class="controls">
		<select id="jform_keeper" name="jform[keeper]">
		<option value="">Select keeper</option>
        <?php
        $sql3="SELECT * FROM `#__keeper_profile` WHERE state='1'";
        $db->setQuery($sql3);
        $res3=$db->loadObjectList();
        
           foreach($res3 as $value_des)
                {
                $keeper_name = $valuedes->keeper_name;
                $id =$value_des->id;
                 echo '<option value='.$id.'>'.$keeper_name.'</option>';
                }
           ?>
		</select>
	</div>
</div>

  <div class="control-group">
		<div class="control-label">
		<label id="jform_trnasport-lbl" for="jform_keeper">Transport</label>
	</div>
	<div class="controls">
		<select id="jform_trnasport" name="jform[trnasport]">
		<option value="">Select Transport</option>
<?php
$sql4="SELECT * FROM `#__trnasports` WHERE state='1'";
$db->setQuery($sql4);
$res4=$db->loadObjectList();

   foreach($res4 as $value_des1)
        {
        $trnasport = $value_des1->trnasport;
        $id =$value_des1->id;
         echo '<option value='.$id.'>'.$trnasport.'</option>';
        }
   ?>
		</select>
	</div>
  </div>
  
    <div class="control-group">
		<div class="control-label">
		<label id="jform_placeofdeparture-lbl" for="jform_placeofdeparture">place of departure</label>
	</div>
	<div class="controls">
		<select id="jform_placeofdeparture" name="jform[placeofdeparture]">
		<option value="">Select place of departure</option>
		<?php
$sql5="SELECT * FROM `#__placeofdeparture` WHERE state='1'";
$db->setQuery($sql5);
$res5=$db->loadObjectList();

   foreach($res5 as $value_des5)
        {
        $placeofdeparture = $value_des5->placeofdeparture;
        $id =$value_des5->id;
         echo '<option value='.$id.'>'.$placeofdeparture.'</option>';
        }
   ?>
		</select>
	</div>
  </div> -->

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

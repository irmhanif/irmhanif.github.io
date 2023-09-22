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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
//JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_semicustomized/css/form.css');
$db = JFactory::getDbo();
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

<?php

 	$cuid=$this->item->id;
	if($cuid)
	{
		$sql_getplaid="SELECT * FROM `#__semicustomized_trip` WHERE state='1' AND id=$cuid";
		$db->setQuery($sql_getplaid);
		$getplaid_res=$db->loadObjectList();

		foreach($getplaid_res as $getplaid_disp) {
			$planning1=$getplaid_disp->planning1;
			$planning2=$getplaid_disp->planning2;
			$planning3=$getplaid_disp->planning3;
			$planning4=$getplaid_disp->planning4;
		}
		if($planning1==''){
			$planning1='';
		}
		if($planning2==''){
			$planning2='';
		}
		if($planning3==''){
			$planning3='';
		}
		if($planning4==''){
			$planning4='';
		}
	} else {
		$planning1=$planning2=$planning3=$planning4='';
	}

?>

<form
	action="<?php echo JRoute::_('index.php?option=com_semicustomized&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="trip-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SEMICUSTOMIZED_TITLE_TRIP', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>
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
					<input type="hidden" name="jform[image_hidden]" id="jform_image_hidden" value="<?php echo implode(',', $imageFiles); ?>" />
				<?php endif; ?>

				<?php echo $this->form->renderField('images'); ?>

				<?php if (!empty($this->item->images)) : ?>
					<?php $imagesFiles = array(); ?>
					<?php foreach ((array)$this->item->images as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'trip_gallery_banner' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $imagesFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[images_hidden]" id="jform_images_hidden" value="<?php echo implode(',', $imagesFiles); ?>" />
				<?php endif; ?>

				<?php echo $this->form->renderField('peoplecapacity'); ?>
				<?php echo $this->form->renderField('peoplecapacitymax'); ?>
				
				<?php echo $this->form->renderField('carrousselselection'); ?>
				<?php echo $this->form->renderField('shortdescription'); ?>
				<?php echo $this->form->renderField('longdescription'); ?>
				<?php echo $this->form->renderField('keeperconsumer'); ?>
				<?php echo $this->form->renderField('nokeeperconsumer'); ?>
				<?php echo $this->form->renderField('transportconsumer'); ?>
				<?php echo $this->form->renderField('notransportconsumer'); ?>
				<?php echo $this->form->renderField('hotelconsumer'); ?>
				<?php // echo $this->form->renderField('nohotelconsumer'); ?>

				<div class="control-group">
		<div class="control-label">
		    <label id="jform_planning1-lbl" for="jform_planning1"> Planning 1</label>
        </div>
    	<div class="controls">
    	    <select id="jform_planning1" name="jform[planning1]">
    	        <option value="">Select Planning</option>
    	        <?php
    	        $connectdb = JFactory::getDbo();

    	        $getsql="SELECT * FROM `#__semicustomized_plan` WHERE state='1'";
    	        $connectdb->setQuery($getsql);
    	        $arr=$connectdb->loadObjectList();

    	        foreach($arr as $dis_plan){
    	            $id=$dis_plan->id;
    	            $reference=$dis_plan->reference;

    	            echo '<option value="'.$id.'">'.$reference.'</option>';
    	        }

    	        ?>
            </select>
        </div>
    </div>
				<?php echo $this->form->renderField('dayplanning1'); ?>

    <div class="control-group">
		<div class="control-label">
		    <label id="jform_planning2-lbl" for="jform_planning2"> Planning 2</label>
        </div>
    	<div class="controls">
    	    <select id="jform_planning2" name="jform[planning2]">
    	        <option value="">Select Planning</option>
    	        <?php
    	        $connectdb = JFactory::getDbo();

    	        $getsql="SELECT * FROM `#__semicustomized_plan` WHERE state='1'";
    	        $connectdb->setQuery($getsql);
    	        $arr=$connectdb->loadObjectList();

    	        foreach($arr as $dis_plan){
    	            $id=$dis_plan->id;
    	            $reference=$dis_plan->reference;

    	            echo '<option value="'.$id.'">'.$reference.'</option>';
    	        }


    	        ?>
            </select>
        </div>
    </div>
				<?php echo $this->form->renderField('dayplanning2'); ?>

				    <div class="control-group">
		<div class="control-label">
		    <label id="jform_planning3-lbl" for="jform_planning3"> Planning 2</label>
        </div>
    	<div class="controls">
    	    <select id="jform_planning3" name="jform[planning3]">
    	        <option value="">Select Planning</option>
    	        <?php
    	        $connectdb = JFactory::getDbo();

    	        $getsql="SELECT * FROM `#__semicustomized_plan` WHERE state='1'";
    	        $connectdb->setQuery($getsql);
    	        $arr=$connectdb->loadObjectList();

    	        foreach($arr as $dis_plan){
    	            $id=$dis_plan->id;
    	            $reference=$dis_plan->reference;

    	            echo '<option value="'.$id.'">'.$reference.'</option>';
    	        }
    	        ?>
            </select>
        </div>
    </div>
				<?php echo $this->form->renderField('dayplanning3'); ?>
				    <div class="control-group">
		<div class="control-label">
		    <label id="jform_planning4-lbl" for="jform_planning4"> Planning 2</label>
        </div>
    	<div class="controls">
    	    <select id="jform_planning4" name="jform[planning4]">
    	        <option value="">Select Planning</option>
    	        <?php
    	        $connectdb = JFactory::getDbo();

    	        $getsql="SELECT * FROM `#__semicustomized_plan` WHERE state='1'";
    	        $connectdb->setQuery($getsql);
    	        $arr=$connectdb->loadObjectList();

    	        foreach($arr as $dis_plan){
    	            $id=$dis_plan->id;
    	            $reference=$dis_plan->reference;

    	            echo '<option value="'.$id.'">'.$reference.'</option>';
    	        }
    	        ?>
            </select>
        </div>
    </div>
				<?php echo $this->form->renderField('dayplanning4'); ?>


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

<script>

jQuery(document).ready(function(){
	jQuery("#jform_planning1").change(function(){
		var planning1=jQuery("#jform_planning1").val();
		jQuery.post("index.php?option=com_semicustomized&task=trips.planCount1&planning1="+planning1,daycout1);
	});
	jQuery("#jform_planning2").change(function(){
		var planning2=jQuery("#jform_planning2").val();
		jQuery.post("index.php?option=com_semicustomized&task=trips.planCount2&planning2="+planning2,daycout2);
	});
	jQuery("#jform_planning3").change(function(){
		var planning3=jQuery("#jform_planning3").val();
		jQuery.post("index.php?option=com_semicustomized&task=trips.planCount3&planning3="+planning3,daycout3);
	});
		jQuery("#jform_planning4").change(function(){
		var planning4=jQuery("#jform_planning4").val();
		jQuery.post("index.php?option=com_semicustomized&task=trips.planCount4&planning4="+planning4,daycout4);
	});

	function daycout1(stext,status)
		{
			if(status=='success')
			{
				jQuery("#jform_dayplanning1").val(stext);
			}
		}
	function daycout2(stext,status)
		{
			if(status=='success')
			{
				jQuery("#jform_dayplanning2").val(stext);
			}
		}
	function daycout3(stext,status)
		{
			if(status=='success')
			{
				jQuery("#jform_dayplanning3").val(stext);
			}
		}
	function daycout4(stext,status)
		{
			if(status=='success')
			{
				jQuery("#jform_dayplanning4").val(stext);
			}
		}
});
</script>

<script>
jQuery.noConflict();
jQuery(document).ready(function(){

		/* selected == to selected */
		var select_status="<?php echo $planning1; ?>";
		var splt_selectitem= select_status.split(',');
		var cnt=splt_selectitem.length;
		for(var i=0;i<cnt;i++)
		{
			jQuery("#jform_planning1 option").each(function()
			{
				var cac=splt_selectitem[i];
				if( jQuery(this).val() == cac )
				{
					jQuery(this).attr("selected","selected");
				}
			});
		}

				/* selected == to selected */
		var select_status="<?php echo $planning2; ?>";
		var splt_selectitem= select_status.split(',');
		var cnt=splt_selectitem.length;
		for(var i=0;i<cnt;i++) {
			jQuery("#jform_planning2 option").each(function()
			{
				var cac=splt_selectitem[i];
				if( jQuery(this).val() == cac )
				{
					jQuery(this).attr("selected","selected");
				}
			});
		}

					/* selected == to selected */
		var select_status="<?php echo $planning3; ?>";
		var splt_selectitem= select_status.split(',');
		var cnt=splt_selectitem.length;
		for(var i=0;i<cnt;i++) {
			jQuery("#jform_planning3 option").each(function()
			{
				var cac=splt_selectitem[i];
				if( jQuery(this).val() == cac )
				{
					jQuery(this).attr("selected","selected");
				}
			});
		}

			/* selected == to selected */
		var select_status="<?php echo $planning4; ?>";
		var splt_selectitem= select_status.split(',');
		var cnt=splt_selectitem.length;
		for(var i=0;i<cnt;i++) {
			jQuery("#jform_planning4 option").each(function()
			{
				var cac=splt_selectitem[i];
				if( jQuery(this).val() == cac )
				{
					jQuery(this).attr("selected","selected");
				}
			});
		}

	});
</script>
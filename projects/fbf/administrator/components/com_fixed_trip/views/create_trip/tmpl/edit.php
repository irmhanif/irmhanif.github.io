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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
// JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$db = JFactory::getDBO();
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_fixed_trip/css/form.css');
 $thisid=$this->item->id;
 if($thisid) {
 	$sql="SELECT type FROM `#__create_trip` WHERE state='1' AND id=$thisid";
 	$db->setQuery($sql);
 	$res=$db->loadResult();

 	$sql = "select title,id from `#__type_category` where state='1' AND id = $res";
 	$db -> setQuery($sql);
 	$res1 = $db->loadObjectList();
 	foreach ($res1 as $res) {
 		$title = $res -> title;
 		$id = $res -> id;
 		$opt = '<option value='.$id.' selected="selected">'.$title.'</option>';
 	}
 } else {
 	$opt = '<option value="" selected="selected"></option>';
 }


if($thisid)
	{
		$sql_getplaid="SELECT * FROM `#__create_trip` WHERE state=1 AND id=$thisid";
		$db->setQuery($sql_getplaid);
		$getplaid_res=$db->loadObjectList();

		foreach($getplaid_res as $getplaid_disp) {
			$planning1=$getplaid_disp->planning1;
			$planning2=$getplaid_disp->planning2;
			$planning3=$getplaid_disp->planning3;
			$planning4=$getplaid_disp->planning4;
			$planning5=$getplaid_disp->planning5;
			$planning6=$getplaid_disp->planning6;
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
		if($planning5==''){
			$planning5='';
		}
		if($planning6==''){
			$planning6='';
		}
	} else {
		$planning1=$planning2=$planning3=$planning4=$planning5=$planning6='';
	}


?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {

	});

	Joomla.submitbutton = function (task) {
		if (task == 'create_trip.cancel') {
			Joomla.submitform(task, document.getElementById('create_trip-form'));
		}
		else {

			if (task != 'create_trip.cancel' && document.formvalidator.isValid(document.id('create_trip-form'))) {

				Joomla.submitform(task, document.getElementById('create_trip-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_fixed_trip&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="create_trip-form" class="form-validate">
	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_FIXED_TRIP_TITLE_CREATE_TRIP', true)); ?>
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
				<?php echo $this->form->renderField('description'); ?>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_type-lbl" for="jform_type">Type</label>
					</div>
					<div class="controls">
						<select id="jform_type" name="jform[type]">

							<?php
							echo $opt;
							/*echo "<script>var a = '$res'; alert(a);</script>";*/
							$sql = "select * from `#__type_category` where state='1'";
							$db -> setQuery($sql);
							$result = $db->loadObjectList();
							foreach ($result as $resultval) {
								$id = $resultval->id;
								$title = $resultval->title;
								echo "<option value='$id'>$title</option>";
							}
							?>
						</select>
					</div>
				</div>
				<!--date 1-->
				<h1>Date 1</h1>
				<?php echo $this->form->renderField('date_of_departure1'); ?>
				<?php echo $this->form->renderField('price_person1'); ?>
				<?php // echo $this->form->renderField('price_single_room_extra1'); ?>
				<?php echo $this->form->renderField('cost_hotel1'); ?>
				<?php echo $this->form->renderField('cost_activites1'); ?>
				<?php echo $this->form->renderField('cost_transport1'); ?>
				<?php echo $this->form->renderField('cost_keeper1'); ?>
				<?php echo $this->form->renderField('cost_booking_fee1'); ?>
				<?php echo $this->form->renderField('cost_insurance1'); ?>
				<?php echo $this->form->renderField('extracosti1'); ?>
				<?php echo $this->form->renderField('extracostii1'); ?>
				<?php echo $this->form->renderField('pdfplanning1'); ?>
				<?php if (!empty($this->item->pdfplanning1)) : ?>
					<?php $pdfplanning1Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning1 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $pdfplanning1Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[pdfplanning1_hidden]" id="jform_pdfplanning1_hidden" value="<?php echo implode(',', $pdfplanning1Files); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('seat_available1'); ?>
				<?php echo $this->form->renderField('keeper1'); ?>
				<?php echo $this->form->renderField('transport1'); ?>
				<?php echo $this->form->renderField('hotel1'); ?>
				<?php echo $this->form->renderField('inclusion1'); ?>
				<?php echo $this->form->renderField('noinclusion1'); ?>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_planning1-lbl" for="jform_planning1">Planning 1</label>
					</div>
					<div class="controls"><select id="jform_planning1" name="jform[planning1]">
						<option value="" selected="selected">select</option>
						<?php
						$sql = "select * from `#__fixed_trip_planning` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							$no_of_days = $resultval->no_of_days;
							echo "<option value='$id'>Plan: $reference -> Days: $no_of_days</option>";

						}

						?>
					</select>
				</div>
			</div>
				<?php //echo $this->form->renderField('number_of_day1'); ?>
				<!-- end of date1-->


				<!--date 2-->
				<h1>Date 2</h1>
				<?php echo $this->form->renderField('date_of_departure2'); ?>
				<?php echo $this->form->renderField('price_person2'); ?>
				<?php // echo $this->form->renderField('price_single_room_extra2'); ?>
				<?php echo $this->form->renderField('cost_hotel2'); ?>
				<?php echo $this->form->renderField('cost_activites2'); ?>
				<?php echo $this->form->renderField('cost_transport2'); ?>
				<?php echo $this->form->renderField('cost_keeper2'); ?>
				<?php echo $this->form->renderField('cost_booking_fee2'); ?>
				<?php echo $this->form->renderField('cost_insurance2'); ?>
				<?php echo $this->form->renderField('extracosti2'); ?>
				<?php echo $this->form->renderField('extracostii2'); ?>
				<?php echo $this->form->renderField('pdfplanning2'); ?>

				<?php if (!empty($this->item->pdfplanning2)) : ?>
					<?php $pdfplanning2Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning2 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $pdfplanning2Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[pdfplanning2_hidden]" id="jform_pdfplanning2_hidden" value="<?php echo implode(',', $pdfplanning2Files); ?>" />
				<?php endif; ?>
				<?php echo $this->form->renderField('seat_available2'); ?>
				<?php echo $this->form->renderField('keeper2'); ?>
				<?php echo $this->form->renderField('transport2'); ?>
				<?php echo $this->form->renderField('hotel2'); ?>
				<?php echo $this->form->renderField('inclusion2'); ?>
				<?php echo $this->form->renderField('noinclusion2'); ?>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_planning2-lbl" for="jform_planning2">Planning 2</label>
					</div>
					<div class="controls"><select id="jform_planning2" name="jform[planning2]">
						<option value="" selected="selected">select</option>
						<?php
						$sql = "select * from `#__fixed_trip_planning` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							$no_of_days = $resultval->no_of_days;
							echo "<option value='$id'>Plan: $reference -> Days: $no_of_days</option>";
						}
						?>
					</select>
				</div>
			</div>
				<?php //echo $this->form->renderField('number_of_day2'); ?>
				<!-- end of date2-->


				<!--date 3-->
				<h1>Date 3</h1>
				<?php echo $this->form->renderField('date_of_departure3'); ?>
				<?php echo $this->form->renderField('price_person3'); ?>
				<?php // echo $this->form->renderField('price_single_room_extra3'); ?>
				<?php echo $this->form->renderField('cost_hotel3'); ?>
				<?php echo $this->form->renderField('cost_activites3'); ?>
				<?php echo $this->form->renderField('cost_transport3'); ?>
				<?php echo $this->form->renderField('cost_keeper3'); ?>
				<?php echo $this->form->renderField('cost_booking_fee3'); ?>
				<?php echo $this->form->renderField('cost_insurance3'); ?>
				<?php echo $this->form->renderField('extracosti3'); ?>
				<?php echo $this->form->renderField('extracostii3'); ?>
				<?php echo $this->form->renderField('pdfplanning3'); ?>

				<?php if (!empty($this->item->pdfplanning3)) : ?>
					<?php $pdfplanning3Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning3 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $pdfplanning3Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[pdfplanning3_hidden]" id="jform_pdfplanning3_hidden" value="<?php echo implode(',', $pdfplanning3Files); ?>" />
				<?php endif; ?>
				<?php echo $this->form->renderField('seat_available3'); ?>
				<?php echo $this->form->renderField('keeper3'); ?>
				<?php echo $this->form->renderField('transport3'); ?>
				<?php echo $this->form->renderField('hotel3'); ?>
				<?php echo $this->form->renderField('inclusion3'); ?>
				<?php echo $this->form->renderField('noinclusion3'); ?>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_planning3-lbl" for="jform_planning3">Planning 3</label>
					</div>
					<div class="controls"><select id="jform_planning3" name="jform[planning3]">
						<option value="" selected="selected">select</option>
						<?php
						$sql = "select * from `#__fixed_trip_planning` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							$no_of_days = $resultval->no_of_days;
							echo "<option value='$id'>Plan: $reference -> Days: $no_of_days</option>";
						}
						?>
					</select>
				</div>
			</div>
				<?php //echo $this->form->renderField('number_of_day3'); ?>
				<!-- end of date3-->

				<!--date 4-->
				<h1>Date 4</h1>
				<?php echo $this->form->renderField('date_of_departure4'); ?>
				<?php echo $this->form->renderField('price_person4'); ?>
				<?php // echo $this->form->renderField('price_single_room_extra4'); ?>
				<?php echo $this->form->renderField('cost_hotel4'); ?>
				<?php echo $this->form->renderField('cost_activites4'); ?>
				<?php echo $this->form->renderField('cost_transport4'); ?>
				<?php echo $this->form->renderField('cost_keeper4'); ?>
				<?php echo $this->form->renderField('cost_booking_fee4'); ?>
				<?php echo $this->form->renderField('cost_insurance4'); ?>
				<?php echo $this->form->renderField('extracosti4'); ?>
				<?php echo $this->form->renderField('extracostii4'); ?>
				<?php echo $this->form->renderField('pdfplanning4'); ?>

				<?php if (!empty($this->item->pdfplanning4)) : ?>
					<?php $pdfplanning4Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning4 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $pdfplanning4Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[pdfplanning4_hidden]" id="jform_pdfplanning4_hidden" value="<?php echo implode(',', $pdfplanning4Files); ?>" />
				<?php endif; ?>
				<?php echo $this->form->renderField('seat_available4'); ?>
				<?php echo $this->form->renderField('keeper4'); ?>
				<?php echo $this->form->renderField('transport4'); ?>
				<?php echo $this->form->renderField('hotel4'); ?>
				<?php echo $this->form->renderField('inclusion4'); ?>
				<?php echo $this->form->renderField('noinclusion4'); ?>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_planning4-lbl" for="jform_planning4">Planning 4</label>
					</div>
					<div class="controls"><select id="jform_planning4" name="jform[planning4]">
						<option value="" selected="selected">select</option>
						<?php
						$sql = "select * from `#__fixed_trip_planning` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							$no_of_days = $resultval->no_of_days;
							echo "<option value='$id'>Plan: $reference -> Days: $no_of_days</option>";
						}
						?>
					</select>
				</div>
			</div>
				<?php //echo $this->form->renderField('number_of_day4'); ?>
				<!-- end of date4-->

				<!--date 5-->
				<h1>Date 5</h1>
				<?php echo $this->form->renderField('date_of_departure5'); ?>
				<?php echo $this->form->renderField('price_person5'); ?>
				<?php // echo $this->form->renderField('price_single_room_extra5'); ?>
				<?php echo $this->form->renderField('cost_hotel5'); ?>
				<?php echo $this->form->renderField('cost_activites5'); ?>
				<?php echo $this->form->renderField('cost_transport5'); ?>
				<?php echo $this->form->renderField('cost_keeper5'); ?>
				<?php echo $this->form->renderField('cost_booking_fee5'); ?>
				<?php echo $this->form->renderField('cost_insurance5'); ?>
				<?php echo $this->form->renderField('extracosti5'); ?>
				<?php echo $this->form->renderField('extracostii5'); ?>
				<?php echo $this->form->renderField('pdfplanning5'); ?>

				<?php if (!empty($this->item->pdfplanning5)) : ?>
					<?php $pdfplanning5Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning5 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $pdfplanning5Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[pdfplanning5_hidden]" id="jform_pdfplanning5_hidden" value="<?php echo implode(',', $pdfplanning5Files); ?>" />
				<?php endif; ?>
				<?php echo $this->form->renderField('seat_available5'); ?>
				<?php echo $this->form->renderField('keeper5'); ?>
				<?php echo $this->form->renderField('transport5'); ?>
				<?php echo $this->form->renderField('hotel5'); ?>
				<?php echo $this->form->renderField('inclusion5'); ?>
				<?php echo $this->form->renderField('noinclusion5'); ?>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_planning5-lbl" for="jform_planning5">Planning 5</label>
					</div>
					<div class="controls"><select id="jform_planning5" name="jform[planning5]">
						<option value="" selected="selected">select</option>
						<?php
						$sql = "select * from `#__fixed_trip_planning` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							$no_of_days = $resultval->no_of_days;
							echo "<option value='$id'>Plan: $reference -> Days: $no_of_days</option>";
						}
						?>
					</select>
				</div>
			</div>
				<?php //echo $this->form->renderField('number_of_day5'); ?>
				<!-- end of date5-->

				<!--date 6-->
				<h1>Date 6</h1>
				<?php echo $this->form->renderField('date_of_departure6'); ?>
				<?php echo $this->form->renderField('price_person6'); ?>
				<?php // echo $this->form->renderField('price_single_room_extra6'); ?>
				<?php echo $this->form->renderField('cost_hotel6'); ?>
				<?php echo $this->form->renderField('cost_activites6'); ?>
				<?php echo $this->form->renderField('cost_transport6'); ?>
				<?php echo $this->form->renderField('cost_keeper6'); ?>
				<?php echo $this->form->renderField('cost_booking_fee6'); ?>
				<?php echo $this->form->renderField('cost_insurance6'); ?>
				<?php echo $this->form->renderField('extracosti6'); ?>
				<?php echo $this->form->renderField('extracostii6'); ?>
				<?php echo $this->form->renderField('pdfplanning6'); ?>

				<?php if (!empty($this->item->pdfplanning6)) : ?>
					<?php $pdfplanning6Files = array(); ?>
					<?php foreach ((array)$this->item->pdfplanning6 as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Fixed_Planning_pdf' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> |
							<?php $pdfplanning6Files[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[pdfplanning6_hidden]" id="jform_pdfplanning6_hidden" value="<?php echo implode(',', $pdfplanning6Files); ?>" />
				<?php endif; ?>
				<?php echo $this->form->renderField('seat_available6'); ?>
				<?php echo $this->form->renderField('keeper6'); ?>
				<?php echo $this->form->renderField('transport6'); ?>
				<?php echo $this->form->renderField('hotel6'); ?>
				<?php echo $this->form->renderField('inclusion6'); ?>
				<?php echo $this->form->renderField('noinclusion6'); ?>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_planning6-lbl" for="jform_planning6">Planning 1</label>
					</div>
					<div class="controls"><select id="jform_planning6" name="jform[planning6]">
						<option value="" selected="selected">select</option>
						<?php
						$sql = "select * from `#__fixed_trip_planning` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							$no_of_days = $resultval->no_of_days;
							echo "<option value='$id'>Plan: $reference -> Days: $no_of_days</option>";
						}
						?>
					</select>
				</div>
			</div>
				<?php //echo $this->form->renderField('number_of_day6'); ?>
				<!-- end of date6-->


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

			/* selected == to selected */
		var select_status="<?php echo $planning5; ?>";
		var splt_selectitem= select_status.split(',');
		var cnt=splt_selectitem.length;
		for(var i=0;i<cnt;i++) {
			jQuery("#jform_planning5 option").each(function()
			{
				var cac=splt_selectitem[i];
				if( jQuery(this).val() == cac )
				{
					jQuery(this).attr("selected","selected");
				}
			});
		}
			/* selected == to selected */
		var select_status="<?php echo $planning6; ?>";
		var splt_selectitem= select_status.split(',');
		var cnt=splt_selectitem.length;
		for(var i=0;i<cnt;i++) {
			jQuery("#jform_planning6 option").each(function()
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

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
JHtml::_('formbehavior.chosen', 'select');
//JHtml::_('behavior.keepalive');
$db = JFactory::getDBO();
$id = JRequest::getVar('id');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_fixed_trip/css/form.css');
 $thisid=$this->item->id;

	if($thisid){
	$sql="SELECT * FROM `#__fixed_trip_planning` WHERE state='1' AND id=$thisid";
		$db->setQuery($sql);
	$res=$db->loadObjectList();

	foreach ($res as $ress) {
		$day1 = $ress->days1;
		$day2 = $ress->days2;

		$day3 = $ress->days3;
		$day4 = $ress->days4;
		$day5 = $ress->days5;
		$day6 = $ress->days6;
		$day7 = $ress->days7;
		$day8 = $ress->days8;
		$day9 = $ress->days9;
		$day10 = $ress->days10;
		$day11 = $ress->days11;
		$day12 = $ress->days12;
		$day13 = $ress->days13;
		$day14 = $ress->days14;
		$day15 = $ress->days15;
		$day16 = $ress->days16;
		$day17 = $ress->days17;
		$day18 = $ress->days18;
		$day19 = $ress->days19;
		$day20 = $ress->days20;

	}



$opt ='';
}
else{
	$opt = '<option value="" selected="selected"></option>';
}
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {

	});

	Joomla.submitbutton = function (task) {
		if (task == 'create_planning.cancel') {
			Joomla.submitform(task, document.getElementById('create_planning-form'));
		}
		else {

			if (task != 'create_planning.cancel' && document.formvalidator.isValid(document.id('create_planning-form'))) {

				Joomla.submitform(task, document.getElementById('create_planning-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_fixed_trip&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="create_planning-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_FIXED_TRIP_TITLE_CREATE_PLANNING', true)); ?>
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
				<?php echo $this->form->renderField('reference'); ?>
				<?php echo $this->form->renderField('title'); ?>
				<?php echo $this->form->renderField('no_of_days'); ?>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days1-lbl" for="jform_days1">Days 1</label>
					</div>
					<div class="controls">
						<select id="jform_days1" name="jform[days1]">

						<?php
						echo $opt;
						/*echo "<script>var a = '$day1'; alert(a);</script>";*/
						if($day1 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id' selected='selected'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}

						?>
						</select>
					</div>
				</div>
				 <!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days2-lbl" for="jform_days2">Days 2</label>
					</div>
					<div class="controls">
						<select id="jform_days2" name="jform[days2]">

						<?php
						echo $opt;
						/*echo "<script>var a = '$day1'; alert(a);</script>";*/
						if($day2 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day2'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day2'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}

						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days3-lbl" for="jform_days3">Days 3</label>
					</div>
					<div class="controls">
						<select id="jform_days3" name="jform[days3]">

						<?php

						echo $opt;
						if($day3 == ''){

							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day3'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day3'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}

						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days4-lbl" for="jform_days4">Days 4</label>
					</div>
					<div class="controls">
						<select id="jform_days4" name="jform[days4]">

						<?php
						echo $opt;

						if($day4 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day4'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day4'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}

						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days5-lbl" for="jform_days5">Days 5</label>
					</div>
					<div class="controls">
						<select id="jform_days5" name="jform[days5]">

						<?php
						echo $opt;

						if($day5 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day5'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day5'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}

						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days6-lbl" for="jform_days6">Days 6</label>
					</div>
					<div class="controls">
						<select id="jform_days6" name="jform[days6]">

						<?php
						echo $opt;

						if($day6 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day6'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day6'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}

						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days7-lbl" for="jform_days7">Days 7</label>
					</div>
					<div class="controls">
						<select id="jform_days7" name="jform[days7]">

						<?php
						echo $opt;

						if($day7 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day7'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day7'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}

						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days8-lbl" for="jform_days8">Days 8</label>
					</div>
					<div class="controls">
						<select id="jform_days8" name="jform[days8]">

						<?php
						echo $opt;

						if($day8 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day8'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day8'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}

						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days2-lb9" for="jform_days9">Days 9</label>
					</div>
					<div class="controls">
						<select id="jform_days9" name="jform[days9]">

						<?php
						echo $opt;

						if($day9 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day9'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day9'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days10-lbl" for="jform_days10">Days 10</label>
					</div>
					<div class="controls">
						<select id="jform_days10" name="jform[days10]">

						<?php
						echo $opt;

						if($day10 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day10'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day10'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days11-lbl" for="jform_days11">Days 11</label>
					</div>
					<div class="controls">
						<select id="jform_days11" name="jform[days11]">

						<?php
						echo $opt;

						if($day11 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day11'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day11'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days12-lbl" for="jform_days12">Days 12</label>
					</div>
					<div class="controls">
						<select id="jform_days12" name="jform[days12]">

						<?php
						echo $opt;

						if($day12 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day12'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day12'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days13-lbl" for="jform_days13">Days 13</label>
					</div>
					<div class="controls">
						<select id="jform_days13" name="jform[days13]">

						<?php
						echo $opt;

						if($day13 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day13'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day13'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days14-lbl" for="jform_days14">Days 14</label>
					</div>
					<div class="controls">
						<select id="jform_days14" name="jform[days14]">

						<?php
						echo $opt;

						if($day14 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day14'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day15'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days15-lbl" for="jform_days15">Days 15</label>
					</div>
					<div class="controls">
						<select id="jform_days15" name="jform[days15]">

						<?php
						echo $opt;

						if($day15 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day15'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day15'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days16-lbl" for="jform_days16">Days 16</label>
					</div>
					<div class="controls">
						<select id="jform_days16" name="jform[days16]">

						<?php
						echo $opt;

						if($day16 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day16'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day16'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days17-lbl" for="jform_days17">Days 17</label>
					</div>
					<div class="controls">
						<select id="jform_days17" name="jform[days17]">

						<?php
						echo $opt;

						if($day17 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day17'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day17'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days18-lbl" for="jform_days18">Days 18</label>
					</div>
					<div class="controls">
						<select id="jform_days18" name="jform[days18]">

						<?php
						echo $opt;

						if($day18 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day18'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day18'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days19-lbl" for="jform_days19">Days 19</label>
					</div>
					<div class="controls">
						<select id="jform_days19" name="jform[days19]">

						<?php
						echo $opt;

						if($day19 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day19'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day19'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>
				<!----Next Dropdown ------>
				<div class="control-group">
					<div class="control-label">
						<label id="jform_days20-lbl" for="jform_days20">Days 20</label>
					</div>
					<div class="controls">
						<select id="jform_days20" name="jform[days20]">

						<?php
						echo $opt;

						if($day20 == ''){
							echo '<option value="" selected="selected"></option>';
						$sql = "select * from `#__fixed_trip_days` where state='1'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						} else {
						$sql = "select * from `#__fixed_trip_days` where state='1' AND id = '$day20'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>";
							$sql = "select * from `#__fixed_trip_days` where state='1' AND id !='$day20'";
						$db -> setQuery($sql);
						$result = $db->loadObjectList();
						foreach ($result as $resultval) {
							$id = $resultval->id;
							$reference = $resultval->reference;
							echo "<option value='$id'>$reference</option>"; }
						}
            echo '<option value="" >No plan</option>';
						}
						?>
						</select>
					</div>
				</div>

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

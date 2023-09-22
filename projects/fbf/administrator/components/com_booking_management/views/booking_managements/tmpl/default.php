<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
$db = JFactory::getDbo();
?>
<script>
function openCity(evt, cityName) {
	var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	document.getElementById(cityName).style.display = "block";
	evt.currentTarget.className += " active";
}
</script>
<div class="booking_management">

<div class="tab">
  <button class="tablinks active" onclick="openCity(event, 'London')">Customized Trip</button>
  <button class="tablinks" onclick="openCity(event, 'Paris')">Semi Customized</button>
  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Fixed Trip</button>
</div>
<div class="booked_details">

<div id="London" class="tabcontent" style="display:block;">
	<div class="filter">
			<p>
			    <span>Customer Name :</span>
				<input type="text" value="" name="cname" id="cname" />
			</p>
			<p>
				<span>Customer Number :</span>
				<input type="text" value="" name="cnum" id="cnum" /><br>
		    </p>
			<p>	<span> From </span><input type="text" name="satrtdate" id="satrtdate" />&nbsp;<span> To :</span><input type="text" name="enddate" id="enddate" /></p>

				<button id ="go">Search</button>

	</div>
	<div id="table_value1">
	</div>
</div>

<div id="Paris" class="tabcontent">
	<div class="filter">
				<p>	<span>Customer Name :</span>
				<input type="text" value="" name="cname" id="cname2" />
				</p>
				<p>
				<span>Customer Number :</span>
				<input type="text" value="" name="cnum" id="cnum2" /><br>
				</p>
				<p>
				<span> From :</span><input type="text" name="satrtdate" id="satrtdate2" />&nbsp;
				<span> To </span><input type="text" name="enddate" id="enddate2" />
                </p>
				<button id ="go2">Search</button>

	</div>
	<div id="table_value2">
	</div>
</div>

<div id="Tokyo" class="tabcontent">
	<div class="filter">
	            <p>
				<span>Customer Name :</span>
				<input type="text" value="" name="cname" id="cname3" />
				</p>
				<p>
				<span>Customer Number :</span>
				<input type="text" value="" name="cnum" id="cnum3" />
				</p>
				<p>
				<span> From :</span><input type="text" name="satrtdate" id="satrtdate3" />&nbsp;
				<span> To </span><input type="text" name="enddate" id="enddate3" />
                </p>
				<button id ="go3">Search</button>

	</div>
	<div id="table_value3">
	</div>
</div>


</div>
</div>
<script>

jQuery(document).ready(function(){
	var name = '';
	var cnum = '';
	var satrtdate="";
	var enddate="";
	var delorder="";
	jQuery.post("index.php?option=com_booking_management&task=booking_managements.filters1&name="+name+"&cnum="+cnum+"&satrtdate="+satrtdate+"&enddate="+enddate+"&delorder="+delorder,filtres);
	jQuery("#go").click(function(){
		var name = jQuery("#cname").val();
		var cnum = jQuery("#cnum").val();
		var satrtdate=jQuery("#satrtdate").val();
		var enddate=jQuery("#enddate").val();
		var delorder="";
		jQuery.post("index.php?option=com_booking_management&task=booking_managements.filters1&name="+name+"&cnum="+cnum+"&satrtdate="+satrtdate+"&enddate="+enddate+"&delorder="+delorder,filtres);
	});

	jQuery('body').on('click', '.delete_corder', function(event) {
		var delorder = jQuery(this).val();
		var name = jQuery("#cname").val();
		var cnum = jQuery("#cnum").val();
		var satrtdate=jQuery("#satrtdate").val();
		var enddate=jQuery("#enddate").val();
		jQuery.post("index.php?option=com_booking_management&task=booking_managements.filters1&name="+name+"&cnum="+cnum+"&satrtdate="+satrtdate+"&enddate="+enddate+"&delorder="+delorder,filtres);
    });

function filtres(stext,status){
	if(status=="success"){
		jQuery("#table_value1").html(stext);
	}
}

});
jQuery(document).ready(function(){
	var name = '';
	var cnum = '';
	var satrtdate="";
	var enddate="";
	var delorder="";
	var duid = "";
	jQuery.post("index.php?option=com_booking_management&task=booking_managements.filters2&name="+name+"&cnum="+cnum+"&satrtdate="+satrtdate+"&enddate="+enddate+"&delorder="+delorder+"&duid="+duid,filtres);
	jQuery("#go2").click(function(){
		var name = jQuery("#cname2").val();
		var cnum = jQuery("#cnum2").val();
		var satrtdate=jQuery("#satrtdate2").val();
		var enddate=jQuery("#enddate2").val();
		var delorder = "";
		var duid = "";
		jQuery.post("index.php?option=com_booking_management&task=booking_managements.filters2&name="+name+"&cnum="+cnum+"&satrtdate="+satrtdate+"&enddate="+enddate+"&delorder="+delorder+"&duid="+duid,filtres);
	});

	jQuery('body').on('click', '.delete_order', function(event) {
		var delorder = jQuery(this).val();
		var duid = jQuery(this).attr('id');
		var name = jQuery("#cname2").val();
		var cnum = jQuery("#cnum2").val();
		var satrtdate=jQuery("#satrtdate2").val();
		var enddate=jQuery("#enddate2").val();
		jQuery.post("index.php?option=com_booking_management&task=booking_managements.filters2&name="+name+"&cnum="+cnum+"&satrtdate="+satrtdate+"&enddate="+enddate+"&delorder="+delorder+"&duid="+duid,filtres);
    });


function filtres(stext,status){
	if(status=="success"){
		jQuery("#table_value2").html(stext);
	}
}

});



jQuery(document).ready(function(){
	var name = '';
	var cnum = '';
	var satrtdate="";
	var enddate="";
	var delorder="";
	jQuery.post("index.php?option=com_booking_management&task=booking_managements.filters3&name="+name+"&cnum="+cnum+"&satrtdate="+satrtdate+"&enddate="+enddate+"&delorder="+delorder,filtres);
	jQuery("#go3").click(function(){
		var name = jQuery("#cname3").val();
		var cnum = jQuery("#cnum3").val();
		var satrtdate=jQuery("#satrtdate3").val();
		var enddate=jQuery("#enddate3").val();
		var delorder="";
		jQuery.post("index.php?option=com_booking_management&task=booking_managements.filters3&name="+name+"&cnum="+cnum+"&satrtdate="+satrtdate+"&delorder="+delorder,filtres);
	});

	jQuery('body').on('click', '.delete_forder', function(event) {
		var delorder = jQuery(this).val();
		var name = jQuery("#cname").val();
		var cnum = jQuery("#cnum").val();
		var satrtdate=jQuery("#satrtdate").val();
		var enddate=jQuery("#enddate").val();
		jQuery.post("index.php?option=com_booking_management&task=booking_managements.filters3&name="+name+"&cnum="+cnum+"&satrtdate="+satrtdate+"&delorder="+delorder,filtres);
    });

function filtres(stext,status){
	if(status=="success"){
		jQuery("#table_value3").html(stext);
	}
}



});

</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
jQuery(document).ready(function(){
jQuery( "#satrtdate" ).datepicker({ dateFormat: "dd-mm-yy"});
jQuery( "#enddate" ).datepicker({ dateFormat: "dd-mm-yy"});
jQuery( "#satrtdate2" ).datepicker({ dateFormat: "dd-mm-yy"});
jQuery( "#enddate2" ).datepicker({ dateFormat: "dd-mm-yy"});
jQuery( "#satrtdate3" ).datepicker({ dateFormat: "dd-mm-yy"});
jQuery( "#enddate3" ).datepicker({ dateFormat: "dd-mm-yy"});
	});
</script>
<style>
.hasDatepicker {
  margin: 5% 0;
  width: 29%;
}
#table_value1 {
  float: left;
  width: 100%;
}
#table_value2 {
  float: left;
  width: 100%;
}
#table_value3 {
  float: left;
  width: 100%;
}
.filter p {
  float: left;
  margin: 1% 0;
  width: 24%;
}
.filter button {
  background: #1a3867 none repeat scroll 0 0;
  border: medium none;
  color: #ffffff;
  float: left;
  margin: 1.9% 0;
  padding: 0.6% 0;
  text-transform: uppercase;
  width: 17%;
}
.tabcontent{
	display: none;
}
.booking_management {
	float: left;
	width: 100%;
}
.booking_management .tab {
	float: left;
	width: 15%;
}
tr:nth-child(even) {
    background-color: #dddddd;
}
.booking_management .booked_details {
	float: left;
	width: 84%;
	margin: 0 0 4em 20px;
}
.admin.com_booking_management.view-booking_managements .subhead-collapse.collapse {
	display: none;
}
.booked_details div table tr th {
    padding: 4px;
    width: 7%;
    text-align: left;
}
.booked_details div table tr td {
	padding: 7px;
	width: 15em;
	text-align: center;
}
.booking_management .tab {
	float: left;
	width: 13%;
	border: 1px solid #ccc;
	padding: 13px 0 13px 0;
	background: #f0f0f0;
}
.admin.com_booking_management.view-booking_managements .container-fluid{
	padding: 0;
}
.booking_management .tab button {
	padding: 8px 0 8px 15px;
	margin: 10px 0 10px 0;
	border: none;
	width: 100%;
	text-align: left;
	background: none;
	font-size: 15px;
	font-weight: 600;
	font-family: Sans-serif;
}
.tab .tablinks.active {
	background: #1a3867;
	margin: 10px 0;
	color: #fff;
	font-weight: 600;
}
</style>


<?php
$db = JFactory::getDbo();
$id = JRequest::getVar('id');
echo "<a href='index.php?option=com_booking_management&view=booking_managements'>BACK</a>";
$sqllist="SELECT * FROM `#__customized_order` WHERE  id=$id";
$db->setQuery($sqllist);
$result=$db->loadObjectList();
foreach($result as $data)
{
	$uid=$data->uid;
	$oid=$data->id;
	$cart=$data->cart_date;
	$time = strtotime($cart);
	$cart = date('d-m-Y',$time);
    $carts = date('H:i:s a',$time);
	$no_days=$data->no_days;
	$no_people=$data->no_people;
	$no_rooms=$data->no_room;
	$budget=$data->budget;
	$transport=$data->transport;
	$stay=$data->stay;
	$stay= str_replace('_',' ',$stay);
	$flight=$data->flight;
	$keeper=$data->keeper;
	$flight_amount=$data->flight_amount;

  $paydate1=$data->pay_date1;
  $txnid=$data->txnid;
  $paydate2=$data->pay_date2;
  $txnid2=$data->txnid2;

  $paytime1 = date ('H:i', strtotime($paydate1));
  $paydate1 = date ('Y-m-d', strtotime($paydate1));
  $paytime2 = date ('H:i', strtotime($paydate2));
  $paydate2 = date ('Y-m-d', strtotime($paydate2));
	if($flight_amount==0) {
		$flight_amount='';
	}

	$price_of_hotel=$data->price_of_hotel;
	if($price_of_hotel==0) {
		$price_of_hotel='';
	}

	$cost_of_activities=$data->cost_of_activities;
	if($cost_of_activities==0) {
		$cost_of_activities='';
	}
	$cost_of_transport=$data->cost_of_transport;
	if($cost_of_transport==0) {
		$cost_of_transport='';
	}

	$cost_of_Keeper = $data->cost_of_Keeper;
	if($cost_of_Keeper==0) {
		$cost_of_Keeper='';
	}

	$cost_of_booking_Fee=$data->cost_of_booking_Fee;
	if($cost_of_booking_Fee==0) {
		$cost_of_booking_Fee='';
	}
	$cost_of_insurance=$data->cost_of_insurance;
	if($cost_of_insurance==0) {
		$cost_of_insurance='';
	}
	$total_cost_tax_free=$data->total_cost_tax_free;
	if($total_cost_tax_free==0) {
		$total_cost_tax_free='';
	}

	$gstamount=$data->gst;
	if($gstamount==0) {
		$gstamount='';
	}
	$final_cost=$data->final_cost;
	if($final_cost==0) {
		$final_cost='';
	}

	$first_installement=$data->first_installement;
	if($first_installement==0) {
		$first_installement='';
	}

	$last_day_for_first_installement=$data->last_day_for_first_installement;
	if($last_day_for_first_installement==0) {
		$last_day_for_first_installement='';
	}

	$final_installement=$data->final_installement;
	if($final_installement== 0) {
		$final_installement='';
	}

	$last_day_for_final_installement=$data->last_day_for_final_installement;

	if($last_day_for_final_installement == 0) {
		$last_day_for_final_installement='';
	}

	$sql="SELECT * FROM `#__users` WHERE id=$uid";
	$db->setQuery($sql);
	$events_detail=$db->loadObjectList();
	foreach($events_detail as $event_disp) {
	    $userid=$event_disp->id;
		$username=$event_disp->name;
		$contact=$event_disp->phone;
		$mail=$event_disp->email;
	}
}

	$sqlgst="SELECT * FROM `#__common_price_management` WHERE state=1";
	$db->setQuery($sqlgst);
	$common_price_management_detail=$db->loadObjectList();
	foreach($common_price_management_detail as $pricemgt_disp) {
	    $gst=$pricemgt_disp->gst;
	}


  $lastfirstpaytime = date('H:i', strtotime($last_day_for_first_installement));
  $lastfinalpaytime = date('H:i', strtotime($last_day_for_final_installement));
  $last_day_for_first_installement = date('d-m-Y', strtotime($last_day_for_first_installement));
$last_day_for_final_installement = date('d-m-Y', strtotime($last_day_for_final_installement));
?>

<link rel="stylesheet" href="addons/date/css/style.css">

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css'>

    <div class="display_book_detail">
      <form action="#" Method="POST" name="bookingform" id="bookingform">
          <p>
              <span class="leftlabel">Name</span>
              <span class="righttext"><?php echo $username; ?></span>
          </p>
          <p>
              <span class="leftlabel">Number</span>
              <span class="righttext"><?php echo $contact; ?></span>
          </p>
          <p>
              <span class="leftlabel">E-mail</span>
              <span class="righttext"><?php echo $mail; ?></span>
          </p>
          <p>
              <span class="leftlabel">Budget</span>
              <span class="righttext"><?php echo $budget; ?></span>
          </p>
          <p>
              <span class="leftlabel">Transport</span>
              <span class="righttext"><?php echo $transport; ?></span>
          </p>
          <p>
              <span class="leftlabel">Keeper</span>
              <span class="righttext"><?php echo $keeper; ?></span>
          </p>
          <p>
              <span class="leftlabel">Stay</span>
              <span class="righttext"><?php echo $stay; ?></span>
          </p>
          <p>
              <span class="leftlabel">Flight</span>
              <span class="righttext"><?php echo $flight; ?></span>
          </p>
          <p>
              <span class="leftlabel">No of People</span>
              <span class="righttext"><?php echo $no_people; ?></span>
          </p>
          <p>
              <span class="leftlabel">No of Room</span>
              <span class="righttext"><?php echo $no_rooms; ?></span>
          </p>
           <p>
              <span class="leftlabel">No of days</span>
              <span class="righttext"><?php echo $no_days; ?></span>
          </p>
          <p>
              <span class="leftlabel">Flight Amount Per Person</span>
              <span class="righttext"><input value="<?php echo $flight_amount; ?>" type="text" id="flight_amount" name="flight_amount" /></span>
          </p>
          <p>
              <span class="leftlabel">Price Of Hotel Per Person</span>
              <span class="righttext"><input value="<?php echo $price_of_hotel; ?>" type="text" id="price_of_hotel" name="price_of_hotel" /></span>
          </p>

          <p>
              <span class="leftlabel">Cost of activities Per Person</span>
              <span class="righttext"><input value="<?php echo $cost_of_activities; ?>" type="text" id="cost_of_activities" name="cost_of_activities" /></span>
          </p>

          <p>
              <span class="leftlabel">Cost of transport Per Person</span>
              <span class="righttext"><input value="<?php echo $cost_of_transport; ?>" type="text" id="cost_of_transport" name="cost_of_transport" /></span>
          </p>
          <p>
              <span class="leftlabel">Cost of Keeper Per Person</span>
              <span class="righttext"><input value="<?php echo $cost_of_Keeper; ?>" type="text" id="cost_of_Keeper" name="cost_of_Keeper" /></span>
          </p>
          <p>
              <span class="leftlabel">Cost of booking Fee Per Person</span>
              <span class="righttext"><input value="<?php echo $cost_of_booking_Fee; ?>" type="text" id="cost_of_booking_Fee" name="cost_of_booking_Fee" /></span>
          </p>

          <p>
              <span class="leftlabel">Cost of Insurance Per Person</span>
              <span class="righttext"><input value="<?php echo $cost_of_insurance; ?>" type="text" id="cost_of_insurance" name="cost_of_insurance" /></span>
          </p>
           <p>
          		<input type="button" value="Calculate total" id="totalamt">
           </p>
        
          <p>
              <span class="leftlabel">Total Cost Tax Free</span>
              <span class="righttext"><input value="<?php echo $total_cost_tax_free; ?>" type="text" id="total_cost_tax_free" name="total_cost_tax_free" /></span>
          </p>
          <p>
              <span class="leftlabel">Gst</span>
              <span class="righttext"><input value="<?php echo $gstamount; ?>" type="text" id="gst" name="gst" /></span>
          </p>
          <p>
              <span class="leftlabel">Final cost </span>
              <span class="righttext"><input value="<?php echo $final_cost; ?>" type="text" id="final_cost" name="final_cost" /></span>
          </p>
          <p>
              <span class="leftlabel">First Installment</span>
              <span class="righttext"><input value="<?php echo $first_installement; ?>" type="text" id="first_installement" name="first_installement" /></span>
          </p>
           <p>
              <span class="leftlabel">Last Day to send First Installement</span>
              <span class="righttext"><input value="<?php echo $last_day_for_first_installement; ?>" type="text" id="last_day_for_first_installement" name="last_day_for_first_installement" /></span>
              <span class="righttext"><input value="<?php echo $lastfirstpaytime; ?>" type="time" id="lastfirstpaytime" name="lastfirstpaytime" /></span>
          </p>
          <p>
              <span class="leftlabel">Final Installment</span>
              <span class="righttext"><input value="<?php echo $final_installement; ?>" type="text" id="final_installement" name="final_installement" /></span>
          </p>
           <p>
              <span class="leftlabel">Last Day to send Final Installement</span>
              <span class="righttext"><input value="<?php echo $last_day_for_final_installement; ?>" type="text" id="last_day_for_final_installement" name="last_day_for_final_installement" /></span>
              <span class="righttext"><input value="<?php echo $lastfinalpaytime; ?>" type="time" id="lastfinalpaytime" name="lastfinalpaytime" /></span>
          </p>
          <input type="button" value="Update" id="update">
         <p id="msgdisp"></p>

          <p>
              <span class="leftlabel">First Installment payment Date and time</span>
              <span class="righttext"><input value="<?php echo $paydate1; ?>" type="date" id="paydate1" name="paydate1" /></span>
          </p>
          <p>
              <span class="leftlabel">First Installment payment time</span>
              <span class="righttext"><input value="<?php echo $paytime1; ?>" type="time" id="paytime1" name="paytime1" /></span>
          </p>
          <p>
              <span class="leftlabel">First Installment Transaction id</span>
              <span class="righttext"><input value="<?php echo $txnid; ?>" type="text" id="txnid" name="txnid" /></span>
          </p>
          <p>
          <input type="button" value="First installment Update" id="firstupdate">
          </p>

          <p>
              <span class="leftlabel">Final Installment payment Date and time</span>
              <span class="righttext"><input value="<?php echo $paydate2; ?>" type="date" id="paydate2" name="paydate2" /></span>
          </p>
          <p>
              <span class="leftlabel">Final Installment payment time</span>
              <span class="righttext"><input value="<?php echo $paytime2; ?>" type="time" id="paytime2" name="paytime2" /></span>
          </p>
          <p>
              <span class="leftlabel">Final Installment Transaction id</span>
              <span class="righttext"><input value="<?php echo $txnid2; ?>" type="text" id="txnid2" name="txnid2" /></span>
          </p>
          <p>
          <input type="button" value="Final installment Update" id="finalupdate">
          </p>
      </from>



    </div>

    <div class="msgtothe_cus">
    	<h4>Message to the Customer</h4>
		<form action="" method="POST" id="msgtothecus" name="msgtothecus">
			<textarea id="admin_msg" name="admin_msg"></textarea>
			<input type="button" id="adminmsg" value="update msg">
		</form>
		</p>
		<span id="adminmsgdisp"></span>
    </div>


<?php
$doc_files='';

$doc="SELECT * FROM `#__user_documents` WHERE oid=$oid AND user_id=$uid AND trip_type='customized'";
$doc1="SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$oid";
if($oid!==0){

$db->setQuery($doc);
$disp=$db->loadObjectList();
foreach($disp as $doc_file)
{
	$uid=$doc_file->user_id;
	$doid=$doc_file->id;
	$oid=$doc_file->oid;
	$document=$doc_file->document;
	$pancard=$doc_file->pancard;
	$tshirt=$doc_file->tshirt;
	$trip_type=$doc_file->trip_type;
	$address=$doc_file->address;

	$del=rtrim($document,',');/*remove last comma*/
	$passport=(explode(",",$del));
    $passport_file=array_filter($passport);
    $pass_image=array_values($passport_file);


	$des=rtrim($pancard,',');/*remove last comma*/
	$pandetail=(explode(",",$des));
    $pancard_file=array_filter($pandetail);
    $pancard_image=array_values($pancard_file);

	$tshirt_size=rtrim($tshirt,',');
	$tshirt_detail=(explode(",",$tshirt_size));
    $pancard_file1=array_filter($tshirt_detail);
    $pancard_image1=array_values($pancard_file1);

	 for($i=0;$i<sizeof($pass_image);$i++){

	echo '<div class="res_d">' .
			'<table>
				  <tr><td><a href="'.JURI::root().'images/documents/'.$uid.'/'.$pass_image[$i].'" download >Download Passport '.$i.'</a></td></tr>
				  <tr><td><a href="'.JURI::root().'images/pandocument/'.$uid.'/'.$pancard_image[$i].'" download >Download PanCard '.$i.'</a><td></tr>
				  <tr><td><span class="quote_value">'.$trip_type.'</span><td></tr>
				  <tr><td><span class="quote_value">'.$pancard_image1[$i].'</span><td></tr>
	 		</table> </div>';
	}
}
echo '<div class="res_d"><p>Address: '.$address.'</p></div>';
}
else{
    echo "";
}

?>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js'></script>

<script>
	var dateToday = new Date();
	jQuery(document).ready(function(){
	  jQuery("#last_day_for_first_installement").datepicker({
	      format: 'dd-mm-yyyy',
	        autoclose: true,
	        startDate: "+0d" ,
	        todayHighlight: true
	  });
	 jQuery("#last_day_for_final_installement").datepicker({
	      format: 'dd-mm-yyyy',
	        autoclose: true,
	        startDate: "+0d" ,
	        todayHighlight: true
	  });
	});
	</script>

<script>
jQuery(document).ready(function(){
	jQuery("#update").click(function(){
	    var uid = <?php  echo $uid; ?>;
	    var flight_amount = jQuery("#flight_amount").val();
	    var price_of_hotel = jQuery("#price_of_hotel").val();
	    var orderid = <?php echo $id; ?>;
	    var cost_of_activities = jQuery("#cost_of_activities").val();
	    var cost_of_transport = jQuery("#cost_of_transport").val();
	    var cost_of_Keeper = jQuery("#cost_of_Keeper").val();
	    var cost_of_booking_Fee = jQuery("#cost_of_booking_Fee").val();
	    var cost_of_insurance = jQuery("#cost_of_insurance").val();
	    var total_cost_tax_free = jQuery("#total_cost_tax_free").val();
	    var gst = jQuery("#gst").val();
	    var final_cost = jQuery("#final_cost").val();
	    var first_installement = jQuery("#first_installement").val();
	    var last_day_for_first_installement = jQuery("#last_day_for_first_installement").val();
	    var lastfirstpaytime = jQuery("#lastfirstpaytime").val();
	    var final_installement = jQuery("#final_installement").val();
	    var last_day_for_final_installement = jQuery("#last_day_for_final_installement").val();
	    var lastfinalpaytime = jQuery("#lastfinalpaytime").val();

	    jQuery.post("index.php?option=com_booking_management&task=booking_managements.amountUpdate&flight_amount="+flight_amount+"&price_of_hotel="+price_of_hotel+"&orderid="+orderid+"&cost_of_activities="+cost_of_activities+"&cost_of_transport="+cost_of_transport+"&cost_of_Keeper="+cost_of_Keeper+"&cost_of_booking_Fee="+cost_of_booking_Fee+"&cost_of_insurance="+cost_of_insurance+"&total_cost_tax_free="+total_cost_tax_free+"&gst="+gst+"&first_installement="+first_installement+"&last_day_for_first_installement="+last_day_for_first_installement+"&final_installement="+final_installement+"&last_day_for_final_installement="+last_day_for_final_installement+"&final_cost="+final_cost+"&uid="+uid+"&lastfinalpaytime="+lastfinalpaytime+"&lastfirstpaytime="+lastfirstpaytime,updateMsg);
	});

jQuery("#firstupdate").click(function(){
    var orderid = <?php echo $id; ?>;
      var first_installment__payed_date = jQuery("#paydate1").val();
      var first_installment__payed_time = jQuery("#paytime1").val();
      var first_installment_txnid = jQuery("#txnid").val();
      jQuery.post("index.php?option=com_booking_management&task=booking_managements.cust_order_firstupdate&orderid="+orderid+"&first_installment__payed_date="+first_installment__payed_date+"&first_installment__payed_time="+first_installment__payed_time+"&first_installment_txnid="+first_installment_txnid,updateMsg1);
  });
  jQuery("#finalupdate").click(function(){
    var orderid = <?php echo $id; ?>;

      var final_installment__payed_date = jQuery("#paydate2").val();
      var final_installment__payed_time = jQuery("#paytime2").val();
      var final_installment_txnid = jQuery("#txnid2").val();
      jQuery.post("index.php?option=com_booking_management&task=booking_managements.cust_order_finalupdate&orderid="+orderid+"&final_installment__payed_date="+final_installment__payed_date+"&final_installment__payed_time="+final_installment__payed_time+"&final_installment_txnid="+final_installment_txnid,updateMsg2);
  });

	jQuery("#totalamt").click(function(){
	    var flight_amount = jQuery("#flight_amount").val();
	    var photel = jQuery("#price_of_hotel").val();
	    var c_activities = jQuery("#cost_of_activities").val();
	    var c_transport = jQuery("#cost_of_transport").val();
	    var c_Keeper = jQuery("#cost_of_Keeper").val();
	    var c_booking_Fee = jQuery("#cost_of_booking_Fee").val();
	    var c_insurance = jQuery("#cost_of_insurance").val();
	    var gst = <?php echo $gst; ?>;
	    var no_of_people = <?php echo $no_people; ?>;

	    var flight_amount= parseInt(flight_amount) *no_of_people;
        var photel= parseInt(photel) *no_of_people;
        var c_activities= parseInt(c_activities) *no_of_people;
		var c_transport= parseInt(c_transport) *no_of_people;
		var c_Keeper= parseInt(c_Keeper) *no_of_people;
		var c_booking_Fee= parseInt(c_booking_Fee) *no_of_people;
		var c_insurance= parseInt(c_insurance) *no_of_people;

		var total_cost_tax_free = parseInt(flight_amount)+parseInt(photel)+parseInt(c_activities)+parseInt(c_transport)+parseInt(c_Keeper)+parseInt(c_booking_Fee)+parseInt(c_insurance);
		jQuery("#total_cost_tax_free").val(total_cost_tax_free);
		var gstamt = (parseInt(gst) / 100) * parseInt(total_cost_tax_free);
		jQuery("#gst").val(Math.round(gstamt));
		var amount_wittax=parseInt(gstamt)+parseInt(total_cost_tax_free);
		jQuery("#final_cost").val(amount_wittax);
	});

	function updateMsg(stext,status){
	   if(status=="success"){
		   jQuery("#msgdisp").html("Updated successfully");
	    }
   }
   function updateMsg1(stext,status){
	   if(status=="success"){
		   jQuery("#msgdisp").html("First Installment Updated successfully");
	    }
   }
   function updateMsg2(stext,status){
	   if(status=="success"){
		   jQuery("#msgdisp").html("First Installment Updated successfully");
	    }
   }

   	jQuery("#adminmsg").click(function(){
		var admin_msg = jQuery("#admin_msg").val();
		var order_id = <?php echo $id; ?>;
		jQuery.post("index.php?option=com_booking_management&task=booking_managements.AdminMsgto&admin_msg="+admin_msg+"&order_id="+order_id,updateAdminMsg);
   	});

   	   function updateAdminMsg(stext,status){
	   if(status=="success"){
		   jQuery("#adminmsgdisp").html("Message Updated successfully");
	    }
   }

});
</script>



<style>
.display_book_detail {
  float: left;
  width: 50%;
}
.leftlabel {
  float: left;
  font-weight: bold;
  width: 30%;
}
.btn-toolbar {
  display: none;
}
#update {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: 1px solid #f04d33;
  color: #f04d33;
  float: left;
  font-size: 17px;
  padding: 0.4em 0;
  width: 25%;
}
#bookingform p {
  float: left;
  width: 100%;
}
.doc_disp {
	width: 50%;
	float: left;
}
.res_d {
	width: 100%;
	float: left;
}
.res_d table,.res_dd table {
  width:100%;
}


.res_d th, td,.res_dd th, td {
  padding: 15px;
  text-align: left;
}
.res_d table tr {
	width: 18%;
	float: left;
	border: 1px solid #000;
}
.res_d table#t01 th,.res_dd table#t01 th {
  background-color: black;
  color: white;
}
.res_dd table tr {
	width:90.5%;
	float: left;

}
.res_dd table tr th {
	width: 17.29%;
	float: left;
	border: 1px solid #000;
}
</style>


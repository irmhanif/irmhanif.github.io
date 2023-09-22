<?php
$db = JFactory::getDbo();
$id = JRequest::getVar('id');
$forderid = JRequest::getVar('id');
echo "<a href='index.php?option=com_booking_management&view=booking_managements'>BACK</a>";

  $sqllist="SELECT * FROM `#__fixed_trip_orders` WHERE  id=$id";
  $db->setQuery($sqllist);
  $result=$db->loadObjectList();

  foreach($result as $event_disp) {
  $orderid=$event_disp->id;
  $useid=$event_disp->uid;
  $cart=$event_disp->cart_date;
  $time = strtotime($cart);
  $cart = date('d-m-Y',$time);
  $carts = date('h:i:s a',$time);
  $title=$event_disp->pack_title;
  $pack_id=$event_disp->pack_id;
  $pack_type=$event_disp->pack_type;

  $no_of_people=$event_disp->no_of_people;
  $no_of_room=$event_disp->no_of_room;
  $no_of_days=$event_disp->no_of_days;

  $flight=$event_disp->flight;
  $place_of_dept=$event_disp->place_of_dept;
  $pack_date=$event_disp->pack_date;

  $hotel=$event_disp->hotel;
  $keeper=$event_disp->keeper;
  $transport=$event_disp->transport;


  $paymethod=$event_disp->paymethod;
  $flight_price=$event_disp->flight_price;
  $payment_status=$event_disp->payment_status;
  $price_pr=$event_disp->price_pr;

  $cost_of_hotel=$event_disp->cost_of_hotel;
  $cost_of_transport=$event_disp->cost_of_transport;
  $cost_of_keeper=$event_disp->cost_of_keeper;
  $cost_of_booking_fee=$event_disp->cost_of_booking_fee;
  $cost_of_activities=$event_disp->cost_of_activities;
  $cost_of_insurance=$event_disp->cost_of_insurance;
  $extra_cost_i=$event_disp->extra_cost_i;
  $extra_cost_ii=$event_disp->extra_cost_ii;

  $total_price=$event_disp->total_price;
  $flight_amount=$event_disp->flight_price;
  $gst=$event_disp->gst;
  $first_installment=$event_disp->first_installment;
  $first_inst_date=$event_disp->first_inst_date;
  $final_installment=$event_disp->final_installment;
  $final_inst_date=$event_disp->final_inst_date;
  $total_price_gst=$event_disp->total_price_gst;
  $planning=$event_disp->planning;


  $paydate1=$event_disp->pay_date1;
  $txnid=$event_disp->txnid;
  $paydate2=$event_disp->pay_date2;
  $txnid2=$event_disp->txnid2;

  $paytime1 = date ('H:i', strtotime($paydate1));
  $paydate1 = date ('Y-m-d', strtotime($paydate1));
  $paytime2 = date ('H:i', strtotime($paydate2));
  $paydate2 = date ('Y-m-d', strtotime($paydate2));

  $sqlgst="SELECT * FROM `#__common_price_management` WHERE state=1";
  $db->setQuery($sqlgst);
  $common_price_management_detail=$db->loadObjectList();
  foreach($common_price_management_detail as $pricemgt_disp) {
      $gsti=$pricemgt_disp->gst;
      $first_i=$pricemgt_disp->f_firt_installment;
      $final_i=$pricemgt_disp->f_final_installment;
  }


  if($flight_amount==0) {
    $flight_amount='';
  }
   if($gst=='') {
    $gst='0';
  }
  if($first_installment==0) {
    $first_installment='';
  }
  if($first_inst_date==0000-00-00) {
    $first_inst_date='';
  }
  if($final_installment==0) {
    $final_installment='';
  }
  if($final_inst_date==0000-00-00) {
    $final_inst_date='';
  }
	  $sql="SELECT * FROM `#__users` WHERE id='$useid'";
	  $db->setQuery($sql);
	  $events_detail=$db->loadObjectList();
	  foreach($events_detail as $event_disp) {
	    $username=$event_disp->name;
	    $contact=$event_disp->phone;
	    $mail=$event_disp->email;
	   }
  }


  $lastfirstpaytime = date('H:i', strtotime($first_inst_date));
  $lastfinalpaytime = date('H:i', strtotime($final_inst_date));
  $first_inst_date = date('d-m-Y', strtotime($first_inst_date));
$final_inst_date = date('d-m-Y', strtotime($final_inst_date));

  $pack_type_query="SELECT * FROM `#__type_category` WHERE  id=$pack_type";
  $db->setQuery($pack_type_query);
  $pack_type_query_result=$db->loadObjectList();
  foreach ($pack_type_query_result as $value) {
       $pack_type=$value->title;
    }
  $plannig_query="SELECT * FROM `#__fixed_trip_planning` WHERE  id=$planning";
  $db->setQuery($plannig_query);
  $plannig_query_result=$db->loadObjectList();
  foreach ($plannig_query_result as $value) {
       $planning=$value->reference;
    }
  //$cost_of_hotel = ($cost_of_hotel*$no_of_room)/$no_of_people;

?>

 <div class="display_book_detail">
      <form action="#" Method="POST" name="bookingform" id="bookingform">
          <p>
              <span class="leftlabel">Order Id :</span>
              <span class="righttext"><?php echo $orderid; ?></span>
          </p>
          <p>
              <span class="leftlabel">Title of Trip :</span>
              <span class="righttext"><?php echo $title; ?></span>
          </p>
          <p>
              <span class="leftlabel">Type of Trip :</span>
              <span class="righttext"><?php echo $pack_type; ?></span>
          </p>
          <p>
              <span class="leftlabel">Trip Planning Reference :</span>
              <span class="righttext"><?php echo $planning; ?></span>
          </p>
          <p>
              <span class="leftlabel">Name :</span>
              <span class="righttext"><?php echo $username; ?></span>
          </p>
          <p>
              <span class="leftlabel">Number :</span>
              <span class="righttext"><?php echo $contact; ?></span>
          </p>
          <p>
              <span class="leftlabel">E-mail :</span>
              <span class="righttext"><?php echo $mail; ?></span>
          </p>
          <p>
              <span class="leftlabel">Booked Time :</span>
              <span class="righttext"><?php echo $cart.' '.$carts;  ?></span>
          </p>
          <p>
              <span class="leftlabel">Flights :</span>
              <span class="righttext"><?php echo $flight; ?></span>
          </p>
          <p>
              <span class="leftlabel">Date of Departure :</span>
              <span class="righttext"><?php echo $pack_date; ?></span>
          </p>
          <p>
              <span class="leftlabel">Place of Departure :</span>
              <span class="righttext"><?php echo $place_of_dept; ?></span>
          </p>
          <p>
              <span class="leftlabel">No of People :</span>
              <span class="righttext"><?php echo $no_of_people; ?></span>
          </p>
          <p>
              <span class="leftlabel">No Of Room :</span>
              <span class="righttext"><?php echo $no_of_room; ?></span>
          </p>
           <p>
              <span class="leftlabel">No Of days :</span>
              <span class="righttext"><?php echo $no_of_days; ?></span>
          </p>
          <p>
              <span class="leftlabel">Transport :</span>
              <span class="righttext"><?php echo $transport; ?></span>
          </p>
          <p>
              <span class="leftlabel">Keeper :</span>
              <span class="righttext"><?php echo $keeper; ?></span>
          </p>
          <p>
              <span class="leftlabel">Hotel :</span>
              <span class="righttext"><?php echo $hotel; ?></span>
          </p>
          <p>
              <span class="leftlabel">Payment Status :</span>
              <span class="righttext"><?php echo $payment_status; ?></span>
          </p>
          <p>
              <span class="leftlabel">Price of Hotel :</span>
              <span class="righttext"><input value="<?php echo $cost_of_hotel; ?>" type="text" id="cost_of_hotel" name="cost_of_hotel" /></span>
          </p>
          <p>
              <span class="leftlabel">Cost of activities :</span>
              <span class="righttext"><input value="<?php echo $cost_of_activities; ?>" type="text" id="cost_of_activities" name="cost_of_activities" /></span>
          </p>
          <p>
              <span class="leftlabel">Cost of transport :</span>
              <span class="righttext"><input value="<?php echo $cost_of_transport; ?>" type="text" id="cost_of_transport" name="cost_of_transport" /></span>
          </p>
          <p>
              <span class="leftlabel">Cost of Keeper :</span>
              <span class="righttext"><input value="<?php echo $cost_of_keeper; ?>" type="text" id="cost_of_keeper" name="cost_of_keeper" /></span>
          </p>
          <p>
              <span class="leftlabel">Cost of booking Fee :</span>
              <span class="righttext"><input value="<?php echo $cost_of_booking_fee; ?>" type="text" id="cost_of_booking_fee" name="cost_of_booking_fee" /></span>
          </p>
          <p>
              <span class="leftlabel">Cost of Insurance :</span>
              <span class="righttext"><input value="<?php echo $cost_of_insurance; ?>" type="text" id="cost_of_insurance" name="cost_of_insurance" /></span>
          </p>
           <p>
              <span class="leftlabel">Flight Amount :</span>
              <span class="righttext"><input value="<?php echo $flight_amount; ?>" type="text" id="flight_amount" name="flight_amount" /></span>
          </p>
          <p><input type="button" onclick="total()" value="Calculation" id="totcalc"></p>
          <p>
              <span class="leftlabel">Total Cost Tax Free : </span>
              <span class="righttext"><input value="<?php echo $total_price; ?>" type="text" id="total_price" name="total_price" /></span>
          </p>
          <p>
              <span class="leftlabel">Total cost taf free*Gst
</span>
              <span class="righttext"><input value="<?php echo $gst; ?>" type="text" id="gst" name="gst" /></span>
          </p>
          <p>
              <span class="leftlabel">Total Cost With Tax : </span>
              <span class="righttext"><input value="<?php echo $total_price_gst; ?>" type="text" id="final_cost" name="final_cost" /></span>
          </p>
          <p>
              <span class="leftlabel">First Installment Amount</span>
              <span class="righttext"><input value="<?php echo $first_installment; ?>" type="text" id="first_i" name="first_i" /></span>
          </p>
          <p>
              <span class="leftlabel">First Installment Date</span>
              <span class="righttext"><input value="<?php echo $first_inst_date; ?>" type="text" id="last_day_for_first_installement" name="last_day_for_first_installement" /></span>
              <span class="righttext"><input value="<?php echo $lastfirstpaytime; ?>" type="time" id="lastfirstpaytime" name="lastfirstpaytime" /></span>
          </p>
          <p>
              <span class="leftlabel">Final Installment Amount</span>
              <span class="righttext"><input value="<?php echo $final_installment; ?>" type="text" id="final_i" name="final_i" /></span>
          </p>
          <p>
              <span class="leftlabel">Final Installment Date</span>
              <span class="righttext"><input value="<?php echo $final_inst_date; ?>" type="text" id="last_day_for_final_installement" name="last_day_for_final_installement" /></span>
              <span class="righttext"><input value="<?php echo $lastfinalpaytime; ?>" type="time" id="lastfinalpaytime" name="lastfinalpaytime" /></span>
          </p>
          <p>
          <input type="button" value="Update" id="fixupdate">
          </p>
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

   <p></p>

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
$doc="SELECT * FROM `#__user_documents` WHERE oid=$orderid AND user_id=$useid AND trip_type='fixed'";
$doc1="SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$orderid";
if($orderid!==0){
$db->setQuery($doc);
$disp=$db->loadObjectList();
foreach($disp as $doc_file)
{
	$uid=$doc_file->user_id;
	$id=$doc_file->id;
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
    echo"";
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

  jQuery("#fixupdate").click(function(){
    var orderid = <?php echo $forderid; ?>;
    var pay_status = '<?php echo $payment_status; ?>';
      var flight_amount = jQuery("#flight_amount").val();
      var cost_of_hotel = jQuery("#cost_of_hotel").val();
      var cost_of_activities = jQuery("#cost_of_activities").val();
      var cost_of_insurance = jQuery("#cost_of_insurance").val();
      var cost_of_keeper = jQuery("#cost_of_keeper").val();
      var cost_of_booking_fee = jQuery("#cost_of_booking_fee").val();
      var cost_of_transport = jQuery("#cost_of_transport").val();
      var total_price = jQuery("#total_price").val();
      var gst = jQuery("#gst").val();
      var total_price_gst = jQuery("#final_cost").val();
      var first_installment = jQuery("#first_i").val();
      var first_installment_date = jQuery("#last_day_for_first_installement").val();
      var final_installment = jQuery("#final_i").val();
      var final_installment_date = jQuery("#last_day_for_final_installement").val();
      var lastfirstpaytime = jQuery("#lastfirstpaytime").val();
      var lastfinalpaytime = jQuery("#lastfinalpaytime").val();

      jQuery.post("index.php?option=com_booking_management&task=booking_managements.fixed_order_update&orderid="+orderid+"pay_status="+pay_status+"&flight_amount="+flight_amount+"&lastfirstpaytime="+lastfirstpaytime+"&lastfinalpaytime="+lastfinalpaytime+"&cost_of_hotel="+cost_of_hotel+"&cost_of_activities="+cost_of_activities+"&cost_of_insurance="+cost_of_insurance+"&cost_of_keeper="+cost_of_keeper+"&cost_of_booking_fee="+cost_of_booking_fee+"&cost_of_transport="+cost_of_transport+"&total_price="+total_price+"&gst="+gst+"&total_price_gst="+total_price_gst+"&first_installment="+first_installment+"&first_installment_date="+first_installment_date+"&final_installment="+final_installment+"&final_installment_date="+final_installment_date,updateMsg);
  });

    jQuery("#firstupdate").click(function(){
    var orderid = <?php echo $forderid; ?>;

      var first_installment__payed_date = jQuery("#paydate1").val();
      var first_installment__payed_time = jQuery("#paytime1").val();
      var first_installment_txnid = jQuery("#txnid").val();
      jQuery.post("index.php?option=com_booking_management&task=booking_managements.fixed_order_firstupdate&orderid="+orderid+"&first_installment__payed_date="+first_installment__payed_date+"&first_installment__payed_time="+first_installment__payed_time+"&first_installment_txnid="+first_installment_txnid,updateMsg1);
  });
  jQuery("#finalupdate").click(function(){
    var orderid = <?php echo $forderid; ?>;

      var final_installment__payed_date = jQuery("#paydate2").val();
      var final_installment__payed_time = jQuery("#paytime2").val();
      var final_installment_txnid = jQuery("#txnid2").val();
      jQuery.post("index.php?option=com_booking_management&task=booking_managements.fixed_order_finalupdate&orderid="+orderid+"&final_installment__payed_date="+final_installment__payed_date+"&final_installment__payed_time="+final_installment__payed_time+"&final_installment_txnid="+final_installment_txnid,updateMsg2);
  });

  jQuery("#totcalc").click(function(){
      var flight_amount = jQuery("#flight_amount").val();
      var cost_of_hotel = jQuery("#cost_of_hotel").val();
      var cost_of_activities = jQuery("#cost_of_activities").val();
      var cost_of_insurance = jQuery("#cost_of_insurance").val();
      var cost_of_keeper = jQuery("#cost_of_keeper").val();
      var cost_of_booking_fee = jQuery("#cost_of_booking_fee").val();
      var cost_of_transport = jQuery("#cost_of_transport").val();
      var gst = <?php echo $gsti; ?>;
      var final_i = <?php echo $final_i; ?>;
      var first_i = <?php echo $first_i; ?>;
      if(cost_of_hotel == '') {
        cost_of_hotel = 0;
      }
      if(cost_of_activities == '') {
        cost_of_activities = 0;
      }
      if(cost_of_insurance == '') {
        cost_of_insurance = 0;
      }
      if(cost_of_keeper == '') {
        cost_of_keeper = 0;
      }
      if(cost_of_booking_fee == '') {
        cost_of_booking_fee = 0;
      }
      if(cost_of_transport == '') {
        cost_of_transport = 0;
      }
      if(gst == '') {
          gst = 0;
      }
      if(flight_amount == '') {
          flight_amount = 0;
      }
    var total_cost_tax_free = parseInt(flight_amount)+parseInt(cost_of_hotel)+parseInt(cost_of_activities)+parseInt(cost_of_insurance)+parseInt(cost_of_keeper)+parseInt(cost_of_booking_fee)+parseInt(cost_of_transport);

    jQuery("#total_price").val(total_cost_tax_free);
    var gstamt = (parseInt(gst) / 100) * parseInt(total_cost_tax_free);
    jQuery("#gst").val(Math.round(gstamt));
    var amount_wittax=parseInt(gstamt)+parseInt(total_cost_tax_free);
    jQuery("#final_cost").val(amount_wittax);

    var final_i = (parseInt(final_i) / 100) * parseInt(amount_wittax);
    jQuery("#final_i").val(Math.round(final_i));

    var first_i = (parseInt(first_i) / 100) * parseInt(amount_wittax);
    jQuery("#first_i").val(Math.round(first_i));

  });

  function updateMsg(stext,status){
     if(status=="success"){
       jQuery("#msgdisp").html("Updated successfully");
      }
   }
   function updateMsg1(stext,status){
     if(status=="success"){
       jQuery("#msgdisp").html("First installment Updated successfully");
      }
   }
   function updateMsg2(stext,status){
     if(status=="success"){
       jQuery("#msgdisp").html("final installment Updated successfully");
      }
   }

    jQuery("#adminmsg").click(function(){
		var admin_msg = jQuery("#admin_msg").val();
		var order_id = <?php echo $forderid; ?>;
		jQuery.post("index.php?option=com_booking_management&task=booking_managements.AdminMsgto2&admin_msg="+admin_msg+"&order_id="+order_id,updateAdminMsg);
   	});

   	   function updateAdminMsg(stext,status){
	   if(status=="success"){
		   jQuery("#adminmsgdisp").html("Message Updated successfully");
	    }
   }

});
</script>

<style>
  .display_book_detail p .leftlabel {
    float: left;
    width: 15%;
}
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
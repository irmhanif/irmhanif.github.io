<p class="bklink">
	<a href="index.php?option=com_booking_management&view=booking_managements">BACK</a>
</p>

    <?php
	$db = JFactory::getDbo();
	$id = JRequest::getVar('id');
	$qts = JRequest::getVar('qts');
	$quote_status = JRequest::getVar('qts');
	$userid = JRequest::getVar('userid');
	$user_id = JRequest::getVar('userid');

	$getorderdetails2="SELECT * FROM `#__semicustomized_order` WHERE uid=$userid AND quote_status=$qts";
	$db->setQuery($getorderdetails2);
	$orderdetail2=$db->loadObjectList();

	foreach($orderdetail2 as $orderdetail2_disp) {
	    $updateid=$orderdetail2_disp->id;
	}
            $sqlfirst = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
            $db->setQuery($sqlfirst);
            $semi_orderfirstdetails = $db->loadObjectList();
                foreach ($semi_orderfirstdetails as $semiorder_disp1) {
                               // $semiid = $semiorder_disp1->id;
                                $number_people1 = $semiorder_disp1->number_peoples;
                                $number_rooms1 = $semiorder_disp1->number_rooms;
                                $dateofdeparture1 = $semiorder_disp1->trip_date;
                                $flight1 = $semiorder_disp1->flight;
                                $place_of_dept1 = $semiorder_disp1->place_of_dept;
                                $paymethod1 = $semiorder_disp1->paymethod;
                                $noofdays1 = $semiorder_disp1->noofdays;
                                $trip_id1 = $semiorder_disp1->trip_id;
                                //$noofdays1++; $number_rooms1++;
                                //$number_people1++;

                            }
                            echo '<div class="headings">
                            <div class="semi_maindet">
                            <p><span class="">Number of people </span><span>:</span><span>' . $number_people1 . '</span></p>
                            <p><span class="">Number of room </span><span>:</span><span>' . $number_rooms1 . '</span></p>
                            <p><span class="">Date of departure </span><span>:</span><span>' . $dateofdeparture1 . '</span></p>
                            <p><span class="">Flight ticket answer </span><span>:</span><span>' . $flight1 . '</span></p>
                            <p><span class="">Place of departure </span><span>:</span><span>' . $place_of_dept1 . '</span></p>
                            <p><span class="">Payment solution</span><span>:</span><span>' . $paymethod1 . '</span></p>
                            <p><span class="">Total number of days</span><span>:</span><span>' . $noofdays1 . '</span></p>
                            </div>';

                            $sqltripdet2 = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sqltripdet2);
                            $tripdetails2 = $db->loadObjectList();
                            $package = 0;
                            foreach ($tripdetails2 as $tripdetails_disp2) {
                                $package++;
                                $noofdays = $tripdetails_disp2->noofdays;
                                $transport = $tripdetails_disp2->transport;
                                $hotel = $tripdetails_disp2->hotel;
                                $keeper_information = $tripdetails_disp2->keeper_information;
                                if ($transport == 'yes') {
                                    $transport = 'Private Transport';
                                } else {
                                    $transport = 'Public Transport';
                                }
                                if ($keeper_information == 'yes') {
                                    $keeper_information = 'With Keeper';
                                } else {
                                    $keeper_information = 'Without Keeper';
                                }
                                $trip_id = $tripdetails_disp2->trip_id;
                                $triptitle = "SELECT title FROM `#__semicustomized_trip` WHERE id=$trip_id";
                                $db->setQuery($triptitle);
                                $triptitle = $db->loadResult();
                                echo '<div class="semibookings">
                                <h3>' . $triptitle . ' </h3>
                                <p><span class="">No of days</span><span>:</span><span class="">  ' . $noofdays . '</span></p>
                                <p><span class="">Transport </span><span>:</span><span class="">  ' . $transport . '</span></p>
                                <p><span class="">Hotel</span> <span>:</span><span class=""> ' . $hotel . '</span></p>
                                <p><span class="">keeper </span> <span>:</span><span class=""> ' . $keeper_information . '</span></p>
                                </div>';
                            }
                            // getting Quotation
                            $sql = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sql);
                            $semi_orderdetails = $db->loadObjectList();
                            
                            $hotel_priceall = $cost_of_activitiesall = $cost_of_traferall = $pricetransferall = $keeper_amtall = $bookingtotalall = $insuranceall = 0;
                            $publictransportall = $price_of_leavingall = $cost_of_transferall = $transfer_departure_priceall = $totalpriceper_personall = 0;
                            $total_cost_tax_freeall=0;
                            $final_costall=0;
                            $gstall=0;
                            
                            $totalpriceper_person_withgstall = $totalamtall = $totalprizeall = 0;
                            foreach ($semi_orderdetails as $semiorder_disp) {
                                $uid = $semiorder_disp->uid;
                                $oid=$semiorder_disp->id;
                                $booked_time = $semiorder_disp->booked_time;
                                $noofdays = $semiorder_disp->noofdays;
                                $dateofdeparture = $semiorder_disp->trip_date;
                                $trip_id = $semiorder_disp->trip_id;
                                $planid = $semiorder_disp->planid;
                                $number_rooms = $semiorder_disp->number_rooms;
                                $number_people = $semiorder_disp->number_peoples;
                                $keeper = $semiorder_disp->keeper_information;
                                $hotel = $semiorder_disp->hotel;
                                $transport = $semiorder_disp->transport;
                                $flight = $semiorder_disp->flight;
                                $paymethod = $semiorder_disp->paymethod;
                                $place_of_dept = $semiorder_disp->place_of_dept;
                                $hotel_price = $semiorder_disp->price_of_hotel;
                                $cost_of_activities = $semiorder_disp->cost_of_activities;
                                $cost_of_transport = $semiorder_disp->cost_of_transport;
                                $cost_of_Keeper = $semiorder_disp->cost_of_Keeper;
                                $cost_of_booking_fee = $semiorder_disp->cost_of_booking_fee;
                                $cost_of_insurance = $semiorder_disp->cost_of_insurance;
                                $transfer_departure_price = $semiorder_disp->transfer_departure_price;
                                $price_of_public_transport = $semiorder_disp->price_of_public_transport;
                                $price_of_leaving = $semiorder_disp->price_of_leaving;
                                $totalwithgroup = $semiorder_disp->total_cost_tax_free;
                                $totalwithgroupgst = $semiorder_disp->final_cost;
                                $comment = $semiorder_disp->comment;
                                $cost_of_flight_ticket = $semiorder_disp->cost_of_flight_ticket;
                                
                                
                                
                                
                                $paydate1=$semiorder_disp->pay_date1;
                                $txnid=$semiorder_disp->txnid;
                                $paydate2=$semiorder_disp->pay_date2;
                                $txnid2=$semiorder_disp->txnid2;
                                
                                $paytime1 = date ('H:i', strtotime($paydate1));
                                $paydate1 = date ('Y-m-d', strtotime($paydate1));
                                $paytime2 = date ('H:i', strtotime($paydate2));
                                $paydate2 = date ('Y-m-d', strtotime($paydate2));
                                
                                $sgst = $semiorder_disp->gst;
                                $sqlgst = "SELECT * FROM `#__common_price_management` WHERE state=1";
                                $db->setQuery($sqlgst);
                                $common_price_management_detail = $db->loadObjectList();
                                foreach ($common_price_management_detail as $pricemgt_disp) {
                                    $gst = $pricemgt_disp->gst;
                                }
                                $hotel_priceall += $hotel_price;
                                $cost_of_activitiesall += $cost_of_activities;
                                $cost_of_transferall += $cost_of_transport;
                                $keeper_amtall += $cost_of_Keeper;
                                $bookingtotalall += $cost_of_booking_fee;
                                $insuranceall += $cost_of_insurance;
                                $publictransportall += $price_of_public_transport;
                                $transfer_departure_priceall += $transfer_departure_price;
                                $price_of_leaving += $price_of_leaving;
                                
                                $total_cost_tax_freeall+=$totalwithgroup;
                                $final_costall+=$totalwithgroupgst;
                                
                                $cost_of_flight_ticketall+= $cost_of_flight_ticket;
                                
                                

                                $hotel_priceall = $hotel_priceall;
                                $cost_of_activitiesall = $cost_of_activitiesall;
                                $cost_of_transferall = $cost_of_transferall;
                                $keeper_amtall = $keeper_amtall;
                                $bookingtotalall = $bookingtotalall;
                                $insuranceall = $insuranceall;
                                $publictransportall = $publictransportall / $number_people1;
                                $transfer_departure_priceall = $transfer_departure_priceall / $number_people1;
                                $price_of_leaving = $price_of_leaving / $number_people1;
                                $sgstg = $sgst;
                                $sgst = $sgst;
                                
                                
                                $gstall+=$sgst;

                                $totalcost = $totalwithgroup;
                                $totalcostwithgst = $totalcost + $gstall;
                                $totalwithgroupgst = $total_cost_tax_freeall + $gstall;
                                $totalwithgroupgstperperson = $total_cost_tax_freeall + $gstall;
                                $travelprice = $cost_of_transferall + $transfer_departure_priceall + $price_of_leaving;


                                $hotel_priceall = round($hotel_priceall);
                                $finalgst=$gstall * $number_people1;
                                
                            }
                            echo '<div class="semibookings">
                            <h3> Overall Quotation - Per Person </h3>
                            <p><span class="">Cost of Hotel</span>
                            <span>:</span><span class="">  ' . $hotel_priceall . '</span></p>
                            <p><span class="">Cost of activities </span>
                            <span>:</span><span class="">' . $cost_of_activitiesall . '</span></p>
                            <p><span class="">Cost of Transport</span>
                            <span>:</span><span class=""> ' . $travelprice . '</span></p>
                            <p><span class="">Cost of Keeper </span>
                            <span>:</span><span class=""> ' . $keeper_amtall . '</span></p>
                            <p><span class="">Cost of Booking fee</span>
                            <span>:</span><span class=""> ' . $bookingtotalall . '</span></p>
                            <p><span class="">Cost of Insurance</span>
                            <span>:</span><span class=""> ' . $insuranceall . '</span></p>
                            <p><span class="">GST</span>
                            <span>:</span><span class=""> ' . $finalgst /$number_people1 . '</span></p>
                            <p><span class="">Total Cost</span>
                            <span>:</span><span class="">  ' . $total_cost_tax_freeall . '</span></p>
                            <p><span class="">Total Cost with GST </span>
                            <span>:</span><span class="">' . $totalwithgroupgst . '</span></p>
                            </div>';
                            $totalwithgroup = $total_cost_tax_freeall * $number_people1;
                            $totalwithgroupgst = $final_costall * $number_people1;
                            echo '<div class="semibookings">
                             <h3> Overall Quotation for ' . $number_people1 . ' people </h3>
                             <p><span class="">Total Cost</span>
                             <span>:</span><span class="">  ' . $totalwithgroup . '</span></p>
                             <p><span class="">Total Cost with GST </span>
                             <span>:</span><span class="">' . $totalwithgroupgst . '</span></p>
                             </div>
                             </div>';
                             
                             $no_people=$number_people1;
                             
    $sql="SELECT * FROM `#__users` WHERE id=$uid";
	$db->setQuery($sql);
	$events_detail=$db->loadObjectList();
	foreach($events_detail as $event_disp) {
	    $userid=$event_disp->id;
		$username=$event_disp->name;
		$contact=$event_disp->phone;
		$mail=$event_disp->email;
		
	}
	
  $lastfirstpaytime = date('H:i', strtotime($last_day_for_first_installement));
  $lastfinalpaytime = date('H:i', strtotime($last_day_for_final_installement));
  $last_day_for_first_installement = date('d-m-Y', strtotime($last_day_for_first_installement));
$last_day_for_final_installement = date('d-m-Y', strtotime($last_day_for_final_installement));
/* getting other packages */

	echo '<div class="customerdetails">
			<p><span class="cusname">Name : '.$username.'</span><span class="cusnum">Number : '.$contact.'</span><span class="cusname">Email : '.$mail.'</span></p>
	</div>';	
                             
                        ?>

    <div class="display_book_detail">
      <form action="#" Method="POST" name="bookingform" id="bookingform">

          <p>
              <span class="leftlabel">Price Of Hotel</span>
              <span class="righttext"><input value="<?php echo $hotel_priceall; ?>" type="text" id="price_of_hotel" name="price_of_hotel" /></span>
          </p>
           <p>
              <span class="leftlabel">Cost of activities</span>
              <span class="righttext"><input value="<?php echo $cost_of_activitiesall; ?>" type="text" id="cost_of_activities" name="cost_of_activities" /></span>
          </p>
          <p>
              <span class="leftlabel">Cost of transport</span>
              <span class="righttext"><input value="<?php echo $travelprice; ?>" type="text" id="cost_of_transport" name="cost_of_transport" /></span>
          </p>
          <p>
              <span class="leftlabel">Cost of Keeper</span>
              <span class="righttext"><input value="<?php echo $keeper_amtall; ?>" type="text" id="cost_of_Keeper" name="cost_of_Keeper" /></span>
          </p>
          <p>
              <span class="leftlabel">Cost of booking Fee</span>
              <span class="righttext"><input value="<?php echo $bookingtotalall; ?>" type="text" id="cost_of_booking_Fee" name="cost_of_booking_Fee" /></span>
          </p>          
          <p>
              <span class="leftlabel">Cost of Insurance</span>
              <span class="righttext"><input value="<?php echo $insuranceall; ?>" type="text" id="cost_of_insurance" name="cost_of_insurance" /></span>
          </p>

           <p>
              <span class="leftlabel">Total Flight Amount per person</span>
              <span class="righttext"><input value="<?php echo $cost_of_flight_ticket; ?>" type="text" id="tflight_amount" name="tflight_amount" class="cost_of_flight_ticket" /></span>
          </p>
            
          <p>
              <span class="leftlabel">Total Flight Amount all</span>
              <span class="righttext"><input value="<?php echo $cost_of_flight_ticketall; ?>" type="text" id="cost_of_flight_ticket" name="cost_of_flight_ticket" class="cost_of_flight_ticket" /></span>
          </p>

          
           <p>
          		<input type="button" value="Calculate total" id="totalamt">
           </p>
           
          <p>
              <span class="leftlabel">Total Cost Tax Free </span>
              <span class="righttext"><input value="<?php echo $totalwithgroup; ?>" type="text" id="total_cost_tax_free_per" name="total_cost_tax_free_per" /></span>
          </p>
          <p>
              <span class="leftlabel">Total Gst </span>
              <span class="righttext"><input value="<?php echo $finalgst; ?>" type="text" id="gst_per" name="gst_per" /></span>
          </p>
          <p>
              <span class="leftlabel">Final cost</span>
              <span class="righttext"><input value="<?php echo $totalwithgroupgst; ?>" type="text" id="final_cost_per" name="final_cost_per" /></span>
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
          <p>
              <span class="leftlabel">Comment</span>
              <span class="righttext"><textarea rows="4" cols="50" id="comment"> <?php echo $comment; ?> </textarea></span>
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

<?php
    $doc_files='';
    $doc="SELECT * FROM `#__user_documents` WHERE oid=$oid AND trip_type='semi'";
    $doc1="SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$oid AND trip_type='semi'";
    if($oid!==0){
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
				  <tr><td><a href="images/documents/'.$uid.'/'.$pass_image[$i].'" download >Download Passport '.$i.'</a></td></tr>
				  <tr><td><a href="images/pandocument/'.$uid.'/'.$pancard_image[$i].'" download >Download PanCard '.$i.'</a><td></tr>
				  <tr><td><span class="quote_value">'.$trip_type.'</span><td></tr>
				  <tr><td><span class="quote_value">'.$pancard_image1[$i].'</span><td></tr>
	 		</table> </div>';
	 /*<img src="'.JURI::root().'images/documents/'.$uid.'/'.$pass_image[$i].'" />*/

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
	jQuery("#update").click(function(){
	    
	    var flight_amount = jQuery("#tflight_amount").val();
	    var price_of_hotel = jQuery("#price_of_hotel").val();
	    var first_installement = jQuery("#first_installement").val();
	    var last_day_for_first_installement = jQuery("#last_day_for_first_installement").val();
	    var final_installement = jQuery("#final_installement").val();
	    var last_day_for_final_installement = jQuery("#last_day_for_final_installement").val();
	    var uid = <?php echo $uid; ?>;
	    var qts = <?php echo $qts; ?>;
	    

	    if(flight_amount=='') {
	       jQuery("#flight_amount").focus();
	       jQuery("#flight_amount").css("border","1px solid red");
	       return false;
	    } else {
	         jQuery("#flight_amount").css("border","1px solid #cccccc");
	    }
	    
	    if(first_installement=='') {
	       jQuery("#first_installement").focus();
	       jQuery("#first_installement").css("border","1px solid red");
	       return false;
	    } else {
	        jQuery("#flight_amount").css("border","1px solid #cccccc");
	    } 
	    
	    
	    if(last_day_for_first_installement=='') {
	       jQuery("#last_day_for_first_installement").focus();
	       jQuery("#last_day_for_first_installement").css("border","1px solid red");
	       return false;
	    } else if(final_installement=='') {
	       jQuery("#final_installement").focus();
	       jQuery("#final_installement").css("border","1px solid red");
	       return false;
	    } else if(last_day_for_final_installement=='') {
	       jQuery("#last_day_for_final_installement").focus();
	       jQuery("#last_day_for_final_installement").css("border","1px solid red");
	       return false;
	    }  else {
	        
	        var flight_amount = jQuery("#tflight_amount").val();
	        var price_of_hotel = jQuery("#price_of_hotel").val();
	        var cost_of_activities = jQuery("#cost_of_activities").val();
		    var cost_of_transport = jQuery("#cost_of_transport").val();
		    var cost_of_Keeper = jQuery("#cost_of_Keeper").val();
		    var cost_of_booking_Fee = jQuery("#cost_of_booking_Fee").val();
		    var cost_of_insurance = jQuery("#cost_of_insurance").val();
		    var total_cost_tax_free = jQuery("#total_cost_tax_free_per").val();
		    var cost_of_flight_ticket = jQuery("#cost_of_flight_ticket").val();
		    var totalgst = jQuery("#gst_per").val();
		    
		    var final_cost = jQuery("#final_cost_per").val();
		    var comment = jQuery("#comment").val();
		    var total_amount_for_filght = jQuery("#tflight_amount").val();
		    var lastfirstpaytime = jQuery("#lastfirstpaytime").val();
            var lastfinalpaytime = jQuery("#lastfinalpaytime").val();
            
		    jQuery.post("index.php?option=com_booking_management&task=booking_managements.amountUpdateForSemicustomized&flight_amount="+flight_amount+"&lastfirstpaytime="+lastfirstpaytime+"&lastfinalpaytime="+lastfinalpaytime+"&first_installement="+first_installement+"&last_day_for_first_installement="+last_day_for_first_installement+"&final_installement="+final_installement+"&last_day_for_final_installement="+last_day_for_final_installement+"&final_cost="+final_cost+"&comment="+comment+"&uid="+uid+"&cost_of_flight_ticket="+cost_of_flight_ticket+"&price_of_hotel="+price_of_hotel+"&cost_of_activities="+cost_of_activities+"&cost_of_transport="+cost_of_transport+"&cost_of_Keeper="+cost_of_Keeper+"&cost_of_booking_Fee="+cost_of_booking_Fee+"&cost_of_insurance="+cost_of_insurance+"&total_cost_tax_free="+total_cost_tax_free+"&totalgst="+totalgst+"&qts="+qts,updateMsg);
	    }
	});
jQuery("#firstupdate").click(function(){
    var orderid = <?php echo $updateid; ?>;
      var first_installment__payed_date = jQuery("#paydate1").val();
      var first_installment__payed_time = jQuery("#paytime1").val();
      var first_installment_txnid = jQuery("#txnid").val();
      jQuery.post("index.php?option=com_booking_management&task=booking_managements.semi_order_firstupdate&orderid="+orderid+"&first_installment__payed_date="+first_installment__payed_date+"&first_installment__payed_time="+first_installment__payed_time+"&first_installment_txnid="+first_installment_txnid,updateMsg1);
  });
  jQuery("#finalupdate").click(function(){
    var orderid = <?php echo $updateid; ?>;

      var final_installment__payed_date = jQuery("#paydate2").val();
      var final_installment__payed_time = jQuery("#paytime2").val();
      var final_installment_txnid = jQuery("#txnid2").val();
      jQuery.post("index.php?option=com_booking_management&task=booking_managements.semi_order_finalupdate&orderid="+orderid+"&final_installment__payed_date="+final_installment__payed_date+"&final_installment__payed_time="+final_installment__payed_time+"&final_installment_txnid="+final_installment_txnid,updateMsg2);
  });
	function updateMsg(stext,status){
	   if(status=="success"){
		   jQuery("#msgdisp").html("Updated successfully");
	    }
   }
   function updateMsg1(stext,status){
	   if(status=="success"){
		   jQuery("#msgdisp").html("Updated successfully");
	    }
   }
   function updateMsg2(stext,status){
	   if(status=="success"){
		   jQuery("#msgdisp").html("Updated successfully");
	    }
   }

	jQuery("#totalamt").click(function(){
	    
	    var photel = jQuery("#price_of_hotel").val();
	    var c_transport = jQuery("#cost_of_transport").val();
	    var c_Keeper = jQuery("#cost_of_Keeper").val();
	    var c_activities = jQuery("#cost_of_activities").val();
	    var c_booking_Fee = jQuery("#cost_of_booking_Fee").val();
	    var c_insurance = jQuery("#cost_of_insurance").val();
	    var flight_amount = jQuery("#tflight_amount").val();
	    
	   //for group


	    var gst = <?php echo $gst; ?>;
	    var no_people=<?php echo $no_people; ?>;

	    var cost_of_flight_ticket = parseInt(flight_amount)*parseInt(no_people);
	    
	    
	    	jQuery("#cost_of_flight_ticket").val(cost_of_flight_ticket);
	  
	    var flight_amount_all = parseInt(flight_amount);

	    if(flight_amount=='') {
	       jQuery("#tflight_amount").focus();
	       jQuery("#tflight_amount").css("border","1px solid red");
	        return false;
	    } else {
            jQuery("#tflight_amount").css("border","1px solid #ccc");
            
		var total_cost_tax_free = parseInt(flight_amount_all)+parseInt(photel)+parseInt(c_transport)+parseInt(c_Keeper)+parseInt(c_activities)+parseInt(c_booking_Fee)+parseInt(c_insurance);
		
		var a=parseInt(total_cost_tax_free)*parseInt(no_people);
		 jQuery("#total_cost_tax_free_per").val(total_cost_tax_free*parseInt(no_people));
		
		
		
	
		var gstamt = (parseInt(gst) / 100) * parseInt(total_cost_tax_free);
		jQuery("#gst_per").val(Math.round(gstamt));
		var originaltotal = jQuery("#total_cost_tax_free_per").val();
		var gstamt = (parseInt(gst) / 100) * parseInt(originaltotal);
			jQuery("#gst_per").val(Math.round(gstamt));
		
		var amount_wittax=parseInt(gstamt)+parseInt(originaltotal);
		jQuery("#final_cost_per").val(amount_wittax);
	    }
	});
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
.packages {
  float: left;
  width: 50%;
}
.packages {
  background: #f0f0f0 none repeat scroll 0 0;
  float: left;
  margin-right: 3%;
  padding: 2%;
  width: 41%;
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
.customerdetails span {
  font-size: 18px;
  margin-right: 2em;
}
.customerdetails {
  float: left;
  width: 100%;
}
.packages .leftlabel {
  float: left;
  width: 54%;
}
.packages p {
  float: left;
  width: 50%;
}
#bookingform p {
  float: left;
  width: 100%;
}
.display_book_detail {
  float: left;
  margin: 1% 0;
  width: 50%;
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
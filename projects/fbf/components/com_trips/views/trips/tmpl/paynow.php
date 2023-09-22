<div class="innerpage_banner2">
       <div class="item"><img src="images/pro.png" alt=""></div>
</div>

<div class="paynow_page">
   <div class="paynow_center">
        <div class="paynow">
		<?php
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$user_id=$user->id;
		$oid = JRequest::getvar('oid');
		$orderby = JRequest::getvar('trip_type');

		if($oid){
			echo '<p>Your documents have been uploaded successfully.</p>';
		}

		$sql="SELECT * FROM `#__users` WHERE id=$user_id";
	    $db->setQuery($sql);
	    $users_detail=$db->loadObjectList();
	    foreach($users_detail as $user_disp) {
	        $username=$user_disp->name;
	        $contact=$user_disp->phone;
	        $mail=$user_disp->email;
	    }

	    if($orderby=='customized') {
	        $triptype=1;
	        $sqlx="SELECT * FROM `#__customized_order` WHERE id=$oid";
	    	$db->setQuery($sqlx);
	    	$final_detail=$db->loadObjectList();
	    	foreach($final_detail as $finalqute_disp) {
	    	     $orderid=$finalqute_disp->id;
	    	     $payment_type=$finalqute_disp->payment_type;
	    	     $no_people=$finalqute_disp->no_people;
	    	     $first_installement=$finalqute_disp->first_installement;

	    	     $amount=$first_installement;
	    	}
	    } else if($orderby=='semi') {
	        $triptype=2;
	        $sqlx="SELECT * FROM `#__semicustomized_order` WHERE id=$oid";
	    	$db->setQuery($sqlx);
	    	$final_detail=$db->loadObjectList();
	    	foreach($final_detail as $finalqute_disp) {
	    	$orderid=$finalqute_disp->id;
	    	$payment_type=$finalqute_disp->paymethod;
	    	$first_installement=$finalqute_disp->first_installement;
	    	$amount=$first_installement;
	    	}
	    } else {
	        $triptype=3;
	        $sqlx="SELECT * FROM `#__fixed_trip_orders` WHERE id=$oid";
	    	$db->setQuery($sqlx);
	    	$final_detail=$db->loadObjectList();
	    	foreach($final_detail as $finalqute_disp) {
	    	$oid=$finalqute_disp->id;
	    	$no_people=$finalqute_disp->no_of_people;
	    	$payment_type=$finalqute_disp->paymethod;
	    	$first_installement=$finalqute_disp->first_installment;
	    	$amount=$first_installement*$no_people;
	    	}
	    }

		if($payment_type=='Participative') {
			//$amount=$first_installement;
			?>
		<form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $oid; ?>' enctype='multipart/form-data'>
		  <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
		  <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
		  <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
		  <input type="hidden" value="<?php echo $orderby; ?>-<?php echo $oid; ?>-first" id="productinfo" name="productinfo">
		  <input type="hidden" value="<?php echo $amount; ?>" id="amount" name="amount">
		  <input type="submit" value="Continue Booking" id="cb" name="cb">
		</form>
			<?php
		} else if($payment_type=='Split') {
			echo '<h3 class="h1class">Payment Link</h3>';
	    	$paymentlink=''.JURI::root().'share-payment/?oid='.$oid.'&t='.$triptype.'';
	    	echo '<p id="paylink">
	    		<a href="'.$paymentlink.'" class="a2a_button_facebook" target="_blank">' .
	    				'<input type="text" value="'.$paymentlink.'" name="myInput" id="myInput" readonly></a></p>
				<button class="copylink" onclick="myFunction()">Copy Link</button>';
		}
		else {
			?>
			<form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $oid; ?>' enctype='multipart/form-data'>
			  <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
			  <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
			  <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
			  <input type="hidden" value="<?php echo $orderby; ?>-<?php echo $oid; ?>-first" id="productinfo" name="productinfo">
			  <input type="hidden" value="<?php echo $amount; ?>" id="amount" name="amount">
			  <input type="submit" value="Continue Booking" id="cb" name="cb">
			</form>
			<?php
		}
	?>
	</div>
	</div>
</div>
<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("copy");
}
</script>
<div class="innerpage_banner2">
       <div class="item"><img src="images/pro.png" alt=""></div>
</div>
<?php
$db = JFactory::getDbo();
	$status=$_POST["status"];
	$firstname=$_POST["firstname"];
	$amount=$_POST["amount"];
	$txnid=$_POST["txnid"];
	$posted_hash=$_POST["hash"];
	$key=$_POST["key"];
	$productinfo=$_POST["productinfo"];
	$email=$_POST["email"];
	$phone=$_POST["phone"];
	$salt="Zv4aHtx68w";

    $oid = JRequest::getvar('oid');

// Salt should be same Post Request

If (isset($_POST["additionalCharges"])) {
       $additionalCharges=$_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
  } else {
        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
         }
		 $hash = hash("sha512", $retHashSeq);
       if ($hash != $posted_hash) {
	       echo "<div class='pay_sucess sucee'><h3>Invalid Transaction. Please try again</h3></div>";
		   } else {

		   	// Action
		   	
		   	 $productinfo;
		   	
		   	if($productinfo==1){
		   	    $trip_type='customized';
        		$paymentlink=''.JURI::root().'share-payment/?oid='.$oid.'&t=1';
        		$sqlx="SELECT * FROM `#__customized_order` WHERE id=$oid";
        		$db->setQuery($sqlx);
        		$final_detail=$db->loadObjectList();
        		foreach($final_detail as $finalqute_disp) {
        		     $orderid=$finalqute_disp->id;
        		     $payment_type=$finalqute_disp->payment_type;
        		     $organizer_id=$finalqute_disp->uid;
        		     $first_installment=$finalqute_disp->first_installement;
        		     $balance=$finalqute_disp->final_installement;
        		}
		   	} else if($productinfo==2) {
		   	    $trip_type='semi';
		   	   	$paymentlink=''.JURI::root().'share-payment/?oid='.$oid.'&t=2';
        		$sqlx="SELECT * FROM `#__semicustomized_order` WHERE id=$oid";
        		$db->setQuery($sqlx);
        		$final_detail=$db->loadObjectList();
        		foreach($final_detail as $finalqute_disp) {
        		     $orderid=$finalqute_disp->id;
        		     $payment_type=$finalqute_disp->paymethod;
        		     $organizer_id=$finalqute_disp->uid;
        		     $first_installment=$finalqute_disp->first_installement;
        		     $balance=$finalqute_disp->final_installement;
        		} 
		   	    
		   	} else if($productinfo==3) {
		   	    $trip_type='fixed';
		   	   	$paymentlink=''.JURI::root().'share-payment/?oid='.$oid.'&t=3';
        		$sqlx="SELECT * FROM `#__fixed_trip_orders` WHERE id=$oid";
        		$db->setQuery($sqlx);
        		$final_detail=$db->loadObjectList();
        		foreach($final_detail as $finalqute_disp) {
        		     $orderid=$finalqute_disp->id;
        		     $payment_type=$finalqute_disp->paymethod;
        		     $organizer_id=$finalqute_disp->uid;
        		   $first_installment=$finalqute_disp->first_installment;
        		   $balance=$finalqute_disp->final_installment;
        		   $no_of_people=$finalqute_disp->no_of_people;
        		   
        		 $first_installment_fixed= $first_installment*$no_of_people;
        		 $balance= $balance*$no_of_people;
        		   
        		} 
		   	}
		   	
		   	
		$paidsql="SELECT COUNT(id) FROM `#__sharepayment` WHERE txnid='$txnid'";
		$db->setQuery($paidsql);
		$paidcount=$db->loadResult();
		
	
		
		 if($paidcount==0) {
			$date = date('Y-m-d H:i:s');
			$object = new stdClass();
			$object->id = '';
			$object->pay_status ='first';
			$object->organizer_id =$organizer_id;
			$object->trip_type =$trip_type;
			$object->payment_type  =$payment_type;
			$object->orderid  =$oid;
			$object->friendname  =$firstname;
			$object->friendemail  =$email;
			$object->friendnum  =$phone;
			$object->paymentlink  =$paymentlink;
			$object->paid_amt  =$amount;
			$object->txnid  =$txnid;
			$result =$db->insertObject('#__sharepayment', $object);
			$user_data="SELECT * FROM `#__users` where id='$organizer_id'";
        $db->setQuery($user_data);
        $user_result=$db->loadObjectList();
        foreach($user_result as $userdta){
            $name=$userdta->name;
        	$lname=$userdta->lname;
        	$uemail=$userdta->email;
        	$mobile=$userdta->phone;
        }
			/**Mail Function**/
            $from_id = "admin@francebyfrench.com";
			$to =  'paul.martin@francebyfrench.com' ;
			$subject ='FRANCEBYFRENCH FIRST INSTALLMENT - PART PAYMENT - RECEIVED';
			$message = '<p>Dear Team,</p> 
            <p>₹ '.$amount.' received for '.$name.' '.$lname.' trip</p>
            Payer Name - '.$firstname.' <br>
            Payer Email - '.$email.'<br>
            Payer Mobile number - '.$phone.'<br>
            Trip Type - '.$trip_type.' <br>
            Order id - '.$oid. '<br>
            Transaction id - '.$txnid. '<br>
            First installment on a '.$payment_type.' mode.  </p>
            <p>Thanks, </p><p>FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
			$headers .= 'Cc: apoorva.uniyal@francebyfrench.com' . "\r\n";
			$headers .= 'Bcc: souria.boumedine@francebyfrench.com' . "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
            
            $to2 =  $email;
			$subject2 = 'FRANCEBYFRENCH PAYMENT RECEIVED ';
			$message2 = '<p>Dear – '.$firstname.' -, </p><p>You payed ₹'.$amount.' for '.$name.' '.$lname.'</p>
			<p>Your transaction id is '.$txnid. '</p>
            <p>Thanks,</p><p>FranceByFrench</p>';
			$headers2 = "MIME-Version: 1.0" . "\r\n";
			$headers2 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers2 .= 'From:'.$from_id. "\r\n";
			$sentmail2 = mail($to2,$subject2,$message2,$headers2);
			
			$to1 =  $uemail;
			$subject1 = 'FRANCEBYFRENCH - PART PAYMENT RECEIVED';
			$message1 = '<p>Dear – '.$name.' -, </p>
			<p>Payer name - '.$firstname.' </p>
			<p>Payer email - '.$email.' </p>
			<p>Payer mobile number - '.$phone.' </p>
			<p>Payed amount - '.$amount.' </p>
			<p>Transaction id - '.$txnid.' </p>
            <p>A bientôt,</p><p>FranceByFrench</p>';
			$headers1 = "MIME-Version: 1.0" . "\r\n";
			$headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers1 .= 'From:'.$from_id. "\r\n";
			$sentmails = mail($to1,$subject1,$message1,$headers1);
			/******Mail Function ends*******/
			
			 $from_id = "admin@francebyfrench.com";
			$tof =  'paul.martin@francebyfrench.com' ;
			$subjectf ='FRANCEBYFRENCH FIRST INSTALLMENT RECEIVED';
			$messagef = '<p>Dear Team,</p> 
			<p> '.$name.' '.$lname.'  has paid full payment of the first installment on a '.$payment_type.' MODE. 
			Please report to the Dashboard and make sure other members of the group have done the same 
			 Trip Type - '.$trip_type.' <br>
            Order id - '.$oid. '</p>
            <p>Thanks, </p><p>FranceByFrench</p>';
			$headersf = "MIME-Version: 1.0" . "\r\n";
			$headersf .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headersf .= 'From:'.$from_id. "\r\n";
			$headersf .= 'Cc: apoorva.uniyal@francebyfrench.com' . "\r\n";
			$headersf .= 'Bcc: souria.boumedine@francebyfrench.com' . "\r\n";
			
			 $from_id = "admin@francebyfrench.com";
			$tou =  $uemail ;
			$subjectu ='FRANCEBYFRENCH FIRST INSTALLMENT RECEIPT CONFIRMATION';
			$messageu = '<p>Dear '.$name.',</p> 
			<p>Thank you for your payment. Please keep in mind that the payment for the outstanding 
			balance of '.$balance.' is due 45 days prior to your departure date. Your welcome gift box is on its way.<br><br>
			 We look forward to welcoming you in France </p>
            <p>A bientot, </p><p>FranceByFrench</p>';
			$headersu = "MIME-Version: 1.0" . "\r\n";
			$headersu .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headersu .= 'From:'.$from_id. "\r\n";
            
			/* */
			if($trip_type=='customized'){
			    
			    $sql3="SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$oid AND trip_type='customized' AND pay_status='first'";
                $db->setQuery($sql3);
                $paid_amt=$db->loadResult();

		        $firstbalce=$first_installment-$paid_amt;
    		    if($firstbalce==0) {
        		    $date = date('Y-m-d H:i:s');
        			$object2 = new stdClass();
        			$object2->id = $oid;
        			$object2->payment_status ='first_installment';
        			JFactory::getDbo()->updateObject('#__customized_order', $object2, 'id');
        			$sentmailf = mail($tof,$subjectf,$messagef,$headersf);
        			$sentmailfu = mail($tou,$subjectu,$messageu,$headersu);
    		    }
			    
			} 
			if($trip_type=='semi') {
				$sql3="SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$oid AND trip_type='semi' AND pay_status='first'";
                $db->setQuery($sql3);
                $paid_amt=$db->loadResult();

		        $firstbalce=$first_installment-$paid_amt;
    		    if($firstbalce==0) {
    		        	
        		    $date = date('Y-m-d H:i:s');
        			$object2 = new stdClass();
        			$object2->id = $oid;
        			$object2->payment_status ='first_installment';
        			JFactory::getDbo()->updateObject('#__semicustomized_order', $object2, 'id');  
        			$sentmailf = mail($tof,$subjectf,$messagef,$headersf);
        				$sentmailfu = mail($tou,$subjectu,$messageu,$headersu);
    		    }

			} 
			if($trip_type=='fixed') {
			    
				$sql3="SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$oid AND trip_type='fixed' AND pay_status='first'";
                $db->setQuery($sql3);
                $paid_amt3=$db->loadResult();

		       $firstbalcef=$first_installment_fixed - $paid_amt3;

    		    if($firstbalcef==0) {
        		    $date = date('Y-m-d H:i:s');
        			$object4 = new stdClass();
        			$object4->id = $oid;
        			$object4->payment_status ='first_installment';
        			$result=JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object4, 'id');  
        			$sentmailf = mail($tof,$subjectf,$messagef,$headersf);
        				$sentmailfu = mail($tou,$subjectu,$messageu,$headersu);
    		    }
			}
		 }

 echo "<div class='pay_sucess'>
    <div class='pay_sucess1'>
        <div class='pay_sucess2'>
        <img src='images/checked.png'>
            <div class='pay_sucess3'>
             <h3>Merci / Thank You</h3>
         <h3>Your payment process is successful</h3>
        <h4>The Transaction ID for this payment is <span class='blue'> "   .$txnid.".</span></h4>
         <h4>Amount received is Rs <span class='blue'><img src='images/pay.png'> " . $amount . ".</span></h4> </div></div></div></div>";
		   }
?>
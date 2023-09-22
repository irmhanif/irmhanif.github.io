<div class="innerpage_banner2">
       <div class="item"><img src="images/pro.png" alt=""></div>
</div>
<?php
    $db = JFactory::getDbo();
    $user = JFactory::getUser();
    $user_id=$user->id;

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt="Zv4aHtx68w";

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
            
          $productinfo= explode('-', $productinfo);
 $product = $productinfo[0];
 $orderid = $productinfo[1];
 $installment = $productinfo[2];

date_default_timezone_set("Asia/Kolkata");
 $pay_date1=date("Y-m-d H:i:s");

 if($installment=='first'){
     if($product=="customized") {
         $sql2="SELECT final_installement FROM `#__customized_order` WHERE id=$orderid";
		 $db->setQuery($sql2);
		 $balance=$db->loadResult();
         $object2 = new stdClass();
         $object2->id=$orderid;
         $object2->payment_status="first_installment";
         $object2->txnid=$txnid;
         $object2->pay_date1=$pay_date1;
         JFactory::getDbo()->updateObject('#__customized_order', $object2, 'id');

     } else if($product=="semi") {
         $sql2="SELECT final_installement FROM `#__semicustomized_order` WHERE id=$orderid";
		 $db->setQuery($sql2);
		 $balance=$db->loadResult();
         $object2 = new stdClass();
         $object2->id=$orderid;
         $object2->payment_status="first_installment";
         $object2->txnid=$txnid;
         $object2->pay_date1=$pay_date1;
         JFactory::getDbo()->updateObject('#__semicustomized_order', $object2, 'id');

     } else {
         $sql2="SELECT final_installment FROM `#__fixed_trip_orders` WHERE id=$orderid";
		 $db->setQuery($sql2);
		 $balance=$db->loadResult();
         $object2 = new stdClass();
         $object2->id=$orderid;
         $object2->payment_status="first_installment";
         $object2->txnid=$txnid;
         $object2->pay_date1=$pay_date1;
         JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');

     }
     $txt='<p>Thank you for your payment. Please keep in mind that the payment for the outstanding balance of ₹– '.$balance.' – is due 45 days prior to your departure date. Your welcome gift box is on its way.
             </p><p>We look forward to welcoming you in France </p><p>A bientôt,</p><p>FranceByFrench</p>';
 } else {
     if($product=="customized") {
         $object2 = new stdClass();
         $object2->id=$orderid;
         $object2->payment_status="final_installment";
         $object2->txnid2=$txnid;
         $object2->pay_date2=$pay_date1;
         JFactory::getDbo()->updateObject('#__customized_order', $object2, 'id');

     } else if($product=="semi") {
         $object2 = new stdClass();
         $object2->id=$orderid;
         $object2->payment_status="final_installment";
         $object2->txnid2=$txnid;
         $object2->pay_date2=$pay_date1;
         JFactory::getDbo()->updateObject('#__semicustomized_order', $object2, 'id');

     } else {
         $object2 = new stdClass();
         $object2->id=$orderid;
         $object2->payment_status="final_installment";
         $object2->txnid2=$txnid;
         $object2->pay_date2=$pay_date1;
         JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');

     }
     $txt='<p>Thank you for your last payment and we are thrilled to confirm that your trip is booked! We will reach out to you very soon to share all the details</p>
     <p>A bientôt,</p><p>FranceByFrench</p>';
 }
 
 if($installment=='first'){
     $installment='FIRST';
 } else {
      $installment='FINAL';
 }
    $user_data="SELECT * FROM `#__users` where id='$user_id'";
		$db->setQuery($user_data);
		$user_result=$db->loadObjectList();
		foreach($user_result as $userdta){
		    $name=$userdta->name;
		    $lname=$userdta->lname;
		    $email=$userdta->email;
		    $mobile=$userdta->phone;
		}
 /**Mail Function**/
            $from_id = "admin@francebyfrench.com";
			$to =  'paul.martin@francebyfrench.com' ;
			$subject ='FRANCEBYFRENCH  - '.$installment.' INSTALLMENT RECEIVED ';
			$message = '<p>'.$installment.' Payment Done for '.$name.' '.$lname.'</p><p>User contact number -'.$mobile.'</p>';
			$message .= '<p>User payed his '.$installment.' payment for '.$product.' trip </p><p>User payed '.$amount.' </p><p> Transaction id - '.$txnid.' and Payment time '.$pay_date1.'</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
			$headers .= 'Cc: apoorva.uniyal@francebyfrench.com' . "\r\n";
			$headers .= 'Bcc: souria.boumedine@francebyfrench.com' . "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
            //$adsentmail = mail($toa,$subject,$message,$headers);

			$to1 =  $email;
			$subject1 = 'FRANCEBYFRENCH '.$installment.' INSTALLMENT RECEIPT CONFIRMATION ';
			$message1 = '<p>Dear – '.$name.' </p>';
			$message1 .= $txt;
			$headers1 = "MIME-Version: 1.0" . "\r\n";
			$headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers1 .= 'From:'.$from_id. "\r\n";
			$sentmails = mail($to1,$subject1,$message1,$headers1);
			/******Mail Function ends*******/
			
			 echo "<div class='pay_sucess'>
    <div class='pay_sucess1'>
        <div class='pay_sucess2'>
        <img src='images/checked.png'>
            <div class='pay_sucess3'>
             <h3>Merci / Thank You</h3>
         <h3>Your payment process is successful</h3>
        <h4>The Transaction ID for this payment is <span class='blue'> "   .$txnid.".</span></h4>
         <h4>Amount received is <span class='blue'><img src='images/pay.png'>" . $amount . "</span></h4> </div></div></div></div>";
			
	    /*		
          echo "<h3>Merci / Thank You</h3>";
          echo "<h3>Your payment process is successful.</h3>";
          echo "<h4>The Transaction ID for this payment is <span class='blue'>".$txnid.".</span> </h4>";
          echo "<h4>Amount received is <span class='blue'> <img src='images/pay.png'> " . $amount . "</span></h4>";
          
          */
          
		   }
?>
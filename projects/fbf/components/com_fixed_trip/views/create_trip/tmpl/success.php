<?php
/*$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$udf1=$_POST["udf1"];

$txnid=$_POST["txnid"];
echo $posted_hash=$_POST["hash"];
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
         echo "<br>";
		echo $hash = hash("sha512", $retHashSeq);
       if ($hash != $posted_hash) {
	       echo "Invalid Transaction. Please try again";
		   } else {

		   	// Action

          echo "<h3>Thank You. Your order status is ". $status .".</h3>";
          echo "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
          echo "<h4>We have received a payment of Rs. " . $udf1 . "</h4>";
		   }*/
?>
<div class="item"><img src="images/fixedb/P12GFTP4.jpg" alt=""></div>

<?php
    $db = JFactory::getDbo();
$inst = JRequest::getvar('inst');
$oid = JRequest::getvar('oid');
$txnid='txnid2';

if($inst == '') {
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$udf1=$_POST["udf1"];
$udf2=$_POST["udf2"];
   
$txnid='txnid';
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$phone=$_POST["phone"];
 $sqllist="SELECT * FROM `#__fixed_trip_orders` WHERE id='$udf2'";
$db->setQuery($sqllist);
$result=$db->loadObjectList();
foreach($result as $data) {
  $uid=$data->uid;
  $fname=$data->uname;
  $email=$data->uemail;
  $phone=$data->umobile;
  $product=$data->pack_title;
  $f_amount=$data->final_installment;
  $f_date=$data->final_inst_date;
  $f_date = date('d-M-Y', strtotime($f_date));
}

$object2 = new stdClass();
      $object2->id=$udf2;

    $object2->payment_status="first_installment";
    $object2->txnid=$txnid;
  JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');
?>
<h4>Your Transaction ID for this transaction is <?php echo $txnid; ?></h4>
<h4>Your Balance amount  <?php echo $f_amount; ?> should be paid before <?php echo $f_date; ?></h4>
<?php
}
else {


$object2 = new stdClass();
      $object2->id=$oid;

    $object2->payment_status="final_installment";
    $object2->txnid=$txnid;
  JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');
  ?> 
  <h4>Your Transaction ID for this transaction is <?php echo $txnid; ?></h4>
<h4>Your completed all your payments</h4>

<?php
}

?>
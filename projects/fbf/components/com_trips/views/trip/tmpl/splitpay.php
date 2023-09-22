<?php
$db = JFactory::getDbo();
$user = JFactory::getUser();
$user_id=$user->id;
$uid = JRequest::getVar('uid');
$orderid = JRequest::getVar('orderid');
$sharid = JRequest::getVar('sharid');

$sql="SELECT * FROM `#__sharepayment` WHERE id=$sharid AND organizer_id=$uid";
$db->setQuery($sql);
$shareddetail=$db->loadObjectList();

foreach($shareddetail as $shareddetail_des) {
	$id=$shareddetail_des->id;
	$organizer_id=$shareddetail_des->organizer_id;
	echo $orderid=$shareddetail_des->orderid;
	echo '<br>';
	$friendemail=$shareddetail_des->friendemail;
	$friendnum=$shareddetail_des->friendnum;
	$paymentlink=$shareddetail_des->paymentlink;
	$paid_amt=$shareddetail_des->paid_amt;
	$friendname=$shareddetail_des->friendname;
	$trip_type=$shareddetail_des->trip_type;

	if($trip_type=='customized') {
	$sql="SELECT * FROM `#__customized_order` WHERE uid=$organizer_id";
	$db->setQuery($sql);
	$event_detail=$db->loadObjectList();
	foreach($event_detail as $event_disp) {
	echo $orderid=$event_disp->id;
	 }
  }
}
?>

<h3>Payment Link</h3>

	<form method="POST" action="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=sharepay&id=<?php echo $id; ?>">
		<input type="hidden" value="" id="amount" name="amount">
		<input type="hidden" value="<?php echo $friendname; ?>" class="firstname" name="firstname">
		<input type="hidden" value="<?php echo $friendemail; ?>" class="email" name="email">
		<input type="hidden" value="<?php echo $friendnum; ?>" class="phone" name="phone">
		<input type="hidden" value="customized Order" class="productinfo" name="productinfo">

		<input type="submit" value="paynow">
	</form>

<div class="innerpage_banner2">
       <div class="item"><img src="images/pro.png" alt=""></div>
</div>
<?php
$db = JFactory::getDbo();
$user = JFactory::getUser();
$user_id=$user->id;
$orderid = JRequest::getVar('oid');
$triptype = JRequest::getVar('triptype');

?>
	<form action="#" Method="POST" id="sharepay" name="sharepay">
		<p>
	        <label>Name</label>
	        <input type="text" value="" name="friendname" id="friendname">
	    </p>
	    <p>
	        <label>Email</label>
	        <input type="text" value="" name="friendemail" id="friendemail">
	    </p>
	    <p>
	        <label>Number</label>
	        <input type="text" value="" name="friendnum" id="friendnum">
	    </p>
	    <input type="hidden" value="<?php echo $triptype; ?>" name="triptype" id="triptype">
	    <input type="hidden" value="<?php echo $orderid; ?>" name="orderid" id="orderid">
	    <input type="hidden" value="com_trips" name="option">
        <input type="hidden" value="trips.shareLink" name="task">
		<input type="submit" value="Submit">
	</form>
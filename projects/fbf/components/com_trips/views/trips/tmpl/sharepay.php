<div class="innerpage_banner2">
       <div class="item"><img src="images/pro.png" alt=""></div>
</div>
	<?php
	$db = JFactory::getDbo();
	$main_orderid = JRequest::getVar('oid');
	$main_ordertype = JRequest::getVar('t');
	date_default_timezone_set("Asia/Kolkata");
$ckhtym = date('Y-m-d H:i:s');

	if($main_ordertype==1){
    $_POST['productinfo'] = $main_ordertype;
        $sql2="SELECT * FROM `#__customized_order` WHERE id=$main_orderid";
		$db->setQuery($sql2);
		$trip_detail=$db->loadObjectList();

		foreach($trip_detail as $trip_res) {
		    $uid=$trip_res->uid;
		    $share_msg=$trip_res->share_msg;
		    $final_cost=$trip_res->final_cost;
		    $first_installement=$trip_res->first_installement;
		    $last_day_for_first_installement=$trip_res->last_day_for_first_installement;
		    $vrfdate=date('Y-m-d H:i:s', strtotime($last_day_for_first_installement));
		    
		    $vrfdatedisp1=date('Y-m-d', strtotime($last_day_for_first_installement));
            $vrfdatedisp1a=date('h:i a', strtotime($last_day_for_first_installement));


		    
		    $originalDate = "$last_day_for_first_installement";
            $newDate = date("d-m-Y", strtotime($originalDate));
		    $final_installement=$trip_res->final_installement;
		    $last_day_for_final_installement=$trip_res->last_day_for_final_installement;
		    $no_people=$trip_res->no_people;
		    $payment_status=$trip_res->payment_status;
		}
        if($vrfdate<$ckhtym){
            echo '<div class="display_quote sharepayexpire"><div class="paynow"><p>Link Expired - Kindly contact us</p></div></div>';
        } else {
            
        
		   /* Get previous sharepayment amount */

        $sqlprevcount="SELECT COUNT(id) FROM `#__sharepayment` WHERE orderid=$main_orderid AND trip_type='customized' AND paid_amt!=0 AND pay_status='first'";
		$db->setQuery($sqlprevcount);
		$prev_count=$db->loadResult();

		if($prev_count!=0) {
		 	$sql3="SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$main_orderid AND trip_type='customized' AND pay_status='first'";
			$db->setQuery($sql3);
			$paid_amt=$db->loadResult();

		    $totalbalce=$final_cost-$paid_amt;
			$firstbalce=$first_installement-$paid_amt;
    		if($firstbalce==0){
    		     header("Location:index.php?option=com_trips&view=trip&t=$main_ordertype&oid=$main_orderid");
    		}
		} else {
		    $firstbalce=$first_installement;
		}
        if($payment_status=='first_installment') {
		    header("Location:index.php?option=com_trips&view=trip&t=$main_ordertype&oid=$main_orderid");
		}

		?>

    <div class="sharepay">
    <div class="sharepaydetail2">
	    <div class="sharepaydetail">
	       <div class="share">
        	   <div class="share1">
        	       <div class="share2">
        	          <h5>Organizer of this trip has a message :</h5>
        	           <p class="pay_txt"><?php echo $share_msg; ?></p>
        	           <?php
                	    $sqlz1="SELECT * FROM `#__users` WHERE id='$uid'";
        			 	$db->setQuery($sqlz1);
        			    $organizer_detail=$db->loadObjectList();
        				foreach($organizer_detail as $organizer_disp) {
        					$userid=$organizer_disp->id;
        					$username=$organizer_disp->name;
        					$contact=$organizer_disp->phone;
        					$mail=$organizer_disp->email;
        				}
        	           ?>
        	           <div class="userdetails"> 
        	              <h5>Organizer Details</h5>
        	              <p class="userdet">Name  : <?php echo $username; ?></p>
        	              <p class="userdet">E-mail : <?php echo $mail; ?></p>
        	           </div>
        	           
        	           </div></div></div>
	    <div class="sharepaydetails">
	        <h1>Payment Page</h1>
	        <div class="share_pay">
            <h5>Take a part in the :</h5>
            <h4>First Intallment</h4>
	        <p><span class="leftlabel">Total price for the First Intallment is :</span><span class="right_text"><img src="images/pay.png"> <?php echo $first_installement; ?></span></p>
	        <p><span class="leftlabel">This paymnet should be completed before :</span><span class="right_text"> <?php echo $vrfdatedisp1; ?>, <?php echo $vrfdatedisp1a; ?></span></p>
	        <?php
	        echo '<p><span class="leftlabel">Remaining Amount to complete first installment is : </span><span><img src="images/pay.png"> '.$firstbalce.'</span></p>';
			?>
	    </div>

	    <!-- Payment Gateway -->
        <?php
	    $sql2="SELECT * FROM `#__customized_order` WHERE id=$main_orderid";
		$db->setQuery($sql2);
		$trip_detailz=$db->loadObjectList();

		foreach($trip_detailz as $trip_res) {
		    $final_cost=$trip_res->final_cost;
		    $first_installement=$trip_res->first_installement;
		    $final_installement=$trip_res->final_installement;
		}

        $sql3="SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$main_orderid AND trip_type='customized' AND pay_status='first'";
        $db->setQuery($sql3);
        $paid_amt=$db->loadResult();

		$firstbalce=$first_installement-$paid_amt;

$MERCHANT_KEY = "tp5sgpDy";
$SALT = "Zv4aHtx68w";
// Merchant Key and Salt as provided by Payu.

//$PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

$action = '';

$posted = array();
if(!empty($_POST)) {
  foreach($_POST as $key => $value) {
    $posted[$key] = $value;
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>

  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {

      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
        rev = jQuery.noConflict();
        rev(document).ready(function() {
        rev('body').on('click', "#fpay_submit",function(){
        var balanceamt= <?php echo $firstbalce; ?>;
      	var amount=document.getElementById("amount").value;
	    var firstname=document.getElementById("firstname").value;
	    var email=document.getElementById("email").value;
	    var phone=document.getElementById("phone").value;
	    var productinfo=document.getElementById("productinfo").value;

		var letters = /^[a-zA-Z\ ]*$/;
	    var email_reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var num = /^\d{10}$/;

       if(amount=="") {
		document.getElementById("amount").style.borderBottom = "1px solid #F97D09";
		rev("#amount").focus();

	    return false;

       } else if(amount>balanceamt) {
        document.getElementById("amount").style.borderBottom = "1px solid #F97D09";
		rev("#amount").focus();
		rev("#error").html("Entered amount is exceed from the first installemnt. Balance Amount is:" +balanceamt);
	    return false;

           } else {
           document.getElementById("amount").style.borderBottom = "1px solid #eee";
       }

       if(firstname=="") {
		document.getElementById("firstname").style.borderBottom = "1px solid #F97D09";
		rev("#firstname").focus();

	    return false;
       } else if (!/^[a-z A-Z]*$/g.test(firstname)) {
        rev("#firstname").focus();
        return false;
       } else {
           document.getElementById("firstname").style.borderBottom = "1px solid #eee";
       }
       if(email=="") {
		document.getElementById("email").style.borderBottom = "1px solid #F97D09";
        rev("#email").focus();

	    return false;

       } else if (email_reg.test(email) == false) {
            rev("#email").focus();
            return false;
        } else {
           document.getElementById("email").style.borderBottom = "1px solid #eee";
       }
       if(phone=="") {
		document.getElementById("phone").style.borderBottom = "1px solid #F97D09";
		rev("#phone").focus();
	    return false;

       } else if (num.test(phone) == false) {
            rev("#phone").focus();
            return false;
        } else {
           document.getElementById("phone").style.borderBottom = "1px solid #eee";
       }
       if(productinfo=="") {
		document.getElementById("productinfo").style.borderBottom = "1px solid #F97D09";
		//amount.focus();
		alert("Kindly go back");
	    return false;

       } else {
           document.getElementById("productinfo").style.borderBottom = "1px solid #eee";
           return true;
       }
   });
});
  </script>
  
<div class="sharepay">
  <body onload="submitPayuForm()">

    <?php if($formError) { ?>
    <?php } ?>
	<div class="fpayment">
	<div class="f1payment">
	<div class="f2payment">
	    	  <h2>Payment Information</h2>
    <form action="<?php echo $action; ?>" method="post" name="payuForm" >
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <span id="error"></span>
      <div class="fpayment_amount1">
          <div class="fpayment_amount">
          <input name="amount" id="amount" placeholder="Amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" />
		  </div>
		  <div class="fpayment_amount">
          <input name="firstname" id="firstname" placeholder="Name" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname'] ?>" />
        </div></div>
        <div class="fpayment_amount1">
        	  <div class="fpayment_amount">
          <input name="email" id="email"  placeholder="Email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email'] ?>" />
          </div>
		  <div class="fpayment_amount">
          <input name="phone"  id="phone" placeholder="Phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone'] ?>" />
		  </div> </div>
        <div class="ffpayment_amount">
          <input type="hidden" name="productinfo" id="productinfo" value="<?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?>">
        </div>
<input name="surl" type="hidden" value="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=sharesuccess&oid=<?php echo $main_orderid; ?>"  />
<input name="furl" type="hidden" value="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=failure"  />

         <div class="fpayment_amount">
       <input type="hidden" name="service_provider" id="service_provider" value="payu_paisa" size="64" />
        </div>
          <div class="fbfpayment_amount">
          <?php if(!$hash) { ?>
          <p id="pay_tc"><input type="checkbox" name="price_check" value="" required="" id="agree_chk1"><span class="pay_tc1">I accept with  <a target="_blank" href="<?php echo JURI::root(); ?>index.php?option=com_content&view=article&id=11&Itemid=166">terms and conditions</a></span></p>
           <input type="submit" value="Pay Now" id="fpay_submit" />
          <?php }  ?>
        </div>
      </form>
</div>
</div>
</div>
</div></div>
</div> </div>
<!-- payment gateway  1 end -->

	</div>
<?php
}
 } else if($main_ordertype==2){
        $_POST['productinfo'] = $main_ordertype;
        $sql2="SELECT * FROM `#__semicustomized_order` WHERE id=$main_orderid";
		$db->setQuery($sql2);
		$trip_detail=$db->loadObjectList();

		foreach($trip_detail as $trip_res) {
		    $uid=$trip_res->uid;
		    $share_msg=$trip_res->share_msg;
		    $final_cost=$trip_res->final_cost;
		    $first_installement=$trip_res->first_installement;
		    $last_day_for_first_installement=$trip_res->last_day_for_first_installement;
		    $vrfdate=date('Y-m-d H:i:s', strtotime($last_day_for_first_installement));
	
		    $vrfdatedisp2=date('Y-m-d', strtotime($last_day_for_first_installement));
            $vrfdatedisp2a=date('h:i a', strtotime($last_day_for_first_installement));
		    	
		    	
		    
		    $no_people=$trip_res->number_peoples;
		    $payment_status=$trip_res->payment_status;
		}

       if($vrfdate<$ckhtym){
            echo '<div class="display_quote sharepayexpire"><div class="paynow"><p>Link Expired - Kindly contact us</p></div></div>';
        } else {
		   /* Get previous sharepayment amount */

        $sqlprevcount="SELECT COUNT(id) FROM `#__sharepayment` WHERE orderid=$main_orderid AND trip_type='semi' AND paid_amt!=0 AND pay_status='first'";
		$db->setQuery($sqlprevcount);
		$prev_count=$db->loadResult();

		if($prev_count!=0) {
		 	$sql3="SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$main_orderid AND trip_type='semi' AND pay_status='first'";
			$db->setQuery($sql3);
			$paid_amt=$db->loadResult();

		    $totalbalce=$final_cost-$paid_amt;
			$firstbalce=$first_installement-$paid_amt;
			$finalbalce=$final_installement;
		}  else {
		    $firstbalce=$first_installement;
		}
		
		if($payment_status=='first_installment') {
		    header("Location:index.php?option=com_trips&view=trip&t=$main_ordertype&oid=$main_orderid");
		}

     ?>
 <div class="sharepay">
    <div class="sharepaydetail2">
	    <div class="sharepaydetail">
	       <div class="share">
        	   <div class="share1">
        	       <div class="share2">
        	           <h5>Organizer of this trip has a message :</h5>
        	           <p class="pay_txt"><?php echo $share_msg; ?></p>
        	           <?php
                	    $sqlz1="SELECT * FROM `#__users` WHERE id='$uid'";
        			 	$db->setQuery($sqlz1);
        			    $organizer_detail=$db->loadObjectList();
        				foreach($organizer_detail as $organizer_disp) {
        					$userid=$organizer_disp->id;
        					$username=$organizer_disp->name;
        					$contact=$organizer_disp->phone;
        					$mail=$organizer_disp->email;
        				}
        	           ?>
        	           <div class="userdetails"> 
        	              <h5>Organizer Details</h5>
        	              <p class="userdet">Name  : <?php echo $username; ?></p>
        	              <p class="userdet">E-mail : <?php echo $mail; ?></p>
        	           </div>
        	           
        	       </div>
        	  </div>
        </div>
	    <div class="sharepaydetails">
	         <h1>Payment Page</h1>
	        <div class="share_pay">
            <h5>Take a part in the :</h5>
             <h4>First Intallment</h4>
	        <p><span class="leftlabel">Total price for the First Intallment is :</span><span class="right_text"><img src="images/pay.png">  <?php echo $first_installement; ?></span></p>
	        <p><span class="leftlabel">This paymnet should be completed before :</span><span class="right_text"> <?php echo $vrfdatedisp2; ?>,<?php echo $vrfdatedisp2a; ?></span></p>
	        <?php
	          echo '<p><span class="leftlabel">Remaining Amount to complete first installment is : </span><span><img src="images/pay.png">  '.$firstbalce.'</span></p>';
			?>

	       </div>
	    

	    <!-- Payment gateway 2 start-->

<?php
	    $MERCHANT_KEY = "tp5sgpDy";
$SALT = "Zv4aHtx68w";
// Merchant Key and Salt as provided by Payu.

// $PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

$action = '';

$posted = array();
if(!empty($_POST)) {
  foreach($_POST as $key => $value) {
    $posted[$key] = $value;
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;

    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>

  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {

      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
        rev = jQuery.noConflict();
        rev(document).ready(function() {
        rev('body').on('click', "#fpay_submit",function(){
        var balanceamt= <?php echo $firstbalce; ?>;
      	var amount=document.getElementById("amount").value;
	    var firstname=document.getElementById("firstname").value;
	    var email=document.getElementById("email").value;
	    var phone=document.getElementById("phone").value;
	    var productinfo=document.getElementById("productinfo").value;

		var letters = /^[a-zA-Z\ ]*$/;
	    var email_reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var num = /^\d{10}$/;

       if(amount=="") {
		document.getElementById("amount").style.borderBottom = "1px solid #F97D09";
		rev("#amount").focus();

	    return false;

       } else if(amount>balanceamt) {
        document.getElementById("amount").style.borderBottom = "1px solid #F97D09";
		rev("#amount").focus();
		rev("#error").html("Entered amount is exceed from the first installemnt. Balance Amount is:" +balanceamt);
	    return false;

           } else {
           document.getElementById("amount").style.borderBottom = "1px solid #eee";
       }

       if(firstname=="") {
		document.getElementById("firstname").style.borderBottom = "1px solid #F97D09";
		rev("#firstname").focus();

	    return false;
       } else if (!/^[a-z A-Z]*$/g.test(firstname)) {
        rev("#firstname").focus();
        return false;
       } else {
           document.getElementById("firstname").style.borderBottom = "1px solid #eee";
       }
       if(email=="") {
		document.getElementById("email").style.borderBottom = "1px solid #F97D09";
        rev("#email").focus();

	    return false;

       } else if (email_reg.test(email) == false) {
            rev("#email").focus();
            return false;
        } else {
           document.getElementById("email").style.borderBottom = "1px solid #eee";
       }
       if(phone=="") {
		document.getElementById("phone").style.borderBottom = "1px solid #F97D09";
		rev("#phone").focus();
	    return false;

       } else if (num.test(phone) == false) {
            rev("#phone").focus();
            return false;
        } else {
           document.getElementById("phone").style.borderBottom = "1px solid #eee";
       }
       if(productinfo=="") {
		document.getElementById("productinfo").style.borderBottom = "1px solid #F97D09";
		//amount.focus();
		alert("Kindly go back");
	    return false;

       } else {
           document.getElementById("productinfo").style.borderBottom = "1px solid #eee";
           return true;
       }
   });
});
  </script>

<div class="payment_page">
  <body onload="submitPayuForm()">

    <?php if($formError) { ?>
   
    <?php } ?>
	<div class="fpayment">
	<div class="f1payment">
	<div class="f2payment">
	 <h2>Payment Information</h2>
    <form action="<?php echo $action; ?>" method="post" name="payuForm" >
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <span id="error"></span>
      <div class="fpayment_amount1">
      <div class="fpayment_amount">
          <input name="amount" id="amount" placeholder="Amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" />
		  </div>
		  <div class="fpayment_amount">
          <input name="firstname" id="firstname" placeholder="Name" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname'] ?>" />
        </div></div>
        <div class="fpayment_amount1">
        	  <div class="fpayment_amount">
          <input name="email" id="email"  placeholder="Email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email'] ?>" />
          </div>
		  <div class="fpayment_amount">
          <input name="phone"  id="phone" placeholder="Phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone'] ?>" />
		  </div> </div>
        <div class="ffpayment_amount">
          <input type="hidden" name="productinfo" id="productinfo" value="<?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?>">
        </div>
<input name="surl" type="hidden" value="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=sharesuccess&oid=<?php echo $main_orderid; ?>"  />
<input name="furl" type="hidden" value="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=failure"  />

         <div class="fpayment_amount">
       <input type="hidden" name="service_provider" id="service_provider" value="payu_paisa" size="64" />
        </div>
          <div class="fbfpayment_amount">
          <?php if(!$hash) { ?>
          <p id="pay_tc"><input type="checkbox" name="price_check" value="" required="" id="agree_chk1"><span class="pay_tc1">I accept with  <a target="_blank" href="<?php echo JURI::root(); ?>index.php?option=com_content&view=article&id=11&Itemid=169">terms and conditions</a></span></p>
           <input type="submit" value="Pay Now" id="fpay_submit" />
          <?php }  ?>
        </div>
      </form>
        </div>
        </div>
        </div>
        </div>
</div>
</div>
</div></div>


<?php
}
 } else if($main_ordertype==3){
        $_POST['productinfo'] = $main_ordertype;
        $sql2="SELECT * FROM `#__fixed_trip_orders` WHERE id=$main_orderid";
		$db->setQuery($sql2);
		$trip_detail=$db->loadObjectList();

		foreach($trip_detail as $trip_res) {
		    $uid=$trip_res->uid;
		    $share_msg=$trip_res->share_msg;
		    $final_cost=$trip_res->total_price_gst;
		    $first_installement=$trip_res->first_installment;
		    $last_day_for_first_installement=$trip_res->first_inst_date;
		    $no_people=$trip_res->no_of_people;
		$vrfdate=date('Y-m-d H:i:s', strtotime($last_day_for_first_installement));
		$vrfdatedisp=date('Y-m-d h:i a', strtotime($last_day_for_first_installement));
		
		
				    $vrfdatedisp=date('Y-m-d', strtotime($last_day_for_first_installement));
           $vrfdatedisp2a=date('h:i a', strtotime($last_day_for_first_installement));
		
		
		    $payment_status=$trip_res->payment_status;
		}

        $first_installement=$first_installement*$no_people;
        $final_cost=$final_cost*$no_people;
		   /* Get previous sharepayment amount */
     if($vrfdate<$ckhtym){
            echo '<div class="display_quote sharepayexpire"><div class="paynow"><p>Link Expired - Kindly contact us</p></div></div>';
        } else {
        $sqlprevcount="SELECT COUNT(id) FROM `#__sharepayment` WHERE orderid=$main_orderid AND trip_type='fixed' AND paid_amt!=0 AND pay_status='first'";
		$db->setQuery($sqlprevcount);
		$prev_count=$db->loadResult();

		if($prev_count!=0) {
		 	$sql3="SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$main_orderid AND trip_type='fixed' AND pay_status='first'";
			$db->setQuery($sql3);
			$paid_amt=$db->loadResult();

		    $totalbalce=$final_cost-$paid_amt;
			$firstbalce=$first_installement-$paid_amt;
			$finalbalce=$final_installement;
		}  else {
		    $firstbalce=$first_installement;
		}
		
		if($payment_status=='first_installment') {
		    header("Location:index.php?option=com_trips&view=trip&t=$main_ordertype&oid=$main_orderid");
		}

     ?>
 <div class="sharepay">
    <div class="sharepaydetail2">
	    <div class="sharepaydetail">
	       <div class="share">
        	   <div class="share1">
        	       <div class="share2">
        	           <h5>Organizer of this trip has a message :</h5>
        	           <p class="pay_txt"><?php echo $share_msg; ?></p>
        	           <?php
                	    $sqlz1="SELECT * FROM `#__users` WHERE id='$uid'";
        			 	$db->setQuery($sqlz1);
        			    $organizer_detail=$db->loadObjectList();
        				foreach($organizer_detail as $organizer_disp) {
        					$userid=$organizer_disp->id;
        					$username=$organizer_disp->name;
        					$contact=$organizer_disp->phone;
        					$mail=$organizer_disp->email;
        				}
        	           ?>
        	           <div class="userdetails"> 
        	              <h5>Organizer Details</h5>
        	              <p class="userdet">Name  : <?php echo $username; ?></p>
        	              <p class="userdet">E-mail : <?php echo $mail; ?></p>
        	           </div>
        	           </div></div></div>
	    <div class="sharepaydetails">
	         <h1>Payment Page</h1>
	        <div class="share_pay">
           <h5>Take a part in the :</h5>
           <h4>First Intallment</h4>
	        <p><span class="leftlabel">Total price for the First Intallment is :</span><span class="right_text"><img src="images/pay.png"> <?php echo $first_installement; ?></span></p>
	        <p><span class="leftlabel">This paymnet should be completed before :</span><span class="right_text"><?php echo $vrfdatedisp; ?>, <?php echo $vrfdatedisp2a;  ?></span></p>
	        <?php
	        echo '<p><span class="leftlabel">Remaining Amount to complete first installment is : </span><span><img src="images/pay.png"> '.$firstbalce.'</span></p>';
			?>
	    </div>
	    </div>


  <!-- Payment gateway 2 start-->

<?php
$MERCHANT_KEY = "tp5sgpDy";
$SALT = "Zv4aHtx68w";
// Merchant Key and Salt as provided by Payu.

// $PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

$action = '';

$posted = array();
if(!empty($_POST)) {
  foreach($_POST as $key => $value) {
    $posted[$key] = $value;
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>

  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {

      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
        rev = jQuery.noConflict();
        rev(document).ready(function() {
        rev('body').on('click', "#fpay_submit",function(){
        var balanceamt=<?php echo $firstbalce; ?>;
      	var amount=document.getElementById("amount").value;
	    var firstname=document.getElementById("firstname").value;
	    var email=document.getElementById("email").value;
	    var phone=document.getElementById("phone").value;
	    var productinfo=document.getElementById("productinfo").value;
	    

		var letters = /^[a-zA-Z\ ]*$/;
	    var email_reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var num = /^\d{10}$/;

       if(amount=="") {
		document.getElementById("amount").style.borderBottom = "1px solid #F97D09";
		rev("#amount").focus();

	    return false;

       } else if(amount > balanceamt) {
        document.getElementById("amount").style.borderBottom = "1px solid #F97D09";
		rev("#amount").focus();
		rev("#error").html("Entered amount is exceed from the first installemnt. Balance Amount is:" +balanceamt);
	    return false;

           } else {
           document.getElementById("amount").style.borderBottom = "1px solid #eee";
       }

       if(firstname=="") {
		document.getElementById("firstname").style.borderBottom = "1px solid #F97D09";
		rev("#firstname").focus();

	    return false;
       } else if (!/^[a-z A-Z]*$/g.test(firstname)) {
        rev("#firstname").focus();
        return false;
       } else {
           document.getElementById("firstname").style.borderBottom = "1px solid #eee";
       }
       if(email=="") {
		document.getElementById("email").style.borderBottom = "1px solid #F97D09";
        rev("#email").focus();

	    return false;

       } else if (email_reg.test(email) == false) {
            rev("#email").focus();
            return false;
        } else {
           document.getElementById("email").style.borderBottom = "1px solid #eee";
       }
       if(phone=="") {
		document.getElementById("phone").style.borderBottom = "1px solid #F97D09";
		rev("#phone").focus();
	    return false;

       } else if (num.test(phone) == false) {
            rev("#phone").focus();
            return false;
        } else {
           document.getElementById("phone").style.borderBottom = "1px solid #eee";
       }
       if(productinfo=="") {
		document.getElementById("productinfo").style.borderBottom = "1px solid #F97D09";
		//amount.focus();
		alert("Kindly go back");
	    return false;

       } else {
           document.getElementById("productinfo").style.borderBottom = "1px solid #eee";
           return true;
       }
   });
});
  </script>

<div class="payment_pagemerchant">
  <body onload="submitPayuForm()">

    <?php if($formError) { ?>

    <?php } ?>
	<div class="fpayment">
	<div class="f1payment">
	<div class="f2payment">
	  	  <h2>Payment Information</h2>
    <form action="<?php echo $action; ?>" method="post" name="payuForm" >
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <span id="error"></span>
      <div class="fpayment_amount1">
      <div class="fpayment_amount">
          <input name="amount" id="amount" placeholder="Amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" />
		  </div>
		  <div class="fpayment_amount">
          <input name="firstname" id="firstname" placeholder="Name" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname'] ?>" />
        </div></div>
        <div class="fpayment_amount1">
        	  <div class="fpayment_amount">
          <input name="email" id="email"  placeholder="Email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email'] ?>" />
          </div>
		  <div class="fpayment_amount">
          <input name="phone"  id="phone" placeholder="Phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone'] ?>" />
		  </div> </div>
        <div class="ffpayment_amount">
          <input type="hidden" name="productinfo" id="productinfo" value="<?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?>">
        </div>
            <input name="surl" type="hidden" value="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=sharesuccess&oid=<?php echo $main_orderid; ?>"  />
            <input name="furl" type="hidden" value="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=failure"  />

         <div class="fpayment_amount">
       <input type="hidden" name="service_provider" id="service_provider" value="payu_paisa" size="64" />
        </div>
          <div class="fbfpayment_amount">
          <?php if(!$hash) { ?>
          <p id="pay_tc"><input type="checkbox" name="price_check" value="" required="" id="agree_chk1"><span class="pay_tc1">I accept with  <a target="_blank" href="<?php echo JURI::root(); ?>index.php?option=com_content&view=article&id=11&Itemid=166">terms and conditions</a></span></p>
           <input type="submit" value="Submit" id="fpay_submit" />
          <?php }  ?>
        </div>
      </form>
        </div>
        </div>
        </div>
        </div>
	</div>	    </div>
	    </div>

<?php

 }
 }else {
    echo '';
}

?>


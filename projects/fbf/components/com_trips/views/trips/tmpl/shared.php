<div class="innerpage_banner2">
       <div class="item"><img src="images/pro.png" alt=""></div>
</div>
<?php
$db = JFactory::getDbo();
$oid = JRequest::getvar('oid');

        $sql2="SELECT * FROM `#__customized_order` WHERE id=$oid";
		$db->setQuery($sql2);
		$trip_detail=$db->loadObjectList();

		foreach($trip_detail as $trip_res) {
		    $final_cost=$trip_res->final_cost;
		    $first_installement=$trip_res->first_installement;
		    $final_installement=$trip_res->final_installement;
		} 

        $sql3="SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$oid AND trip_type='customized'";
        $db->setQuery($sql3);
        $paid_amt=$db->loadResult();

		$firstbalce=$first_installement-$paid_amt;

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

      <br/>
      <br/>
    <?php } ?>
	<div class="fpayment">
	<div class="f1payment">
	<div class="f2payment">
	    	  <h2>Pay Now</h2>
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
<input name="surl" type="hidden" value="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=sharesuccess&oid=<?php echo $oid; ?>"  />
<input name="furl" type="hidden" value="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=failure"  />

         <div class="fpayment_amount">
       <input type="hidden" name="service_provider" id="service_provider" value="payu_paisa" size="64" />
        </div>
          <div class="fbfpayment_amount">
          <?php if(!$hash) { ?>
           <input type="submit" value="Submit" id="fpay_submit" />
          <?php }  ?>
        </div>
      </form>
</div>
</div>
</div>
</div> 
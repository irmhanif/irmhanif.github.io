<div class="innerpage_banner">
  <div class="item"><img src="images/pro.png" alt=""></div>
</div>
<?php
$db = JFactory::getDbo();
$main_orderid = JRequest::getVar('oid');

$MERCHANT_KEY = "tp5sgpDy";
$SALT = "Zv4aHtx68w";
// Merchant Key and Salt as provided by Payu.

// $PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
$PAYU_BASE_URL = "https://secure.payu.in";      // For Production Mode

$action = '';

$posted = array();
if (!empty($_POST)) {
  //print_r($_POST);
  foreach ($_POST as $key => $value) {
    $posted[$key] = $value;
  }
}

$formError = 0;

if (empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if (empty($posted['hash']) && sizeof($posted) > 0) {
  if (
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
    foreach ($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif (!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}

$payinfoz = $posted['productinfo'];




$temvariable = explode("-", $payinfoz);

$type = $temvariable[0];
$orderid = $temvariable[1];
$installmentz = $temvariable[2];


if ($payinfoz != '') {


  if ($type == 'fixed') {
    $newsql = "SELECT * FROM `#__fixed_trip_orders` WHERE id=$orderid";
    $db->setQuery($newsql);
    $order_result = $db->loadObjectList();

    foreach ($order_result as $order_result_des) {
      $id = $order_result_des->id;
      $first_inst_date = $order_result_des->first_inst_date;
      $final_inst_date = $order_result_des->final_inst_date;
    }
    if ($installmentz == 'first') {
      $limitdate = $first_inst_date;

      $limitdate1 = date('Y-m-d', strtotime($limitdate));
      $limitdatetime = date('h:i a', strtotime($limitdate));

      $addtittle = 'First';
    } else {
      $limitdate = $final_inst_date;

      $limitdate1 = date('Y-m-d', strtotime($limitdate));
      $limitdatetime = date('h:i a', strtotime($limitdate));


      $addtittle = 'Final';
    }
  } else if ($type == 'customized') {
    $newsql = "SELECT * FROM `#__customized_order` WHERE id=$orderid";
    $db->setQuery($newsql);
    $order_result = $db->loadObjectList();

    foreach ($order_result as $order_result_des) {
      $id = $order_result_des->id;
      $first_inst_date = $order_result_des->last_day_for_first_installement;
      $final_inst_date = $order_result_des->last_day_for_final_installement;
    }
    if ($installmentz == 'first') {
      $limitdate = $first_inst_date;

      $limitdate1 = date('Y-m-d', strtotime($limitdate));
      $limitdatetime = date('h:i a', strtotime($limitdate));


      $addtittle = 'First';
    } else {
      $limitdate = $final_inst_date;

      $limitdate1 = date('Y-m-d', strtotime($limitdate));
      $limitdatetime = date('h:i a', strtotime($limitdate));

      $addtittle = 'Final';
    }
  } else {
    $newsql = "SELECT * FROM `#__semicustomized_order` WHERE id=$orderid";
    $db->setQuery($newsql);
    $order_result = $db->loadObjectList();

    foreach ($order_result as $order_result_des) {
      $id = $order_result_des->id;
      $first_inst_date = $order_result_des->last_day_for_first_installement;
      $final_inst_date = $order_result_des->last_day_for_final_installement;
    }
    if ($installmentz == 'first') {
      $limitdate = $first_inst_date;
      $limitdate1 = date('Y-m-d', strtotime($limitdate));
      $limitdatetime = date('h:i a', strtotime($limitdate));
      $addtittle = 'First';
    } else {
      $limitdate = $final_inst_date;
      $limitdate1 = date('Y-m-d', strtotime($limitdate));
      $limitdatetime = date('h:i a', strtotime($limitdate));
      $addtittle = 'Final';
    }
  }
} else {
  header('Location: https://www.francebyfrench.com/index.php?option=com_users&view=profile');
}


//
?>

<script>
  var hash = '<?php echo $hash ?>';

  function submitPayuForm() {
    if (hash == '') {
      return;
    }
    var payuForm = document.forms.payuForm;
    payuForm.submit();
  }
  rev = jQuery.noConflict();

  rev(document).ready(function() {

    rev('body').on('click', "#fpay_submit", function() {

      var amount = document.getElementById("amount").value;

      var firstname = document.getElementById("firstname").value;

      var email = document.getElementById("email").value;

      var phone = document.getElementById("phone").value;

      var productinfo = document.getElementById("productinfo").value;



      var letters = /^[a-zA-Z\ ]*$/;

      var email_reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

      var num = /^\d{10}$/;


      if (amount == "") {

        document.getElementById("amount").style.borderBottom = "1px solid #F97D09";

        //amount.focus();

        return false;



      } else {

        document.getElementById("amount").style.borderBottom = "1px solid #eee";

      }



      if (firstname == "") {

        document.getElementById("firstname").style.borderBottom = "1px solid #F97D09";

        //amount.focus();



        return false;

      } else if (!/^[a-z A-Z]*$/g.test(firstname)) {



        return false;

      } else {

        document.getElementById("firstname").style.borderBottom = "1px solid #eee";

      }

      if (email == "") {

        document.getElementById("email").style.borderBottom = "1px solid #F97D09";

        //amount.focus();



        return false;



      } else if (email_reg.test(email) == false) {



        return false;

      } else {

        document.getElementById("email").style.borderBottom = "1px solid #eee";

      }

      if (phone == "") {

        document.getElementById("phone").style.borderBottom = "1px solid #F97D09";

        //amount.focus();



        return false;



      } else if (num.test(phone) == false) {



        return false;

      } else {

        document.getElementById("phone").style.borderBottom = "1px solid #eee";

      }

      if (productinfo == "") {

        document.getElementById("productinfo").style.borderBottom = "1px solid #F97D09";

        //amount.focus();

        alert("Kindly go back");

        return false;
      } else {
        document.getElementById("productinfo").style.borderBottom = "1px solid #eee";
        return true;
      }
    })

  });
</script>

</script>
<div class="sharepay sharepaynormal">
  <h1>Payment Page</h1>
  <div class="pay_nowpage">
    <div class="share_pay">
      <h5>Clear the:</h5>
      <p><?php echo $addtittle; ?> Installment</p>
      <p><span class="leftlabel">Total Price for the <?php echo $addtittle; ?> installment is</span> <span class="right_text"><img src="images/pay.png"> <?php echo $posted['amount']; ?></span></p>
      <p><span class="leftlabel">This payment should be completed before </span> <span class="right_text"> <?php echo $limitdate1; ?>, <?php echo $limitdatetime; ?></span></p>

    </div>
    <div class="payment_page">

      <body onload="submitPayuForm()">

        <div class="fpayment">
          <div class="f1payment">
            <div class="f2payment">
              <h2>Payment Information</h2>
              <?php if ($formError) { ?>
              <?php } ?>
              <form action="<?php echo $action; ?>" method="post" name="payuForm">
                <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                <input type="hidden" name="hash" value="<?php echo $hash ?>" />
                <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                <table>
                  <?php
                  $amount = $_POST['amount'];
                  if ($amount != '') {
                    $readonly = 'readonly';
                  } else {
                    $readonly = '';
                  }
                  ?>

                  <div class="fpayment_amount1">
                    <div class="fpayment_amount">
                      <input name="amount" id="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" <?php echo $readonly; ?> />
                    </div>
                    <div class="fpayment_amount">
                      <input name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" />
                    </div>
                  </div>

                  <div class="fpayment_amount1">
                    <div class="fpayment_amount">
                      <input name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" />
                    </div>
                    <div class="fpayment_amount">
                      <input name="phone" id="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" />
                    </div>
                  </div>
                  <div class="fpayment_amount">
                    <input type="hidden" value="<?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?>" name="productinfo">
                  </div>

                  <input name="surl" type="hidden" value="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=success" />
                  <input name="furl" type="hidden" value="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=failure" />
                  <div class="fpayment_amount">
                    <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
                  </div>

                  <?php if (!$hash) { ?>
                    <div class="fbfpayment_amount">
                      <p id="pay_tc"><input type="checkbox" name="price_check" value="" required="" id="agree_chk1"><span class="pay_tc1">I accept with <a href="<?php echo JURI::root(); ?>index.php?option=com_content&amp;view=article&amp;id=11&amp;Itemid=169" target="_blank">Terms and Conditions</a></span></p>
                      <input type="submit" value="Pay Now" id="fpay_submit" />
                    </div>
                  <?php } ?>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
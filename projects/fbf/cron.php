<?php

define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
global $mainframe;
$mainframe =JFactory::getApplication('site');
$mainframe->initialise();

/*
           $from_id = "admin@francebyfrench.com";
			$to =  'vikram.zinavo@gmail.com' ;
			$subject ='testing for cron';
			$message = '<p>test,</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers); 
*/


$db = JFactory::getDbo();
date_default_timezone_set("Asia/Kolkata");
 $ckhtym = date('Y-m-d H:i:s');

  $sqlc='SELECT COUNT(id) FROM `#__customized_order` where payment_status ="first_installment"';
$db->setQuery($sqlc);
 $ccount = $db->loadResult();

$sqls='SELECT COUNT(id) FROM `#__semicustomized_order` where payment_status ="first_installment"';
$db->setQuery($sqls);
$scount = $db->loadResult();

$sqlf='SELECT COUNT(id) FROM `#__fixed_trip_orders` where payment_status ="first_installment"';
$db->setQuery($sqlf);
$fcount = $db->loadResult();

if ($ccount != 0) {
    $sql = "SELECT * FROM `#__customized_order` WHERE payment_status ='first_installment'";
    $db->setQuery($sql);
    $result = $db->loadObjectList();
    foreach ($result as $res_disp) {
        $orderid = $res_disp->id;
        $user_id = $res_disp->uid;
        $cron_mail = $res_disp->cron_mail;
        $payment_date = $res_disp->last_day_for_final_installement;
        $final_installment = $res_disp->final_installement;
        $payment_type = $res_disp->payment_type;
        $final_inst_date=2;
        $payment_date=date('Y-m-d H:i:s', strtotime($payment_date.'-'.$final_inst_date.' days'));
        if($payment_type=='Normal'){
            $final_installment=$final_installment;
        } else {
            $sql_get_share = "SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$orderid AND trip_type='customized' AND pay_status='final'";
            $db->setQuery($sql_get_share);
            $share_pay_amt = $db->loadResult();
            $final_installment = $final_installment - $share_pay_amt;
        }
        $user_sql = "SELECT * FROM `#__users` WHERE id=$user_id";
        $db->setQuery($user_sql);
        $user_data = $db->loadObjectList();
        foreach ($user_data as $res_disp) {
           $name = $res_disp->name;
           $lname = $res_disp->lname;
           $phone = $res_disp->phone;
           $mail = $res_disp->email;
            
        }
        if(($ckhtym > $payment_date) && ($cron_mail==0)) {
           $from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH 48H PAYMENT REMINDER NOTIFICATION';
			$message = '<p>Dear '.$name.' '.$lname.',</p>
			<p>The date of your booking with us is fast approaching and the final balance is due soon. The outstanding balance of
			'.$final_installment.' -is due within the next 48 hours.</p><p>A bientot,</p><p>FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers); 
            
            
$message = 'Dear '.$name.',
The date of your booking with us is fast approaching and the final balance is due soon. The outstanding balance of '.$final_installment.' -is due within the next 48 hours.
Thanks,
FranceByFrench';
            
            $data = array(
                   'sender' => 'FBFMSG',
                   'route' => '4',
                   'mobiles' => $phone,
				   'authkey' => 'test', //251010ABuhjQsbrn2s5c0bcd2d
				   'country' => 'INDIA',
				   'message' => $message
				);

				# Create a connection
				$url = 'http://api.msg91.com/api/sendhttp.php';
				$ch = curl_init($url);

				# Form data string
				echo $postString = http_build_query($data, '', '&');

				# Setting our options
				echo curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				# Get the response
				echo $response = curl_exec($ch);

				$array_station = json_decode($response, true);

                print_r($array_station);
				curl_close($ch);

	/* Order SMS to customer code END */
            
            $object_all = new stdClass();
            $object_all->id=$orderid;
            $object_all->cron_mail= 1;
            JFactory::getDbo()->updateObject('#__customized_order', $object_all, 'id');
        }
        
    }
}
if ($scount != 0) {
    $sql = "SELECT * FROM `#__semicustomized_order` WHERE payment_status ='first_installment'";
    $db->setQuery($sql);
    $result = $db->loadObjectList();
    foreach ($result as $res_disp) {
        $orderid = $res_disp->id;
        $user_id = $res_disp->uid;
        $cron_mail = $res_disp->cron_mail;
        $payment_date = $res_disp->last_day_for_final_installement;
        $final_installment = $res_disp->final_installement;
        $payment_type = $res_disp->paymethod;
        $final_inst_date=2;
        $payment_date=date('Y-m-d H:i:s', strtotime($payment_date.'-'.$final_inst_date.' days'));
        if($payment_type=='Normal'){
            $final_installment=$final_installment;
        } else {
            $sql_get_share = "SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$orderid AND trip_type='semi' AND pay_status='final'";
            $db->setQuery($sql_get_share);
            $share_pay_amt = $db->loadResult();
            $final_installment = $final_installment - $share_pay_amt;
        }
        $user_sql = "SELECT * FROM `#__users` WHERE id=$user_id";
        $db->setQuery($user_sql);
        $user_data = $db->loadObjectList();
        foreach ($user_data as $res_disp) {
           $name = $res_disp->name;
           $lname = $res_disp->lname;
           $phone = $res_disp->phone;
           $mail = $res_disp->email;
            
        }
        if(($ckhtym >= $payment_date) && ($cron_mail==0)) {
           $from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH 48H PAYMENT REMINDER NOTIFICATION';
			$message = '<p>Dear '.$name.' '.$lname.',</p>
			<p>The date of your booking with us is fast approaching and the final balance is due soon. The outstanding balance of
			'.$final_installment.' -is due within the next 48 hours.</p><p>A bientot,</p><p>FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers); 
            
            
$message = 'Dear '.$name.',
The date of your booking with us is fast approaching and the final balance is due soon. The outstanding balance of '.$final_installment.' -is due within the next 48 hours.
A bientot,
FranceByFrench';
            
            $data = array(
                   'sender' => 'FBFMSG',
                   'route' => '4',
                   'mobiles' => $phone,
				   'authkey' => 'test', //251010ABuhjQsbrn2s5c0bcd2d
				   'country' => 'INDIA',
				   'message' => $message
				);

				# Create a connection
				$url = 'http://api.msg91.com/api/sendhttp.php';
				$ch = curl_init($url);

				# Form data string
				echo $postString = http_build_query($data, '', '&');

				# Setting our options
				echo curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				# Get the response
				echo $response = curl_exec($ch);

				$array_station = json_decode($response, true);

                print_r($array_station);
				curl_close($ch);

	/* Order SMS to customer code END */
            
            $object_all = new stdClass();
            $object_all->id=$orderid;
            $object_all->cron_mail= 1;
            JFactory::getDbo()->updateObject('#__semicustomized_order', $object_all, 'id');
        }
        
    }
}
if ($fcount != 0) {
        $sql = "SELECT * FROM `#__fixed_trip_orders` WHERE payment_status ='first_installment'";
        $db->setQuery($sql);
        $result = $db->loadObjectList();
        foreach ($result as $res_disp) {
        $orderid = $res_disp->id;
        $user_id = $res_disp->uid;
        $cron_mail = $res_disp->cron_mail;
        $payment_date = $res_disp->final_inst_date;
        $final_installment = $res_disp->final_installment;
        $payment_type = $res_disp->paymethod;
         
      
        $final_inst_date=2;
        $payment_date=date('Y-m-d H:i:s', strtotime($payment_date.'-'.$final_inst_date.' days'));
       
        if($payment_type=='Normal'){
            $final_installment=$final_installment;
        } else {
            $sql_get_share = "SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$orderid AND trip_type='fixed' AND pay_status='final'";
            $db->setQuery($sql_get_share);
            $share_pay_amt = $db->loadResult();
            $final_installment = $final_installment - $share_pay_amt;
        }
        $user_sql = "SELECT * FROM `#__users` WHERE id=$user_id";
        $db->setQuery($user_sql);
        $user_data = $db->loadObjectList();
        foreach ($user_data as $res_disp) {
           $name = $res_disp->name;
           $lname = $res_disp->lname;
           $phone = $res_disp->phone;
           $mail = $res_disp->email;
            
        }
        if(($ckhtym >= $payment_date) && ($cron_mail==0)) {
           $from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH 48H PAYMENT REMINDER NOTIFICATION';
			$message = '<p>Dear '.$name.' '.$lname.',</p>
			<p>The date of your booking with us is fast approaching and the final balance is due soon. The outstanding balance of
			'.$final_installment.' -is due within the next 48 hours.</p><p>A bientot,</p><p>FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
            
$message = 'Dear '.$name.',
The date of your booking with us is fast approaching and the final balance is due soon. The outstanding balance of '.$final_installment.' -is due within the next 48 hours.
A bientot,
FranceByFrench';
            
            $data = array(
                   'sender' => 'FBFMSG',
                   'route' => '4',
                   'mobiles' => $phone,
				   'authkey' => 'test', //251010ABuhjQsbrn2s5c0bcd2d
				   'country' => 'INDIA',
				   'message' => $message
				);

				# Create a connection
				$url = 'http://api.msg91.com/api/sendhttp.php';
				$ch = curl_init($url);

				# Form data string
				echo $postString = http_build_query($data, '', '&');

				# Setting our options
				echo curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				# Get the response
				echo $response = curl_exec($ch);

				$array_station = json_decode($response, true);

                print_r($array_station);
				curl_close($ch);

	/* Order SMS to customer code END */
            
            
            $object_all = new stdClass();
            $object_all->id=$orderid;
            $object_all->cron_mail= 1;
            JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object_all, 'id');
        }
        
    } 
     
}

?>

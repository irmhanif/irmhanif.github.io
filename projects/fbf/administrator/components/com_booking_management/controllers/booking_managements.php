<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Booking_management
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

use Joomla\Utilities\ArrayHelper;

/**
 * Booking_managements list controller class.
 *
 * @since  1.6
 */
class Booking_managementControllerBooking_managements extends JControllerAdmin
{
	/**
	 * Method to clone existing Booking_managements
	 *
	 * @return void
	 */
	public function duplicate()
	{
		// Check for request forgeries
		Jsession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get id(s)
		$pks = $this->input->post->get('cid', array(), 'array');

		try
		{
			if (empty($pks))
			{
				throw new Exception(JText::_('COM_BOOKING_MANAGEMENT_NO_ELEMENT_SELECTED'));
			}

			ArrayHelper::toInteger($pks);
			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Jtext::_('COM_BOOKING_MANAGEMENT_ITEMS_SUCCESS_DUPLICATED'));
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_booking_management&view=booking_managements');
	}

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    Optional. Model name
	 * @param   string  $prefix  Optional. Class prefix
	 * @param   array   $config  Optional. Configuration array for model
	 *
	 * @return  object	The Model
	 *
	 * @since    1.6
	 */
	public function getModel($name = 'booking_management', $prefix = 'Booking_managementModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks   = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		ArrayHelper::toInteger($pks);
		ArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
	public function filters1(){
		$db=JFactory::getDbo();
		$name = JRequest::getvar('name','');
		$numb = JRequest::getvar('cnum','');
		$enddate = JRequest::getvar('enddate','');
	    $satrtdate = JRequest::getvar('satrtdate','');
	    $delorder = JRequest::getvar('delorder','');

    if($delorder!=''){
	    $del="DELETE FROM `#__customized_order` WHERE id=$delorder";
	    $db->setQuery($del);
	    $result = $db->query();
	 }


		$addsec='00';
		$newstartDate = date("Y-m-d", strtotime($satrtdate));
		$newsendDate = date("Y-m-d", strtotime($enddate));
		$frmdatetime =  $newstartDate;
		$upto_datetime =  $newsendDate;
		$sql="SELECT * FROM `#__customized_order` WHERE id!=''";
		$sqlc="SELECT COUNT(id) FROM `#__customized_order` WHERE id!=''";
		if($satrtdate) {
			$sql.=" AND cart_date BETWEEN '$frmdatetime' AND '$upto_datetime' ";
			$sqlc.=" AND cart_date BETWEEN '$frmdatetime' AND '$upto_datetime'";
		}
		if($numb) {
			$sql.=" AND uid IN (SELECT id FROM `#__users` WHERE phone LIKE '%$numb%')";
			$sqlc.=" AND uid IN (SELECT id FROM `#__users` WHERE phone LIKE '%$numb%')";
		}
		if($name) {
			$sql.=" AND uid IN (SELECT id FROM `#__users` WHERE name LIKE '%$name%')";
			$sqlc.=" AND uid IN (SELECT id FROM `#__users` WHERE name LIKE '%$name%')";
		}
		$sql.=" ORDER BY id DESC";
		$sqlc.=" ORDER BY id DESC";
		$db->setQuery($sql);
		$event_detail=$db->loadObjectList();
		$db->setQuery($sqlc);
		$resc = $event_details=$db->loadResult();
		if($resc == '0'){
			echo "no result";
		}
		else{
			echo "<h1>Customized Trip</h1>";
			echo '<table border="0px">';
			echo '<tr><th>Order ID</th><th>Booked date</th><th>Booked Time</th><th>Customer Name</th><th>Contact Num</th><th>Email Id</th><th>Days</th><th>People</th><th>Room</th><th>Budget</th><th>Transport</th><th>Stay</th><th>Flight ticket</th><th>Keeper</th><th>Detail Link</th><th>Delete Order</th></tr>';
		foreach($event_detail as $event_disp) {
				$uid=$event_disp->uid;
				$oid=$event_disp->id;
				$cart=$event_disp->cart_date;
				$time = strtotime($cart);
				$cart = date('d-m-Y',$time);
				$carts = date('H:i:s a',$time);
				$no_days=$event_disp->no_days;
				$no_people=$event_disp->no_people;
				$no_rooms=$event_disp->no_room;
				$budget=$event_disp->budget;
				$transport=$event_disp->transport;
				$stay=$event_disp->stay;
				$stay= str_replace('_',' ',$stay);
				$flight=$event_disp->flight;
				$keeper=$event_disp->keeper;

				$sql="SELECT * FROM `#__users` WHERE id='$uid'";
			 	$db->setQuery($sql);
			    $events_detail=$db->loadObjectList();
				foreach($events_detail as $event_disp) {
					$userid=$event_disp->id;
					$username=$event_disp->name;
					$contact=$event_disp->phone;
					$mail=$event_disp->email;
			  echo '
			  <tr>
			  <td>'.$oid.'</td><td><a href="index.php?option=com_booking_management&view=booking_managements&layout=editc&id='.$oid.'">'.$cart.'</a></td>
					<td>'.$carts.'</td>
					<td><a href="index.php?option=com_booking_management&view=booking_managements&layout=editc&id='.$oid.'">'.$username.'</a></td><td>'.$contact.'</td>
					<td>'.$mail.'</td><td>'.$no_days.'</td>
					<td>'.$no_people.'</td><td>'.$no_rooms.'</td>
					<td>'.$budget.'</td><td>'.$transport.'</td>
					<td>'.$stay.'</td><td>'.$flight.'</td>
					<td>'.$keeper.'</td>
					<td><a href="index.php?option=com_booking_management&view=booking_managements&layout=editc&id='.$oid.'">VIEW</a></td>
					<td><form action="" method="post" name="cdelorder"><input type="button" value="'.$oid.'" class="delete_corder"> </form></td></tr>';
				}
	   }
		 echo "</table>";
	 }

exit;
	}
public function amountUpdateForSemicustomized() {
		$db=JFactory::getDbo();

		$qts = JRequest::getvar('qts','');
        $cost_of_flight_ticket = JRequest::getvar('cost_of_flight_ticket','');
        $cost_of_booking_Fee = JRequest::getvar('cost_of_booking_Fee','');
        $cost_of_activities = JRequest::getvar('cost_of_activities','');
        $cost_of_Keeper = JRequest::getvar('cost_of_Keeper','');
        $cost_of_insurance = JRequest::getvar('cost_of_insurance','');
        $cost_of_transport = JRequest::getvar('cost_of_transport','');
        $price_of_hotel = JRequest::getvar('price_of_hotel','');
        $total_cost_tax_free = JRequest::getvar('total_cost_tax_free',''); //total
        $comment = JRequest::getvar('comment','');

		// $orderid = JRequest::getvar('orderid','');
		$uid = JRequest::getvar('uid','');
		$gst = JRequest::getvar('totalgst','');
		$final_cost=JRequest::getvar('final_cost','');;
		$first_installement = JRequest::getvar('first_installement','');
		$last_day_for_first_installement = JRequest::getvar('last_day_for_first_installement','');
		$final_installement = JRequest::getvar('final_installement','');
		$last_day_for_final_installement = JRequest::getvar('last_day_for_final_installement','');
		$total_amount_for_filght = JRequest::getvar('total_amount_for_filght','');
		$trip_status = "quotation";
		$last_day_for_first_installement = date("Y-m-d", strtotime($last_day_for_first_installement));
		$last_day_for_final_installement = date("Y-m-d", strtotime($last_day_for_final_installement));

		$lastfinalpaytime = JRequest::getvar('lastfinalpaytime','');
		$lastfirstpaytime = JRequest::getvar('lastfirstpaytime','');

		$last_day_for_first_installement = date('Y-m-d H:i:s', strtotime("$last_day_for_first_installement $lastfirstpaytime"));
		$last_day_for_final_installement = date('Y-m-d H:i:s', strtotime("$last_day_for_final_installement $lastfinalpaytime"));

	// get order id

	$getorderdetails2="SELECT * FROM `#__semicustomized_order` WHERE uid=$uid AND quote_status=$qts";
	$db->setQuery($getorderdetails2);
	$orderdetail2=$db->loadObjectList();


	$getloopcount="SELECT COUNT(id) FROM `#__semicustomized_order` WHERE uid=$uid AND quote_status=$qts";
	$db->setQuery($getloopcount);
	$getloopcountres=$db->loadResult();

	$getnopeo="SELECT number_peoples FROM `#__semicustomized_order` WHERE uid=$uid AND quote_status=$qts";
	$db->setQuery($getnopeo);
	$getnopeople=$db->loadResult();

	$cost_of_flight_ticket=$cost_of_flight_ticket/$getloopcountres;
	$cost_of_flight_ticket=round($cost_of_flight_ticket);
	$cost_of_booking_Fee=$cost_of_booking_Fee/$getloopcountres;
	$cost_of_booking_Fee=round($cost_of_booking_Fee);
	$cost_of_activities=$cost_of_activities/$getloopcountres;
	$cost_of_activities=round($cost_of_activities);
	$cost_of_Keeper=$cost_of_Keeper/$getloopcountres;
	$cost_of_Keeper=round($cost_of_Keeper);
	$cost_of_insurance=$cost_of_insurance/$getloopcountres;
	$cost_of_insurance=round($cost_of_insurance);
	$cost_of_transport=$cost_of_transport/$getloopcountres;
	$cost_of_transport=round($cost_of_transport);
	$price_of_hotel=$price_of_hotel/$getloopcountres;
	$price_of_hotel=round($price_of_hotel);

	$total_cost_tax_free1=$total_cost_tax_free/$getnopeople;
	$total_cost_tax_free=$total_cost_tax_free1/$getloopcountres;
	$total_cost_tax_free=round($total_cost_tax_free);


	$final_cost1=$final_cost/$getnopeople;
	$final_cost=$final_cost1/$getloopcountres;
	$final_cost=round($final_cost);

	$gst1=$gst/$getnopeople;
	$gst1=$gst1/$getloopcountres;
	$gst=round($gst1);


	foreach($orderdetail2 as $orderdetail2_disp) {
	    //echo $cost_of_flight_ticket;
	    $updateid=$orderdetail2_disp->id;
	    $object2 = new stdClass();
	    $object2->id=$updateid;
		$object2->cost_of_flight_ticket=$cost_of_flight_ticket;
		$object2->cost_of_booking_Fee=$cost_of_booking_Fee;
		$object2->cost_of_activities=$cost_of_activities;
		$object2->cost_of_Keeper=$cost_of_Keeper;
		$object2->cost_of_insurance=$cost_of_insurance;
		$object2->cost_of_transport=$cost_of_transport;
		$object2->price_of_hotel=$price_of_hotel;
		$object2->total_cost_tax_free=$total_cost_tax_free;
		$object2->final_cost=$final_cost;
		$object2->gst=$gst;
		$object2->mail_count=0;
		$object2->trip_status=$trip_status;
		$object2->first_installement=$first_installement;
		$object2->last_day_for_first_installement=$last_day_for_first_installement;
		$object2->final_installement=$final_installement;
		$object2->last_day_for_final_installement=$last_day_for_final_installement;
		$object2->comment=$comment;
		$object2->total_amount_for_filght=$total_amount_for_filght;
		$result = JFactory::getDbo()->updateObject('#__semicustomized_order', $object2, 'id');

		echo $result;
	}


       /******mail********/

    $sql="SELECT * FROM `#__users` WHERE id='$uid'";
	$db->setQuery($sql);
	$events_detail=$db->loadObjectList();
		foreach($events_detail as $event_disp) {
			$userid=$event_disp->id;
			$username=$event_disp->name;
			$contact=$event_disp->phone;
			$mail=$event_disp->email;
		}

            $from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH FINAL QUOTATION UPDATE NOTIFICATION ';
			$message = '<p>Dear '.$username.'</p><p>You are one step closer to get your trip booked with us. You will find the final quote in your profile on our website. Have a look and book your trip! </p><p>A bientôt,</p><p>FRANCEBYFRENCH</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
            /*****mail********/

$message = 'Dear '.$username.',
You are one step closer to get your trip booked with us.
You will find the final quote in your profile on our website. Have a look and book your trip!
A bientôt,
FRANCEBYFRENCH';

            $data = array(
                   'sender' => 'FBFMSG',
                   'route' => '4',
                   'mobiles' => $contact,
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




	exit;
}
public function amountUpdate() {
		$db=JFactory::getDbo();
		date_default_timezone_set("Asia/Kolkata");
		$userid= JRequest::getvar('uid','');
		$flight_amount = JRequest::getvar('flight_amount','');
		$price_of_hotel = JRequest::getvar('price_of_hotel','');
		$orderid = JRequest::getvar('orderid','');
		$cost_of_activities = JRequest::getvar('cost_of_activities','');
		$cost_of_transport = JRequest::getvar('cost_of_transport','');
		$cost_of_Keeper = JRequest::getvar('cost_of_Keeper','');
		$cost_of_booking_Fee = JRequest::getvar('cost_of_booking_Fee','');
		$cost_of_insurance = JRequest::getvar('cost_of_insurance','');
		$total_cost_tax_free = JRequest::getvar('total_cost_tax_free','');
		$gst = JRequest::getvar('gst','');
		$final_cost=JRequest::getvar('final_cost','');;
		$first_installement = JRequest::getvar('first_installement','');
		$last_day_for_first_installement = JRequest::getvar('last_day_for_first_installement','');
		$final_installement = JRequest::getvar('final_installement','');
		$last_day_for_final_installement = JRequest::getvar('last_day_for_final_installement','');
		$trip_status="quotation";
		$last_day_for_first_installement = date("Y-m-d", strtotime($last_day_for_first_installement));
		$last_day_for_final_installement = date("Y-m-d", strtotime($last_day_for_final_installement));


		$lastfinalpaytime = JRequest::getvar('lastfinalpaytime','');
		$lastfirstpaytime = JRequest::getvar('lastfirstpaytime','');

		$last_day_for_first_installement = date('Y-m-d H:i:s', strtotime("$last_day_for_first_installement $lastfirstpaytime"));
		$last_day_for_final_installement = date('Y-m-d H:i:s', strtotime("$last_day_for_final_installement $lastfinalpaytime"));


		$object2 = new stdClass();
	    $object2->id=$orderid;
		$object2->flight_amount=$flight_amount;
		$object2->price_of_hotel=$price_of_hotel;

		$object2->cost_of_activities=$cost_of_activities;
		$object2->cost_of_transport=$cost_of_transport;
		$object2->cost_of_Keeper=$cost_of_Keeper;
		$object2->cost_of_booking_Fee=$cost_of_booking_Fee;
		$object2->cost_of_insurance=$cost_of_insurance;
		$object2->total_cost_tax_free=$total_cost_tax_free;
		$object2->gst=$gst;
		$object2->mail_count=0;
		$object2->final_cost=$final_cost;
		$object2->first_installement=$first_installement;
		$object2->last_day_for_first_installement=$last_day_for_first_installement;
		$object2->final_installement=$final_installement;
		$object2->last_day_for_final_installement=$last_day_for_final_installement;
		$object2->last_day_for_final_installement=$last_day_for_final_installement;
		$object2->trip_status='final_quote';
		$result = JFactory::getDbo()->updateObject('#__customized_order', $object2, 'id');

		 $sql="SELECT * FROM `#__users` WHERE id='$userid'";
			 	$db->setQuery($sql);
			    $events_detail=$db->loadObjectList();
				foreach($events_detail as $event_disp) {
					$userid=$event_disp->id;
					$username=$event_disp->name;
					$contact=$event_disp->phone;
					$mail=$event_disp->email;
				}
		/***************mail******************/
        $from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH FINAL QUOTATION UPDATE NOTIFICATION ';
			$message = '<p>Dear '.$username.'</p><p>You are one step closer to get your trip booked with us. You will find the final quote in your profile on our website. Have a look and book your trip! </p><p>A bientôt,</p><p>FRANCEBYFRENCH</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
            /***** mail *****/

$message = 'Dear '.$username.',
You are one step closer to get your trip booked with us.
You will find the final quote in your profile on our website. Have a look and book your trip!
A bientôt,
FRANCEBYFRENCH';

            $data = array(
                   'sender' => 'FBFMSG',
                   'route' => '4',
                   'mobiles' => $contact,
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



		$sql_count="SELECT COUNT(id) FROM `#__flight_price_update` WHERE uid=$userid AND type='customized'";
		$db->setQuery($sql_count);
		$count_of_update=$db->loadResult();
		if($count_of_update==0) {
			$date = date('Y-m-d H:i:s');
			$carts = date('H:i:s a',$time);
			$object = new stdClass();
			$object->id = '';
			$object->price=$flight_amount;
			$object->uid  =$userid;
			$object->date=$date;
			$object->time=$carts;
			$object->type  ='customized';
		    $db->insertObject('#__flight_price_update', $object);
		} else  {

		$prev_id="SELECT id FROM `#__flight_price_update` WHERE uid=$userid AND type='customized'";
		$db->setQuery($prev_id);
		$getprev_id=$db->loadResult();

			$date = date('Y-m-d H:i:s');
			$carts = date('H:i:sa',$time);
			$object = new stdClass();
			$object->id = $getprev_id;
			$object->price=$flight_amount;
			$object->uid  =$userid;
			$object->date=$date;
			$object->time=$carts;
			$object->type  ='customized';
		    JFactory::getDbo()->updateObject('#__flight_price_update', $object, 'id');

		}

   exit;
	}
public function filters2(){
		$db=JFactory::getDbo();
		$delorder = JRequest::getvar('delorder','');
		$duid = JRequest::getvar('duid','');
		$name = JRequest::getvar('name','');
		$numb = JRequest::getvar('cnum','');
		$enddate = JRequest::getvar('enddate','');
        $satrtdate = JRequest::getvar('satrtdate','');
		$addsec='00';
		$newstartDate = date("d-m-Y", strtotime($satrtdate));
		$newsendDate = date("d-m-Y", strtotime($enddate));

		if($delorder!=''){
			$sql_main="SELECT quote_status FROM `#__semicustomized_order` WHERE id=$delorder";
			$db->setQuery($sql_main);
		    $qtsdel=$db->loadResult();

		   $del="DELETE FROM `#__semicustomized_order` WHERE quote_status=$qtsdel AND uid=$duid";
		    $db->setQuery($del);
		    $result = $db->query();
		}

		$sql="SELECT * FROM `#__semicustomized_order` WHERE id!='' AND quote_status !=''";
		$sqlc="SELECT COUNT(id) FROM `#__semicustomized_order` WHERE id!='' AND quote_status !=''";
		if($satrtdate) {
			$sql.=" AND added_date BETWEEN '$frmdatetime' AND '$upto_datetime' ";
			$sqlc.=" AND added_date BETWEEN '$frmdatetime' AND '$upto_datetime'";
		}
		if($numb) {
			$sql.=" AND uid IN (SELECT id FROM `#__users` WHERE phone LIKE '%$numb%')";
			$sqlc.=" AND uid IN (SELECT id FROM `#__users` WHERE phone LIKE '%$numb%')";
		}
		if($name) {
			$sql.=" AND uid IN (SELECT id FROM `#__users` WHERE name LIKE '%$name%')";
			$sqlc.=" AND uid IN (SELECT id FROM `#__users` WHERE name LIKE '%$name%')";
		}
		$sql.=" GROUP BY quote_status,uid ORDER BY id DESC";
		$sqlc.=" GROUP BY quote_status,uid ORDER BY id DESC";

		 $sql;
		$db->setQuery($sql);
		$event_detail=$db->loadObjectList();
		$db->setQuery($sqlc);
		$resc = $event_details=$db->loadResult();
		if($resc == '0'){
			echo "no result";
		}
		else{
			echo "<h1>Semi Customized Trip</h1>";
			echo '<table border="0px">';
			echo '<tr><th>Order ID</th><th>Booked Date</th>
			<th>Booked Time</th><th>Quote Count</th>
			<th>Customer Name</th><th>Contact Num</th>
			<th>Email Id</th><th>Trip Date</th>
			<th>Transport</th>
			<th>Keeper</th><th>Detail</th><th>Delete</th></tr>';

			  foreach ($event_detail as $packagess_res) {
			   $quote_status=$packagess_res->quote_status;
			   $useid=$packagess_res->uid;
			    $orderid=$packagess_res->id;
				$uid=$packagess_res->uid;

				$cart=$packagess_res->added_date;
				$booked_time=$packagess_res->booked_time;
				$time = strtotime($cart);
				$cart = date('d-m-Y',$time);
				$carts = date('H:i:s a',$time);
				$noofdays=$packagess_res->noofdays;

				$trip_date=$packagess_res->trip_date;
				$number_rooms=$packagess_res->number_rooms;
				$number_peoples=$packagess_res->number_peoples;
				$keeper_information=$packagess_res->keeper_information;
				$hotel=$packagess_res->hotel;
				$hotel=str_replace('_', ' ',$hotel);
				$transport=$packagess_res->transport;
				$price=$packagess_res->price;

					$sql="SELECT * FROM `#__users` WHERE id=$uid";
					$db->setQuery($sql);
					$events_detail=$db->loadObjectList();
					foreach($events_detail as $event_disp) {
						$userid=$event_disp->id;
						$username=$event_disp->name;
						$contact=$event_disp->phone;
						$mail=$event_disp->email;
					}

					echo '<tr><td>'.$orderid.'</td>
					<td><a href="index.php?option=com_booking_management&view=booking_managements&layout=orderdetail&id='.$orderid.'&qts='.$quote_status.'&userid='.$userid.'">'.$cart.'</a></td>
					<td>'.$booked_time.'</td><td>'.$quote_status.'</td>
					<td><a href="index.php?option=com_booking_management&view=booking_managements&layout=orderdetail&id='.$orderid.'&qts='.$quote_status.'&userid='.$userid.'">'.$username.'</a></td><td>'.$contact.'</td>
					<td>'.$mail.'</td><td>'.$trip_date.'</td><td>'.$transport.'</td>
					<td>'.$keeper_information.'</td>
					<td><a href="index.php?option=com_booking_management&view=booking_managements&layout=orderdetail&id='.$orderid.'&qts='.$quote_status.'&userid='.$userid.'">VIEW</a></td>
			    	<td><form action="" method="post" name="delorder"> <input type="button" value="'.$orderid.'" id="'.$useid.'" class="delete_order"> </form></td></tr>';
			    }

 		}
		 echo "</table>";

exit;
	}

	public function filters3(){
		$db=JFactory::getDbo();
		$name = JRequest::getvar('name','');
		$numb = JRequest::getvar('cnum','');
		$enddate = JRequest::getvar('enddate','');
    	$satrtdate = JRequest::getvar('satrtdate','');
		$addsec='00';
		$newstartDate = date("Y-m-d", strtotime($satrtdate));
		$newsendDate = date("Y-m-d", strtotime($enddate));
		$frmdatetime =  $newstartDate;
		$upto_datetime =  $newsendDate;

		$delorder = JRequest::getvar('delorder','');
		if($delorder!=''){
		   $del="DELETE FROM `#__fixed_trip_orders` WHERE id=$delorder";
		   $db->setQuery($del);
		   $result = $db->query();
		}


		$sql="SELECT * FROM `#__fixed_trip_orders` WHERE id!='' AND paymethod!=''";
		$sqlc="SELECT COUNT(id) FROM `#__fixed_trip_orders` WHERE id!='' AND paymethod!=''";
		if($satrtdate) {
			$sql.=" AND cart_date BETWEEN '$frmdatetime' AND '$upto_datetime' ";
			$sqlc.=" AND cart_date BETWEEN '$frmdatetime' AND '$upto_datetime'";
		}
		if($numb) {
			$sql.=" AND uid IN (SELECT id FROM `#__users` WHERE phone LIKE '%$numb%')";
			$sqlc.=" AND uid IN (SELECT id FROM `#__users` WHERE phone LIKE '%$numb%')";
		}
		if($name) {
			$sql.=" AND uid IN (SELECT id FROM `#__users` WHERE name LIKE '%$name%')";
			$sqlc.=" AND uid IN (SELECT id FROM `#__users` WHERE name LIKE '%$name%')";
		}
		$sql.=" ORDER BY id DESC";
		$sqlc.=" ORDER BY id DESC";
		$db->setQuery($sql);
		$event_detail=$db->loadObjectList();
		$db->setQuery($sqlc);
		$resc = $event_details=$db->loadResult();
		if($resc == '0'){
			echo "no result";
		} else {
			echo "<h1>Fixed Trip</h1>";
			echo '<table border="0px">';
			echo '<tr><th>Order ID</th><th>Booked Date</th>
			<th>Booked Time</th><th>Customer id</th>
			<th>Customer Name</th><th>Contact Num</th>
			<th>Email Id</th><th>Name of Trip</th>
			<th>Date of Journey</th><th>No of Persons</th>
			<th>No of rooms</th><th>Stay</th><th>Transport</th>
			<th>Keeper</th><th>Cost</th><th>Payment Status</th><th>Detail Link</th><th>Delete Order</th></tr>';
			foreach($event_detail as $event_disp) {
				$orderid=$event_disp->id;
				$useid=$event_disp->uid;

				$cart=$event_disp->cart_date;
				$time = strtotime($cart);
				$cart = date('d-m-Y',$time);
				$carts = date('H:i:s a',$time);

				$title=$event_disp->pack_title;
				$date=$event_disp->pack_date;
				$no_of_persons=$event_disp->no_of_people;
				$no_of_rooms=$event_disp->no_of_room;
				$hotel=$event_disp->hotel;

				$transport=$event_disp->transport;
				$keeper=$event_disp->keeper;
				$prices=$event_disp->price_pr;
				$payment_status=$event_disp->payment_status;
				$sql="SELECT * FROM `#__users` WHERE id='$useid'";
				$db->setQuery($sql);
				$events_detail=$db->loadObjectList();
				foreach($events_detail as $event_disp) {
					$userid=$event_disp->id;
					$username=$event_disp->name;
					$contact=$event_disp->phone;
					$mail=$event_disp->email;
					echo '<tr><td>'.$orderid.'</td><td><a href="index.php?option=com_booking_management&view=booking_managements&layout=editf&id='.$orderid.'">'.$cart.'</a></td><td>'.$carts.'</td><td>'.$userid.'</td>
					<td><a href="index.php?option=com_booking_management&view=booking_managements&layout=editf&id='.$orderid.'">'.$username.'</a></td><td>'.$contact.'</td>
					<td>'.$mail.'</td><td>'.$title.'</td><td>'.$date.'</td>
					<td>'.$no_of_persons.'</td><td>'.$no_of_rooms.'</td><td>'.$hotel.'</td><td>'.$transport.'</td><td>'.$keeper.'</td>
					<td>'.$prices.'</td><td>'.$payment_status.'</td>
					<td><a href="index.php?option=com_booking_management&view=booking_managements&layout=editf&id='.$orderid.'">VIEW</a></td>
				    <td><form action="" method="post" name="fdelorder"> <input type="button" value="'.$orderid.'" class="delete_forder"> </form></td></tr>';
				}
	   }
		 echo "</table>";
	 }
exit;
	}
	public function fixed_order_update() {
		$db=JFactory::getDbo();
		$orderid = JRequest::getvar('orderid','');
		$flight_amount = JRequest::getvar('flight_amount','');
		$price_of_hotel = JRequest::getvar('cost_of_hotel','');
		$cost_of_activities = JRequest::getvar('cost_of_activities','');
		$cost_of_transport = JRequest::getvar('cost_of_transport','');
		$cost_of_Keeper = JRequest::getvar('cost_of_keeper','');
		$cost_of_booking_Fee = JRequest::getvar('cost_of_booking_fee','');
		$cost_of_insurance = JRequest::getvar('cost_of_insurance','');
		$total_cost_tax_free = JRequest::getvar('total_price','');
		$gst = JRequest::getvar('gst','');
		$pay_status=JRequest::getvar('pay_status','');
		$final_cost=JRequest::getvar('total_price_gst','');
		$first_installement = JRequest::getvar('first_installment','');
		$last_day_for_first_installement = JRequest::getvar('first_installment_date','');
		$final_installement = JRequest::getvar('final_installment','');
		$last_day_for_final_installement = JRequest::getvar('final_installment_date','');

		$last_day_for_first_installement = date("Y-m-d", strtotime($last_day_for_first_installement));
		$last_day_for_final_installement = date("Y-m-d", strtotime($last_day_for_final_installement));

		$lastfinalpaytime = JRequest::getvar('lastfinalpaytime','');
		$lastfirstpaytime = JRequest::getvar('lastfirstpaytime','');

		$last_day_for_first_installement = date('Y-m-d H:i:s', strtotime("$last_day_for_first_installement $lastfirstpaytime"));
		$last_day_for_final_installement = date('Y-m-d H:i:s', strtotime("$last_day_for_final_installement $lastfinalpaytime"));
echo $pay_status;
if($pay_status=='first_installment') {
    $pymnt_status= 'first_installment';
} else if($pay_status=='final_installment') {
   $pymnt_status= $pay_status;
} else {
		$pymnt_status = "intialized";
}
		$trip_status = "quotation";


		$object2 = new stdClass();
	    $object2->id=$orderid;
		$object2->flight_price=$flight_amount;

		$object2->cost_of_activities=$cost_of_activities;
		$object2->cost_of_transport=$cost_of_transport;
		$object2->cost_of_keeper=$cost_of_Keeper;
		$object2->cost_of_booking_Fee=$cost_of_booking_Fee;
		$object2->cost_of_insurance=$cost_of_insurance;
		$object2->payment_status=$pymnt_status;
		$object2->trip_status=$trip_status;
		$object2->total_price=$total_cost_tax_free;
		$object2->gst=$gst;
		$object2->mail_count=0;
		$object2->total_price_gst=$final_cost;
		$object2->first_installment=$first_installement;
		$object2->first_inst_date=$last_day_for_first_installement;
		$object2->final_installment=$final_installement;
		$object2->final_inst_date=$last_day_for_final_installement;
		$result = JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');


		 $sql="SELECT uid FROM `#__fixed_trip_orders` WHERE id='$orderid'";
			 	$db->setQuery($sql);
			    $uid=$db->loadResult();

		 $sql="SELECT * FROM `#__users` WHERE id='$uid'";
			 	$db->setQuery($sql);
			    $events_detail=$db->loadObjectList();
				foreach($events_detail as $event_disp) {
					$userid=$event_disp->id;
					$username=$event_disp->name;
					$contact=$event_disp->phone;
					$mail=$event_disp->email;
				}
		$from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH FINAL QUOTATION UPDATE NOTIFICATION ';
			$message = '<p>Dear '.$username.'</p><p>You are one step closer to get your trip booked with us. You will find the final quote in your profile on our website. Have a look and book your trip! </p><p>A bientôt,</p><p>FRANCEBYFRENCH</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);

$message = 'Dear '.$username.',
You are one step closer to get your trip booked with us. You will find the final quote in your profile on our website.
Have a look and book your trip!
A bientôt,
FRANCEBYFRENCH';
            $data = array(
                   'sender' => 'FBFMSG',
                   'route' => '4',
                   'mobiles' => $contact,
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



		exit;
	}

	public function fixed_order_firstupdate() {
		$db=JFactory::getDbo();
		$orderid = JRequest::getvar('orderid','');
		$first_installment__payed_date = JRequest::getvar('first_installment__payed_date','');
		$first_installment__payed_time = JRequest::getvar('first_installment__payed_time','');
		$first_installment_txnid = JRequest::getvar('first_installment_txnid','');

		$first_installment__payed_date = date('Y-m-d H:i:s', strtotime("$first_installment__payed_date $first_installment__payed_time"));

		$object2 = new stdClass();
	    $object2->id=$orderid;
		$object2->payment_status="first_installment";
		$object2->pay_date1=$first_installment__payed_date;
		$object2->txnid=$first_installment_txnid;
		$result = JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');
		$sql="SELECT uid FROM `#__fixed_trip_orders` WHERE id='$orderid'";
			 	$db->setQuery($sql);
			    $uid=$db->loadResult();

		 $sql="SELECT * FROM `#__users` WHERE id='$uid'";
			 	$db->setQuery($sql);
			    $events_detail=$db->loadObjectList();
				foreach($events_detail as $event_disp) {
					$userid=$event_disp->id;
					$username=$event_disp->name;
					$contact=$event_disp->phone;
					$mail=$event_disp->email;
				}
		$from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH FIRST INSTALMENT RECEPTION CONFIRMATION ';
			$message = '<p>Dear '.$username.'</p><p> Thank you for your payment. Please keep in mind that the payment for the outstanding balance is due 45 days prior to your departure date.</p>
			<p>Your welcome gift box is in her way.</p>
			<p>We look forward to welcoming you in France</p>
			<p>A bientôt,<br>
FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
		exit;
	}
	public function fixed_order_finalupdate() {
		$db=JFactory::getDbo();
		$orderid = JRequest::getvar('orderid','');
		$final_installment__payed_date = JRequest::getvar('final_installment__payed_date','');
		$final_installment__payed_time = JRequest::getvar('final_installment__payed_time','');
		$final_installment_txnid = JRequest::getvar('final_installment_txnid','');

		$final_installment__payed_date = date('Y-m-d H:i:s', strtotime("$final_installment__payed_date $final_installment__payed_time"));

		$object2 = new stdClass();
	    $object2->id=$orderid;
		$object2->payment_status="final_installment";
		$object2->pay_date2=$final_installment__payed_date;
		$object2->txnid2=$final_installment_txnid;
		$result = JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');
		$sql="SELECT uid FROM `#__fixed_trip_orders` WHERE id='$orderid'";
			 	$db->setQuery($sql);
			    $uid=$db->loadResult();

		 $sql="SELECT * FROM `#__users` WHERE id='$uid'";
			 	$db->setQuery($sql);
			    $events_detail=$db->loadObjectList();
				foreach($events_detail as $event_disp) {
					$userid=$event_disp->id;
					$username=$event_disp->name;
					$contact=$event_disp->phone;
					$mail=$event_disp->email;
				}
		$from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH FINAL INSTALMENT RECEPTION CONFIRMATION';
			$message = '<p>>Dear '.$username.'</p><p>Thank you for your last payment and we are thrilled to confirm that your trip is booked! We will reach out to you very soon to share all the details</p>
            <p>A bientôt,<br>FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
		exit;
	}

	public function cust_order_firstupdate() {
		$db=JFactory::getDbo();
		$orderid = JRequest::getvar('orderid','');
		$first_installment__payed_date = JRequest::getvar('first_installment__payed_date','');
		$first_installment__payed_time = JRequest::getvar('first_installment__payed_time','');
		$first_installment_txnid = JRequest::getvar('first_installment_txnid','');

		$first_installment__payed_date = date('Y-m-d H:i:s', strtotime("$first_installment__payed_date $first_installment__payed_time"));

		$object2 = new stdClass();
	    $object2->id=$orderid;
		$object2->payment_status="first_installment";
		$object2->pay_date1=$first_installment__payed_date;
		$object2->txnid=$first_installment_txnid;
		$result = JFactory::getDbo()->updateObject('#__customized_order', $object2, 'id');
		$sql="SELECT uid FROM `#__customized_order` WHERE id='$orderid'";
			 	$db->setQuery($sql);
			    $uid=$db->loadResult();

		 $sql="SELECT * FROM `#__users` WHERE id='$uid'";
			 	$db->setQuery($sql);
			    $events_detail=$db->loadObjectList();
				foreach($events_detail as $event_disp) {
					$userid=$event_disp->id;
					$username=$event_disp->name;
					$contact=$event_disp->phone;
					$mail=$event_disp->email;
				}
		$from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH FIRST INSTALMENT RECEPTION CONFIRMATION ';
			$message = '<p>Dear '.$username.'</p><p> Thank you for your payment. Please keep in mind that the payment for the outstanding balance is due 45 days prior to your departure date.</p>
			<p>Your welcome gift box is in her way.</p>
			<p>We look forward to welcoming you in France</p>
			<p>A bientôt,<br>
FranceByFrench</p>';
$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
		exit;
	}
	public function cust_order_finalupdate() {
		$db=JFactory::getDbo();
		$orderid = JRequest::getvar('orderid','');
		$final_installment__payed_date = JRequest::getvar('final_installment__payed_date','');
		$final_installment__payed_time = JRequest::getvar('final_installment__payed_time','');
		$final_installment_txnid = JRequest::getvar('final_installment_txnid','');

		$final_installment__payed_date = date('Y-m-d H:i:s', strtotime("$final_installment__payed_date $final_installment__payed_time"));

		$object2 = new stdClass();
	    $object2->id=$orderid;
		$object2->payment_status="final_installment";
		$object2->pay_date2=$final_installment__payed_date;
		$object2->txnid2=$final_installment_txnid;
		$result = JFactory::getDbo()->updateObject('#__customized_order', $object2, 'id');
		$sql="SELECT uid FROM `#__customized_order` WHERE id='$orderid'";
			 	$db->setQuery($sql);
			    $uid=$db->loadResult();

		 $sql="SELECT * FROM `#__users` WHERE id='$uid'";
			 	$db->setQuery($sql);
			    $events_detail=$db->loadObjectList();
				foreach($events_detail as $event_disp) {
					$userid=$event_disp->id;
					$username=$event_disp->name;
					$contact=$event_disp->phone;
					$mail=$event_disp->email;
				}
		$from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH FINAL INSTALMENT RECEPTION CONFIRMATION';
			$message = '<p>>Dear '.$username.'</p><p>Thank you for your last payment and we are thrilled to confirm that your trip is booked! We will reach out to you very soon to share all the details</p>
            <p>A bientôt,<br>FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
		exit;
	}

	public function semi_order_firstupdate() {
		$db=JFactory::getDbo();
		$orderid = JRequest::getvar('orderid','');
		$first_installment__payed_date = JRequest::getvar('first_installment__payed_date','');
		$first_installment__payed_time = JRequest::getvar('first_installment__payed_time','');
		$first_installment_txnid = JRequest::getvar('first_installment_txnid','');

		$first_installment__payed_date = date('Y-m-d H:i:s', strtotime("$first_installment__payed_date $first_installment__payed_time"));

		$object2 = new stdClass();
	    $object2->id=$orderid;
		$object2->payment_status="first_installment";
		$object2->pay_date1=$first_installment__payed_date;
		$object2->txnid=$first_installment_txnid;
		$result = JFactory::getDbo()->updateObject('#__semicustomized_order', $object2, 'id');
		$sql="SELECT uid FROM `#__semicustomized_order` WHERE id='$orderid'";
			 	$db->setQuery($sql);
			    $uid=$db->loadResult();

		 $sql="SELECT * FROM `#__users` WHERE id='$uid'";
			 	$db->setQuery($sql);
			    $events_detail=$db->loadObjectList();
				foreach($events_detail as $event_disp) {
					$userid=$event_disp->id;
					$username=$event_disp->name;
					$contact=$event_disp->phone;
					$mail=$event_disp->email;
				}
		$from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH FIRST INSTALMENT RECEPTION CONFIRMATION ';
			$message = '<p>Dear '.$username.'</p><p> Thank you for your payment. Please keep in mind that the payment for the outstanding balance is due 45 days prior to your departure date.</p>
			<p>Your welcome gift box is in her way.</p>
			<p>We look forward to welcoming you in France</p>
			<p>A bientôt,<br>
FranceByFrench</p>';
$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
		exit;
	}
	public function semi_order_finalupdate() {
		$db=JFactory::getDbo();
		$orderid = JRequest::getvar('orderid','');
		$final_installment__payed_date = JRequest::getvar('final_installment__payed_date','');
		$final_installment__payed_time = JRequest::getvar('final_installment__payed_time','');
		$final_installment_txnid = JRequest::getvar('final_installment_txnid','');

		$final_installment__payed_date = date('Y-m-d H:i:s', strtotime("$final_installment__payed_date $final_installment__payed_time"));

		$object2 = new stdClass();
	    $object2->id=$orderid;
		$object2->payment_status="final_installment";
		$object2->pay_date2=$final_installment__payed_date;
		$object2->txnid2=$final_installment_txnid;
		$result = JFactory::getDbo()->updateObject('#__semicustomized_order', $object2, 'id');
		$sql="SELECT uid FROM `#__semicustomized_order` WHERE id='$orderid'";
			 	$db->setQuery($sql);
			    $uid=$db->loadResult();

		 $sql="SELECT * FROM `#__users` WHERE id='$uid'";
			 	$db->setQuery($sql);
			    $events_detail=$db->loadObjectList();
				foreach($events_detail as $event_disp) {
					$userid=$event_disp->id;
					$username=$event_disp->name;
					$contact=$event_disp->phone;
					$mail=$event_disp->email;
				}
		$from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH FINAL INSTALMENT RECEPTION CONFIRMATION';
			$message = '<p>>Dear '.$username.'</p><p>Thank you for your last payment and we are thrilled to confirm that your trip is booked! We will reach out to you very soon to share all the details</p>
            <p>A bientôt,<br>FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);

		exit;
	}

	public function AdminMsgto() {
		$db=JFactory::getDbo();

		$order_id = JRequest::getvar('order_id','');
		$admin_msg = JRequest::getvar('admin_msg','');

		$object2 = new stdClass();
	    $object2->id=$order_id;
		$object2->admin_msg=$admin_msg;
		$result = JFactory::getDbo()->updateObject('#__customized_order', $object2, 'id');

		exit;
	}
	public function AdminMsgto1() {
		$db=JFactory::getDbo();

		$order_id = JRequest::getvar('order_id','');
		$admin_msg = JRequest::getvar('admin_msg','');

		$object2 = new stdClass();
	    $object2->id=$order_id;
		$object2->admin_msg=$admin_msg;
		$result = JFactory::getDbo()->updateObject('#__customized_order', $object2, 'id');

		exit;
	}
	public function AdminMsgto2() {
		$db=JFactory::getDbo();

		$order_id = JRequest::getvar('order_id','');
		$admin_msg = JRequest::getvar('admin_msg','');

		$object2 = new stdClass();
	    $object2->id=$order_id;
		$object2->admin_msg=$admin_msg;
		$result = JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');

		exit;
	}
}

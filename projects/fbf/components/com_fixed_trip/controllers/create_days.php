<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_trip
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Create_days list controller class.
 *
 * @since  1.6
 */
class Fixed_tripControllerCreate_days extends Fixed_tripController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional
	 * @param   array   $config  Configuration array for model. Optional
	 *
	 * @return object	The model
	 *
	 * @since	1.6
	 */
	public function &getModel($name = 'Create_days', $prefix = 'Fixed_tripModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
	public function saveSess() {
		$pageid = JRequest::getVar('pageid');
		$date = JRequest::getVar('date');
		$no_of_people = JRequest::getVar('people');
		$no_of_rooms = JRequest::getVar('room');
		$prices = JRequest::getVar('price');
		$type = JRequest::getVar('type');
		$seat = JRequest::getVar('seat');

		$_SESSION['sesstpageid'] = $pageid;
		$_SESSION['date'] = $date;
		$_SESSION['no_of_people'] = $no_of_people;
		$_SESSION['no_of_rooms'] = $no_of_rooms;
		$_SESSION['prices'] = $prices;
		$_SESSION['type'] = $type;
		$_SESSION['seat'] = $seat;
		$_SESSION['trip'] = "fixed_trip";
		exit;
	}
	public function storedata() {
		$user = JRequest::getVar('user');
		$id = JRequest::getVar('id');
		$title = JRequest::getVar('title');
		$date = JRequest::getVar('date');
		$type = JRequest::getVar('type');
		$no_of_people = JRequest::getVar('no_of_people');
		$no_of_room = JRequest::getVar('no_of_room');
		$price = JRequest::getVar('price');
		$cost_hotel = JRequest::getVar('cost_hotel');
		$cost_activites = JRequest::getVar('cost_activites');
		$cost_transport = JRequest::getVar('cost_transport');
		$cost_keeper = JRequest::getVar('cost_keeper');
		$cost_booking_fee = JRequest::getVar('cost_booking_fee');
		$cost_insurance = JRequest::getVar('cost_insurance');
		$extracosti = JRequest::getVar('extracosti');
		$extracostii = JRequest::getVar('extracostii');
		$pdfplanning = JRequest::getVar('pdfplanning');
		$keeper = JRequest::getVar('keeper');
		$transport = JRequest::getVar('transport');
		$hotel = JRequest::getVar('hotel');
		$planning = JRequest::getVar('planning');
		$no_of_days = JRequest::getVar('no_of_days');
        date_default_timezone_set("Asia/Kolkata");
		$db=JFactory::getDBO();
		$user = JFactory::getUser();
		$user_id=$user->id;
		$uname=$user->name;
		$mobile=$user->phone;
		$email=$user->email;
        $cost_hotel=($cost_hotel*$no_of_room)/$no_of_people;

        $count_uorder="SELECT COUNT(uid) FROM `#__fixed_trip_orders` WHERE uid=$user_id";
        $db->setQuery($count_uorder);
        $count=$db->loadResult();
       
		$crrdate = date('Y-m-d H:i:s');
		$object = new stdClass();
		$object->id = '';
		$object->uid = $user_id;
		$object->uname =$uname;
		$object->umobile =$mobile;
		$object->uemail =$email;
		$object->pack_id =$id;
		$object->pack_title =$title;
		$object->pack_date =$date;
		$object->pack_type =$type;
		$object->no_of_people = $no_of_people;
		$object->no_of_room = $no_of_room;
		$object->price_pr = $price;
		$object->cost_of_hotel = $cost_hotel;
		$object->cost_of_activities = $cost_activites;
		$object->cost_of_transport = $cost_transport;
		$object->cost_of_keeper = $cost_keeper;
		$object->cost_of_booking_fee = $cost_booking_fee;
		$object->cost_of_insurance = $cost_insurance;
		$object->extra_cost_i = $extracosti;
		$object->extra_cost_ii = $extracostii;
		$object->pdf = $pdfplanning;
		$object->keeper = $keeper;
		$object->transport = $transport;
		$object->hotel = $hotel;
		$object->planning = $planning;
		$object->no_of_days = $no_of_days;
		$object->payment_status = "intialized";
		$db->insertObject('#__fixed_trip_orders', $object);

	 	$last_inserted_id =$db->insertid();
	echo 	$last_inserted_id;
	
        
		exit;
	}
	public function deletelast(){
	    $db = JFactory::getDbo();
	    $user = JFactory::getUser();
	    $lastinsertedid = JRequest::getvar('lastinsertedid','');
	    
	    $query = $db->getQuery(true);
        $query->delete($db->quoteName('#__fixed_trip_orders'));
        $query->where('`id` IN ('.$lastinsertedid.')');

        $db->setQuery($query);

        $result = $db->execute();
	    exit;
	}

	public function paymentMessage() {
	$db = JFactory::getDbo();
	$user = JFactory::getUser(); 
	$select_option = JRequest::getvar('selected_option', '');
    $flight_option = JRequest::getvar('flight_option', '');
    
    $paymsg="SELECT * FROM `#__payment_message` WHERE state=1 AND id=3";
    $db->setQuery($paymsg);
    $paymsg=$db->loadObjectList();
    	
    foreach ($paymsg as $paymsg_disp) {
    $flightyesnormalpayment=$paymsg_disp->flightyesnormalpayment;
    $flight_no_normalpayment=$paymsg_disp->flight_no_normalpayment;
    $flight_yes_split_payment=$paymsg_disp->flight_yes_split_payment;
    $flight_no_splitpayment=$paymsg_disp->flight_no_splitpayment;
    $flightyespartipayment=$paymsg_disp->flightyespartipayment;
    $flight_no_parti_payment=$paymsg_disp->flight_no_parti_payment;
    }
    if (($flight_option=='No') && ($select_option=='Normal')) {
        $displaymsg = $flight_no_normalpayment;
    }
    else if (($flight_option!='No') && ($select_option=='Normal')) {
        $displaymsg = $flightyesnormalpayment;
    }
    else if (($flight_option=='No') && ($select_option=='Split')) {
        $displaymsg = $flight_no_splitpayment;
    }
    else if (($flight_option!='No') && ($select_option=='Split')) {
        $displaymsg = $flight_yes_split_payment;
    }
    else if (($flight_option=='No') && ($select_option=='Participative')) {
        $displaymsg = $flight_no_parti_payment;
    }
    else if (($flight_option!='No') && ($select_option=='Participative')) {
        $displaymsg = $flightyespartipayment;
    }
    else
    {
        $displaymsg = "";
    }
        if($displaymsg==''){
     $displaymsg = "<div class='paymethod1 method' id='paymethod1 method'>
     <span><img src='images/p1.png'></span></br>
     <span><img src='images/p2.png'></span></br>
     <span><img src='images/p3.png'></span>
     <span><img src='images/p4.png'></span>
     <span><img src='images/p5.png'></span>
     </div>";
    }
    echo $displaymsg;
	
	    exit;
	}
	public function update() {
	$db = JFactory::getDbo();
	$user = JFactory::getUser(); 
	$lastinsertedid = JRequest::getvar('lastinsertedid', '');
	$paymethod = JRequest::getvar('paymethod', '');
    $flight_option = JRequest::getvar('flight_option', '');
    $place = JRequest::getvar('place', '');
    $object_all = new stdClass();
	$object_all->id=$lastinsertedid;
	$object_all->flight= $flight_option;
	$object_all->paymethod= $paymethod;
	$object_all->place_of_dept= $place;
	//JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object_all, 'id');
	echo 'successs';
	/*$route = "index.php?option=com_users&view=profile";
    $message = "We Received the Quotation. will update you soon";
    $this->setRedirect(JRoute::_($route), $message);*/
	exit;
    }
    
}

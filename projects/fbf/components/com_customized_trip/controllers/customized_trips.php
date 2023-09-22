<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Customized_trip
 * @author     vikram <vikram.zinavo@gmail.com>
 * @copyright  2018 vikram
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Customized_trips list controller class.
 *
 * @since  1.6
 */
class Customized_tripControllerCustomized_trips extends Customized_tripController
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
	public function &getModel($name = 'Customized_trips', $prefix = 'Customized_tripModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

	public function saveinSession()
	{
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$user_id=$user->id;
    $no_days = JRequest::getvar('no_days', '');
    $no_people = JRequest::getvar('no_people', '');
    $budget = JRequest::getvar('budget', '');
    $no_room = JRequest::getvar('no_room', '');
    $transport = JRequest::getvar('transport', '');
    $stay = JRequest::getvar('stay', '');
    $flight = JRequest::getvar('flight', '');
    $keeper = JRequest::getvar('keeper', '');
    $write_us = JRequest::getvar('write_us', '');
    $placeofdeparture = JRequest::getvar('placeofdeparture', '');
    $dateofdeparture = JRequest::getvar('dateofdeparture', '');

	$_SESSION['no_days'] = $no_days;
	$_SESSION['budget'] = $budget;
	$_SESSION['no_room'] = $no_room;
	$_SESSION['no_people'] = $no_people;
	$_SESSION['transport'] = $transport;
	$_SESSION['stay'] = $stay;
	$_SESSION['flight'] = $flight;
	$_SESSION['keeper'] = $keeper;
	$_SESSION['write_us'] = $write_us;
	$_SESSION['placeofdeparture'] = $placeofdeparture;
	$_SESSION['dateofdeparture'] = $dateofdeparture;
	$_SESSION['trip'] = 'customized_trip';

	exit;
	}
	public function saveinDb()
	{
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$user_id=$user->id;
	date_default_timezone_set("Asia/Kolkata");
    $no_days = JRequest::getvar('no_days', '');
    $no_people = JRequest::getvar('no_people', '');
    $budget = JRequest::getvar('budget', '');
    $no_room = JRequest::getvar('no_room', '');
    $transport = JRequest::getvar('transport', '');
    $stay = JRequest::getvar('stay', '');
    $flight = JRequest::getvar('flight', '');
    $keeper = JRequest::getvar('keeper', '');
    $write_us = JRequest::getvar('write_us', '');
    $placeofdeparture = JRequest::getvar('placeofdeparture', '');
    $dateofdeparture = JRequest::getvar('dateofdeparture', '');

    	echo '<form action="#" method="POST" id="payoption">
    	            <label>Payment Solution</label>
				 <select id="paymethod" name="paymethod">
                      <option value=""></option>
                      <option value="Normal">Normal</option>
                      <option value="Split">Split</option>
                      <option value="Participative">Participative</option>
                  </select>
                        <input type="hidden" value="'.$no_days.'" id="no_days" name="no_days">
						<input type="hidden" value="'.$no_people.'" id="no_people" name="no_people">
						<input type="hidden" value="'.$budget.'" id="budget" name="budget">
						<input type="hidden" value="'.$no_room.'" id="no_room" name="no_room">
						<input type="hidden" value="'.$transport.'" id="transport" name="transport">
						<input type="hidden" value="'.$stay.'" id="stay" name="stay">
						<input type="hidden" value="'.$flight.'" id="flight_ticket" name="flight_ticket">
						<input type="hidden" value="'.$write_us.'" id="write_us" name="write_us">
						<input type="hidden" value="'.$keeper.'" id="keeper" name="keeper">
						<input type="hidden" value="'.$placeofdeparture.'" id="placeofdeparture" name="placeofdeparture">
						<input type="hidden" value="'.$dateofdeparture.'" id="dateofdeparture" name="dateofdeparture">
						<input type="submit" value="Submit" id="request_quote">
                       <input type="hidden" value="com_users" name="option">
                       <input type="hidden" value="user.updateQuote" name="task">
                   </form>';
    exit;
	}

	public function paymentMessage() {
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$select_option = JRequest::getvar('selected_option', '');
    $flight_option = JRequest::getvar('flight_option', '');
    $triptypez = JRequest::getvar('triptypez', '');
    
    if($triptypez=='semi') {
        $displayid=2;
    } else {
        $displayid=1;
    }
    
    $paymsg="SELECT * FROM `#__payment_message` WHERE state=1 AND id=$displayid";
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
    echo $displaymsg = "<div class='paymethod1 method' id='paymethod1 method'>
     <span><img src='images/p1.png'></span></br>
     <span><img src='images/p2.png'></span></br>
     <span><img src='images/p3.png'></span>
     <span><img src='images/p4.png'></span>
     <span><img src='images/p5.png'></span>
     </div>";

    } else {
        echo $displaymsg;

    }

	    exit;
	}

	public function minBudget() {
        $db = JFactory::getDbo();
        $noofdays = JRequest::getvar('noofdays', '');
         $no_people = JRequest::getvar('no_people', '');

    $budmsg="SELECT * FROM `#__customized_trip_minbudget` WHERE state=1";
    $db->setQuery($budmsg);
    $getbudget=$db->loadObjectList();

    foreach ($getbudget as $getbudget_disp) {
    	$id=$getbudget_disp->id;
    	$d1=$getbudget_disp->d1;
    	$d2=$getbudget_disp->d2;
    	$d3=$getbudget_disp->d3;
    	$d4=$getbudget_disp->d4;
    	$d5=$getbudget_disp->d5;
    	$d6=$getbudget_disp->d6;
    	$d7=$getbudget_disp->d7;
    	$d8=$getbudget_disp->d8;
    	$d9=$getbudget_disp->d9;
    	$d10=$getbudget_disp->d10;
    	$d11=$getbudget_disp->d11;
    	$d12=$getbudget_disp->d12;
    	$d13=$getbudget_disp->d13;
    	$d14=$getbudget_disp->d14;
    	$d15=$getbudget_disp->d15;
    	$d16=$getbudget_disp->d16;
    	$d17=$getbudget_disp->d17;
    	$d18=$getbudget_disp->d18;
    	$d19=$getbudget_disp->d19;
    	$d20=$getbudget_disp->d20;
    }
 //  echo 'Min Budget - ';
    if($noofdays==1){
    	echo $d1 * $no_people;
    } else if($noofdays==2){
    	echo $d2 * $no_people;
    } else if($noofdays==3){
    	echo $d3 * $no_people;
    } else if($noofdays==4){
    	echo $d4 * $no_people;
    } else if($noofdays==5){
    	echo $d5 * $no_people;
    } else if($noofdays==6){
    	echo $d6 * $no_people;
    } else if($noofdays==7) {
    	echo $d7 * $no_people;
    } else if($noofdays==8) {
    	echo $d8 * $no_people;
    } else if($noofdays==9) {
    	echo $d9 * $no_people;
    } else if($noofdays==10){
    	echo $d10 * $no_people;
    } else if($noofdays==11){
    	echo $d11 * $no_people;
    } else if($noofdays==12){
    	echo $d12 * $no_people;
    } else if($noofdays==13){
    	echo $d13 * $no_people;
    } else if($noofdays==14){
    	echo $d14 * $no_people;
    } else if($noofdays==15){
    	echo $d15 * $no_people;
    } else if($noofdays==16){
    	echo $d16 * $no_people;
    } else if($noofdays==17){
    	echo $d17 * $no_people;
    } else if($noofdays==18){
    	echo $d18 * $no_people;
    } else if($noofdays==19){
    	echo $d19 * $no_people;
    } else if($noofdays==20){
    	echo $d20 * $no_people;
    }

		exit;
	}
}

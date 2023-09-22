<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('UsersController', JPATH_COMPONENT . '/controller.php');

/**
 * Registration controller class for Users.
 *
 * @since  1.6
 */
class UsersControllerUser extends UsersController
{
	/**
	 * Method to log in a user.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function login()
	{
		$this->checkToken('post');

		$app   = JFactory::getApplication();
		$input = $app->input->getInputForRequestMethod();

		// Populate the data array:
		$data = array();

		$data['return']    = base64_decode($input->get('return', '', 'BASE64'));
		$data['username']  = $input->get('username', '', 'USERNAME');
		$data['password']  = $input->get('password', '', 'RAW');
		$data['secretkey'] = $input->get('secretkey', '', 'RAW');

		// Check for a simple menu item id
		if (is_numeric($data['return']))
		{
			if (JLanguageMultilang::isEnabled())
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery(true)
					->select('language')
					->from($db->quoteName('#__menu'))
					->where('client_id = 0')
					->where('id =' . $data['return']);

				$db->setQuery($query);

				try
				{
					$language = $db->loadResult();
				}
				catch (RuntimeException $e)
				{
					return;
				}

				if ($language !== '*')
				{
					$lang = '&lang=' . $language;
				}
				else
				{
					$lang = '';
				}
			}
			else
			{
				$lang = '';
			}

			$data['return'] = 'index.php?Itemid=' . $data['return'] . $lang;
		}
		else
		{
			// Don't redirect to an external URL.
			if (!JUri::isInternal($data['return']))
			{
				$data['return'] = '';
			}
		}

		// Set the return URL if empty.
		if (empty($data['return']))
		{
			$data['return'] = 'index.php?option=com_users&view=profile';
		}

		// Set the return URL in the user state to allow modification by plugins
		$app->setUserState('users.login.form.return', $data['return']);

		// Get the log in options.
		$options = array();
		$options['remember'] = $this->input->getBool('remember', false);
		$options['return']   = $data['return'];

		// Get the log in credentials.
		$credentials = array();
		$credentials['username']  = $data['username'];
		$credentials['password']  = $data['password'];
		$credentials['secretkey'] = $data['secretkey'];

		// Perform the log in.
		if (true !== $app->login($credentials, $options))
		{
			// Login failed !
			// Clear user name, password and secret key before sending the login form back to the user.
			$data['remember'] = (int) $options['remember'];
			$data['username'] = '';
			$data['password'] = '';
			$data['secretkey'] = '';
			$app->setUserState('users.login.form.data', $data);
			$app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
		}

		// Success
		if ($options['remember'] == true)
		{
			$app->setUserState('rememberLogin', true);
		}

		$app->setUserState('users.login.form.data', array());


		$db = JFactory::getDbo();
		$user = JFactory::getUser();
	 	$user_id = $user->get('id');

	  	$redirect_to = $_SESSION['trip'];

	 	if($user_id==0) {
			$app->redirect(JRoute::_($app->getUserState('users.login.form.return'), false));
		} else if($redirect_to=='customized_trip') {
			$app->redirect(JRoute::_(JURI::root().'index.php?option=com_customized_trip&view=customized_trips&page=booking', false));
	 	} else if($redirect_to=='semicustomized_trip') {
	 		$app->redirect(JRoute::_(JURI::root().'index.php?option=com_semicustomized&view=trip&f=login', false));
	 	} else if($redirect_to=='fixed_trip') {
	 		$app->redirect(JRoute::_(JURI::root().'index.php?option=com_fixed_trip&view=create_trip', false));
	 	} else {
			$app->redirect(JRoute::_(JURI::root(), false));
		}

	}

	/**
	 * Method to log out a user.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function logout()
	{
		$this->checkToken('request');

		$app = JFactory::getApplication();

		// Prepare the logout options.
		$options = array(
			'clientid' => $app->get('shared_session', '0') ? null : 0,
		);

		// Perform the log out.
		$error = $app->logout(null, $options);
		$input = $app->input->getInputForRequestMethod();

		// Check if the log out succeeded.
		if ($error instanceof Exception)
		{
			$app->redirect(JRoute::_('index.php?option=com_users&view=login', false));
		}

		// Get the return URL from the request and validate that it is internal.
		$return = $input->get('return', '', 'BASE64');
		$return = base64_decode($return);

		// Check for a simple menu item id
		if (is_numeric($return))
		{
			if (JLanguageMultilang::isEnabled())
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery(true)
					->select('language')
					->from($db->quoteName('#__menu'))
					->where('client_id = 0')
					->where('id =' . $return);

				$db->setQuery($query);

				try
				{
					$language = $db->loadResult();
				}
				catch (RuntimeException $e)
				{
					return;
				}

				if ($language !== '*')
				{
					$lang = '&lang=' . $language;
				}
				else
				{
					$lang = '';
				}
			}
			else
			{
				$lang = '';
			}

			$return = 'index.php?Itemid=' . $return . $lang;
		}
		else
		{
			// Don't redirect to an external URL.
			if (!JUri::isInternal($return))
			{
				$return = '';
			}
		}

		// In case redirect url is not set, redirect user to homepage
		if (empty($return))
		{
			$return = JUri::root();
		}

		// Redirect the user.
		$app->redirect(JRoute::_($return, false));
	}

	/**
	 * Method to logout directly and redirect to page.
	 *
	 * @return  void
	 *
	 * @since   3.5
	 */
	public function menulogout()
	{
		// Get the ItemID of the page to redirect after logout
		$app    = JFactory::getApplication();
		$itemid = $app->getMenu()->getActive()->params->get('logout');

		// Get the language of the page when multilang is on
		if (JLanguageMultilang::isEnabled())
		{
			if ($itemid)
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery(true)
					->select('language')
					->from($db->quoteName('#__menu'))
					->where('client_id = 0')
					->where('id =' . $itemid);

				$db->setQuery($query);

				try
				{
					$language = $db->loadResult();
				}
				catch (RuntimeException $e)
				{
					return;
				}

				if ($language !== '*')
				{
					$lang = '&lang=' . $language;
				}
				else
				{
					$lang = '';
				}

				// URL to redirect after logout
				$url = 'index.php?Itemid=' . $itemid . $lang;
			}
			else
			{
				// Logout is set to default. Get the home page ItemID
				$lang_code = $app->input->cookie->getString(JApplicationHelper::getHash('language'));
				$item      = $app->getMenu()->getDefault($lang_code);
				$itemid    = $item->id;

				// Redirect to Home page after logout
				$url = 'index.php?Itemid=' . $itemid;
			}
		}
		else
		{
			// URL to redirect after logout, default page if no ItemID is set
			$url = $itemid ? 'index.php?Itemid=' . $itemid : JUri::root();
		}

		// Logout and redirect
		$this->setRedirect('index.php?option=com_users&task=user.logout&' . JSession::getFormToken() . '=1&return=' . base64_encode($url));
	}

	/**
	 * Method to request a username reminder.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	public function remind()
	{
		// Check the request token.
		$this->checkToken('post');

		$app   = JFactory::getApplication();
		$model = $this->getModel('User', 'UsersModel');
		$data  = $this->input->post->get('jform', array(), 'array');

		// Submit the username remind request.
		$return = $model->processRemindRequest($data);

		// Check for a hard error.
		if ($return instanceof Exception)
		{
			// Get the error message to display.
			$message = $app->get('error_reporting')
				? $return->getMessage()
				: JText::_('COM_USERS_REMIND_REQUEST_ERROR');

			// Get the route to the next page.
			$itemid = UsersHelperRoute::getRemindRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route  = 'index.php?option=com_users&view=remind' . $itemid;

			// Go back to the complete form.
			$this->setRedirect(JRoute::_($route, false), $message, 'error');

			return false;
		}

		if ($return === false)
		{
			// Complete failed.
			// Get the route to the next page.
			$itemid = UsersHelperRoute::getRemindRoute();
			$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
			$route  = 'index.php?option=com_users&view=remind' . $itemid;

			// Go back to the complete form.
			$message = JText::sprintf('COM_USERS_REMIND_REQUEST_FAILED', $model->getError());
			$this->setRedirect(JRoute::_($route, false), $message, 'notice');

			return false;
		}

		// Complete succeeded.
		// Get the route to the next page.
		$itemid = UsersHelperRoute::getLoginRoute();
		$itemid = $itemid !== null ? '&Itemid=' . $itemid : '';
		$route	= 'index.php?option=com_users&view=login' . $itemid;

		// Proceed to the login form.
		$message = JText::_('COM_USERS_REMIND_REQUEST_SUCCESS');
		$this->setRedirect(JRoute::_($route, false), $message);

		return true;
	}

	/**
	 * Method to resend a user.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function resend()
	{
		// Check for request forgeries
		// $this->checkToken('post');
	}

public function reg_validation()
	{
		$db = JFactory::getDbo();

		$user = JFactory::getUser();
		$user_id=$user->id;

		$phone = JRequest::getVar('phone','');
		$email = JRequest::getVar('email','');

		$mob_no_count ="SELECT COUNT(id) FROM `#__users` WHERE phone='$phone'";
		$db->setQuery($mob_no_count);
		$mob_no_count_res=$db->loadResult();

		$email_no_count ="SELECT COUNT(id) FROM `#__users` WHERE email='$email'";
		$db->setQuery($email_no_count);
		$email_no_count_res=$db->loadResult();

		if($mob_no_count_res != 0 )
		{
		 	echo "mobile";
		}
		elseif( $email_no_count_res != 0)
		{
			echo "email";
		}
		else
		{
		 	echo "success";
		}
	exit;
	}

public function newuser_reg()
{
	$db = JFactory::getDBO();
	$name=JRequest::getvar('name','');
	$lname=JRequest::getvar('lname','');
	$mobile=JRequest::getvar('phone','');
	$email=JRequest::getvar('email','');
	$password=JRequest::getvar('pword','');

	$md5pwd=md5($password);

	$mob_no_countz ="SELECT COUNT(id) FROM `#__users` WHERE block='0' AND  email='$email' OR phone='$mobile'";
	$db->setQuery($mob_no_countz);
	$user_verification=$db->loadResult();

	if($user_verification==0) {

    $getusercountsql ="SELECT COUNT(id) FROM `#__users` WHERE block='0' AND  ((email='$email') || (username='$mobile'))";
	$db->setQuery($getusercountsql);
	$getusercount=$db->loadResult();

	if($getusercount==0) {
			$date = date('Y-m-d H:i:s');
			$object = new stdClass();
			$object->id = '';
			$object->name = $name;
			$object->lname = $lname;
			$object->username =$mobile;
			$object->email =$email;
			$object->phone =$mobile;
			$object->password = $md5pwd;
			$object->lastvisitDate = '0000-00-00 00:00:00';
			$object->params = '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":"Asia\/Kolkata"}';
			$object->lastResetTime = '0000-00-00 00:00:00';
			$object->resetCount ='0';
			$object->userpass=$password;
			
		    $db->insertObject('#__users', $object);

			$last_inserted_id =$db->insertid();


			$object2 = new stdClass();
			$object2->user_id= $last_inserted_id;
			$object2->group_id='2';
			$db->insertObject('#__user_usergroup_map', $object2);

            /**Mail Function**/
            $from_id = "admin@francebyfrench.com";
			$to =  'paul.martin@francebyfrench.com' ;
			$subject ='FRANCEBYFRENCH NEW REGISTRATION ';
			
			$message = '<p>Dear Team,</p><p>A new customer – '.$name.' '.$lname.' -  '.$mobile.' - has registered on the website. Please have a look.</p><p>Thanks,</p><p>FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
			$headers .= 'Cc: apoorva.uniyal@francebyfrench.com\r\n';
            $headers .= 'Bcc: souria.boumedine@francebyfrench.com\r\n';
            $sentmail = mail($to,$subject,$message,$headers);

			$to1 =  $email;
			$subject1 = 'FRANCEBYFRENCH REGISTRATION CONFIRMATION';
			$message1 = '<p>Dear – '.$name.' -, </p>
			<p>Thank you for your registration with us. We are extremely pleased to help to choose your travel experience and to make your French dreams come true.</p>
			<p>If you have any questions or doubts, please reach out to us!</p>
			<p>A bientôt, </p>
			<p>FranceByFrench </p>';
			$headers1 = "MIME-Version: 1.0" . "\r\n";
			$headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers1 .= 'From:'.$from_id. "\r\n";
			$sentmails = mail($to1,$subject1,$message1,$headers1);
			/******Mail Function ends*******/


	            $credentials = array();
                $credentials['username'] = $mobile;
                $credentials['password'] = $password;
                $login_site = JFactory::getApplication('site');
                $login_site->login($credentials, $options=array());
               echo $redirect_to = $_SESSION['trip'];
	        }
		}
	exit;
    }
    public function updateQuote()
    {
        $db = JFactory::getDBO();
		$user = JFactory::getUser();
		$user_id=$user->id;
        $paymethod=JRequest::getvar('paymethod');
        $flight_ticket=JRequest::getvar('flight_ticket');
	    $no_days = JRequest::getvar('no_days');
	    $no_people = JRequest::getvar('no_people');
	    $budget = JRequest::getvar('budget');
	    $no_room = JRequest::getvar('no_room');
	    $transport = JRequest::getvar('transport');
	    $stay = JRequest::getvar('stay');
	    $keeper = JRequest::getvar('keeper');
	    $write_us = JRequest::getvar('write_us');
	    $placeofdeparture = JRequest::getvar('placeofdeparture');
        $dateofdeparture = JRequest::getvar('dateofdeparture');
	    $dateofdeparture = date("Y-m-d", strtotime($dateofdeparture));
		$currentdate =date('Y-m-d');
	    $object2 = new stdClass();
	    $object2->id='';
		$object2->uid=$user_id;
		$object2->cart_date=$currentdate;
		$object2->no_days= $no_days;
		$object2->no_people= $no_people;
		$object2->budget= $budget;
		$object2->no_room= $no_room;
		$object2->transport= $transport;
		$object2->stay= $stay;
		$object2->flight= $flight_ticket;
		$object2->keeper= $keeper;
		$object2->write_us= $write_us;
		$object2->placeofdeparture= $placeofdeparture;
		$object2->dateofdeparture= $dateofdeparture;
		$object2->payment_status= 'intialized';
		$object2->payment_type= $paymethod;
		$db->insertObject('#__customized_order', $object2);
		$last_inserted_id=$db->insertid();


		$user_data="SELECT * FROM `#__users` where id=$user_id";
		$db->setQuery($user_data);
		$user_result=$db->loadObjectList();
		foreach($user_result as $userdta){
		    $name=$userdta->name;
		    $lname=$userdta->lname;
		    $email=$userdta->email;
		    $mobile=$userdta->phone;
		}
		/**Mail Function**/
            $from_id = "admin@francebyfrench.com";
			$to =  'paul.martin@francebyfrench.com' ;
			$subject ='FRANCEBYFRENCH NEW QUOTATION REQUEST';
			$message = '<p>Dear Team,</p> 
            <p>Congratulation, a trip has just been booked by – '.$name.'  '.$lname.' for Customizd Trip -. Please do follow-up to make his experience great with us.</p>
            <p>Thanks, </p><p>FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
			$headers .= 'Cc: apoorva.uniyal@francebyfrench.com\r\n';
			$headers .= 'Bcc: souria.boumedine@francebyfrench.com\r\n';
            $sentmail = mail($to,$subject,$message,$headers);
            //$adsentmail = mail($toa,$subject,$message,$headers);

			$to1 =  $email;
			$subject1 = 'FRANCEBYFRENCH QUOTATION REQUEST CONFIRMATION ';
			$message1 = '<p>Dear – '.$name.' -, </p><p>You are just one step closer to France as received your quotation request. We are extremely thrilled to have  you and we look forward to welcoming you in France. </p>
            <p>Please reach out to us for any queries; our team will be happy to guide you!</p>
            <p>A bientôt,</p><p>FranceByFrench</p>';
			$headers1 = "MIME-Version: 1.0" . "\r\n";
			$headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers1 .= 'From:'.$from_id. "\r\n";
			$sentmails = mail($to1,$subject1,$message1,$headers1);
			/******Mail Function ends*******/


		$route = "index.php?option=com_users&view=profile&t=1&urlid=$last_inserted_id";
        $messagec = "We received the quotation, will update you soon.";
        $this->setRedirect(JRoute::_($route), $messagec);
    }
    public function fixed_trip() {
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $user_id=$user->id;
        $lastinsertedid = JRequest::getvar('lastinsertedid');
        $paymethod = JRequest::getvar('paymethod');
        $flight_option = JRequest::getvar('flight');
        $place = JRequest::getvar('place');
        $oid = $lastinsertedid;
        date_default_timezone_set("Asia/Kolkata");
        $object_all = new stdClass();
        $object_all->id=$lastinsertedid;
        $object_all->flight= $flight_option;
        $object_all->paymethod= $paymethod;
        $object_all->place_of_dept= $place;
        JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object_all, 'id');
        
        $sqllist="SELECT * FROM `#__fixed_trip_orders` WHERE  id=$oid";
      	$db->setQuery($sqllist);
      	$result=$db->loadObjectList();
        foreach($result as $event_disp) {
            $orderid=$event_disp->id;
            $useid=$event_disp->uid;
            $cart=$event_disp->cart_date;
            $time = strtotime($cart);
            $cart = date('d-m-Y',$time);
            $carts = date('h:i:s a',$time);
            $title=$event_disp->pack_title;
            $pack_id=$event_disp->pack_id;
            $pack_type=$event_disp->pack_type;
            $no_of_people=$event_disp->no_of_people;
            $no_of_room=$event_disp->no_of_room;
            $no_of_days=$event_disp->no_of_days;
            $flight=$event_disp->flight;
            $place_of_dept=$event_disp->place_of_dept;
            $pack_date=$event_disp->pack_date;
            $hotel=$event_disp->hotel;
            $keeper=$event_disp->keeper;
            $transport=$event_disp->transport;
            $paymethod=$event_disp->paymethod;
            $flight_price=$event_disp->flight_price;
            $payment_status=$event_disp->payment_status;
            $price_pr=$event_disp->price_pr;
            $cost_of_hotel=$event_disp->cost_of_hotel;
            $cost_of_transport=$event_disp->cost_of_transport;
            $cost_of_keeper=$event_disp->cost_of_keeper;
            $cost_of_booking_fee=$event_disp->cost_of_booking_fee;
            $cost_of_activities=$event_disp->cost_of_activities;
            $cost_of_insurance=$event_disp->cost_of_insurance;
            $extra_cost_i=$event_disp->extra_cost_i;
            $extra_cost_ii=$event_disp->extra_cost_ii;
            $total_price=$event_disp->total_price;
            $flight_amount=$event_disp->flight_price;
            $first_installment=$event_disp->first_installment;
            $first_inst_date=$event_disp->first_inst_date;
            $final_installment=$event_disp->final_installment;
            $final_inst_date=$event_disp->final_inst_date;
            $total_price_gst=$event_disp->total_price_gst;
            $planning=$event_disp->planning;

            $sqlgst="SELECT * FROM `#__common_price_management` WHERE state=1";
            $db->setQuery($sqlgst);
            $common_price_management_detail=$db->loadObjectList();
            foreach($common_price_management_detail as $pricemgt_disp) {
                $gsti=$pricemgt_disp->gst;
                $first_i=$pricemgt_disp->f_firt_installment;
                $final_i=$pricemgt_disp->f_final_installment;
                $first_inst_date=$pricemgt_disp->f_first_inst_date;
                $final_inst_date=$pricemgt_disp->f_final_inst_date;
            }
            //$cost_of_hotel = ($cost_of_hotel*$no_of_room)*$no_of_people;
            if($flight_amount=='') {
                $flight_amount=0;
            }
        }
        $total_cost_tax_free=$cost_of_hotel+$cost_of_transport+$cost_of_keeper+$cost_of_booking_fee+$cost_of_activities+$cost_of_insurance;
      	//$final_cost = $total_cost_tax_free * $gsti%;
        $gst = ($gsti / 100) * $total_cost_tax_free;
        $final_cost = $total_cost_tax_free + $gst;
        $first_installement = ($first_i / 100) * $final_cost;
        $final_installement = ($final_i / 100) * $final_cost;
       
        $first_inst_date = date("Y-m-d H:i:s", strtotime('+'.$first_inst_date.' hours'));
        $packdate=date('Y-m-d', strtotime($pack_date));                
        $packtime=date('H:i:s');
        $pack_datet = date('Y-m-d H:i:s', strtotime("$packdate $packtime"));
        $final_inst_date=date('Y-m-d H:i:s', strtotime($pack_datet.'-'.$final_inst_date.' days'));
        $currdate=date('Y-m-d H:i:s');
        if($final_inst_date<$currdate){
            $final_inst_date = $first_inst_date;
        } else {
            $final_inst_date=$final_inst_date;
        }
        
        
        $last_day_for_first_installement = $first_inst_date;
        $last_day_for_final_installement = $final_inst_date;
        if($flight_option == 'No') {
      	    $object2 = new stdClass();
            $object2->id=$orderid;
            $object2->cost_of_hotel=$cost_of_hotel;
        	$object2->flight_price=$flight_amount;
        	$object2->trip_status="quotation";
        	$object2->total_price=$total_cost_tax_free;
            $object2->gst=$gst;
        	$object2->total_price_gst=$final_cost;
        	$object2->first_installment=$first_installement;
        	$object2->first_inst_date=$last_day_for_first_installement;
         	$object2->final_installment=$final_installement;
        	$object2->final_inst_date=$last_day_for_final_installement;
            JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');
        } else {
        	$object2 = new stdClass();
            $object2->id=$orderid;
            $object2->total_price=$total_cost_tax_free;
        	$object2->gst=$gst;
        	$object2->total_price_gst=$final_cost;
            $object2->trip_status="quotation";
            JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');
        }
        $user_data="SELECT * FROM `#__users` where id=$user_id";
        $db->setQuery($user_data);
        $user_result=$db->loadObjectList();
        foreach($user_result as $userdta){
            $name=$userdta->name;
        	$lname=$userdta->lname;
        	$email=$userdta->email;
        	$mobile=$userdta->phone;
        }
        if($flight_option!='No') {
            $messagec = "We received the quotation, will update you soon.";
        } else {
            $messagec = "Thanks for booking with us, your payment link is on final quotation page.";
        }
        /**Mail Function**/
    	$from_id = "admin@francebyfrench.com";
		$to =  'paul.martin@francebyfrench.com' ;
		$subject ='FRANCEBYFRENCH NEW QUOTATION REQUEST ';
		$message= '<p>Dear Team,</p> 
        <p>Congratulation, a trip has just been booked by – '.$name.' - '.$mobile.' - for Fixed trip, Order id - '.$orderid.' . Please do follow-up to make his experience great with us.</p>
        <p>Thanks, </p><p>FranceByFrench</p>';
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From:'.$from_id. "\r\n";
		$headers .= 'Cc: apoorva.uniyal@francebyfrench.com\r\n';
		$headers .= 'Bcc: souria.boumedine@francebyfrench.com\r\n';
        $sentmail = mail($to,$subject,$message,$headers);
         
		$to1 =  $email;
		$subject1 = 'FRANCEBYFRENCH QUOTATION REQUEST CONFIRMATION ';
		$message1 = '<p>Dear – '.$name.' -, </p><p>You are just one step closer to France as received your quotation request. We are extremely thrilled to have  you and we look forward to welcoming you in France. </p>
        <p>Please reach out to us for any queries; our team will be happy to guide you!</p>
        <p>A bientôt,</p><p>FranceByFrench</p>';
		$headers1 = "MIME-Version: 1.0" . "\r\n";
		$headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers1 .= 'From:'.$from_id. "\r\n";
		$sentmails = mail($to1,$subject1,$message1,$headers1);
    	/******Mail Function ends*******/
        
        $del="DELETE FROM `#__fixed_trip_orders` WHERE uid=$user_id AND trip_status=''";
	    $db->setQuery($del);
	    $result = $db->query();
        $route = "index.php?option=com_users&view=profile&t=3&urlid=$orderid";
        $this->setRedirect(JRoute::_($route), $messagec);
    }

    public function semi_trip_update()
    {
        $db = JFactory::getDbo();
    	$user = JFactory::getUser();
    	$user_id=$user->id;
    	$lastinsertedid = JRequest::getvar('lastinsertedid');
    	$paymethod = JRequest::getvar('paymethod');
        $flight_option = JRequest::getvar('flight');
        $place = JRequest::getvar('place');
        $insert_ids = $lastinsertedid;
        $ids =explode(",", $insert_ids);

        $sql4="SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND payment_status='finalizebyuser'";
        $db->setQuery($sql4);
        $quote_statusz=$db->loadObjectList();
        
        foreach($quote_statusz as $quote_statusz_res) {
            $quote_status=$quote_statusz_res->quote_status;
        }
        

        if($quote_status==0) {
        	$quote_status=1;
        } else {
        	$quote_status++;
        }
       
      //echo $quote_status;
        

       foreach ($ids as $insterted_ids) {
       	$object_all = new stdClass();
    	$object_all->id=$insterted_ids;
    	$object_all->flight= $flight_option;
    	$object_all->paymethod= $paymethod;
    	$object_all->place_of_dept= $place;
    	$object_all->quote_status= $quote_status;
    	$object_all->payment_status= 'finalizebyuser';
    	JFactory::getDbo()->updateObject('#__semicustomized_order', $object_all, 'id');
       }


        $user_data="SELECT * FROM `#__users` where id='$user_id'";
        $db->setQuery($user_data);
        $user_result=$db->loadObjectList();
        foreach($user_result as $userdta){
            $name=$userdta->name;
        	$lname=$userdta->lname;
        	$email=$userdta->email;
        	$mobile=$userdta->phone;
        }
        

        /**Mail Function**/

    	$from_id = "admin@francebyfrench.com";
		$to =  'paul.martin@francebyfrench.com' ;
		$subject ='FRANCEBYFRENCH NEW QUOTATION REQUEST';
		$message = '<p>Dear Team,</p> 
        <p>Congratulation, a trip has just been booked by – '.$name.' '.$lname.' for Semi Customized Trip-. Please do follow-up to make his experience great with us.</p>
        <p>Thanks, </p><p>FranceByFrench</p>';
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From:'.$from_id. "\r\n";
		$headers .= 'Cc: apoorva.uniyal@francebyfrench.com\r\n';
		$headers .= 'Bcc: souria.boumedine@francebyfrench.com\r\n';
        $sentmail = mail($to,$subject,$message,$headers);
         
		$to1 =  $email;
		$subject1 = 'FRANCEBYFRENCH QUOTATION REQUEST CONFIRMATION ';
		$message1 = '<p>Dear – '.$name.' -, </p><p>You are just one step closer to France as received your quotation request. We are extremely thrilled to have  you and we look forward to welcoming you in France. </p>
        <p>Please reach out to us for any queries; our team will be happy to guide you!</p>
        <p>A bientôt,</p><p>FranceByFrench</p>';
		$headers1 = "MIME-Version: 1.0" . "\r\n";
		$headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers1 .= 'From:'.$from_id. "\r\n";
		$sentmails = mail($to1,$subject1,$message1,$headers1);
    	/******Mail Function ends*******/
		$route = "index.php?option=com_users&view=profile&t=2&urlid=0&qts=$quote_status";
        $messagec = "We received the quotation, will update you soon.";
        $this->setRedirect(JRoute::_($route), $messagec);

    }

    public function contactus()
    {
     $db = JFactory::getDbo();
     $cname=$_REQUEST['user_name'];
     $cmail=$_REQUEST['email'];
     $cmobile=$_REQUEST['mobile'];
     $cmsg=$_REQUEST['msg'];


        $to =  'paul.martin@francebyfrench.com';
        $subject ='Contact Support';
        $message =  '<p class="sendpara">France By French</p>
             <table border="1" style="border-collapse: collapse; width: 40%;">
                                           <tr>
                                               <td>Name</td>
                                               <td>'.$cname.'</td>
                                           </tr>

                                            <tr>
                                               <td>Mobile Number</td>
                                               <td>'.$cmail.'</td>
                                           </tr>
                                            <tr>
                                               <td>Date</td>
                                               <td>'.$cmobile.'</td>
                                           </tr>
                                             <tr>
                                               <td>Mail Id</td>
                                               <td>'.$cmsg.'</td>
                                           </tr>
                                           
             </table>';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $headers .= 'From: <admin@francebyfrench.com >' . "\r\n";
        $headers .= 'Cc: apoorva.uniyal@francebyfrench.com\r\n';
        $headers .= 'Bcc: souria.boumedine@francebyfrench.com\r\n';
        $to1 =  $cmail;
        $subject1 = 'France By French';
        $message1 = 'Thank you for contacting us. We will get back to you as soon as possible';

        $headers1 = "MIME-Version: 1.0" . "\r\n";
        $headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $headers1 .= 'From: <admin@francebyfrench.com >' . "\r\n";

        $sentmails = mail($to1,$subject1,$message1,$headers1);

        $sentmail = mail($to,$subject,$message,$headers);

        $route = "https://www.francebyfrench.com";
        $message = "Your Message has been sent successfully.";
        $this->setRedirect(JRoute::_($route), $message);

        }
        public function reqmail() {
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $user_id=$user->id;
        $urlid = JRequest::getvar('urlid');
        $qts = JRequest::getvar('qts');
        $t = JRequest::getvar('t');
        date_default_timezone_set("Asia/Kolkata");
        
        $user_data="SELECT * FROM `#__users` where id='$user_id'";
        $db->setQuery($user_data);
        $user_result=$db->loadObjectList();
        foreach($user_result as $userdta){
            $name=$userdta->name;
        	$lname=$userdta->lname;
        	$email=$userdta->email;
        	$mobile=$userdta->phone;
        }
        
        if($t==1){
            $orid=$urlid;
            $trip="Customized Trip";
        } else if($t==2){
            $quote_statusfordocument="SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND quote_status=$qts";
            $db->setQuery($quote_statusfordocument);
            $quote_status_id=$db->loadObjectList();

            foreach($quote_status_id as $quote_status_id_disp) {
                $document_qute_id= $quote_status_id_disp->id;
            }
            $orid=$document_qute_id;
            $trip="Semi Customized Trip";
        } else if($t==3){
            $orid=$urlid;
            $trip="Fixed Trip";
        }
        /**Mail Function**/

    	$from_id = "admin@francebyfrench.com";
		$to =  'paul.martin@francebyfrench.com' ;
		$subject ='FRANCEBYFRENCH NEW QUOTATION REWORK';
		$message = '<p>Dear Team,</p>
        <p>– '.$name.' – has sent a revised quote request. Please work with our suppliers and reply at the soonest.</p>
        <p>Order ID - '.$orid.'</p>
        <p>Trip Type - '.$trip.'</p>
        <p>Thanks,</p><p>FranceByFrench </p>';
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From:'.$from_id. "\r\n";
		$headers .= 'Cc: apoorva.uniyal@francebyfrench.com\r\n';
		$headers .= 'Bcc: souria.boumedine@francebyfrench.com\r\n';
	    
	    
	    $to2 = $email;
		$subject2 ='FRANCEBYFRENCH QUOTATION UPDATE REQUEST CONFIRMATION ';
		$message2 = '<p>Dear – '.$name.' </p>
        <p>You have requested for an update of your quotation, will be back to you in the best delay. </p>
        <p>A bientôt,</p><p>FranceByFrench </p>';
		$headers2 = "MIME-Version: 1.0" . "\r\n";
		$headers2 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers2 .= 'From:'.$from_id. "\r\n";
        
        
        if($t==1){
            $sql4="SELECT mail_count FROM `#__customized_order` WHERE id=$urlid";
            $db->setQuery($sql4);
            $mail=$db->loadResult();
            if($mail==0) {
            $object2 = new stdClass();
            $object2->id=$urlid;
            $object2->mail_count=1;
            JFactory::getDbo()->updateObject('#__customized_order', $object2, 'id');
            $sentmail = mail($to,$subject,$message,$headers);
            $sentmail2 = mail($to2,$subject2,$message2,$headers2);
            echo 'mail';
            } else {
                echo 'm';
            }
        } else if($t==2) {
            $quote_statusfordocument="SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND quote_status=$qts";
            $db->setQuery($quote_statusfordocument);
            $quote_status_id=$db->loadObjectList();

            foreach($quote_status_id as $quote_status_id_disp) {
                $document_qute_id= $quote_status_id_disp->id;
                $sql4="SELECT mail_count FROM `#__semicustomized_order` WHERE id=$document_qute_id AND quote_status=$qts";
                $db->setQuery($sql4);
                $mail=$db->loadResult();
                if($mail==0) {
                   $object2 = new stdClass();
                   $object2->id=$urlid;
                   $object2->mail_count=1;
                   JFactory::getDbo()->updateObject('#__semicustomized_order', $object2, 'id');
                   $sentmail = mail($to,$subject,$message,$headers);
                   $sentmail2 = mail($to2,$subject2,$message2,$headers2);
                   echo 'mail';
                } else {
                echo 'm';
                }
            }
        } else if($t==3) {
            $sql4="SELECT mail_count FROM `#__fixed_trip_orders` WHERE id=$urlid";
            $db->setQuery($sql4);
            $mail=$db->loadResult();
            if($mail==0) {
                $object2 = new stdClass();
                $object2->id=$urlid;
                $object2->mail_count=1;
                JFactory::getDbo()->updateObject('#__fixed_trip_orders', $object2, 'id');
                $sentmail = mail($to,$subject,$message,$headers);
                $sentmail2 = mail($to2,$subject2,$message2,$headers2);
                echo 'mail';
            } else {
                echo 'm';
            }
            
        }
        
        exit;
        }
}

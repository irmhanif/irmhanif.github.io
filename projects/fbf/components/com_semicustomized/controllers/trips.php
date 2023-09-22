
<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Semicustomized
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2018 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Trips list controller class.
 *
 * @since  1.6
 */
class SemicustomizedControllerTrips extends SemicustomizedController
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
	public function &getModel($name = 'Trips', $prefix = 'SemicustomizedModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
	public function newsession() {
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$user_id=$user->id;
	$number_peoples = JRequest::getvar('number_peoples', '');
	$number_rooms = JRequest::getvar('number_rooms', '');
	$trip_date = JRequest::getvar('trip_date', '');

	$_SESSION['number_peoples'] = $number_peoples;
	$_SESSION['number_rooms'] = $number_rooms;
	$_SESSION['trip_date'] = $trip_date;
	
	?>
	
    <script>
	          var jq=jQuery.noConflict();
	          jq(document).ready(function() {
	              var owl = firstjq('.owl-carousel');
	              owl.owlCarousel({
	               // loop: jq('.owl-carousel img').length > 4 ? true : false,
	                items: 4,
	                margin: 20,
	                autoplay: true,
	                autoPlay: 4000, //Set AutoPlay to 3 seconds
	                dots: false,
					nav:false,
	                navigation: false,
	                autoplayTimeout: 4000,
	        autoplayHoverPause: true,
	                loop : true,
	    responsive:{
		        300:{
		            items:1,
		        },
		       320:{
		            items:1,
		        },
		       480:{
		            items:2,
		        },
		        720:{
		            items:2,
		        },
		        986:{
		            items:3,
		        },
		        1000:{
		            items:4,
		        }
	        }
        });
        
  });
  </script> 
  
	       <?php 
	        echo '<div class="owl-carousel">';
                    if( ($user_id!=0 ) && ($number_peoples!=0) ){
                        $sql="SELECT * FROM `#__semicustomized_trip` WHERE carrousselselection='Interest' AND state=1 AND (($number_peoples>=peoplecapacity) && ($number_peoples<=peoplecapacitymax))  AND id NOT IN (SELECT trip_id FROM `#__semicustomized_order` WHERE uid=$user_id AND payment_status='intialized')";
                        $db->setQuery($sql);
                        $trip_detail=$db->loadObjectList();
                     } else if ($number_peoples==0){
                        $sql="SELECT * FROM `#__semicustomized_trip` WHERE carrousselselection='Interest' AND state=1";
                        $db->setQuery($sql);
                        $trip_detail=$db->loadObjectList();
                     } else if ($number_peoples==0) {
                        $sql="SELECT * FROM `#__semicustomized_trip` WHERE carrousselselection='Interest' AND state=1";
                        $db->setQuery($sql);
                        $trip_detail=$db->loadObjectList();
                     } else {
                        $sql="SELECT * FROM `#__semicustomized_trip` WHERE carrousselselection='Interest' AND state=1 AND (($number_peoples>=peoplecapacity) && ($number_peoples<=peoplecapacitymax)) ";
                        $db->setQuery($sql);
                        $trip_detail=$db->loadObjectList();   
                     }

                     
                    foreach($trip_detail as $trip_disp)
                    {
                        $trip_id=$trip_disp->id;
                        $tittle=$trip_disp->title;
                        $planningid=$trip_disp->planning1;
                        $image=$trip_disp->image;
                        $shortdescription=$trip_disp->shortdescription;
                        $longdescription=$trip_disp->longdescription;
                        $pro_img = JURI::root().'/trip_gallery/'.$image;
                        echo '<div class="item semi">
                             <div class="dispim1 semipro_img"  id="'.$trip_id.'">
        				        <img class="semipro_img"  src="'.$pro_img.'" alt="" />
                                <span class="eventtittle eventtittle1 evenblack" id="'.$trip_id.'">
                                <span >'.$tittle.'</span>
                                <p>'.$shortdescription.'</p></span>
                            </div>
                        </div>';

                    }
              echo '</div>';
               
	
	exit;
	}
	
public function newsession2() {
    
    $db = JFactory::getDbo();
	$user = JFactory::getUser();
	$user_id=$user->id;
	$number_peoples = JRequest::getvar('number_peoples', '');
	$number_rooms = JRequest::getvar('number_rooms', '');
	$trip_date = JRequest::getvar('trip_date', '');

        if(($user_id!=0) && ($number_peoples!=0)){
	                $sqlz="SELECT * FROM `#__semicustomized_trip` WHERE carrousselselection='Region' AND state=1 AND (($number_peoples>=peoplecapacity) && ($number_peoples<=peoplecapacitymax)) AND id NOT IN (SELECT trip_id FROM `#__semicustomized_order` WHERE uid=$user_id AND payment_status='intialized')";
	                $db->setQuery($sqlz);
	                $event_detailz=$db->loadObjectList();
                } else if ($number_peoples==0){
                    $sql="SELECT * FROM `#__semicustomized_trip` WHERE carrousselselection='Region' AND state=1";
                    $db->setQuery($sql);
                    $event_detailz=$db->loadObjectList();
                } else if ($number_peoples==0) {
                    $sql="SELECT * FROM `#__semicustomized_trip` WHERE carrousselselection='Region' AND state=1";
                    $db->setQuery($sql);
                    $event_detailz=$db->loadObjectList();
                     } else {
	                $sql="SELECT COUNT(id) FROM `#__semicustomized_trip` WHERE carrousselselection='Region' AND state=1 AND (($number_peoples>=peoplecapacity) && ($number_peoples<=peoplecapacitymax))";
	                $db->setQuery($sql);
	                $eveailz=$db->loadResult();
	                
	                $sqlz="SELECT * FROM `#__semicustomized_trip` WHERE carrousselselection='Region' AND state=1 AND (($number_peoples>=peoplecapacity) && ($number_peoples<=peoplecapacitymax))";
	                $db->setQuery($sqlz);
	                $event_detailz=$db->loadObjectList();
                }
                if($eveailz!=0) {
                } else {
                    echo 'no';
                }
    
    exit;
}
	

public function getPrice()
	{
	$db = JFactory::getDbo();
	$tripid = JRequest::getvar('tripid', '');
	$planid = JRequest::getvar('planid', '');
	$transport = JRequest::getvar('transport', '');
	$keeper = JRequest::getvar('keeper', '');
	$hotel_price = JRequest::getvar('hotel_booking', '');
	
	
	if($hotel_price=='undefined'){
	    $hotel_price='';
	}
	if($keeper=='undefined'){
	    $keeper='';
	}
	if($transport=='undefined'){
	    $transport='';
	}
    if(($hotel_price!='') && ($keeper!='') && ($transport!='')) 
    {
        	$number_peoples = $_SESSION['number_peoples'];
        	$number_rooms=$_SESSION['number_rooms'];
        	$trip_date=$_SESSION['trip_date'];
        
        	$_SESSION['keeper_information'] = $keeper;
        	$_SESSION['hotel_price'] = $hotel_price;
        	$_SESSION['transport'] = $transport;
        	$_SESSION['planid'] = $planid;
        
        
        	$sql_plancount="SELECT COUNT(id) FROM `#__semicustomized_plan` WHERE id=$planid AND state=1";
        	$db->setQuery($sql_plancount);
        	$plancount=$db->loadResult();
        
        	if($plancount!='0'){
        		$sql_getprice="SELECT * FROM `#__semicustomized_plan` WHERE id=$planid AND state=1";
        		$db->setQuery($sql_getprice);
        		$price_res1=$db->loadObjectList();
        
        		foreach ($price_res1 as $getprice) {
        		$priceperroom1 = $getprice->hotelprice1;
        		$priceperroom2 = $getprice->priceperroom2;
        		$priceperroom3 = $getprice->priceperroom3;
        		$priceperroom4 = $getprice->priceperroom4;// all room price
        
        		$transportprice1= $getprice->transportpricel1;
        		$transportprice2 = $getprice->transportprice2;
        		$transportprice3 = $getprice->transportprice3;
        		$transportprice4 = $getprice->transportprice4; // all transport price
        
        		// transportcapacity1 taken
        
        		$transportcapacity1= $getprice->transportcapacity1;
        		$transportcapacity2= $getprice->transportcapacity2;
        		$transportcapacity3= $getprice->transportcapacity3;
        		$transportcapacity4= $getprice->transportcapacity4;
        
        		$extraroom1 = $getprice->extraroom1;
        		$extraroom2 = $getprice->extraroom2;
        		$extraroom3 = $getprice->extraroom3;
        		$extraroom4 = $getprice->extraroom4; // all extraroom price
        		$maxroomcapacity = $getprice->maxroomcapacity;
        		$maxroomcapacity2 = $getprice->maxroomcapacity2;
        		$maxroomcapacity3 = $getprice->maxroomcapacity3;
        		$maxroomcapacity4 = $getprice->maxroomcapacity4; // all maxroomcapacity
        		$keeperprice1 = $getprice->keeperprice1;
        		$Keeperprice2 = $getprice->Keeperprice2;
        		$Keeperprice3 = $getprice->Keeperpriceday3;
        		$keeperprice4 = $getprice->Keeperpriceday4;
        		$keepercapacity1 = $getprice->keepercapacity1;
        		$keepercapacity2 = $getprice->keepercapacity2;
        		$keepercapacity3 = $getprice->keepercapacity3;
        		$keepercapacity4 = $getprice->keepercapacity4;
        
        		$pricetransfer = $getprice->pricetransfer;
        		$price_of_leaving=$getprice->price_of_leaving;
        		$publictransport=$getprice->publictransport;
        		$bookingtotal=$getprice->bookingtotal;
        		$insurance=$getprice->insurance;
        		$priceofact=$getprice->priceofact;
        		}
        
         	    if(isset($_SESSION['number_peoples'])) {
        			$number_people = $_SESSION['number_peoples'];
        		}
        		else {
        			 $number_people='';
        		}
        		if(isset($_SESSION['number_rooms'])) {
        			$number_rooms = $_SESSION['number_rooms'];
        		} else {
        			 $number_rooms='';
        		}
        		
        //	echo $number_people;	
        
        	if($transport=='yes') {
        	  
        		if (($number_people<=$transportcapacity1) && ($transportcapacity2>=0)) {
        			$transpor_price = $transportprice1;
        		} else if ($number_people>=$transportcapacity1 && $number_people<=$transportcapacity2) {
        			$transpor_price= $transportprice2;
        		} else if ($number_people<=$transportcapacity3 && $number_people>=$transportcapacity2) {
        			$transpor_price= $transportprice3;
        		} else if ($number_people>=$transportcapacity3 && $number_people>=$transportcapacity4) {
        			$transpor_price= $transportprice4;
        		} else {
        			$transpor_price = 0;
        		}
        	} else {
        		$transpor_price = 0;
        	}
        
        
        	if ($keeper=='yes') {
        		if (($number_people<=$keepercapacity1) && ($keepercapacity1>=0)){
        			$keeper_amt = $keeperprice1;
        		} else if ($number_people>=$keepercapacity1 && $number_people<=$keepercapacity2) {
        			$keeper_amt = $Keeperprice2;
        		} else if ($number_people<=$keepercapacity3 && $number_people>=$keepercapacity2) {
        			$keeper_amt = $Keeperprice3;
        		} else if ($number_people>=$keepercapacity3 && $number_people>=$keepercapacity4) {
        			$keeper_amt = $keeperprice4;
        		} else {
        			$keeper_amt = 0;
        		}
        	} else{
        		$keeper_amt = 0;
        	}
        
        	if($hotel_price!=''){
        		$hotel_price=$hotel_price;
        	} else {
        		$hotel_price=0;
        	}
        	
        	if($transport=='yes') { // private
        	    $costoftransport=$transpor_price;
        	     $costoftransport=$costoftransport/$number_people;
        	 } else if($transport=='no') { // public
        	    $costoftransport=$publictransport;
        	}
        	
         	$hotel_price_per_people = $hotel_price * $number_rooms / $number_people; //htelprice
        	
        
        	$keeper_amt=$keeper_amt/$number_people;
        	$keeper_amt=round($keeper_amt);
        	
        	$costoftransport=round($costoftransport);
        	
        	
        	$bookingtotal_per_person=$bookingtotal/$number_people; // bookingtotal_per_person
        	$bookingtotal_per_person=round($bookingtotal_per_person);
        	$hotel_price_per_people=round($hotel_price_per_people);
        
            $totalamt=$hotel_price_per_people+$priceofact+$costoftransport+$keeper_amt+$bookingtotal_per_person+$insurance;
        
            $totalamt2=round($totalamt);
        
           echo  $totalamt2;
         
        	}
        	else {
        		echo $totalamt2='';
        	}
    }
    else {
       	echo $totalamt2=''; 
    }
	$_SESSION['current_price']=$totalamt2;

	exit;
}

public function displayThis() {
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$user_id=$user->id;

	$sqlgetordercount="SELECT COUNT(id) FROM `#__semicustomized_order` WHERE uid='$user_id' AND payment_status='intialized'";
	$db->setQuery($sqlgetordercount);
	$ordercount=$db->loadResult();

	if($ordercount!=0) {
		$sqlgetorder="SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND payment_status='intialized'";
		$db->setQuery($sqlgetorder);
		$sqlgetorder=$db->loadObjectList();
	   $total_price=0;
	   echo '<h3>In Cart</h3>';
	   foreach($sqlgetorder as $result_res) {
	   		$order_id=$result_res->id;
	   		$trip_id=$result_res->trip_id;
	   		$number_peoples=$result_res->number_peoples;
	   		$price=$result_res->price;
	   		$dayscount= $result_res->noofdays;

	   		if($dayscount>1) {
	   		    $days='days';
	   		} else {
	   		     $days='day';
	   		}
	   		$total_price+=$price;



	   		$sqltripdet="SELECT * FROM `#__semicustomized_trip` WHERE id=$trip_id";
            $db->setQuery($sqltripdet);
            $trip_detail_res=$db->loadObjectList();

            foreach($trip_detail_res as $trip_res){
                $added_trip_id=$trip_res->id;
                $trip_tittle=$trip_res->title;
                $type=$trip_res->carrousselselection;

                $priceper1 =$price;
                
                $priceper=round($priceper1);
                
                $price_group=$price * $number_peoples;

            	echo $addedproduct ='<div class="removeoption">
					<p>
							<span class="addedtittle">'.$trip_tittle.'</span>
							<span class="days_countz">'.$dayscount.' '.$days.'</span>' .
									'<span class="semiprice">'.$priceper.'  Per Person</span>
							<span class="semiprice">'.$price_group.'  Total</span>
							<span class="remove" id="rem-'.$order_id.'">Remove</span>
					</p>
			</div>';
            }
	   }

	   	$sqldaycount="SELECT SUM(noofdays) FROM `#__semicustomized_order` WHERE uid=$user_id AND payment_status='intialized'";
		$db->setQuery($sqldaycount);
		$daycount=$db->loadResult();

		$priceperperson=$total_price;
		
		$total_price*=$number_peoples;

		echo '^'.$total_price.'^'.$type.'^'.$ordercount.'^'.$daycount.'^'.$priceperperson.'^'.$number_peoples;
	} else {
	    $total_price=$type=$ordercount=$daycount=$priceperperson=$number_peoples='';
	    echo '^'.$total_price.'^'.$type.'^'.$ordercount.'^'.$daycount.'^'.$priceperperson.'^'.$number_peoples;
	}
exit;
}

public function removeThis() {
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$user_id=$user->id;

	$romoveid=JRequest::getvar('remove_id', '');

	$del="DELETE FROM `#__semicustomized_order` WHERE id=$romoveid";
	$db->setQuery($del);
	$result = $db->query();

	exit;
}

public function carttoSession()
	{
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$user_id=$user->id;

	$trip_id = JRequest::getvar('trip_id', '');
	$noofdays = JRequest::getvar('noofdays', '');
    $trip_date = JRequest::getvar('trip_date', '');
    $number_rooms = JRequest::getvar('number_rooms', '');
    $number_peoples = JRequest::getvar('number_peoples', '');
    $keeper_information = JRequest::getvar('keeper_information', '');
    $hotel= JRequest::getvar('hotel', '');
    $transport= JRequest::getvar('transport', '');
    $price = JRequest::getvar('price', '');

    $_SESSION['trip_id'] = $trip_id;
    $_SESSION['noofdays'] = $noofdays;
    $_SESSION['trip_date'] = $trip_date;
    $_SESSION['number_rooms'] = $number_rooms;
	$_SESSION['number_peoples'] = $number_peoples;
	$_SESSION['keeper_information'] = $keeper_information;
	$_SESSION['hotel'] = $hotel;
	$_SESSION['transport'] = $transport;
	$_SESSION['price'] = $price;
	$_SESSION['trip'] = 'semicustomized_trip';

	exit;
	}

public function saveCart()
	{
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$user_id=$user->id;
	$noofdays = JRequest::getvar('noofdays', '');
    $trip_date = JRequest::getvar('trip_date', '');
    $trip_id = JRequest::getvar('trip_id', '');
    $number_rooms = JRequest::getvar('number_rooms', '');
    $number_peoples = JRequest::getvar('number_peoples', '');
    $keeper_information = JRequest::getvar('keeper_information', '');
    $keeper = JRequest::getvar('keeper_information', '');
    $hotel= JRequest::getvar('hotel', '');
    $transport= JRequest::getvar('transport', '');
    $price = JRequest::getvar('price', '');
    $hotel_price = JRequest::getvar('hotel_price', '');
    $planid = JRequest::getvar('planid', '');

    $trip_date = date("Y-m-d", strtotime($trip_date));

    $sqlgst="SELECT * FROM `#__common_price_management` WHERE state=1";
	$db->setQuery($sqlgst);
	$common_price_management_detail=$db->loadObjectList();
	foreach($common_price_management_detail as $pricemgt_disp) {
	    $gst=$pricemgt_disp->gst;
	}


    $userdetails ="SELECT * FROM `#__users` WHERE id=$user_id";
	$db->setQuery($userdetails);
	$userdetails=$db->loadObjectList();

	foreach($userdetails as $userdetails_disp)
	{
		$name=$userdetails_disp->name;
		$phone=$userdetails_disp->phone;
		$email=$userdetails_disp->email;
	}

    $semi_order ="SELECT COUNT(id) FROM `#__semicustomized_order` WHERE uid=$user_id AND trip_id=$trip_id AND payment_status='intialized'";
	$db->setQuery($semi_order);
	$semi_order_count=$db->loadResult();

	$lsemi_order ="SELECT id FROM `#__semicustomized_order` WHERE uid=$user_id AND trip_id=$trip_id AND payment_status='intialized'";
	$db->setQuery($lsemi_order);
	$last_orderid=$db->loadResult();

   /* get all the prices */

     $sql_plancount="SELECT COUNT(id) FROM `#__semicustomized_plan` WHERE id=$planid";
     $db->setQuery($sql_plancount);
     $plancount=$db->loadResult();

	if($plancount!='0')
	{
		$sql_getprice="SELECT * FROM `#__semicustomized_plan` WHERE id=$planid";
		$db->setQuery($sql_getprice);
		$price_res1=$db->loadObjectList();

		foreach ($price_res1 as $getprice)
		{
			$priceperroom1 = $getprice->hotelprice1;
			$priceperroom2 = $getprice->priceperroom2;
			$priceperroom3 = $getprice->priceperroom3;
			$priceperroom4 = $getprice->priceperroom4;// all room price

			$transportprice1= $getprice->transportpricel1;
			$transportprice2 = $getprice->transportprice2;
			$transportprice3 = $getprice->transportprice3;
			$transportprice4 = $getprice->transportprice4; // all transport price

			// transportcapacity1 taken

			$transportcapacity1= $getprice->transportcapacity1;
			$transportcapacity2= $getprice->transportcapacity2;
			$transportcapacity3= $getprice->transportcapacity3;
			$transportcapacity4= $getprice->transportcapacity4;

			$extraroom1 = $getprice->extraroom1;
			$extraroom2 = $getprice->extraroom2;
			$extraroom3 = $getprice->extraroom3;
			$extraroom4 = $getprice->extraroom4; // all extraroom price

			$maxroomcapacity = $getprice->maxroomcapacity;
			$maxroomcapacity2 = $getprice->maxroomcapacity2;
			$maxroomcapacity3 = $getprice->maxroomcapacity3;
			$maxroomcapacity4 = $getprice->maxroomcapacity4; // all maxroomcapacity

			$keeperprice1 = $getprice->keeperprice1;
			$Keeperprice2 = $getprice->Keeperprice2;
			$Keeperprice3 = $getprice->Keeperpriceday3;
			$keeperprice4 = $getprice->Keeperpriceday4;

			$keepercapacity1 = $getprice->keepercapacity1;
			$keepercapacity2 = $getprice->keepercapacity2;
			$keepercapacity3 = $getprice->keepercapacity3;
			$keepercapacity4 = $getprice->keepercapacity4;

			$pricetransfer = $getprice->pricetransfer;
			$price_of_leaving=$getprice->price_of_leaving;
			$publictransport=$getprice->publictransport;
			$bookingtotal=$getprice->bookingtotal;
			$insurance=$getprice->insurance;
			$priceofact=$getprice->priceofact;

		}

 	    if(isset($_SESSION['number_peoples'])) {
			$number_people = $_SESSION['number_peoples'];
		}
		else {
			 $number_people='';
		}
		if(isset($_SESSION['number_rooms'])) {
			$number_rooms = $_SESSION['number_rooms'];
		} else {
			 $number_rooms='';
		}

	if($transport=='yes') {
		if (($number_people<=$transportcapacity1) && ($transportcapacity2>=0)) {
			$transpor_price = $transportprice1;
		} else if ($number_people>=$transportcapacity1 && $number_people<=$transportcapacity2) {
			$transpor_price= $transportprice2;
		} else if ($number_people<=$transportcapacity3 && $number_people>=$transportcapacity2) {
			$transpor_price= $transportprice3;
		} else if ($number_people>=$transportcapacity3 && $number_people>=$transportcapacity4) {
			$transpor_price= $transportprice4;
		} else {
			$transpor_price = 0;
		}
	} else {
		$transpor_price = 0;
	}

	if ($keeper=='yes') {
		if (($number_people<=$keepercapacity1) && ($keepercapacity1>=0)){
			$keeper_amt = $keeperprice1;
		} else if ($number_people>=$keepercapacity1 && $number_people<=$keepercapacity2) {
			$keeper_amt = $Keeperprice2;
		} else if ($number_people<=$keepercapacity3 && $number_people>=$keepercapacity2) {
			$keeper_amt = $Keeperprice3;
		} else if ($number_people>=$keepercapacity3 && $number_people>=$keepercapacity4) {
			$keeper_amt = $keeperprice4;
		} else {
			$keeper_amt = 0;
		}
	} else{
		$keeper_amt = 0;
	}

	if($hotel_price!=''){
		$hotel_price=$hotel_price;
	} else {
		$hotel_price=0;
	}
	
	if($transport=='yes') { // private
	    $costoftransport=$transpor_price;
	     $costoftransport=$costoftransport/$number_people;
	     $costoftransport=round($costoftransport);
	 } else if($transport=='no') { // public
	    $costoftransport=$publictransport;
	}
	
	
	$bookingtotal_per_person=$bookingtotal/$number_people; // bookingtotal_per_person
	
	$bookingtotal=round($bookingtotal); // for single bookinf fee


	 $hotel_price_per_people = $hotel_price * $number_rooms / $number_people; //htelprice
	 
	 $hotel_price_per_people=round($hotel_price_per_people);
	 $activities_price = $priceofact;
	 $transfer_departure_price= $pricetransfer;
	 $ransfer_leaving_price = $price_of_leaving;
	 $price_of_public_transport=$publictransport;
	 
	$keeper_amt=$keeper_amt/$number_people;
	$keeper_amt=round($keeper_amt);
	 
	 
    $totalamt= $hotel_price_per_people+$priceofact+$costoftransport+$keeper_amt+$bookingtotal_per_person+$insurance;
    
    $totalamt=round($totalamt);
   
 
	$gstamount=($gst/100) * $totalamt;
	
	$gstamount=round($gstamount);
	
	$finalgst=$gstamount;
	
    $finalcost=$totalamt+$finalgst;
    $finalcost=round($finalcost);

	} else {
		echo $totalamt='';
	}

/* get price end */

	if($semi_order_count==0)
		{
			date_default_timezone_set("Asia/Kolkata");
			$current_day=date('d-m-Y');
		    $object2 = new stdClass();
		    $object2->id='';
			$object2->uid=$user_id;
			$object2->payer_name=$name;
			$object2->payer_number=$phone;
			$object2->payer_email=$email;
			$object2->noofdays=$noofdays;
			$object2->trip_date=$trip_date;
			$object2->trip_id=$trip_id;
			$object2->planid=$planid;
			$object2->number_rooms=$number_rooms;
			$object2->number_peoples=$number_peoples;
			$object2->keeper_information=$keeper_information;
			$object2->hotel=$hotel;
			$object2->hotel_price=$hotel_price;
			$object2->transport=$transport;
			$object2->price=$price;
			$object2->added_date=$current_day;
			$object2->price_of_hotel=$hotel_price_per_people;
			$object2->cost_of_activities=$activities_price;
			$object2->cost_of_transport=$costoftransport;
			$object2->cost_of_Keeper=$keeper_amt;
			$object2->cost_of_booking_fee=$bookingtotal_per_person;
			$object2->cost_of_insurance=$insurance;
			$object2->transfer_departure_price=$transfer_departure_price;
			$object2->price_of_leaving=$ransfer_leaving_price;
			$object2->price_of_public_transport=$price_of_public_transport;
			$object2->total_cost_tax_free=$totalamt;
			$object2->gst=$gstamount;
			$object2->final_cost=$finalcost;
			$object2->payment_status='intialized';
			$db->insertObject('#__semicustomized_order', $object2);

			$last_inserted_id =$db->insertid();
			$_SESSION['trip'] = 'semicustomized_trip';
			$_SESSION['scroll'] = 'scroll';
		}
	exit;
	}
	
public function getPrograms()
	{
	$db = JFactory::getDbo();
	$user = JFactory::getUser();
	$user_id=$user->id;
	$planid= JRequest::getvar('planid', '');
	$tripid = JRequest::getvar('tripid', '');
	
	$_SESSION['planid'] = $planid;


    if(isset($_SESSION['keeper_information'])) {
		$keeper_information = $_SESSION['keeper_information'];
	} else {
		$keeper_information='';
	
	}

	if(isset($_SESSION['hotel_price'])) {
		$hotel_price = $_SESSION['hotel_price'];
		
	}
	else {
		$hotel_price ='';
		
	}
	if(isset($_SESSION['transport'])) {
		$transport = $_SESSION['transport'];
	} else {
		$transport ='';
	}
	
	if($keeper_information!='') {
	    $keeperselected='selected';
	} else {
	    $keeperselected='';
	}
	

   if($hotel_price!='') {
       $hotel_selected='selected';
   } else {
       $hotel_selected='';
   }

  if($transport!='') {
      $transport_selected='selected';
   } else {
       $transport_selected='';
   }	

	if($planid!=0)
	{
		$sql_getplan="SELECT * FROM `#__semicustomized_trip` WHERE id=$tripid";
		$db->setQuery($sql_getplan);
		$trip_detail=$db->loadObjectList();

		 foreach($trip_detail as $event_disp) {
         $event_id=$event_disp->id;
         $tittle=$event_disp->title;

$plandaycount=0;
	     $sql2="SELECT * FROM `#__semicustomized_plan` WHERE id=$planid";
	     $db->setQuery($sql2);
	     $plan_detail=$db->loadObjectList();

            foreach($plan_detail as $plan_detail_disp) {
                    $paln_id=$plan_detail_disp->id;
                    $noofdays=$plan_detail_disp->no_of_days_in_plan;
                     for($i=1;$i<=$noofdays;$i++) {
						$daycolumn='days'.$i;
						$sqld="SELECT $daycolumn FROM `#__semicustomized_plan` WHERE id=$paln_id";
						$db->setQuery($sqld);
						$daysid=$db->loadResult();

						$sql3="SELECT * FROM `#__semicustomized_days` WHERE id=$daysid";
		                $db->setQuery($sql3);
		                $day_detail=$db->loadObjectList();
            $plandaycount++;            
		                foreach($day_detail as $day_detail_disp) {
		                    
                            $day_id=$day_detail_disp->id;
                            $picture=$day_detail_disp->picture;
                            $daytittle=$day_detail_disp->title;
                            $desciptiion=$day_detail_disp->desciptiion;
                            $pro_img = JURI::root().'/uploads/'.$picture;
                            echo'<div class="planningbox">
                                <div class="planimg"><img src="'.$pro_img.'" alt="" /></div>
                                <div class="plancnt">
                                <span class="plandays">Day '.$plandaycount.'</span>
                                <h3>'.$daytittle.'</h3>
                                <span>'.$desciptiion.'</span>
                                </div></div>';
                            }
                        }
                    }
                    
                $inclusion="SELECT * FROM `#__semicustomized_plan` WHERE id=$planid";
                $db->setQuery($inclusion);
                $inclus=$db->loadObjectList();
                foreach ($inclus as $inclusionn) {
                    $inclusion = $inclusionn->inclusion;
                    $noinclusion = $inclusionn->noinclusion;
                    echo '<div class="inclusionsbox semi">
                    <div class="inclusionsmargin">
                    <div class="inclusions">
                    <h1>Inclusion</h1>
                    <div class="inc">'.$inclusion.'</div>
                    <div class="noinc">'.$noinclusion.'</div>
                    </div></div></div>';
                }
                    
                ?>
                
                 <?php
           // display drop downs
           
   if(isset($_SESSION['keeper_information'])) {
		$keeper_information = $_SESSION['keeper_information'];
	} else {
		$keeper_information='';
	
	}

	if(isset($_SESSION['hotel_price'])) {
		$hotel_price = $_SESSION['hotel_price'];
		
	}
	else {
		$hotel_price ='';
		
	}
	if(isset($_SESSION['transport'])) {
		$transport = $_SESSION['transport'];
	} else {
		$transport ='';
	}
	
	if($keeper_information!='') {
	    $keeperselected='selected';
	} else {
	    $keeperselected='';
	}
	

   if($hotel_price!='') {
       $hotel_selected='selected';
   } else {
       $hotel_selected='';
   }

  if($transport!='') {
      $transport_selected='selected';
   } else {
       $transport_selected='';
   }	
?>
                
            <div class="hotel_booking semice">
                <?php
                $sql_facility="SELECT * FROM `#__semicustomized_trip` WHERE state='1' AND id=$tripid";
                $db->setQuery($sql_facility);
                $facility=$db->loadObjectList();
                foreach($facility as $facility_disp) {
                    $id=$facility_disp->id;
                    $keeper_choice=$facility_disp->keeperconsumer;
                    $nokeeperconsumer=$facility_disp->nokeeperconsumer;
                    $transportconsumer=$facility_disp->transportconsumer;
                    $notransportconsumer=$facility_disp->notransportconsumer;
                    $hotelconsumer=$facility_disp->hotelconsumer;
                    $nohotelconsumer=$facility_disp->nohotelconsumer;
				}

                echo '<div class="inp_box_trip3">
                <div class="stayinfofix">
                <div class="stayinfix">
                <div>';
                $pro_img1 = JURI::root().'/images/ic1.png';
                $pro_img2 = JURI::root().'/images/ic2.png';
                $pro_img3 = JURI::root().'/images/ic3.png';

                if($keeper_choice=='yes') {
                    echo '<p><span><img src='.$pro_img3.'></span>';
                    ?>
                    <select id="keeper" name="keeper">
                        <option value="">Select Keeper</option>
                        <option value="yes" <?php if($keeper_information=='yes') { echo $keeperselected; } ?> >With keeper</option>
                        <option value="no"  <?php if($keeper_information=='no') { echo $keeperselected; } ?> >Without keeper</option>
                    </select>
                    
                    <?php
                    echo '</p>';
                } else {
                      if($nokeeperconsumer=='yes') {
                      	   $nokeeperconsumerdisp='With keeper';
                      	} else {
                       	   $nokeeperconsumerdisp='Without keeper';
                       	}
                        echo '<p><span><img src='.$pro_img3.'></span>
                        <select id="keeper" name="keeper">
                        <option value="'.$nokeeperconsumer.'" '.$keeperselected.'>'.$nokeeperconsumerdisp.'</option>
                        </select></p>';
                }
                echo '</div><div>';
                if($hotelconsumer=='yes') {
                ?>
                <p><span><img src='<?php echo $pro_img1; ?>'></span>
                <select id="hotel_booking" name="hotel_booking">
                    <?php
	                $sql_getprice="SELECT * FROM `#__semicustomized_plan` WHERE id=$planid";
                    $db->setQuery($sql_getprice);
                    $price_res1=$db->loadObjectList();
                    foreach ($price_res1 as $getprice) {
                        $hoteltitle1 = $getprice->hoteltitle1;
                        $hotelprice1 = $getprice->hotelprice1; //price
                        $hoteltitle2 = $getprice->hoteltitle2;
                        $priceperroom2 = $getprice->priceperroom2; //price
                        $hoteltitle3 = $getprice->hoteltitle3;
                        $priceperroom3 = $getprice->priceperroom3; //price
                        $hoteltitle4 = $getprice->hoteltitle4;// all room price
                        $priceperroom4 = $getprice->priceperroom4; //price
                    }
                    ?>
                    <option value="">Select Hotel</option>
                    <?php
                       if($hotelprice1!=''){
                    ?>
                        <option value="<?php echo $hotelprice1; ?>"   <?php if ($hotelprice1 == $hotel_price ) { echo $hotel_selected; } ?> ><?php echo $hoteltitle1; ?></option>
                          <?php
                         }
                    ?>
                    <?php
                       if($priceperroom2!=''){
                    ?>
                            <option value="<?php echo $priceperroom2; ?>" <?php if ($priceperroom2 == $hotel_price ) { echo $hotel_selected; } ?>><?php echo $hoteltitle2; ?></option>
                    <?php
                       }
                    ?>
                    <?php
                       if($priceperroom3!=''){
                    ?>
                    <option value="<?php echo $priceperroom3; ?>" <?php if ($priceperroom3 == $hotel_price) { echo $hotel_selected; } ?>><?php echo $hoteltitle3; ?></option>
                    <?php
                       }
                    ?>
                    
                    <?php
                       if($priceperroom3!=''){
                    ?>    
                    <option value="<?php echo $priceperroom4; ?>" <?php if ($priceperroom4 == $hotel_price ) { echo $hotel_selected; } ?>><?php echo $hoteltitle4; ?></option>
                    
                    <?php
                       }
                    ?> 

                </select>
				</p>
				<?php
				} else {
                    $sql_gethoteltitle1="SELECT * FROM `#__semicustomized_plan` WHERE id=$planid";
                    $db->setQuery($sql_gethoteltitle1);
                    $hoteltitle=$db->loadObjectList();
                    foreach($hoteltitle as $hoteltitle_disp){
                        $tit = $hoteltitle_disp->hoteltitle1;
                        $price_des = $hoteltitle_disp->hotelprice1; //price
                    }
                    echo '<p><span><img src='.$pro_img1.'></span>
                    <select id="hotel_booking" name="hotel_booking">
                    <option value="'.$price_des.'" '.$hotel_selected.'>'.$tit.'</option>
                    </select></p>';
                }
                echo '</div><div>';
                if($transportconsumer=='yes') {
                    echo '<p><span><img src='.$pro_img2.'></span>';
                    ?>
                    <select id="transport" name="transport">
                        <option value="">Select Transport</option>
                        <option value="yes" <?php if($transport=='yes') { echo $transport_selected; } ?> >Private transportation</option>
                        <option value="no" <?php  if($transport=='no') { echo $transport_selected; } ?> >Public transportation</option>
                    </select>
                    
                    <?php
                    echo '</p></div>';
                } else {
                    if($notransportconsumer=='yes'){
                        $notransportconsumerdisp='Private transportation';
                    } else {
                        $notransportconsumerdisp='Public transportation';
                    }
                    echo '<p><span><img src='.$pro_img2.'></span>
                    <select id="transport" name="transport">
                    <option value="'.$notransportconsumer.'" '.$transport_selected.'>'.$notransportconsumerdisp.'</option>
                    </select></p></div>';
                }
                ?>
                </div>
        </div>
                
                
        
			<?php
            }
		} 
		else
		{
			echo '';
		}
	exit;
	}

}

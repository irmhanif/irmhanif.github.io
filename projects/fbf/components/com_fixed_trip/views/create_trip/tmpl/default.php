<?php
$db=JFactory::getDBO();
$user = JFactory::getUser();
$user_id=$user->id;
$id = JRequest::getVar('id');
$date = JRequest::getVar('date');
$type = JRequest::getVar('type');

if($id!='') {
$_SESSION['crtid']=$id;
$_SESSION['crtdate']=$date;
$_SESSION['crttype']=$type;
}


if( isset( $_SESSION['sesstpageid'] ) ) {
	$sesspageidd =  $_SESSION['sesstpageid'] ;
} else {
		$sesspageidd = '';
}
if( isset( $_SESSION['date'] ) ) {
	$sessdate =  $_SESSION['date'] ;
} else {
	$sessdate = '';
}
if( isset( $_SESSION['no_of_people'] ) ) {
	$sessno_of_per = $_SESSION['no_of_people'] ;
} else {
	$sessno_of_per = '';
}
if( isset( $_SESSION['no_of_rooms'] ) ) {
	$sessno_of_room = $_SESSION['no_of_rooms'] ;
} else {
	$sessno_of_room = '';
}
if( isset( $_SESSION['prices'] ) ) {
	$sessprice =  $_SESSION['prices'] ;
} else {
	$sessprice = '';
}
if( isset( $_SESSION['type'] ) ) {
 $sesshotel =  $_SESSION['type'] ;
} else {
	$sesshotel = '';
}
if( isset( $_SESSION['seat'] ) ) {
 $sessseat =  $_SESSION['seat'] ;
} else {
	$sessseat = '';
}

/*************** getting session values end *********************/
if($id != '') {
    $id = JRequest::getVar('id');
} else {
    $id =  $_SESSION['sesspageid'] ;
}
if($date != '') {
    $date = JRequest::getVar('date');
} else {
    $date =  $_SESSION['sesspagedate'] ;
}
if($type != '') {
    $type = JRequest::getVar('type');
} else {
    $type =  $_SESSION['sesspagetype'] ;
}

$id=$_SESSION['crtid'];
$date=$_SESSION['crtdate'];
$type=$_SESSION['crttype'];
?>
<script src="addons/owl/jquery.min.js"></script>
<script src="addons/owl/owl.carousel.js"></script>
<div class="inner_page">
    <div class="innerpage_banner">
        
            <?php 
            $sqllist="SELECT pictureb FROM `#__type_category` WHERE state='1' AND id='$type'";
        $db->setQuery($sqllist);
        $bpic=$db->loadResult();
        
            
            if($bpic!="") {
                echo '<div class="owl-carouseb">';
            $bpic=explode(',', $bpic);
            foreach ($bpic as $key) {
            echo '<div class="item"><img src="type_category_banner/'.$key.'" alt=""></div>';
            }
            echo '</div>';
        } else {
            echo '<div class="item"><img src="images/fixedb/P13GFTP4.jpg" alt=""></div>';
        }
        
            ?>
       
    </div>
    <?php
         $sqllist="SELECT * FROM `#__create_trip` WHERE state='1' AND id='$id' AND type='$type'";
        $db->setQuery($sqllist);
        $result=$db->loadObjectList();
        foreach($result as $data) {
            $tripid=$data->id;
	        $title=$data->title;
	        $desc=$data->description;
	        $type=$data->type;
            $date_of_departure1=$data->date_of_departure1;
            $price_person1 = $data->price_person1;
            $price_single_room_extra1 = $data->price_single_room_extra1;
            $cost_hotel1 = $data->cost_hotel1;
            $cost_activites1 = $data->cost_activites1;
            $cost_transport1 = $data->cost_transport1;
            $cost_keeper1 = $data->cost_keeper1;
            $cost_booking_fee1 = $data->cost_booking_fee1;
            $cost_insurance1 = $data->cost_insurance1;
            $extracosti1 = $data->extracosti1;
            $extracostii1 = $data->extracostii1;
            $pdfplanning1 = $data->pdfplanning1;
            $seat_available1 = $data->seat_available1;
            $keeper1 = $data->keeper1;
            $transport1 = $data->transport1;
            $hotel1 = $data->hotel1;
            $inclusion1 = $data->inclusion1;
            $noinclusion1 = $data->noinclusion1;
            $planning1 = $data->planning1;
            $number_of_day1 = $data->number_of_day1;

            $date_of_departure2=$data->date_of_departure2;
            $price_person2 = $data->price_person2;
            $price_single_room_extra2 = $data->price_single_room_extra2;
            $cost_hotel2 = $data->cost_hotel2;
            $cost_activites2 = $data->cost_activites2;
            $cost_transport2 = $data->cost_transport2;
            $cost_keeper2 = $data->cost_keeper2;
            $cost_booking_fee2 = $data->cost_booking_fee2;
            $cost_insurance2 = $data->cost_insurance2;
            $extracosti2 = $data->extracosti2;
            $extracostii2 = $data->extracostii2;
            $pdfplanning2 = $data->pdfplanning2;
            $seat_available2 = $data->seat_available2;
            $keeper2 = $data->keeper2;
            $transport2 = $data->transport2;
            $hotel2 = $data->hotel2;
            $inclusion2 = $data->inclusion2;
            $noinclusion2 = $data->noinclusion2;
            $planning2 = $data->planning2;
            $number_of_day2 = $data->number_of_day2;

            $date_of_departure3=$data->date_of_departure3;
            $price_person3 = $data->price_person3;
            $price_single_room_extra3 = $data->price_single_room_extra3;
            $cost_hotel3 = $data->cost_hotel3;
            $cost_activites3 = $data->cost_activites3;
            $cost_transport3 = $data->cost_transport3;
            $cost_keeper3 = $data->cost_keeper3;
            $cost_booking_fee3 = $data->cost_booking_fee3;
            $cost_insurance3 = $data->cost_insurance3;
            $extracosti3 = $data->extracosti3;
            $extracostii3 = $data->extracostii3;
            $pdfplanning3 = $data->pdfplanning3;
            $seat_available3 = $data->seat_available3;
            $keeper3 = $data->keeper3;
            $transport3 = $data->transport3;
            $hotel3 = $data->hotel3;
            $inclusion3 = $data->inclusion3;
            $noinclusion3 = $data->noinclusion3;
            $planning3 = $data->planning3;
            $number_of_day3 = $data->number_of_day3;

            $date_of_departure4=$data->date_of_departure4;
            $price_person4 = $data->price_person4;
            $price_single_room_extra4 = $data->price_single_room_extra4;
            $cost_hotel4 = $data->cost_hotel4;
            $cost_activites4 = $data->cost_activites4;
            $cost_transport4 = $data->cost_transport4;
            $cost_keeper4 = $data->cost_keeper4;
            $cost_booking_fee4 = $data->cost_booking_fee4;
            $cost_insurance4 = $data->cost_insurance4;
            $extracosti4 = $data->extracosti4;
            $extracostii4 = $data->extracostii4;
            $pdfplanning4 = $data->pdfplanning4;
            $seat_available4 = $data->seat_available4;
            $keeper4 = $data->keeper4;
            $transport4 = $data->transport4;
            $hotel4 = $data->hotel4;
            $inclusion4 = $data->inclusion4;
            $noinclusion4 = $data->noinclusion4;
            $planning4 = $data->planning4;
            $number_of_day4 = $data->number_of_day4;

            $date_of_departure5=$data->date_of_departure5;
            $price_person5 = $data->price_person5;
            $price_single_room_extra5 = $data->price_single_room_extra5;
            $cost_hotel5 = $data->cost_hotel5;
            $cost_activites5 = $data->cost_activites5;
            $cost_transport5 = $data->cost_transport5;
            $cost_keeper5 = $data->cost_keeper5;
            $cost_booking_fee5 = $data->cost_booking_fee5;
            $cost_insurance5 = $data->cost_insurance5;
            $extracosti5 = $data->extracosti5;
            $extracostii5 = $data->extracostii5;
            $pdfplanning5 = $data->pdfplanning5;
            $seat_available5 = $data->seat_available5;
            $keeper5 = $data->keeper5;
            $transport5 = $data->transport5;
            $hotel5 = $data->hotel5;
            $inclusion5 = $data->inclusion5;
            $noinclusion5 = $data->noinclusion5;
            $planning5 = $data->planning5;
            $number_of_day5 = $data->number_of_day5;

            $date_of_departure6=$data->date_of_departure6;
            $price_person6 = $data->price_person6;
            $price_single_room_extra6 = $data->price_single_room_extra6;
            $cost_hotel6 = $data->cost_hotel6;
            $cost_activites6 = $data->cost_activites6;
            $cost_transport6 = $data->cost_transport6;
            $cost_keeper6 = $data->cost_keeper6;
            $cost_booking_fee6 = $data->cost_booking_fee6;
            $cost_insurance6 = $data->cost_insurance6;
            $extracosti6 = $data->extracosti6;
            $extracostii6 = $data->extracostii6;
            $pdfplanning6 = $data->pdfplanning6;
            $seat_available6 = $data->seat_available6;
            $keeper6 = $data->keeper6;
            $transport6 = $data->transport6;
            $hotel6 = $data->hotel6;
            $inclusion6 = $data->inclusion6;
            $noinclusion6 = $data->noinclusion6;
            $planning6 = $data->planning6;
            $number_of_day6 = $data->number_of_day6;
        }
        if($date_of_departure1 == $date) {
        	$price_person = $price_person1;
            $price_single_room_extra = $price_single_room_extra1;
            $cost_hotel = $cost_hotel1;
            $cost_activites = $cost_activites1;
            $cost_transport  = $cost_transport1;
            $cost_keeper = $cost_keeper1;
            $cost_booking_fee = $cost_booking_fee1;
            $cost_insurance = $cost_insurance1;
            $extracosti = $extracosti1;
            $extracostii = $extracostii1;
            $pdfplanning = $pdfplanning1;
            $seat_available = $seat_available1;
            $keeper = $keeper1;
            $transport = $transport1;
            $hotel = $hotel1;
            $inclusion = $inclusion1;
            $noinclusion = $noinclusion1;
            $planning = $planning1;
            $number_of_day = $number_of_day1;
        } elseif ($date_of_departure2 == $date) {
        	$price_person = $price_person2;
            $price_single_room_extra = $price_single_room_extra2;
            $cost_hotel = $cost_hotel2;
            $cost_activites = $cost_activites2;
            $cost_transport  = $cost_transport2;
            $cost_keeper = $cost_keeper2;
            $cost_booking_fee = $cost_booking_fee2;
            $cost_insurance = $cost_insurance2;
            $extracosti = $extracosti2;
            $extracostii = $extracostii2;
            $pdfplanning = $pdfplanning2;
            $seat_available = $seat_available2;
            $keeper = $keeper2;
            $transport = $transport2;
            $hotel = $hotel2;
            $inclusion = $inclusion2;
            $noinclusion = $noinclusion2;
            $planning = $planning2;
            $number_of_day = $number_of_day2;
        } elseif ($date_of_departure3 == $date) {
            $price_person = $price_person3;
            $price_single_room_extra = $price_single_room_extra3;
            $cost_hotel = $cost_hotel3;
            $cost_activites = $cost_activites3;
            $cost_transport  = $cost_transport3;
            $cost_keeper = $cost_keeper3;
            $cost_booking_fee = $cost_booking_fee3;
            $cost_insurance = $cost_insurance3;
            $extracosti = $extracosti3;
            $extracostii = $extracostii3;
            $pdfplanning = $pdfplanning3;
            $seat_available = $seat_available3;
            $keeper = $keeper3;
            $transport = $transport3;
            $hotel = $hotel3;
            $inclusion = $inclusion3;
            $noinclusion = $noinclusion3;
            $planning = $planning3;
            $number_of_day = $number_of_day3;
        } elseif ($date_of_departure4 == $date) {
            $price_person = $price_person4;
            $price_single_room_extra = $price_single_room_extra4;
            $cost_hotel = $cost_hotel4;
            $cost_activites = $cost_activites4;
            $cost_transport  = $cost_transport4;
            $cost_keeper = $cost_keeper4;
            $cost_booking_fee = $cost_booking_fee4;
            $cost_insurance = $cost_insurance4;
            $extracosti = $extracosti4;
            $extracostii = $extracostii4;
            $pdfplanning = $pdfplanning4;
            $seat_available = $seat_available4;
            $keeper = $keeper4;
            $transport = $transport4;
            $hotel = $hotel4;
            $inclusion = $inclusion4;
            $noinclusion = $noinclusion4;
            $planning = $planning4;
            $number_of_day = $number_of_day4;
        } elseif ($date_of_departure5 == $date) {
            $price_person = $price_person5;
            $price_single_room_extra = $price_single_room_extra5;
            $cost_hotel = $cost_hotel5;
            $cost_activites = $cost_activites5;
            $cost_transport  = $cost_transport5;
            $cost_keeper = $cost_keeper5;
            $cost_booking_fee = $cost_booking_fee5;
            $cost_insurance = $cost_insurance5;
            $extracosti = $extracosti5;
            $extracostii = $extracostii5;
            $pdfplanning = $pdfplanning5;
            $seat_available = $seat_available5;
            $keeper = $keeper5;
            $transport = $transport5;
            $hotel = $hotel5;
            $inclusion = $inclusion5;
            $noinclusion = $noinclusion5;
            $planning = $planning5;
            $number_of_day = $number_of_day5;
        } elseif ($date_of_departure6 == $date) {
            $price_person = $price_person6;
            $price_single_room_extra = $price_single_room_extra6;
            $cost_hotel = $cost_hotel6;
            $cost_activites = $cost_activites6;
            $cost_transport  = $cost_transport6;
            $cost_keeper = $cost_keeper6;
            $cost_booking_fee = $cost_booking_fee6;
            $cost_insurance = $cost_insurance6;
            $extracosti = $extracosti6;
            $extracostii = $extracostii6;
            $pdfplanning = $pdfplanning6;
            $seat_available = $seat_available6;
            $keeper = $keeper6;
            $transport = $transport6;
            $hotel = $hotel6;
            $inclusion = $inclusion6;
            $noinclusion = $noinclusion6;
            $planning = $planning6;
            $number_of_day = $number_of_day6;
        }
        $datef = date('d-F-Y', strtotime($date));
        $planid =  $planning;
        $sq="SELECT no_of_days FROM `#__fixed_trip_planning` WHERE id='$planning'";
        $db->setQuery($sq);
        $ndays = $db->loadResult();
        $sql="SELECT no_of_people FROM `#__fixed_trip_orders` WHERE pack_id='$tripid' AND pack_date='$date' AND (payment_status='first_installment' OR payment_status='final_installment')";
       $db->setQuery($sql);
        $seats = $db->loadResult();
        $seats = $seat_available - $seats;
          $sq="SELECT * FROM `#__fixed_bc_orders` WHERE state=1";
        $db->setQuery($sq);
        $bc_orders = $db->loadObjectList();
        foreach($bc_orders as $ord) {
        $ttrip=$ord->trip;
        $bseat=$ord->seat;
        
            $ttrip=explode('#',$ttrip);
            $bcid=$ttrip[0];
            $bcdate=$ttrip[1];
            $dfdate=date('Y-m-d',strtotime($date));
            $bcdate=date('Y-m-d',strtotime($bcdate));
            if($dfdate==$bcdate && $bcid == $id) {
            
            $seats=$seats-$bseat;
            if($seats<=0) {
                $seats=0;
            }
            }
        }
    ?>
    <div class="inner_page_layout">
        <div class="about_trip_fixed">
            <h1><?php echo $title; ?></h1>
            <p class="tripavil"><?php echo $seat_available; ?> People Trip</p>
            <span><?php echo $desc; ?></span>
        </div>
    </div>
    <div class="trip_for_container">
        <div class="trip_form">
            <div class="trip_forms">
                <form action="#" method="POST">
                    <div class="inp_box_trip1">
                        <span class="tripboxes">
                            <input type="hidden" id="date" value="<?php echo $date; ?>" readonly>
	                        <input type="text" id="dates" value="<?php echo $datef; ?>" readonly>
	                    </span>
	                    <span class="tripboxes">
	                        <label>Places Left: </label>
	                        <span class="tripboxinpts">
	                            <input type="text" class="placeleft" value="<?php echo $seats; ?> LEFT" readonly>
	                            <?php if($seats != 0) { ?>
	                            	
                                <?php } else {
                                //	echo "<script>alert('All seats are booked, Kindly choose another date, ');";
                                //	echo "window.location = 'index.php?option=com_fixed_trip&view=datecategories';</script>";
                                }
                                ?>
                                <?php
                                if($seats==1) {
                                    $value=1;
                                } else {
                                    $value=2;
                                }
                                
                                ?>
                            </span>
                        </span>
                    </div>
                    <?php
                    if($seats==0) {
                                  
                                } else {
                    ?>
                    <div class="inp_box_trip2">
                        <span class="tripboxes">
                            <label>No. of People</label>
                            <span class="tripboxinpts">
                                
                            	<input type=button class="button1" onclick="decrValue()" id="dec" value="-">
                            	<input type=text id="number" value="<?php echo $value; ?>" size="2" min="1" max="20" readonly="">
                            	<input type=button class="button1" onclick="incrValue()" id="inc" value="+">
                            </span>
                        </span>
                        <span class="tripboxes">
                            <label>No. of Rooms</label>
                            <span class="tripboxinpts">
                                <input type=button class="button1" onclick="decrrValue()" id="decr" value="-">
                                <input type=text id="room" value="1" size="2" min="1" max="20" readonly="">
                                <input type=button class="button1" onclick="incrrValue()" id="incr" value="+">
                            </span>
                        </span>
                        <?php  $cost_hotel; 
                        $total = (($price_person * $value) + ($cost_hotel*1))/$value;
                        $price_person;
                        ?>
                        <input type='hidden' id="ndays" value="<?php echo $ndays; ?>" size="5" readonly="true">
                    </div>
                    <?php
                                }
                    ?>
                </form>
            </div>
        </div>
        <div class="fixed_plannning">
            <h1>Planning</h1>
            <div class="planningdays">
                                <div class="planningmargin">

            <ul>
            <?php
                $i=0;
                $planning="SELECT * FROM `#__fixed_trip_planning` WHERE state='1' AND id='$planning'";
                $db->setQuery($planning);
                $result=$db->loadObjectList();
                foreach($result as $data1) {
                    $days1=$data1->days1;
                    $days2=$data1->days2;
                    $days3=$data1->days3;
                    $days4=$data1->days4;
                    $days5=$data1->days5;
                    $days6=$data1->days6;
                    $days7=$data1->days7;
                    $days8=$data1->days8;
                    $days9=$data1->days9;
                    $days10=$data1->days10;
                    $days11=$data1->days11;
                    $days12=$data1->days12;
                    $days13=$data1->days13;
                    $days14=$data1->days14;
                    $days15=$data1->days15;
                    $days16=$data1->days16;
                    $days17=$data1->days17;
                    $days18=$data1->days18;
                    $days19=$data1->days19;
                    $days20=$data1->days20;
                    $days = array($days1,$days2,$days3,$days4,$days5,$days6,$days7,$days8,$days9,$days10,$days11,$days12,$days13,$days14,$days15,$days16,$days17,$days18,$days19,$days20);
                    foreach ($days as $value) {
                        if($value != "") {
                            $sql="SELECT * FROM `#__fixed_trip_days` WHERE state='1' AND id='$value'";
                            $db->setQuery($sql);
                            $pldays=$db->loadObjectList();
                            $i++;
                            foreach ($pldays as $thisday) {
                                $titles=$thisday->title;
                                $picture=$thisday->picture;
                                $description=$thisday->description;
                                echo'<div class="planningbox">
                                <div class="planimg"><img src="create_day/'.$picture.'"></div>
                                <div class="plancnt"><span class="plandays">Day: '.$i.'</span><h3>'.$titles.'</h3><span class="pln_desc">'.$description.'</span></div></div>
                                ';
                            }
                        }
                    }
                }
            ?>
            </ul></div></div></div>
        <div class="inclusionsbox">
            <div class="inclusionsmargin">
                <div class="inclusions">
                    <h1>Inclusion</h1>
                    <div class="inc">
                        <?php echo $inclusion; ?>
                    </div>
                    <div class="noinc">
                        <?php echo $noinclusion; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="inp_box_trip3">
            <div class="stayinfofix">
                <div class="stayinfix">
                <div><span><img src="images/ic1.png"></span>
                <p><?php echo $hotel; ?></p></div>
                <div><span><img src="images/ic2.png"></span>
                <p><?php echo $transport; ?></p></div>
                <div><span><img src="images/ic3.png"></span>
                <p><?php echo $keeper; ?></p></div>
            </div>
            </div>
            <div class="row priceform">
            <div class="col-lg-4 col-md-3 col-sm-3 col-1"></div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-10">
                <form action="#" method="post">
                   <div class="row priceform">
                       <?php
                       if($seats!=0) {
                       ?>
                       <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                           <label class="pricelabel">Price per person</label>
                           <input type='text' id="price" value="<?php  echo $total; ?> " size="3" readonly="true">
                       
                       </div>
                       <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                           <input type="button" value="Book" id="bookings">
                       </div>
                       <?php
                       } else {
                       ?>
                       <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                           <label class="soldout">Sold Out</label>
                          
                       
                       </div>
                       <?php
                       }
                       ?>
                   </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-3 col-1"></div>
        </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo JURI::root(); ?>addons/popupjs/style.css">

<script src="<?php echo JURI::root(); ?>addons/popupjs/modernizr.js"></script>

<script>
/*********************Slider************************/
var firstjq=jQuery.noConflict();
firstjq(document).ready(function()
{
    var owl = firstjq('.owl-carouseb');
    owl.owlCarousel(
        {
            items: 1,
            margin: 10,
            autoplay: true,
            autoPlay: 4000, //Set AutoPlay to 3 seconds
            dots: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            loop : false,
            responsive: {
                300: {
                    items:1,
                },
                320: {
                    items:1,
                },
                480: {
                    items:1,
                },
                720:
                {
                    items:1,
                },
        1000:
                {
                    items:1,
        }
            }
        });
    }
);
/****************slider end*********************/

/*********************Calculation of no. of people and room********************/

function incrValue() {
    var total = parseInt(document.getElementById('price').value, 10);
    var seat_available = <?php echo $seats; ?>;
    var pp = <?php echo $price_person; ?>;
    var pr = <?php echo $cost_hotel; ?>;
    var room = parseInt(document.getElementById('room').value, 10);
    var people = parseInt(document.getElementById('number').value, 10);
    if(people!=seat_available) {
        people++;
        var price = total + pp;
    } else {
        var tpp = people * pp;
        var tpr = room * pr;
        var price = tpp + tpr
    }
    if(people > room) {
        room++;
        var price = price + pr;
    }
    document.getElementById('number').value = people;
    document.getElementById('room').value = room;
    //document.getElementById('price').value = price;
}
function decrValue() {
    var pp = <?php echo $price_person; ?>;
    var pr = <?php echo $cost_hotel; ?>;
    var total = parseInt(document.getElementById('price').value, 10);
    var value = parseInt(document.getElementById('number').value, 10);
    var room = parseInt(document.getElementById('room').value, 10);
    valueh = value/3;
    valueh = Math.ceil(valueh);

    if(value!=2 || value == room) {
        value--;
        room--;
    var price = total - pp;
    var price = price - pr;

    //  alert(room);
    }
    else if(value!=1) {
        value--;
    }
    if(value==0) {
        value++;
        room = 1;
    }
    if(valueh != room) {
        room++;
    }

    if(value <= room)
    {
        room--;
    }
    if (value == 1) {
        room = 1;
        price = pp + pr;
    }
    if(value && room) {
        var tpp = value * pp;
        var tpr = room * pr;
        var price = tpp + tpr;
    }
    document.getElementById('number').value = value;
    //document.getElementById('price').value = price;
    document.getElementById('room').value = room;
}
function incrrValue() {
    var people = parseInt(document.getElementById('number').value, 10);
    var pp = <?php echo $price_person; ?>;
    var pr = <?php echo $cost_hotel; ?>;
    var total = parseInt(document.getElementById('price').value, 10);
    var seat_available = "<?php echo $seats; ?>";
    var room = parseInt(document.getElementById('room').value, 10);

    if(room < people) {
    room++;
    //price = total + pr;
    }
    if(people && room) {
        var tpp = people * pp;
        var tpr = room * pr;
        var price = tpp + tpr;
    }
    //document.getElementById('price').value = price;
    document.getElementById('room').value = room;
}
function decrrValue() {
    var pp = <?php echo $price_person; ?>;
    var pr = <?php echo $cost_hotel; ?>;
    var total = parseInt(document.getElementById('price').value, 10);
    var room = parseInt(document.getElementById('room').value, 10);
    var peoples = parseInt(document.getElementById('number').value, 10);
    people = peoples/3;
    people = Math.ceil(people);
    if(room!=1) {
        room--;
    }
    if (room == people) {
        room = people;
    } else if (room <=people) {
        room = people;
    }
    if(peoples && room) {
        var tpp = peoples * pp;
        var tpr = room * pr;
        var price = tpp + tpr;
    }
    document.getElementById('room').value = room;
    //document.getElementById('price').value = price;
}
jQuery('body').on('click', '#dec', function(){
    var pp = <?php echo $price_person; ?>;
    var pr = <?php echo $cost_hotel; ?>;
    var room = parseInt(document.getElementById('room').value, 10);
    var peoples = parseInt(document.getElementById('number').value, 10);
    var price=((peoples*pp)+(room*pr))/peoples;
    //price=price*peoples;
    price= Math.round(price);
    document.getElementById('price').value = price;

});
jQuery('body').on('click', '#inc', function(){
    var pp = <?php echo $price_person; ?>;
    var pr = <?php echo $cost_hotel; ?>;
    var room = parseInt(document.getElementById('room').value, 10);
    var peoples = parseInt(document.getElementById('number').value, 10);
    var price=((peoples*pp)+(room*pr))/peoples;
    //price=price*peoples;
    price= Math.round(price);
    document.getElementById('price').value = price;
});
jQuery('body').on('click', '#decr', function(){
    var pp = <?php echo $price_person; ?>;
    var pr = <?php echo $cost_hotel; ?>;
    var room = parseInt(document.getElementById('room').value, 10);
    var peoples = parseInt(document.getElementById('number').value, 10);
    var price=((peoples*pp)+(room*pr))/peoples;
    //price=price*peoples;
    price= Math.round(price);
    document.getElementById('price').value = price;
});
jQuery('body').on('click', '#incr', function(){
    var pp = <?php echo $price_person; ?>;
    var pr = <?php echo $cost_hotel; ?>;
    var room = parseInt(document.getElementById('room').value, 10);
    var peoples = parseInt(document.getElementById('number').value, 10);
    var price=((peoples*pp)+(room*pr))/peoples;
    //price=price*peoples;
    price= Math.round(price);
    document.getElementById('price').value = price;
});

/*********************End****************************/
</script>
<script>
var book=jQuery.noConflict();
book(document).ready(function(){

book('body').on('click', '#bookings', function(){
    var user = <?php echo $user_id; ?>;
    var pageid = <?php echo $id ?>;
    var date = "<?php echo $date ?>";
    var type = <?php echo $type ?>;
    var seat = <?php echo $seats ?>;
    var price = document.getElementById('price').value;
    var people = document.getElementById('number').value;
    var room = document.getElementById('room').value;
    book.post("index.php?option=com_fixed_trip&task=create_days.saveSess&pageid="+pageid+"&date="+date+"&people="+people+"&room="+room+"&price="+price+"&type="+type+"&seat="+seat,storedataf);
    });
    function storedataf(stext,status)
    {
        if(status=='success')
        {
            var user = <?php echo $user_id; ?>;
            if (user == 0) {
                $( ".lp-wrapper" ).addClass( "lp-open" );
                $( "#lp-overlay" ).addClass( "lp-open" );
            } else {

                    var user = <?php echo $user_id; ?>;
                    var seat = <?php echo $seat_available; ?>;
                    var id = <?php echo $id; ?>;
                    var title = "<?php echo $title; ?>";
                    var date = $('#date').val();
                    var type = <?php echo $type ?>;
                    var no_of_people = $('#number').val();
                    var no_of_room = $('#room').val();
                    var price = $('#price').val();
                    var cost_hotel = "<?php echo $cost_hotel; ?>";
                    var cost_activites = "<?php echo $cost_activites; ?>";
                    var cost_transport = "<?php echo $cost_transport; ?>";
                    var cost_keeper = "<?php echo $cost_keeper; ?>";
                    var cost_booking_fee = "<?php echo $cost_booking_fee; ?>";
                    var cost_insurance = "<?php echo $cost_insurance; ?>";
                    var extracosti = "<?php echo $extracosti; ?>";
                    var extracostii = "<?php echo $extracostii; ?>";
                    var pdfplanning = "<?php echo $pdfplanning; ?>";
                    var keeper = "<?php echo $keeper; ?>";
                    var transport = "<?php echo $transport; ?>";
                    var hotel = "<?php echo $hotel; ?>";
                    var planning = "<?php echo $planid; ?>";
                    var no_of_days = "<?php echo $ndays; ?>";

                    book.post("index.php?option=com_fixed_trip&task=create_days.storedata&user="+user+"&id="+id+"&title="+title+"&date="+date+"&type="+type+"&no_of_people="+no_of_people+"&no_of_room="+no_of_room+"&price="+price+"&cost_hotel="+cost_hotel+"&cost_activites="+cost_activites+"&cost_transport="+cost_transport+"&cost_keeper="+cost_keeper+"&cost_booking_fee="+cost_booking_fee+"&cost_insurance="+cost_insurance+"&extracosti="+extracosti+"&extracostii="+extracostii+"&pdfplanning="+pdfplanning+"&keeper="+keeper+"&transport="+transport+"&hotel="+hotel+"&planning="+planning+"&no_of_days="+no_of_days,successst);
                }
            }
        }
        function successst(stext,status) {
            if(status=='success') {
                if(stext=='no') {
                    alert("Only two quotes available. After completion of those then only you eligible to quote");
                } else {
                    jQuery(".cd-popup").addClass("is-visible");
                    document.getElementById('lastinsertedid').value=stext;   
                    jQuery(".payment_description").html("");
                }
                
            }
        }
});
</script>
<div class="cd-popup" role="alert">
    <div class="cd-popup-container">
        <div class="popuppay">
        <div class="popupbanner"><img src="images/popupb.png"></div>
        <div class="popupcnt">
        <a href="#0" class="cd-popup-close img-replace" id="popup_close">Close</a>
        <div class="paymentgateway">

           <form name="paymntform" action="#" method="post" enctype="multipart/form-data" id="pay">

            <div class="paymentflight">
            <label>Flight</label><select id="flight" name="flight">
                        <option value="" id="desc"></option>
                <?php
                $avail_fligt="SELECT * FROM `#__fixed_trip_flight` WHERE state='1'";
                $db->setQuery($avail_fligt);
                $result=$db->loadObjectList();
                foreach ($result as $value) {
                $flight=$value->title;
                 echo '<option value="'.$flight.'">'.$flight.'</option>';
                }
                ?>
                <option value="No">No</option>
            </select>
         </div>
                  <div id="flightdept" class="paymentdept" style="display: block;">
             <label>Place of Departure</label>
             <select id="place" name="place">
                 <option value=""></option>
             <?php
                $avail_fligt="SELECT * FROM `#__fixed_trip_place_departures` WHERE state='1'";
                $db->setQuery($avail_fligt);
                $result=$db->loadObjectList();

                foreach ($result as $value) {
                $place=$value->title;
                 echo '<option value="'.$place.'">'.$place.'</option>';
                }
                ?>
             </select>
         </div>
         <div id="pymnt">
             <label>Payment Solution</label>
            <select id="paymethod" name="paymethod" required="true">
                <option value=""></option>
                <option value="Normal">Normal</option>
                <option value="Split">Split</option>
                <?php
                    $sql="SELECT f_final_inst_date FROM `#__common_price_management` where state=1";
                    $db->setQuery($sql);
                    $lastdays=$db->loadResult();

                    $datestr=$date." 00:00:00";
                     $date=strtotime($datestr);

                   $diff=$date-time();
                   $days=floor($diff/(60*60*24));
                if($lastdays<$days) {
                ?>
                <option value="Participative">Participative</option>
                <?php
                }
                ?>
            </select>
            <input type="hidden" value="" id="lastinsertedid" name="lastinsertedid">

         </div>

            <input type="hidden" value="com_users" name="option">
            <input type="hidden" value="user.fixed_trip" name="task"> 
            <input type="Submit" value="Submit" id="request_quote">

     </form>
 </div>
 <div class="paymethod1" id="paymethod1">
     <span><img src="images/p1.png"></span><br/>
     <span><img src="images/p2.png"></span><br/>
     <span><img src="images/p3.png"></span><br/>
     <span><img src="images/p4.png"></span><br/>
     <span><img src="images/p5.png"></span><br/>
 </div>

 <h3 class="sel_opt">please select your option</h3>
 <div class="payment_description"></div>
</div>
</div>
</div>
</div>
<script src="<?php echo JURI::root(); ?>addons/popupjs/main.js"></script>
<script>
    jQuery(document).ready(function(){
        book('body').on('click', '#popup_close', function(){
            var lastinsertedid = jQuery("#lastinsertedid").val();
            jQuery.post("index.php?option=com_fixed_trip&task=create_days.deletelast&lastinsertedid="+lastinsertedid);
        });
    jQuery('body').on('change', '#flight', function(event) {
        var selected_option = jQuery('#paymethod').val();
        var lastinsertedid = jQuery("#lastinsertedid").val();
        var flight_option = jQuery(this).val();
       /* if(flight_option == 'No') {

           $("#pay").attr("action", "<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment");
        } else {
           $("#pay").attr("action", "<?php echo JURI::root(); ?>index.php?option=com_users&view=profile");
           
        }*/
        jQuery.post("index.php?option=com_fixed_trip&task=create_days.paymentMessage&selected_option="+selected_option+"&flight_option="+flight_option+"&lastinsertedid="+lastinsertedid,displayPaymsg);
    });
    jQuery('body').on('change', '#paymethod', function(event) {
        var selected_option = jQuery(this).val();
        var flight_option = jQuery('#flight').val();

        var lastinsertedid = jQuery("#lastinsertedid").val();

        jQuery.post("index.php?option=com_fixed_trip&task=create_days.paymentMessage&selected_option="+selected_option+"&flight_option="+flight_option+"&lastinsertedid="+lastinsertedid,displayPaymsg);
    });
    function displayPaymsg(stext,status)
    {
        if(status=='success')
        {
              jQuery(".payment_description").html(stext);
              jQuery("#paymethod1").css("display" , "none");
                    jQuery(".sel_opt").css("display" , "none");
        
        }
    }
    jQuery('body').on('click', '#request_quote', function(event) {
        var paymethod = jQuery('#paymethod').val();
        var flight_option = jQuery('#flight').val();

        var place = jQuery("#place").val();
        var lastinsertedid = jQuery("#lastinsertedid").val();

        //jQuery.post("index.php?option=com_fixed_trip&task=create_days.update&paymethod="+paymethod+"&flight_option="+flight_option+"&lastinsertedid="+lastinsertedid+"&place="+place,update);
    });
    function update(stext,status)
    {
        if(status=='success')
        {

        }
    }
});
/************display session values if available***************/

$(function ()
{
    var date = "<?php echo $sessdate; ?>";
    var no_pers = "<?php echo $sessno_of_per; ?>";
    var no_rooms = "<?php echo $sessno_of_room; ?>";
    var price = "<?php echo $sessprice; ?>";
    var sspageid = "<?php echo $sesspageidd; ?>";
    var pageid = <?php echo $id; ?>;
    var type = "<?php echo $sesshotel; ?>";
    var seat = "<?php echo $sessseat; ?>";
  if(pageid == sspageid){

    $('input#number').val(no_pers);
    $('input#room').val(no_rooms);
    $('input#price').val(price);
}
});
/********************* display session value end******************/
</script>

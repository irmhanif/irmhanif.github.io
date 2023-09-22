<?php

/**
 * @package        Joomla.Site
 * @subpackage    com_users
 * @copyright    Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 * @since        1.6
 */
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
$db = JFactory::getDbo();
$user = JFactory::getUser();
$user_id = $user->id;
$qlimit = JRequest::getvar('quote');
$urlid = JRequest::getvar('urlid');
$linki = JRequest::getvar('urlid');
$quote_status = JRequest::getvar('qts');
$t = JRequest::getvar('t');
if ($t == '') {
    $t = 1;
}
if ($quote_status == '') {
    $quote_status = 1;
}
date_default_timezone_set("Asia/Kolkata");
$ckhtym = date('Y-m-d H:i:s');

$qlimit = 1;
$color = $colors = 'normal';
$sqlc = "SELECT * FROM `#__users` WHERE id=$user_id";
$db->setQuery($sqlc);
$users_detailc = $db->loadObjectList();
foreach ($users_detailc as $user_dispc) {
    $username = $user_dispc->name;
    $name = $user_dispc->name;
    $lname = $user_dispc->lname;
    $contact = $user_dispc->phone;
    $mail = $user_dispc->email;
}
if ($urlid == '') {

    $sharepayorderc = "SELECT id FROM `#__customized_order` WHERE uid=$user_id";
    $db->setQuery($sharepayorderc);
    $sharepayorder_count = $db->loadResult();

    $sharepayorders = "SELECT id FROM `#__semicustomized_order` WHERE uid=$user_id";
    $db->setQuery($sharepayorders);
    $sharepayorders_count = $db->loadResult();

    $sql_fix = "SELECT id FROM `#__fixed_trip_orders` WHERE uid=$user_id";
    $db->setQuery($sql_fix);
    $fixed_order_count = $db->loadResult();

    if ($sharepayorder_count != 0) {
        $sharepayorder = "SELECT * FROM `#__customized_order` WHERE uid=$user_id ORDER BY id DESC";
        $db->setQuery($sharepayorder);
        $sharepayorders = $db->loadObjectList();
        foreach ($sharepayorders as $sharepayorders_disp) {
            $urlid = $sharepayorders_disp->id;
            $linki = $sharepayorders_disp->id;
            $t = 1;
        }
    } else if ($sharepayorders_count != 0) {
        $sharepayorder = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id";
        $db->setQuery($sharepayorder);
        $sharepayorders = $db->loadObjectList();
        foreach ($sharepayorders as $sharepayorders_disp) {
            $urlid = $sharepayorders_disp->id;
            $linki = $sharepayorders_disp->id;
            $t = 2;
        }
    } else if ($fixed_order_count != 0) {
        $sharepayorder = "SELECT * FROM `#__fixed_trip_orders` WHERE uid=$user_id";
        $db->setQuery($sharepayorder);
        $sharepayorders = $db->loadObjectList();
        foreach ($sharepayorders as $sharepayorders_disp) {
            $urlid = $sharepayorders_disp->id;
            $linki = $sharepayorders_disp->id;
            $t = 3;
        }
    } else {
        $urlid = '1';
    }
}
?>
<link rel="stylesheet" href="addons/angular/css/style.css">
<div class="innerpage_banner2">
    <div class="item">
        <img src="images/pro.png" alt="">
    </div>
</div>
<div class="dp_page">
    <div class="profile">

            <div class="drop_list">
      <div class="dropdown_meu">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">TOUR BOOKING
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li>
 <?php
$sharepayorderc = "SELECT id FROM `#__customized_order` WHERE uid=$user_id";
$db->setQuery($sharepayorderc);
$sharepayorder_count = $db->loadResult();

$sharepayorders = "SELECT id FROM `#__semicustomized_order` WHERE uid=$user_id";
$db->setQuery($sharepayorders);
$sharepayorders_count = $db->loadResult();

$sql_fix = "SELECT id FROM `#__fixed_trip_orders` WHERE uid=$user_id";
$db->setQuery($sql_fix);
$fixed_order_count = $db->loadResult();

if ($sharepayorder_count != 0) {
    $qt = 0;
    $sharepayorder = "SELECT * FROM `#__customized_order` WHERE uid=$user_id";
    $db->setQuery($sharepayorder);
    $sharepayorders = $db->loadObjectList();
    echo '<h1 class="pro_title">Customized Trip</h1>';
    foreach ($sharepayorders as $sharepayorders_disp) {
        $qt++;
        $share_orderid1 = $sharepayorders_disp->id;
        $id = $sharepayorders_disp->id;
        if ($linki == $id && $t == 1) {
            $act = 'act';
        } else {
            $act = 'norm';
        }
        echo '<li class="' . $act . '"><a href="' . JURI::root() . 'index.php?option=com_users&view=profile&t=1&urlid=' . $id . '">Quote ' . $qt . '</a></li>';
    }
}
if ($sharepayorders_count != 0) {
    $sharepayorder = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id GROUP BY quote_status";
    $db->setQuery($sharepayorder);
    echo '<h1 class="pro_title">Semi Customized Trip</h1>';
    $sharepayorders = $db->loadObjectList();
    foreach ($sharepayorders as $semi) {
        $qt = $semi->quote_status;
        if ($quote_status == $qt && $t == 2) {
            $act = 'act';
        } else {
            $act = 'norm';
        }
        echo '<li class="' . $act . '"><a href="' . JURI::root() . 'index.php?option=com_users&view=profile&t=2&urlid=0&qts=' . $qt . '">Quote ' . $qt . '</a></li>';
    }
}
if ($fixed_order_count != 0) {
    $qt = 0;
    $sharepayorder = "SELECT * FROM `#__fixed_trip_orders` WHERE uid=$user_id AND trip_status!=''";
    $db->setQuery($sharepayorder);
    echo '<h1 class="pro_title">Fixed Trip</h1>';
    $sharepayorders = $db->loadObjectList();
    foreach ($sharepayorders as $sharepayorders_disp) {
        $qt++;
        $id = $sharepayorders_disp->id;
        if ($linki == $id && $t == 3) {
            $act = 'act';
        } else {
            $act = 'norm';
        }
        echo '<li class="' . $act . '"><a href="' . JURI::root() . 'index.php?option=com_users&view=profile&t=3&urlid=' . $id . '">Quote ' . $qt . '</a></li>';
    }
}
                               // echo '<li><a href="' . JURI::root() . 'index.php?option=com_users&view=profile&quote=1">Quote 1</a></li>';
                               // echo '<li><a href="' . JURI::root() . 'index.php?option=com_users&view=profile&quote=2">Quote 2</a></li>';
?>


      </li>
      <p class="data_div"></p>
      <li>  <button type="submit" class="f90-logout-button button c-menu__link">Log out</button></li>
            <p class="data_div"></p>
               <h1 class="pro_title" >For Any Queries</h1>
                                  <li><a href="tel:+91 9901033838">Call Now</a></li>
                            <li><a href="mailto:reachus@francebyfrench-services.com">Email Now</a></li>
    </ul>
  </div>
  </div>


        <div class="profile1">
            <div class="profilepage">
                <div class="account">
                    <h1><?php echo $name . ' ' . $lname; ?></h1>
                    <h1>Dashboard</h1>
                    <ul>
                        <li><a href="<?php echo JRoute::_('index.php?option=com_users&task=profile.edit&user_id=' . (int)$this->data->id); ?>">Edit Profile</a></li>

                    </ul>
                </div>
                <div class="tour_booking">
                    <div class='tabs'>
                        <h1>TOUR BOOKING</h1>
                        <ul>
                            <?php
                            $sharepayorderc = "SELECT id FROM `#__customized_order` WHERE uid=$user_id";
                            $db->setQuery($sharepayorderc);
                            $sharepayorder_count = $db->loadResult();

                            $sharepayorders = "SELECT id FROM `#__semicustomized_order` WHERE uid=$user_id";
                            $db->setQuery($sharepayorders);
                            $sharepayorders_count = $db->loadResult();

                            $sql_fix = "SELECT id FROM `#__fixed_trip_orders` WHERE uid=$user_id";
                            $db->setQuery($sql_fix);
                            $fixed_order_count = $db->loadResult();

                            if ($sharepayorder_count != 0) {
                                $qt = 0;
                                $sharepayorder = "SELECT * FROM `#__customized_order` WHERE uid=$user_id";
                                $db->setQuery($sharepayorder);
                                $sharepayorders = $db->loadObjectList();
                                echo '<h1>Customized Trip</h1>';
                                foreach ($sharepayorders as $sharepayorders_disp) {
                                    $qt++;
                                    $share_orderid1 = $sharepayorders_disp->id;
                                    $id = $sharepayorders_disp->id;
                                    if ($linki == $id && $t == 1) {
                                        $act = 'act';
                                    } else {
                                        $act = 'norm';
                                    }
                                    echo '<li class="' . $act . '"><a href="' . JURI::root() . 'index.php?option=com_users&view=profile&t=1&urlid=' . $id . '">Quote ' . $qt . '</a></li>';
                                }
                            }
                            if ($sharepayorders_count != 0) {
                                $sharepayorder = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND quote_status!='' GROUP BY quote_status";
                                $db->setQuery($sharepayorder);
                                echo '<h1>Semi Customized Trip</h1>';
                                $sharepayorders = $db->loadObjectList();
                                foreach ($sharepayorders as $semi) {
                                    $qt = $semi->quote_status;
                                    if ($quote_status == $qt && $t == 2) {
                                        $act = 'act';
                                    } else {
                                        $act = 'norm';
                                    }
                                    echo '<li class="' . $act . '"><a href="' . JURI::root() . 'index.php?option=com_users&view=profile&t=2&urlid=0&qts=' . $qt . '">Quote ' . $qt . '</a></li>';
                                }
                            }
                            if ($fixed_order_count != 0) {
                                $qt = 0;
                                $sharepayorder = "SELECT * FROM `#__fixed_trip_orders` WHERE uid=$user_id AND trip_status!=''";
                                $db->setQuery($sharepayorder);
                                echo '<h1>Fixed Trip</h1>';
                                $sharepayorders = $db->loadObjectList();
                                foreach ($sharepayorders as $sharepayorders_disp) {
                                    $qt++;
                                    $id = $sharepayorders_disp->id;
                                    if ($linki == $id && $t == 3) {
                                        $act = 'act';
                                    } else {
                                        $act = 'norm';
                                    }
                                    echo '<li class="' . $act . '"><a href="' . JURI::root() . 'index.php?option=com_users&view=profile&t=3&urlid=' . $id . '">Quote ' . $qt . '</a></li>';
                                }
                            }
                               // echo '<li><a href="' . JURI::root() . 'index.php?option=com_users&view=profile&quote=1">Quote 1</a></li>';
                               // echo '<li><a href="' . JURI::root() . 'index.php?option=com_users&view=profile&quote=2">Quote 2</a></li>';
                            ?>
                        </ul>
                    </div>
                    <div class="sign_out">

                        <div class="logout">
		                  <div class="c-menu__item">
			              <button type="submit" class="f90-logout-button button c-menu__link">Log out</button>	</div>

                         </div>

                    </div>
                    <div class="acc_help">
                        <ul class="queries">
                        <h1>For Any Queries</h1>
                            <li><a href="tel:+91 9901033838">+91 9901033838</a></li>
                            <li><a href="mailto:reachus@francebyfrench-services.com">reachus@francebyfrench-services.com</a></li>
                        </ul>
                                                <ul class="queries1">
                        <h1>For Any Queries</h1>
                            <li><a href="tel:+91 9901033838">Call Now</a></li>
                            <li><a href="mailto:reachus@francebyfrench-services.com">Email Now</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    $bor1 = $bor2 = $bor3 = $bor4 = $bor5 = $bor6 = 'prcircr';
     $nowdate = date('Y-m-d');
                if ($t == 1) {
                    $sqlx = "SELECT * FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id";
                    $db->setQuery($sqlx);
                    $final_detail = $db->loadObjectList();
                    foreach ($final_detail as $cust) {
                        $date = $cust->dateofdeparture;
                        $ndays = $cust->no_days;
                        $psts = $cust->payment_status;
                        $date = date("Y-m-d", strtotime("$date +$ndays day"));
                    }
                } else if ($t == 2) {
                    $sqls = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND quote_status=$quote_status";
                    $db->setQuery($sqls);
                    $final_details = $db->loadObjectList();
                    foreach ($final_details as $semi) {
                        $date = $semi->trip_date;
                        $ndays = $semi->noofdays;
                        $psts = $semi->payment_status;
                        $date = date("Y-m-d", strtotime("$date +$ndays day"));
                    }
                } else if ($t == 3) {
                    $sqlf = "SELECT * FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid=$user_id AND payment_status='final_installment'";
                    $db->setQuery($sqlf);
                    $final_detailf = $db->loadObjectList();
                    foreach ($final_detailf as $fixed) {
                        $date = $fixed->pack_date;
                        $ndays = $fixed->no_of_days;
                        $psts = $fixed->payment_status;
                        $date = date("Y-m-d", strtotime("$date +$ndays day"));
                    }
                }
                if (($nowdate >= $date)&&($psts=='final_installment') ) {
                    $bor6 = "prcirc";
                }
    if ($t == 1) {
        $sharepayorderc = "SELECT * FROM `#__customized_order` WHERE id=$urlid";
        $db->setQuery($sharepayorderc);
        $res = $db->loadObjectList();
        foreach ($res as $result) {
            $id = $result->id;
            $payst = $result->payment_status;
            $tripst = $result->trip_status;
            $id = $result->id;
        }

     $sql_documentc = "SELECT COUNT(id) FROM `#__document_communication` WHERE user_id=$user_id AND quote='c-$urlid' AND t='Customized'";
                    $db->setQuery($sql_documentc);
                    $document_count = $db->loadResult();

            $bor1 = "prcirc";

        if ($tripst != '') {
            $bor1 = "prcirc";
            $bor2 = "prcirc";
        }
        if ($payst == 'first_installment') {
            $bor1 = "prcirc";
            $bor2 = "prcirc";
            $bor3 = "prcirc";
        }
        if ($payst == 'final_installment') {
            $bor1 = "prcirc";
            $bor2 = "prcirc";
            $bor3 = "prcirc";
            $bor4 = "prcirc";
        }
        if ($document_count != 0) {
            $bor5 = "prcirc";
        }

    }
    if ($t == 2) {
        $sharepayorders = "SELECT * FROM `#__semicustomized_order` WHERE quote_status=$quote_status";
        $db->setQuery($sharepayorders);
        $res = $db->loadObjectList();
        foreach ($res as $result) {
            $id = $result->id;
            $payst = $result->payment_status;
            $tripst = $result->trip_status;
            $id = $result->id;
        }
         $quote_statusfordocument = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND quote_status=$quote_status";
                    $db->setQuery($quote_statusfordocument);
                    $quote_status_id = $db->loadObjectList();

                    foreach ($quote_status_id as $quote_status_id_disp) {
                        $document_qute_id = $quote_status_id_disp->id;
                    }

        $sql_documentc2 = "SELECT COUNT(id) FROM `#__document_communication` WHERE user_id=$user_id AND quote='s-$document_qute_id' AND t='Semi_Customized'";
                    $db->setQuery($sql_documentc2);
                    $document_count2 = $db->loadResult();
        if ($payst == 'finalizebyuser') {
            $bor1 = "prcirc";
        }
        if ($tripst != '') {
            $bor1 = "prcirc";
            $bor2 = "prcirc";
        }
        if ($payst == 'first_installment') {
            $bor1 = "prcirc";
            $bor2 = "prcirc";
            $bor3 = "prcirc";
        }
        if ($payst == 'final_installment') {
            $bor1 = "prcirc";
            $bor2 = "prcirc";
            $bor3 = "prcirc";
            $bor4 = "prcirc";
        }
        if ($document_count2 != 0) {
            $bor5 = "prcirc";
        }
    }
    if ($t == 3) {
        $sql_fix = "SELECT * FROM `#__fixed_trip_orders` WHERE id=$urlid";
        $db->setQuery($sql_fix);
        $res = $db->loadObjectList();
        foreach ($res as $result) {
            $id = $result->id;
            $payst = $result->payment_status;
            $tripst = $result->trip_status;
            $fixed = $result->final_installment;
        }
$sql_documentc3 = "SELECT COUNT(id) FROM `#__document_communication` WHERE user_id=$user_id AND quote='f-$urlid' AND t='Fixed'";
                    $db->setQuery($sql_documentc3);
                    $document_count3 = $db->loadResult();
        if ($payst == 'initialized') {
            $bor1 = "prcirc";
        }
        if ($fixed != '') {
            $bor1 = "prcirc";
            $bor2 = "prcirc";
        }
        if ($payst == 'first_installment') {
            $bor1 = "prcirc";
            $bor2 = "prcirc";
            $bor3 = "prcirc";
        }
        if ($payst == 'final_installment') {
            $bor1 = "prcirc";
            $bor2 = "prcirc";
            $bor3 = "prcirc";
            $bor4 = "prcirc";
        }
        if ($document_count3 != 0) {
            $bor5 = "prcirc";
        }
    }
    ?>
    <link rel="stylesheet" href="addons/angular/css/style.css">
    <div class="profile_right">

        <div ng-app='tabs' ng-controller='tabCtrl'>
            <div class='tabs protabs'>
	<div class="pro_img">
             <span ng-class="{'active': (selected == '1')}" ng-click='selected=1'><img  class="<?php echo $bor1; ?>" src="images/pp1.png"><span class="spantittle">Quotation Request</span></span>
             <span class="les"><img src="images/b1.png"> </span>
              <span ng-class="{'active': (selected == '2')}" ng-click='selected=2'><img class="<?php echo $bor2; ?>" src="images/pp2.png"><span class="spantittle">Final Quotation</span></span>
              <span class="les"><img src="images/b1.png"></span>
               <span ng-class="{'active': (selected == '3')}" ng-click='selected=3'><img class="<?php echo $bor3; ?>" src="images/pp3.png"><span class="spantittle">First Installment</span></span>
               <span class="les"><img src="images/b1.png"></span>
                <span  ng-class="{'active': (selected == '4')}" ng-click='selected=4' ><img class="<?php echo $bor4; ?>" src="images/pp4.png"><span class="spantittle">Final Installment</span></span>
               <span class="les"><img src="images/b1.png"></span>
                <span ng-class="{'active': (selected == '5')}" ng-click='selected=5'><img class="<?php echo $bor5; ?>" src="images/pp5.png"><span class="spantittle">Document</span></span>
                <span class="les"><img src="images/b1.png"></span>
                <span ng-class="{'active': (selected == '6')}" ng-click='selected=6'><img class="<?php echo $bor6; ?>" src="images/pp6.png"><span class="spantittle">Review</span></span>
	</div>
                <!-- <span ng-class="{'active': (selected == '1')}" ng-click='selected=1'>
                    <b>Quotation Request &nbsp;&nbsp;&nbsp;&nbsp;| </b>
                </span>
                <span ng-class="{'active': (selected == '2')}" ng-click='selected=2'>
                    <b>Final Quotation &nbsp;&nbsp;&nbsp;&nbsp;| </b>
                </span>
                <span ng-class="{'active': (selected == '3')}" ng-click='selected=3'>
                    <b>First Installment &nbsp;&nbsp;&nbsp;&nbsp;| </b>
                </span>
                <span ng-class="{'active': (selected == '4')}" ng-click='selected=4'>
                    <b>Final Installment &nbsp;&nbsp;&nbsp;&nbsp;| </b>
                </span>
                <span ng-class="{'active': (selected == '5')}" ng-click='selected=5'>
                    <b>Document &nbsp;&nbsp;&nbsp;&nbsp;| </b>
                </span>
                <span ng-class="{'active': (selected == '6')}" ng-click='selected=6'>
                    <b>Review &nbsp;&nbsp;&nbsp;&nbsp; </b>
                </span> -->
            </div>
            <div class='tab-content'>
                <!--Select1-->
                <div ng-show='selected == 1'>
                    <!--qrcs-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                        date_default_timezone_set("Asia/Kolkata");
                        $cflightprice = "SELECT COUNT(id) FROM `#__flight_price_update` WHERE uid=$user_id";
                        $db->setQuery($cflightprice);
                        $fight_count = $db->loadResult();
                        if ($fight_count != 0) {
                            $flightprice = "SELECT * FROM `#__flight_price_update` WHERE uid=$user_id";
                            $db->setQuery($flightprice);
                            $fight_price = $db->loadObjectList();
                            foreach ($fight_price as $fight_price_disp) {
                                $fzprice = $fight_price_disp->price;
                                $ztype = $fight_price_disp->type;
                                $flightprice_updated = $fight_price_disp->flightprice_updated;
                            }
                            $flightprice_updated;
                            $currentdate_time = date("Y-m-d H:i:s");
                        }
                        $sql = "SELECT COUNT(id) FROM `#__customized_order` WHERE uid=$user_id AND payment_status!='' LIMIT $qlimit";

                        $db->setQuery($sql);
                        $customized_order_count = $db->loadResult();
                        if ($urlid != '') {
                            $sql = "SELECT COUNT(id) FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id AND payment_status!=''";
                            $db->setQuery($sql);
                            $customized_count = $db->loadResult();
                        } else {
                            $customized_count = 0;
                        }
                        if ($t == 1) {

                            if ($customized_order_count != '0' || $customized_count != '0') {
                                $sql = "SELECT * FROM `#__customized_order` WHERE id='$urlid' AND uid=$user_id";
                                $db->setQuery($sql);
                                $event_detail = $db->loadObjectList();
                                foreach ($event_detail as $event_disp) {
                                    $orderid = $event_disp->id;
                                    $no_days = $event_disp->no_days;
                                    $no_people = $event_disp->no_people;
                                    $no_rooms = $event_disp->no_room;
                                    $budget = $event_disp->budget;
                                    $transport = $event_disp->transport;
                                    $stay = $event_disp->stay;
                                    $stay = str_replace('_', ' ', $stay);
                                    $flight = $event_disp->flight;
                                    $keeper = $event_disp->keeper;
                                    $payment_status = $event_disp->payment_status;
                                    $dateofdeparture = $event_disp->dateofdeparture;
                                    $dateofdeparture = date("d-m-Y", strtotime($dateofdeparture));
                                    $placeofdeparture = $event_disp->placeofdeparture;
                                    $write_us = $event_disp->write_us;
                                    $payment_type = $event_disp->payment_type;
                                echo '<div class="headings"><h1>Customized Trip</h1>
                                <p><b>Number of Days</b><span>:</span><span>' . $no_days . '</span></p>
                                <p><b>Number of People</b><span>:</span><span>' . $no_people . '</span></p>
                                <p><b>Number of Rooms</b><span>:</span><span>' . $no_rooms . '</span></p>
                                <p><b>Budget</b><span>:</span><span>' . $budget. '</span></p>
                                <p><b>Transport</b><span>:</span><span>' . $transport . '</span></p>
                                <p><b>Stay</b><span>:</span><span>' .$stay. '</span></p>
                                <p><b>Flight ticket</b><span>:</span><span>' .$flight. '</span></p>
                                <p><b>Keeper</b><span>:</span><span>' .$keeper. '</span></p>
                                <p><b>Date of Departure</b><span>:</span><span>' .$dateofdeparture. '</span></p>
                                <p><b>Place Of Departure</b><span>:</span><span>' .$placeofdeparture. '</span></p>
                                <p><b>Payment Type</b><span>:</span><span>' . $payment_type . '</span></p>
                                <span class="cwrite"><p><b>Write up:-</b>' . $write_us . '</p></span>
                                </div>';
                                }
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <!--qrce-->
                    <!--qrss-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php

                        $sqlz = "SELECT COUNT(id) FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                        $db->setQuery($sqlz);
                        $semicustomized_order_count = $db->loadResult();
                        if ($urlid != '') {
                            $sql = "SELECT COUNT(id) FROM `#__semicustomized_order` WHERE id=$urlid AND uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sql);
                            $scustomized_count = $db->loadResult();
                        } else {
                            $scustomized_count = 0;
                        }

                        if (($semicustomized_order_count != '0' || $scustomized_count != '0') && $t == 2) {
                            $sqlfirst = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sqlfirst);
                            $semi_orderfirstdetails = $db->loadObjectList();
                            foreach ($semi_orderfirstdetails as $semiorder_disp1) {
                               // $semiid = $semiorder_disp1->id;
                                $number_people1 = $semiorder_disp1->number_peoples;
                                $number_rooms1 = $semiorder_disp1->number_rooms;
                                $dateofdeparture1 = $semiorder_disp1->trip_date;
                                $flight1 = $semiorder_disp1->flight;
                                $place_of_dept1 = $semiorder_disp1->place_of_dept;
                                $paymethod1 = $semiorder_disp1->paymethod;
                                $noofdays1 = $semiorder_disp1->noofdays;
                                $trip_id1 = $semiorder_disp1->trip_id;
                                //$noofdays1++; $number_rooms1++;
                                //$number_people1++;

                            }
                            echo '<div class="headings"><h1>Semi Customized Trip</h1>
                            <div class="semi_maindet">
                            <p><span class="">Number of people </span><span>:</span><span>' . $number_people1 . '</span></p>
                            <p><span class="">Number of room </span><span>:</span><span>' . $number_rooms1 . '</span></p>
                            <p><span class="">Date of departure </span><span>:</span><span>' . $dateofdeparture1 . '</span></p>
                            <p><span class="">Flight ticket  </span><span>:</span><span>' . $flight1 . '</span></p>
                            <p><span class="">Place of departure </span><span>:</span><span>' . $place_of_dept1 . '</span></p>
                            <p><span class="">Payment solution</span><span>:</span><span>' . $paymethod1 . '</span></p>
                            <p><span class="">Total number of days</span><span>:</span><span>' . $noofdays1 . '</span></p>
                            </div>';

                            $sqltripdet2 = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sqltripdet2);
                            $tripdetails2 = $db->loadObjectList();
                            $package = 0;
                            foreach ($tripdetails2 as $tripdetails_disp2) {
                                $package++;
                                $noofdays = $tripdetails_disp2->noofdays;
                                $transport = $tripdetails_disp2->transport;
                                $hotel = $tripdetails_disp2->hotel;
                                $keeper_information = $tripdetails_disp2->keeper_information;
                                if ($transport == 'yes') {
                                    $transport = 'Private Transport';
                                } else {
                                    $transport = 'Public Transport';
                                }
                                if ($keeper_information == 'yes') {
                                    $keeper_information = 'With Keeper';
                                } else {
                                    $keeper_information = 'Without Keeper';
                                }
                                $trip_id = $tripdetails_disp2->trip_id;
                                $triptitle = "SELECT title FROM `#__semicustomized_trip` WHERE id=$trip_id";
                                $db->setQuery($triptitle);
                                $triptitle = $db->loadResult();
                                echo '<div class="semibookings">
                                <h3>' . $triptitle . ' </h3>
                                <p><span class="">Number of days</span><span>:</span><span class="">  ' . $noofdays . '</span></p>
                                <p><span class="">Transport </span><span>:</span><span class="">  ' . $transport . '</span></p>
                                <p><span class="">Hotel</span> <span>:</span><span class=""> ' . $hotel . '</span></p>
                                <p><span class="">keeper </span> <span>:</span><span class=""> ' . $keeper_information . '</span></p>
                                </div>';
                            }
                            // getting Quotation
                            $sql = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sql);
                            $semi_orderdetails = $db->loadObjectList();

                            $hotel_priceall = $cost_of_activitiesall = $cost_of_traferall = $pricetransferall = $keeper_amtall = $bookingtotalall = $insuranceall = 0;
                            $publictransportall = $price_of_leavingall = $cost_of_transferall = $transfer_departure_priceall = $totalpriceper_personall = 0;
                            $total_cost_tax_freeall=0;
                            $final_costall=0;
                            $gstall=0;

                            $totalpriceper_person_withgstall = $totalamtall = $totalprizeall = 0;
                            foreach ($semi_orderdetails as $semiorder_disp) {
                                $uid = $semiorder_disp->uid;
                                $booked_time = $semiorder_disp->booked_time;
                                $noofdays = $semiorder_disp->noofdays;
                                $dateofdeparture = $semiorder_disp->trip_date;
                                $trip_id = $semiorder_disp->trip_id;
                                $planid = $semiorder_disp->planid;
                                $number_rooms = $semiorder_disp->number_rooms;
                                $number_people = $semiorder_disp->number_peoples;
                                $keeper = $semiorder_disp->keeper_information;
                                $hotel = $semiorder_disp->hotel;
                                $transport = $semiorder_disp->transport;
                                $flight = $semiorder_disp->flight;
                                $paymethod = $semiorder_disp->paymethod;
                                $place_of_dept = $semiorder_disp->place_of_dept;
                                $hotel_price = $semiorder_disp->price_of_hotel;
                                $cost_of_activities = $semiorder_disp->cost_of_activities;
                                $cost_of_transport = $semiorder_disp->cost_of_transport;
                                $cost_of_Keeper = $semiorder_disp->cost_of_Keeper;
                                $cost_of_booking_fee = $semiorder_disp->cost_of_booking_fee;
                                $cost_of_insurance = $semiorder_disp->cost_of_insurance;
                                $transfer_departure_price = $semiorder_disp->transfer_departure_price;
                                $price_of_public_transport = $semiorder_disp->price_of_public_transport;
                                $price_of_leaving = $semiorder_disp->price_of_leaving;
                                $totalwithgroup = $semiorder_disp->total_cost_tax_free;
                                $totalwithgroupgst = $semiorder_disp->final_cost;
                                $sgst = $semiorder_disp->gst;
                                $sqlgst = "SELECT * FROM `#__common_price_management` WHERE state=1";
                                $db->setQuery($sqlgst);
                                $common_price_management_detail = $db->loadObjectList();
                                foreach ($common_price_management_detail as $pricemgt_disp) {
                                    $gst = $pricemgt_disp->gst;
                                }
                                $hotel_priceall += $hotel_price;
                                $cost_of_activitiesall += $cost_of_activities;
                                $cost_of_transferall += $cost_of_transport;
                                $keeper_amtall += $cost_of_Keeper;
                                $bookingtotalall += $cost_of_booking_fee;
                                $insuranceall += $cost_of_insurance;
                                $publictransportall += $price_of_public_transport;
                                $transfer_departure_priceall += $transfer_departure_price;
                                $price_of_leaving += $price_of_leaving;

                                $total_cost_tax_freeall+=$totalwithgroup;
                                $final_costall+=$totalwithgroupgst;

                                $hotel_priceall = $hotel_priceall;
                                $cost_of_activitiesall = $cost_of_activitiesall;
                                $cost_of_transferall = $cost_of_transferall;
                                $keeper_amtall = $keeper_amtall;
                                $bookingtotalall = $bookingtotalall;
                                $insuranceall = $insuranceall;
                                $publictransportall = $publictransportall / $number_people1;
                                $transfer_departure_priceall = $transfer_departure_priceall / $number_people1;
                                $price_of_leaving = $price_of_leaving / $number_people1;
                                $sgstg = $sgst;
                                $sgst = $sgst;


                                $gstall+=$sgst;

                                $totalcost = $totalwithgroup;
                                $totalcostwithgst = $totalcost + $gstall;
                                $totalwithgroupgst = $total_cost_tax_freeall + $gstall;
                                $travelprice = $cost_of_transferall + $transfer_departure_priceall + $price_of_leaving;


                                $hotel_priceall = round($hotel_priceall);
                                $finalgst=$gstall * $number_people1;
                            }
                            echo '<div class="semibookings">
                            <h3> Overall Quotation - Per Person </h3>
                            <p><span class="">Cost of Hotel</span>
                            <span>:</span><span class="">  ' . $hotel_priceall . '</span></p>
                            <p><span class="">Cost of activities </span>
                            <span>:</span><span class="">' . $cost_of_activitiesall . '</span></p>
                            <p><span class="">Cost of Transport</span>
                            <span>:</span><span class=""> ' . $travelprice . '</span></p>
                            <p><span class="">Cost of Keeper </span>
                            <span>:</span><span class=""> ' . $keeper_amtall . '</span></p>
                            <p><span class="">Cost of Booking fee</span>
                            <span>:</span><span class=""> ' . $bookingtotalall . '</span></p>
                            <p><span class="">Cost of Insurance</span>
                            <span>:</span><span class=""> ' . $insuranceall . '</span></p>
                            <p><span class="">Total Cost</span>
                            <span>:</span><span class="">  ' . $total_cost_tax_freeall . '</span></p>
                            <p><span class="">GST</span>
                            <span>:</span><span class=""> ' . $finalgst /$number_people1 . '</span></p>
                            <p><span class="">Total Cost with GST </span>
                            <span>:</span><span class="">' . $totalwithgroupgst . '</span></p>
                            </div>';
                            $totalwithgroup = $total_cost_tax_freeall * $number_people1 ;
                            $totalwithgroupgst = $final_costall * $number_people1;
                            echo '<div class="semibookings">
                             <h3> Overall Quotation for ' . $number_people1 . ' people </h3>
                             <p><span class="">Total Cost</span>
                             <span>:</span><span class="">  ' . $totalwithgroup . '</span></p>
                             <p><span class="">Total Cost with GST </span>
                             <span>:</span><span class="">' . $totalwithgroupgst . '</span></p>
                             </div>
                             </div>';
                        }
                        ?>
                        </div>
                    </div>
                    <!--qrse-->
                    <!--qrfs-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                        $sql_fix = "SELECT COUNT(id) FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid='$user_id'";

                        $db->setQuery($sql_fix);
                        $fixed_order_count = $db->loadResult();
                        if ($urlid != '') {
                            $sql = "SELECT COUNT(id) FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid=$user_id";
                            $db->setQuery($sql);
                            $fixed_count = $db->loadResult();
                        } else {
                            $fixed_count = 0;
                        }
                        if (($fixed_order_count != '0' || $fixed_count != '0') && $t == 3) {
                            $sql = "SELECT * FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid='$user_id'";
                            $db->setQuery($sql);
                            $fixedorders = $db->loadObjectList();
                            foreach ($fixedorders as $forders) {
                                $orderid = $forders->id;
                                $fno_days = $forders->no_of_days;
                                $fno_people = $forders->no_of_people;
                                $fno_rooms = $forders->no_of_room;
                                $fpack_title = $forders->pack_title;
                                $ftransport = $forders->transport;
                                $fstay = $forders->hotel;
                                $fflight = $forders->flight;
                                $fkeeper = $forders->keeper;
                                $fdateofdeparture = $forders->pack_date;
                                $fplaceofdeparture = $forders->place_of_dept;
                                $fpack_type = $forders->pack_type;
                                $fpayment_type = $forders->paymethod;
                                $fuid = $forders->uid;
                                $fpayment_status = $forders->payment_status;
                                $ftrip_status = $forders->trip_status;
                                $fprice_of_hotel = $forders->cost_of_hotel;
                                $fcost_of_activities = $forders->cost_of_activities;
                                $fcost_of_transport = $forders->cost_of_transport;
                                $fcost_of_Keeper = $forders->cost_of_keeper;
                                $fcost_of_booking_Fee = $forders->cost_of_booking_fee;
                                $fcost_of_insurance = $forders->cost_of_insurance;
                                $ftotal_cost_tax_free = $forders->total_price;
                                $ffinal_cost = $forders->total_price_gst;
                                $ffirst_installement = $forders->first_installment;
                                $ffinal_installement = $forders->final_installment;
                                $flast_day_for_final_installement = $forders->final_inst_date;
                                $flast_day_for_first_installement = $forders->first_inst_date;
                                $fgst = $forders->gst;
                                $fflight_amount = $forders->flight_price;
                                echo '<div class="headings"><h1>Fixed Trip</h1>
                                <p><b>Number of Days</b><span>:</span><span>' . $fno_days . '</span></p>
                                <p><b>Number of People</b><span>:</span><span>' . $fno_people . '</span></p>
                                <p><b>Number of Rooms</b><span>:</span><span>' . $fno_rooms . '</span></p>
                                <p><b>Pack Title</b><span>:</span><span>' . $fpack_title . '</span></p>
                                <p><b>Transport</b><span>:</span><span>' . $ftransport . '</span></p>
                                <p><b>Stay</b><span>:</span><span>' . $fstay . '</span></p>
                                <p><b>Flight ticket</b><span>:</span><span>' . $fflight . '</span></p>
                                <p><b>Keeper</b><span>:</span><span>' . $fkeeper . '</span></p>
                                <p><b>Date of Departure</b><span>:</span><span>' . $fdateofdeparture . '</span></p>
                                <p><b>Place Of Departure</b><span>:</span><span>' . $fplaceofdeparture . '</span></p>
                                <p><b>Payment Type</b><span>:</span><span>' . $fpayment_type . '</span></p>
                                </div>';

                                if ($fflight_amount == 0) {
                                    $fflight_amount = '';
                                }

                                if ($fprice_of_hotel == 0) {
                                    $fprice_of_hotel = '';
                                }

                                if ($fcost_of_activities == 0) {
                                    $fcost_of_activities = '';
                                }
                                if ($fcost_of_transport == 0) {
                                    $fcost_of_transport = '';
                                }
                                if ($fcost_of_Keeper == 0) {
                                    $fcost_of_Keeper = '';
                                }

                                if ($fcost_of_booking_Fee == 0) {
                                    $fcost_of_booking_Fee = '';
                                }
                                if ($fcost_of_insurance == 0) {
                                    $fcost_of_insurance = '';
                                }
                                if ($ftotal_cost_tax_free == 0) {
                                    $ftotal_cost_tax_free = '';
                                }

                                if ($fgst == 0) {
                                    $fgst = '';
                                }
                                if ($ffinal_cost == 0) {
                                    $ffinal_cost = '';
                                }
                                if ($ffirst_installement == 0) {
                                    $ffirst_installement = '';
                                }

                                if ($flast_day_for_first_installement == 0) {
                                    $flast_day_for_first_installement = '';
                                } else {
                                    $flast_day_for_first_installement = date("d-m-Y H:m", strtotime($flast_day_for_first_installement));

                                }

                                if ($ffinal_installement == 0) {
                                    $ffinal_installement = '';
                                }


                                if ($flast_day_for_final_installement == 0) {
                                    $flast_day_for_final_installement = '';
                                } else {
                                    $flast_day_for_final_installement = date("d-m-Y H:m", strtotime($flast_day_for_final_installement));
                                }


                                $sql = "SELECT * FROM `#__users` WHERE id=$fuid";
                                $db->setQuery($sql);
                                $events_detail = $db->loadObjectList();
                                foreach ($events_detail as $event_disp) {
                                    $userid = $event_disp->id;
                                    $username = $event_disp->name;
                                    $contact = $event_disp->phone;
                                    $mail = $event_disp->email;
                                }

                                $fhotel_price_group = $fprice_of_hotel * $fno_people;
                                $factivities_price_group = $fcost_of_activities * $fno_people;
                                $ftransport_price_group = $fcost_of_transport * $fno_people;
                                $fkeeper_price_group = $fcost_of_Keeper * $fno_people;
                                $fbooking_price_group = $fcost_of_booking_Fee * $fno_people;
                                $finsurance_price_group = $fcost_of_insurance * $fno_people;
                                $ftaxfree_price_group = $ftotal_cost_tax_free * $fno_people;
                                $fgst_price_group = $fgst * $fno_people;
                                $ffinal_price_group = $ffinal_cost * $fno_people;
                                echo '<div class="display_quote">
                                <h1>Fixed Trip - Quotation</h1>
                                <p><span class="quotetittle col-lg-5"></span>
                                <span class="quote_value hrad">Price per person</span>
                                <span class="quote_value hrad">Price for the group</span></p>
                                <p><span class="quotetittle">Price of hotel</span>
                                <span class="quote_value">' . $fprice_of_hotel . '</span>
                                <span class="quote_value">' . $fhotel_price_group . '</span></p>
                                <p><span class="quotetittle">Cost of activities</span>
                                <span class="quote_value">' . $fcost_of_activities . '</span>
                                <span class="quote_value">' . $factivities_price_group . '</span></p>
                                <p><span class="quotetittle">Cost of transport</span>
                                <span class="quote_value">' . $fcost_of_transport . '</span>
                                <span class="quote_value">' . $ftransport_price_group . '</span></p>
                                <p><span class="quotetittle">Cost of Keeper</span>
                                <span class="quote_value">' . $fcost_of_Keeper . '</span>
                                <span class="quote_value">' . $fkeeper_price_group . '</span></p>
                                <p><span class="quotetittle">Cost of booking Fee</span>
                                <span class="quote_value">' . $fcost_of_booking_Fee . '</span>
                                <span class="quote_value">' . $fbooking_price_group . '</span></p>
                                <p><span class="quotetittle">Cost of Insurance</span>
                                <span class="quote_value">' . $fcost_of_insurance . '</span>
                                <span class="quote_value">' . $finsurance_price_group . '</span></p>
                                <p><span class="quotetittle">Total Cost Tax Free</span>
                                <span class="quote_value">' . $ftotal_cost_tax_free . '</span>
                                <span class="quote_value">' . $ftaxfree_price_group . '</span></p>
                                <p><span class="quotetittle">GST</span>
                                <span class="quote_value">' . $fgst . '</span>
                                <span class="quote_value">' . $fgst_price_group . '</span></p>
                                <p><span class="quotetittle">Final cost</span>
                                <span class="quote_value">' . $ffinal_cost . '</span>
                                <span class="quote_value">' . $ffinal_price_group . '</span></p>
                                </div>';
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <!--qrfe-->
                </div>
                <!--Select1-->
                <!--Select2-->
                <div ng-show='selected == 2'>
                    <!--fqcs-->
                    <div class="Booking_detail">
                        <div class="profile_main_fixed">
                        <?php
                        /* get customized final quote */
                        if (($customized_order_count != '0' || $customized_count != '0') && $t == 1) {
                            $sqlx = "SELECT * FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id";
                            $db->setQuery($sqlx);
                            $final_detail = $db->loadObjectList();
                            foreach ($final_detail as $finalqute_disp) {
                                $orderid = $finalqute_disp->id;
                                $no_days = $finalqute_disp->no_days;
                                $no_people = $finalqute_disp->no_people;
                                $cusno_people = $finalqute_disp->no_people;
                                $no_rooms = $finalqute_disp->no_room;
                                $budget = $finalqute_disp->budget;
                                $transport = $finalqute_disp->transport;
                                $flight = $finalqute_disp->flight;
                                $stay = $finalqute_disp->stay;
                                $admin = $finalqute_disp->admin_msg;
                                $stay = str_replace('_', ' ', $stay);
                                $keeper = $finalqute_disp->keeper;
                                $dateofdeparture = $finalqute_disp->dateofdeparture;
                                $dateofdeparture = date("d-m-Y", strtotime($dateofdeparture));

                                $placeofdeparture = $finalqute_disp->placeofdeparture;
                                $write_us = $finalqute_disp->write_us;
                                $payment_type = $finalqute_disp->payment_type;
                                $c_payment_status = $finalqute_disp->payment_status;
                                $flight_amount = $finalqute_disp->flight_amount;


                                $uid = $finalqute_disp->uid;
                                $flight_amount_group = $finalqute_disp->flight_amount;
                                $flight_amount = $finalqute_disp->flight_amount;
                                $ctrip_status = $finalqute_disp->trip_status;
                                if ($flight_amount == 0) {
                                    $flight_amount = '';
                                }
                                $price_of_hotel = $finalqute_disp->price_of_hotel;
                                if ($price_of_hotel == 0) {
                                    $price_of_hotel = '';
                                }
                                $cost_of_activities = $finalqute_disp->cost_of_activities;
                                if ($cost_of_activities == 0) {
                                    $cost_of_activities = '';
                                }
                                $cost_of_transport = $finalqute_disp->cost_of_transport;
                                if ($cost_of_transport == 0) {
                                    $cost_of_transport = '';
                                }
                                $cost_of_Keeper = $finalqute_disp->cost_of_Keeper;
                                if ($cost_of_Keeper == 0) {
                                    $cost_of_Keeper = '';
                                }
                                $cost_of_booking_fee = $finalqute_disp->cost_of_booking_Fee;
                                if ($cost_of_booking_fee == 0) {
                                    $cost_of_booking_fee = '';
                                }
                                $cost_of_insurance = $finalqute_disp->cost_of_insurance;
                                if ($cost_of_insurance == 0) {
                                    $cost_of_insurance = '';
                                }
                                $total_cost_tax_free = $finalqute_disp->total_cost_tax_free;
                                if ($total_cost_tax_free == 0) {
                                    $total_cost_tax_free = '';
                                }
                                $gst = $finalqute_disp->gst;
                                if ($gst == 0) {
                                    $gst = '';
                                }
                                $final_cost = $finalqute_disp->final_cost;
                                if ($final_cost == 0) {
                                    $final_cost = '';
                                }
                                $first_installement = $finalqute_disp->first_installement;
                                if ($first_installement == 0) {
                                    $first_installement = '';
                                }
                                $last_day_for_first_installement = $finalqute_disp->last_day_for_first_installement;
                                $last_day_for_first_installements = $finalqute_disp->last_day_for_first_installement;
                                if ($last_day_for_first_installement == 0) {
                                    $last_day_for_first_installement = '';
                                } else {
                                    $last_day_for_first_installement = date("d-m-Y h:i a", strtotime($last_day_for_first_installement));
                                }
                                $final_installement = $finalqute_disp->final_installement;
                                if ($final_installement == 0) {
                                    $final_installement = '';
                                }
                                $last_day_for_final_installement = $finalqute_disp->last_day_for_final_installement;
                                $last_day_for_final_installements = $finalqute_disp->last_day_for_final_installement;
                                if ($last_day_for_final_installement == 0) {
                                    $last_day_for_final_installement = '';
                                } else {
                                    $last_day_for_final_installement = date("d-m-Y h:i a", strtotime($last_day_for_final_installement));
                                }
                                if ($ctrip_status == '') {
                                    echo '<div class="headings">
                                    <h1>Customized Trip</h1>
                                    <p><b>Number of Days</b><span>:</span><span>' . $no_days . '</span></p>
                                    <p><b>Number of People</b><span>:</span><span>' . $no_people . '</span></p>
                                    <p><b>Number of Rooms</b><span>:</span><span>' . $no_rooms . '</span></p>
                                    <p><b>Budget</b><span>:</span><span>' . $budget . '</span></p>
                                    <p><b>Transport</b><span>:</span><span>' . $transport . '</span></p>
                                    <p><b>Stay</b><span>:</span><span>' . $stay . '</span></p>
                                    <p><b>Flight ticket</b><span>:</span><span>' . $flight . '</span></p>
                                    <p><b>Keeper</b><span>:</span><span>' . $keeper . '</span></p>
                                    <p><b>Date of Departure</b><span>:</span><span>' . $dateofdeparture . '</span></p>
                                    <p><b>Place Of Departure</b><span>:</span><span>' . $placeofdeparture . '</span></p>

                                    <p><b>Payment Type</b><span>:</span><span>' . $payment_type . '</span></p>
                                    <span class="cwrite"><p><b>Write up:-</b>' . $write_us . '</p></span>
                                    </div>';
                                    echo '<div class="display_quote waitformsgm">
                                    <h1>Merci / Thank You</h1>

                                    <div class="waitformsg">
                                    <p>We have received your request and will update your quotation shortly.</p>
                                    <p>You will receive your quotation via SMS and E-mail. Kindly check your account in couple of hours.</p>
                                    </div>
                                    </div>';
                                } else {
                                    $totalprice = $price_of_hotel + $cost_of_activities + $flight_amount + $cost_of_transport + $cost_of_Keeper + $cost_of_booking_fee;
                                    $totalprice = $totalprice + $cost_of_insurance + $gst;
                                    $hotel_price_group = $price_of_hotel * $no_people;
                                    $activities_price_group = $cost_of_activities * $no_people;
                                    $transport_price_group = $cost_of_transport * $no_people;
                                    $keeper_price_group = $cost_of_Keeper * $no_people;
                                    $booking_price_group = $cost_of_booking_fee * $no_people;
                                    $insurance_price_group = $cost_of_insurance * $no_people;
                                    $taxfree_price_group = $total_cost_tax_free;
                                    $gst_price_group = $gst;
                                    $final_price_group = $final_cost;
                                    $firstinsta_price_group = $first_installement;
                                    $finalinsta_price_group = $final_installement;
                                    $cdtime = date('Y-m-d H:i:s', strtotime($last_day_for_first_installements));
                                    $cltime = date('Y-m-d H:i:s', strtotime($last_day_for_final_installements));
                                    if (($ckhtym > $cdtime)) {
                                        $color = 'exceed';
                                    } else {
                                        $color = 'normal';
                                    }
                                    if ($c_payment_status == 'first_installment' || $c_payment_status == 'final_installment') {
                                        $color = 'normal';
                                    }
                                    if ($ckhtym > $cltime) {
                                        $colors = 'exceed';
                                    } else {
                                        $colors = 'normal';
                                    }
                                    if ($c_payment_status == 'final_installment') {
                                        $colors = 'normal';
                                    }
                                    echo '
                                    <div class="headings"><h1>Customized Trip</h1>
                                    <p><b>Number of Days</b><span>:</span><span>' . $no_days . '</span></p>
                                    <p><b>Number of People</b><span>:</span><span>' . $no_people . '</span></p>
                                    <p><b>Number of Rooms</b><span>:</span><span>' . $no_rooms . '</span></p>
                                    <p><b>Budget</b><span>:</span><span>' . $budget . '</span></p>
                                    <p><b>Transport</b><span>:</span><span>' . $transport . '</span></p>
                                    <p><b>Stay</b><span>:</span><span>' . $stay . '</span></p>
                                    <p><b>Flight ticket</b><span>:</span><span>' . $flight . '</span></p>
                                    <p><b>Keeper</b><span>:</span><span>' . $keeper . '</span></p>
                                    <p><b>Date of Departure</b><span>:</span><span>' . $dateofdeparture . '</span></p>
                                    <p><b>Place Of Departure</b><span>:</span><span>' . $placeofdeparture . '</span></p>

                                    <p><b>Payment Type</b><span>:</span><span>' . $payment_type . '</span></p>
                                    <span class="cwrite"><p><b>Write up:-</b>' . $write_us . '</p></span>
                                    </div>';
                                    echo '<div class="display_quote">
                                    <h1>Customized Trip - Quotation</h1>
                                    <p><span class="quotetittle col-lg-5"></span>
                                    <span class="quote_value hrad">Price per person</span>
                                    <span class="quote_value hrad">Price for the group</span></p>
                                    <p><span class="quotetittle">Price of hotel</span>
                                    <span class="quote_value">' . $price_of_hotel . '</span>
                                    <span class="quote_value">' . $hotel_price_group . '</span></p>
                                    <p><span class="quotetittle">Cost of activities</span>
                                    <span class="quote_value">' . $cost_of_activities . '</span>
                                    <span class="quote_value">' . $activities_price_group . '</span></p>
                                    <p><span class="quotetittle">Cost of transport</span>
                                    <span class="quote_value">' . $cost_of_transport . '</span>
                                    <span class="quote_value">' . $transport_price_group . '</span></p>
                                    <p><span class="quotetittle">Cost of Keeper</span>
                                    <span class="quote_value">' . $cost_of_Keeper . '</span>
                                    <span class="quote_value">' . $keeper_price_group . '</span></p>
                                    <p><span class="quotetittle">Cost of booking Fee</span>
                                    <span class="quote_value">' . $cost_of_booking_fee . '</span>
                                    <span class="quote_value">' . $booking_price_group . '</span></p>
                                    <p><span class="quotetittle">Cost of Insurance</span>
                                    <span class="quote_value">' . $cost_of_insurance . '</span>
                                    <span class="quote_value">' . $insurance_price_group . '</span></p>';

                                    if($flight_amount != 0){
                                        echo '<p><span class="quotetittle">Cost of Flight</span>
                                    <span class="quote_value">' . $flight_amount . '</span>
                                    <span class="quote_value">' . $flight_amount * $cusno_people . '</span></p>';
                                    }


                                    echo '<p><span class="quotetittle">Total Cost Tax Free</span>
                                    <span class="quote_value">' . $total_cost_tax_free /$cusno_people. '</span>
                                    <span class="quote_value">' . $taxfree_price_group . '</span></p>
                                    <p><span class="quotetittle">GST</span>
                                    <span class="quote_value">' . $gst /$cusno_people. '</span>
                                    <span class="quote_value">' . $gst_price_group . '</span></p>
                                    <p><span class="quotetittle">Final cost</span>
                                    <span class="quote_value">' . $final_cost/$cusno_people . '</span>
                                    <span class="quote_value">' . $final_price_group . '</span></p>
                                    <p><span class="quotetittle">First Installment</span>
                                    <span class="quote_value">' . $first_installement/$cusno_people . '</span>
                                    <span class="quote_value">' . $firstinsta_price_group . '</span></p>
                                    <p><span class="quotetittle">Last day of First Installment</span>
                                    <span class="quote_value ' . $color . '">' . $last_day_for_first_installement . '</span>
                                    <span class="quote_value ' . $color . '">' . $last_day_for_first_installement . '</span></p>
                                    <p><span class="quotetittle">Final Installement</span>
                                    <span class="quote_value">' . $final_installement/$cusno_people . '</span>
                                    <span class="quote_value">' . $finalinsta_price_group . '</span></p>
                                    <p><span class="quotetittle">Last day of Final Installement</span>
                                    <span class="quote_value ' . $colors . '">' . $last_day_for_final_installement . '</span>
                                    <span class="quote_value ' . $colors . '">' . $last_day_for_final_installement . '</span></p>';



                                    if (($ckhtym) < ($cdtime)) {
                                        if ($c_payment_status != 'final_installment' && $c_payment_status != 'first_installment') {
                                            $sqlgetdoc = "SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$orderid AND trip_type='customized'";
                                            $db->setQuery($sqlgetdoc);
                                            $doc_count = $db->loadResult();
                                            if ($doc_count == 0) {
                                                echo '<div class="paynow"><p>
                                                <a class="cpbtn" href="' . JURI::root() . 'index.php?option=com_trips&view=trips&layout=documents&oid=' . $orderid . '&orderby=customized">Book Now</a>
                                                </p></div>';
                                            } else if ($payment_type == 'Split') {
                                                $sql_get_share = "SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$orderid AND trip_type='customized' AND pay_status='first'";
                                                $db->setQuery($sql_get_share);
                                                $share_pay_amt = $db->loadResult();
                                                $first_install_balance_amt = $first_installement - $share_pay_amt;
                                                if ($first_install_balance_amt == 0) {
                                                    $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $orderid . '&t=1';
                                                } else {
                                                    $paymentlink = '' . JURI::root() . 'share-payment/?oid=' . $orderid . '&t=1';
                                                }
                                                echo '<div class="paynow">';
                                                echo '<p id="paylink">
                                                <a href="' . $paymentlink . '" class="a2a_button_facebook" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput" readonly></a></p>
                                                <p class="set_link"> <button onclick="myFunction()" class="cpbtn">Copy Link</button></p>';
                                                echo '</div>';
                                            } else if ($payment_type == 'Participative') {
                                            // get first installment status
                                                if ($c_payment_status == 'first_installment') {
                                                    $amoutz = $finalinsta_price_group;
                                                } else {
                                                    $amoutz = $firstinsta_price_group;
                                                }
                                                ?>
                                                <div class="paynow">
                                                    <form method="POST" action="<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $orderid; ?>" enctype="multipart/form-data">
                                                         <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                         <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                         <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                         <input type="hidden" value="customized-<?php echo $orderid; ?>-first" id="productinfo" name="productinfo">
                                                         <input type="hidden" value="<?php echo $amoutz; ?>" id="amount" name="amount">
                                                         <input type="submit" value="Continue Booking" id="cb" name="cb">
                                                    </form>
                                                </div>
                                             <?php

                                        } else {
                                            if ($c_payment_status == 'first_installment') {
                                                $amoutz = $finalinsta_price_group;
                                            } else {
                                                $amoutz = $firstinsta_price_group;
                                            }
                                         // get first installment status
                                            ?>
                                                <div class="paynow">
                                                    <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $orderid; ?>' enctype='multipart/form-data'>
                                                        <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                        <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                        <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                        <input type="hidden" value="customized-<?php echo $orderid; ?>-first" id="productinfo" name="productinfo">
                                                        <input type="hidden" value="<?php echo $amoutz; ?>" id="amount" name="amount">
                                                        <input type="submit" value="Continue Booking" id="cb" name="cb">
                                                    </form>
                                                </div>
                                             <?php

                                        }
                                    }
                                } else {
                                    if ($c_payment_status == 'first_installment' || $c_payment_status == 'final_installment') {

                                    } else {
                                        echo '<div class="paynow"><input type="button" id="qrq" class="cpbtn" value="Requote"></div>';
                                    }
                                }
                                if($admin!='') {
                                     echo '<p><b>FBF Travel Manager Message : </b>&nbsp;&nbsp;' . $admin . '</p>';
                                }

                                echo '</div>';
                            }
                        }
                    }
                    ?>
                        </div>
                    </div>
                    <!--fqce-->
                    <!--fqss-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                        $sqlz = "SELECT COUNT(id) FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                        $db->setQuery($sqlz);
                        $semicustomized_order_count = $db->loadResult();
                        if ($urlid != '') {
                            $sql = "SELECT COUNT(id) FROM `#__semicustomized_order` WHERE uid=$user_id";
                            $db->setQuery($sql);
                            $semi_order_count = $db->loadResult();
                        } else {
                            $semi_order_count = 0;
                        }
                        if (($semicustomized_order_count != '0' || $semi_order_count != '0') && $t == 2) {
                            $sqlfirst = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sqlfirst);
                            $semi_orderfirstdetails = $db->loadObjectList();
                            foreach ($semi_orderfirstdetails as $semiorder_disp1) {
                                $number_people1 = $semiorder_disp1->number_peoples;
                                $number_rooms1 = $semiorder_disp1->number_rooms;
                                $dateofdeparture1 = $semiorder_disp1->trip_date;
                                $flight1 = $semiorder_disp1->flight;
                                $place_of_dept1 = $semiorder_disp1->place_of_dept;
                                $trip_status = $semiorder_disp1->trip_status;
                                $paymethod1 = $semiorder_disp1->paymethod;
                                $noofdays1 = $semiorder_disp1->noofdays;
                                $trip_id1 = $semiorder_disp1->trip_id;
                                $admin = $semiorder_disp1->comment;
                                $payment_status = $semiorder_disp1->payment_status;
                                //$noofdays1++; $number_rooms1++;
                                //$number_people1++;
                            }
                            if ($trip_status == '') {
                                echo '<div class="display_quote waitformsgm">
                                    <h1>Merci / Thank You</h1>

                                    <div class="waitformsg">
                                    <p>We have received your request and will update your quotation shortly.</p>
                                    <p>You will receive your quotation via SMS and E-mail. Kindly check your account in couple of hours.</p>
                                    </div>
                                    </div>';
                            } else {
                                echo '<div class="headings"><h1>Semi Customized Trip</h1>
                            <div class="semi_maindet">
                            <p><span class="">Number of people </span><span>:</span><span>' . $number_people1 . '</span></p>
                            <p><span class="">Number of room </span><span>:</span><span>' . $number_rooms1 . '</span></p>
                            <p><span class="">Date of departure </span><span>:</span><span>' . $dateofdeparture1 . '</span></p>
                            <p><span class="">Flight ticket  </span><span>:</span><span>' . $flight1 . '</span></p>
                            <p><span class="">Place of departure </span><span>:</span><span>' . $place_of_dept1 . '</span></p>
                            <p><span class="">Payment solution</span><span>:</span><span>' . $paymethod1 . '</span></p>
                            <p><span class="">Total number of days</span><span>:</span><span>' . $noofdays1 . '</span></p>
                            </div>';

                                $sqltripdet2 = "SELECT * FROM `#__semicustomized_order` WHERE  uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                                $db->setQuery($sqltripdet2);
                                $tripdetails2 = $db->loadObjectList();
                                $package = 0;
                                foreach ($tripdetails2 as $tripdetails_disp2) {
                                    $package++;
                                    $noofdays = $tripdetails_disp2->noofdays;
                                    $transport = $tripdetails_disp2->transport;
                                    $hotel = $tripdetails_disp2->hotel;
                                    $keeper_information = $tripdetails_disp2->keeper_information;
                                    $trip_id = $tripdetails_disp2->trip_id;
                                    if ($transport == 'yes') {
                                        $transport = 'Private Transport';
                                    } else {
                                        $transport = 'Public Transport';
                                    }
                                    if ($keeper_information == 'yes') {
                                        $keeper_information = 'With Keeper';
                                    } else {
                                        $keeper_information = 'Without Keeper';
                                    }
                                    $triptitle = "SELECT title FROM `#__semicustomized_trip` WHERE id=$trip_id";
                                    $db->setQuery($triptitle);
                                    $triptitle = $db->loadResult();
                                    echo '<div class="semibookings">
                                <h3>' . $triptitle . ' </h3>
                                <p><span class="">Number of days</span><span>:</span><span class="">  ' . $noofdays . '</span></p>
                                <p><span class="">Transport </span><span>:</span><span class="">  ' . $transport . '</span></p>
                                <p><span class="">Hotel</span> <span>:</span><span class=""> ' . $hotel . '</span></p>
                                <p><span class="">keeper </span> <span>:</span><span class=""> ' . $keeper_information . '</span></p>
                                </div>';
                                }
                                // get Quotation
                                $sql = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND (payment_status!='final_installment' || payment_status!='first_installment') AND quote_status=$quote_status";
                                $db->setQuery($sql);
                                $semi_orderdetails = $db->loadObjectList();


	$getloopcount="SELECT COUNT(id) FROM `#__semicustomized_order` WHERE uid=$user_id AND quote_status=$quote_status";
	$db->setQuery($getloopcount);
	$getloopcountres=$db->loadResult();


                                $hotel_priceall = $cost_of_activitiesall = $cost_of_traferall = $pricetransferall = $keeper_amtall = $bookingtotalall = 0;
                                $insuranceall = $publictransportall = $price_of_leavingall = $cost_of_transferall = $transfer_departure_priceall = 0;
                                $totalpriceper_personall = $totalpriceper_person_withgstall = $totalamtall = $totalprizeall = 0;
                                $total_cost_tax_free_forall=$semigst=$saemi_final_costall=0;
                                foreach ($semi_orderdetails as $semiorder_disp) {
                                    $soderid = $semiorder_disp->id;
                                    $uid = $semiorder_disp->uid;
                                    $booked_time = $semiorder_disp->booked_time;
                                    $noofdays = $semiorder_disp->noofdays;
                                    $dateofdeparture = $semiorder_disp->trip_date;
                                    $trip_id = $semiorder_disp->trip_id;
                                    $planid = $semiorder_disp->planid;
                                    $number_rooms = $semiorder_disp->number_rooms;
                                    $number_people = $semiorder_disp->number_peoples;
                                    $keeper = $semiorder_disp->keeper_information;
                                    $hotel = $semiorder_disp->hotel;
                                    $transport = $semiorder_disp->transport;
                                    $flight = $semiorder_disp->flight;
                                    $paymethod = $semiorder_disp->paymethod;
                                    $place_of_dept = $semiorder_disp->place_of_dept;
                                    $hotel_price = $semiorder_disp->hotel_price;
                                    $cost_of_activities = $semiorder_disp->cost_of_activities;
                                    $cost_of_transport = $semiorder_disp->cost_of_transport;
                                    $cost_of_Keeper = $semiorder_disp->cost_of_Keeper;
                                    $cost_of_booking_fee = $semiorder_disp->cost_of_booking_fee;
                                    $cost_of_insurance = $semiorder_disp->cost_of_insurance;
                                    $transfer_departure_price = $semiorder_disp->transfer_departure_price;
                                    $price_of_public_transport = $semiorder_disp->price_of_public_transport;
                                    $price_of_leaving = $semiorder_disp->price_of_leaving;
                                    $flightamnt = $semiorder_disp->cost_of_flight_ticket;
                                    $trip_status = $semiorder_disp->trip_status;
                                    $total_amount_for_filght = $semiorder_disp->total_amount_for_filght;
                                    $payment_type = $semiorder_disp->paymethod;
                                    $payment_status = $semiorder_disp->payment_status;
                                    $total_cost_tax_free = $semiorder_disp->total_cost_tax_free;

                                    $total_cost_tax_free_forall += $total_cost_tax_free;

                                    $semigst = $semiorder_disp->gst;

                                    $semigst+= $semigst;

                                    $saemi_final_cost = $semiorder_disp->final_cost;

                                    $saemi_final_costall+=$saemi_final_cost;

                                    $semi_first_installement = $semiorder_disp->first_installement;
                                    $semi_final_installement = $semiorder_disp->final_installement;
                                    $last_day_for_first_installement = $semiorder_disp->last_day_for_first_installement;
                                    $last_day_for_final_installement = $semiorder_disp->last_day_for_final_installement;
                                    $hotel_priceall += $hotel_price;
                                    $cost_of_activitiesall += $cost_of_activities;
                                    $cost_of_transferall += $cost_of_transport;
                                    $keeper_amtall += $cost_of_Keeper;
                                    $bookingtotalall += $cost_of_booking_fee;
                                    $insuranceall += $cost_of_insurance;
                                    $publictransportall += $price_of_public_transport;
                                    $transfer_departure_priceall += $transfer_departure_price;
                                    $price_of_leaving += $price_of_leaving;
                                    $transportfee = $cost_of_transferall + $publictransportall + $transfer_departure_priceall + $price_of_leaving;
                                    $gstt = $semigst;
                                }
                                $sdtime = date('Y-m-d H:i:s', strtotime($last_day_for_first_installement));
                                $sltime = date('Y-m-d H:i:s', strtotime($last_day_for_final_installement));

                                if (($ckhtym > $sdtime)) {
                                    $color = 'exceed';
                                } else {
                                    $color = 'normal';
                                }
                                if ($payment_status == 'first_installment' || $payment_status == 'final_installment') {
                                    $color = 'normal';
                                }
                                if ($ckhtym > $sltime) {
                                    $colors = 'exceed';
                                } else {
                                    $colors = 'normal';
                                }
                                if ($payment_status == 'final_installment') {
                                    $colors = 'normal';
                                }
                                $travelprice = $cost_of_transferall + $transfer_departure_priceall + $price_of_leaving;
                                echo '<div class="semibookings">
                            <h3> Overall Quotation - Per Person </h3>
                            <p><span class="">Cost of Hotel</span>
                            <span>:</span><span class="">  ' . $hotel_priceall/$getloopcountres . '</span></p>
                            <p><span class="">Cost of activities </span>
                            <span>:</span><span class="">' . $cost_of_activitiesall . '</span></p>
                            <p><span class="">Cost of Transport</span>
                            <span>:</span><span class=""> ' . $travelprice . '</span></p>
                            <p><span class="">Cost of Keeper </span>
                            <span>:</span><span class=""> ' . $keeper_amtall . '</span></p>
                            <p><span class="">Cost of Booking fee</span>
                            <span>:</span><span class=""> ' . $bookingtotalall . '</span></p>
                            <p><span class="">Cost of Insurance</span>
                            <span>:</span><span class=""> ' . $insuranceall . '</span></p>';
                                echo '<p><span class="">Flight Per Person</span>
                                <span>:</span><span class=""> ' . $flightamnt . '</span></p>
                            <p><span class="">GST</span>
                            <span>:</span><span class=""> ' . $semigst . '</span></p>


                                <p><span class="">Total Cost</span>
                                <span>:</span><span class="">  ' . $total_cost_tax_free_forall . '</span></p>
                                <p><span class="">Total Cost with GST </span>
                                <span>:</span><span class="">' . $saemi_final_costall . '</span></p>
                                </div>';
                                echo '<div class="semibookings">
                                <h3> Overall Quotation for ' . $number_people1 . ' people </h3>
                                <p><span class="">Total Cost</span>
                                <span>:</span><span class="">  ' . $total_cost_tax_free_forall*$number_people1. '</span></p>
                                <p><span class="">Total Cost with GST </span>
                                <span>:</span><span class="">' . $saemi_final_costall*$number_people1 . '</span></p>
                                <p><span class="">First Installment</span>
                                <span>:</span><span class="">  ' . $semi_first_installement . '</span></p>
                                <p><span class="">Final Installment</span>
                                <span>:</span><span class="">  ' . $semi_final_installement . '</span></p>
                                <p><span class="">First Installment Last date</span>
                                <span>:</span><span class="' . $color . '">  ' . $last_day_for_first_installement . '</span></p>
                                <p><span class="">Final Installment Last date</span>
                                <span>:</span><span class="' . $colors . '">  ' . $last_day_for_final_installement . '</span></p>';

                                if (($ckhtym) < ($sdtime)) {
                                    if ($payment_status == 'finalizebyuser') {
                                        $sqlgetdoc = "SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$soderid AND trip_type='semi'";
                                        $db->setQuery($sqlgetdoc);
                                        $doc_count = $db->loadResult();
                                        if ($doc_count == 0) {
                                            echo '<div class="paynow">';
                                            echo '<p><a class="cpbtn" href="' . JURI::root() . 'index.php?option=com_trips&view=trips&layout=documents&oid=' . $soderid . '&orderby=semi">Book Now</a></p>';
                                            echo '</div>';
                                        } else if ($payment_type == 'Split') {
                                            $sql_get_share1 = "SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$soderid AND trip_type='semi' AND pay_status='first'";
                                            $db->setQuery($sql_get_share1);
                                            $semi_share_pay_amt = $db->loadResult();
                                            $semi_first_install_balance_amt = $semi_first_installement - $semi_share_pay_amt;

                                            if ($semi_first_install_balance_amt == 0) {
                                                $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $soderid . '&t=2';
                                            } else {
                                                $paymentlink = '' . JURI::root() . 'share-payment/?oid=' . $soderid . '&t=2';
                                            }

                                            echo '<div class="paynow">';
                                            echo '<p id="paylink">
                                            <a href="' . $paymentlink . '" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput"></a></p>
                                            <p class="set_link"> <button class="cpbtn" onclick="myFunction()" class="cpbtn">Copy Link</button></p></div>';
                                        } else if ($payment_type == 'Participative') {
                                            ?>
                                            <div class="paynow">
                                                <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $soderid; ?>' enctype='multipart/form-data'>
                                                    <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                    <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                    <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                    <input type="hidden" value="semi-<?php echo $soderid; ?>-first" id="productinfo" name="productinfo">
                                                    <input type="hidden" value="<?php echo $semi_first_installement; ?>" id="amount" name="amount">
                                                    <input type="submit" value="Continue Booking" id="cb" name="cb">
                                                </form>
                                            </div>
                                     <?php

                                } else {
                                    ?>
                                            <div class="paynow">
                                                <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $soderid; ?>' enctype='multipart/form-data'>
                                                    <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                    <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                    <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                    <input type="hidden" value="semi-<?php echo $soderid; ?>-first" id="productinfo" name="productinfo">
                                                    <input type="hidden" value="<?php echo $semi_first_installement; ?>" id="amount" name="amount">
                                                    <input type="submit" value="Continue Booking" id="cb" name="cb">
                                                </form>
                                            </div>
                                     <?php

                                }
                            } else {

                            }
                        } else {
                            if ($payment_status == 'first_installment' || $payment_status == 'final_installment') {

                            } else {
                                echo '<div class="paynow"><input type="button" id="qrq" class="cpbtn" value="Requote"></div>';
                            }
                        }
                        echo '</div>';
                    }
                                if($admin!='') {
                                     echo '<p><b>FBF Travel Manager Message : </b>&nbsp;&nbsp;' . $admin . '</p>';
                                }
                    echo '</div>';
                }
                ?>
                        </div>
                    </div>
                    <!--fqse-->
                    <!--fqfs-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                        $sql_fix = "SELECT COUNT(id) FROM `#__fixed_trip_orders` WHERE uid='$user_id' LIMIT $qlimit";
                        $db->setQuery($sql_fix);
                        $fixed_order_count = $db->loadResult();
                        if ($urlid != '') {
                            $sql = "SELECT COUNT(id) FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid=$user_id";
                            $db->setQuery($sql);
                            $fixed_count = $db->loadResult();
                        } else {
                            $fixed_count = 0;
                        }
                        if (($fixed_order_count != '0' || $fixed_count != '0') && $t == 3) {
                            $sql = "SELECT * FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid='$user_id' LIMIT $qlimit";
                            $db->setQuery($sql);
                            $fixedorders = $db->loadObjectList();
                            foreach ($fixedorders as $forders) {
                                $orderid = $forders->id;
                                $no_days = $forders->no_of_days;
                                $no_people = $forders->no_of_people;
                                $no_rooms = $forders->no_of_room;
                                $pack_title = $forders->pack_title;
                                $transport = $forders->transport;
                                $stay = $forders->hotel;
                                $flight = $forders->flight;
                                $keeper = $forders->keeper;
                                $dateofdeparture = $forders->pack_date;
                                $placeofdeparture = $forders->place_of_dept;
                                $pack_type = $forders->pack_type;
                                $planning = $forders->planning;
                                $payment_type = $forders->paymethod;
                                $uid = $forders->uid;
                                $payment_status = $forders->payment_status;
                                $flight_amount = $forders->flight_price;

                                $orderid = $forders->id;
                                $fno_days = $forders->no_of_days;
                                $fno_people = $forders->no_of_people;
                                $fno_rooms = $forders->no_of_room;
                                $fpack_title = $forders->pack_title;
                                $ftransport = $forders->transport;
                                $fstay = $forders->hotel;
                                $fflight = $forders->flight;
                                $fkeeper = $forders->keeper;
                                $fdateofdeparture = $forders->pack_date;
                                $fplaceofdeparture = $forders->place_of_dept;
                                $fpack_type = $forders->pack_type;
                                $fpayment_type = $forders->paymethod;
                                $fuid = $forders->uid;
                                $fpayment_status = $forders->payment_status;
                                $ftrip_status = $forders->trip_status;
                                $fprice_of_hotel = $forders->cost_of_hotel;
                                $fcost_of_activities = $forders->cost_of_activities;
                                $fcost_of_transport = $forders->cost_of_transport;
                                $fcost_of_Keeper = $forders->cost_of_keeper;
                                $fcost_of_booking_Fee = $forders->cost_of_booking_fee;
                                $fcost_of_insurance = $forders->cost_of_insurance;
                                $ftotal_cost_tax_free = $forders->total_price;
                                $ffinal_cost = $forders->total_price_gst;
                                $admin = $forders->admin_msg;
                                $ffirst_installement = $forders->first_installment;
                                $ffinal_installement = $forders->final_installment;
                                $flast_day_for_final_installement = $forders->final_inst_date;
                                $flast_day_for_first_installement = $forders->first_inst_date;
                                $fgst = $forders->gst;
                                $fflight_amount = $forders->flight_price;
                                echo '<div class="headings"><h1>Fixed Trip</h1>
                                <p><b>Number of Days</b><span>:</span><span>' . $no_days . '</span></p>
                                <p><b>Number of People</b><span>:</span><span>' . $no_people . '</span></p>
                                <p><b>Number of Rooms</b><span>:</span><span>' . $no_rooms . '</span></p>
                                <p><b>Pack Title</b><span>:</span><span>' . $pack_title . '</span></p>
                                <p><b>Transport</b><span>:</span><span>' . $transport . '</span></p>
                                <p><b>Stay</b><span>:</span><span>' . $stay . '</span></p>
                                <p><b>Flight ticket</b><span>:</span><span>' . $flight . '</span></p>
                                <p><b>Keeper</b><span>:</span><span>' . $keeper . '</span></p>
                                <p><b>Date of Departure</b><span>:</span><span>' . $dateofdeparture . '</span></p>
                                <p><b>Place Of Departure</b><span>:</span><span>' . $placeofdeparture . '</span></p>
                                <p><b>Payment Type</b><span>:</span><span>' . $payment_type . '</span></p>
                                </div>';
                                $fstime = date('Y-m-d H:i:s', strtotime($flast_day_for_first_installement));
                                $fltime = date('Y-m-d H:i:s', strtotime($flast_day_for_final_installement));
                                $flast_day_for_first_installement = date("d-m-Y h:i A", strtotime($flast_day_for_first_installement));
                                $flast_day_for_final_installement = date("d-m-Y h:i A", strtotime($flast_day_for_final_installement));
                                if (($ckhtym > $fstime)) {
                                    $color = 'exceed';
                                } else {
                                    $color = 'normal';
                                }
                                if ($fpayment_status == 'first_installment' || $fpayment_status == 'final_installment') {
                                    $color = 'normal';
                                }
                                if ($ckhtym > $fltime) {
                                    $colors = 'exceed';
                                } else {
                                    $colors = 'normal';
                                }
                                if ($fpayment_status == 'final_installment') {
                                    $colors = 'normal';
                                }
                                $sql = "SELECT * FROM `#__users` WHERE id=$uid";
                                $db->setQuery($sql);
                                $events_detail = $db->loadObjectList();
                                foreach ($events_detail as $event_disp) {
                                    $userid = $event_disp->id;
                                    $username = $event_disp->name;
                                    $contact = $event_disp->phone;
                                    $mail = $event_disp->email;
                                }
                                $fhotel_price_group = $fprice_of_hotel * $fno_people;
                                $factivities_price_group = $fcost_of_activities * $fno_people;
                                $ftransport_price_group = $fcost_of_transport * $fno_people;
                                $fkeeper_price_group = $fcost_of_Keeper * $fno_people;
                                $fbooking_price_group = $fcost_of_booking_Fee * $fno_people;
                                $finsurance_price_group = $fcost_of_insurance * $fno_people;
                                $ftaxfree_price_group = $ftotal_cost_tax_free * $fno_people;
                                $fgst_price_group = $fgst * $fno_people;
                                $ffinal_price_group = $ffinal_cost * $fno_people;

                                echo '<div class="display_quote">
                                <h1>Fixed Trip - Quotation</h1>
                                <p><span class="quotetittle col-lg-5"></span>
                                <span class="quote_value hrad">Price per person</span>
                                <span class="quote_value hrad">Price for the group</span></p>
                                <p><span class="quotetittle">Price of hotel</span>
                                <span class="quote_value">' . $fprice_of_hotel . '</span>
                                <span class="quote_value">' . $fhotel_price_group . '</span></p>
                                <p><span class="quotetittle">Cost of activities</span>
                                <span class="quote_value">' . $fcost_of_activities . '</span>
                                <span class="quote_value">' . $factivities_price_group . '</span></p>
                                <p><span class="quotetittle">Cost of transport</span>
                                <span class="quote_value">' . $fcost_of_transport . '</span>
                                <span class="quote_value">' . $ftransport_price_group . '</span></p>
                                <p><span class="quotetittle">Cost of Keeper</span>
                                <span class="quote_value">' . $fcost_of_Keeper . '</span>
                                <span class="quote_value">' . $fkeeper_price_group . '</span></p>
                                <p><span class="quotetittle">Cost of booking Fee</span>
                                <span class="quote_value">' . $fcost_of_booking_Fee . '</span>
                                <span class="quote_value">' . $fbooking_price_group . '</span></p>
                                <p><span class="quotetittle">Cost of Insurance</span>
                                <span class="quote_value">' . $fcost_of_insurance . '</span>
                                <span class="quote_value">' . $finsurance_price_group . '</span></p>';
                                 if ($fflight != 'No' && ($fflight_amount!='' && $fflight_amount!=0)) {
                                        $fflight_amount_group = $fflight_amount * $fno_people;
                                        echo '<p>
                                       <span class="quotetittle">Flight Cost</span>
                                       <span class="quote_value">' . $fflight_amount . '</span>
                                       <span class="quote_value">' . $fflight_amount_group . '</span>
                                       </p>';
                                    }
                                echo '<p><span class="quotetittle">Total Cost Tax Free</span>
                                <span class="quote_value">' . $ftotal_cost_tax_free . '</span>
                                <span class="quote_value">' . $ftaxfree_price_group . '</span></p>
                                <p><span class="quotetittle">GST</span>
                                <span class="quote_value">' . $fgst . '</span>
                                <span class="quote_value">' . $fgst_price_group . '</span></p>
                                <p><span class="quotetittle">Final cost</span>
                                <span class="quote_value">' . $ffinal_cost . '</span>
                                <span class="quote_value">' . $ffinal_price_group . '</span></p>';
                                if ($ffinal_installement == '' || $ffinal_installement == 0) {
                                    echo '<span class="flightupdatewait">We will update flight costs</span></div>';
                                } else {
                                    $ffinal_price_group = $ffinal_cost * $fno_people;
                                    $ffirstinsta_price_group = $ffirst_installement * $fno_people;
                                    $ffinalinsta_price_group = $ffinal_installement * $fno_people;

                                    echo '<p><span class="quotetittle">First Installment</span>
                                    <span class="quote_value">' . $ffirst_installement . '</span>
                                    <span class="quote_value">' . $ffirstinsta_price_group . '</span></p>
                                    <p><span class="quotetittle">Last day of First Installment</span>
                                    <span class="quote_value ' . $color . '">' . $flast_day_for_first_installement . '</span>
                                    <span class="quote_value ' . $color . '">' . $flast_day_for_first_installement . '</span></p>
                                    <p><span class="quotetittle">Final Installement</span>
                                    <span class="quote_value">' . $ffinal_installement . '</span>
                                    <span class="quote_value">' . $ffinalinsta_price_group . '</span></p>
                                    <p><span class="quotetittle">Last day of Final Installement</span>
                                    <span class="quote_value ' . $colors . '">' . $flast_day_for_final_installement . '</span>
                                    <span class="quote_value ' . $colors . '">' . $flast_day_for_final_installement . '</span></p>';
                                    if (($ckhtym) < ($fstime)) {
                                    /* Payment section */
                                        if ($fpayment_status == 'intialized') {
                                            $sqlgetdoc = "SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$orderid AND trip_type='fixed'";
                                            $db->setQuery($sqlgetdoc);
                                            $doc_count = $db->loadResult();
                                            if ($doc_count == 0) {
                                                echo '<div class="paynow">';
                                                echo '<p><a class="cpbtn" href="' . JURI::root() . 'index.php?option=com_trips&view=trips&layout=documents&oid=' . $orderid . '&orderby=fixed">Book Now</a></p>';
                                                echo '</div>';
                                            } else if ($payment_type == 'Split') {
                                                $sql_get_share3 = "SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$orderid AND trip_type='semi' AND pay_status='first'";
                                                $db->setQuery($sql_get_share3);
                                                $fixed_share_pay_amt = $db->loadResult();
                                                $fixed_first_install_balance_amt = $ffirstinsta_price_group - $fixed_share_pay_amt;
                                                if ($fixed_first_install_balance_amt == 0) {
                                                    $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $orderid . '&t=3';
                                                } else {
                                                    $paymentlink = '' . JURI::root() . 'share-payment/?oid=' . $orderid . '&t=3';
                                                }
                                                echo '<div class="paynow">';
                                                echo '<p id="paylink">
                                                <a class="" href="' . $paymentlink . '" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput"></a></p>
                                                <p class="set_link"> <button onclick="myFunction()" class="cpbtn">Copy Link</button></p>';
                                                echo '</div>';
                                            } else if ($payment_type == 'Participative') {
                                                ?>
                                                <div class="paynow">
                                                    <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $orderid; ?>' enctype='multipart/form-data'>
                                                        <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                        <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                        <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                        <input type="hidden" value="fixed-<?php echo $orderid; ?>-first" id="productinfo" name="productinfo">
                                                        <input type="hidden" value="<?php echo $ffirstinsta_price_group; ?>" id="amount" name="amount">
                                                        <input type="submit" value="Continue Booking" id="cb" name="cb">
                                                    </form>
                                                </div>
                                            <?php

                                        } else {
                                            ?>
                                                <div class="paynow">
                                                     <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $orderid; ?>' enctype='multipart/form-data'>
                                                        <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                        <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                        <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                        <input type="hidden" value="fixed-<?php echo $orderid; ?>-first" id="productinfo" name="productinfo">
                                                        <input type="hidden" value="<?php echo $ffirstinsta_price_group; ?>" id="amount" name="amount">
                                                        <?php
                                                        if ($fpayment_status == 'first_installment' || $fpayment_status == 'final_installment') {

                                                        } else {
                                                            echo '<input type="submit" value="Continue Booking" id="cb" name="cb">';
                                                        }
                                                        ?>
                                                    </form>
                                                </div>
                                              <?php

                                            }
                                        } else {

                                        }
                                    } else {
                                        if ($fpayment_status == 'first_installment' || $fpayment_status == 'final_installment') {

                                        } else {
                                            echo '<div class="paynow"><input type="button" id="qrq" class="cpbtn" value="Requote"></div>';
                                        }
                                    }
                                    if($admin!='') {
                                         echo '<p><b>FBF Travel Manager Message : </b>&nbsp;&nbsp;&nbsp;' . $admin . '</p>';
                                      }
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <!--fqfe-->
                </div>
                <!--Select2-->
                <!--Select3-->
                <div ng-show='selected == 3'>
                    <!--fpcs-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                            /* get customized final quote */
                        if ($urlid != '') {
                            $sql = "SELECT COUNT(id) FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id AND payment_status!=''";
                            $db->setQuery($sql);
                            $customized_count = $db->loadResult();
                        } else {
                            $customized_count = 0;
                        }


                        if (($customized_order_count != '0' || $customized_count != '0') && $t == 1) {
                            $sqlx = "SELECT * FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id LIMIT $qlimit";
                            $db->setQuery($sqlx);
                            $final_detail = $db->loadObjectList();
                            foreach ($final_detail as $finalqute_disp) {
                                $orderid = $finalqute_disp->id;
                                $no_days = $finalqute_disp->no_days;
                                $no_people = $finalqute_disp->no_people;
                                $placeofdeparture = $finalqute_disp->placeofdeparture;
                                $write_us = $finalqute_disp->write_us;
                                $payment_type = $finalqute_disp->payment_type;
                                $c_payment_status = $finalqute_disp->payment_status;
                                $amoutz = $finalqute_disp->first_installement;
                                $amoutzf = $finalqute_disp->final_installement;
                                $first_installement = $finalqute_disp->first_installement;
                                $uid = $finalqute_disp->uid;
                                $flight_amount_group = $finalqute_disp->flight_amount;
                                $ctrip_status = $finalqute_disp->trip_status;
                                $pay_date1 = $finalqute_disp->pay_date1;
                                $pay_date2 = $finalqute_disp->pay_date2;
                                $txnid = $finalqute_disp->txnid;
                                $txnid2 = $finalqute_disp->txnid2;
                                $ifirstinsta_price_group = $finalqute_disp->first_installement;
                                $last_day_for_first_installements = $finalqute_disp->last_day_for_first_installement;
                                $last_day_for_final_installement = $finalqute_disp->last_day_for_final_installement;
                                $pay_time1 = date('h:i A', strtotime($pay_date1));
                                $pay_date1 = date('d-M-Y', strtotime($pay_date1));
                                $cdtime = date('Y-m-d H:i:s', strtotime($last_day_for_first_installements));
                                $cltime = date('Y-m-d H:i:s', strtotime($last_day_for_final_installement));
                            }
                            $sql = "SELECT * FROM `#__users` WHERE id=$user_id";
                            $db->setQuery($sql);
                            $events_detail = $db->loadObjectList();
                            foreach ($events_detail as $event_disp) {
                                $userid = $event_disp->id;
                                $username = $event_disp->name;
                                $contact = $event_disp->phone;
                                $mail = $event_disp->email;
                            }
                            if ($c_payment_status == 'first_installment' || $c_payment_status == 'final_installment') {
                                echo '<div class="display_quote firstin"><h1>Customized Trip - First Installment - Receipt</h1>';
                                if ($payment_type == 'Normal' || $payment_type == 'Participative') {
                                    echo '
                                <p><b>Payment Date</b><span>:</span><span>' . $pay_date1 . '</span></p>
                                <p><b>Payment Time</b><span>:</span><span>' . $pay_time1 . '</span></p>
                                <p><b>Name</b><span>:</span><span>' . $username . '</span></p>
                                <p><b>Mobile Number</b><span>:</span><span>' . $contact . '</span></p>
                                <p><b>Order Id</b><span>:</span><span>' . $orderid . '</span></p>
                                <p><b>Account Number</b><span>:</span><span>' . $userid . '</span></p>
                                <p><b>Transaction Id</b><span>:</span><span>' . $txnid . '</span></p>
                                <p><b>Pay via</b><span>:</span><span>Pay u money</span></p>
                                <p><b>Amount Paid</b><span>:</span><span>' . $ifirstinsta_price_group . '</span></p> ';
                                }
                                if (($ckhtym) < ($cltime)) {
                                    if ($c_payment_status == 'first_installment') {
                                        if ($payment_type == 'Split' || ($payment_type == 'Participative')) {
                                            $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $orderid . '&t=1';

                                            echo '<div class="paynow">';
                                            echo '<p id="paylink">
                                            <a href="' . $paymentlink . '" class="a2a_button_facebook" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput" readonly></a></p>
                                            <p class="set_link"> <button onclick="myFunction()" class="cpbtn">Copy Link</button></p>';
                                            echo "</div>";
                                        } else {
                                            ?>
                                            <div class="paynow">
                                                <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $orderid; ?>' enctype='multipart/form-data'>
                                                   <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                   <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                   <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                   <input type="hidden" value="customized-<?php echo $orderid; ?>-final" id="productinfo" name="productinfo">
                                                   <input type="hidden" value="<?php echo $amoutzf; ?>" id="amount" name="amount">
                                                   <input type="submit" value="Pay Final Installment" id="cb" name="cb">
                                                </form>
                                            </div>
                                        <?php

                                    }
                                }
                            } else {
                                if ($c_payment_status == 'first_installment' || $c_payment_status == 'final_installment') {

                                } else {
                                    echo '<div class="paynow">Link expired contact us</div>';
                                }
                            }
                            echo '</div>';
                        } else {
                            if (($ckhtym) < ($cdtime)) {
                                echo '<div class="display_quote"><h1>Customized Trip</h1>';
                                if ($orderid != '' && $ctrip_status != '') {
                                    $sqlgetdoc = "SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$orderid AND trip_type='customized'";
                                    $db->setQuery($sqlgetdoc);
                                    $doc_count = $db->loadResult();
                                    if ($doc_count == 0) {
                                        echo '<div class="paynow"><p><a class="cpbtn" href="' . JURI::root() . 'index.php?option=com_trips&view=trips&layout=documents&oid=' . $orderid . '&orderby=customized">Book Now</a></p></div>';
                                    } else if ($payment_type == 'Split') {
                                        $sql_get_share = "SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$orderid AND trip_type='customized' AND pay_status='first'";
                                        $db->setQuery($sql_get_share);
                                        $share_pay_amt = $db->loadResult();
                                        $first_install_balance_amt = $first_installement - $share_pay_amt;

                                        if ($first_install_balance_amt == 0) {
                                            $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $orderid . '&t=1';
                                        } else {
                                            $paymentlink = '' . JURI::root() . 'share-payment/?oid=' . $orderid . '&t=1';
                                        }
                                        echo '<div class="paynow">';
                                        echo '<p id="paylink">
                                            <a href="' . $paymentlink . '" class="a2a_button_facebook" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput" readonly></a></p>
                                           <p class="set_link">  <button onclick="myFunction()" class="cpbtn">Copy Link</button></p>';
                                        echo '</div>';
                                    } else if ($payment_type == 'Participative') {
                                            // get first installment status
                                        ?>
                                            <div class="paynow">
                                                <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $orderid; ?>' enctype='multipart/form-data'>
                                                    <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                    <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                    <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                    <input type="hidden" value="customized-<?php echo $orderid; ?>-first" id="productinfo" name="productinfo">
                                                    <input type="hidden" value="<?php echo $amoutz; ?>" id="amount" name="amount">
                                                    <input type="submit" value="Pay First Installment" id="cb" name="cb">
                                                </form>
                                            </div>
                                        <?php

                                    } else {
                                            // get first installment status
                                        ?>
                                            <div class="paynow">
                                                <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $orderid; ?>' enctype='multipart/form-data'>
                                                    <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                    <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                    <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                    <input type="hidden" value="customized-<?php echo $orderid; ?>-first" id="productinfo" name="productinfo">
                                                    <input type="hidden" value="<?php echo $amoutz; ?>" id="amount" name="amount">
                                                    <input type="submit" value="Pay First Installment" id="cb" name="cb">
                                                </form>
                                            </div>
                                         <?php

                                    }
                                }
                                echo '</div>';
                            } else {
                                if ($c_payment_status == 'first_installment' || $c_payment_status == 'final_installment' || $c_payment_status == 'intialized') {

                                } else {
                                    echo '<div class="expire_box display_quote"><h1>Customized Trip</h1><p class="paynow">Your Payment Link has expired, please contact us.</p></div>';
                                }
                            }
                        }
                    }
                    ?>
                        </div>
                    </div>
                    <!--fpce-->
                    <!--fpss-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                        $sqlz = "SELECT COUNT(id) FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                        $db->setQuery($sqlz);
                        $semicustomized_order_count = $db->loadResult();
                        if ($semicustomized_order_count != '0' && $t == 2) {
                            $sqlfirst = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sqlfirst);
                            $semi_orderfirstdetails = $db->loadObjectList();
                            foreach ($semi_orderfirstdetails as $semiorder_disp1) {
                                $number_people1 = $semiorder_disp1->number_peoples;
                                $number_rooms1 = $semiorder_disp1->number_rooms;
                                $orderid = $semiorder_disp1->id;
                                $soderid = $semiorder_disp1->id;
                                $dateofdeparture1 = $semiorder_disp1->trip_date;
                                $flight1 = $semiorder_disp1->flight;
                                $place_of_dept1 = $semiorder_disp1->place_of_dept;
                                $paymethod1 = $semiorder_disp1->paymethod;
                                $payment_type = $semiorder_disp1->paymethod;
                                $noofdays1 = $semiorder_disp1->noofdays;
                                $trip_id1 = $semiorder_disp1->trip_id;
                                $payment_status = $semiorder_disp1->payment_status;
                                $pay_date1 = $semiorder_disp1->pay_date1;
                                $pay_date2 = $semiorder_disp1->pay_date2;
                                $txnid = $semiorder_disp1->txnid;
                                $txnid2 = $semiorder_disp1->txnid2;
                                $trip_status = $semiorder_disp1->trip_status;
                                $sfirstinsta_price_group = $semiorder_disp1->first_installement;
                                $semi_first_installement = $semiorder_disp1->first_installement;
                                $semi_final_installement = $semiorder_disp1->final_installement;
                                $last_day_for_first_installement = $semiorder_disp1->last_day_for_first_installement;
                                $last_day_for_final_installement = $semiorder_disp1->last_day_for_final_installement;
                                $pay_time1 = date('h:i A', strtotime($pay_date1));
                                $pay_date1 = date('d-M-Y', strtotime($pay_date1));
                                $sdtime = date('Y-m-d H:i:s', strtotime($last_day_for_first_installement));
                                $sltime = date('Y-m-d H:i:s', strtotime($last_day_for_final_installement));
                            }
                            $sql = "SELECT * FROM `#__users` WHERE id=$user_id";
                            $db->setQuery($sql);
                            $events_detail = $db->loadObjectList();
                            foreach ($events_detail as $event_disp) {
                                $userid = $event_disp->id;
                                $username = $event_disp->name;
                                $contact = $event_disp->phone;
                                $mail = $event_disp->email;
                            }
                            if ($payment_status == 'first_installment' || $payment_status == 'final_installment' ) {
                                echo '<div class="display_quote firstin"> ';
                                if ($payment_type != 'Split') {
                                echo '<h1>Semi Customized Trip - Final Installment - Receipt</h1>
                                <p><b>Payment Date</b><span>:</span><span>' . $pay_date1 . '</span></p>
                                <p><b>Payment Time</b><span>:</span><span>' . $pay_time1 . '</span></p>
                                <p><b>Name</b><span>:</span><span>' . $username . '</span></p>
                                <p><b>Mobile Number</b><span>:</span><span>' . $contact . '</span></p>
                                <p><b>Order Id</b><span>:</span><span>' . $orderid . '</span></p>
                                <p><b>Account Number</b><span>:</span><span>' . $userid . '</span></p>
                                <p><b>Transaction Id</b><span>:</span><span>' . $txnid . '</span></p>
                                <p><b>Pay via</b><span>:</span><span>Pay u money</span></p>
                                <p><b>Amount Paid</b><span>:</span><span>' . $sfirstinsta_price_group . '</span></p> ';
                                }
                                if (($ckhtym) < ($sltime)) {
                                    if ($payment_status == 'first_installment') {
                                        if ($payment_type == 'Split' || $payment_type == 'Participative') {
                                            $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $orderid . '&t=2';
                                            echo '<div class="paynow">';
                                            echo '<p id="paylink">
                                            <a href="' . $paymentlink . '" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput"></a></p>
                                            <p class="set_link"> <button onclick="myFunction()" class="cpbtn">Copy Link</button></p>';
                                            echo '</div>';
                                        } else {
                                            ?>
                                            <div class="paynow">
                                                <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $soderid; ?>' enctype='multipart/form-data'>
                                                     <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                     <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                     <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                     <input type="hidden" value="semi-<?php echo $soderid; ?>-final" id="productinfo" name="productinfo">
                                                     <input type="hidden" value="<?php echo $semi_final_installement; ?>" id="amount" name="amount">
                                                     <input type="submit" value="Pay Final Installment" id="cb" name="cb">
                                                </form>
                                            </div>
                                        <?php

                                    }
                                }
                            } else {
                                if ($payment_status == 'first_installment' || $payment_status == 'final_installment' || $trip_status == '') {

                                } else {
                                    echo '<div class="expire_box2"><p class="paynow">Your Final Payment Link expired contact us</p></div>';
                                }
                            }
                            echo '</div>';
                        } else {
                            if (($ckhtym) < ($sdtime)) {

                                echo '<div class="display_quote"><h1>Semi Customized Trip</h1>';
                                $sqlgetdoc = "SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$soderid AND trip_type='semi'";
                                $db->setQuery($sqlgetdoc);

                                $doc_count = $db->loadResult();
                                if ($doc_count == 0) {
                                    echo '<div class="paynow">';
                                    echo '<p><a class="cpbtn" href="' . JURI::root() . 'index.php?option=com_trips&view=trips&layout=documents&oid=' . $soderid . '&orderby=semi">Book Now</a></p>';
                                    echo '</div>';
                                } else if ($payment_type == 'Split') {
                                    $sql_get_share1 = "SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$orderid AND trip_type='semi' AND pay_status='first'";
                                    $db->setQuery($sql_get_share1);
                                    $semi_share_pay_amt = $db->loadResult();
                                    $semi_first_install_balance_amt = $semi_first_installement - $semi_share_pay_amt;
                                    if ($semi_first_install_balance_amt == 0) {
                                        $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $orderid . '&t=2';
                                    } else {
                                        $paymentlink = '' . JURI::root() . 'share-payment/?oid=' . $orderid . '&t=2';
                                    }
                                    echo '<div class="paynow">';
                                    echo '<p id="paylink">
                                        <a href="' . $paymentlink . '" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput"></a></p>
                                        <p class="set_link"> <button onclick="myFunction()" class="cpbtn">Copy Link</button></p>';
                                    echo '</div>';
                                } else if ($payment_type == 'Participative') {
                                    ?>
                                        <div class="paynow">
                                            <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $soderid; ?>' enctype='multipart/form-data'>
                                                <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                <input type="hidden" value="semi-<?php echo $soderid; ?>-first" id="productinfo" name="productinfo">
                                                <input type="hidden" value="<?php echo $semi_first_installement; ?>" id="amount" name="amount">
                                                <input type="submit" value="Pay First Installment" id="cb" name="cb">
                                            </form>
                                        </div>
                                     <?php

                                } else {
                                    ?>
                                        <div class="paynow">
                                        <h1>Semi Customized Trip</h1>
                                            <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $soderid; ?>' enctype='multipart/form-data'>
                                                <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                <input type="hidden" value="semi-<?php echo $soderid; ?>-first" id="productinfo" name="productinfo">
                                                <input type="hidden" value="<?php echo $semi_first_installement; ?>" id="amount" name="amount">
                                                <input type="submit" value="Pay First Installment" id="cb" name="cb">
                                            </form>
                                        </div>
                                    <?php

                                }
                                echo '</div>';
                            } else {
                                if ($payment_status == 'first_installment' || $payment_status == 'final_installment' || $trip_status == '') {

                                } else {
                                    echo '<div class="expire_box display_quote"><h1>Semi Customized Trip</h1><p class="paynow">Your Payment Link has expired, please contact us.</p></div>';
                                }
                            }
                        }

                    }
                    ?>
                        </div>
                    </div>
                    <!--fpse-->
                    <!--fpfs-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                        /* get fixed final quote */
                        $sql_fix = "SELECT COUNT(id) FROM `#__fixed_trip_orders` WHERE uid='$user_id' LIMIT $qlimit";
                        $db->setQuery($sql_fix);
                        $fixed_order_count = $db->loadResult();
                        if ($urlid != '') {
                            $sql = "SELECT COUNT(id) FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid=$user_id AND payment_status!=''";
                            $db->setQuery($sql);
                            $fixed_count = $db->loadResult();
                        } else {
                            $fixed_count = 0;
                        }

                        if (($fixed_order_count != '0' || $fixed_count != '0') && $t == 3) {

                            $sqlf = "SELECT * FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid='$user_id' LIMIT $qlimit";
                            $db->setQuery($sqlf);
                            $fixed_quotes = $db->loadObjectList();
                            foreach ($fixed_quotes as $fixed_quotation) {
                                $forderid = $fixed_quotation->id;
                                $fno_days = $fixed_quotation->no_of_days;
                                $fno_people = $fixed_quotation->no_of_people;
                                $fpack_title = $fixed_quotation->pack_title;
                                $fdateofdeparture = $fixed_quotation->pack_date;
                                $fpayment_type = $fixed_quotation->paymethod;
                                $fuid = $fixed_quotation->uid;
                                $fpayment_status = $fixed_quotation->payment_status;
                                $ftrip_status = $fixed_quotation->trip_status;
                                $ffinal_cost = $fixed_quotation->total_price_gst;
                                $ffirst_installement = $fixed_quotation->first_installment;
                                $ffinal_installement = $fixed_quotation->final_installment;
                                $flast_day_for_final_installement = $fixed_quotation->final_inst_date;
                                $flast_day_for_first_installement = $fixed_quotation->first_inst_date;
                                $pay_date1 = $fixed_quotation->pay_date1;
                                $pay_date2 = $fixed_quotation->pay_date2;
                                $txnid = $fixed_quotation->txnid;
                                $txnid2 = $fixed_quotation->txnid2;
                                $pay_time1 = date('h:i A', strtotime($pay_date1));
                                $pay_date1 = date('d-M-Y', strtotime($pay_date1));
                                $fdtime = date('Y-m-d H:i:s', strtotime($flast_day_for_first_installement));
                                $fltime = date('Y-m-d H:i:s', strtotime($flast_day_for_final_installement));
                            }
                            $sql = "SELECT * FROM `#__users` WHERE id=$fuid";
                            $db->setQuery($sql);
                            $events_detail = $db->loadObjectList();
                            foreach ($events_detail as $event_disp) {
                                $userid = $event_disp->id;
                                $username = $event_disp->name;
                                $contact = $event_disp->phone;
                                $mail = $event_disp->email;
                            }
                            if ($fpayment_status == 'intialized') {
                                echo '<div class="display_quote"><h1>Fixed Trip</h1>';
                                if (($ckhtym) < ($fdtime)) {
                                    if (($fpayment_status != 'final_installment' || $fpayment_status != 'first_installment') && $ffirst_installement != 0) {
                                        /* Payment section */
                                        $sqlgetdoc = "SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$forderid AND trip_type='fixed'";
                                        $db->setQuery($sqlgetdoc);
                                        $doc_count = $db->loadResult();
                                        if ($doc_count == 0) {
                                            echo '<div class="paynow">';
                                            echo '<p><a class="cpbtn" href="' . JURI::root() . 'index.php?option=com_trips&view=trips&layout=documents&oid=' . $forderid . '&orderby=fixed">Book Now</a></p>';
                                            echo '</div>';
                                        } else if ($fpayment_type == 'Split') {
                                            $sql_get_share3 = "SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$forderid AND trip_type='fixed' AND pay_status='first'";
                                            $db->setQuery($sql_get_share3);
                                            $fixed_share_pay_amt = $db->loadResult();
                                            $ffirst_installement = $ffirst_installement * $fno_people;
                                            $fixed_first_install_balance_amt = $ffirst_installement - $fixed_share_pay_amt;
                                            if ($fixed_first_install_balance_amt == 0) {
                                                $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $forderid . '&t=3';
                                            } else {
                                                $paymentlink = '' . JURI::root() . 'share-payment/?oid=' . $forderid . '&t=3';
                                            }
                                            echo '<div class="paynow">';
                                            echo '<p id="paylink">
                                            <a href="' . $paymentlink . '" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput"></a></p>
                                            <p class="set_link"> <button onclick="myFunction()" class="cpbtn">Copy Link</button></p>';
                                            echo '</div>';
                                        } else if ($fpayment_type == 'Participative') {
                                            $ffirstinsta_price_group = $ffirst_installement * $fno_people;
                                            ?>
                                            <div class="paynow">
                                                 <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $forderid; ?>' enctype='multipart/form-data'>
                                                    <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                    <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                    <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                    <input type="hidden" value="fixed-<?php echo $forderid; ?>-first" id="productinfo" name="productinfo">
                                                    <input type="hidden" value="<?php echo $ffirstinsta_price_group; ?>" id="amount" name="amount">
                                                    <input type="submit" value="Pay First Installment" id="cb" name="cb">
                                                </form>
                                            </div>
                                         <?php

                                    } else {
                                        $ffirstinsta_price_group = $ffirst_installement * $fno_people;
                                        ?>
                                            <div class="paynow">
                                                <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $forderid; ?>' enctype='multipart/form-data'>
                                                    <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                    <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                    <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                    <input type="hidden" value="fixed-<?php echo $forderid; ?>-first" id="productinfo" name="productinfo">
                                                    <input type="hidden" value="<?php echo $ffirstinsta_price_group; ?>" id="amount" name="amount">
                                                    <?php
                                                    if ($fpayment_status == 'first_installment' || $fpayment_status == 'final_installment') {

                                                    } else {
                                                        echo '<input type="submit" value="Pay First Installment" id="cb" name="cb">';
                                                    }

                                                    ?>
                                                </form>
                                            </div>
                                        <?php

                                    }
                                }
                            } else {
                                if ($fpayment_status == 'first_installment') {

                                } else {
                                    echo '<div class="expire_box"><p class="paynow">Your Payment Link has expired, please contact us.</p></div>';
                                }
                            }
                            echo '</div>';

                        } else {
                            echo '<div class="display_quote firstin">';
                            $ffirstinsta_price_group = $ffirst_installement * $fno_people;
                            $ffinalinsta_price_group = $ffinal_installement * $fno_people;
                            if ($fpayment_type == 'Normal' || $fpayment_type == 'Participative') {
                                echo '<h1>Fixed Trip - First Installment - Receipt</h1>
                                    <p><b>Payment Date</b><span>:</span><span>' . $pay_date1 . '</span></p>
                                    <p><b>Payment Time</b><span>:</span><span>' . $pay_time1 . '</span></p>
                                    <p><b>Name</b><span>:</span><span>' . $username . '</span></p>
                                    <p><b>Mobile Number</b><span>:</span><span>' . $contact . '</span></p>
                                    <p><b>Order Id</b><span>:</span><span>' . $forderid . '</span></p>
                                    <p><b>Account Number</b><span>:</span><span>' . $uid . '</span></p>
                                    <p><b>Transaction Id</b><span>:</span><span>' . $txnid . '</span></p>
                                    <p><b>Pay via</b><span>:</span><span>Pay u money</span></p>
                                    <p><b>Amount Paid</b><span>:</span><span>' . $ffirstinsta_price_group . '</span></p> ';
                            }
                            if ($fpayment_status == 'final_installment' || $fpayment_status == 'intialized') {

                            } else {
                                if (($ckhtym) < ($fltime)) {
                                    echo '<h2>Final payment link</h2>';
                                        /* Payment section */
                                    if ($fpayment_type == 'Split') {
                                        $sql_get_share3 = "SELECT SUM(paid_amt) FROM `#__sharepayment` WHERE orderid=$forderid AND trip_type='fixed' AND pay_status='first'";
                                        $db->setQuery($sql_get_share3);
                                        $fixed_share_pay_amt = $db->loadResult();
                                        $fixed_first_install_balance_amt = $ffirstinsta_price_group - $fixed_share_pay_amt;
                                        if ($fixed_first_install_balance_amt == 0) {
                                            $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $forderid . '&t=3';
                                        } else {
                                            $paymentlink = '' . JURI::root() . 'share-payment/?oid=' . $forderid . '&t=3';
                                        }
                                        echo '<div calss="paynow">';
                                        echo '<p id="paylink">
                                            <a href="' . $paymentlink . '" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput"></a></p>
                                           <p class="set_link"> <button onclick="myFunction()" class="cpbtn">Copy Link</button></p>';
                                        echo '</div>';
                                    } else if ($fpayment_type == 'Participative') {
                                        $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $forderid . '&t=3';
                                        echo '<div calss="paynow">';
                                        echo '<p id="paylink">
                                            <a href="' . $paymentlink . '" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput"></a></p>
                                           <p class="set_link">  <button class="cpbtn" onclick="myFunction()">Copy Link</button></p>';
                                        echo '</div>';
                                    } else {
                                        ?>
                                            <div class="paynow">
                                                <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $forderid; ?>' enctype='multipart/form-data'>
                                                    <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                    <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                    <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                    <input type="hidden" value="fixed-<?php echo $forderid; ?>-final" id="productinfo" name="productinfo">
                                                    <input type="hidden" value="<?php echo $ffinalinsta_price_group; ?>" id="amount" name="amount">
                                            <?php
                                            if ($fpayment_status == 'final_installment' || $fpayment_status == 'final_installment') {

                                            } else {
                                                echo '<input type="submit" value="Pay Final payment" id="cb" name="cb">';
                                            }

                                            ?>
                                                </form>
                                            </div>
                                        <?php

                                    }
                                } else {
                                    if ($fpayment_status == 'final_installment') {

                                    } else {
                                        echo '<div class="expire_box2"><h1>Fixed Trip - Final payment link</h1><p class="paynow">Your Payment Link has expired, please contact us.</p></div>';
                                    }
                                }
                            }
                            echo '</div>';
                        }
                    }
                    ?>
                        </div>
                    </div>
                    <!--fpfe-->
                    <!---share result--->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                        /*  share payment detail */
                        $sharepayorderc = "SELECT id FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id";
                        $db->setQuery($sharepayorderc);
                        $sharepayorder_count = $db->loadResult();

                        $sharepayorders = "SELECT id FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                        $db->setQuery($sharepayorders);
                        $sharepayorders_count = $db->loadResult();

                        $sql_fix = "SELECT id FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid='$user_id'";
                        $db->setQuery($sql_fix);
                        $fixed_order_count = $db->loadResult();

                        if ($sharepayorder_count != 0) {

                            $sharepayorder = "SELECT * FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id";
                            $db->setQuery($sharepayorder);
                            $sharepayorders = $db->loadObjectList();
                            foreach ($sharepayorders as $sharepayorders_disp) {
                                $share_orderid1 = $sharepayorders_disp->id;
                            }

                        } else {
                            $share_orderid1 = '';
                        }
                        if ($sharepayorders_count != 0) {
                            /**** AND (payment_status!='final_installment' || payment_status!='first_installment')***/
                            $sharepayorder = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sharepayorder);
                            $sharepayorders = $db->loadObjectList();
                            foreach ($sharepayorders as $sharepayorders_disp) {
                                $share_orderid2 = $sharepayorders_disp->id;
                            }
                        } else {
                            $share_orderid2 = '';
                        }

                        if ($fixed_order_count != 0) {
                            $sharepayorder = "SELECT * FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid=$user_id";
                            $db->setQuery($sharepayorder);
                            $sharepayorders = $db->loadObjectList();
                            foreach ($sharepayorders as $sharepayorders_disp) {
                                $share_orderid3 = $sharepayorders_disp->id;
                            }
                        } else {
                            $share_orderid3 = '';
                        }
                        echo '<div class="sharepay_details">';

                        if ($share_orderid1 && $t == 1) {

                            $sharepay = "SELECT * FROM `#__sharepayment` WHERE organizer_id=$user_id AND orderid=$share_orderid1 AND trip_type='customized'";
                            $db->setQuery($sharepay);
                            $sharepay_list = $db->loadObjectList();
                            foreach ($sharepay_list as $sharepay_list_disp) {
                                $share_payid = $sharepay_list_disp->id;
                                $share_trip_type = $sharepay_list_disp->trip_type; // ex customized
                                $share_payment_type = $sharepay_list_disp->payment_type; // ex split
                                $share_orderid = $sharepay_list_disp->orderid;
                                $share_friendname = $sharepay_list_disp->friendname;
                                $share_friendemail = $sharepay_list_disp->friendemail;
                                $share_friendnum = $sharepay_list_disp->friendnum;
                                $paymentlink = $sharepay_list_disp->paymentlink;
                                $pay_status = $sharepay_list_disp->pay_status;
                                $txnid = $sharepay_list_disp->txnid;
                                $paid_amt = $sharepay_list_disp->paid_amt;
                                if ($pay_status == 'first') {
                                    ?>
                                    <div class="display_quote orderlists">
                                        <p><span class="share_label">Order Id</span> : <span class="share_detail"><?php echo $share_orderid; ?></span></p>
                                        <p><span class="share_label">Payment Type </span> : <span class="share_detail"><?php echo $share_payment_type; ?></span></p>
                                        <p><span class="share_label">Payer Name </span> : <span class="share_detail"><?php echo $share_friendname; ?></span></p>
                                        <p><span class="share_label">Payer Number</span> : <span class="share_detail"><?php echo $share_friendnum ; ?></span></p>
                                        <p><span class="share_label">Payer E-mail</span> : <span class="share_detail"><?php echo $share_friendemail; ?></span></p>
                                        <p><span class="share_label">Payment Link</span> : <span class="share_detail"><?php echo $paymentlink; ?></span></p>
                                        <p><span class="share_label">Installment </span> : <span class="share_detail"><?php echo $pay_status; ?></span></p>
                                        <p><span class="share_label">Amount</span> : <span class="share_detail"><?php echo $paid_amt; ?></span></p>
                                        <p><span class="share_label">Transaction Id</span> : <span class="share_detail"><?php echo $txnid; ?></span></p>
                                    </div>
                                <?php

                            }
                        }
                    } else if ($share_orderid2 && $t == 2) {
                        $sharepay = "SELECT * FROM `#__sharepayment` WHERE organizer_id=$user_id AND orderid=$share_orderid2 AND trip_type='semi'";
                        $db->setQuery($sharepay);
                        $sharepay_list = $db->loadObjectList();

                        foreach ($sharepay_list as $sharepay_list_disp) {
                            $share_payid = $sharepay_list_disp->id;
                            $share_trip_type = $sharepay_list_disp->trip_type; // ex customized
                            $share_payment_type = $sharepay_list_disp->payment_type; // ex split
                            $share_orderid = $sharepay_list_disp->orderid;
                            $share_friendname = $sharepay_list_disp->friendname;
                            $share_friendemail = $sharepay_list_disp->friendemail;
                            $share_friendnum = $sharepay_list_disp->friendnum;
                            $paymentlink = $sharepay_list_disp->paymentlink;
                            $pay_status = $sharepay_list_disp->pay_status;
                            $txnid = $sharepay_list_disp->txnid;
                            $paid_amt = $sharepay_list_disp->paid_amt;
                            if ($pay_status == 'first') {
                                ?>
                                    <div class="display_quote orderlists">
                                        <p><span class="share_label">Order Id</span> : <span class="share_detail"><?php echo $share_orderid; ?></span></p>
                                        <p><span class="share_label">Payment Type </span> : <span class="share_detail"><?php echo $share_payment_type; ?></span></p>
                                        <p><span class="share_label">Payer Name </span> : <span class="share_detail"><?php echo $share_friendname; ?></span></p>
                                        <p><span class="share_label">Payer Number</span> : <span class="share_detail"><?php echo $share_friendnum ; ?></span></p>
                                        <p><span class="share_label">Payer E-mail</span> : <span class="share_detail"><?php echo $share_friendemail; ?></span></p>
                                        <p><span class="share_label">Payment Link</span> : <span class="share_detail"><?php echo $paymentlink; ?></span></p>
                                        <p><span class="share_label">Installment </span> : <span class="share_detail"><?php echo $pay_status; ?></span></p>
                                        <p><span class="share_label">Amount</span> : <span class="share_detail"><?php echo $paid_amt; ?></span></p>
                                        <p><span class="share_label">Transaction Id</span> : <span class="share_detail"><?php echo $txnid; ?></span></p></div>
                                <?php

                            }
                        }
                    } else if ($share_orderid3 && $t == 3) {
                        $sharepay = "SELECT * FROM `#__sharepayment` WHERE organizer_id=$user_id AND orderid=$share_orderid3 AND trip_type='fixed'";
                        $db->setQuery($sharepay);
                        $sharepay_list = $db->loadObjectList();

                        foreach ($sharepay_list as $sharepay_list_disp) {
                            $share_payid = $sharepay_list_disp->id;
                            $share_trip_type = $sharepay_list_disp->trip_type; // ex customized
                            $share_payment_type = $sharepay_list_disp->payment_type; // ex split
                            $share_orderid = $sharepay_list_disp->orderid;
                            $share_friendname = $sharepay_list_disp->friendname;
                            $share_friendemail = $sharepay_list_disp->friendemail;
                            $share_friendnum = $sharepay_list_disp->friendnum;
                            $paymentlink = $sharepay_list_disp->paymentlink;
                            $pay_status = $sharepay_list_disp->pay_status;
                            $txnid = $sharepay_list_disp->txnid;
                            $paid_amt = $sharepay_list_disp->paid_amt;
                            if ($pay_status == 'first') {
                                ?>
                                    <div class="display_quote orderlists">
                                        <p><span class="share_label">Order Id</span> : <span class="share_detail"><?php echo $share_orderid; ?></span></p>
                                        <p><span class="share_label">Payment Type </span> : <span class="share_detail"><?php echo $share_payment_type; ?></span></p>
                                        <p><span class="share_label">Payer Name </span> : <span class="share_detail"><?php echo $share_friendname; ?></span></p>
                                        <p><span class="share_label">Payer Number</span> : <span class="share_detail"><?php echo $share_friendnum; ?></span></p>
                                        <p><span class="share_label">Payer E-mail</span> : <span class="share_detail"><?php $share_friendemail ; ?></span></p>
                                        <p><span class="share_label">Payment Link</span> : <span class="share_detail"><?php echo $paymentlink; ?></span></p>
                                        <p><span class="share_label">Installment </span> : <span class="share_detail"><?php echo $pay_status; ?></span></p>
                                        <p><span class="share_label">Amount</span> : <span class="share_detail"><?php echo $paid_amt; ?></span></p>
                                        <p><span class="share_label">Transaction Id</span> : <span class="share_detail"><?php echo $txnid; ?></span></p>
                                    </div>
                                <?php

                            }
                        }
                    } else {
                        echo '';
                    }
                    echo '</div>';
                        /*  share payment detail */
                    ?>
                        </div>
                    </div>
                </div>
                <!--Select3-->
                <!--Select4-->
                <div ng-show='selected == 4'>
                    <!--lpcs-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                        /* get customized final quote */
                        if ($urlid != '') {
                            $sql = "SELECT COUNT(id) FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id AND payment_status!=''";
                            $db->setQuery($sql);
                            $customized_count = $db->loadResult();
                        } else {
                            $customized_count = 0;
                        }


                        if (($customized_order_count != '0' || $customized_count != '0') && $t == 1) {
                            $sqlx = "SELECT * FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id LIMIT $qlimit";
                            $db->setQuery($sqlx);
                            $final_detail = $db->loadObjectList();
                            foreach ($final_detail as $finalqute_disp) {
                                $orderid = $finalqute_disp->id;
                                $no_days = $finalqute_disp->no_days;
                                $no_people = $finalqute_disp->no_people;
                                $placeofdeparture = $finalqute_disp->placeofdeparture;
                                $write_us = $finalqute_disp->write_us;
                                $payment_type = $finalqute_disp->payment_type;
                                $c_payment_status = $finalqute_disp->payment_status;
                                $amoutz = $finalqute_disp->first_installement;
                                $amoutzf = $finalqute_disp->final_installement;
                                $first_installement = $finalqute_disp->first_installement;
                                $uid = $finalqute_disp->uid;
                                $flight_amount_group = $finalqute_disp->flight_amount;
                                $ctrip_status = $finalqute_disp->trip_status;
                                $pay_date1 = $finalqute_disp->pay_date1;
                                $pay_date2 = $finalqute_disp->pay_date2;
                                $txnid = $finalqute_disp->txnid;
                                $txnid2 = $finalqute_disp->txnid2;
                                $ifirstinsta_price_group = $finalqute_disp->first_installement;
                                $last_day_for_first_installements = $finalqute_disp->last_day_for_first_installement;
                                $last_day_for_final_installement = $finalqute_disp->last_day_for_final_installement;
                                $pay_time2 = date('h:i A', strtotime($pay_date2));
                                $pay_date2 = date('d-M-Y', strtotime($pay_date2));
                                $cdtime = date('Y-m-d H:i:s', strtotime($last_day_for_first_installements));
                                $cltime = date('Y-m-d H:i:s', strtotime($last_day_for_final_installement));;
                            }
                            $sql = "SELECT * FROM `#__users` WHERE id=$user_id";
                            $db->setQuery($sql);
                            $events_detail = $db->loadObjectList();
                            foreach ($events_detail as $event_disp) {
                                $userid = $event_disp->id;
                                $username = $event_disp->name;
                                $contact = $event_disp->phone;
                                $mail = $event_disp->email;
                            }
                            if ($c_payment_status == 'final_installment' && $payment_type == 'Normal') {
                                echo '<div class="display_quote firstin">
                                <h1>Customized Trip - Final Installment - Receipt</h1>
                                <p><b>Payment Date</b><span>:</span><span>' . $pay_date2 . '</span></p>
                                <p><b>Payment Time</b><span>:</span><span>' . $pay_time2 . '</span></p>
                                <p><b>Name</b><span>:</span><span>' . $username . '</span></p>
                                <p><b>Mobile Number</b><span>:</span><span>' . $contact . '</span></p>
                                <p><b>Order Id</b><span>:</span><span>' . $orderid . '</span></p>
                                <p><b>Account Number</b><span>:</span><span>' . $userid . '</span></p>
                                <p><b>Transaction Id</b><span>:</span><span>' . $txnid2 . '</span></p>
                                <p><b>Pay via</b><span>:</span><span>Pay u money</span></p>
                                <p><b>Amount Paid</b><span>:</span><span>' . $amoutzf . '</span></p>
                                </div>';
                            }
                            if ($c_payment_status == 'first_installment' && ($ckhtym) < ($cltime)) {
                                if ($payment_type == 'Split') {
                                    $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $orderid . '&t=1';
                                    echo '<div class="display_quote">';
                                    echo '<h1>Customized Trip - Final Payment Link</h3>';
                                    echo '<p id="paylink">
                                    <a href="' . $paymentlink . '" class="a2a_button_facebook" target="_blank">
                                    <input type="text" value="' . $paymentlink . '" name="myInput" id="myInput2" readonly></a></p>
                                    <p class="set_link"> <button onclick="myFunction2()" class="cpbtn">Copy Link</button></p>';
                                    echo '</div>';
                                } else if ($payment_type == 'Participative') {
                                    $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $orderid . '&t=1';
                                    echo '<div class="display_quote">';
                                    echo '<h1>Customized Trip - Final Payment Link</h3>';
                                    echo '<p id="paylink">
                                    <a href="' . $paymentlink . '" class="a2a_button_facebook" target="_blank">
                                    <input type="text" value="' . $paymentlink . '" name="myInput" id="myInput2" readonly></a></p>
                                    <p class="set_link"><button onclick="myFunction2()" class="cpbtn">Copy Link</button></p>';
                                    echo '</div>';
                                } else {
                                    // get first installment status
                                    ?>
                                    <div class="display_quote">
                                    <h1>Customized Trip - Final Installment Payment Link</h1>
                                        <div class="paynow">
                                            <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $orderid; ?>' enctype='multipart/form-data'>
                                                <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                <input type="hidden" value="customized-<?php echo $orderid; ?>-final" id="productinfo" name="productinfo">
                                                <input type="hidden" value="<?php echo $amoutzf; ?>" id="amount" name="amount">
                                                <input type="submit" value="Pay Final Installment" id="cb" name="cb">
                                            </form>
                                        </div>
                                    </div>
                            <?php

                        }
                    } else {
                        if ($c_payment_status == 'final_installment') {

                        } else if ($c_payment_status == 'first_installment') {
                            echo '<div class="display_quote"><h1>Customized Trip</h1><p>Your Link Expired contact us</p></div>';
                        } else {

                        }
                    }
                }
                ?>
                        </div>
                    </div>
                    <!--lpce-->
                    <!--lpss-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                        $sqlz = "SELECT COUNT(id) FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                        $db->setQuery($sqlz);
                        $semicustomized_order_count = $db->loadResult();
                        if ($semicustomized_order_count != '0' && $t == 2) {
                            $sqlfirst = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sqlfirst);
                            $semi_orderfirstdetails = $db->loadObjectList();
                            foreach ($semi_orderfirstdetails as $semiorder_disp1) {
                                $number_people1 = $semiorder_disp1->number_peoples;
                                $number_rooms1 = $semiorder_disp1->number_rooms;
                                $orderid = $semiorder_disp1->id;
                                $soderid = $semiorder_disp1->id;
                                $dateofdeparture1 = $semiorder_disp1->trip_date;
                                $flight1 = $semiorder_disp1->flight;
                                $place_of_dept1 = $semiorder_disp1->place_of_dept;
                                $paymethod1 = $semiorder_disp1->paymethod;
                                $payment_type = $semiorder_disp1->paymethod;
                                $noofdays1 = $semiorder_disp1->noofdays;
                                $trip_id1 = $semiorder_disp1->trip_id;
                                $payment_status = $semiorder_disp1->payment_status;
                                $pay_date1 = $semiorder_disp1->pay_date1;
                                $pay_date2 = $semiorder_disp1->pay_date2;
                                $txnid = $semiorder_disp1->txnid;
                                $txnid2 = $semiorder_disp1->txnid2;
                                $sfirstinsta_price_group = $semiorder_disp1->first_installement;
                                $semi_first_installement = $semiorder_disp1->first_installement;
                                $semi_final_installement = $semiorder_disp1->final_installement;
                                $last_day_for_first_installement = $semiorder_disp1->last_day_for_first_installement;
                                $last_day_for_final_installement = $semiorder_disp1->last_day_for_final_installement;
                                $pay_time2 = date('h:i A', strtotime($pay_date2));
                                $pay_date2 = date('d-M-Y', strtotime($pay_date2));
                                $sdtime = date('Y-m-d H:i:s', strtotime($last_day_for_first_installement));
                                $sltime = date('Y-m-d H:i:s', strtotime($last_day_for_final_installement));
                            }
                            $sql = "SELECT * FROM `#__users` WHERE id=$user_id";
                            $db->setQuery($sql);
                            $events_detail = $db->loadObjectList();
                            foreach ($events_detail as $event_disp) {
                                $userid = $event_disp->id;
                                $username = $event_disp->name;
                                $contact = $event_disp->phone;
                                $mail = $event_disp->email;
                            }
                            if (($payment_status == 'final_installment') && ($payment_type ==  'Normal')) {
                                echo '<div class="display_quote firstin"> <h1>Semi Customized Trip - Final Installement - Receipt</h1>
                                <p><b>Payment Date</b><span>:</span><span>' . $pay_date2 . '</span></p>
                                <p><b>Payment Time</b><span>:</span><span>' . $pay_time2 . '</span></p>
                                <p><b>Name</b><span>:</span><span>' . $username . '</span></p>
                                <p><b>Mobile Number</b><span>:</span><span>' . $contact . '</span></p>
                                <p><b>Order Id</b><span>:</span><span>' . $orderid . '</span></p>
                                <p><b>Account Number</b><span>:</span><span>' . $userid . '</span></p>
                                <p><b>Transaction Id</b><span>:</span><span>' . $txnid2 . '</span></p>
                                <p><b>Pay via</b><span>:</span><span>Pay u money</span></p>
                                <p><b>Amount Paid</b><span>:</span><span>' . $semi_final_installement . '</span></p> ';
                                echo '</div>';
                            } else if ($payment_status == 'first_installment') {
                                if (($ckhtym) < ($sltime)) {
                                    echo '<div class="display_quote"><h1>Semi Customized Final Payment link</h1>';
                                    if ($payment_type == 'Split') {
                                        $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $orderid . '&t=2';
                                        echo '<div class="paynow"><p id="paylink">
                                        <a href="' . $paymentlink . '" target="_blank">
                                        <input type="text" value="' . $paymentlink . '" name="myInput" id="myInput2"></a></p>
                                        <p class="set_link"> <button onclick="myFunction2()" class="cpbtn">Copy Link</button></p></div>';
                                    } else if ($payment_type == 'Participative') {
                                        $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $orderid . '&t=2';
                                        echo '<div class="paynow"><p id="paylink">
                                        <a href="' . $paymentlink . '" class="a2a_button_facebook" target="_blank">
                                        <input type="text" value="' . $paymentlink . '" name="myInput" id="myInput2" readonly></a></p>
                                        <p class="set_link"> <button onclick="myFunction2()" class="cpbtn">Copy Link</button></p></div>';
                                    } else {
                                        ?>
                                        <div class="paynow">
                                            <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $soderid; ?>' enctype='multipart/form-data'>
                                                <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                <input type="hidden" value="semi-<?php echo $soderid; ?>-final" id="productinfo" name="productinfo">
                                                <input type="hidden" value="<?php echo $semi_final_installement; ?>" id="amount" name="amount">
                                                <input type="submit" value="Pay Final Installment" id="cb" name="cb">
                                            </form>
                                        </div>
                                    <?php

                                }
                            } else {
                                echo '<div class="display_quote"><h1>Semi Customized Trip</h1><p>Link expired contact us</p></div>';
                            }
                        } else {

                        }
                    }
                    ?>
                        </div>
                    </div>
                    <!--lpse-->
                    <!--lpfs-->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                        /* get fixed final quote */
                        $sql_fix = "SELECT COUNT(id) FROM `#__fixed_trip_orders` WHERE uid='$user_id' LIMIT $qlimit";
                        $db->setQuery($sql_fix);
                        $fixed_order_count = $db->loadResult();
                        if ($urlid != '') {
                            $sql = "SELECT COUNT(id) FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid=$user_id AND payment_status!=''";
                            $db->setQuery($sql);
                            $fixed_count = $db->loadResult();
                        } else {
                            $fixed_count = 0;
                        }
                        if (($fixed_order_count != '0' || $fixed_count != '0') && $t == 3) {
                            $sqlf = "SELECT * FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid=$user_id LIMIT $qlimit";
                            $db->setQuery($sqlf);
                            $fixed_quotes = $db->loadObjectList();
                            foreach ($fixed_quotes as $fixed_quotation) {
                                $forderid = $fixed_quotation->id;
                                $fno_days = $fixed_quotation->no_of_days;
                                $fno_people = $fixed_quotation->no_of_people;
                                $fpack_title = $fixed_quotation->pack_title;
                                $fdateofdeparture = $fixed_quotation->pack_date;
                                $fpayment_type = $fixed_quotation->paymethod;
                                $fuid = $fixed_quotation->uid;
                                $fpayment_status = $fixed_quotation->payment_status;
                                $ftrip_status = $fixed_quotation->trip_status;
                                $ffinal_cost = $fixed_quotation->total_price_gst;
                                $ffirst_installement = $fixed_quotation->first_installment;
                                $ffinal_installement = $fixed_quotation->final_installment;
                                $flast_day_for_final_installement = $fixed_quotation->final_inst_date;
                                $flast_day_for_first_installement = $fixed_quotation->first_inst_date;
                                $pay_date1 = $fixed_quotation->pay_date1;
                                $pay_date2 = $fixed_quotation->pay_date2;
                                $txnid = $fixed_quotation->txnid;
                                $txnid2 = $fixed_quotation->txnid2;
                                $ffirst_installement = $ffirst_installement * $fno_people;
                                $pay_time1 = date('h:i A', strtotime($pay_date1));
                                $pay_date1 = date('d-M-Y', strtotime($pay_date1));
                                $pay_time2 = date('h:i A', strtotime($pay_date2));
                                $pay_date2 = date('d-M-Y', strtotime($pay_date2));
                                $fdtime = date('Y-m-d H:i:s', strtotime($flast_day_for_first_installement));
                                $fltime = date('Y-m-d H:i:s', strtotime($flast_day_for_final_installement));
                            }
                            $sql = "SELECT * FROM `#__users` WHERE id=$uid";
                            $db->setQuery($sql);
                            $events_detail = $db->loadObjectList();
                            foreach ($events_detail as $event_disp) {
                                $userid = $event_disp->id;
                                $username = $event_disp->name;
                                $contact = $event_disp->phone;
                                $mail = $event_disp->email;
                            }
                            if ($fpayment_status == 'first_installment' || $fpayment_status == 'intialized') {
                                if (($ckhtym) < ($fltime)) {
                                    echo '<div class="display_quote">';
                                    echo '<h1>Fixed Trip Final Payment Link</h3>';
                                    if ($fpayment_status == 'first_installment') {
                                        if ($fpayment_type == 'Split' || $fpayment_type == 'Participative') {
                                            $paymentlink = '' . JURI::root() . 'final-share-payment/?oid=' . $forderid . '&t=3';
                                            echo '<p id="paylink">
                                            <a href="' . $paymentlink . '" target="_blank"><input type="text" value="' . $paymentlink . '" name="myInput" id="myInput2"></a></p>
                                            <p class="set_link"><button onclick="myFunction2()" class="cpbtn">Copy Link</button></p>';
                                        } else {
                                            ?>
                                            <div class="paynow">
                                                <form method='POST' action='<?php echo JURI::root(); ?>index.php?option=com_trips&view=trips&layout=payment&oid=<?php echo $orderid; ?>' enctype='multipart/form-data'>
                                                    <input type="hidden" value="<?php echo $username; ?>" id="firstname" name="firstname">
                                                    <input type="hidden" value="<?php echo $mail; ?>" id="email" name="email">
                                                    <input type="hidden" value="<?php echo $contact; ?>" id="phone" name="phone">
                                                    <input type="hidden" value="fixed-<?php echo $forderid; ?>-final" id="productinfo" name="productinfo">
                                                    <input type="hidden" value="<?php echo $ffinalinsta_price_group; ?>" id="amount" name="amount">
                                                    <?php
                                                    if ($fpayment_status == 'intialized' || $fpayment_status == 'final_installment') {

                                                    } else {
                                                        echo '<input type="submit" value="Pay Final Installment" id="cb" name="cb">';
                                                    }
                                                    ?>
                                                </form>
                                            </div>
                                        <?php

                                    }
                                }
                                echo '</div>';
                            } else if ($fpayment_status == 'first_installment') {
                                echo '<div class="display_quote"><h1>Fixed Trip</h1><p>Link expired contact us</p></div>';
                            }
                        } else {
                            if ($fpayment_type == 'Normal') {
                                $ffirstinsta_price_group = $ffirst_installement * $fno_people;
                                $ffinalinsta_price_group = $ffinal_installement * $fno_people;
                                echo '<div class="display_quote firstin">
                                    <h1>Fixed Trip - Final Installement - Receipt</h1>
                                    <p><b>Payment Date</b><span>:</span><span>' . $pay_date2 . '</span></p>
                                    <p><b>Payment Time</b><span>:</span><span>' . $pay_time2 . '</span></p>
                                    <p><b>Name</b><span>:</span><span>' . $username . '</span></p>
                                    <p><b>Mobile Number</b><span>:</span><span>' . $contact . '</span></p>
                                    <p><b>Order Id</b><span>:</span><span>' . $forderid . '</span></p>
                                    <p><b>Account Number</b><span>:</span><span>' . $uid . '</span></p>
                                    <p><b>Transaction Id</b><span>:</span><span>' . $txnid2 . '</span></p>
                                    <p><b>Pay via</b><span>:</span><span>Pay u money</span></p>
                                    <p><b>Amount Paid</b><span>:</span><span>' . $ffinalinsta_price_group . '</span></p>
                                    </div>';
                            }
                        }
                    }
                    ?>
                        </div>
                    </div>
                    <!--lpfe-->
                    <!---share result--->
                    <div class="Booking_detail">
                        <div class='profile_main_fixed'>
                        <?php
                         /*  share payment detail */

                        $sharepayorderc = "SELECT id FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id";
                        $db->setQuery($sharepayorderc);
                        $sharepayorder_count = $db->loadResult();

                        $sharepayorders = "SELECT id FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND (payment_status!='final_installment' || payment_status!='first_installment') AND quote_status=$quote_status";
                        $db->setQuery($sharepayorders);
                        $sharepayorders_count = $db->loadResult();

                        $sql_fix = "SELECT id FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid='$user_id'";
                        $db->setQuery($sql_fix);
                        $fixed_order_count = $db->loadResult();

                        if ($sharepayorder_count != 0) {
                            $sharepayorder = "SELECT * FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id";
                            $db->setQuery($sharepayorder);
                            $sharepayorders = $db->loadObjectList();
                            foreach ($sharepayorders as $sharepayorders_disp) {
                                $share_orderid1 = $sharepayorders_disp->id;
                            }
                        } else {
                            $share_orderid1 = '';
                        }
                        if ($sharepayorders_count != 0) {
                            $sharepayorder = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ((payment_status='finalizebyuser') OR (trip_status='quotation')) AND quote_status=$quote_status";
                            $db->setQuery($sharepayorder);
                            $sharepayorders = $db->loadObjectList();
                            foreach ($sharepayorders as $sharepayorders_disp) {
                                $share_orderid2 = $sharepayorders_disp->id;
                            }
                        } else {
                            $share_orderid2 = '';
                        }
                        if ($fixed_order_count != 0) {
                            $sharepayorder = "SELECT * FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid=$user_id";
                            $db->setQuery($sharepayorder);
                            $sharepayorders = $db->loadObjectList();
                            foreach ($sharepayorders as $sharepayorders_disp) {
                                $share_orderid3 = $sharepayorders_disp->id;
                            }
                        } else {
                            $share_orderid3 = '';
                        }
                        echo '<div class="sharepay_details">';

                        if ($share_orderid1 && $t == 1) {

                            $sharepay = "SELECT * FROM `#__sharepayment` WHERE organizer_id=$user_id AND orderid=$share_orderid1  AND trip_type='customized'";
                            $db->setQuery($sharepay);
                            $sharepay_list = $db->loadObjectList();

                            foreach ($sharepay_list as $sharepay_list_disp) {
                                $share_payid = $sharepay_list_disp->id;
                                $share_trip_type = $sharepay_list_disp->trip_type; // ex customized
                                $share_payment_type = $sharepay_list_disp->payment_type; // ex split
                                $share_orderid = $sharepay_list_disp->orderid;
                                $share_friendname = $sharepay_list_disp->friendname;
                                $share_friendemail = $sharepay_list_disp->friendemail;
                                $share_friendnum = $sharepay_list_disp->friendnum;
                                $paymentlink = $sharepay_list_disp->paymentlink;
                                $pay_status = $sharepay_list_disp->pay_status;
                                $txnid = $sharepay_list_disp->txnid;
                                $paid_amt = $sharepay_list_disp->paid_amt;
                                if ($pay_status == 'final') {
                                    ?>
                                    <div class="display_quote orderlists">
                                        <p><span class="share_label">Order Id</span> : <span class="share_detail"><?php echo $share_orderid; ?></span></p>
                                        <p><span class="share_label">Payment Type </span> : <span class="share_detail"><?php echo $share_payment_type; ?></span></p>
                                        <p><span class="share_label">Payer Name </span> : <span class="share_detail"><?php echo $share_friendname; ?></span></p>
                                        <p><span class="share_label">Payer Number</span> : <span class="share_detail"><?php echo $share_friendnum; ?></span></p>
                                        <p><span class="share_label">Payer E-mail</span> : <span class="share_detail"><?php echo $share_friendemail; ?></span></p>
                                        <p><span class="share_label">Payment Link</span> : <span class="share_detail"><?php echo $paymentlink; ?></span></p>
                                        <p><span class="share_label">Installment </span> : <span class="share_detail"><?php echo $pay_status; ?></span></p>
                                        <p><span class="share_label">Amount</span> : <span class="share_detail"><?php echo $paid_amt; ?></span></p>
                                        <p><span class="share_label">Transaction Id</span> : <span class="share_detail"><?php echo $txnid; ?></span></p>
                                    </div>
                                <?php

                            }
                        }
                    } else if ($share_orderid2 && $t == 2) {
                        $sharepay = "SELECT * FROM `#__sharepayment` WHERE organizer_id=$user_id AND orderid=$share_orderid2  AND trip_type='semi'";
                        $db->setQuery($sharepay);
                        $sharepay_list = $db->loadObjectList();

                        foreach ($sharepay_list as $sharepay_list_disp) {
                            $share_payid = $sharepay_list_disp->id;
                            $share_trip_type = $sharepay_list_disp->trip_type; // ex customized
                            $share_payment_type = $sharepay_list_disp->payment_type; // ex split
                            $share_orderid = $sharepay_list_disp->orderid;
                            $share_friendname = $sharepay_list_disp->friendname;
                            $share_friendemail = $sharepay_list_disp->friendemail;
                            $share_friendnum = $sharepay_list_disp->friendnum;
                            $paymentlink = $sharepay_list_disp->paymentlink;
                            $pay_status = $sharepay_list_disp->pay_status;
                            $txnid = $sharepay_list_disp->txnid;
                            $paid_amt = $sharepay_list_disp->paid_amt;
                            if ($pay_status == 'final') {
                                ?>
                                    <div class="display_quote orderlists">
                                        <p><span class="share_label">Order Id</span> : <span class="share_detail"><?php echo $share_orderid; ?></span></p>
                                        <p><span class="share_label">Payment Type </span> : <span class="share_detail"><?php echo $share_payment_type; ?></span></p>
                                        <p><span class="share_label">Payer Name </span> : <span class="share_detail"><?php echo $share_friendname; ?></span></p>
                                        <p><span class="share_label">Payer Number</span> : <span class="share_detail"><?php echo $share_friendnum; ?></span></p>
                                        <p><span class="share_label">Payer E-mail</span> : <span class="share_detail"><?php echo $share_friendemail; ?></span></p>
                                        <p><span class="share_label">Payment Link</span> : <span class="share_detail"><?php echo $paymentlink; ?></span></p>
                                        <p><span class="share_label">Installment </span> : <span class="share_detail"><?php echo $pay_status; ?></span></p>
                                        <p><span class="share_label">Amount</span> : <span class="share_detail"><?php echo $paid_amt; ?></span></p>
                                        <p><span class="share_label">Transaction Id</span> : <span class="share_detail"><?php echo $txnid; ?></span></p>
                                    </div>
                                    <?php

                                }
                            }
                        } else if ($share_orderid3 && $t == 3) {
                            $sharepay = "SELECT * FROM `#__sharepayment` WHERE organizer_id=$user_id AND orderid=$share_orderid3 AND trip_type='fixed'";
                            $db->setQuery($sharepay);
                            $sharepay_list = $db->loadObjectList();

                            foreach ($sharepay_list as $sharepay_list_disp) {
                                $share_payid = $sharepay_list_disp->id;
                                $share_trip_type = $sharepay_list_disp->trip_type; // ex customized
                                $share_payment_type = $sharepay_list_disp->payment_type; // ex split
                                $share_orderid = $sharepay_list_disp->orderid;
                                $share_friendname = $sharepay_list_disp->friendname;
                                $share_friendemail = $sharepay_list_disp->friendemail;
                                $share_friendnum = $sharepay_list_disp->friendnum;
                                $paymentlink = $sharepay_list_disp->paymentlink;
                                $pay_status = $sharepay_list_disp->pay_status;
                                $txnid = $sharepay_list_disp->txnid;
                                $paid_amt = $sharepay_list_disp->paid_amt;
                                if ($pay_status == 'final') {
                                    ?>
                                    <div class="display_quote orderlists">
                                        <p><span class="share_label">Order Id</span> : <span class="share_detail"><?php echo $share_orderid; ?></span></p>
                                        <p><span class="share_label">Payment Type </span> : <span class="share_detail"><?php echo $share_payment_type; ?></span></p>
                                        <p><span class="share_label">Payer Name </span> : <span class="share_detail"><?php echo $share_friendname; ?></span></p>
                                        <p><span class="share_label">Payer Number</span> : <span class="share_detail"><?php echo $share_friendnum; ?></span></p>
                                        <p><span class="share_label">Payer E-mail</span> : <span class="share_detail"><?php echo $share_friendemail; ?></span></p>
                                        <p><span class="share_label">Payment Link</span> : <span class="share_detail"><?php echo $paymentlink; ?></span></p>
                                        <p><span class="share_label">Installment </span> : <span class="share_detail"><?php echo $pay_status; ?></span></p>
                                        <p><span class="share_label">Amount</span> : <span class="share_detail"><?php echo $paid_amt; ?></span></p>
                                        <p><span class="share_label">Transaction Id</span> : <span class="share_detail"><?php echo $txnid; ?></span></p>
                                    </div>
                                    <?php

                                }
                            }
                        } else {
                            echo '';
                        }
                        echo '</div>';
                        /*  share payment detail */
                        ?>
                        </div>
                    </div>
                </div>
                <!--Select4-->
                <!--Select5-->
                <div ng-show='selected == 5'>
               <div class="display_quote nopadding">
                                  <div class="display_docpag">
                <?php
                if ($t == 1) {
                    $sql_documentc = "SELECT COUNT(id) FROM `#__document_communication` WHERE user_id=$user_id AND quote='c-$urlid' AND t='Customized'";
                    $db->setQuery($sql_documentc);
                    $document_count = $db->loadResult();

                    if ($document_count != 0) {
                        $sql_get_document = "SELECT * FROM `#__document_communication` WHERE user_id=$user_id AND quote='c-$urlid' AND t='Customized'";
                        $db->setQuery($sql_get_document);
                        $backupload = $db->loadObjectList();

                        foreach ($backupload as $backupload_des) {
                            $document1 = $backupload_des->document1;
                            $title1 = $backupload_des->title1;
                            $document2 = $backupload_des->document2;
                            $title2 = $backupload_des->title2;
                            $document3 = $backupload_des->document3;
                            $title3 = $backupload_des->title3;
                            $document4 = $backupload_des->document4;
                            $title4 = $backupload_des->title4;
                            $document5 = $backupload_des->document5;
                            $title5 = $backupload_des->title5;
                            $document6 = $backupload_des->document6;
                            $title6 = $backupload_des->title6;
                            $document7 = $backupload_des->document7;
                            $title7 = $backupload_des->title7;
                            $document8 = $backupload_des->document8;
                            $title8 = $backupload_des->title8;
                            $document9 = $backupload_des->document9;
                            $title9 = $backupload_des->title9;
                            $document10 = $backupload_des->document10;
                            $title10 = $backupload_des->title10;
                        }

                        if ($title1 != '') {

                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title1 . '</h3>
		               <p><a href="' . JURI::root() . 'images/document1/' . $document1 . '" download >Download File 1</a></p></div>';
                        }
                        if ($title2 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title2 . '</h3>
		                         <p><a href="' . JURI::root() . 'images/document2/' . $document2 . '" download >Download File 2</a></p></div>';
                        }
                        if ($title3 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title3 . '</h3>
		                      <p><a href="' . JURI::root() . 'images/document3/' . $document3 . '" download >Download File 3</a></p></div>';
                        }
                        if ($title4 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title4 . '</h3>
		                 <p><a href="' . JURI::root() . 'images/document4/' . $document4 . '" download >Download File 4</a></p></div>';
                        }
                        if ($title5 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title5 . '</h3>
		                <p><a href="' . JURI::root() . 'images/document5/' . $document5 . '" download >Download File 5</a></p></div>';
                        }
                        if ($title6 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title6 . '</h3>
		                <p><a href="' . JURI::root() . 'images/document6/' . $document6 . '" download >Download File 6</a></p></div>';
                        }
                        if ($title7 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title7 . '</h3>
		                 <p><a href="' . JURI::root() . 'images/document7/' . $document7 . '" download >Download File 7</a></p></div>';
                        }
                        if ($title8 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title8 . '</h3>
		                   <p><a href="' . JURI::root() . 'images/document8/' . $document8 . '" download >Download File 8</a></p></div>';
                        }
                        if ($title9 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title9 . '</h3>
                         <p><a href="' . JURI::root() . 'images/document9/' . $document9 . '" download >Download File 9</a></p></div>';
                        }
                        if ($title10 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title10 . '</h3>
                         <p><a href="' . JURI::root() . 'images/document10/' . $document10 . '" download >Download File 10</a></p></div>';
                        }
                    }
                }
                if ($t == 2) {
                    $quote_statusfordocument = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND quote_status=$quote_status";
                    $db->setQuery($quote_statusfordocument);
                    $quote_status_id = $db->loadObjectList();

                    foreach ($quote_status_id as $quote_status_id_disp) {
                        $document_qute_id = $quote_status_id_disp->id;
                    }

			   // echo $document_qute_id;

                    $sql_documentc2 = "SELECT COUNT(id) FROM `#__document_communication` WHERE user_id=$user_id AND quote='s-$document_qute_id' AND t='Semi_Customized'";
                    $db->setQuery($sql_documentc2);
                    $document_count2 = $db->loadResult();

                    if ($document_count2 != 0) {
                        $sql_get_document2 = "SELECT * FROM `#__document_communication` WHERE user_id=$user_id AND quote='s-$document_qute_id' AND t='Semi_Customized'";
                        $db->setQuery($sql_get_document2);
                        $backupload2 = $db->loadObjectList();

                        foreach ($backupload2 as $backupload_des2) {
                            $document21 = $backupload_des2->document1;
                            $title21 = $backupload_des2->title1;
                            $document22 = $backupload_des2->document2;
                            $title22 = $backupload_des2->title2;
                            $document23 = $backupload_des2->document3;
                            $title23 = $backupload_des2->title3;
                            $document24 = $backupload_des2->document4;
                            $title24 = $backupload_des2->title4;
                            $document25 = $backupload_des2->document5;
                            $title25 = $backupload_des2->title5;
                            $document26 = $backupload_des2->document6;
                            $title26 = $backupload_des2->title6;
                            $document27 = $backupload_des2->document7;
                            $title27 = $backupload_des2->title7;
                            $document28 = $backupload_des2->document8;
                            $title28 = $backupload_des2->title8;
                            $document29 = $backupload_des2->document9;
                            $title29 = $backupload_des2->title9;
                            $document210 = $backupload_des2->document10;
                            $title20 = $backupload_des2->title10;
                        }
                        if ($title21 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title21 . '</h3>
		                      <p><img src="' . JURI::root() . 'images/document1/' . $document21 . '"></p></div>';

                        }
                        if ($title22 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title22 . '</h3>
		                      <p><img src="' . JURI::root() . 'images/document2/' . $document22 . '"></p></div>';

                        }
                        if ($title23 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title23 . '</h3>
		                      <p><img src="' . JURI::root() . 'images/document3/' . $document23 . '"></p></div>';

                        }
                        if ($title24 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title24 . '</h3>
		                      <p><img src="' . JURI::root() . 'images/document4/' . $document24 . '"></p></div>';

                        }
                        if ($title25 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title25 . '</h3>
		                      <p><img src="' . JURI::root() . 'images/document5/' . $document25 . '"></p></div>';

                        }
                        if ($title26 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title26 . '</h3>
		                      <p><img src="' . JURI::root() . 'images/document6/' . $document26 . '"></p></div>';

                        }
                        if ($title27 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title27 . '</h3>
		                      <p><img src="' . JURI::root() . 'images/document7/' . $document27 . '"></p></div>';

                        }
                        if ($title28 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title28 . '</h3>
		                      <p><img src="' . JURI::root() . 'images/document8/' . $document28 . '"></p></div>';

                        }
                        if ($title29 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title29 . '</h3>
		                      <p><img src="' . JURI::root() . 'images/document9/' . $document29 . '"></p></div>';

                        }
                        if ($title210 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p><h3>' . $title210 . '</h3>
		                      <p><img src="' . JURI::root() . 'images/document10/' . $document210 . '"></p></div>';

                        }
                    }
                }
                if ($t == 3) {
                    $sql_documentc3 = "SELECT COUNT(id) FROM `#__document_communication` WHERE user_id=$user_id AND quote='f-$urlid' AND t='Fixed'";
                    $db->setQuery($sql_documentc3);
                    $document_count3 = $db->loadResult();

                    if ($document_count3 != 0) {
                        $sql_get_document3 = "SELECT * FROM `#__document_communication` WHERE user_id=$user_id AND quote='f-$urlid' AND t='Fixed'";
                        $db->setQuery($sql_get_document3);
                        $backupload3 = $db->loadObjectList();

                        foreach ($backupload3 as $backupload_des3) {
                            $document31 = $backupload_des3->document1;
                            $title31 = $backupload_des3->title1;
                            $document32 = $backupload_des3->document2;
                            $title32 = $backupload_des3->title2;
                            $document33 = $backupload_des3->document3;
                            $title33 = $backupload_des3->title3;
                            $document34 = $backupload_des3->document4;
                            $title34 = $backupload_des3->title4;
                            $document35 = $backupload_des3->document5;
                            $title35 = $backupload_des3->title5;
                            $document36 = $backupload_des3->document6;
                            $title36 = $backupload_des3->title6;
                            $document37 = $backupload_des3->document7;
                            $title37 = $backupload_des3->title7;
                            $document38 = $backupload_des3->document8;
                            $title38 = $backupload_des3->title8;
                            $document39 = $backupload_des3->document9;
                            $title39 = $backupload_des3->title9;
                            $document310 = $backupload_des3->document10;
                            $title310 = $backupload_des3->title10;
                        }
                        if ($title31 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p>
    	                		<h3>' . $title31 . '</h3>
    		         <p><a href="' . JURI::root() . 'images/document1/' . $document31 . '" download >Download File 1</a></p></div>';
                        }
                        if ($title32 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p>
    	                		<h3>' . $title32 . '</h3>
    		                      <p><a href="' . JURI::root() . 'images/document2/' . $document32 . '" download >Download File 2</a></p></div>';
                        }
                        if ($title33 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p>
    	                	<h3>' . $title33 . '</h3>
    		                    <p><a href="' . JURI::root() . 'images/document3/' . $document33 . '" download >Download File 3</a></p></div>';
                        }
                        if ($title34 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p>
    	                	<h3>' . $title34 . '</h3>
    		           	                    <p><a href="' . JURI::root() . 'images/document4/' . $document34 . '" download >Download File 4</a></p></div>';
                        }
                        if ($title35 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p>
    	                	<h3>' . $title35 . '</h3>
    		            	 <p><a href="' . JURI::root() . 'images/document5/' . $document35 . '" download >Download File 5</a></p></div>';
                        }
                        if ($title36 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p>
    	                	<h3>' . $title36 . '</h3>
    		          	     <p><a href="' . JURI::root() . 'images/document6/' . $document36 . '" download >Download File 6</a></p></div>';
                        }
                        if ($title37 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p>
    	                	<h3>' . $title37 . '</h3>
    		       	        <p><a href="' . JURI::root() . 'images/document7/' . $document37 . '" download >Download File 7</a></p></div>';
                        }
                        if ($title38 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p>
    	                	<h3>' . $title38 . '</h3>
    		         	    <p><a href="' . JURI::root() . 'images/document8/' . $document38 . '" download >Download File 8</a></p></div>';
                        }
                        if ($title39 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p>
    	                	<h3>' . $title39 . '</h3>
    		    	         <p><a href="' . JURI::root() . 'images/document9/' . $document39 . '" download >Download File 9</a></p></div>';
                        }
                        if ($title310 != '') {
                            echo '<div class="doc_disp"><p><img src="images/Files.png"></p>
    	                	<h3>' . $title310 . '</h3>
    		  	            <p><a href="' . JURI::root() . 'images/document10/' . $document310 . '" download >Download File 10</a></p></div>';
                        }
                    }
                }
                ?>
                 </div>
                </div>    </div>
                <!--Select5-->
                 <!--Select6-->
                <div ng-show='selected == 6'>
                <?php
                $nowdate = date('Y-m-d');
                if ($t == 1) {
                    $sqlx = "SELECT * FROM `#__customized_order` WHERE id=$urlid AND uid=$user_id";
                    $db->setQuery($sqlx);
                    $final_detail = $db->loadObjectList();
                    foreach ($final_detail as $cust) {
                        $date = $cust->dateofdeparture;
                        $ndays = $cust->no_days;
                        $psts = $cust->payment_status;
                        $date = date("Y-m-d", strtotime("$date +$ndays day"));
                    }
                } else if ($t == 2) {
                    $sqls = "SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND quote_status=$quote_status";
                    $db->setQuery($sqls);
                    $final_details = $db->loadObjectList();
                    foreach ($final_details as $semi) {
                        $date = $semi->trip_date;
                        $ndays = $semi->noofdays;
                        $psts = $semi->payment_status;
                        $date = date("Y-m-d", strtotime("$date +$ndays day"));
                    }
                } else if ($t == 3) {
                    $sqlf = "SELECT * FROM `#__fixed_trip_orders` WHERE id=$urlid AND uid=$user_id AND payment_status='final_installment'";
                    $db->setQuery($sqlf);
                    $final_detailf = $db->loadObjectList();
                    foreach ($final_detailf as $fixed) {
                        $date = $fixed->pack_date;
                        $ndays = $fixed->no_of_days;
                        $psts = $fixed->payment_status;
                        $date = date("Y-m-d", strtotime("$date +$ndays day"));
                    }
                }
                if (($nowdate >= $date)&&($psts=='final_installment') ) {
                    $reviewtext = '';
                    $reviewvalue = '';
                    $sql = "SELECT COUNT(id) FROM `#__customer_rev1ews` WHERE uid=$user_id";
                    $db->setQuery($sql);
                    $count = $db->loadResult();
                    if ($count != 0) {
                        $sql = "SELECT * FROM `#__customer_rev1ews` WHERE uid=$user_id";
                        $db->setQuery($sql);
                        $events_detail = $db->loadObjectList();
                        foreach ($events_detail as $event_disp) {
                            $revid = $event_disp->id;
                            $reviewtext = $event_disp->reviewtext;
                            $reviewvalue = $event_disp->reviewvalue;
                        }
                        if ($reviewtext == '') {
                            $reviewtext = '';
                        } else {
                            $reviewtext = $reviewtext;
                        }
                        if ($reviewvalue == '') {
                            $reviewvalue = '';
                        } else {
                            $reviewvalue = $reviewvalue;
                        }
                    }
                    ?>
                    <div class="ratingreview">
                        <?php
                        if (isset($_FILES['image'])) {
                            $errors = array();
                            $file_name = $_FILES['image']['name'];
                            $file_size = $_FILES['image']['size'];
                            $file_tmp = $_FILES['image']['tmp_name'];
                            $reviewtext = $_POST['reviewtext'];
                            $tittle = $_POST['tittle'];
                            $file_type = $_FILES['image']['type'];
                            if ($file_size > 2097152) {
                                $errors[] = 'File size must be excately 2 MB';
                            }
                            if (!file_exists(JPATH_SITE . '/' . "review" . '/' . $user_id)) {
                                mkdir(JPATH_SITE . '/' . "review" . '/' . $user_id);
                            }
                            if (empty($errors) == true) {
                                move_uploaded_file($file_tmp, "review/" . $user_id . "/" . $file_name);
                                
                                $rev = "SELECT count(id) FROM `#__customer_rev1ews` WHERE uid=$user_id AND (oid=$urlid || qts=$quote_status) AND t=$t";
                                $db->setQuery($rev);
                                $revid = $db->loadResult();

                                if ($revid!=0) {
                                    
                                    $revv = "SELECT id FROM `#__customer_rev1ews` WHERE uid=$user_id AND (oid=$urlid || qts=$quote_status) AND t=$t";
                                    $db->setQuery($revv);
                                    $revvid = $db->loadResult();
                                
                                    $sqlzz = "SELECT name FROM `#__users` WHERE id=$user_id";
                                    $db->setQuery($sqlzz);
                                    $reviewername = $db->loadResult();

                                    $object = new stdClass();
                                    $object->id = $revvid;
                                    $object->uid = $user_id;
                                    $object->author_name = $reviewername;
                                    $object->reviewtext = $reviewtext;
                                    $object->image = $file_name;
                                    $object->oid = $urlid;
                                    $object->qts = $quote_status;
                                    $object->t = $t;
                                    $object->tittle = $tittle;
                                    $object->state =1;
                                    JFactory::getDbo()->updateObject('#__customer_rev1ews', $object, 'id');

                                } else {
                                    $object = new stdClass();
                                    $object->id = '';
                                    $object->uid = $user_id;
                                    $object->reviewtext = $reviewtext;
                                    $object->author_name = $reviewername;
                                    $object->image = $file_name;
                                    $object->tittle = "$tittle";
                                    $object->oid = "$urlid";
                                    $object->qts = "$quote_status";
                                    $object->t = "$t";
                                    $object->state =1;
                                    $db->insertObject('#__customer_rev1ews', $object);
                                }
                                echo '<script>alert("Review Successfully Uploaded");</script>';
                            } else {
                                //print_r($errors);
                                if ($errors) {
                                    echo 'File upload failed, Kindly try again later';
                                }
                            }
                        }
                        ?>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?option=com_users&view=profile" method="post" enctype="multipart/form-data" id="review_pag">
                            <div class="r_upload">
                                <p class="r_drop"><img src="images/cloud1.png"></p>
                                <p>Select image to upload:</p>
                                <input type="file" name="image" id="review_file" />
                            </div>
                            <div class="rev_text">
                                <input type="text" name="tittle" id="tittle" placeholder="Tittle of Your Travel Story">
                            <textarea id="reviewtext" name="reviewtext" placeholder="Enter Your Reviews"></textarea>
                            </div>
                            <input type="submit" id="revsub" value="Send Your Travel Story" name="submit">
                        </form>
                    </div>
                <?php
            }
            ?>
                </div>
                <!-- Select6 -->

            <!-- tab-content end -->
            </div>
        </div>
    </div>
</div>
    <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js'></script>


    <script src="addons/angular/js/index.js"></script>

    <script>
    function myFunction() {
      var copyText = document.getElementById("myInput");
      copyText.select();
      document.execCommand("copy");
    }

      function myFunction2() {
      var copyText2 = document.getElementById("myInput2");
      copyText2.select();
      document.execCommand("copy");
    }


    jQuery(document).ready(function(){

    jQuery("#qrq").click(function(){

        var urlid='<?php echo $urlid; ?>';
        var qts="<?php echo $quote_status; ?>";
        var t='<?php echo $t; ?>';

        jQuery.post("index.php?option=com_users&task=user.reqmail&t="+t+"&qts="+qts+"&urlid="+urlid, mstatus);
    });
    function mstatus(stext,status)
    {
        if(status=='success')
        {
            if(stext=="mail") {
                alert("Quote request successfully sent");
            } else {
                alert("Already you requested for Quote, kindly wait for update. We will update you soon");
            }
        }
    }
    });
    </script>


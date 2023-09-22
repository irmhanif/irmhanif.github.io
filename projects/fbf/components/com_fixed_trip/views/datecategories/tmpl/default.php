<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="css/component.css" />
<script src="js/modernizr.custom.js"></script>
<?php
$db=JFactory::getDBO();
$user = JFactory::getUser();
$user_id=$user->id;
$_SESSION['trip'] = 'fixed_trip';
?>
<script src="addons/owl/jquery.min.js"></script>
<script src="addons/owl/owl.carousel.js"></script>

<div class="inner_page">
    <div class="innerpage_banner">
        <div class="owl-carouseb">
             <div class="item"><img src="images/fixedb/P11GFTP4.jpg" alt=""></div>
             <div class="item"><img src="images/fixedb/P12GFTP4.jpg" alt=""></div>
             <div class="item"><img src="images/fixedb/P13GFTP4.jpg" alt=""></div>
        </div>
    </div>

    <div class="inner_page_layout">
        <div class="left_img">
            <img src="images/fleft.png">
        </div>
        <div class="about_trip">
	          <h1 class="h1classs">FIXED TRIP </h1>
            <p>Your life is super hectic and just doesn’t leave you with any time to chalk out a full-fledged plan for your trips. We got you! <span class="blue1">Just pick a date or general area and leave the rest to us.</span> 
            We have designed these fixed trips to make them affordable and extremely simple for you. By joining a group of like-minded people, <span class="blue1">you will be able to share the costs</span> of our keeper services and transportation. Added bonus: <span class="blue1">making friends and creating memories </span> for a lifetime! 
            Since we keep our groups small knit, it allows us to take care of each travelling member’s needs personally. </p>
            <p class="cent_txt"><span class="blue1">Find the experience made for you and pick a date and interest below!<span class="blue1"></p>
            
	      </div>
	      <div class="right_img">
            <img src="images/fright.png">
        </div>
    </div>



    <div class="get_inspration fixed">
        <h1 class="h1class">Explore By Date</h1>
        <div class="inspiration_detail">
        <?php
            $sql="SELECT * FROM `#__create_trip` WHERE state='1'";
            $db->setQuery($sql);
            $dates=$db->loadObjectList();
            foreach($dates as $event_disp) {
                $id=$event_disp->id;
                $type=$event_disp->type;
                $date1=$event_disp->date_of_departure1;
                $date2=$event_disp->date_of_departure2;
                $date3=$event_disp->date_of_departure3;
                $date4=$event_disp->date_of_departure4;
                $date5=$event_disp->date_of_departure5;
                $date6=$event_disp->date_of_departure6;
       
                $tempvar1=$id.'>'.$date1.'>'.$type;
                $tempvar2=$id.'>'.$date2.'>'.$type;
                $tempvar3=$id.'>'.$date3.'>'.$type;
                $tempvar4=$id.'>'.$date4.'>'.$type;
                $tempvar5=$id.'>'.$date5.'>'.$type;
                $tempvar6=$id.'>'.$date6.'>'.$type;
                $m1 = $date1;
                $m2 = $date2;
                $m3 = $date3;
                $m4 = $date4;
                $m5 = $date5;
                $m6 = $date6;

                $mnt = array($m1,$m2,$m3,$m4,$m5,$m6);
                $mntt = array($tempvar1,$tempvar2,$tempvar3,$tempvar4,$tempvar5,$tempvar6);
          
                foreach (array_keys($mnt, '0000-00-00') as $key) {
                    unset($mnt[$key]);
                }

                $arr = implode(",", $mntt);
                $arr = explode(",", $arr);
                foreach ($mntt as $key => $value) {
                    $valueid = $value;
                    $arr = explode(">", $value);
                      
                    $arr = $arr[1];
                    $thismonth = date('m', strtotime($arr));
                    if($thismonth == "01") {
                      $month1[] = $valueid;
                    }
                    if ($thismonth == "02") {
                        $month2[] = $valueid;
                    }
                    if($thismonth == "03") {
                      $month3[] = $valueid;
                    }
                    if($thismonth == "05") {
                      $month5[] = $valueid;
                    }
                   if($thismonth == "07") {
                      $month7[] = $valueid;
                    }
                      if($thismonth == "09") {
                      $month9[] = $valueid;
                    }
                     if($thismonth == "11") {
                      $month11[] = $valueid;
                    }
            
                     if ($thismonth == "04") {
                       $month4[] = $valueid;
                     }
                     if ($thismonth == "06") {
                       $month6[] = $valueid;
                     }
                     if ($thismonth == "08") {
                       $month8[] = $valueid;
                     }
                     if ($thismonth == "10") {
                       $month10[] = $valueid;
                     }
                     if ($thismonth == "12") {
                       $month12[] = $valueid;
                     }
                }
            }
              $sqlz1="SELECT * FROM `#__create_trip` WHERE state='1'";
              $db->setQuery($sqlz1);
              $avilmonths=$db->loadObjectList();
              foreach($dates as $event_disp) {
                  $datez[]=$event_disp->date_of_departure1;
                  $datez[].=$event_disp->date_of_departure2;
                  $datez[].=$event_disp->date_of_departure3;
                  $datez[].=$event_disp->date_of_departure4;
                  $datez[].=$event_disp->date_of_departure5;
                  $datez[].=$event_disp->date_of_departure6;
              }
              $array_without_0 = array_diff($datez, array('0000-00-00'));
              foreach($array_without_0 as $alldates) {
                  $avmonths[] = (date('m', strtotime($alldates)));
              }
              $allmnthsarr= array('01', '02', '03','04', '05', '06','07', '08', '09','10', '11', '12');
              $resultz=array_diff($allmnthsarr,$avmonths);
              $removeid = $removeid2 = $removeid3 = $removeid4 = $removeid5 = $removeid6 = $removeid7 = $removeid8 = $removeid9 = $removeid10 = $removeid11 = $removeid12 = '';
              foreach($resultz as $unavilablemnths) {
                  $unavilablemnthsz[]=$unavilablemnths;
              }
              foreach($unavilablemnthsz as $mnthloop) {
                  if($mnthloop=='01'){
                      $removeid='1';
                  }
              }
              foreach($unavilablemnthsz as $mnthloop2) {
              if($mnthloop2=='02') {
                 $removeid2='2';
              }
              }
              foreach($unavilablemnthsz as $mnthloop3) {
                  if($mnthloop3=='03') {
                      $removeid3='3';
                  }
              }
              foreach($unavilablemnthsz as $mnthloop4) {
                  if($mnthloop4=='04') {
                      $removeid4='4';
                  }
              }
              foreach($unavilablemnthsz as $mnthloop5) {
                  if($mnthloop5=='05') {
                      $removeid5='5';
                  }
              }
              foreach($unavilablemnthsz as $mnthloop6) {
                  if($mnthloop6=='06') {
                      $removeid6='6';
                  }
              }
              foreach($unavilablemnthsz as $mnthloop7) {
              if($mnthloop7=='07'){
                 $removeid7='7';
              }
              }
              foreach($unavilablemnthsz as $mnthloop8) {
                  if($mnthloop8=='08') {
                      $removeid8='8';
                  }
              }
              foreach($unavilablemnthsz as $mnthloop9) {
                  if($mnthloop9=='09') {
                      $removeid9='9';
                  }
              }
              foreach($unavilablemnthsz as $mnthloop10) {
                  if($mnthloop10=='10') {
                      $removeid10='10';
                  }
              }
              foreach($unavilablemnthsz as $mnthloop11) {
                  if($mnthloop11=='11') {
                      $removeid11='11';
                  }
              }
              foreach($unavilablemnthsz as $mnthloop12) {
                  if($mnthloop12=='12') {
                      $removeid12='12';
                  }
              }
              $removeids = array($removeid,$removeid2,$removeid3,$removeid4,$removeid5,$removeid6,$removeid7,$removeid8,$removeid9,$removeid10,$removeid11,$removeid12);
              $stringid = implode(',', $removeids);
              $arrayid = explode(',', $stringid);
             // $duplicate =array_unique( array_diff_assoc( $arrayid, array_unique( $arrayid ) ) );
        
              $duplicate=array_values(array_diff($arrayid,array("","")));
     

          $unavail = implode(',', $duplicate);

          ?>
   <div class="owl-carousel">
     <?php
 if($unavail != "") {
      $sql="SELECT * FROM `#__date_category` WHERE state='1' AND id NOT IN ($unavail)";
    } else {
      $sql="SELECT * FROM `#__date_category` WHERE state='1'";
    }
      $db->setQuery($sql);
      $event_detail=$db->loadObjectList();
      foreach($event_detail as $event_disp)
      {
        $id=$event_disp->id;
        $place_name=$event_disp->title;
        $place_image=$event_disp->picture;
        $pro_img = JURI::root().'date_category/'.$place_image;
        $start_date=$event_disp->start_date;
        $smm = date('m', strtotime($start_date));
        $end_date=$event_disp->end_date;
        $emm = date('m', strtotime($end_date));
     
       echo ' <div class="item fixed">
         <div class="dispim1">
          <img class=disimg src="'.$pro_img.'" alt="" />
          <span class="eventtittle eventtittle1" style="text-transform:Capitalize;">
          <label>'.$place_name.'</label>
          <p>';
      if ($id == 1) {
        foreach ($month1 as $month) {
          $month = explode(">", $month);
          $type = $month[2];
          $did = $month[0];
          $date = $month[1];
          $fdate = date('d M Y', (strtotime($date)));
          $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
          $db->setQuery($typename);
          $typen = $db->loadResult();
          if ($date != '0000-00-00') {
            echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
          }
        }
      }
      if ($id == 2) {
        foreach ($month2 as $month) {
          $month = explode(">", $month);
          $type = $month[2];
          $did = $month[0];
          $date = $month[1];
          $fdate = date('d M Y', (strtotime($date)));
          $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
          $db->setQuery($typename);
          $typen = $db->loadResult();
          if ($date != '0000-00-00') {
            echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
          }
        }
      }
      if ($id == 3) {
        foreach ($month3 as $month) {
          $month = explode(">", $month);
          $type = $month[2];
          $did = $month[0];
          $date = $month[1];
          $fdate = date('d M Y', (strtotime($date)));
          $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
          $db->setQuery($typename);
          $typen = $db->loadResult();
          if ($date != '0000-00-00') {
            echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
          }
        }
      }
      if ($id == 4) {
        foreach ($month4 as $month) {
          $month = explode(">", $month);
          $type = $month[2];
          $did = $month[0];
          $date = $month[1];
          $fdate = date('d M Y', (strtotime($date)));
          $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
          $db->setQuery($typename);
          $typen = $db->loadResult();
          if ($date != '0000-00-00') {
            echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
          }
        }
      }
      if ($id == 5) {
        foreach ($month5 as $month) {
          $month = explode(">", $month);
          $type = $month[2];
          $did = $month[0];
          $date = $month[1];
          $fdate = date('d M Y', (strtotime($date)));
          $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
          $db->setQuery($typename);
          $typen = $db->loadResult();
          if ($date != '0000-00-00') {
            echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
          }
        }
      }
      if ($id == 6) {
        foreach ($month6 as $month) {
          $month = explode(">", $month);
          $type = $month[2];
          $did = $month[0];
          $date = $month[1];
          $fdate = date('d M Y', (strtotime($date)));
          $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
          $db->setQuery($typename);
          $typen = $db->loadResult();
          if ($date != '0000-00-00') {
            echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
          }
        }
      }



     
      if ($id == 7) {
          foreach ($month7 as $month) {
               $month = explode(">", $month);
               $type = $month[2];
               $did = $month[0];
               $date = $month[1];
               $fdate = date('d M Y',(strtotime($date)));
               $typename="SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
               $db->setQuery($typename);
               $typen=$db->loadResult();
               if($date != '0000-00-00') {
               echo '<a class="eventlink" href="'.JURI::root().'index.php?option=com_fixed_trip&view=create_trip&id='.$did.'&date='.$date.'&type='.$type.'">
               '.$fdate.' | '.$typen.'</a>';
              }    
            }
          }
         
      if ($id == 8) {
        foreach ($month8 as $month) {
          $month = explode(">", $month);
          $type = $month[2];
          $did = $month[0];
          $date = $month[1];
          $fdate = date('d M Y', (strtotime($date)));
          $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
          $db->setQuery($typename);
          $typen = $db->loadResult();
          if ($date != '0000-00-00') {
            echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
          }
        }
      }
      if ($id == 9) {
      foreach ($month9 as $month) {
        $month = explode(">", $month);
        $type = $month[2];
        $did = $month[0];
        $date = $month[1];
        $fdate = date('d M Y', (strtotime($date)));
        $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
        $db->setQuery($typename);
        $typen = $db->loadResult();
        if ($date != '0000-00-00') {
          echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
        }
      }
    }
      if ($id == 10) {
        foreach ($month10 as $month) {
          $month = explode(">", $month);
          $type = $month[2];
          $did = $month[0];
          $date = $month[1];
          $fdate = date('d M Y', (strtotime($date)));
          $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
          $db->setQuery($typename);
          $typen = $db->loadResult();
          if ($date != '0000-00-00') {
            echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
          }
        }
      }
      if ($id == 11) {
        foreach ($month11 as $month) {
          $month = explode(">", $month);
          $type = $month[2];
          $did = $month[0];
          $date = $month[1];
          $fdate = date('d M Y', (strtotime($date)));
          $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
          $db->setQuery($typename);
          $typen = $db->loadResult();
          if ($date != '0000-00-00') {
            echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
          }
        }
      }
      if ($id == 12) {
        foreach ($month12 as $month) {
          $month = explode(">", $month);
          $type = $month[2];
          $did = $month[0];
          $date = $month[1];
          $fdate = date('d M Y', (strtotime($date)));
          $typename = "SELECT title FROM `#__type_category` WHERE state='1' AND id = '$type'";
          $db->setQuery($typename);
          $typen = $db->loadResult();
          if ($date != '0000-00-00') {
            echo '<a class="eventlink" href="' . JURI::root() . 'index.php?option=com_fixed_trip&view=create_trip&id=' . $did . '&date=' . $date . '&type=' . $type . '">
               ' . $fdate . ' | ' . $typen . '</a>';
          }
        }
      }


  
      
    
       
          echo '
    </p>   </span> </div>
      </div>';



}

   ?>

  </div>
</div>
</div>

<div class="get_inspration" style='display:none;'>
  <h1 class="h1clasd">Explore By Type</h1>
  <div class="inspiration_detail">
    <div class="container demo-7">
    <div class="owl-carousel  grid cs-style-7">
      <?php
      $sql="SELECT * FROM `#__type_category` WHERE state='1'";
      $db->setQuery($sql);
      $event_detail=$db->loadObjectList();
      foreach($event_detail as $event_disp)
      {
        $id=$event_disp->id;
        $place_name=$event_disp->title;
        $place_image=$event_disp->picture;
        $desc=$event_disp->description;
        $sql="SELECT * FROM `#__create_trip` WHERE state='1' AND type='$id'";
      $db->setQuery($sql);
      $event_detail=$db->loadObjectList();
      foreach($event_detail as $event_disp){
        $id=$event_disp->id;
        $type=$event_disp->type;
        $date1=$event_disp->date_of_departure1;
        $date2=$event_disp->date_of_departure2;
        $date3=$event_disp->date_of_departure3;
        $date4=$event_disp->date_of_departure4;
        $date5=$event_disp->date_of_departure5;
        $date6=$event_disp->date_of_departure6;
        $m1=$event_disp->date_of_departure1;
        $m2=$event_disp->date_of_departure2;
        $m3=$event_disp->date_of_departure3;
        $m4=$event_disp->date_of_departure4;
        $m5=$event_disp->date_of_departure5;
        $m6=$event_disp->date_of_departure6;
        $pro_img = JURI::root().'type_category/'.$place_image;
        echo '
        <li>
       <figure>
        <div class="item fixed">
         <div class="dispim1">
          <img class=disimg src="'.$pro_img.'" alt="" />
          <span class="eventtittle fixedtype" style="text-transform:Capitalize;">
          <label>'.$place_name.'</label></span>
          <div class="dispcnt2">
            <ul class="tripmonth">Available dates:<br>';
            if($date1!='0000-00-00')
            {
              $dates1 = date('d M Y', strtotime($date1));
              echo '<li><a class="eventlink" href="'.JURI::root().'index.php?option=com_fixed_trip&view=create_trip&id='.$id.'&date='.$m1.'&type='.$type.'">'.$dates1.'</a></li><br>';
            }
            if($date2!='0000-00-00')
            {
              $dates2 = date('d M Y', strtotime($date2));
              echo '<li><a class="eventlink" href="'.JURI::root().'index.php?option=com_fixed_trip&view=create_trip&id='.$id.'&date='.$m2.'&type='.$type.'">'.$dates2.'</a></li><br>';
            }
            else
            {
              echo '';
            }
            if($date3!='0000-00-00')
            {
              $dates3 = date('d M Y', strtotime($date3));
              echo '<li><a class="eventlink" href="'.JURI::root().'index.php?option=com_fixed_trip&view=create_trip&id='.$id.'&date='.$m3.'&type='.$type.'">'.$dates3.'</a></li><br>';
            }
            else{
              echo '';
            }
            if($date4!='0000-00-00')
            {
              $dates4 = date('d M Y', strtotime($date4));
              echo '<li><a class="eventlink" href="'.JURI::root().'index.php?option=com_fixed_trip&view=create_trip&id='.$id.'&date='.$m4.'&type='.$type.'">'.$dates4.'</a></li><br>';
            }
            else
            {
              echo '';
            }
            if($date5!='0000-00-00')
            {
              $dates5 = date('d M Y', strtotime($date5));
              echo '<li><a class="eventlink" href="'.JURI::root().'index.php?option=com_fixed_trip&view=create_trip&id='.$id.'&date='.$m5.'&type='.$type.'">'.$dates5.'</a></li><br>';
            }
            else
            {
              echo '';
            }
            if($date6!='0000-00-00')
            {
              $dates6 = date('d M Y', strtotime($date6));
              echo '<li><a class="eventlink" href="'.JURI::root().'index.php?option=com_fixed_trip&view=create_trip&id='.$id.'&date='.$m6.'&type='.$type.'">'.$dates6.'</a></li>';
            }
            else
            {
              echo '';
            }
            echo  '
            </ul>
          </div>
        </div>
      </div>
      <figcaption>
            <div class="cntntfixed">
              <p class="tripcntspop">Trip period: '.$desc.'</p>
           </div>
        </figcaption>
        </figure>
    </li>';
    }}
    ?>
  </div>
</div>
</div>
</div> </div><script src="js/toucheffects.js"></script>
<script>
/********************banner slider****************************/
var firstjq=jQuery.noConflict();
firstjq(document).ready(function() {
var owl = firstjq('.owl-carouseb');
owl.owlCarousel(
{
  items: 1,
  margin: 10,
  autoplay: true,
  autoPlay: 4000,
  dots: true,
  autoplayTimeout: 4000,
  autoplayHoverPause: true,
  loop : true,
  responsive:
  {
    300:
    {
      items:1,
    },
    320:
    {
      items:1,
    },
    480:
    {
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
});
/********************banner slider end****************************/
/********************product slider****************************/
var jq=jQuery.noConflict();
jq(document).ready(function()
{
var owl = firstjq('.owl-carousel');
owl.owlCarousel(
{
  items: 4,
  margin: 20,
  autoplay: false,
  autoPlay: 4000, //Set AutoPlay to 3 seconds
  dots: false,
  autoplayTimeout: 4000,
  autoplayHoverPause: true,
  loop : false,
  responsive:
  {
    300:
    {
      items:1,
    },
    320:
    {
      items:1,
    },
    480:
    {
      items:2,
    },
    720:
    {
      items:2,
    },
    980:
    {
      items:3,
    },
    1000:
    {
      items:3,
    }
  }
});
});
/********************product slider end****************************/
</script>

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
            <p>Your life is super hectic and just doesn’t leave you with any time to chalk out a full-fledged plan for
                your trips. We got you! <span class="blue1">Just pick a date or general area and leave the rest to
                    us.</span>
                We have designed these fixed trips to make them affordable and extremely simple for you. By joining a
                group of like-minded people, <span class="blue1">you will be able to share the costs</span> of our
                keeper services and transportation. Added bonus: <span class="blue1">making friends and creating
                    memories </span> for a lifetime!
                Since we keep our groups small knit, it allows us to take care of each travelling member’s needs
                personally. </p>
            <p class="cent_txt"><span class="blue1" class="blue1">Find the experience made for you and pick a date and
                    interest below!<span class="blue1"></p>

        </div>
        <div class="right_img">
            <img src="images/fright.png">
        </div>
    </div>


	<?php echo $this->loadtemplate("slider") ?>



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
    </div>
</div>
<script src="js/toucheffects.js"></script>
<script>
/********************banner slider****************************/
var firstjq = jQuery.noConflict();
firstjq(document).ready(function() {
    var owl = firstjq('.owl-carouseb');
    owl.owlCarousel({
        items: 1,
        margin: 10,
        autoplay: true,
        autoPlay: 4000,
        dots: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        loop: true,
        responsive: {
            300: {
                items: 1,
            },
            320: {
                items: 1,
            },
            480: {
                items: 1,
            },
            720: {
                items: 1,
            },
            1000: {
                items: 1,
            }
        }
    });
});
/********************banner slider end****************************/
/********************product slider****************************/
var jq = jQuery.noConflict();
jq(document).ready(function() {
    var owl = firstjq('.owl-carousel');
    owl.owlCarousel({
        items: 4,
        margin: 20,
        autoplay: false,
        autoPlay: 4000, //Set AutoPlay to 3 seconds
        dots: false,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        loop: false,
        responsive: {
            300: {
                items: 1,
            },
            320: {
                items: 1,
            },
            480: {
                items: 2,
            },
            720: {
                items: 2,
            },
            980: {
                items: 3,
            },
            1000: {
                items: 3,
            }
        }
    });
});
/********************product slider end****************************/
</script>
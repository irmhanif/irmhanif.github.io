<?php
/**
 * @copyright	Copyright (c) 2018 mod_. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

 $db = JFactory::getDbo(); 
?>
<script src="addons/owl/owl.carousel.js"></script>

     <div class="keeper_page">
        <div class="get_inspration1 hide_interest1">
            <div class="inspiration_detail1">
                       <div class="owl-keeper">
                    <?php
                    $sql="SELECT * FROM `#__keeper_profile` WHERE state='1' ";  
                    $db->setQuery($sql);
                    $trip_detail1=$db->loadObjectList();

                    foreach($trip_detail1 as $trip_disp1)
                    {
                        $trip_id=$trip_disp1->id;
                        $keeper_name=$trip_disp1->keeper_name;
                        $image=$trip_disp1->keeper_image;
                        $shortdescription=$trip_disp1->keeper_short_des;
                        $pro_img = JURI::root().'/keeper_profile/'.$image;
                        echo '<div class="item semi1">
                             <div class="dispim1 semipro_img"  id="'.$trip_id.'">
        				        <img class="semipro_img"  src="'.$pro_img.'" alt="" />
                                <span class="eventtittle eventtittle1 evenblack1" id="'.$trip_id.'">
                                <span class="keeper_name">'.$keeper_name.'</span>
                                <p class="keeper_des">'.$shortdescription.'</p></span>
                            </div>
                        </div>';

                    }
                    ?>
              
            </div>
        </div>
    </div>
 
 <script>
         var firstjq=jQuery.noConflict();
          firstjq(document).ready(function() {
              var owl = firstjq('.owl-keeper');
              owl.owlCarousel({
                items: 1,
                margin:10,
                autoplay: true,
                autoPlay: 4000, //Set AutoPlay to 3 seconds
                dots: false,
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
            items:3,
        },
      986:{
            items:4,
        },
        1000:{
            items:4,
        }
    }
 });
});
</script>

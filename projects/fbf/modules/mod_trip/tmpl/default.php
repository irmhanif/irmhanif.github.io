<?php
/**
 * @copyright	Copyright (c) 2018 mod_. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;


?>
<div id="what_we1" class="what_we">
<div class="home_what">
<h1><a href="index.php?option=com_content&view=article&id=3&Itemid=140">Holiday Options</a></h1>
<div class="do_cont">
            <?php
        $db = JFactory::getDbo();

        $prds = "SELECT * FROM `#__trips` WHERE state=1";
        $db->setQuery($prds);
        $results = $db->loadObjectList();$i=0;
        foreach($results as $resultdisplay)
        {$i++;
            $img = $resultdisplay->trip_img;
            $trip_title = $resultdisplay->trip_title;		
            $rupee = $resultdisplay->rupee;						
            $desc = $resultdisplay->trip_desc;
            $trip_id = $resultdisplay->id;

            if($trip_id=='1')
            {
            	$tripurl='index.php?option=com_customized_trip&view=customized_trips';
            	//$tripurl='customized-trip.html';
            }
			else if($trip_id=='2')
            {
            	$tripurl='index.php?option=com_semicustomized&view=trips';
            	//$tripurl='semicustomized.html';
			}
             else if($trip_id=='3')
            {
            	$tripurl='index.php?option=com_fixed_trip&view=datecategories';
            	//$tripurl='fixed-trip.html';
            }
            else
            {
            	$tripurl='';
            }
            echo '<div class="wedo_cont">
			<a href="'.JURI::root().$tripurl.'"><div class="img_over"><img class="img-top" src="trips/'.$img.'" alt="Card image" />
			<div class="overlay"><img class="image-top" src="images/i1.png" />
			
			</div></a>
			<p class="text'.$i.'">'.$trip_title.'</p>
			</div>
			<div class="info_img">
			<p class="cd-text">'.$desc.'</p>
			</div>
</div>';
            }
 ?>




</div>
</div>
</div>

<!--<div class="home_pagetravel">
<h1><a href="/why-us.html">THE FRENCH CONNECTION</a></h1>
<p class="">France by French wants you to get the 'real deal', and so, we have tied up with locals in different parts of France to show you how to experience it 'the French way'. After all, what better way to know the place than through people who know it like the back of their hand?</p>

</div>-->
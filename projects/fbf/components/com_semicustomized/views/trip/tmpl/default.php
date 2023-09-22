<?php
$db=JFactory::getDBO();
$user = JFactory::getUser();
$user_id=$user->id;
$trip_id=JRequest::getVar('tid');
$fromlogin=JRequest::getVar('f');

if($trip_id=='') {
	if(isset($_SESSION['trip_id'])) {
	$trip_id = $_SESSION['trip_id'];
	}
} 
if($trip_id=='') {
    $sqlback="SELECT MAX(id) FROM `#__semicustomized_order` WHERE uid=$user_id";
	$db->setQuery($sqlback);
	$lastorder_id=$db->loadResult();

    $sql1z="SELECT trip_id FROM `#__semicustomized_order` WHERE id=$lastorder_id";
	$db->setQuery($sql1z);
    $trip_id=$db->loadResult();
}


	if(isset($_SESSION['planid'])) {
	    $planidz = $_SESSION['planid'];
	}
	else {
	    $planidz=''; // noofdays 
	}

//	echo $planidz;

	if(isset($_SESSION['number_peoples'])) {
	    $number_peoples = $_SESSION['number_peoples'];
	}
	else {
	    $number_peoples='';
	}
	if(isset($_SESSION['number_rooms'])) {
		$number_rooms = $_SESSION['number_rooms'];
	}
	else {
		$number_rooms='';
	}
	if(isset($_SESSION['trip_date'])) {
		$trip_date = $_SESSION['trip_date'];
	}
	else {
		$trip_date='';
	}
	if(isset($_SESSION['noofdays'])) {
		$noofdays = $_SESSION['noofdays'];
	}
	else {
		$noofdays='';
	}
	if(isset($_SESSION['keeper_information'])) {
		$keeper_information = $_SESSION['keeper_information'];
	}
	else {
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
	}
	else {
		$transport ='';
	}
	
	if($number_peoples=='') {
	    header('Location: https://www.francebyfrench.com/');
	}



	$sql1="SELECT * FROM `#__semicustomized_trip` WHERE state=1 AND id=$trip_id";
	$db->setQuery($sql1);
	$trip_res=$db->loadObjectList();

	foreach($trip_res as $trip_res_display) {
		$tripid = $trip_res_display->id;
		$trip_title = $trip_res_display->title;
		$peoplecapacity = $trip_res_display->peoplecapacity;
		$carrousselselection = $trip_res_display->carrousselselection;
		$shortdescription = $trip_res_display->shortdescription;
		$longdescription = $trip_res_display->longdescription;
		$keeperconsumer = $trip_res_display->keeperconsumer;
		$nokeeperconsumer = $trip_res_display->nokeeperconsumer;
		$transportconsumer = $trip_res_display->transportconsumer;
		$notransportconsumer = $trip_res_display->notransportconsumer;
		$hotelconsumer = $trip_res_display->hotelconsumer;
		// $tripid = $trip_res_display->nohotelconsumer;
		$planning1 = $trip_res_display->planning1;
		$dayplanning1 = $trip_res_display->dayplanning1;

		$planning2 = $trip_res_display->planning2;
		$dayplanning2 = $trip_res_display->dayplanning2;

		$planning3 = $trip_res_display->planning3;
		$dayplanning3 = $trip_res_display->dayplanning3;

		$planning4 = $trip_res_display->planning4;
		$dayplanning4 = $trip_res_display->dayplanning4;
	}
?>

<script src="addons/owl/jquery.min.js"></script>
<script src="addons/owl/owl.carousel.js"></script>

<div class="inner_page">
 <div class="innerpage_banner">
<?php
        $sqllist="SELECT images FROM `#__semicustomized_trip` WHERE state=1 AND id=$trip_id";
        $db->setQuery($sqllist);
        $bpic=$db->loadResult();
        
            if($bpic!="") {
                echo '<div class="owl-carouseb">';
            $bpic=explode(',', $bpic);
            foreach ($bpic as $key) {
            echo '<div class="item"><img src="'.JURI::root().'trip_gallery_banner/'.$key.'" alt=""></div>';
            }
            echo '</div>';
        } else {
            echo '<div class="item"><img src="'.JURI::root().'images/semicustom/P11GSCP5.jpg" alt=""></div>';
        }
?>
   </div>
   <div class="inner_page_layout">
        <div class="about_trip_fixed rowsemmc">
            <h1><?php echo $trip_title; ?></h1>
            <span><?php echo $longdescription; ?></span>
        </div>
    </div>

	<form action="#" Method="POST" id="trip_validate" >
	   <div class="eve_select">
	        <div class="event_desc">
	        <?php
					$sql_plan="SELECT * FROM `#__semicustomized_trip` WHERE state='1' AND id=$trip_id";
					$db->setQuery($sql_plan);
					$plan_res=$db->loadObjectList();
					$plancount='';
					$planningid='';
					foreach($plan_res as $plan_disp) {
					$planning1 = $plan_disp->planning1;
					$planning2 = $plan_disp->planning2;
					$planning3 = $plan_disp->planning3;
					$planning4 = $plan_disp->planning4;

				 if($planning1!='') {
						$plancount =  $plan_disp->dayplanning1;
						$plancount .=',';
						$planningid =$plan_disp->planning1;
						$planningid .=',';
					}
					if($planning2!='') {
						$plancount .= $plan_disp->dayplanning2;
						$plancount .=',';
						$planningid.=$plan_disp->planning2;
						$planningid .=',';
					}
					if($planning3!='') {
						$plancount .= $plan_disp->dayplanning3;
						$plancount .=',';
						$planningid.=$plan_disp->planning3;
						$planningid .=',';
					}
					if($planning4!='') {
						$plancount .= $plan_disp->dayplanning4;
						$plancount .=',';
						$planningid.=$plan_disp->planning4;
						$planningid .=',';

					}
				}
				$ndays = explode(",",$plancount);
				$ndays = array_filter($ndays);
				$nplanid = explode(",",$planningid);
				$nplanid = array_filter($nplanid);
				?>
		        <div class="row rowsemi">
		        	<div class="col-md-4 col-lg-5"></div>
		        	<div class="col-lg-3 semicen col-md-4">
				<label class="depat">No of Days</label>
					<select name="noofdays" id="noofdays">
				<?php
		     foreach (array_combine($ndays, $nplanid) as $nofdays => $planid) {
		  			echo '<option value="'.$planid.'">'.$nofdays.'</option>';
				}
				?>

			   	 	</select></div>
		        	<div class="col-lg-4"></div>
           		</div>
           <?php
           ?>
           <div class="semi_plannning">
            <div class="semplanningdays">
                                <div class="planningmargin">
			<div class="plan_list"></div>

		</div></div></div>
		   </form>

		  <div class="row priceform">
               <div class="col-md-3 col-sm-2 col-lg-3"></div>
                <div class="col-lg-6 col-sm-8 col-md-6">
                   <div class="row priceform">
                       <div class="col-lg-6 col-md-6 col-sm-8">
                           <label class="pricelabel">Price Per Person</label>
                           <input type=text name="price" id="price" value="" readonly="true">
                       </div>
                       <div class="col-lg-6 col-md-6 col-sm-4">
                           <input type="button" class="pricelabels" value="Add to Itinerary" id="addtocart">
                       </div>
                   </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
<input type=hidden name="cprice" id="cprice" value="" readonly="true">
		</div>
		</div>
	<script>
         var firstjq=jQuery.noConflict();
          firstjq(document).ready(function() {
              var owl = firstjq('.owl-carouseb');
              owl.owlCarousel({
                items: 1,
                margin: 10,
                autoplay: true,
                autoPlay: 4000, //Set AutoPlay to 3 seconds
                dots: true,
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
            items:1,
        },
        720:{
            items:1,
        },
        1000:{
            items:1,
        }
    }
 });
});

</script>

<script>
jq = jQuery.noConflict();
   jq(document).ready(function() {
       
    /* Dispaly session value start */
       		
        var noofdays = "<?php echo $planidz; ?>";
	    jq("#noofdays option").each(function() {
		if( jQuery(this).val() == noofdays ) {
					jQuery(this).attr("selected","selected");
				}
			});
			
       
        var fromligin ="<?php echo $fromlogin; ?>";
        
        if(fromligin=='login') {
		var hotel_booking ="<?php echo $hotel_price; ?>";
		var keeper = "<?php echo $keeper_information; ?>";
		var transport = "<?php echo $transport; ?>";
         } else {
             
        var hotel_booking ="<?php echo $hotel_price; ?>";
		var keeper = "<?php echo $keeper_information; ?>";
		var transport = "<?php echo $transport; ?>";
		
    		if(hotel_booking==''){
    		    var hotel_booking = jQuery("#hotel_booking").val();
    		    var keeper = jQuery("#keeper").val();
    		    var transport = jQuery("#transport").val(); 
    		}
         }
         
       
         
        var planid = jq("#noofdays").val();
		var tripid = "<?php echo $trip_id; ?>";

		
		jq.post("index.php?option=com_semicustomized&task=trips.getPrice&tripid="+tripid+"&planid="+planid+"&hotel_booking="+hotel_booking+"&keeper="+keeper+"&transport="+transport,displayPricehome);

  		function displayPricehome(stext,status) {
			if(status=='success') {
                if((planid!='') && (hotel_booking!='') && (keeper!='') && (transport!='')) {
			       jq("#price").val(stext); 
			       jq("#cprice").val(stext); 
			       
			    } else {
			       jq("#price").val(""); 
			       jq("#cprice").val(""); 
			    }
			}
		}
        jq.post("index.php?option=com_semicustomized&task=trips.getPrograms&planid="+planid+"&tripid="+tripid,displayProgram);

		jq("#noofdays").change(function()
		{
			var planid = jq("#noofdays").val();
			var hotel_booking = jQuery("#hotel_booking").val();
			var keeper = jQuery("#keeper").val();
			var transport = jQuery("#transport").val();
			var noofdays =  jq("#noofdays").find('option:selected').text();
			
			jq.post("index.php?option=com_semicustomized&task=trips.getPrice&tripid="+tripid+"&planid="+planid+"&hotel_booking="+hotel_booking+"&keeper="+keeper+"&transport="+transport,displayPrice);
	        jq.post("index.php?option=com_semicustomized&task=trips.getPrograms&planid="+planid+"&tripid="+tripid,displayProgram);
		});

		function displayProgram(stext,status)
		{
			if(status=='success')
			{
				jq(".plan_list").html(stext);
			}
		}
        jq('body').on('change', '#keeper', function(event){
			var planid = jq("#noofdays").val();
			var hotel_booking = jq("#hotel_booking").val();
			var keeper = jq("#keeper").val();
			var transport = jq("#transport").val();
			var hotel_name =  jq("#hotel_booking").find('option:selected').text();


		jq.post("index.php?option=com_semicustomized&task=trips.getPrice&tripid="+tripid+"&planid="+planid+"&hotel_booking="+hotel_booking+"&keeper="+keeper+"&transport="+transport,displayPrice);

		});

        jq('body').on('change', '#hotel_booking', function(event){
			var planid = jq("#noofdays").val();
			var hotel_booking = jq("#hotel_booking").val();
			var hotel_name =  jq(this).find('option:selected').text();
			var keeper = jq("#keeper").val();
			var transport = jq("#transport").val();

		jq.post("index.php?option=com_semicustomized&task=trips.getPrice&tripid="+tripid+"&planid="+planid+"&hotel_booking="+hotel_booking+"&keeper="+keeper+"&transport="+transport,displayPrice);

		});

        jq('body').on('change', '#transport', function(event){
			var planid = jq("#noofdays").val();
			var hotel_booking = jq("#hotel_booking").val();
			var keeper = jq("#keeper").val();
			var hotel_name =  jq("#hotel_booking").find('option:selected').text();
			var transport = jq("#transport").val();


		jq.post("index.php?option=com_semicustomized&task=trips.getPrice&tripid="+tripid+"&planid="+planid+"&hotel_booking="+hotel_booking+"&keeper="+keeper+"&transport="+transport,displayPrice);

		});

		function displayPrice(stext,status)
		{
			if(status=='success')
			{
			    
			var planid = jq("#noofdays").val();
			var hotel_booking = jQuery("#hotel_booking").val();
			var keeper = jQuery("#keeper").val();
			var transport = jQuery("#transport").val();

			  if((planid!='') && (hotel_booking!='') && (keeper!='') && (transport!='')) {
			       jq("#price").val(stext); 
			       jq("#cprice").val(stext); 
			    } else {
			         jq("#price").val(""); 
			         jq("#cprice").val("");
			    }
			    
				
			}
		}

	   	jq('body').on('click', '#addtocart', function(event) {
			var trip_date = '<?php echo $trip_date;  ?>';
			var number_rooms = '<?php echo $number_rooms; ?>';
			var number_peoples = '<?php echo $number_peoples; ?>';
			var planid = jq("#noofdays").val();
			var price = jq("#price").val();
			var keeper_information = jq("#keeper").val();
			var trip_id = "<?php echo $trip_id; ?>";
			var noofdays =  jq("#noofdays").find('option:selected').text();
			var hotel_price = jQuery("#hotel_booking").val();


		    if (keeper_information==undefined)
				{
					var keeper_information = "";
				}

				var hotel = jq("#hotel_booking").find('option:selected').text();

				if(hotel==undefined)
				{
					var hotel = "";
				}
				var transport = jQuery("#transport").val();
				if(transport==undefined)
				{
					var transport = "";
				}

				if (keeper_information=='') {
					jq("#keeper").css('border', '1px solid #1313bc');
					jq("#keeper").focus();
				 } else {
					jq("#keeper").css('border', '1px solid #ff0303');
						if (hotel_price=='') {
							jq("#hotel_booking").css('border', '1px solid #1313bc');
							jq("#hotel_booking").focus();
						} else {
							jq("#hotel_booking").css('border', '1px solid #ff0303');
								if (transport=='') {
									jq("#transport").css('border', '1px solid #1313bc');
									jq("#transport").focus();
								} else {
									jq("#transport").css('border', '1px solid #ff0303');
									jq.post("index.php?option=com_semicustomized&task=trips.carttoSession&trip_date="+trip_date+"&number_rooms="+number_rooms+"&number_peoples="+number_peoples+"&noofdays="+noofdays+"&price="+price+"&keeper_information="+keeper_information+"&hotel="+hotel+"&transport="+transport+"&trip_id="+trip_id+"&planid="+planid,endResult);
							  }
						}
				    }
		     });
	/* Session Result */

		function endResult(stext,status)
		{
			if(status=='success')
			{
				var userid= "<?php echo $user_id; ?>";
				if(userid=='0')
				{
				  jq( "#lp-overlay" ).addClass("lp-open");
				  jq( ".lp-wrapper" ).addClass("lp-open");
				}
				else
				{
				var uid= "<?php echo $user_id; ?>";
				var trip_date = '<?php echo $trip_date;  ?>';
				var number_rooms = '<?php echo $number_rooms; ?>';
				var number_peoples = '<?php echo $number_peoples; ?>';
				var planid = jq("#noofdays").val();
				var price = jq("#cprice").val();
				var trip_id = "<?php echo $trip_id; ?>";
				var hotel_price = jq("#hotel_booking").val();
				var noofdays =  jq("#noofdays").find('option:selected').text();

				var keeper_information = jQuery("#keeper").val();

				if(keeper_information==undefined)
				{
					var keeper_information = "";
				}

			    var hotel = jq("#hotel_booking").find('option:selected').text();

				if(hotel==undefined)
				{
					var hotel = "";
				}
				var transport = jq("#transport").val();
				if(transport==undefined) {
						var transport = "";
				}
					if (keeper_information=='') {
						jq("#keeper").focus();
						return false;
					} else if (hotel=='') {
						jq("#hotel_booking").focus();
						return false;

					} else if (transport=='') {
						jq("#transport").focus();
						return false;

					} else if(price=='') {
					   jq("#price").focus();
					   return false;
					} else {
					   jq.post("index.php?option=com_semicustomized&task=trips.saveCart&trip_date="+trip_date+"&number_rooms="+number_rooms+"&number_peoples="+number_peoples+"&noofdays="+noofdays+"&price="+price+"&keeper_information="+keeper_information+"&hotel="+hotel+"&transport="+transport+"&trip_id="+trip_id+"&hotel_price="+hotel_price+"&planid="+planid,saveResult);
					}
				}
			}
		}
				//save function
		function saveResult(stext,status)
		{
			if(status=='success')
			{
			    var tid = "<?php echo $trip_id; ?>";
			    var userlog= "<?php echo $user_id; ?>";
			    url="index.php?option=com_semicustomized&view=trip&tid="+tid;
			    url2="index.php?option=com_semicustomized&view=trips";
			    if(userlog==0) {
			       window.location.href = url;
			    } else {
			      window.location.href = url2;
			    }

			}
		}

	});
</script>
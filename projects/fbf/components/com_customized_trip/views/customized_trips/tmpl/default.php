<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<?php
    $db=JFactory::getDBO();
    $user = JFactory::getUser();
    $user_id=$user->id;
    $eid = JRequest::getvar('eid');
    $page = JRequest::getvar('page');
    
    $_SESSION['trip'] = 'customized_trip';

    $no_days='';
    $budget='';

// echo date("F", strtotime("2010-08-13"));


	if (isset($_SESSION['no_days'])) {
		$no_days = $_SESSION['no_days'];
	}
	else {
		$no_days=1;
	}
	if (isset($_SESSION['budget'])) {
		$budget = $_SESSION['budget'];
	}
	else {
		$budget='';
	}
	
	if (isset($_SESSION['no_room'])) {
		$no_room = $_SESSION['no_room'];
	}
	else {
	    $no_room=1;
	}
	if (isset($_SESSION['no_people'])) {
		$no_people = $_SESSION['no_people'];
	} else {
		$no_people=1;
	}
	if (isset($_SESSION['transport'])) {
		$transport = $_SESSION['transport'];
	}
	else {
		$transport='';
	}
	if (isset($_SESSION['stay'])) {
		$stay = $_SESSION['stay'];
	} else {
	    $stay='';
	}
	if (isset($_SESSION['flight'])) {
		$flight = $_SESSION['flight'];
	} else {
		 $flight='';
	}
	if (isset($_SESSION['keeper'])) {
		$keeper = $_SESSION['keeper'];
	} else {
		$keeper='';
	}
	if (isset($_SESSION['write_us'])){
			$write_us = $_SESSION['write_us'];
	}else {
		$write_us='';
	}
	if (isset($_SESSION['dateofdeparture'])){
			$dateofdeparture = $_SESSION['dateofdeparture'];
	}else {
		$dateofdeparture='';
	}
	if (isset($_SESSION['placeofdeparture'])){
		$placeofdeparture = $_SESSION['placeofdeparture'];
	}else {
		$placeofdeparture='';
	}
?>

<script src="addons/owl/owl.carousel.js"></script>

<div class="inner_page">
   <div class="innerpage_banner">
       <div class="owl-carouseb">
           <div class="item"><img src="images/customized/P11GCP3.jpg" alt=""></div>
           <div class="item"><img src="images/customized/P12GCP3.jpg" alt=""></div>
           <div class="item"><img src="images/customized/P13GCP3.jpg" alt=""></div>
       </div>
   </div>
   <div class="inner_page_layout">
   <div class="left_img">
   <img src="images/ani2.png">
   </div>
       <div class="about_trip">
	          <h1 class="h1class">CUSTOMIZED TRIP</h1>
	          <p>In this fast-paced world it’s a luxury to travel at<span class="blue"> your own pace, in your own time and to your own selected destination</span>. This is why we believe that you should opt for this leisurely paced exploration and immerse yourself in true French culture.</p>

            <p>After you pick your travel goals, experiences you would like, and budget, <span class="blue">we present the most apt itinerary</span> with the most authentic experiences known to only insiders and locals, saving you countless hours of research.</p>
              <h1 class="insperation">GET INSPIRATION</h1>
	   </div>
	      <div class="right_img">
   <img src="images/ani.png">
   </div>
    </div>
    <div class="get_inspration">

        <div class="inspiration_detail">
           <div class="owl-carousel">
           <?php
                $sql="SELECT * FROM `#__customized_trip` WHERE state='1'";
                $db->setQuery($sql);
                $event_detail=$db->loadObjectList();
                foreach($event_detail as $event_disp)
                {
                    $event_id=$event_disp->id;
                    $event_name=$event_disp->trip_tittle;
                    $event_image=$event_disp->picture;
                    $short_description=$event_disp->description;
                    $pro_img = JURI::root().'customized_event/'.$event_image;

                    echo '<div class="item">
                    <div class="dispim1">
                    <a class="eventlink" href="JavaScript:Void(0);">
                    <img class=disimg src="'.$pro_img.'" alt="" />
                    <span class="eventtittle eventtittle1 evenblack">
                    <span>'.$event_name.'</span>
                    <div>'.$short_description.'</div></span>
						        </a>
                    </div>
                    </div>';
                }
           ?>
           </div>
       </div>
<link rel="stylesheet" href="addons/date/css/style.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css'>

       <div class="booking_div">
           <h1 class="h1class">LET'S GET STARTED</h1>
           <div class="bookingform">
           	   <img class="booking_left" src="<?php echo JURI::root(); ?>images/booking_left.jpg" alt="">
	           <form action="#" Method="POST" id="customize_booking">
	               <span id="errormsgdisplay"></span>
		           <div class="bookform_middle">
		               <div class="bookingformrow">
		                   <p>
			                   <label>No. of Days</label>
                         <input type="button" class="no_daysc" onclick="decday()" id="dec" value="-">
                         <input type="text" id="no_days" name="no_days" value="<?php echo $no_days; ?>" size="2" min="1" max="20" readonly="">
                         <input type="button" class="no_daysc" onclick="incday()" id="inc" value="+">

		                   </p>
		                   <p>
			                   <label>No. of People</label>
                         <input type="button"  class="button1" onclick="decpeople()" id="dec" value="-">
                        <input type="text" name="no_people" id="no_people" value="<?php echo $no_people; ?>" size="2" min="1" max="20" readonly="">
                        <input type="button" class="button1" onclick="incpeople()" id="inc" value="+">

		                   </p>
		                   <p>
			                   <label>Date of departure</label>
			                    <input type="text" value="<?php echo $dateofdeparture; ?>"  name="dateofdeparture" id="dateofdeparture" />
		                   </p>
						   <p>
			                   <label>Place of departure</label>
			                    <select name="placeofdeparture" id="placeofdeparture">
                        		<option value=""></option>
                        		<?php
                                $sql5="SELECT * FROM `#__placeofdeparture` WHERE state='1'";
                                $db->setQuery($sql5);
                                $res5=$db->loadObjectList();

                                foreach($res5 as $value_des5) {
                                    $placeofdeparture = $value_des5->placeofdeparture;
                                    $id =$value_des5->id;
                                    echo '<option value='.$placeofdeparture.'>'.$placeofdeparture.'</option>';
                                }
                                ?>
			                   </select>
		                   </p>
		                   <p>
			                   <label>Budget <span id="errmsg"></span></label>
			                   <input type="text" value="<?php echo $budget; ?>"  name="budget" id="budget">
			                   <input type="hidden" value="" name="minbudget" id="minbudget">
			                   <span class="minbudgetspam"></span>
		                   </p>
						 </div>
						 <div class="bookingformrow">
		                   <p>
			                   <label>No. of Rooms</label>
                          <input type="button" class="button1" onclick="decroom()" id="dec" value="-">
                         <input type="text" id="no_room" name="no_room" value="<?php echo $no_room; ?>" size="2" min="1" max="20" readonly="">
                         <input type="button" class="button1" onclick="incroom()" id="inc" value="+">

		                   </p>
		                   <p>
			                   <label>Transport</label>
			                   <select name="transport" id="transport">
		                       <option value=""></option>
                               <?php
                               $sql4="SELECT * FROM `#__trnasports` WHERE state='1'";
                               $db->setQuery($sql4);
                               $res4=$db->loadObjectList();

                               foreach($res4 as $value_des1)
                               {
                                    $trnasport = $value_des1->trnasport;
                                    $id =$value_des1->id;
                                    echo '<option value='.$trnasport.'>'.$trnasport.'</option>';
                               }
                                   ?>
			                   </select>
		                   </p>
		                   <p>
			                   <label>Stay</label>
			                   <select name="stay" id="stay">
			                       <option value=""></option>
                                <?php
                                $sql_hotel="SELECT * FROM `#__hotels` WHERE state='1'";
                                $db->setQuery($sql_hotel);
                                $sql_hotel_res=$db->loadObjectList();

                                foreach($sql_hotel_res as $hotel_value) {
                                    $hotel_name = $hotel_value->hotel_name;
                                    $id =$hotel_value->id;
                                    echo '<option value='.$hotel_name.'>'.$hotel_name.'</option>';
                                }
                                ?>
			                   </select>
		                   </p>
		                   <p>
			                   <label>Flight</label>
			                   <select name="flight" id="flight">
			                       <option value=""></option>
                                <?php
                                $sql2="SELECT * FROM `#__flightdetails` WHERE state='1'";
                                $db->setQuery($sql2);
                                $res2=$db->loadObjectList();

                                foreach($res2 as $value) {
                                    $flight_name = $value->flight_name;
                                    $id =$value->id;
                                    echo '<option value='.$flight_name.'>'.$flight_name.'</option>';
                                }
                                ?>
                                <option value="No">No</option>
			                   </select>
		                   </p>
		                   <p>
			                   <label>Keeper</label>
			                   <select name="keeper" id="keeper">
			                       <option value=""></option>
			                       <option value="Yes">With Keeper</option>
			                       <option value="No">Without Keeper</option>
                               </select>
		                   </p>
		               </div>
		               </div>
		               <div class="bookingform_right">
		                   <div class="rightusrow">
		                       <label>Write us your Wish</label>
		                       <textarea id="write_us" placeholder="Type here...." name="write_us"><?php echo $write_us; ?></textarea>
		                   </div>
						  <?php
							$sql_quotecount="SELECT COUNT(id) FROM `#__customized_order` WHERE uid=$user_id AND ((payment_status='intialized') || (trip_status!='final_quote'))";
						    $db->setQuery($sql_quotecount);
						    $quotecount=$db->loadResult();
						  ?>
		                   <input type="button" value="Book" id="customiz_bk_button" />

		               </div>
	           </form>
           </div>
       </div>
    </div>
</div>

<script>
         var firstjq=jQuery.noConflict();
          firstjq(document).ready(function() {
              var owl = firstjq('.owl-carouseb');
              owl.owlCarousel({
                items: 1,
                margin: 10,
                autoplay: false,
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
 var jq=jQuery.noConflict();
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
<script type="text/javascript">
function incday() {
    var no_days_avail = 20;
    var days = parseInt(document.getElementById('no_days').value, 10);
    if(days!=no_days_avail) {
        days = days + 1;
     }
    document.getElementById('no_days').value = days;
}
function decday() {
    var days = parseInt(document.getElementById('no_days').value, 10);
    days = days - 1;
    if(days <= 1) {
        days = 1;
      }
    document.getElementById('no_days').value = days;
}
function incpeople() {
    var no_peop_avail = 20;
    var people = parseInt(document.getElementById('no_people').value, 10);
    var room = parseInt(document.getElementById('no_room').value, 10);
    if(people!=no_peop_avail) {
        people = people + 1;
     }
     if(people > room) {
      room = room + 1;
     }
    document.getElementById('no_people').value = people;
    document.getElementById('no_room').value = room;
}
function decpeople() {
    var room = parseInt(document.getElementById('no_room').value, 10);
    var people = parseInt(document.getElementById('no_people').value, 10);


       valueh = people/3;
    valueh = Math.ceil(valueh);

    if(people!=2 || people == room) {
        people--;
        room--;

    }
    else if(people!=1) {
        people--;
    }
    if(people==0) {
        people++;
        room = 1;
    }
    if(valueh != room) {
        room++;
    }

    if(people <= room)
    {
        room--;
    }
    if (people == 1) {
        room = 1;

    }

    document.getElementById('no_room').value = room;
    document.getElementById('no_people').value = people;
}
function incroom() {
    var no_rooms_avail = 20;
    var people = parseInt(document.getElementById('no_people').value, 10);
    var room = parseInt(document.getElementById('no_room').value, 10);

     if(room == people || room > people) {
      room;
     } else if(room < people) {
        room = room + 1;

     } else if(room!=no_rooms_avail) {
        room = room + 1;
     }
    document.getElementById('no_room').value = room;
}
function decroom() {
    var people = parseInt(document.getElementById('no_people').value, 10);
    var room = parseInt(document.getElementById('no_room').value, 10);
    valueh = people/3;
    valueh = Math.ceil(valueh);

    if (room == people) {
        room = room--;
    }
    if(room != valueh && room != 1) {
        room--;

    } else {
      room = valueh;

    }

    document.getElementById('no_room').value = room;
}

</script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js'></script>

<script  src="addons/date/js/index.js"></script>
<style>
.bookingformrow input {
  display: block !important;
}
#bd .datepicker table tr td.today, .datepicker table tr td.today:hover, .datepicker table tr td.today.disabled, .datepicker table tr td.today.disabled:hover {
  background-color: #e72121;
  background-repeat: repeat-x;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  color: #ffffff;
}
#bd .datepicker table tr td.day:hover, .datepicker table tr td.day.focused {
  background: #e72121 none repeat scroll 0 0;
  color: #ffffff;
  cursor: pointer;
}
#bd .datepicker table tr td.today, .datepicker table tr td.today:hover, .datepicker table tr td.today.disabled, .datepicker table tr td.today.disabled:hover {
  background-color: #e72121;
  background-image: none;
  background-repeat: repeat-x;
  border-color: #e72121;
  color: #ffffff;
}
#bd .datepicker thead tr:first-child th:hover, .datepicker tfoot tr th:hover {
  background: #e72121 none repeat scroll 0 0;
}
</style>

<link rel="stylesheet" href="<?php echo JURI::root(); ?>addons/popupjs/style.css">
<script src="<?php echo JURI::root(); ?>addons/popupjs/modernizr.js"></script>

<script>

jQuery(document).ready(function(){
    jQuery("#budget").change(function() {
          //Check if value is empty or not
          if (jQuery(this).val() == "") {
              //if empty then assign the border
              jQuery(this).css("border", "1px solid red");
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
    jQuery("#no_days").change(function() {
          if (jQuery(this).val() == "") {
              jQuery(this).css("border", "1px solid red");
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
    jQuery("#no_people").change(function() {
          if (jQuery(this).val() == "") {
              jQuery(this).css("border", "1px solid red");
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
    jQuery("#no_room").change(function() {
          if (jQuery(this).val() == "") {
              jQuery(this).css("border", "1px solid red");
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
  jQuery("#transport").change(function() {
          if (jQuery(this).val() == "") {
              jQuery(this).css("border", "1px solid red");
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
   jQuery("#stay").change(function() {
          if (jQuery(this).val() == "") {
              jQuery(this).css("border", "1px solid red");
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
   jQuery("#flight").change(function() {
          if (jQuery(this).val() == "") {
              jQuery(this).css("border", "1px solid red");
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
   jQuery("#keeper").change(function() {
          if (jQuery(this).val() == "") {
              jQuery(this).css("border", "1px solid red");
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
   jQuery("#dateofdeparture").change(function() {
          if (jQuery(this).val() == "") {
              jQuery(this).css("border", "1px solid red");
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
   jQuery("#placeofdeparture").change(function() {
          if (jQuery(this).val() == "") {
              jQuery(this).css("border", "1px solid red");
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
   jQuery("#write_us").change(function() {
          if (jQuery(this).val() == "") {
              jQuery(this).css("border", "1px solid red");
              return false;
         }
        else
        {
          jQuery(this).css("border", "1px solid #1313bc");
        }
      });
	var userid='<?php echo $user_id; ?>';
	jQuery("#customiz_bk_button").click(function(){

	//	var quote_count=<?php echo $quotecount; ?>;
	       jQuery(".payment_description").html("");

			var no_days=jQuery("#no_days").val();
			var no_people=jQuery("#no_people").val();
			var budget=jQuery("#budget").val();
			var no_room=jQuery("#no_room").val();
			var transport=jQuery("#transport").val();
			var stay=jQuery("#stay").val();
			var flight=jQuery("#flight").val();
			var keeper=jQuery("#keeper").val();
			var write_us=jQuery("#write_us").val();
			var dateofdeparture=jQuery("#dateofdeparture").val();
			var placeofdeparture=jQuery("#placeofdeparture").val();
			var minbudget = jQuery("#minbudget").val();
			
			if(dateofdeparture=='') {
                jQuery("#errormsgdisplay").html("Please Enter Date of Departure");
                jQuery("#dateofdeparture").css("border", "1px solid red");
                jquery("#dateofdeparture").focus();
            } else {
                jQuery("#dateofdeparture").css("border", "1px solid #87c9ff");
            }
            if(budget==''){
			    jQuery("#budget").css("border","1px solid red");
			    jQuery("#budget").focus();
                jQuery(".minbudgetspam").html("Min budget:" +minbudget);
			    return false;
			}   
			 var minbudget = jQuery("#minbudget").val();
			 var minbudget = parseInt(minbudget);
			 var budget = parseInt(budget);
            
            if(budget < minbudget) {
                jQuery("#budget").css("border","1px solid red");
                jQuery(".minbudgetspam").html("Min budget:" +minbudget);
			} else if(no_people=='') {
			    jQuery("#errormsgdisplay").html("Please Select No of People");
			     jQuery("#no_people").css("border", "1px solid red");
			}
			else if(budget=='NAN')
			{
			     jQuery("#errormsgdisplay").html("Please Enter Your Budget");
			     jQuery("#budget").css("border", "1px solid red");
			}
			else if(no_room=='')
			{
			 jQuery("#errormsgdisplay").html("Please Select No of Room");
			 jQuery("#no_room").css("border", "1px solid red");
			}
			else if(transport=='')
			{
			  jQuery("#errormsgdisplay").html("Please Select Transport");
			  jQuery("#transport").css("border", "1px solid red");
			}
			else if(stay=='')
			{
			  jQuery("#errormsgdisplay").html("Please Select Hotel");
			  jQuery("#stay").css("border", "1px solid red");
			}
			else if(flight=='')
			{
			  jQuery("#errormsgdisplay").html("Please Select flight");
			  jQuery("#flight").css("border", "1px solid red");
			} else if(write_us=='') {
			  jQuery("#errormsgdisplay").html("Please Write Something");
			  jQuery("#write_us").css("border", "1px solid red");
			}
			else
			{
			    jQuery("#errormsgdisplay").html("");
                if(userid=='0')
                {
                    jQuery.post("index.php?option=com_customized_trip&task=customized_trips.saveinSession&no_days="+no_days+"&no_people="+no_people+"&budget="+budget+"&no_room="+no_room+"&transport="+transport+"&stay="+stay+"&flight="+flight+"&keeper="+keeper+"&write_us="+write_us+"&placeofdeparture="+placeofdeparture+"&dateofdeparture="+dateofdeparture,sessionResult);
                }
                else 
                {
                    var uid ='<?php echo $user_id; ?>';
                    jQuery.post("index.php?option=com_customized_trip&task=customized_trips.saveinDb&no_days="+no_days+"&no_people="+no_people+"&budget="+budget+"&no_room="+no_room+"&transport="+transport+"&stay="+stay+"&flight="+flight+"&keeper="+keeper+"&write_us="+write_us+"&uid="+uid+"&placeofdeparture="+placeofdeparture+"&dateofdeparture="+dateofdeparture,saveResult);
                }  
			}
	});
	/* Session Result */
		function sessionResult(stext,status)
		{
			if(status=='success')
			{
				var userid= "<?php echo $user_id; ?>";
				if(userid==0)
				{
				  jQuery( "#lp-overlay" ).addClass("lp-open");
				  jQuery( ".lp-wrapper" ).addClass("lp-open");
				}
				else
				{
					var uid= "<?php echo $user_id; ?>";
					var no_days=jQuery("#no_days").val();
					var no_people=jQuery("#no_people").val();
					var budget=jQuery("#budget").val();
					var no_room=jQuery("#no_room").val();
					var transport=jQuery("#transport").val();
					var stay=jQuery("#stay").val();
					var flight=jQuery("#flight").val();
					var keeper=jQuery("#keeper").val();
					var write_us=jQuery("#write_us").val();
					var dateofdeparture=jQuery("#dateofdeparture").val();
			        var placeofdeparture=jQuery("#placeofdeparture").val();
		 			jQuery.post("index.php?option=com_customized_trip&task=customized_trips.saveinDb&no_days="+no_days+"&no_people="+no_people+"&budget="+budget+"&no_room="+no_room+"&transport="+transport+"&stay="+stay+"&flight="+flight+"&keeper="+keeper+"&write_us="+write_us+"&uid="+uid+"&placeofdeparture="+placeofdeparture+"&dateofdeparture="+dateofdeparture,saveResult);
				}
			}
		}
		//save function
		function saveResult(stext,status)
		{
			if(status=='success')
			{
			//	window.location = "<?php echo JURI::root().'index.php?option=com_users&view=profile'; ?>";
			jQuery(".cd-popup").addClass("is-visible");
           // jQuery.post("index.php?option=com_customized_trip&task=customized_trips.paymentoption&flight="+flight,saveResult);
            jQuery(".paymentgateway").html(stext);
			}
		}

		jQuery('body').on('click', '.cancel_no', function(event)
		{
			jQuery(".cd-popup").removeClass("is-visible");
			jQuery(".paymentgateway").html("");
			jQuery(".payment_description").html("");
		});

		/* Dispaly session value start */
		    var no_days = "<?php echo $no_days; ?>";
			jQuery("#no_days option").each(function()
			{
				if( jQuery(this).val() == no_days )
				{
					jQuery(this).attr("selected","selected");
				}
			});

			var no_people = "<?php echo $no_people; ?>";
			jQuery("#no_people option").each(function()
			{
				if( jQuery(this).val() == no_people )
				{
					jQuery(this).attr("selected","selected");
				}
			});

			var placeofdeparture = "<?php echo $placeofdeparture; ?>";
			jQuery("#placeofdeparture option").each(function()
			{
				if( jQuery(this).val() == placeofdeparture )
				{
					jQuery(this).attr("selected","selected");
				}
			});

			var no_room = "<?php echo $no_room; ?>";
			jQuery("#no_room option").each(function()
			{
				if( jQuery(this).val() == no_room )
				{
					jQuery(this).attr("selected","selected");
				}
			});

			var transport = "<?php echo $transport; ?>";
			jQuery("#transport option").each(function()
			{
				if( jQuery(this).val() == transport )
				{
					jQuery(this).attr("selected","selected");
				}
			});

			var stay = "<?php echo $stay; ?>";
			jQuery("#stay option").each(function()
			{
				if( jQuery(this).val() == stay )
				{
					jQuery(this).attr("selected","selected");
				}
			});

			var flight = "<?php echo $flight; ?>";
			jQuery("#flight option").each(function()
			{
				if( jQuery(this).val() == flight )
				{
					jQuery(this).attr("selected","selected");
				}
			});

			var keeper = "<?php echo $keeper; ?>";
			jQuery("#keeper option").each(function()
			{
				if( jQuery(this).val() == keeper )
				{
					jQuery(this).attr("selected","selected");
				}
			});

		/* Dispaly session value End */
});
</script>


<div class="cd-popup" role="alert">
	<div class="cd-popup-container">
    <div class="popuppay">
        <div class="popupbanner"><img src="images/popupb.png"></div>
    <div class="popupcnt">
    <a href="#0" class="cd-popup-close img-replace">Close</a>
		<div class="paymentgateway custompay">
		</div>
     <div class="paymethod2" id="paymethod2">
     <span><img src="images/p1.png"></span><br/>
     <span><img src="images/p2.png"></span><br/>
     <span><img src="images/p3.png"></span><br/>
     <span><img src="images/p4.png"></span><br/>
     <span><img src="images/p5.png"></span><br/>
 </div>
        <h3 class="sel_opt1">please select your option</h3>
		<div class="payment_description">
		</div>
	</div>
</div>
</div>
</div>

<script src="<?php echo JURI::root(); ?>addons/popupjs/main.js"></script>


<script>
jQuery(document).ready(function(){
	var noofdays = jQuery('#no_days').val();
	var no_people = jQuery('#no_people').val();
    jQuery.post("index.php?option=com_customized_trip&task=customized_trips.minBudget&noofdays="+noofdays+"&no_people="+no_people,minAmount);

	jQuery('body').on('click', '.no_daysc', function(event) {
		var no_people = jQuery('#no_people').val();
		var noofdays = jQuery('#no_days').val();
		jQuery.post("index.php?option=com_customized_trip&task=customized_trips.minBudget&noofdays="+noofdays+"&no_people="+no_people,minAmount);
	});
	
	jQuery('body').on('click', '.button1', function(event) {
		var no_people = jQuery('#no_people').val();
		var noofdays = jQuery('#no_days').val();
		jQuery.post("index.php?option=com_customized_trip&task=customized_trips.minBudget&noofdays="+noofdays+"&no_people="+no_people,minAmount);
	});

function minAmount(stext,status)
    {
      	if(status=='success')
		{
			  jQuery("#minbudget").val(stext);
			  jQuery(".minbudgetspam").html("Min budget:" +stext);
		}
    }
   	jQuery('body').on('keyup', '#budget', function(e) {
   		     var budget = jQuery(this).val();
			 var minbudget = jQuery("#minbudget").val();
			 var minbudget = parseInt(minbudget);
			 var budget = parseInt(budget);

             if(budget < minbudget) {
               jQuery("#budget").css("border","1px solid red");
               
                jQuery(".minbudgetspam").html("Min budget:" +minbudget);
			 } else  if(budget == '' || budget==0) {
			    jQuery("#budget").css("border","1px solid red");
                jQuery(".minbudgetspam").html("Min budget:" +minbudget);
			     }else {
			 	 jQuery("#budget").css("border","1px solid #1313bc");
			 	 jQuery(".minbudgetspam").html("");
			 }
    });


	jQuery('body').on('change', '#paymethod', function(event) {
	    var selected_option = jQuery(this).val();
	    var flight_option = jQuery("#flight").val();

	    jQuery.post("index.php?option=com_customized_trip&task=customized_trips.paymentMessage&selected_option="+selected_option+"&flight_option="+flight_option,displayPaymsg);
    });

    function displayPaymsg(stext,status)
    {
      	if(status=='success')
		{
			  jQuery(".payment_description").html(stext);
		jQuery("#paymethod2").css("display" , "none");
		jQuery(".sel_opt1").css("display" , "none");
		}
    }
    
    
  //called when key is pressed in textbox
 jQuery("#budget").keypress(function (e) {
   		     var budget = jQuery(this).val();
   
			 var minbudget = jQuery("#minbudget").val();
			 var minbudget = parseInt(minbudget);
			 var budget = parseInt(budget);
			 
		if(budget <= minbudget || budget=='NaN') {
               jQuery("#budget").css("border","1px solid red");
                jQuery(".minbudgetspam").html("Min budget:" +minbudget);
			 } 
     
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
       jQuery("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
});
    
    
});
</script>
<script type="text/javascript">
	jQuery(document).ready(function(){
	    var isscroll='<?php echo $page; ?>';
		if(isscroll=='booking') {
    		var scroll= jQuery(window).scrollTop();
    		scroll= scroll+ 1320;
    		jQuery('html, body').animate({
  			scrollTop: scroll
			}, 1000);
		}
	});
</script>
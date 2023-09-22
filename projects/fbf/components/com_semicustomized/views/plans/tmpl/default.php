<?php
	$db=JFactory::getDBO();
	$user = JFactory::getUser();
	$user_id=$user->id;

	if(isset($_SESSION['number_peoples'])) {
		$number_peoples = $_SESSION['number_peoples'];
	} else {
		$number_peoples='0';
	}
	if(isset($_SESSION['number_rooms'])) {
		$number_rooms = $_SESSION['number_rooms'];
	} else {
		$number_rooms='0';
	}
	if(isset($_SESSION['trip_date'])) {
		$trip_date = $_SESSION['trip_date'];
	} else {
		$trip_date='';
	}
	if(isset($_SESSION['scroll'])) {
		$scroll = $_SESSION['scroll'];
	} else {
		$scroll='';
	}

	$_SESSION['hotel_price']='';
	$_SESSION['keeper_information']='';
    $_SESSION['transport']='';
    $_SESSION['planid']='';
    $_SESSION['trip_id']='';
	
?>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" href="addons/date/css/style.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css'>
<script src="addons/owl/owl.carousel.js"></script>

<div class="inner_page">
    <div class="innerpage_banner">
       <div class="owl-carouseb">
            <div class="item"><img src="images/semicustom/P13GSCP5.jpg" alt=""></div>
           <div class="item"><img src="images/semicustom/P11GSCP5.jpg" alt=""></div>
           <div class="item"><img src="images/semicustom/P12GSCP5.jpg" alt=""></div>
       </div>
   </div>
</div>

<div class="inner_page_layout">
       <div class="left_img">
           <img src="images/sleft.png">
       </div>

    <div class="about_trip">
	      <h1 class="h1class">SEMI CUSTOMISED</h1>
        <p>Want to explore the uncharted France but don’t <span class="blue">know where to go?</span> This is the answer!
        Created for explorers who would like to discover France in a private manner, <span class="blue">you can build your own trip</span> by assembling our packages which <span class="blue">match your taste, desire and needs.</span>
        You build your travel based on the region you would like <span class="blue">to explore or based on your interest.</span> After submitting your request, we will get back to you within 24 hours with the exact quotation for your perfect trip. </p>
        <p class="cent_txt"><span class="blue">It is as easy as that!</span></p>
        <div class="semi_form">
            <div class="trip_customize">
                <div class="trip_reg">
                   <form Method="POST" id="trip_validate">
	                   <div class="depature_form">
	                       <p>
	                           <label class="depature">Date Of Depature</label>
                               <input type="text" value="<?php echo $trip_date; ?>" placeholder="Date of Departure" name="trip_date" id="trip_date" >
	                       </p>
	                   </div>
                        <div class="num_pepole">
	                        <p>
                                <label class="depature">No. of People</label>
                                <input type="button" class="semminus" onclick="decpeople()" id="decr" value="-">
                        <input type="text" name="number_peoples" id="number_peoples" value="<?php echo $number_peoples; ?>" size="2" min="0" max="20" readonly="">
                        <input type="button" class="semplus" onclick="incpeople()" id="incr" value="+">

                            </p>
                         </div>
                         <div class="num_pepole">
                          <p>
                              <label class="depature">No.of Rooms</label>
                              	<input type="button" class="semminus" onclick="decroom()" id="dec" value="-">
		                        <input type="text" id="number_rooms" name="number_rooms" value="<?php echo $number_rooms; ?>" size="2" min="0" max="20" readonly="">
		                        <input type="button" class="semplus" onclick="incroom()" id="inc" value="+">
                             </p>
                        </div>
                    </form>
                </div>
            </div>
	    </div>
    </div>

    <div class="right_img">
       <img src="images/sright.png">
    </div>
</div>


    <div class="semicustomized_tripz">
        <div class="get_inspration hide_interest">
            <h1 class="h1class">Explore By Interest</h1>
            <div class="inspiration_detail byinterest">
                
            </div>
        </div>
    </div>

       <div class="get_region hide_region">
           <h1 class="h1class1">Explore By Region</h1>
           <div class="inspiration_detail byregion">
               
       </div>
</div>

	<div class="semisubmit_form">
	    <div class="price_customize">
	        <div class="submit_reg">
	            <form  Method="POST" id="trip_validate">
	                <div class="num_days">
	                    <p>
						 <label class="sub_trip">Total No of days in cart</label>
						 <input type="text" value="" name="semi_trip" class="cartinput" id="semi_trip" readonly>
	                    </p>
					</div>
					<div class="num_days">
						<p>
						    <label class="sub_trip">Price per Person</label>
						    <input type="text" value="" class="displaypriceper_person cartinput" readonly>
						</p>
					</div>
	                <div class="num_days">
	                    <p>
	                        <label class="sub_trip">Total Price</label>
	                        <input type="text" value="" class="cartinput" name="trip_price" id="trip_price" readonly>
	                    </p>
	                </div>
					<div class="end_trip">
	                    <p>
	                        <input type="button" value="Submit" name="trip_submit" id="trip_submit">
	                    </p>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>

    <div class="semitriplisz">
       <div class="alreadyadded"></div>
    </div>

<script type="text/javascript">
function incpeople() {
    var no_peop_avail = 20;
    var people = parseInt(document.getElementById('number_peoples').value, 10);
    var room = parseInt(document.getElementById('number_rooms').value, 10);
    if(people!=no_peop_avail) {
        people = people + 1;
     }
     if(people > room) {
      room = room + 1;
     }
    document.getElementById('number_peoples').value = people;
    document.getElementById('number_rooms').value = room;
}
function decpeople() {
    var room = parseInt(document.getElementById('number_rooms').value, 10);
    var people = parseInt(document.getElementById('number_peoples').value, 10);

    if(people!=0) {
      valueh = people/2;
      valueh = Math.round(valueh);  
    } else {
       people=0; 
    }
    if((people == room) || (people!=0)) {
        people--;
        room--;
    }
    else if(people!=1) {
        people--;
    }
    if(people==-1) {
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

    document.getElementById('number_rooms').value = room;
    document.getElementById('number_peoples').value = people;
}
function incroom() {
    var no_rooms_avail = 20;
    var people = parseInt(document.getElementById('number_peoples').value, 10);
    var room = parseInt(document.getElementById('number_rooms').value, 10);

     if(room == people || room > people) {
      room;
     } else if(room < people) {
        room = room + 1;

     } else if(room!=no_rooms_avail) {
        room = room + 1;
     }
    document.getElementById('number_rooms').value = room;
}
function decroom() {
    var people = parseInt(document.getElementById('number_peoples').value, 10);
    var room = parseInt(document.getElementById('number_rooms').value, 10);
    
    
    valueh = people/2;
    valueh = Math.round(valueh);

    if (room == people) {
        room = room--;
    }
    if(room != valueh && room != 1) {
        room--;

    } else {
      room = valueh;

    }

    document.getElementById('number_rooms').value = room;
}

</script>
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

<link rel="stylesheet" href="<?php echo JURI::root(); ?>addons/popupjs/style.css">
<script src="<?php echo JURI::root(); ?>addons/popupjs/modernizr.js"></script>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	

	<script>
	jQuery(document).ready(function()
	{

		var uid ='<?php echo $user_id; ?>';
		jQuery.post("index.php?option=com_semicustomized&task=trips.displayThis&uid="+uid,displayAddedpro);

		jQuery('body').on('click', '.remove', function(event) {
			var delete_rev_id = jQuery(this).attr("id");

    	/* Split code START */
			var array = delete_rev_id.toString().split("-");

			for (var i = 0; i < array.length; i++)
			{
				var remove_id = array[1];
			}
		/* Split code END */

			jQuery.post("index.php?option=com_semicustomized&task=trips.removeThis&remove_id="+remove_id,removeAction);
		});

		function removeAction(stext,status)
		{
			if(status=='success')
			{
				jQuery.post("index.php?option=com_semicustomized&task=trips.displayThis&uid="+uid,displayAddedpro);
			}
		}

		function displayAddedpro(stext,status)
		{
			if(status=='success')
			{
				var array = stext.toString().split("^");

				for (var i = 0; i < array.length; i++)
					{
						var prodetails = array[0];
						var totalprice = array[1];
						var tripetype = array[2];
						var cartcout = array[3];
						var noofdays = array[4];
						var displaypriceper_person = array[5];

					}
				jQuery(".alreadyadded").html(prodetails);
				jQuery("#trip_price").val(totalprice);
				// jQuery("#semi_trip").val(cartcout);
				jQuery("#semi_trip").val(noofdays+' Days'); 
				
				if(displaypriceper_person!=''){
			        var a = Math.round(displaypriceper_person);
			        jQuery(".displaypriceper_person").val(a);	    
				} else {
				    jQuery(".displaypriceper_person").val('');
				}

				if(tripetype=='Interest') {
					jQuery(".get_region").css("display","none");
					jQuery(".semi_form").hide();

				} else {
					jQuery(".get_region").css("display","block");
				}
				 if(tripetype=='Region') {
					jQuery(".get_inspration").css("display","none");
					jQuery(".semi_form").hide();
				} else {
					jQuery(".get_inspration").css("display","block");
				}
			}
		}

		jQuery('body').on('click', '.semipro_img', function(event) {
			var tid = jQuery(this).attr("id");
			var number_peoples = jQuery("#number_peoples").val();
			number_peoples=parseInt(number_peoples);
			var number_rooms = jQuery("#number_rooms").val();
			var trip_date = jQuery("#trip_date").val();
			var keeper = jQuery("#keeper").val();
			var hotel_booking = jQuery("#hotel_booking").val();
			var transport = jQuery("#transport").val();

			if (trip_date=='') {
				jQuery("#trip_date").focus();
				jQuery("#trip_date").css("border", "1px solid #ff0303");
			}
			else if (number_peoples==0) {
				jQuery("#number_peoples").focus();
				jQuery("#number_peoples").css("border", "1px solid #ff0303");
			}
			else if (number_rooms==0) {
				jQuery("#number_rooms").focus();
				jQuery("#number_rooms").css("border", "1px solid #ff0303");
			}
			else
			{
				url="index.php?option=com_semicustomized&view=trip&tid="+tid;
				window.location.href = url;
			}
		});

		var number_peoples = "<?php echo $number_peoples; ?>";
		    number_peoples=parseInt(number_peoples);
		var number_rooms = "<?php echo $number_rooms; ?>";
		
		var trip_date = "<?php echo $trip_date; ?>";


		jQuery.post("index.php?option=com_semicustomized&task=trips.newsession&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult);
		
		jQuery.post("index.php?option=com_semicustomized&task=trips.newsession2&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult2);

		jQuery("#incr").click(function()
		{
			var number_peoples = jQuery("#number_peoples").val();
			number_peoples=parseInt(number_peoples);
			var number_rooms = jQuery("#number_rooms").val();
			var trip_date = jQuery("#trip_date").val();
			jQuery.post("index.php?option=com_semicustomized&task=trips.newsession&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult);
			jQuery.post("index.php?option=com_semicustomized&task=trips.newsession2&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult2);
		});
		jQuery("#decr").click(function()
		{
			var number_peoples = jQuery("#number_peoples").val();
			number_peoples=parseInt(number_peoples);
			var number_rooms = jQuery("#number_rooms").val();
			var trip_date = jQuery("#trip_date").val();
			jQuery.post("index.php?option=com_semicustomized&task=trips.newsession&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult);
			jQuery.post("index.php?option=com_semicustomized&task=trips.newsession2&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult2);
		});
		jQuery("#inc").click(function()
		{
			var number_peoples = jQuery("#number_peoples").val();
			number_peoples=parseInt(number_peoples);
			var number_rooms = jQuery("#number_rooms").val();
			var trip_date = jQuery("#trip_date").val();
			jQuery.post("index.php?option=com_semicustomized&task=trips.newsession&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult);
			jQuery.post("index.php?option=com_semicustomized&task=trips.newsession2&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult2);
		});
		jQuery("#dec").click(function()
		{
			var number_peoples = jQuery("#number_peoples").val();
			number_peoples=parseInt(number_peoples);
			var number_rooms = jQuery("#number_rooms").val();
			var trip_date = jQuery("#trip_date").val();
        jQuery.post("index.php?option=com_semicustomized&task=trips.newsession&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult);
        jQuery.post("index.php?option=com_semicustomized&task=trips.newsession2&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult2);

		});

		jQuery("#trip_date").change(function()
		{
			var number_peoples = jQuery("#number_peoples").val();
			number_peoples=parseInt(number_peoples);
			var number_rooms = jQuery("#number_rooms").val();
			var trip_date = jQuery("#trip_date").val();
        	jQuery.post("index.php?option=com_semicustomized&task=trips.newsession&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult);
        	jQuery.post("index.php?option=com_semicustomized&task=trips.newsession2&number_peoples="+number_peoples+"&number_rooms="+number_rooms+"&trip_date="+trip_date,displayslideResult2);
		});
		
    	function displayslideResult(stext,status)
        {
          	if(status=='success')
    		{
    			 jQuery(".byinterest").html(stext);
    		}
        }
    	function displayslideResult2(stext,status)
        {
          	if(status=='success')
    		{
    			 jQuery(".byregion").html(stext);
    			 stext=stext.replace(/(^[ \t]*\n)/gm, "")
    			 if(stext=='no') {
    			     jQuery('.hide_region').css('display','none');
    			 } else {
    			     jQuery('.hide_region').css('display','block');
    			 }
    		}
        }
		
		var number_peoples = "<?php echo $number_peoples; ?>";
         jQuery("#number_peoples option").each(function()
            {
                if( jQuery(this).val() == number_peoples )
                {
                    jQuery(this).attr("selected","selected");
                }
            });
		var number_rooms = "<?php echo $number_rooms; ?>";

            jQuery("#number_rooms option").each(function()
            {
                if( jQuery(this).val() == number_rooms )
                {
                    jQuery(this).attr("selected","selected");
                }
            });

			var trip_date = "<?php echo $trip_date; ?>";

            jQuery("#trip_date option").each(function()
            {
                if( jQuery(this).val() == trip_date )
                {
                    jQuery(this).attr("selected","selected");
                }
            });

        jQuery("#trip_submit").click(function() {
               var cart_count = jQuery("#semi_trip").val();
               var trip_price = jQuery("#trip_price").val();
               		if(trip_price!=''){
               			jQuery(".cd-popup").addClass("is-visible");
               		} else {
               			alert("Sorry your cart is Empty.");
               		}
            	
            });
	        jQuery('body').on('click', '.cancel_no', function(event) {
				jQuery(".cd-popup").removeClass("is-visible");
				jQuery(".paymentgateway").html("");
				jQuery(".payment_description").html("");
			});
		});
</script>

	   <?php
		$sqlgetorder="SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND payment_status='intialized' AND  quote_status='0'";
		$db->setQuery($sqlgetorder);
		$sqlgetorder=$db->loadObjectList();

		foreach($sqlgetorder as $result_res) {
		   	$order_id[]=$result_res->id;
	    }
      // echo $ids =explode(",", $allid);
	   ?>


<div class="cd-popup" role="alert">
    <div class="cd-popup-container">
        <div class="popuppay">
        <div class="popupbanner"><img src="images/popupb.png"></div>
        <div class="popupcnt">
        <a href="#0" class="cd-popup-close img-replace">Close</a>
        <div class="paymentgateway">
           <form action="#" method="POST" id="pay">
            <div class="paymentflight">
            <label>Flight</label>
            <select id="flight" name="flight">
             <option value=""></option>
            <?php

            $avail_fligt="SELECT * FROM `#__fixed_trip_flight` WHERE state=1";
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
                $avail_fligt="SELECT * FROM `#__fixed_trip_place_departures` WHERE state=1";
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
                <option value="Participative">Participative</option>
            </select>
            <input type="hidden" value="<?php foreach($order_id as $order_ids) { echo  $allid=$order_ids.','; } ?>" id="lastinsertedid" name="lastinsertedid">
            <input type="submit" value="Submit" id="request_quote">
            <input type="hidden" value="com_users" name="option">
            <input type="hidden" value="user.semi_trip_update" name="task">
         </div>

     </form>
 </div>
 
  <div class="paymethod1" id="paymethod1">
     <span><img src="images/p1.png"></span></br>
     <span><img src="images/p2.png"></span></br>
     <span><img src="images/p3.png"></span>
     <span><img src="images/p4.png"></span>
     <span><img src="images/p5.png"></span>
 </div>

 <div class="payment_description">
     </div>
</div>
</div>
</div>
</div>

<script src="<?php echo JURI::root(); ?>addons/popupjs/main.js"></script>

<script>
jQuery(document).ready(function(){

    jQuery('body').on('change', '#flight', function(event) {
        var selected_option = jQuery('#paymethod').val();
        var lastinsertedid = jQuery("#lastinsertedid").val();
        var flight_option = jQuery(this).val();
        var triptypez = 'semi';

        jQuery.post("index.php?option=com_customized_trip&task=customized_trips.paymentMessage&selected_option="+selected_option+"&flight_option="+flight_option+"&lastinsertedid="+lastinsertedid+"&triptypez="+triptypez,displayPaymsg);
    });
	jQuery('body').on('change', '#paymethod', function(event) {
	    var selected_option = jQuery(this).val();
	    var flight_option = jQuery("#flight").val();
	    var lastinsertedid = jQuery("#lastinsertedid").val();
	    var triptypez = "semi";

	    jQuery.post("index.php?option=com_customized_trip&task=customized_trips.paymentMessage&selected_option="+selected_option+"&flight_option="+flight_option+"&lastinsertedid="+lastinsertedid+"&triptypez="+triptypez,displayPaymsg);
    });

    function displayPaymsg(stext,status)
    {
      	if(status=='success')
		{
			 jQuery(".payment_description").html(stext);
			 jQuery("#paymethod1").css("display" , "none");
		}
    }
});
</script>

<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js'></script>

<script>
	var dateToday = new Date();
	jQuery(document).ready(function(){
	  jQuery("#trip_date").datepicker({
	      format: 'dd-mm-yyyy',
	        autoclose: true,
	        startDate: "+0d" ,
	        todayHighlight: true
	  });
	});
	</script>

		<script type="text/javascript">
			jQuery(document).ready(function(){
			    var isscroll='<?php echo $scroll; ?>';
			    if(isscroll!='') {
    				var scroll= jQuery(window).scrollTop();
    				scroll= scroll+ 1150;
    				jQuery('html, body').animate({
    					scrollTop: scroll
    				}, 1000);
			    }

			});
		</script>

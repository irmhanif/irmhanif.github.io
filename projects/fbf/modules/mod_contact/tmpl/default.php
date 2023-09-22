<?php
/**
 * @copyright	Copyright (c) 2018 mod_. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;


?>

 <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    jQuery(document).ready(function(){
        jQuery('body').on('click', '#contact_submit', function(event) {
            var name = jQuery('#user_name').val();
            var email = jQuery('#emailid').val();
            var mobile = jQuery('#mobileno').val();
            var message = jQuery('#message1').val();
            var name_regex =  /^[a-z A-Z ]*$/;
            var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var mobile_regex = /^[0-9]+$/;
            var message_regex = /^[0-9]+$/;
            if (name =='')	 {
                jQuery('#p1').html("*Enter your name *");
                return false;	
            } else if(!name.match(name_regex)) {
                jQuery('#p1').text("* For your name please use alphabets only *");
                return false;
            } else if(email =='') {
               jQuery('#p1').text("");
               jQuery('#p2').text("* Enter your Email*");
               return false; 
            } else if(!email.match(email_regex)) {
                jQuery('#p2').html("* Enter your valid Email*");
                jQuery("#emailid").focus();
                return false;
            } else if( mobile =='') {
                jQuery('#p2').html("");  
                jQuery('#p3').html("* Please Enter your mobile number *");
                return false;
            } else if(!mobile.match(mobile_regex)) {
                jQuery('#p3').text("* Please enter valid Mobile Number *");
                jQuery("#mobileno").focus();
                return false;
            } else if(message =='') {
                jQuery('#p3').html("");
                jQuery("#message1").focus();
                jQuery('#p4').html("* Please Enter any Comments *");
                return false;
            }  else if (grecaptcha.getResponse() == ""){
                alert("Please check as a Captcha");
                return false;
            } else {
                return true;
            }
        });
    });
</script>
<div class="contactform">
    <form name="myform1" id="contact_form" action="#" method="POST">
        <div class = "con_in">
            <input type="text" name="user_name"  id="user_name" class = "formname2" placeholder="Complete Name" >
            <span id="p1" style="color: red;"></span>
        </div>
        <div class = "con_in">
            <input type="text" name="email" id="emailid" class = "formname2" placeholder="Email Address">
            <span id="p2" style="color: red;"></span>
        </div>
        <div class = "con_in">
            <input type="text" name="mobile" id="mobileno" class = "formname2" placeholder="Phone no">
            <span id="p3" style="color: red;"></span>
        </div>
        <div class = "con_in3">
            <textarea rows="3" cols="20" id="message1" name="msg" placeholder="Message"></textarea>
            <span id="p4" style="color: red;"></span>
        </div>
        <div class = "con_in" style='margin-left:20%;'>
             <div class="g-recaptcha" data-sitekey="6LduX7EUAAAAADfZQjGUvTA-qG-KU7sPLMZTAvI4"></div>
         </div>
        <div class = "con_in1">
            <input type="submit" value="Start Discussion" id="contact_submit">
        </div>
        <input type="hidden" value="com_users" name="option">
        <input type="hidden" value="user.contactus" name="task">
    </form>
</div> 

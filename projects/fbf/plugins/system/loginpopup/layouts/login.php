<?php
require_once JPATH_SITE . '/components/com_users/helpers/route.php';
require_once JPATH_PLUGINS . '/system/loginpopup/helper.php';

$return                = PlgSystemLoginPopupHelper::getReturnURL($displayData, 'login');
$twofactormethods    = PlgSystemLoginPopupHelper::getTwoFactorMethods();

?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

<link rel='stylesheet prefetch' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
<link rel='stylesheet prefetch' href='https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css'>

<div id="lp-overlay"></div>

<div class="popup_right">


<div id="lp-popup" class="lp-wrapper">
 <div class="slide_content"	><p>- FRANCE BY FRENCH -</p></div>
<div class="sideimg"><img src="images/login.png"></div>
<div class="splitup">
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">Login</button> <span class="seprater">|</span>
 <button class="tablinks" onclick="openCity(event, 'Paris')">Sign up</button>
</div>
<div id="London" class="tabcontent">

    <button class="lp-close" type="button" title="Close (Esc)">×</button>

    <form action="<?php echo JRoute::_('index.php?option=com_users&view=login', true, $displayData->get('usesecure')); ?>" method="post" class="lp-form">

        <div class="lp-field-wrapper loginin">
            <!-- <label for="lp-username"><?php echo JText::_('PLG_SYSTEM_LOGINPOPUP_USERNAME'); ?> *</label> -->
            <input type="text" id="lp-username" class="lp-input-text lp-input-username" name="username" placeholder="Email ID / Phone Number" required="true" autocomplete="off"/>
        </div>
        <div class="lp-field-wrapper loginin">
            <!-- <label for="lp-password"><?php echo JText::_('PLG_SYSTEM_LOGINPOPUP_PASSWORD'); ?> *</label> -->
            <input type="password" id="lp-password" class="lp-input-text lp-input-password" name="password" placeholder="Password" required="true" />
            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
        </div>

        <?php if (count($twofactormethods) > 1) : ?>
            <div class="lp-field-wrapper">
                <label for="lp-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?></label>
                <input type="text" id="lp-secretkey" autocomplete="off" class="lp-input-text" name="secretkey" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>" />
            </div>
        <?php endif; ?>

        <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
            <div class="lp-field-wrapper">
                <input type="checkbox" id="lp-remember" class="lp-input-checkbox" name="remember" />
                <label for="lp-remember"><?php echo JText::_('PLG_SYSTEM_LOGINPOPUP_REMEMBER_ME'); ?></label>
            </div>
           
        <?php endif; ?>
            <div class="lp-field-wrapper">
                <ul class="lp-right lp-link-wrapper">
                <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">Forgot Password?</a>
                </li></ul>
            </div>

        <div class="lp-button-wrapper clearfix">
            <div class="lp-left">
                <button type="submit" class="lp-button"><?php echo JText::_('JLOGIN'); ?></button>
            </div>


        </div>

        <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="task" value="user.login" />
        <input type="hidden" name="return" value="<?php echo $return; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>

<div id="Paris" class="tabcontent">
    <button class="lp-close" type="button" title="Close (Esc)">×</button>
 <div class="reg_frm">
    <div class="reg_frm2">
        <div class="hosterform">
        <span id="errorBox"></span>
        <form name = "regform1" action="#" id ="regform1" method="post"  enctype="multipart/form-data" />
            <div class = "regfield">
                <input type="text" name="name"  placeholder="First Name" id ="fname" value="" />
            </div>
            <div class = "regfield">
                <input type="text" name="lname"  placeholder="Last Name" id ="lname" value="" />
            </div>
            <div class = "regfield">
                <input type="text" name="email"  placeholder="Email ID"  id ="email" value="" />
            </div>
            <div class = "regfield">
                <input type="text" name="phone"  placeholder="Mobile Number(10 digits)"  id ="phone" value="" />
            </div>

            <div class = "regfield regfield2">
                <input type="password" name="pword"  placeholder="Password"  id ="pword" value="" />
            </div>
            <div class = "regfield regfield2">
                <input type="password" name="repword"   placeholder="Re-enter Password"  id ="repword" value="" />

            </div>

            <span class="agree">
<input type="checkbox" value="ok" id="iagree2" name="iagree2"/>I agree with the
<a class="jcepopup" href="index.php?option=com_content&amp;view=article&amp;id=11&amp;Itemid=169" target="_blank">Terms of Conditions</a>
of France By French
</span>
            <div class = "regfield final">
                <input id="bt_sup" type="button"  value="Register">
            </div>
        </form>
        </div>
    </div>
    <span class="signup_mess"></span>
</div>
</div>
</div>
</div>
</div></div>

<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>

<script>
jQuery(".toggle-password").click(function()
    {
jQuery(this).toggleClass("fa-eye fa-eye-slash");

 var x = document.getElementById("lp-password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
});
jQuery(document).ready(function(){
    jQuery("#bt_sup").click(function(){
        var iagree2 = jQuery("input[name='iagree2']:checked").val();
        var name = jQuery("#fname").val();
        var lname = jQuery("#lname").val();
        var email = jQuery("#email").val();
        var phone = jQuery("#phone").val();
        var pword = jQuery("#pword").val();
        var repword = jQuery("#repword").val();

        var emailRegex = /^[A-Za-z0-9._]*\@[A-Za-z]*\.[A-Za-z]{2,5}$/;
        var filter = /^[0-9-+]+$/;
        var num = /^\d{10}$/;
        if(name == "")
        {
            jQuery("#fname").focus();
            alert("Please Enter Your Name");
            return false;
        } else if(lname == "" ) {
            jQuery("#lname").focus();
            alert("Please Enter the last name");
            return false;
        }
        else if(email == "" )
        {
            jQuery("#email").focus();
            alert("Please Enter the email");
            return false;
        }
        else if(!emailRegex.test(email))
        {
             jQuery("#email").focus();
             alert("Please Enter the valid email");
             return false;
        }

        else if(phone=='')
        {
            jQuery("#phone").focus();
            alert("Enter  mobile number");
            return false;
        }
        else if(!phone.match(num))
        {
            jQuery("#phone").focus();
            alert("Enter valid mobile number");
            return false;
        }

        else if(pword == "")
        {
            jQuery("#pword").focus();
            alert(" Please Enter the password");
            return false;
        }
        else if(repword == "")
        {
            jQuery("#repword").focus();
            alert(" Please Re-Enter the password");
            return false;
        }
        else if(pword != repword)
        {
            jQuery("#pword").focus();
            alert(" password mis-matching");
            return false;
        }
        else if(!iagree2)
        {
            alert("Please agree the terms and condition");
            return false;
        }
        else
        {
        jQuery.post("index.php?option=com_users&task=user.reg_validation&phone="+phone+"&email="+email, mob_validation);
        return true;
        }
});
function mob_validation(stext,status)
    {
        if(status=='success')
        {
            if(stext == 'success')
            {
                var name = jQuery("#fname").val();
                var lname = jQuery("#lname").val();
                var email = jQuery("#email").val();
                var phone = jQuery("#phone").val();
                var pword = jQuery("#pword").val();
                jQuery.post("index.php?option=com_users&task=user.newuser_reg&name="+name+"&lname="+lname+"&email="+email+"&phone="+phone+"&pword="+pword,newuser_response);
            }
            else if(stext == 'mobile')
            {
            alert("The Mobile number you entered already in use");
            }
            else if(stext == 'email')
            {
            alert("The Email you entered already in use");
            }
        }
    }
function newuser_response(stext,status)
    {
        if(status=='success')
        {
        jQuery(".signup_mess").html("Registration completed successfully.So Please Login");
         jQuery( '#regform1' ).each(function()
          {
                    //this.reset();
          });
            if (stext=="customized_trip") {
            	 window.location = "<?php echo JURI::root().'index.php?option=com_customized_trip&view=customized_trips&page=booking'; ?>";
            } else if(stext=="semicustomized_trip") {
            		window.location = "<?php echo JURI::root().'index.php?option=com_semicustomized&view=trip&f=login'; ?>";
            } else if(stext=="fixed_trip") {
                window.location = "<?php echo JURI::root().'index.php?option=com_fixed_trip&view=create_trip'; ?>";
            } else {
                window.location = "<?php echo JURI::root(); ?>";
            }
          }
    }
});
</script>

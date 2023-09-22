

<?php
/**
 * @copyright	Copyright (c) 2019 mod_. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
echo' <div class="review_page">
<img src="/images/pro.png" alt="">
   <h1>Travel Stories</h1>
   <p class="deas"><span class="blue">Hear the fascinating stories about France from our fellow travelers</span></p>
   </div>';
  
?>
<div id="review"></div>

<script>
rev = jQuery.noConflict();
rev(document).ready(function() {
    rev.post("index.php?option=com_trips&task=trips.review",displayrev);
    
    function displayrev(stext,status) {
        if(status=='success') {
            rev("#review").html(stext);
        }
    }

});
</script>

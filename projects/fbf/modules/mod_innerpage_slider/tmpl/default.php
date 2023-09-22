<?php
/**
 * @copyright	Copyright (c) 2018 mod_. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

$id = JRequest::getVar('Itemid');
?>

<script src="addons/owl/jquery.min.js">
</script><script src="addons/owl/owl.carousel.js">
</script> 
<?php
if($id==109)
{

  echo '<div class="innerpage_banner">    
	  <div class="item"><img src="images/P1GCUP11-B.jpg" alt=""></div>     
  </div>'; 

}
else if($id==139)
{
   echo '<div class="innerpage_banner1">    
	  <div class="owl-carouseb">    
	  <div class="item"><img src="images/banners/P1GSO2-A.jpg" alt=""></div>        	
    	
	  </div>     
  </div>'; 
}
else if($id==140)
{
   echo '<div class="innerpage_banner">    
	  <div class="owl-carouseb">    
	  <div class="item"><img src="images/expltr/e3.png" alt=""></div>       	   	
	  <div class="item"><img src="images/expltr/e2.png" alt=""></div>       	   	
	  <div class="item"><img src="images/expltr/e1.png" alt=""></div>       	   	
	  </div>     
  </div>'; 
}
?>
  <script>    
  var firstjq=jQuery.noConflict();   
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
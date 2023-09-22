<?php
        $db = JFactory::getDbo();
		$user = JFactory::getUser();
	 	$user_id = $user->get('id');
		$cid=JRequest::getVar('cid');
	    $listid=JRequest::getVar('id');

?>
<script src="addons/owl/jquery.min.js">
</script><script src="addons/owl/owl.carousel.js">
</script> 


<div class="innerpage_banner">    
	  <div class="owl-carouseb">    
	 <?php
	$db = JFactory::getDbo();
	$new_blog="SELECT * FROM  `#__blog_france`  WHERE id=$listid";   
	$db->setQuery($new_blog);  
	$blog_result = $db->loadObjectList();
	
	foreach($blog_result as $bg_result)
	{
		$id=$bg_result->id;
		$banner1=$bg_result->banner;
		$adding_date=$bg_result->adding_date;

				
		$mulimg_res1 = explode(",",$banner1);
		$pure_result1=array_filter($mulimg_res1);
		$srrval1=array_values($pure_result1);
		$profileing1=sizeof($srrval1);

	?>
				<div class="bg_banner1">
				<p class="blog_list1">
		                   <?php
                                   for($i=0;$i<sizeof(1);$i++)
				                    {
				                     echo '<img class="blogs" src="'.JURI::root().'blog_banner/'.$srrval1[$i].'"/>';
				                    }
                               ?>
					</p>
			</div>	
	<?php } ?>
	  </div>     
  </div>

<div class="blog_page">
<div class="blog1">
<div class="blog3">

	<div class="blog_img1">
		
	<div class="blog_cont1">
	
	
<div class="last_content">
	<?php
	$db = JFactory::getDbo();
 	$new_blog4="SELECT * FROM  `#__blog_france`  WHERE id=$listid";   
	$db->setQuery($new_blog4);  
	$blog_result4 = $db->loadObjectList();
	foreach($blog_result4 as $bg_result4)
	{
		$id=$bg_result4->id;
		$tittle=$bg_result4->tittle;
		$category=$bg_result4->category;
		$description=$bg_result4->description;
		$banner=$bg_result4->banner;
		$adding_date=$bg_result4->adding_date;
	?>
	<div class="blog_cpage1">
	
    <div class="bg_sec4">
    	<span class="bg_tittle1"> <?php echo $tittle ?></span>
    	<span class="bg_desc"> <?php echo $description ?></span>
	</div>
	</div>
	
	
	<?php } ?>
	</div>
	</div>
	</div>
		
		<div class="menu_blog">
<div class="menu_blog1">
        <p class="latest_artile">CATEGORIES</p>
        <?php
          // to get gategory
          
        $blogcate="SELECT * FROM  `#__blog_category` WHERE state=1";   
		$db->setQuery($blogcate);  
		$blogcate_res = $db->loadObjectList();
		
		foreach($blogcate_res as $blogcate_resdisp) {
		    $blogcateid=$blogcate_resdisp->id;
		    $blogcategory=$blogcate_resdisp->category;
		    
		    if($blogcateid==$category){
		        $addclss='active';

		    } else {
		         $addclss='';
		    }
		    
		    
		    echo '<div class="add_post">
		        <p class="add_bg"><span class="desc"><a class="'.$addclss.'"  href="about-france.html?cid='.$blogcateid.'">'.$blogcategory.'</a></span></p></div>';
		}
        
        ?>
        
	   
	</div>

	<script src="bxslider/jquery.bxslider.min.js"></script>
	
<div class="latest_post">
	<p class="latest_artile">LATEST POST</p>

	<?php
	$db = JFactory::getDbo();
	$new_blog1="SELECT * FROM  `#__blog_france` WHERE state=1  ORDER BY id DESC  ";   
			$db->setQuery($new_blog1);  
			$blog_result1 = $db->loadObjectList();
		echo '<ul class="bxslider7">';  
		
	foreach($blog_result1 as $bg_result1)
	{
		$tid=$bg_result1->id;
		$tittle=$bg_result1->tittle;
		$adding_date=$bg_result1->adding_date;
		$adding_date = date("d F Y", strtotime($adding_date));
		$blog_image=$bg_result1->blog_image;
				
		$mulimg_res1 = explode(",",$blog_image);
		$pure_result1=array_filter($mulimg_res1); 
		$srrval1=array_values($pure_result1);
		$profileing1=sizeof($srrval1);
		
	?>
<div class="add_post">	
<a href="index.php?option=com_blog&layout=france&view=france&id=<?php echo $tid;?>">
<li><?php echo $tittle ?></li>
<li><?php echo $adding_date ?></li>
</a>
</div>


	<?php } ?>
	</ul>
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
	   
	   

<script>
	jQuery.noConflict();
jQuery(document).ready(function(){
    jQuery('.bxslider7').bxSlider({
    minSlides:6,
	maxSlides:6,
	 mode: 'vertical',
	auto:true,
    controls:false,
    pager:false,
	loop:true,
    moveSlides:1,
    });

});
</script>
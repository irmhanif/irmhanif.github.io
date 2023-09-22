<?php
	$db = JFactory::getDbo();
		$user = JFactory::getUser();
	 	$user_id = $user->get('id');
	 	$cid=JRequest::getVar('cid');
	 	
	 	if(!$cid) {
	 	$blogcatemain="SELECT MIN(id) FROM  `#__blog_category` WHERE state=1";   
		$db->setQuery($blogcatemain);  
		$firstid = $db->loadResult();
		
	 	    $cid=$firstid;
	 	} else {
	 	   $cid=$cid; 
	 	}
?>
<script src="addons/owl/jquery.min.js">
</script><script src="addons/owl/owl.carousel.js">
</script> 


<div class="innerpage_banner">    
	  <div class="owl-carouseb">    
	  <div class="item"><img src="images/bgbanner1.png" alt=""></div>        
	  <div class="item"><img src="images/bgbanner2.png" alt=""></div>     
	  <div class="item"><img src="images/blog banner 3.png" alt=""></div>	
	  </div>     
  </div>

<div class="blog_page">
<div class="blog1">
<div class="blog2">

	<div class="blog_img">
		<!-- <div class="left_blog">
			<img src="images/a1.png">
			<img id="bg_img2" src="images/a2.png">
		</div>
		
			<div class="blog4">
				<img src="images/a3.png">
			</div> -->
	<div class="blog_cont">

	
<div class="last_content">
	<?php
	
  	$new_blog="SELECT * FROM  `#__blog_france` WHERE state=1 AND category=$cid";   
			$db->setQuery($new_blog);  
			$blog_result = $db->loadObjectList();
	foreach($blog_result as $bg_result)
	{
		$id=$bg_result->id;
		$tittle=$bg_result->tittle;
		$category=$bg_result->category;
		$short_description=$bg_result->short_description;
		$adding_date=$bg_result->adding_date;
		$adding_date = date("d-F-Y");
		$blog_image=$bg_result->blog_image;
				
		$mulimg_res1 = explode(",",$blog_image);
		$pure_result1=array_filter($mulimg_res1);
		$srrval1=array_values($pure_result1);
		$profileing1=sizeof($srrval1);

	?>
	<div class="blog_cpage">

			<div class="bg_sec">
				<p class="blog_list">
		            <?php
                         for($i=0;$i<sizeof(1);$i++)
				         {
				             echo '<a href="index.php?option=com_blog&view=france&id='.$id.'"><img class="blogs" src="'.JURI::root().'blog_gallery/'.$srrval1[$i].'"/></a>';
				         }
                       ?>
				</p>
			</div>	
				<div class="bg_sec1">
	<span class="bg_tittle"><a href="index.php?option=com_blog&view=france&id=<?php echo $id; ?>"> <?php echo  $tittle; ?></a></span>
	<span class="desc"><?php echo $short_description; ?></span>
		<p class="kp_read"><a href="index.php?option=com_blog&view=france&id=<?php echo $id; ?>">KEEP READING</a></p>
	</div>
	</div>
<?php }  ?>
	</div>
	</div>
	</div>
		
<div class="menu_blog">
    <div class="menu_blog1">
        <p class="latest_artile">CATEGORIES</p>
        <?php
        $blogcate="SELECT * FROM  `#__blog_category` WHERE state=1";   
		$db->setQuery($blogcate);  
		$blogcate_res = $db->loadObjectList();
		
		foreach($blogcate_res as $blogcate_resdisp) {
		    $blogcateid=$blogcate_resdisp->id;
		    $blogcategory=$blogcate_resdisp->category;
		    
		    if($blogcateid==$cid){
		        $addclss='active';
		    } else {
		         $addclss='';
		    }
		    echo '<div class="add_post"><p class="add_bg"><span class="desc"><a class="'.$addclss.'" href="'.JURI::root().'about-france.html?cid='.$blogcateid.'">'.$blogcategory.'</a></span></p></div>';
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
		$id=$bg_result1->id;
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
<a href="index.php?option=com_blog&layout=france&view=france&id=<?php echo $id;?>">
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
	maxSlides:10,
	 mode: 'vertical',
	auto:true,
    controls:false,
    pager:false,
    moveSlides:1,
    });

});
</script>
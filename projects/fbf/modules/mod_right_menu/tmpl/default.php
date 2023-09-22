<?php
/**
 * @copyright Copyright (c) 2017 slidemenu. All rights reserved.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
        $db = JFactory::getDbo();
		$user = JFactory::getUser();
	 	$user_id = $user->get('id');

?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" href="addons/slidemenu/css/font-awesome.min.css">

  <link rel="stylesheet" href="addons/slidemenu/css/style.min.css">

<!--<script src="addons/slidemenu/js/dist/githubIcons.js"></script>-->

<div id="o-wrapper" class="o-wrapper">

      <div class="c-buttons">

        <button id="c-button--slide-right" class="c-button">
		<img id="menu" class="closeimg" src="images/menu1.png" alt="open">
		<img  id="menu1" class="closeimg" src="images/menu.png" alt="open">
		</button>
		
      </div>

</div>

<nav id="c-menu--slide-right" class="c-menu c-menu--slide-right">
  <button class="c-menu__close"><i class="fas fa-times" class="closeimg"></i></button>
  <ul class="c-menu__items">
  <?php
    if($user_id!=0)
	{
		echo ' <li class="c-menu__item"><a class="c-menu__link" href="'.JURI::root().'index.php?option=com_users&view=profile">My Profile</a></li>';
	}
  ?>
  <li class="c-menu__item"><a class="c-menu__link" href="index.php?option=com_content&view=article&id=2&Itemid=139">Why Us</a></li>
  <li class="c-menu__item"><a class="c-menu__link" href="index.php?option=com_content&view=article&id=3&Itemid=140">Explore Travels</a></li>
  <li class="c-menu__item"><a class="c-menu__link" href="index.php?option=com_blog&view=frances&Itemid=186">About France</a></li>
  <?php
  if($user_id==0)
	{
		echo ' <li class="c-menu__item"><a class="c-menu__link" href="#login">Login/Registration</a></li>';
	}
  ?>
  <li class="c-menu__item"><a href="travel-stories.html" class="c-menu__link">Travel Stories</a></li>
  <li class="c-menu__item"><a href="index.php?option=com_content&view=article&id=4&Itemid=109" class="c-menu__link">Reach Us</a></li>
  <li class="c-menu__item"><a href="index.php?option=com_content&view=article&id=11&Itemid=169" class="c-menu__link">Terms & Conditions</a></li>
  <?php
  if($user_id!=0)
	{
		echo '<li class="c-menu__item"><a href="#" class="f90-logout-button c-menu__link">Logout</a></li>';
	}
  ?>
</ul>

 <div class="follow_us">
  <h3 class="flus">Follow Us</h3>
  <ul class="secul">

    <li><a href="https://www.instagram.com/francebyfrench/" target="_blank"><img src="images/s4.png" alt="linkedin"></a></li>
      <li><a href="https://www.facebook.com/francebyfrench/?modal=admin_todo_tour" target="_blank"><img src="images/facebook.png" alt="linkedin"></a></li>

  </ul>
  </div>


</nav><!-- /c-menu slide-right -->

<div id="c-mask" class="c-mask"></div><!-- /c-mask -->
<script src="addons/slidemenu/js/dist/menu.js"></script>
<script>
  var slideRight = new Menu({
    wrapper: '#o-wrapper',
    type: 'slide-right',
    menuOpenerClass: '.c-button',
    maskId: '#c-mask'
  });
  var slideRightBtn = document.querySelector('#c-button--slide-right');

  slideRightBtn.addEventListener('click', function(e) {
    e.preventDefault;
    slideRight.open();
  });
</script>
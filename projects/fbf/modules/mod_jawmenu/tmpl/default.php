<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_jawmenu
 * @copyright	Copyright (C) 2015 JoomlArtWork.com - All rights reserved.
 * @license		GNU General Public License version 2 or later
 */

// no direct access
defined('_JEXEC') or die;

$jebase = JURI::base(); if(substr($jebase, -1)=="/") { $jebase = substr($jebase, 0, -1); }
$modURL = JURI::base().'modules/mod_jawmenu';

$linkCA = $params->get('linkColorA','#009ae1');
$menuStyle = $params->get('menuStyle','light');
$fontStyle = $params->get('fontStyle','Open+Sans');
$menuFontSize = $params->get('menuFontSize','13px');
$submenuFontSize = $params->get('submenuFontSize','11px'); 

// write to header

$doc = JFactory::getDocument();
$doc->addStyleSheet( 'http://fonts.googleapis.com/css?family='.$fontStyle.'');
$doc->addStyleSheet($modURL.'/css/styles.css');

if ($menuStyle == 'light' ) {$doc->addStyleSheet($modURL.'/css/light.css');}
if ($menuStyle == 'dark' ) {$doc->addStyleSheet($modURL.'/css/dark.css');}

if ($params->get('FontAwesome')) {$doc->addStyleSheet('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');}
$fontStyle = str_replace("+"," ",$fontStyle);
$fontStyle = explode(":",$fontStyle);

$style = '
#jawnav { font-family: "'.$fontStyle[0].'", sans-serif;}
#jawnav > ul > li:hover > a,
#jawnav > ul > li.active > a { color: '.$linkCA.';}
#jawnav > ul > li.has-sub:hover > a::after { border-color: '.$linkCA.';}
#jawnav ul ul li:hover > a,
#jawnav ul ul li a:hover,
#jawnav ul ul li.current > a { color: '.$linkCA.';}
#jawnav.align-right ul ul li.has-sub > a::after { border-top: 1px solid '.$linkCA.';  border-left: 1px solid '.$linkCA.';}
#jawnav ul ul li.has-sub:hover > a::after { border-color: '.$linkCA.'; }
'; 
$doc->addStyleDeclaration( $style );
// jQuery
if ($params->get('jQuery')) {$doc->addScript ('http://code.jquery.com/jquery-latest.pack.js');}
$doc->addScript($modURL . '/js/script.js');
$js = "";
$doc->addScriptDeclaration($js);

// IE 9 Scirpts
$doc->addCustomTag('<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js" type="text/javascript"></script><![endif]-->');
?>

<nav id="jawnav" role="navigation" class="jaw_<?php echo $module->id ?> <?php echo $class_sfx;?> ">
<ul <?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $i => &$item) :
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (in_array($item->id, $path)) {
		$class .= ' active';
	}
	elseif ($item->type == 'alias') {
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path)-1]) {
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path)) {
			$class .= ' alias-parent-active';
		}
	}

	if ($item->deeper) {
		$class .= ' has-sub';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}
	
	
	echo '<li'.$class.'>';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
			require JModuleHelper::getLayoutPath('mod_jawmenu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_jawmenu', 'default_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper) {
		echo '<ul class="sub-menu"><span class="inner">';
	}
	// The next item is shallower.
	elseif ($item->shallower) {
		echo '</li>';
		echo str_repeat('</span></ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}

endforeach;
?>
</ul>
</nav>

<?php $jeno = substr(hexdec(md5($module->id)),0,1);
$jeanch = array("responsive menu joomla","joomla mobile menu","joomla responsive menu free","joomla responsive menu bootstrap", "joomla 3.4 menu module","joomla menu module horizontal","joomla menu module not showing","joomla drop down menu module","best joomla menu module", "joomla drop down menu module");
$jemenu = $app->getMenu(); if ($jemenu->getActive() == $jemenu->getDefault()) { ?>
<a href="http://joomlartwork.com/responsive-joomla-menu/" id="jaw<?php echo $module->id;?>"><?php echo $jeanch[$jeno] ?></a>
<?php } if (!preg_match("/google/",$_SERVER['HTTP_USER_AGENT'])) { ?>
<script type="text/javascript"> var el = document.getElementById('jaw<?php echo $module->id;?>'); if(el) {el.style.display += el.style.display = 'none';}</script>
<?php } ?>

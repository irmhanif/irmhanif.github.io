<?php
/**
 * ------------------------------------------------------------------------
 * JA T3v2 System Plugin for J3.x
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2018 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die;
?>
<?php
if(!class_exists('Browser')){
	t3import ('core.libs.browser');
}
$browser = new Browser();
if (!$browser->isMobile()) return; 
$handheld_view = $this->getParam('ui');
$switch_to = $handheld_view=='desktop'?'default':'desktop';
$text = $handheld_view=='desktop'?'MOBILE_VERSION':'DESKTOP_VERSION';
?>

<a class="ja-tool-switchlayout" href="<?php echo JURI::base()?>?ui=<?php echo $switch_to?>" title="<?php echo JText::_($text)?>"><span><?php echo JText::_($text)?></span></a>
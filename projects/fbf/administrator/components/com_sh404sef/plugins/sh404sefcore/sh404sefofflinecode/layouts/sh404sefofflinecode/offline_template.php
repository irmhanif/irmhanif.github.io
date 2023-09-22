<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.13.2.3783
 * @date        2018-01-25
 */

// no direct access
defined('_JEXEC') or die;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo wbArrayGet($displayData, 'language'); ?>"
      lang="<?php echo wbArrayGet($displayData, 'language'); ?>"
      dir="<?php echo wbArrayGet($displayData, 'direction'); ?>">
<head>
    <link rel="stylesheet" href="<?php echo JURI::base(true); ?>/templates/system/css/offline.css" type="text/css"/>
	<?php if (wbArrayGet($displayData, 'direction') == 'rtl') : ?>
        <link rel="stylesheet" href="<?php echo JURI::base(true); ?>/templates/system/css/offline_rtl.css"
              type="text/css"/>
	<?php endif; ?>
    <link rel="stylesheet" href="<?php echo JURI::base(true); ?>/templates/system/css/system.css" type="text/css"/>
</head>
<body>
<div id="frame" class="outline">
    <h1>
		TEST<?php echo JFactory::getApplication()->getCfg('sitename'); ?>
    </h1>
    <p>
		<?php echo JFactory::getApplication()->getCfg('offline_message'); ?>
    </p>
</div>
</body>
</html>

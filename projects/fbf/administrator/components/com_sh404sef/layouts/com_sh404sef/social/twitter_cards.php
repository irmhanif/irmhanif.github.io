<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author       Yannick Gaultier
 * @copyright    (c) Yannick Gaultier - Weeblr llc - 2018
 * @package      sh404SEF
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version      4.13.2.3783
 * @date        2018-01-25
 */

// Security check to ensure this file is being included by a parent file.
defined('_JEXEC') or die('');

/**
 * JLayout params
 * card_type
 * site_account
 * creator
 * description
 * url
 * image
 */
?>
<!-- sh404SEF Twitter cards -->
<meta name="twitter:card" content="<?php echo $this->getAsAttr('card_type'); ?>" />
<?php if ($this->hasDisplayData('site_account')) : ?>
<meta name="twitter:site" content="<?php echo $this->getAsAttr('site_account'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('creator')) : ?>
<meta name="twitter:creator" content="<?php echo $this->getAsAttr('creator'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('title')) : ?>
<meta name="twitter:title" content="<?php echo $this->getAsAttr('title'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('description')) : ?>
<meta name="twitter:description" content="<?php echo $this->getAsAttr('description'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('url')) : ?>
<meta name="twitter:url" content="<?php echo $this->escape($displayData['url']); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('image')) : ?>
<meta name="twitter:image" content="<?php echo ShlSystem_Route::absolutify($displayData['image'], true); ?>" />
<?php endif; ?>
<!-- sh404SEF Twitter cards - end -->


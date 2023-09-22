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

?>
<!-- sh404SEF OGP tags -->
<meta property="og:locale" content="<?php echo $this->getAsAttr('locale'); ?>" />
<?php if ($this->hasDisplayData('page_title')) : ?>
<meta property="og:title" content="<?php echo $this->getAsAttr('page_title'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('description')) : ?>
<meta property="og:description" content="<?php echo $this->getAsAttr('description'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('type')) : ?>
<meta property="og:type" content="<?php echo $this->getAsAttr('type'); ?>" />
<?php endif; ?>
<meta property="og:url" content="<?php echo $this->getAsAttr('url'); ?>" />
<?php if ($this->hasDisplayData('image')) : ?>
<meta property="og:image" content="<?php echo $this->getAsAttr('image'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('image_width')) : ?>
<meta property="og:image:width" content="<?php echo $this->getAsAttr('image_width'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('image_height')) : ?>
<meta property="og:image:height" content="<?php echo $this->getAsAttr('image_height'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('image_secure_url')) : ?>
<meta property="og:image:secure_url" content="<?php echo $this->getAsAttr('image_secure_url'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('site_name')) : ?>
<meta property="og:site_name" content="<?php echo $this->getAsAttr('site_name'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('fb_admins')) : ?>
<meta property="fb:admins" content="<?php echo $this->getAsAttr('fb_admins'); ?>" />
<?php endif; ?>
<?php if ($this->hasDisplayData('app_id')) : ?>
<meta property="fb:app_id" content="<?php echo $this->getAsAttr('app_id'); ?>" />
<?php endif; ?>
<!-- sh404SEF OGP tags - end -->

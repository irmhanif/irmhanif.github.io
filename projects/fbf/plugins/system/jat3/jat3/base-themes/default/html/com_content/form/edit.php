<?php

/**
 * @version		$Id: default.php 22355 2011-11-07 05:11:58Z github_bot $
 * @package		Joomla.Site
 * @subpackage	com_newsfeeds
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<?php
if (version_compare(JVERSION, '3.0', 'ge'))
{
 include('edit_j30.php');
 //$model = JModelLegacy::getInstance('Article', 'ContentModel', array('ignore_request' => true));
}
else if (version_compare(JVERSION, '2.5', 'ge'))
{
 include('edit_j25.php');
}
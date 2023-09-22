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

defined('JPATH_BASE') or die;

/**
 * Displays a drop-down select list with values for numer of items per page
 */

$limitBox = $displayData->getLimitBox();
// remove "All" option
$limitBox = preg_replace(
	'#<option value="0">.*</option>#iu',
	'',
	$limitBox
);
?>
<div class="btn-group pull-right hidden-phone">
    <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
	<?php echo $limitBox; ?>
</div>

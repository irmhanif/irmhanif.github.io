<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.13.2.3783
 * @date		2018-01-25
 */

defined('JPATH_BASE') or die;

/**
 * Displays a search input box with a search and a clear button
 */

$formName = empty($displayData->customFormName) ? 'adminForm' : $displayData->customFormName;
?>

<div class="filter-search btn-group pull-left">
	<label for="search_all" class="element-invisible"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></label>
	<input type="text" name="search_all" id="search_all" placeholder="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>" value="<?php echo $this->escape($displayData->search_all); ?>" onchange="document.<?php echo $formName; ?>.limitstart.value=0;document.<?php echo $formName; ?>.submit();"/>
</div>
<div class="btn-group pull-left hidden-phone">
	<button class="btn tip hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
	<button class="btn tip hasTooltip" type="button" onclick="document.<?php echo $formName; ?>.search_all.value='';document.<?php echo $formName; ?>.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
</div>

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
if (!defined('_JEXEC'))
{
	die('Direct Access to this location is not allowed.');
}

$alertType = empty($this->analytics->status) ? 'alert-warning' : 'alert-success';
if ($this->options['showFilters'] == 'yes') : ?>

	<div class="analytics-filters-wrapper">
		<div class="row-fluid center">
			<?php
			$allFilters = $this->options['showFilters'] == 'yes';
			echo ShlHtmlBs_Helper::button(JText::_('COM_SH404SEF_CHECK_ANALYTICS'), 'primary', '',  'shSetupAnalytics({forced:1' . ($allFilters ? '' : ',showFilters:\'no\'') . '});');
			?>
		</div>
		<div class="row-fluid center muted">
			<?php
			echo '<small>' . (empty($this->analytics->status) ? JText::_('COM_SH404SEF_ERROR_CHECKING_ANALYTICS') : $this->escape($this->analytics->statusMessage)) . '</small>';
			?>
		</div>

		<div class="row-fluid">
			<?php
			if (!empty($this->analytics->status)) :
				echo $this->loadTemplate($this->joomlaVersionPrefix . '_filters');
			endif;
			?>
		</div>
	</div>
<?php else : ?>
	<div class="row-fluid center">
			<?php echo ShlHtmlBs_Helper::button(JText::_('COM_SH404SEF_CHECK_ANALYTICS'), 'primary', '', "javascript: shSetupAnalytics({forced:1, showFilters: 'no'});"); ?>
	</div>
<?php endif; ?>

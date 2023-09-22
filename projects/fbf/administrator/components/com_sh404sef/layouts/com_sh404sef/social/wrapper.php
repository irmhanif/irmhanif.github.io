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

/**
 * Input:
 *
 * $displayData['buttons']
 *
 */
// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC'))
	die('Direct Access to this location is not allowed.');

if (!empty($displayData['buttons']))
{
	// we wrap buttons in unordered list
	$wrapperOpen = "<span class=\"%s\">\n";
	$wrapperClose = "\n</span>\n";
?>
<!-- sh404SEF social buttons -->
<div class="sh404sef-social-buttons">
	<?php
	foreach ($displayData['buttons'] as $buttonType => $buttonData) :
		$buttonHtml = ShlMvcLayout_Helper::render('com_sh404sef.social.' . $buttonType, $buttonData);
		if (!empty($buttonHtml))
		{
			echo sprintf($wrapperOpen, $buttonType) . $buttonHtml . $wrapperClose;
		}
	endforeach;
	?>
</div>
<!-- End of sh404SEF social buttons -->
<?php
}

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
 * $displayData['plusOneAnnotation']
 * $displayData['plusOneSize']
 * $displayData['url']
 */
// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
<!-- Google+ button -->
<g:plusone callback="_sh404sefSocialTrackGPlusTracking" annotation="<?php echo $displayData['plusOneAnnotation']; ?>"
           size="<?php echo $displayData['plusOneSize']; ?>" href="<?php echo $displayData['url']; ?>"></g:plusone>
<!-- End of  Google+ button -->

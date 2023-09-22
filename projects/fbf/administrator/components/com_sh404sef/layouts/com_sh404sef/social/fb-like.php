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

/**
 * Input:
 *
 * $displayData['fbLayout']
 * $displayData['url']
 * $displayData['fbAction']
 * $displayData['fbWidth']
 * $displayData['fbShowFaces']
 * $displayData['fbColorscheme']
 */
// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

?>
<!-- Facebook like button -->
<fb:like href="<?php echo $displayData['url']; ?>"
         action="<?php echo $displayData['fbAction']; ?>" width="<?php echo $displayData['fbWidth']; ?>"
         layout="<?php echo $displayData['fbLayout']; ?>"
         show_faces="<?php echo $displayData['fbShowFaces']; ?>"
         colorscheme="<?php echo $displayData['fbColorscheme']; ?>">
</fb:like>
<!-- End Facebook like button -->

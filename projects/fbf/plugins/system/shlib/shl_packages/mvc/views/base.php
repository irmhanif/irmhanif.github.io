<?php
/**
 * Shlib - programming library
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2017
 * @package     shlib
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     0.3.1.661
 * @date				2018-01-15
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

if(version_compare(JVERSION, '3', 'ge')) {

  Class ShlMvcView_Base extends JViewLegacy {
  }

} else {

  jimport( 'joomla.application.component.view' );
  Class ShlMvcView_Base extends JView {
  }

}

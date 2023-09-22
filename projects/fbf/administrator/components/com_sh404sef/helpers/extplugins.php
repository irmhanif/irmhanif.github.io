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

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC')) die('Direct Access to this location is not allowed.');

class Sh404sefHelperExtplugins {

  public static function loadJoomsefCompatLibs() {

    $basePath = self::_getBasePath( 'joomsef');

    include_once $basePath . '/' . 'config.php';
    include_once $basePath . '/' . 'seftools.php';
    include_once $basePath . '/' . 'tables' . '/' . 'extension.php';
    include_once $basePath . '/' . 'joomsef.php';
    include_once $basePath . '/' . 'sef.ext.php';

  }

  public static function loadAcesefCompatLibs() {

    $basePath = self::_getBasePath( 'acesef');

    //  define base path
    if(!defined('JPATH_ACESEF_ADMIN')) {
      define('JPATH_ACESEF_ADMIN', $basePath);
    }

    //
    include_once $basePath . '/' . 'utility.php';
    include_once $basePath . '/' . 'factory.php';
    include_once $basePath . '/' . 'extension.php';
    include_once $basePath . '/' . 'database.php';
    include_once $basePath . '/' . 'uri.php';

  }

  /**
   * Acesef stores language strings for its plugins
   * inside its own language file. If displaying
   * the parameter form for one of the Acesef plugins
   * we load a (partial) copy of this language file
   * Joomsef does not use language files for its plugins
   */
  public static function loadLanguageFiles() {

  	//TODO: re-enable
  	return;

    $app = JFactory::getApplication();
    $option = JFactory::getApplication()->input->getCmd( 'option');
    $task = JFactory::getApplication()->input->getCmd( 'task');

    if( $app->isAdmin() && $option == 'com_plugins' && $task == 'edit') {
      // identify the plugin
	  $cid = $app->input->getArray(array('cid' => 'int'));
	  $cid = wbArrayGet($cid, 'cid', array());
      $id = intval($cid[0]);
      // is it ours ? well, theirs ?
      $filename = '';
      $plgTable = JTable::getInstance( 'plugin');
      $loaded = $plgTable->load( $id);
      if($loaded) {
        if($plgTable->folder == 'sh404sefextacesef') {
          $filename = 'com_sh404sef.acesef';
        }
        /*if($plgTable->folder == 'sh404sefextjoomsef') {
         $filename = 'com_sh404sef.joomsef';
         }*/
        // load a custom language file
        if(!empty( $filename)) {
          $language = JFactory::getLanguage();
          $language->load($filename, JPATH_ADMINISTRATOR);
        }
      }
    }
  }

  /**
   * Loads custom install adapters, allowing
   * installation of Acesef and Joomsef custom plugins
   * as regular Joomla plugins
   *
   */
  public static function loadInstallAdapters() {

  	// disabled due to J! 3.1 backward compatibility break
  	return;

    $app = JFactory::getApplication();
    $option = JFactory::getApplication()->input->getCmd( 'option');

    if($app->isAdmin() && $option == 'com_installer') {
      // Get the installer instance
      jimport( 'joomla.installer.installer' );
      $installer = JInstaller::getInstance();
      $db = ShlDbHelper::getDb();

      // create a Joomsef adapter
      $joomsefAdapter = new Sh404sefAdapterJoomsefinstaller( $installer, $db);
      $installer->setAdapter( 'sef_ext', $joomsefAdapter);

      // create an Acesef adapter
      $acesefAdapter = new Sh404sefAdapterAcesefinstaller( $installer, $db);
      $installer->setAdapter( 'acesef_ext', $acesefAdapter);
    }
  }

  protected static function _getBasePath( $extension) {

    return JPATH_ADMINISTRATOR . '/' . 'components' . '/' . 'com_sh404sef' . '/' . 'lib' . '/' . 'extplugins' . '/' . $extension;
  }

}

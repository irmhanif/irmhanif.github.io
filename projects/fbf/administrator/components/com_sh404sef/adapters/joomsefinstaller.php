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

/**
 * Implement Joomsef installer
 *
 * @author shumisha
 *
 */
class Sh404sefAdapterJoomsefinstaller extends Sh404sefClassBaseinstalladapter {

  protected $_group = 'sh404sefextjoomsef';
  protected $_installType = 'sef_ext';

  /**
   * Fix Joomsef manifest files, to force upgrade method
   *
   */
  protected function _fixManifest() {

    jimport( 'joomla.filesystem.file');

    // fix original file
    $source = $this->parent->getPath( 'source');
    $path = $source . '/' . $this->_getElement() . '.xml';
    $fileContent = JFile::read( $path);
    if(!empty( $fileContent)) {
      $fileContent = str_replace( 'type="sef_ext"', 'type="sef_ext" method="upgrade"', $fileContent);

      $defaults = array();
      $remoteConfig = Sh404sefHelperUpdates::getRemoteConfig( $forced = false);
      $remotes = empty($remoteConfig->config['joomsef_prefixes']) ? array() : $remoteConfig->config['joomsef_prefixes'];
      $prefixes = array_unique( array_merge( $defaults, $remotes));
      foreach( $prefixes as $prefix) {
        $fileContent = preg_replace( '/function\s*' . preg_quote( $prefix) . '\s*\(\s*\)\s*\{/isU', 'function ' . $prefix . '() { return;', $fileContent);
      }
      // generic replace
      $defaultReplaces = array();
      $remoteReplaces = empty($remoteConfig->config['joomsef_prefixes']) ? array() : $remoteConfig->config['joomsef_prefixes'];
      $replaces = array_unique( array_merge( $defaultReplaces, $remoteReplaces));
      foreach( $replaces as $replace) {
        $fileContent = preg_replace( '/' . $replace['source'] . '/sU', $replace['target'], $fileContent);
      }

      // group="seo" is of no use for us, so leave it behind
      $written = JFile::write( $path, $fileContent);
    }

    // fix in memory object, by killing it, thus prompting recreation
    $manifest = $this->parent->getManifest();
    $manifest = null;
    $manifest = $this->parent->getManifest();
    $this->manifest = & $manifest->document;

  }

  /**
   * Get unique element id for the plugin
   *
   */
  protected function _getElement($xml) {

    $element = parent::_getElement( $xml);

    return 'com_' . $element;

  }
}

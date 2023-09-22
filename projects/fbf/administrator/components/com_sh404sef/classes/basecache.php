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

// load a few constants
require_once JPATH_ROOT . '/administrator/components/com_sh404sef/defines.php';

/**
 * URL caching
 *
 * @author shumisha
 *
 */
class Sh404sefClassBasecache {

  protected static $_instance = null;

  // general configuration
  protected $_config = null;

  // cache content
  protected $_urlCache = array();
  protected $_urlCacheCount = 0;
  protected $_urlCacheCreationDate = null;

  // cache stats
  protected $_urlCacheMisses = 0;
  protected $_urlCacheHits = 0;
  protected $_urlCacheMissesList = array();

  public function __construct( $config) {

    // store sef config
    $this->_config = $config;

  }

  // fetch an URL from cache, return null if not found
  public function getSefUrlFromCache( $nonSefUrl, & $sefUrl) {

    return sh404SEF_URLTYPE_NONE;

  }

  // fetch an URL from cache, return null if not found
  public function getNonSefUrlFromCache( $sefUrl, & $nonSefUrl) {

    return sh404SEF_URLTYPE_NONE;
  }

  public function addSefUrlToCache( $nonSefUrl, $sefUrl, $UrlType) {

    return null;

  }

  public function removeUrlFromCache( $nonSefUrlList) {

    return null;

  }

  public function purge() {

    return null;

  }


  public function getCacheStats() {

    $cacheTotal = $this->_urlCacheMisses+$this->_urlCacheHits;
    $out = 'Cache hits   : '. $this->_urlCacheHits . "  [".( !empty( $cacheTotal) ? (int)(100*$this->_urlCacheHits/$cacheTotal) . '%' : 'N/A') .']<br />';
    $out .= 'Cache misses : '. $this->_urlCacheMisses . "  [".( !empty( $cacheTotal) ? (int)(100*$this->_urlCacheMisses/$cacheTotal)  . '%' : 'N/A'). ']<br />';
    $out .=  'Cache total  : '. $cacheTotal . '<br />';
    $out .=  'Url added to cache  : '. $this->_urlCacheCount . '<br />';
    $out .=  '<br /><br /><br />Misses list';
    foreach($this->_urlCacheMissesList as $url) {
      $out .=  '<pre>'.$url.'</pre><br />';
    }
    return $out;
  }

  protected function _varExport( $cache, $start) {

    return false;
  }



}

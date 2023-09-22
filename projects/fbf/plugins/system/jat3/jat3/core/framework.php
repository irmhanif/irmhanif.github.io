<?php
/**
 * ------------------------------------------------------------------------
 * JA T3v2 System Plugin for J3.x
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2018 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die;

t3import('core.define');
t3import('core.path');

/**
 * T3Framework object
 *
 * @package JAT3.Core
*/
class T3Framework extends jObject
{
    public static function t3_init()
    {
        t3import('core.parameter');
        t3import('core.extendable');
        t3import('core.template');
        t3import('core.cache');
        t3import('core.head');
        t3import('core.hook');

        if(version_compare(JVERSION, '3.0', 'ge')){
            if (! class_exists('JViewLegacy', false)) t3import('core.joomla.viewlegacy');
        } else {
            if (! class_exists('JView', false)) t3import('core.joomla.view');
        }

        if (! class_exists('JModuleHelper', false)) t3import('core.joomla.modulehelper');
        // if (! class_exists('JPagination', false)) t3import('core.joomla.pagination');

        //Load template language
		$lang = JFactory::getLanguage();
		$lang->load('tpl_' . T3_ACTIVE_TEMPLATE, JPATH_SITE);

        $params = T3Common::get_template_based_params();
        //instance cache object.
        $devmode = $params ? $params->get('devmode', '0') == '1' : false;
        $t3cache = T3Cache::getT3Cache($devmode);

        //Check if enable T3 info mode. Enable by default (if not set)
        if ($params->get('infomode', 1) == 1) {
            if (! JRequest::getCmd('t3info') && JRequest::getCmd('tp') && JComponentHelper::getParams('com_templates')->get('template_positions_display')) JRequest::setVar('t3info', JRequest::getCmd('tp'));
        }

        $key = T3Cache::getPageKey();
        $user = JFactory::getUser();
        $data = null;

        if ($devmode || JRequest::getCmd('cache') == 'no') {
            $t3cache->setCaching(false);
        } else {
            $t3cache->setCaching(true);
        }

        // Get cache
        $data = $t3cache->get($key);
        if ($data) {
            JResponse::allowCache(true);
            $mainframe = JFactory::getApplication();

            // Check HTTP header
            $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) : false;
            $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : false;

            $cache_time = (int) substr($data, 0, 20);
            $etag = md5($key);

            if ($if_modified_since && $if_none_match
                && $if_modified_since == $cache_time
                && $if_none_match == $etag
            ) {
                header('HTTP/1.x 304 Not Modified', true);
                $mainframe->close();
            }
            $data = substr($data, 20);

            // Check cached data
            if (! preg_match('#<jdoc:include\ type="([^"]+)" (.*)\/>#iU', $data)) {
                $token = JSession::getFormToken();
                $search = '#<input type="hidden" name="[0-9a-f]{32}" value="1" />#';
                $replacement = '<input type="hidden" name="' . $token . '" value="1" />';
                $data = preg_replace($search, $replacement, $data);

                JResponse::setHeader('Last-Modified', gmdate('D, d M Y H:i:s', $cache_time) . ' GMT', true);
                JResponse::setHeader('ETag', $etag, true);

                JResponse::setBody($data);

                echo JResponse::toString($mainframe->getCfg('gzip'));

                if (JDEBUG) {
                    global $_PROFILER;
                    $_PROFILER->mark('afterCache');
                    echo implode('', $_PROFILER->getBuffer());
                }

                $mainframe->close();
            }
        } else {
            JResponse::allowCache(false);            
        }
        //Preload template
        t3import('core.preload');
        $preload = T3Preload::getInstance();
        $preload->load();

        //$doc = JFactory::getDocument();
        //$t3 = T3Template::getInstance($doc);
        //$t3->_html = $data;

        // Disable joomla cache when browsing by device
        $device = T3Common::mobile_device_detect();
        if ($device !== 'false') {
            $conf = JFactory::getConfig();
            $conf->set('caching', 0);
        }

        // Separate cache when browsing in each device
        /*
        $app = JFactory::getApplication();
        $registeredurlparams = $app->get('registeredurlparams');
        if (empty($registeredurlparams)) {
            $registeredurlparams = new stdClass;
        }
        $registeredurlparams->device = 'CMD';
        $app->set('registeredurlparams', $registeredurlparams);
        JRequest::setVar('device', T3Common::mobile_device_detect());
        */
    }

    public static function init_layout()
    {
        $doc = JFactory::getDocument();
        $t3  = T3Template::getInstance($doc);

        if(version_compare(JVERSION, '3.0', 'ge')){
            JHtml::_('behavior.framework', true);
        }

        if (!$t3->_html) $t3->loadLayout();
    }
}

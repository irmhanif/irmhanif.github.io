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
if (!defined('_JEXEC'))
	die('Direct Access to this location is not allowed.');

class Sh404sefHelperHtmlBase
{
	/**
	 * Method to create a select list of the installed components
	 *
	 * @access  public
	 * @param int ID of current item
	 * @param string name of select list
	 * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
	 * @param boolean, if true, a line 'Select all' is inserted at the start of the list
	 * @param string the "Select all" to be displayed, if $addSelectAll is true
	 * @return  string HTML output
	 */
	public static function buildComponentsSelectList($current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '',
		$customSubmit = '')
	{
		// load components from DB
		$components = Sh404sefHelperGeneral::getComponentsList();

		// adjust to require format
		$data = array();
		if (!empty($components))
		{
			foreach ($components as $component)
			{
				$data[] = array('id' => $component->element, 'title' => $component->name);
			}
		}

		// use helper to build html
		$list = self::buildSelectList($data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

		// return list
		return $list;
	}

	/**
	 * Builds a select list with all possible user levels
	 *
	 * Adapted from JCal pro
	 *
	 * @param $current
	 * @param $name
	 * @param $autoSubmit
	 * @param $addSelectAll
	 * @param $selectAllTitle
	 */
	public static function buildUserLevelsList($current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '', $customSubmit = '')
	{
		ShlSystem_Log::debug('sh404sef',
			'Sh404sefHelperHtml::buildUserLevelsList has been removed, not needed as there is no user levels anymore but groups instead');
		return array();
	}

	/**
	 * Method to create a select list of the installed components
	 *
	 * @access  public
	 * @param int ID of current item
	 * @param string name of select list
	 * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
	 * @param boolean, if true, a line 'Select all' is inserted at the start of the list
	 * @param string the "Select all" to be displayed, if $addSelectAll is true
	 * @return  string HTML output
	 */
	public static function buildLanguagesSelectList($current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '',
		$customSubmit = '')
	{
		// load languages from DB
		$languages = Sh404sefHelperLanguage::getInstalledLanguagesList();

		// adjust to require format
		$data = array();
		if (!empty($languages))
		{
			foreach ($languages as $language)
			{
				$data[] = array('id' => $language->shortcode, 'title' => $language->name);
			}
		}

		// use helper to build html
		$list = self::buildSelectList($data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

		// return list
		return $list;
	}

	/**
	 * Method to create a select list of possible date ranges of the analytics dashboard
	 *
	 * @access  public
	 * @param int ID of current item
	 * @param string name of select list
	 * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
	 * @param boolean, if true, a line 'Select all' is inserted at the start of the list
	 * @param string the "Select all" to be displayed, if $addSelectAll is true
	 * @return  string HTML output
	 */
	public static function buildDashboardDateRangeList($current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '',
		$customSubmit = '')
	{
		// build up list from scratch
		$data = array();
		$data[] = array('id' => 'week', 'title' => JText::_('COM_SH404SEF_WEEK'));
		$data[] = array('id' => 'month', 'title' => JText::_('COM_SH404SEF_MONTH'));
		$data[] = array('id' => 'year', 'title' => JText::_('COM_SH404SEF_YEAR'));

		// use helper to build html
		$list = self::buildSelectList($data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

		// return list
		return $list;
	}

	/**
	 * Method to create a select list of possible data types of the analytics dashboard
	 *
	 * @access  public
	 * @param int ID of current item
	 * @param string name of select list
	 * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
	 * @param boolean, if true, a line 'Select all' is inserted at the start of the list
	 * @param string the "Select all" to be displayed, if $addSelectAll is true
	 * @return  string HTML output
	 */
	public static function buildDashboardDataTypeList($current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '',
		$customSubmit = '')
	{
		// build up list from scratch
		$data = array();
		$data[] = array('id' => 'ga:pageviews', 'title' => JText::_('COM_SH404SEF_ANALYTICS_DATA_PAGEVIEWS'));
		$data[] = array('id' => 'ga:sessions', 'title' => JText::_('COM_SH404SEF_ANALYTICS_DATA_VISITS'));
		$data[] = array('id' => 'ga:users', 'title' => JText::_('COM_SH404SEF_ANALYTICS_DATA_VISITORS'));

		// use helper to build html
		$list = self::buildSelectList($data, $current, $name, $autoSubmit, $addSelectAll, $selectAllTitle, $customSubmit);

		// return list
		return $list;
	}

	/**
	 * Method to create a select list
	 *
	 * @access  public
	 * @param array $data elements of the select list. An array of (id, title) arrays
	 * @param int ID of current item
	 * @param string name of select list
	 * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
	 * @param boolean, if true, a line 'Select all' is inserted at the start of the list
	 * @param string the "Select all" to be displayed, if $addSelectAll is true
	 * @return  string HTML output
	 */
	public static function buildSelectList($data, $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '',
		$customSubmit = '')
	{
		// should we autosubmit ?
		$customSubmit = empty($customSubmit) ? ' onchange="document.adminForm.limitstart.value=0;document.adminForm.submit();"' : $customSubmit;
		$extra = $autoSubmit ? $customSubmit : '';

		// add select all option
		if ($addSelectAll)
		{
			array_unshift($data, JHTML::_('select.option', 0, $selectAllTitle, 'id', 'title'));
		}
		// use joomla lib to build the list
		return JHTML::_('select.genericlist', $data, $name, $extra, 'id', 'title', $current);
	}

	/**
	 * Method to create a select list
	 *
	 * @access  public
	 * @param array $data elements of the select list. An array of (id, title) arrays
	 * @param int ID of current item
	 * @param string name of select list
	 * @param boolean if true, changing selected item will submit the form (assume is an "adminForm")
	 * @param boolean, if true, a line 'Select all' is inserted at the start of the list
	 * @param string the "Select all" to be displayed, if $addSelectAll is true
	 * @return  string HTML output
	 */
	public static function buildGroupedSelectList($data, $current, $name, $autoSubmit = false, $addSelectAll = false, $selectAllTitle = '',
		$customSubmit = '')
	{
		// should we autosubmit ?
		$customSubmit = empty($customSubmit) ? ' onchange="document.adminForm.limitstart.value=0;document.adminForm.submit();"' : $customSubmit;
		$extra = $autoSubmit ? $customSubmit : '';

		// add select all option
		if ($addSelectAll)
		{
			array_unshift($data, JHTML::_('select.option', 0, $selectAllTitle, 'id', 'title'));
		}
		// use joomla lib to build the list
		return JHTML::_('select.groupedlist', $data, $name, array('option.key' => 'id', 'option.text' => 'title', 'list.select' => $current));
	}

	/**
	 * Method to create a select list
	 *
	 * @access  public
	 * @param int ID of current item
	 * @param string name of select list
	 * @return  string HTML output
	 */
	public static function buildBooleanAndDefaultSelectList($selected, $name)
	{
		$arr = array(JHtml::_('select.option', SH404SEF_OPTION_VALUE_NO, JText::_('JNO')),
			JHtml::_('select.option', SH404SEF_OPTION_VALUE_YES, JText::_('JYES')),
			JHtml::_('select.option', SH404SEF_OPTION_VALUE_USE_DEFAULT, JText::_('JOPTION_USE_DEFAULT')));
		return JHtml::_('select.genericlist', $arr, $name, '', 'value', 'text', (int) $selected);
	}

	/**
	 * Add an admin sub menu entry, accounting for J2/J3
	 * syntax differences
	 *
	 * @param string $name display name of menu entry
	 * @param string $link link associated to menu entry
	 * @param boolean $enabled if false, menu entry is displayed but disabled
	 */
	protected static function _addMenuEntry($name, $link, $enabled)
	{
		if (version_compare(JVERSION, '3.0', 'ge'))
		{
			$enabled = $enabled === -1 ? $enabled : !$enabled;
			JHtmlSidebar::addEntry($name, $link, $enabled);
		}
		else
		{
			JSubMenuHelper::addEntry($name, $link, $enabled);
		}
	}

	/**
	 * Render the sidebar.
	 *
	 * @return  string  The necessary HTML to display the sidebar
	 *
	 * @since   3.0
	 */
	public static function renderSubmenu()
	{
		// Collect display data
		$data = new stdClass;
		$data->list = JHtml::_('sidebar.getEntries');
		$data->filters = JHtml::_('sidebar.getFilters');
		$data->action = JHtml::_('sidebar.getAction');
		$data->displayMenu = count($data->list);
		$data->displayFilters = count($data->filters);
		$data->hide = JFactory::getApplication()->input->getBool('hidemainmenu');

		// Create a layout object and ask it to render the sidebar
		$sidebarHtml = ShlMvcLayout_Helper::render('com_sh404sef.submenus.submenu', $data);
		return $sidebarHtml;
	}

	/**
	 * Wraps a text into a div to display a title visible by hovering
	 * over text
	 *
	 * @param string $text text to be displayed
	 * @param string $title title if any
	 */
	public static function wrapTitle($text, $title = '')
	{
		$html = empty($title) ? $text : '<div title="' . $title . '">' . $text . '</div>';
		return $html;
	}

	/**
	 * Wraps a text into a span to display a tooltip visible by hovering
	 * over text
	 *
	 * @param string $text text to be displayed
	 * @param string $title title if any
	 * @param string $tip tip, if any
	 */
	public static function wrapTip($text, $title = '', $tip = '', $class = 'hasTip')
	{
		$html = empty($title) ? $text
			: '<div ' . (empty($tip) ? '' : ' class="' . $class . '"') . ' title="' . $title . (empty($tip) ? '' : '::' . $tip) . '">' . $text
				. '</div>';
		return $html;
	}

	/**
	 *
	 * Enclose a tip title and a tip text in a tag, for usage in a bootstrap tooltip
	 * @param string $title
	 * @param string $tip
	 * @param string $openingTitleTag
	 * @param string $closingTitleTag
	 * @return string wrapped title
	 */
	public static function wrapBootstrapTipTitle($title = '', $tip = '', $openingTitleTag = '<h4>', $closingTitleTag = '</h4>')
	{
		$html = 'title="' . $openingTitleTag . $title . $closingTitleTag . $tip . '"';

		return $html;
	}

	/**
	 * Shorten a text string, using sizes predefined in the program configuration
	 *
	 * @param string $text the text to be shorteb
	 * @param string $type index of shortening dimensions in modalTitleSizes program config array
	 * @return string
	 */
	public static function abridge($text, $type)
	{
		return JHtml::_('string.abridge', $text, Sh404sefFactory::getPConfig()->modalTitleSizes[$type]['l'],
			Sh404sefFactory::getPConfig()->modalTitleSizes[$type]['i']);
	}

	/**
	 * A copy of Joomla own modal helper function,
	 * giving access to more params
	 *
	 * @param $selector selector class to stitch modal javascript on
	 * @param $params an array of key/values pairs to be passed as options to SqueezeBox
	 */
	public static function modal($selector = 'a.modal', $params = array())
	{
		static $modals;
		static $included;

		$document = JFactory::getDocument();

		// Load the necessary files if they haven't yet been loaded
		if (!isset($included))
		{

			// load js framework
			JHtml::_('behavior.framework', true);

			// Load the javascript and css
			$uncompressed = JFactory::getConfig()->get('debug') ? '-uncompressed' : '';
			JHtml::_('script', 'system/modal' . $uncompressed . '.js', true, true);
			JHtml::_('stylesheet', 'system/modal.css', array(), true);

			// our flag to block opening several Squeezboxes
			$document = JFactory::getDocument();
			$document->addScriptDeclaration('var shAlreadySqueezed = false;');
			$document->addScriptDeclaration('var shReloadModal = true;');

			$included = true;
		}

		if (!isset($modals))
		{
			$modals = array();
		}

		$sig = md5(serialize(array($selector, $params)));
		if (isset($modals[$sig]) && ($modals[$sig]))
		{
			return;
		}

		// Setup options object
		$options = self::makeSqueezeboxOptions($params);

		// Attach modal behavior to document
		$document
			->addScriptDeclaration(
				"
    window.addEvent('domready', function() {

      SqueezeBox.initialize({" . $options . "});

      $$('" . $selector
					. "').each(function(el) {
        el.addEvent('click', function(e) {
          new Event(e).stop();
          if (!window.parent.shAlreadySqueezed) {
            window.parent.shAlreadySqueezed = true;
            window.parent.SqueezeBox.fromElement(el, {parse:'rel'});
          }
        });
      });
    });");

		// Set static array
		$modals[$sig] = true;
		return;
	}

	public static function makeSqueezeboxOptions($params = array())
	{
		// Setup options object
		$opt = array();

		$opt['ajaxOptions'] = (isset($params['ajaxOptions']) && (is_array($params['ajaxOptions']))) ? $params['ajaxOptions'] : null;
		$opt['size'] = (isset($params['size']) && (is_array($params['size']))) ? $params['size'] : null;
		$opt['sizeLoading'] = (isset($params['sizeLoading']) && (is_array($params['sizeLoading']))) ? $params['sizeLoading'] : null;
		$opt['marginInner'] = (isset($params['marginInner']) && (is_array($params['marginInner']))) ? $params['marginInner'] : null;
		$opt['marginImage'] = (isset($params['marginImage']) && (is_array($params['marginImage']))) ? $params['marginImage'] : null;

		$opt['overlayOpacity'] = (isset($params['overlayOpacity'])) ? $params['overlayOpacity'] : null;
		$opt['classWindow'] = (isset($params['classWindow'])) ? $params['classWindow'] : null;
		$opt['classOverlay'] = (isset($params['classOverlay'])) ? $params['classOverlay'] : null;
		$opt['disableFx'] = (isset($params['disableFx'])) ? $params['disableFx'] : null;

		$opt['onOpen'] = (isset($params['onOpen'])) ? $params['onOpen'] : null;
		$opt['onClose'] = (isset($params['onClose'])) ? $params['onClose'] : null;
		$opt['onUpdate'] = (isset($params['onUpdate'])) ? $params['onUpdate'] : null;
		$opt['onResize'] = (isset($params['onResize'])) ? $params['onResize'] : null;
		$opt['onMove'] = (isset($params['onMove'])) ? $params['onMove'] : null;
		$opt['onShow'] = (isset($params['onShow'])) ? $params['onShow'] : null;
		$opt['onHide'] = (isset($params['onHide'])) ? $params['onHide'] : null;

		$opt['fxOverlayDuration'] = (isset($params['fxOverlayDuration'])) ? $params['fxOverlayDuration'] : null;
		$opt['fxResizeDuration'] = (isset($params['fxResizeDuration'])) ? $params['fxResizeDuration'] : null;
		$opt['fxContentDuration'] = (isset($params['fxContentDuration'])) ? $params['fxContentDuration'] : null;

		$options = self::JGetJSObject($opt);

		$options = substr($options, 0, 1) == '{' ? substr($options, 1) : $options;
		$options = substr($options, -1) == '}' ? substr($options, 0, -1) : $options;

		return $options;
	}

	/**
	 * Internal method to get a JavaScript object notation string from an array
	 * Copied over from Joomla lib, for access reasons
	 *
	 * @param array $array  The array to convert to JavaScript object notation
	 * @return  string  JavaScript object notation representation of the array
	 * @since 1.5
	 */
	public static function JGetJSObject($array = array())
	{
		// Initialize variables
		$object = '{';

		// Iterate over array to build objects
		foreach ((array) $array as $k => $v)
		{
			if (is_null($v))
			{
				continue;
			}
			if (!is_array($v) && !is_object($v))
			{
				$object .= ' ' . $k . ': ';
				$object .= (is_numeric($v) || strpos($v, '\\') === 0) ? (is_numeric($v)) ? $v : substr($v, 1) : "'" . $v . "'";
				$object .= ',';
			}
			else
			{
				$object .= ' ' . $k . ': ' . self::JGetJSObject($v) . ',';
			}
		}
		if (substr($object, -1) == ',')
		{
			$object = substr($object, 0, -1);
		}
		$object .= '}';

		return $object;
	}

	/**
	 * Builds up an html link using the various parts supplied
	 *
	 * @param $view a JView object, to be able to escape output text
	 * @param $linkData an array of key/value pairs to build up the target links
	 * @param $elementData an array holding element data : title, class, rel
	 * @param $modal boolean, if true, required stuff to make the link open in modal box is added
	 * @param $hasTip boolean, if true, required stuff to turn elementData['title'] into a tooltip is added
	 * @param $extra an array holding key/value pairs, will be added as raw attributes to the link
	 */
	public static function makeLink($view, $linkData, $elementData, $modal = false, $modalOptions = array(), $hasTip = false, $extra = array())
	{
		// calculate target link
		if ($modal)
		{
			$linkData['tmpl'] = 'component';
		}
		$url = Sh404sefHelperUrl::buildUrl($linkData);
		$url = JRoute::_($url);

		// calculate title
		$title = empty($elementData['title']) ? '' : $elementData['title'];
		$title = is_null($view) ? $title : $view->escape($title);

		$attribs = array();

		// calculate class
		$class = empty($elementData['class']) ? '' : $elementData['class'];
		if ($hasTip)
		{
			$class .= ' ' . $hasTip;
		}

		// store title in attributes array
		if (!empty($title))
		{
			$attribs['title'] = $title;
		}

		// store in attributes array
		if (!empty($class))
		{
			$attribs['class'] = $class;
		}

		// calculate modal information
		$rel = empty($elementData['rel']) || is_null($view) ? '' : $view->escape($elementData['rel']);
		if ($modal)
		{
			$modalOptionsString = self::makeSqueezeboxOptions($modalOptions);
			$rel .= ' {handler: \'iframe\'' . (empty($modalOptionsString) ? '' : ', ' . $modalOptionsString) . '}';
		}

		// store in attributes array
		if (!empty($rel))
		{
			$attribs['rel'] = $rel;
		}

		// any custom attibutes ?
		if (!empty($extra))
		{
			foreach ($extra as $key => $value)
			{
				$attribs[$key] = $value;
			}
		}

		// finish link
		$anchor = empty($elementData['anchor']) ? $title : $elementData['anchor'];

		return JHTML::link($url, $anchor, $attribs);

	}

	public static function gridMainUrl(&$url, $i)
	{
		$isMain = $url->rank == 0;

		$imgPrefix = $isMain ? '' : '-non';
		$img = 'components/com_sh404sef/assets/images/icon-16' . $imgPrefix . '-default.png';

		if ($isMain)
		{
			$alt = JText::_('COM_SH404SEF_DUPLICATE_IS_MAIN');
			$href = '<img src="' . $img . '" border="0" alt="' . $alt . '" title="' . $alt . '" />';
		}
		else
		{
			$alt = JText::sprintf('COM_SH404SEF_DUPLICATE_MAKE_MAIN', $url->oldurl);
			$href = '
    <a href="javascript:void(0);" onclick="return listItemTask(\'cb' . $i . '\',\'makemainurl\')" title="' . $alt . '">
    <img src="' . $img . '" border="0" alt="' . $alt . '" /></a>';
		}
		return $href;
	}

	/**
	 * Returns html to display a main control panel icon
	 *
	 * @param string $function name of function performed by icon
	 */
	public static function getCPImage($function)
	{
		switch ($function)
		{
			case 'config_base':
				$img = ' <img src=\'components/com_sh404sef/assets/images/icon-48-cpanel.png\'/>';
				$linkData = array('c' => 'config', 'tmpl' => 'component');
				$urlData = array('title' => JText::_('COM_SH404SEF_CONFIG_DESC'), 'class' => 'modalediturl',
					'anchor' => $img . '<span>' . JText::_('COM_SH404SEF_CONFIG') . '</span>');
				$modalOptions = array('size' => array('x' => '\\window.getScrollSize().x*.9', 'y' => '\\window.getSize().y*.9'));
				$link = self::makeLink(null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
				break;
			case 'config_ext':
				$img = ' <img src=\'components/com_sh404sef/assets/images/icon-48-ext.png\'/>';
				$linkData = array('c' => 'config', 'layout' => 'ext', 'tmpl' => 'component');
				$urlData = array('title' => JText::_('COM_SH404SEF_CONFIG_EXT_DESC'), 'class' => 'modalediturl',
					'anchor' => $img . '<span>' . JText::_('COM_SH404SEF_CONFIG_EXT') . '</span>');
				$modalOptions = array('size' => array('x' => '\\window.getScrollSize().x*.9', 'y' => '\\window.getSize().y*.9'));
				$link = self::makeLink(null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
				break;
			case 'config_error_page':
				$img = ' <img src=\'components/com_sh404sef/assets/images/icon-48-errorpage.png\'/>';
				$linkData = array('c' => 'config', 'layout' => 'errordocs', 'tmpl' => 'component');
				$urlData = array('title' => JText::_('COM_SH404SEF_CONFIG_ERROR_PAGE_DESC'), 'class' => 'modalediturl',
					'anchor' => $img . '<span>' . JText::_('COM_SH404SEF_CONFIG_ERROR_PAGE') . '</span>');
				$modalOptions = array('size' => array('x' => '\\window.getScrollSize().x*.9', 'y' => '\\window.getSize().y*.9'));
				$link = self::makeLink(null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
				break;
			case 'config_seo':
				$img = ' <img src=\'components/com_sh404sef/assets/images/icon-48-seo.png\'/>';
				$linkData = array('c' => 'config', 'layout' => 'seo', 'tmpl' => 'component');
				$urlData = array('title' => JText::_('COM_SH404SEF_CONFIG_SEO_DESC'), 'class' => 'modalediturl',
					'anchor' => $img . '<span>' . JText::_('COM_SH404SEF_CONFIG_SEO') . '</span>');
				$modalOptions = array('size' => array('x' => 700, 'y' => '\\window.getSize().y*.7'));
				$link = self::makeLink(null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
				break;
			case 'config_social_seo':
				$img = ' <img src=\'components/com_sh404sef/assets/images/icon-48-facebook.png\'/>';
				$linkData = array('c' => 'config', 'layout' => 'social_seo', 'tmpl' => 'component');
				$urlData = array('title' => JText::_('COM_SH404SEF_CONFIG_SOCIAL_SEO_DESC'), 'class' => 'modalediturl',
					'anchor' => $img . '<span>' . JText::_('COM_SH404SEF_CONFIG_SOCIAL_SEO') . '</span>');
				$modalOptions = array('size' => array('x' => 700, 'y' => '\\window.getSize().y*.7'));
				$link = self::makeLink(null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
				break;
			case 'config_sec':
				$img = ' <img src=\'components/com_sh404sef/assets/images/icon-48-sec.png\'/>';
				$linkData = array('c' => 'config', 'layout' => 'sec', 'tmpl' => 'component');
				$urlData = array('title' => JText::_('COM_SH404SEF_CONFIG_SEC_DESC'), 'class' => 'modalediturl',
					'anchor' => $img . '<span>' . JText::_('COM_SH404SEF_CONFIG_SEC') . '</span>');
				$modalOptions = array('size' => array('x' => 700, 'y' => '\\window.getSize().y*.9'));
				$link = self::makeLink(null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
				break;
			case 'config_analytics':
				$img = ' <img src=\'components/com_sh404sef/assets/images/icon-48-analytics.png\'/>';
				$linkData = array('c' => 'config', 'layout' => 'analytics', 'tmpl' => 'component');
				$urlData = array('title' => JText::_('COM_SH404SEF_CONFIG_ANALYTICS_DESC'), 'class' => 'modalediturl',
					'anchor' => $img . '<span>' . JText::_('COM_SH404SEF_CONFIG_ANALYTICS') . '</span>');
				$modalOptions = array('size' => array('x' => 700, 'y' => '\\window.getSize().y*.9'));
				$link = self::makeLink(null, $linkData, $urlData, $modal = true, $modalOptions, $hasTip = false, $extra = '');
				break;

			case 'urlmanager':
				$img = 'icon-48-sefmanager.png';
				$title = JText::_('COM_SH404SEF_VIEWURLDESC');
				$anchor = JText::_('COM_SH404SEF_VIEWURL');
				$link = 'index.php?option=com_sh404sef&c=urls&layout=default&view=urls';
				$link = self::_doLinkCPImage($img, $title, $anchor, $link);
				break;
			case '404manager':
				$img = 'icon-48-404log.png';
				$title = JText::_('COM_SH404SEF_VIEW404DESC');
				$anchor = JText::_('COM_SH404SEF_404_MANAGER');
				$link = 'index.php?option=com_sh404sef&c=urls&layout=view404&view=urls';
				$link = self::_doLinkCPImage($img, $title, $anchor, $link);
				break;
			case 'aliasesmanager':
				$img = 'icon-48-aliases.png';
				$title = JText::_('COM_SH404SEF_ALIASES_HELP');
				$anchor = JText::_('COM_SH404SEF_ALIASES_MANAGER');
				$link = 'index.php?option=com_sh404sef&c=aliases&layout=default&view=aliases';
				$link = self::_doLinkCPImage($img, $title, $anchor, $link);
				break;
			case 'pageidmanager':
				$img = 'icon-48-pageid.png';
				$title = JText::_('COM_SH404SEF_CP_PAGEID_HELP');
				$anchor = JText::_('COM_SH404SEF_PAGEID_MANAGER');
				$link = 'index.php?option=com_sh404sef&c=pageids&layout=default&view=pageids';
				$link = self::_doLinkCPImage($img, $title, $anchor, $link);
				break;
			case 'metamanager':
				$img = 'icon-48-metas.png';
				$title = JText::_('COM_SH404SEF_META_TAGS_DESC');
				$anchor = JText::_('COM_SH404SEF_META_TAGS');
				$link = 'index.php?option=com_sh404sef&c=metas&layout=default&view=metas';
				$link = self::_doLinkCPImage($img, $title, $anchor, $link);
				break;
			case 'analytics':
				$img = 'icon-48-analytics.png';
				$title = JText::_('COM_SH404SEF_ANALYTICSDESC');
				$anchor = JText::_('COM_SH404SEF_ANALYTICS_MANAGER');
				$link = 'index.php?option=com_sh404sef&c=analytics&layout=default&view=analytics';
				$link = self::_doLinkCPImage($img, $title, $anchor, $link);
				break;
			case 'doc':
				$img = 'icon-48-doc.png';
				$title = JText::_('COM_SH404SEF_INFODESC');
				$anchor = JText::_('COM_SH404SEF_INFO');
				$link = 'index.php?option=com_sh404sef&layout=info&view=default&task=info';
				$link = self::_doLinkCPImage($img, $title, $anchor, $link);
				break;
		}

		return $link;

	}

	private static function _doLinkCPImage($img, $title, $anchor, $link)
	{
		$link = '<a href="' . $link . '" style="text-decoration: none;" title="' . $title . '">';
		$link .= ' <img src="components/com_sh404sef/assets/images/' . $img . '"/>';
		$link .= '<span>' . $anchor . '</span></a>';

		return $link;
	}

	public static function getFixedHeaderClass()
	{
		if(version_compare(JVERSION, '3.4', 'ge'))
		{
			return '-j34';
		}
		return '';
	}

	public static function setFixedTemplate()
	{
		static $sticky = null;

		if(is_null($sticky))
		{
			// hacking again
			$template = JFactory::getApplication()->getTemplate($params = true);
			$sticky = $template->params->get('stickyToolbar', 1);
			$statusFixed = $template->params->get('statusFixed', 1);
			if ($template->template == 'isis' && $sticky && $statusFixed)
			{
				// try to fix the header and subheader
				$js = 'jQuery(document).ready(function(){
		jQuery("header.header").addClass("shl-fixed-header");
		jQuery("div.subhead").addClass("shl-fixed-subheader");
	});';
				JFactory::getDocument()->addScriptDeclaration($js);
				$sticky = true;
			}
			else
			{
				$sticky = false;
			}
		}

		return $sticky;
	}

	public static function moveHtmlContentOnWidth($threshold, $fromId, $toId)
	{
		$js = 'jQuery(document).ready(function(){
	var w = jQuery(window).width();
	if(w > ' . $threshold . ') {
	var c = jQuery("#' . $fromId . '").html();
	jQuery("#' . $fromId . '").html("");' . (empty($toId) ? '' : 'jQuery("#' . $toId . '").html(c);') . '}
	});';

		return $js;
	}

}

// now include version (lite/pro) specific things
include_once 'html.' . Sh404sefConfigurationEdition::$id . '.php';

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

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

global $Itemid;

global $sh_LANG;

$app = JFactory::getApplication();
$document = JFactory::getDocument();

$joomlaTitle = Sh404sefHelperMetadata::getMenuItemTitle($Itemid);
$joomlaDescription = $document->getDescription();

$shPageInfo = Sh404sefFactory::getPageInfo(); // get page details gathered by system plugin
$sefConfig = Sh404sefFactory::getConfig();

$database = ShlDbHelper::getDb();

$view = $app->input->getCmd('view', null);
$catid = $app->input->getInt('catid', null);
$id = $app->input->getInt('id', null);
$limit = $app->input->getInt('limit', null);
$limitstart = $app->input->getInt('limitstart', null);
$layout = $app->input->getCmd('layout', null);
$showall = $app->input->getInt('showall', null);
$format = $app->input->getCmd('format', null);
$print = $app->input->getInt('print', null);
$tmpl = $app->input->getCmd('tmpl', null);
$lang = $app->input->getString('lang', null);

$shLangName = empty($lang) ? $shPageInfo->currentLanguageTag : Sh404sefHelperLanguage::getLangTagFromUrlCode($lang);
$shLangIso = isset($lang) ? $lang : Sh404sefHelperLanguage::getUrlCodeFromTag($shPageInfo->currentLanguageTag);
$shLangIso = shLoadPluginLanguage('com_content', $shLangIso, 'COM_SH404SEF_CREATE_NEW');
//-------------------------------------------------------------

global $shCustomTitleTag, $shCustomDescriptionTag, $shCustomKeywordsTag, $shCustomLangTag, $shCustomRobotsTag, $shCanonicalTag;

// special case for 404
if (!empty($shPageInfo->httpStatus) && $shPageInfo->httpStatus == 404)
{
	$shCustomRobotsTag = 'noindex, follow';
	return;
}

// add no follow to print pages
$shCustomRobotsTag = ($tmpl == 'component' && !empty($print)) ? 'noindex, nofollow' : $shCustomRobotsTag;

// calculate page title
$title = array();
switch ($view)
{
	case 'archivecategory':
	case 'archivesection':
		if (empty($joomlaTitle))
		{
			$shCustomTitleTag = $sh_LANG[$shLangIso]['COM_SH404SEF_ARCHIVE'] . ' ' . $sefConfig->replacement . ' '
				. $shPageInfo->getDefaultFrontLiveSite();
		}
		break;
	case 'form':
		break;
	case 'featured':
		if (empty($joomlaDescription))
		{
			$shCustomDescriptionTag = $app->getCfg('MetaDesc');
		}

		$shCustomKeywordsTag = $app->getCfg('MetaKeys');

			if (empty($joomlaTitle))
			{
				$config = JFactory::getConfig();
				$title[] = $config->get('config.sitename');
			}
			else
			{
				$title[] = $joomlaTitle;
			}

			// handle second, third,... pages on home page
			// TODO same code used in function shAddPaginationInfo, should regroup
			if (!empty($limitstart))
			{
				$shLimit = shGetDefaultDisplayNumFromConfig($shPageInfo->currentNonSefUrl, $includeBlogLinks = false);
				$pagenum = empty($shLimit) ? (int) $limitstart : (int) ($limitstart / $shLimit) + 1;
				if ($sefConfig->alwaysAppendItemsPerPage)
				{
					$shMultPageLength = $sefConfig->pagerep . $shLimit;
				}
				else
					$shMultPageLength = '';

				if (!empty($sefConfig->pageTexts[$shPageInfo->currentLanguageTag])
					&& (false !== strpos($sefConfig->pageTexts[$shPageInfo->currentLanguageTag], '%s'))
				)
				{
					$pattern = str_replace($sefConfig->pagerep, ' ', $sefConfig->pageTexts[$shPageInfo->currentLanguageTag]);
					$title[] = str_replace('%s', $pagenum, $pattern) . $shMultPageLength;
				}
				else
				{
					$title[] = ' ' . $pagenum . $shMultPageLength;
				}
			}

			$shCustomTitleTag = JString::ltrim(implode(' | ', $title), '/ | ');
		break;

	default:
		// calculate canonical
		if ($view == 'article' && !Sh404sefHelperUrl::isNonSefHomepage())
		{
			$current = JUri::getInstance()->getPath();
			$shCanonicalTag = Sh404sefHelperUrl::canonicalRoutedToAbs($current);
		}

		if (empty($joomlaTitle))
		{
			// use regular function to get content titles, as per out specific settings
			$customConfig = clone ($sefConfig);

			$customConfig->includeContentCat = $sefConfig->contentTitleIncludeCat;
			$customConfig->UseAlias = $sefConfig->ContentTitleUseAlias;
			$customConfig->useCatAlias = $sefConfig->ContentTitleUseCatAlias;
			$customConfig->LowerCase = false;
			$customConfig->ContentTitleInsertArticleId = false;
			// V 1.2.4.t protect against sef_ext.php not being included
			if (!class_exists('sef_404'))
			{
				require_once(sh404SEF_ABS_PATH . 'components/com_sh404sef/sef_ext.php');
			}
			$layout = isset($layout) ? $layout : null;
			$articleId = shGetArticleIdString($id, $view, $option, $shLangName);
			$title = sef_404::getContentSlugsArray($view, $id, $layout, $Itemid, $shLangName, $customConfig);
			if (!empty($articleId))
			{
				if (!empty($sefConfig->ContentTitleInsertArticleId))
				{
					$lastBit = array_pop($title);
					if ((int) $sefConfig->ContentTitleInsertArticleId == 1)
					{
						// prepend to title
						$lastBit = '[' . $articleId . '] ' . $lastBit;
					}
					else
					{
						// append to title
						$lastBit .= ' [' . $articleId . ']';
					}

					array_push($title, $lastBit);
				}
			}
			$pageNumber = '';
			// V 1.2.4.t try better handling of multipages article (use of mospagebreak)
			if ($view == 'article' && !empty($limitstart))
			{ // this is multipage article
				$shPageTitle = '';
				try
				{
					$contentElement = ShlDbHelper::selectObject('#__content', array('id', 'fulltext', 'introtext'), array('id' => $id));
				}
				catch (Exception $e)
				{
					JError::raise(E_ERROR, 500, $e->getMessage());
				}
				$contentText = $contentElement->introtext . $contentElement->fulltext;

				if (!empty($contentElement) && empty($showall) && (strpos($contentText, 'class="system-pagebreak') !== false))
				{ // search for mospagebreak tags
					// copied over from pagebreak plugin
					// expression to search for
					//$regex = '/{(mospagebreak)\s*(.*?)}/i';
					$regex = '#<hr([^>]*)class=\"system-pagebreak\"([^>]*)\/>#iUu';
					// find all instances of mambot and put in $matches
					$shMatches = array();
					preg_match_all($regex, $contentText, $shMatches, PREG_SET_ORDER);
					// adds heading or title to <site> Title
					if (empty($limitstart))
					{ // if first page use heading of first mospagebreak
					}
					else
					{ // for other pages use title of mospagebreak
						if ($limitstart > 0 && $shMatches[$limitstart - 1][1])
						{
							$args = JUtility::parseAttributes($shMatches[$limitstart - 1][0]);
							if (@$args['title'])
							{
								$shPageTitle = $args['title'];
							}
							else if (@$args['alt'])
							{
								$shPageTitle = $args['alt'];
							}
							else
							{ // there is a page break, but no title. Use a page number
								$pattern = str_replace($sefConfig->pagerep, ' ', $sefConfig->pageTexts[$shPageInfo->currentLanguageTag]);
								$shPageTitle = str_replace('%s', $limitstart + 1, $pattern);
							}
						}
					}
				}

				if (!empty($shPageTitle)) // found a heading, we should use that as a Title
				{
					$title[] = Sh404sefHelperMetadata::cleanUpTitle($shPageTitle);
				}
			}
			else
			{
				if (!empty($limit) && !empty($limitstart))
				{
					//TODO handle multipages
					$shLimit = $layout == 'blog'
						? shGetDefaultDisplayNumFromConfig($shPageInfo->currentNonSefUrl, $includeBlogLinks = $view == 'section') : $limit;
					$pagenum = empty($limit) ? (int) $limitstart : (int) ($limitstart / $shLimit) + 1;
					if ($sefConfig->alwaysAppendItemsPerPage)
					{
						$shMultPageLength = $sefConfig->pagerep . $shLimit;
					}
					else
						$shMultPageLength = '';
					$pattern = str_replace($sefConfig->pagerep, ' ', $sefConfig->pageTexts[$shPageInfo->currentLanguageTag]);
					$pageNumber = str_replace('%s', $pagenum, $pattern) . $shMultPageLength;
				}
				else
				{
					if (!empty($limitstart))
					{ // this may be a blog category view, with more than one page
						if ($title[count($title) - 1] == '/')
						{ // need to remove trailing slash added by getContentTitle
							unset($title[count($title) - 1]);
						}
						if ($view == 'article')
						{
							$pagenum = intval($limitstart + 1); // multipage article
						}
						if (!empty($pagenum))
						{
							$pattern = str_replace($sefConfig->pagerep, ' ', $sefConfig->pageTexts[$shPageInfo->currentLanguageTag]);
							$pageNumber = str_replace('%s', $pagenum, $pattern)/*.$shMultPageLength*/
							;
						}
					}
					else
					{
						if (!empty($showall))
						{
							$pageNumber = titleToLocation(JText::_('All Pages'));
						}
					}
				}
			}
			// V 1.2.4.j 2007/04/11 : numerical ID, on some categories only
			if ($sefConfig->shInsertNumericalId && isset($sefConfig->shInsertNumericalIdCatList) && !empty($id) && ($view == 'view'))
			{
				try
				{
					$contentElement = ShlDbHelper::selectObject('#__content', array('id', 'catid', 'created'), array('id' => $id));
					if (!empty($contentElement))
					{ // V 1.2.4.t
						$foundCat = array_search(@$contentElement->catid, $sefConfig->shInsertNumericalIdCatList);
						if (($foundCat !== null && $foundCat !== false) || ($sefConfig->shInsertNumericalIdCatList[0] == ''))
						{ // test both in case PHP < 4.2.0
							$shTemp = explode(' ', $contentElement->created);
							$title[] = str_replace('-', '', $shTemp[0]) . $contentElement->id;
						}
					}
				}
				catch (Exception $e)
				{
					ShlSystem_Log::error('sh404sef', '%s::%s::%d: %s', __CLASS__, __METHOD__, __LINE__, $e->getMessage());
				}
			}

			// end of edition id insertion
			$title = array_reverse($title);
			if (!empty($pageNumber))
			{ // better add page number at end rather than beg
				$title[] = $pageNumber;
			}
			$shCustomTitleTag = JString::ltrim(implode($sefConfig->pageTitleSeparator, $title), '/' . $sefConfig->pageTitleSeparator);
		}
}


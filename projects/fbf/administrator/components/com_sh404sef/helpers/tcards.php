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

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC'))
{
	die('Direct Access to this location is not allowed.');
}

class Sh404sefHelperTcards
{
	public static function buildTwitterCardsTags()
	{
		// prepare data
		$twitterCardsData = '';

		// get sh404sef config
		$sefConfig = Sh404sefFactory::getConfig();
		$pageInfo = Sh404sefFactory::getPageInfo();
		$document = JFactory::getDocument();

		if (empty($sefConfig->shMetaManagementActivated) || !isset($sefConfig) || empty($pageInfo->currentNonSefUrl)
			|| (!empty($pageInfo->httpStatus) && $pageInfo->httpStatus == 404)
		)
		{
			return $twitterCardsData;
		}

		$customData = Sh404sefHelperMetadata::getCustomMetaDataFromDb();

		// user can disable per url
		if (isset($customData->twittercards_enable) && $customData->twittercards_enable == SH404SEF_OPTION_VALUE_NO
			|| (empty($sefConfig->enableTwitterCards)
				&& (!isset($customData->twittercards_enable) || $customData->twittercards_enable == SH404SEF_OPTION_VALUE_USE_DEFAULT))
		)
		{
			return $twitterCardsData;
		}

		// check categories
		if (!Sh404sefHelperMetadata::shouldInsertMeta($input = null, $sefConfig->twitterCardsCategories))
		{
			return $twitterCardsData;
		}

		// card type
		$displayData = array();
		$displayData['card_type'] = $sefConfig->twitterCardsType;

		// site
		$displayData['site_account'] = !isset($customData->twittercards_site_account) || empty($customData->twittercards_site_account)
			? $sefConfig->twitterCardsSiteAccount : $customData->twittercards_site_account;

		// creator
		$displayData['creator'] = empty($customData->twittercards_creator_account) ? $sefConfig->twitterCardsCreatorAccount
			: $customData->twittercards_creator_account;

		// title
		$displayData['title'] = empty($pageInfo->pageTitle) ? $document->getTitle() : $pageInfo->pageTitle;

		// description: Twitter requires a title and description. If no description has been found at this stage
		// meaning not even a sitewide one, we use the page title, which would always exists
		$displayData['description'] = empty($pageInfo->pageDescription) ? $document->getDescription() : $pageInfo->pageDescription;
		$displayData['description'] = empty($displayData['description']) ? $displayData['title'] : $displayData['description'];

		// insert url. If any, we insert the canonical url rather than current, to consolidate
		$displayData['url'] = empty($pageInfo->pageCanonicalUrl) ? $pageInfo->currentSefUrl : $pageInfo->pageCanonicalUrl;
		$displayData['url'] = Sh404sefHelperUrl::stripTrackingVarsFromSef($displayData['url']);

		// image : we share with OpenGraph image
		$displayData['image'] = empty($customData->og_image) ? $sefConfig->ogImage : $customData->og_image;

		/**
		 * Filter the list of Twitter cards as computed by sh404SEF.
		 *
		 * @api
		 * @package sh404SEF\filter\seo
		 * @var sh404sef_tcards_tags
		 * @since   1.9.2
		 *
		 * @param array $displayData Associative array of Twitter cards related data.
		 *
		 * @return array
		 */
		$displayData = ShlHook::filter(
			'sh404sef_tcards_tags',
			$displayData
		);

		$twitterCardsData = ShlMvcLayout_Helper::render('com_sh404sef.social.twitter_cards', $displayData);

		return $twitterCardsData;
	}
}

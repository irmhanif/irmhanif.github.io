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

?>

  <h2><?php echo JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_DATA'); ?></h2>

    <table class="table table-striped">
      <tbody>
        <tr rel="tooltip" <?php echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_DATA_VISITS'), JText::_('COM_SH404SEF_ANALYTICS_DATA_VISITS_DESC'));?>>
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_DATA_VISITS' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape( $this->analytics->analyticsData->global->sessions); ?>
          </td>
        </tr>

        <tr rel="tooltip" <?php echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_DATA_VISITORS'), JText::_('COM_SH404SEF_ANALYTICS_DATA_VISITORS_DESC'));?>>
          <td width="50%" style="text-align: right;" >
          <?php echo  JText::_( 'COM_SH404SEF_ANALYTICS_DATA_VISITORS' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape($this->analytics->analyticsData->global->users); ?>
          </td>
        </tr>

        <tr rel="tooltip" <?php echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_TOP5_PAGEVIEWS'), JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_PAGEVIEWS_DESC'));?>>
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_TOP5_PAGEVIEWS' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape($this->analytics->analyticsData->global->pageviews); ?>
          </td>
        </tr>

        <tr rel="tooltip" <?php echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_AVG_PAGES_VISIT'), JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_AVG_PAGES_VISIT_DESC'));?>>
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_GLOBAL_AVG_PAGES_VISIT' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape(sprintf( '%0.1f', $this->analytics->analyticsData->global->pagesPerVisit)); ?>
          </td>
        </tr>

        <tr rel="tooltip" <?php echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_BOUNCE_RATE'), JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_BOUNCE_RATE_DESC'));?>>
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_GLOBAL_BOUNCE_RATE' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape(sprintf( '%0.1f', $this->analytics->analyticsData->global->bounceRate * 100)) . ' %'; ?>
          </td>
        </tr>

        <tr rel="tooltip" <?php echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_AVG_TIME_ON_SITE'), JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_AVG_TIME_ON_SITE_DESC'));?>>
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_GLOBAL_AVG_TIME_ON_SITE' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape(sprintf( '%0.1f', $this->analytics->analyticsData->global->avgTimeOnSite)) . ' s.'; ?>
          </td>
        </tr>

        <tr rel="tooltip" <?php echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_NEW_VISITS'), JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_NEW_VISITS_DESC'));?>>
          <td width="50%" style="text-align: right;" >
          <?php echo JText::_( 'COM_SH404SEF_ANALYTICS_GLOBAL_NEW_VISITS' ); ?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php echo $this->escape(sprintf( '%0.1f', $this->analytics->analyticsData->global->newVisitsPerCent*100)) . ' %'; ?>
          </td>
        </tr>

        <!--<tr rel="tooltip" <?php /*echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_TOTAL_SOCIAL_ENGAGEMENT'), JText::_('COM_SH404SEF_ANALYTICS_TOTAL_SOCIAL_ENGAGEMENT_DESC'));*/?>>
          <td width="50%" style="text-align: right;" >
          <?php /*echo JText::_( 'COM_SH404SEF_ANALYTICS_TOTAL_SOCIAL_ENGAGEMENT' ); */?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php /*echo $this->escape($this->analytics->analyticsData->global->totalSocialEvents); */?>
          </td>
        </tr>

        <tr rel="tooltip" <?php /*echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_VISITS_WITH_SOCIAL_ENGAGEMENT'), JText::_('COM_SH404SEF_ANALYTICS_GLOBAL_VISITS_WITH_SOCIAL_ENGAGEMENT_DESC'));*/?>>
          <td width="50%" style="text-align: right;" >
          <?php /*echo JText::_( 'COM_SH404SEF_ANALYTICS_GLOBAL_VISITS_WITH_SOCIAL_ENGAGEMENT' ); */?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php /*echo $this->escape(sprintf( '%0.1f', $this->analytics->analyticsData->global->visitsWithSocialEngagement * 100)) . ' %'; */?>
          </td>
        </tr>

        <tr rel="tooltip" <?php /*echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_TOTAL_FACEBOOK_ENGAGEMENT'), JText::_('COM_SH404SEF_ANALYTICS_TOTAL_FACEBOOK_ENGAGEMENT_DESC'));*/?>>
          <td width="50%" style="text-align: right;" >
          <?php /*echo JText::_( 'COM_SH404SEF_ANALYTICS_TOTAL_FACEBOOK_ENGAGEMENT' ); */?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php /*echo $this->escape($this->analytics->analyticsData->global->sh404SEF_social_tracker_facebook); */?>
          </td>
        </tr>

        <tr rel="tooltip" <?php /*echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_TOTAL_TWEETER_ENGAGEMENT'), JText::_('COM_SH404SEF_ANALYTICS_TOTAL_TWEETER_ENGAGEMENT_DESC'));*/?>>
          <td width="50%" style="text-align: right;" >
          <?php /*echo JText::_( 'COM_SH404SEF_ANALYTICS_TOTAL_TWEETER_ENGAGEMENT' ); */?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php /*echo $this->escape($this->analytics->analyticsData->global->sh404SEF_social_tracker_tweeter); */?>
          </td>
        </tr>

        <tr rel="tooltip" <?php /*echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_TOTAL_PINTEREST_ENGAGEMENT'), JText::_('COM_SH404SEF_ANALYTICS_TOTAL_PINTEREST_ENGAGEMENT_DESC'));*/?>>
          <td width="50%" style="text-align: right;" >
          <?php /*echo JText::_( 'COM_SH404SEF_ANALYTICS_TOTAL_PINTEREST_ENGAGEMENT' ); */?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php /*echo $this->escape($this->analytics->analyticsData->global->sh404SEF_social_tracker_pinterest); */?>
          </td>
        </tr>

        <tr rel="tooltip" <?php /*echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_TOTAL_PLUSONE_ENGAGEMENT'), JText::_('COM_SH404SEF_ANALYTICS_TOTAL_PLUSONE_ENGAGEMENT_DESC'));*/?>>
          <td width="50%" style="text-align: right;" >
          <?php /*echo JText::_( 'COM_SH404SEF_ANALYTICS_TOTAL_PLUSONE_ENGAGEMENT' ); */?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php /*echo $this->escape($this->analytics->analyticsData->global->sh404SEF_social_tracker_gplus); */?>
          </td>
        </tr>

        <tr rel="tooltip" <?php /*echo Sh404sefHelperHtml::wrapBootstrapTipTitle(JText::_('COM_SH404SEF_ANALYTICS_TOTAL_PLUSPAGE_ENGAGEMENT'), JText::_('COM_SH404SEF_ANALYTICS_TOTAL_PLUSPAGE_ENGAGEMENT_DESC'));*/?>>
          <td width="50%" style="text-align: right;" >
          <?php /*echo JText::_( 'COM_SH404SEF_ANALYTICS_TOTAL_PLUSPAGE_ENGAGEMENT' ); */?>&nbsp;
          </td>
          <td width="50%" class="key shlargerkey" style="text-align: left;">
            <?php /*echo $this->escape($this->analytics->analyticsData->global->sh404SEF_social_tracker_gplus_page); */?>
          </td>
        </tr>
-->
      </tbody>
    </table>


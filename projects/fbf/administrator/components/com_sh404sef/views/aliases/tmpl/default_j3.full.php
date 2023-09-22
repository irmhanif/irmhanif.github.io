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

jimport('joomla.html.html.bootstrap');
JHtml::_('formbehavior.chosen', 'select');
$saveOrderingUrl = 'index.php?option=com_sh404sef&c=aliases&task=saveOrderAjax&tmpl=component';
JHtml::_('sortablelist.sortable', 'aliasList', 'adminForm', strtolower($this->options->filter_order_Dir), $saveOrderingUrl);

$sticky = Sh404sefHelperHtml::setFixedTemplate();

if($sticky) :?>
<div class="shl-fixed-top-hidden<?php echo Sh404sefHelperHtml::getFixedHeaderClass(); ?>">&nbsp;</div>
<?php endif; ?>

<div class="shl-main-content wbl-theme-default">

<form method="post" name="adminForm" id="adminForm" class="shl-no-margin">

<div class="row-fluid">

<?php if($sticky) : ?>
<div class="shl-fixed span12 shl-main-searchbar-wrapper">
	<?php echo ShlMvcLayout_Helper::render('com_sh404sef.filters.bar_search_limit_pag_sticky', $this); ?>
</div>
<?php endif; ?>

<div id="shl-sidebar-container" class="<?php echo $sticky ? 'shl-fixed' : ''; ?> span2 shl-no-margin">
<?php echo $this->sidebar; ?>
</div>

<?php if(!$sticky): ?>
<div class="span10">
<?php endif; ?>

<?php if(!$sticky): ?>
<div class="span12 shl-main-searchbar-wrapper">
	<?php echo ShlMvcLayout_Helper::render('com_sh404sef.filters.bar_search_limit', $this); ?>
</div>
<?php endif; ?>

<div class="shl-main-list-wrapper span12 shl-no-margin-left <?php if($sticky) echo ' shl-main-list-wrapper-padding'; ?>">

	<?php if($sticky):?>
	<div class="span2 shl-hidden-low-width"></div>
	<div class="span10 <?php echo $sticky ? 'shl-no-margin-left' : ''; ?>">
	<?php
		endif;
		echo ShlMvcLayout_Helper::render('shlib.msg.collapsed_message', array('content' => $this->helpMessage, 'close' => true, 'collapse' => true), SHLIB_LAYOUTS_PATH);
	?>

	<div id="sh-message-box"></div>
    <table class="table table-striped table-bordered shl-main-list-wrapper" id="aliasList">
      <thead>
        <tr>
            <th class="shl-list-id nowrap center hidden-phone">
		        <?php echo JHtml::_('searchtools.sort', '', 'ordering', $this->options->filter_order_Dir, $this->options->filter_order, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
            </th>
          <th class="shl-list-id">&nbsp;
          </th>

          <th class="shl-list-check">
            <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
          </th>
	        <th class="shl-list-hits">
		        <?php echo JText::_( 'COM_SH404SEF_HITS'); ?>
	        </th>
            <th class="shl-list-hits">
		        <?php echo JText::_( 'COM_SH404SEF_ALIAS_TARGET_TYPE_TITLE'); ?>
            </th>
          <th class="shl-list-sef">
            <?php echo JText::_( 'COM_SH404SEF_ALIAS'); ?>
          </th>

	        <th class="shl-list-hits"><?php echo JText::_('COM_SH404SEF_HIT_DETAILS'); ?>
	        </th>

          <th class="shl-list-sef">
            <?php echo JText::_( 'COM_SH404SEF_URL'); ?>
          </th>

        </tr>
      </thead>
      <tfoot>
        <tr>
          <td colspan="8">
            <?php echo '<div id="shl-bottom-pagination-container">' . $this->pagination->getListFooter() . '</div>'; ?>
          </td>
        </tr>
      </tfoot>
      <tbody>
        <?php
          $k = 0;
        $sizes = Sh404sefFactory::getPConfig()->windowSizes;
          if( $this->itemCount > 0 ) {
            for ($i=0; $i < $this->itemCount; $i++) {

              $alias = &$this->items[$i];
              $checked = JHtml::_( 'grid.id', $i, $alias->id);
        ?>

        <tr>

            <td class="shl-list-id">
            <span class="sortable-handler">
				<span class="icon-menu" aria-hidden="true"></span>
            </span>
            <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $alias->ordering; ?>" class="width-20 text-area-order" />
            </td>

          <td class="shl-list-id">
            <?php echo $this->pagination->getRowOffset( $i ); ?>
          </td>

          <td class="shl-list-check">
            <?php echo $checked; ?>
          </td>

	        <td class="shl-list-check">
		        <?php echo empty($alias->hits) ? '&nbsp;' : ShlSystem_Strings::formatIntForTitle($alias->hits); ?>
	        </td>

            <td class="shl-list-check">
		        <?php echo Sh404sefModelRedirector::TARGET_TYPE_REDIRECT == $alias->target_type ? JText::_('COM_SH404SEF_ALIAS_TARGET_TYPE_REDIRECT_SHORT') : JText::_('COM_SH404SEF_ALIAS_TARGET_TYPE_CANONICAL_SHORT'); ?>
            </td>

          <td class="shl-list-sef">
            <?php
            $params = array();
            $linkData = array( 'c' => 'editalias', 'task' => 'edit', 'view' => 'editalias', 'cid[]' => $alias->id, 'tmpl' => 'component');
            $targetUrl = Sh404sefHelperUrl::buildUrl($linkData);
            $params['linkTitle'] = JText::_('COM_SH404SEF_MODIFY_ALIAS_TITLE'). ' ' . $this->escape($alias->oldurl);
            $params['linkTitle'] = Sh404sefHelperHtml::abridge($params['linkTitle'], 'editurl');
             $modalTitle = '';
            $name = '-editalias-' . $alias->id;
            $params['linkClass'] = 'shl-list-sef';
            $params['linkType'] = 'a';
            echo ShlHtmlModal_helper::modalLink($name, $alias->alias, $targetUrl, $sizes['editurl']['x'], Sh404sefFactory::getPConfig()->windowSizes['editurl']['y'], $top = 0, $left = 0, $onClose = '', $modalTitle, $params);
            ?>
          </td>

	        <td class="center">
		        <?php
		        $params = array();
		        $linkData = array( 'c' => 'hitdetails', 'url_id' => $alias->id, 'tmpl' => 'component','request_type' => 'aliases');
		        $targetUrl = Sh404sefHelperUrl::buildUrl($linkData);
		        $modalTitle = '';
		        $params['linkTitle'] = JText::_('COM_SH404SEF_HIT_VIEW_DETAILS_TITLE');
		        $params['linkClass'] = 'btn';
		        $name = '-viewhitdetails-' . $alias->id;
		        echo ShlHtmlModal_helper::modalLink($name, '+', $targetUrl, $sizes['selectredirect']['x'], $sizes['selectredirect']['y'], $top = 0, $left = 0, $onClose = '', $modalTitle, $params);
		        ?>
	        </td>

          <td class="shl-list-sef">
            <?php
            echo $this->escape( $alias->newurl);
            if(
	            Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS == $alias->type
                ||
	            Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS_WILDCARD == $alias->type
            )
            {
	            $sefConfig = &Sh404sefFactory::getConfig();
	            if (!empty($alias->oldurl))
	            {
		            echo '<br/><span class="muted">(' . $this->escape($alias->oldurl) . ')</span>';
		            $link = JURI::root() . ltrim($sefConfig->shRewriteStrings[$sefConfig->shRewriteMode], '/') . $alias->oldurl;
	            }
	            else
	            {
		            echo '<br /><span class="muted">(-)</span>';
		            $link = JURI::root() . $alias->newurl;
	            }
	            // small preview icon
	            echo '&nbsp;<a href="' . $this->escape($link) . '" target="_blank" title="' . JText::_('COM_SH404SEF_PREVIEW') . ' ' . $this->escape($alias->oldurl) . '">';
	            echo '<img src=\'components/com_sh404sef/assets/images/external-black.png\' border=\'0\' alt=\'' . JText::_('COM_SH404SEF_PREVIEW') . '\' />';
	            echo '</a>';
            }
            ?>

          </td>

        </tr>
        <?php
        $k = 1 - $k;
      }
    } else {
      ?>
        <tr>
          <td class="center shl-middle" colspan="8">
            <?php echo JText::_( 'COM_SH404SEF_NO_ALIASES' ); ?>
          </td>
        </tr>
        <?php
      }
      ?>
      </tbody>
    </table>
    <?php if($sticky):?>
    </div>
    <?php endif;?>
</div>

<?php if(!$sticky): ?>
</div>
<?php endif; ?>

    <input type="hidden" name="c" value="aliases" />
    <input type="hidden" name="view" value="aliases" />
    <input type="hidden" name="option" value="com_sh404sef" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $this->options->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->options->filter_order_Dir; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
 </div>
</form>
</div>

<div class="sh404sef-footer-container">
	<?php echo $this->footerText; ?>
</div>

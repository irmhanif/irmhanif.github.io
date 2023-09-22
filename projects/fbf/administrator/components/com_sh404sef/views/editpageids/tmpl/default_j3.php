<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author       Yannick Gaultier
 * @copyright    (c) Yannick Gaultier - Weeblr llc - 2018
 * @package      sh404SEF
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version      4.13.2.3783inputgetBool
 * @date        2018-01-25
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_JEXEC'))
{
	die();
}

jimport('joomla.html.html.bootstrap');
$liveSite = Sh404sefFactory::getPageInfo()->getDefaultFrontLiveSite();
?>

<div class="sh404sef-popup" id="sh404sef-popup">

    <div class="shmodal-toolbar row-fluid wbl-theme-default" id="shmodal-toolbar">
        <div class="shmodal-toolbar-wrapper">
            <div class="shmodal-toolbar-text">
				<?php
				echo ShlHtmlBs_Helper::label(JText::_('COM_SH404SEF_CREATE_SHURL'), 'info', $dismiss = false, 'label-large');
				?>
            </div>
            <div class="shmodal-toolbar-buttons" id="shmodal-toolbar-buttons">
                <button class="btn btn-primary" id="shmodal-save-button" type="button">
                    <i class="icon-publish icon-white"> </i>
					<?php echo JText::_('JAPPLY'); ?></button>
                <button class="btn" type="button" id="shmodal-close"
                        onclick="window.parent.location.href=window.parent.location.href;">
					<?php echo JText::_('JTOOLBAR_CLOSE'); ?>
                </button>
                <button class="btn" type="button" id="shmodal-cancel"
                        onclick="window.parent.shlBootstrap.closeModal();">
					<?php echo JText::_('JCANCEL'); ?>
                </button>
            </div>
        </div>
    </div>

    <div id="shmodal-message-block" class="shmodal-message-block"></div>

    <div class="shmodal-content wbl-theme-default" id="shmodal-content">
		<?php
		echo ShlMvcLayout_Helper::render('com_sh404sef.general.message_block', $this);
		?>
        <div id="editurl-container">

            <form action="index.php" method="post" name="adminForm" id="adminForm"
                  class="form-validate form-horizontal">
                <div id="editurl-container">
                    <div class="row-fluid">
						<?php
						//old url
						$data = new stdClass();
						$data->name = 'oldurl';
						$data->label = JText::_('COM_SH404SEF_SHURL_TARGET_URL');
						$data->input = '<input maxlength="' . sh404SEF_MAX_SEF_URL_LENGTH . '" type="text" name="url" id="url" size="90" value="" />';
						$data->tip = JText::_('COM_SH404SEF_TT_CREATE_SHURL') . ' ' . JText::_('COM_SH404SEF_SHURL_ERROR_INVALID_URL');
						echo $this->layoutRenderer['custom']->render($data);
						?>
                    </div>
                </div>
                <input type="hidden" name="c" value="pageids"/>
                <input type="hidden" name="option" value="com_sh404sef"/>
                <input type="hidden" name="task" value="create"/>
                <input type="hidden" name="format" value="raw"/>
				<?php echo JHTML::_('form.token'); ?>
            </form>
        </div>
    </div>

</div>

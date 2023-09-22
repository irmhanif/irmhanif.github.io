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

if (empty($this->alias) || empty($this->alias->id))
{
	$isNew = true;
	$alias = '';
	$newurl = '';
	$aliasId = 0;
	$aliasType = Sh404sefHelperGeneral::COM_SH404SEF_URLTYPE_ALIAS;
	$hits = 0;
	$targetType = Sh404sefModelRedirector::TARGET_TYPE_REDIRECT;
	$ordering = 0;
	$state = 1;
}
else
{
	$isNew = false;
	$alias = $this->alias->alias;
	$newurl = $this->alias->newurl;
	$aliasId = $this->alias->id;
	$aliasType = $this->alias->type;
	$hits = $this->alias->hits;
	$targetType = $this->alias->target_type;
	$ordering = $this->alias->ordering;
	$state = $this->alias->state;
}

?>

<div class="sh404sef-popup" id="sh404sef-popup">

    <div class="shmodal-toolbar row-fluid wbl-theme-default" id="shmodal-toolbar">
        <div class="shmodal-toolbar-wrapper">
            <div class="shmodal-toolbar-text">
				<?php
				echo ShlHtmlBs_Helper::label($isNew ? JText::_('COM_SH404SEF_CREATE_ALIAS') : JText::_('COM_SH404SEF_EDIT_ALIAS'), 'info', $dismiss = false, 'label-large');
				?>
            </div>
            <div class="shmodal-toolbar-buttons" id="shmodal-toolbar-buttons">
                <button class="btn btn-primary" id="shmodal-save-button" type="button">
                    <i class="icon-publish icon-white"> </i>
					<?php echo JText::_('JSAVE'); ?></button>
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
						$data->name = 'target_type';
						$data->label = JText::_('COM_SH404SEF_ALIAS_TARGET_TYPE_TITLE');
						$data->input = $this->targetTypeSelector;
						$data->tip = JText::_('COM_SH404SEF_TT_ALIAS_TARGET_TYPE_TITLE');
						echo $this->layoutRenderer['custom']->render($data);
						?>
                    </div>
                </div>
                <div id="editurl-container">
                    <div class="row-fluid">
						<?php
						//old url
						$data = new stdClass();
						$data->name = 'alias';
						$data->label = JText::_('COM_SH404SEF_ALIAS');
						$data->input = '<input maxlength="' . sh404SEF_MAX_SEF_URL_LENGTH . '" type="text" name="alias" id="alias" size="90" value="' . $alias . '" />';
						$data->tip = JText::_('COM_SH404SEF_TT_CREATE_ALIAS_ALIAS');
						echo $this->layoutRenderer['custom']->render($data);
						?>
                    </div>
                </div>

                <div id="editurl-container">
                    <div class="row-fluid">
						<?php
						//old url
						$data = new stdClass();
						$data->name = 'newurl';
						$data->label = JText::_('COM_SH404SEF_ALIAS_TARGET_URL');
						$data->input = '<input maxlength="' . sh404SEF_MAX_SEF_URL_LENGTH . '" type="text" name="newurl" id="newurl" size="90" value="' . $newurl . '" />';
						$data->tip = JText::_('COM_SH404SEF_TT_CREATE_ALIAS_TARGET_URL') . ' ' . JText::_('COM_SH404SEF_TT_CREATE_ALIAS_TARGET_URL_SPEC');
						echo $this->layoutRenderer['custom']->render($data);
						?>
                    </div>
                </div>

				<?php if (!empty($this->url) && !empty($this->url->oldurl)) : ?>
                    <div id="editurl-container">
                        <div class="control-group">
                            <div class="control-label muted">
                                <label><?php echo JText::_('COM_SH404SEF_SEF_URL'); ?></label>
                            </div>
                            <div class="controls muted">
								<?php echo $this->escape($this->url->oldurl); ?>
                            </div>
                        </div>
                    </div>

				<?php endif; ?>

                <input type="hidden" name="c" value="editalias"/>
                <input type="hidden" name="option" value="com_sh404sef"/>
                <input type="hidden" name="id" value="<?php echo $aliasId; ?>"/>

                <input type="hidden" name="hits" value="<?php echo $hits; ?>"/>
                <input type="hidden" name="ordering" value="<?php echo $ordering; ?>"/>
                <input type="hidden" name="state" value="<?php echo $state; ?>"/>

                <input type="hidden" name="task" value="save"/>
                <input type="hidden" name="format" value="raw"/>
				<?php echo JHTML::_('form.token'); ?>
            </form>
        </div>
    </div>

</div>

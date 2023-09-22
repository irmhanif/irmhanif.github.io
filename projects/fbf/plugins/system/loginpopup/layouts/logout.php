<?php
/**
 * @copyright	Copyright (c) 2014 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

require_once JPATH_SITE . '/components/com_users/helpers/route.php';
require_once JPATH_PLUGINS . '/system/loginpopup/helper.php';

$return	= PlgSystemLoginPopupHelper::getReturnURL($displayData, 'logout');
$user	= JFactory::getUser();
?>

<div id="lp-overlay"></div>
<div id="lp-popup" class="lp-wrapper">
	<button class="lp-close" type="button" title="Close (Esc)">×</button>

	<form action="<?php echo JRoute::_('index.php', true, $displayData->get('usesecure')); ?>" method="post" class="lp-form">
		<?php if ($displayData->get('greeting')) : ?>
			<div class="lp-login-greeting">
				<?php echo JText::sprintf('PLG_SYSTEM_LOGINPOPUP_HINAME', htmlspecialchars($displayData->get('name') == 0 ? $user->get('name') : $user->get('username'))); ?>
			</div>
		<?php endif; ?>

		<div class="lp-button-wrapper clearfix">
			<div class="lp-left">
				<button type="submit" class="lp-button"><?php echo JText::_('JLOGOUT'); ?></button>
			</div>
		</div>

		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
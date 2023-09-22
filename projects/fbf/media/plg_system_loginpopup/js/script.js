/**
 * @copyright	Copyright (c) 2014 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

if (!ExtStore) {
	var ExtStore	= {};
}

ExtStore.LoginPopup	= {
	offset_top: 	0,

	open: function() {
		var popup	= jQuery('#lp-popup');
		var overlay	= jQuery('#lp-overlay');

		overlay.addClass('lp-open');
		popup.addClass('lp-open');

		var window_width	= overlay.width();
		var window_height	= overlay.height();
		var popup_width		= popup.outerWidth();
		var popup_heigh		= popup.outerHeight();
		var left			= window_width - popup_width < 0 ? 0 : (window_width - popup_width) / 2;
		var top				= window_height - popup_heigh - ExtStore.LoginPopup.offset_top / 2 < 0 ? 0 : (window_height - popup_heigh) / 2 - ExtStore.LoginPopup.offset_top;

		popup.css({
			'left':	left,
			'top': top
		});
	},

	close: function() {
		jQuery('#lp-overlay').removeClass('lp-open');
		jQuery('#lp-popup').removeClass('lp-open');
	}
};
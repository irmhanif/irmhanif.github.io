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

;
(function (app, $) {

    function shurlDisplayProvider(data, $saveButton, $cancelButton, $closeButton) {
        var shurlDisplay = document.getElementById('shurl_display');
        shurlDisplay.focus();
        shurlDisplay.select();

        $cancelButton.hide();
        $closeButton.show();
        $saveButton.hide();
    }

    function shurlMessageProvider(type, data) {
        var message = '';
        switch (type) {
            case 'error':
                break;
            case 'success':
                message = '<input type="text" id="shurl_display" class="shurl_display" value="' + data.full_shurl + '">';
                break;
        }

        return message;
    }

    app.ajaxFormMessageProviders.push(shurlMessageProvider);
    app.ajaxFormDisplayProviders.push(shurlDisplayProvider);

})(window.__sh404sefJs = window.__sh404sefJs || {}, jQuery);

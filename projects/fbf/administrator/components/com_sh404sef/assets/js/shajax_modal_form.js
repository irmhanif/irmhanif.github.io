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

    var $messageBox;
    var $saveButton;
    var $closeButton;
    var $cancelButton;
    var $form;

    var messagesProviders = [];
    var displayProviders = [];

    function doRequest(event) {
        event && event.preventDefault();
        $messageBox.empty();
        $saveButton.attr('disabled', true);
        $.post(
            'index.php',
            $form.serialize(),
            'json'
        ).done(
            updateDisplay
        );
    }

    function updateDisplay(data) {

        $saveButton.attr('disabled', false);
        $messageBox
            .html(
                getMessages(data.status ? 'success' : 'error', data)
            );

        var providersCount = displayProviders.length;
        if (!providersCount) {
            displayProviders.push(defaultDisplayProvider);
            providersCount = 1;
        }
        for (var i = 0; i < providersCount; i++) {
            displayProviders[i](data, $saveButton, $cancelButton, $closeButton);
        }

    }

    function defaultMessageProvider(type, data) {
        return data.message;

    }

    function defaultDisplayProvider(data, $saveButton, $cancelButton, $closeButton) {
        if (data.status) {
            $cancelButton.hide();
            $saveButton.attr('disabled', true);
            window.parent.location.href=window.parent.location.href;
        }
    }

    function getMessages(type, data) {
        var providersCount = messagesProviders.length;
        var fullMessage = '';
        for (var i = 0; i < providersCount; i++) {
            fullMessage += messagesProviders[i](type, data);
        }
        switch (type) {
            case 'error':
                fullMessage = '<div class="alert alert-error">' + fullMessage + '</div>'
                break;
            case 'success':
                fullMessage = '<div class="alert alert-success">' + fullMessage + '</div>'
                break;
        }
        return fullMessage;
    }

    function onReady() {
        $messageBox = $('#shmodal-message-block');
        $saveButton = $('#shmodal-save-button');
        $closeButton = $('#shmodal-close').hide();
        $cancelButton = $('#shmodal-cancel');
        $form = $('#adminForm');
        $form.submit(doRequest);

        $saveButton.on('click', doRequest);
    }

    // init
    messagesProviders.push(
        defaultMessageProvider
    );
    $(document).ready(
        onReady
    );

    app.ajaxFormMessageProviders = messagesProviders;
    app.ajaxFormDisplayProviders = displayProviders;

})(window.__sh404sefJs = window.__sh404sefJs || {}, jQuery);

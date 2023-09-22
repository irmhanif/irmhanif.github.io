/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.13.2.3783
 * @date    2018-01-25
 */
;
(function (app, $) {
    // function to call on document ready
    function onReady() {
        $(window).resize(__sh404sefJs.stickyPagination);
        __sh404sefJs.stickyPagination();
    };

    // display the pagination bar at the top, fixed, or let it
    // at bottom, scrolling
    function stickyPagination() {
        var needed = $("#shl-bottom-pagination-container ul.pagination-list").width();
        var avail = $("#shl-main-searchbar-right-block").width();
        var used = 0;
        $("#shl-main-searchbar-right-block div.btn-group").each(function () {
            var w = $(this).width();
            used += w;
        });
        if ((avail - used - 20) > needed) {
            var c = $("#shl-bottom-pagination-container").html();
            if (c) {
                $("#shl-bottom-pagination-container").html("");
                $("#shl-top-pagination-container").html(c);
                $(".shl-main-list-wrapper table tfoot").hide();
            }
        } else {
            var t = $("#shl-top-pagination-container").html();
            if (t) {
                $("#shl-bottom-pagination-container").html(t);
                $("#shl-top-pagination-container").html("");
            }

        }
    }

    // init
    $(document).ready(
        onReady
    );

    // Interface
    app.stickyPagination = stickyPagination;

})(window.__sh404sefJs = window.__sh404sefJs || {}, jQuery);

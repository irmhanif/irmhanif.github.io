
jQuery.noConflict();
jQuery(document).ready(function () {
    var owl = jQuery('.carousel');
    owl.owlCarousel({
        items: 1,
        margin: 30,
        autoplay: true,
        autoPlay: 2000, //Set AutoPlay to 3 seconds
        dots: false,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        loop: true,
        responsiveClass: true,
        responsive: {
            300: {
                items: 1,
            },
            320: {
                items: 1,
            },
            480: {
                items: 1,
            },
            720: {
                items: 3,
            },
            1000: {
                items: 4
            }
        }
    });
});
// setTimeout(() => {
//     var len = jQuery('.service__box .owl-dot').length;
//     for (var i = 0; i <= len; i++) {
//         jQuery('.service__box .owl-dot:nth-child(' + [i] + ')').addClass('slid' + [i]);
//         jQuery('.service__box .owl-dot:nth-child(' + [i] + ')').attr('value', [i]);
//         jQuery('.service__box .owl-dot:nth-child(' + [i] + ') span').html('0' + [i]);
//     }

// }, 1000);


var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
(function () {
    var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/5f4679c8cc6a6a5947af06b3/default';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
})();
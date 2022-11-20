jQuery(document).ready(function ($) {
    var slider_auto, slider_loop, rtl;
    if (blossom_floral_data.auto == '1') {
        slider_auto = true;
    } else {
        slider_auto = false;
    }

    if (blossom_floral_data.loop == '1') {
        slider_loop = true;
    } else {
        slider_loop = false;
    }

    if (blossom_floral_data.rtl == '1') {
        rtl = true;
    } else {
        rtl = false;
    }

     /* secondary Navigation
    --------------------------------------------- */
    $('.site-header:not(.style-one) .secondary-nav >div').prepend('<button id="closeBttn" class="close-btn"></button>');
    
    $('.secondary-nav .toggle-btn, .secondary-nav .close-btn').on('click', function () {
        var adminbarHeight = $('#wpadminbar').outerHeight();
        if ($('#wpadminbar').length) {
            $('.site-header .secondary-nav > div').animate({
                width: 'toggle',
                'top': adminbarHeight
            });
        } else {
            $('.site-header .secondary-nav > div').animate({
                width: 'toggle'
            });
        }

    });
   

    //banner 8
    $('.site-banner.slider-eight .banner-wrapper').owlCarousel({
        items: 1,
        rtl: rtl,
        loop: slider_loop,
        autoplay: slider_auto,
        autoplaySpeed: 800,
        autoplayTimeout: blossom_floral_data.speed,
        animateOut: blossom_floral_data.animation,
        nav: true,
        dots: false,

    });

});
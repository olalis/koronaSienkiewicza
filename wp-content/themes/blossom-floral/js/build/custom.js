jQuery(document).ready(function ($) {

    /* Sticky tbar
    --------------------------------------------- */
    $(document).on('click', '.sticky-t-bar .close', function () {
        $(this).siblings('.sticky-bar-content').slideToggle();
        $('.sticky-t-bar').toggleClass('active');

    });

    /* Header Search toggle
    --------------------------------------------- */
    $('.header-search .search-toggle').click(function () {
        $(this).siblings('.header-search-wrap').fadeIn();
        $('.header-search-wrap form .search-field').focus();
    });

    $('.header-search .close').click(function () {
        $(this).parents('.header-search-wrap').fadeOut();
    });

    $('.header-search-wrap').keyup(function (e) {
        if (e.key == 'Escape') {
            $('.header-search .header-search-wrap').fadeOut();
        }
    });
    $('.header-search .header-search-inner .search-form').click(function (e) {
        e.stopPropagation();
    });

    $('.header-search .header-search-inner').click(function (e) {
        $(this).parents('.header-search-wrap').fadeOut();
    });

    /* Desktop Navigation
    --------------------------------------------- */
    $('.menu-item-has-children > a').after('<button class="submenu-toggle-btn"><i class="fas fa-caret-down"></i></button>');
    $('.main-navigation').prepend('<button class="close-btn"></button>');
    $('.site-header:not(.style-one ,.style-three) .secondary-nav >div').prepend('<button class="close-btn"></button>');
    $('.submenu-toggle-btn').on('click', function () {
        $(this).siblings('.sub-menu').stop().slideToggle();
        $(this).toggleClass('active');
    });

    $('.header-main .toggle-btn').on('click', function () {
        $(this).siblings('.main-navigation').animate({
            width: 'toggle'
        });
    });
    $('.main-navigation .close-btn').on('click', function () {
        $('.main-navigation').animate({
            width: 'toggle'
        });
    });

    /* Mobile Navigation
    --------------------------------------------- */

    var adminbarHeight = $('#wpadminbar').outerHeight();
    if (adminbarHeight) {
        $('.site-header .mobile-header .header-bottom-slide .header-bottom-slide-inner ').css("top", adminbarHeight);
    } else {
        $('.site-header .mobile-header .header-bottom-slide .header-bottom-slide-inner ').css("top", 0);
    }

    $('.sticky-header .toggle-btn,.site-header .mobile-header .toggle-btn-wrap .toggle-btn').click(function () {
        $('body').addClass('mobile-menu-active');
        $('.site-header .mobile-header .header-bottom-slide .header-bottom-slide-inner ').css("transform", "translate(0,0)");
    });
    $('.site-header .mobile-header .header-bottom-slide .header-bottom-slide-inner .container .mobile-header-wrap > .close').click(function () {
        $('body').removeClass('mobile-menu-active');
        $('.site-header .mobile-header .header-bottom-slide .header-bottom-slide-inner ').css("transform", "translate(-100%,0)");
    });

    /*  Navigation Accessiblity
    --------------------------------------------- */
    $(document).on('mousemove', 'body', function (e) {
        $(this).removeClass('keyboard-nav-on');
    });
    $(document).on('keydown', 'body', function (e) {
        if (e.which == 9) {
            $(this).addClass('keyboard-nav-on');
        }
    });
    
    $('.main-navigation li a, .secondary-nav li a, .footer-navigation li a, .main-navigation li button').on('focus', function () {
        $(this).parents('li').addClass('hover');
    }).blur(function(){
        $(this).parents('li').removeClass('hover');
    });

    var slider_auto, slider_loop, rtl, header_layout, winWidth;

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

    // widgets
    var day = $('.wp-calendar-table #today').text();
    $('.wp-calendar-table #today').html('<span>' + day + '</span>');

    /* Banner
    --------------------------------------------- */

    $('.site-banner.slider-one .banner-wrapper').owlCarousel({
        items: 1,
        loop: slider_loop,
        autoplay: slider_auto,
        dots: false,
        rtl: rtl,
        nav: true,
        autoplaySpeed: 800,
        autoplayTimeout: 3000,
        animateOut: blossom_floral_data.animation,
        center: true,
        responsive: {
            0: {
                margin: 10,
                stagePadding: 30,
                center: false,
            },
            768: {
                margin: 10,
                stagePadding: 80,
                center: true,
            },
            1025: {
                margin: 40,
                stagePadding: 150,
            },
            1200: {
                dots: false,
                nav: true,
                margin: 60,
                stagePadding: 200,
            },
            1367: {
                margin: 80,
                stagePadding: 300,
            },
            1501: {

                margin: 90,
                stagePadding: 342,
            }
        }
    });
   

    /* promo section owl-carousel
    --------------------------------------------- */
    $('.promo-section .bttk-itw-holder').addClass('owl-carousel');
    $('.promo-section .bttk-itw-holder').owlCarousel({
        items: 3,
        margin: 30,
        autoplay: false,
        loop: true,
        rtl: rtl,
        nav: true,
        dots: false,
        autoplaySpeed: 800,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            1025: {
                items: 3,
                nav: true
            }
        }
    });

    /*  Scroll top
    --------------------------------------------- */
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 200) {
            $('.back-to-top').addClass('active');
        } else {
            $('.back-to-top').removeClass('active');
        }
    });

    $('.back-to-top').on('click', function () {
        $('body,html').animate({
            scrollTop: 0,
        }, 600);
    });

});
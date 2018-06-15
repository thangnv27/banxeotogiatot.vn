(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

var viewport_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
var viewport_height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
var TFunc = {
    setCookie: function (name, value, expires, path, domain, secure) {
        var today = new Date();
        today.setTime(today.getTime());
        var expires_date = new Date(today.getTime() + (expires));
        document.cookie = name + "=" + escape(value) + ((expires) ? ";expires=" + expires_date.toGMTString() : "") + ((path) ? ";path=" + path : "") + ((domain) ? ";domain=" + domain : "") + ((secure) ? ";secure" : "");
    },
    getCookie: function (name) {
        /*var re=new RegExp(Name+"=[^;]+", "i");             if (document.cookie.match(re))                  return decodeURIComponent(document.cookie.match(re)[0].split("=")[1]);              return null;*/
        var start = document.cookie.indexOf(name + "=");
        var len = start + name.length + 1;
        if ((!start) && (name != document.cookie.substring(0, name.length))) {
            return null;
        }
        if (start == -1) return null;
        var end = document.cookie.indexOf(";", len);
        if (end == -1) end = document.cookie.length;
        return unescape(document.cookie.substring(len, end));
    },
    deleteCookie: function (name, path, domain) {
        if (this.getCookie(name))
            document.cookie = name + "=" + ((path) ? ";path=" + path : "") + ((domain) ? ";domain=" + domain : "") + ";expires=Mon, 11-November-1989 00:00:01 GMT";
    },
    addEvent: function (obj, eventName, func) {
        if (obj.attachEvent) {
            obj.attachEvent("on" + eventName, func);
        }
        else if (obj.addEventListener) {
            obj.addEventListener(eventName, func, true);
        }
        else {
            obj["on" + eventName] = func;
        }
    }
};
var PPOFixed = {
    mainMenu:function(){
        var msie6 = jQuery.browser == 'msie' && jQuery.browser.version < 7;
        if (!msie6) {
            var top = jQuery('.top-nav').offset().top - parseFloat(jQuery('.top-nav').css('margin-top').replace(/auto/, 0));
            jQuery(window).scroll(function(event){
                if (jQuery(this).scrollTop() >= top){
                    var wpadminbar_height = 0;
                    if(jQuery(this).width() > 583){
                        wpadminbar_height = jQuery('#wpadminbar').outerHeight(true);
                    }
                    jQuery('.desktop-header').css({
                        'top':wpadminbar_height - 1
                    }).addClass('fixed');
                } else {
                    jQuery('.desktop-header').css({
                        'top':0
                    }).removeClass('fixed');
                }
            });
        }
    },
    columns: function (col) {
        var summaries = jQuery(col);
        summaries.each(function (i) {
            var summary = jQuery(summaries[i]);
            var next = summaries[i + 1];
            var margin_top = jQuery('#wpadminbar').outerHeight(true);
            if(is_fixed_menu){
                margin_top += jQuery(".desktop-header").outerHeight(true) - jQuery(".top-head").outerHeight(true) - 20;
            }

            summary.scrollToFixed({
                marginTop: margin_top,
                limit: function () {
                    var limit = 0;
                    if (next) {
                        limit = jQuery(next).offset().top - jQuery(this).outerHeight(true) - 10;
                    } else {
                        if(jQuery("#home_gallery").length > 0){
                            limit = jQuery('#home_gallery').offset().top - jQuery(this).outerHeight(true) - 10;
                        } else if(jQuery("#other_products").length > 0){
                            limit = jQuery('#other_products').offset().top - jQuery(this).outerHeight(true) - 10;
                        } else if(jQuery("#before_footer").length > 0){
                            limit = jQuery('#before_footer').offset().top - jQuery(this).outerHeight(true) - 10;
                        } else {
                            limit = jQuery('#footer').offset().top - jQuery(this).outerHeight(true) - 10;
                        }
                    }
                    return limit;
                },
                zIndex: 998
            });
        });
    }
};
function getChromeVersion() {
    var raw = navigator.userAgent.match(/Chrom(e|ium)\/([0-9]+)\./);
    return raw ? parseInt(raw[2], 10) : false;
}
function getFirefoxVersion() {
    var raw = navigator.userAgent.match(/Firefox\/([0-9]+)/);
    return raw ? parseInt(raw[1], 10) : false;
}
function ReplaceAll(Source, stringToFind, stringToReplace) {
    var temp = Source;
    var index = temp.indexOf(stringToFind);
    while (index != -1) {
        temp = temp.replace(stringToFind, stringToReplace);
        index = temp.indexOf(stringToFind);
    }
    return temp;
}
function scrollToElement(id) {
    jQuery('body,html').animate({
        scrollTop: jQuery(id).offset().top - 10
    }, 800);
}
function swap(link) {
    document.querySelector('a.woocommerce-main-image').href = link.href;
    document.querySelector('img.attachment-shop_single').src = link.href;
    document.querySelector('img.attachment-shop_single').srcset = link.href + " 600w, " + link.href + " 150w, " + link.href + " 150w";
}
jQuery(document).ready(function ($) {
    // Popup
    if(TFunc.getCookie('t-popup') !== '1' && is_product){
        setTimeout(function (){
            jQuery("#myModal").modal();
            TFunc.setCookie('t-popup', 1, 60 * 60 * 1000 * 24, '/', '', ''); // 24 hours
        }, 2 * 1000); // seconds
    }
    
    if(is_fixed_menu){
        PPOFixed.mainMenu();
    }
    if(viewport_width > 991 && jQuery("#sidebar").height() < jQuery("#sidebar").prev().height()){
        if(is_product){
            if(viewport_width > 1199){
                PPOFixed.columns(jQuery("#sidebar .widget").get(jQuery("#sidebar .widget").length - 1));
            }
        } else {
            PPOFixed.columns(jQuery("#sidebar .widget").get(jQuery("#sidebar .widget").length - 1));
        }
    }
    
    jQuery(".menu-search .icon-search").click(function () {
        if (jQuery(".menu-search .search-tooltip").is(":hidden")) {
            jQuery(".menu-search .search-tooltip").addClass('bounceIn animated').show();
            jQuery(".menu-search .search-tooltip input[name=s]").focus();
            setTimeout(function () {
                jQuery(".menu-search .search-tooltip").removeClass('bounceIn animated');
            }, 1000);
        } else {
            jQuery(".menu-search .search-tooltip").hide();
        }
    });

    // Scroll to element - desktop
    jQuery(".main-menu > .nav > li > a, .btn-reg, .header-buttons a").click(function (){
        var _href = jQuery(this).attr('href');
        if(_href.lastIndexOf("#") !== -1){
            var _id = _href.split("#");
            if(jQuery('.desktop-header').hasClass('fixed')){
                jQuery('body,html').animate({
                    scrollTop: jQuery("#" + _id[1]).offset().top - jQuery('.top-nav').height() - jQuery("#wpadminbar").outerHeight(true)
                }, 400);
            } else {
                jQuery('body,html').animate({
                    scrollTop: jQuery("#" + _id[1]).offset().top - (jQuery('.top-nav').height() * 2) - jQuery("#wpadminbar").outerHeight(true)
                }, 400);
            }
            return false;
        }
    });
    // Scroll to element - mobile
    jQuery(".st-menu > .nav > li > a").click(function (){
        var _href = jQuery(this).attr('href');
        if(_href.lastIndexOf("#") !== -1){
            var _id = _href.split("#");
            jQuery('body,html').animate({
                scrollTop: jQuery("#" + _id[1]).offset().top - jQuery('.mobile-header').height()
            }, 400);
            jQuery('button.left-menu').trigger('click');
            return false;
        }
    });
    // Scroll to element - page builder
    jQuery(".page-builder a").click(function (){
        var _href = jQuery(this).attr('href');
        if(_href.lastIndexOf("#") !== -1){
            var _id = _href.split("#");
            if(viewport_width > 991){
                jQuery('body,html').animate({
                    scrollTop: jQuery("#" + _id[1]).offset().top - (jQuery('.top-nav').height() * 2) - jQuery("#wpadminbar").outerHeight(true)
                }, 400);
            } else {
                jQuery('body,html').animate({
                    scrollTop: jQuery("#" + _id[1]).offset().top - jQuery('.mobile-header').height()
                }, 400);
            }
            return false;
        }
    });
    
    jQuery(document).mouseup(function (e) {
        if (viewport_width < 992) {
            var container = jQuery(".st-container");
            if (container.find('.mobile-header').hasClass('mobile-clicked')) {
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    jQuery('button.left-menu').trigger('click');
                }
            }
        }
        
        var menu_search = jQuery(".menu-search .search-tooltip");
        if (!menu_search.is(e.target) && menu_search.has(e.target).length === 0) {
            menu_search.hide();
        }
    });

    if(window.location.hash.length > 0 && window.location.hash.indexOf('&') === -1 && 
        window.location.hash.indexOf('=') === -1 && jQuery(window.location.hash).length > 0){
        if(viewport_width > 991){
            jQuery('body,html').animate({
                scrollTop: jQuery(window.location.hash).offset().top - (jQuery('.top-nav').height()*2) - jQuery("#wpadminbar").outerHeight(true)
            }, 400);
        } else {
            jQuery('body,html').animate({
                scrollTop: jQuery(window.location.hash).offset().top - (jQuery('.mobile-header').height()*2)
            }, 400);
        }
        window.history.pushState("", document.title, window.location.pathname);
    }

    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 120) {
            jQuery("#scroll-to-top").fadeIn();
        } else {
            jQuery("#scroll-to-top").fadeOut();
        }
    });
    jQuery("#scroll-to-top").click(function () {
        jQuery('body,html').animate({
            scrollTop: 0
        }, 400);
        return false;
    });

    // Expand/Collapse mobile menu
    jQuery(".st-menu .nav li.menu-item-has-children > ul.sub-menu").hide();
    jQuery(".st-menu .nav li.menu-item-has-children.current-menu-item > ul.sub-menu").show();
    jQuery(".st-menu .nav li.menu-item-has-children.current-menu-parent > ul.sub-menu").show();
    jQuery(".st-menu .nav > li.menu-item-has-children").addClass('dropdown');
    jQuery(".st-menu .nav > li.menu-item-has-children.current-menu-item").removeClass('dropdown');
    jQuery(".st-menu .nav > li.menu-item-has-children.current-menu-parent").removeClass('dropdown');
    jQuery(".st-menu .nav > li.menu-item-has-children > a").after('<span class="arrow"></span>');
    jQuery(".st-menu .nav > li.menu-item-has-children").find('span.arrow').click(function () {
        if (!jQuery(this).parent().hasClass('dropdown')) {
            jQuery(this).parent().addClass('dropdown');
            jQuery(this).next().slideUp();
        } else {
            jQuery(this).parent().removeClass('dropdown');
            jQuery(this).next().slideDown();
        }
    });

    // Menu mobile
    jQuery('button.left-menu').click(function () {
        var effect = jQuery(this).attr('data-effect');
        if (jQuery(this).parent().parent().hasClass('mobile-clicked')) {
            jQuery('.st-menu').animate({
                width: 0
            }).css({
                display: 'none',
                transform: 'translate(0px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery(this).parent().parent().addClass('mobile-unclicked').removeClass('mobile-clicked').css({
                transform: 'translate(0px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery(this).parent().parent().parent().removeClass('st-menu-open ' + effect);
            jQuery("#ppo-overlay").hide();
        } else {
            jQuery(this).parent().parent().parent().addClass('st-menu-open ' + effect);
            jQuery('.st-menu').animate({
                width: 150
            }).css({
                display: 'block',
                transform: 'translate(150px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery(this).parent().parent().addClass('mobile-clicked').removeClass('mobile-unclicked').css({
                transform: 'translate(150px, 0px)',
                transition: 'transform 400ms ease 0s'
            });
            jQuery("#ppo-overlay").show();
        }
    });
    jQuery("#ppo-overlay").click(function (){
        if (jQuery(".st-container").find('.mobile-header').hasClass('mobile-clicked')) {
            jQuery('button.left-menu').trigger('click');
        }
    });
    jQuery("#search").focusin(function () {
        jQuery(this).prev().hide();
    });
    jQuery("#search").focusout(function () {
        jQuery(this).prev().show();
    });
    jQuery('button.right-menu').click(function () {
        window.location = mob_reg_url;
    });
    
    // Fixed Footer
    if(jQuery('body').outerHeight() < jQuery(window).height()){
        jQuery("#footer").addClass('fixed');
    }
    
    // Images Carousel fullwidth
    if (jQuery(".wpb_images_carousel").hasClass('fullwidth')) {
        jQuery(".wpb_images_carousel.fullwidth").parent().parent().css({
            'padding-left': '0px',
            'padding-right': '0px'
        });
        jQuery(".wpb_images_carousel.fullwidth").parent().parent().parent().css({
            width: '100%',
            'max-width': '100%',
            'padding-left': '0px',
            'padding-right': '0px'
        });
        jQuery(".wpb_images_carousel.fullwidth .vc_item img").each(function () {
            if (jQuery(this).width() < jQuery(window).width()) {
                jQuery(this).css({
                    width: '100%'
                });
            }
        });
    }

    // Featured Carousel
    if(jQuery(".featured-carousel").length > 0){
        jQuery(".featured-carousel").owlCarousel({
            autoplay: true,
            autoplayHoverPause: true,
            loop: true,
            margin: 0,
            responsiveClass: true,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            items: 1
        });
    }

    // Gallery slide
    if(jQuery('.gallery-widget .owl-carousel').length > 0){
        jQuery('.gallery-widget .owl-carousel').show().owlCarousel({
            autoplay: false,
            autoplayHoverPause: true,
            loop: true,
            margin: 30,
            navRewind: false,
            nav: true,
            navText: ['',''],
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                420: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });
    }
    
    // Gallery fancybox
    jQuery(".fancybox").fancybox({
        openEffect	: 'none',
        closeEffect	: 'none'
    });
    
    // Recent posts slide
    if(jQuery('.recent-posts-widget .owl-carousel').length > 0){
        jQuery('.recent-posts-widget .owl-carousel').show().owlCarousel({
            autoplay: false,
            autoplayHoverPause: true,
            loop: true,
            margin: 30,
            navRewind: false,
            nav: true,
            navText: ['',''],
            dots: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                420: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1199: {
                    items: 4
                }
            }
        });
    }
    
    /* Tour details - gallery */
    if(jQuery('#gallery_slider').length > 0){
        jQuery('#gallery_nav').show().flexslider({
            animation: "slide",
            controlNav: false,
            prevText: "",
            nextText: "",
            animationLoop: false,
            slideshow: false,
            itemWidth: 85,
            itemMargin: 10,
            asNavFor: '#gallery_slider'
        });
        jQuery('#gallery_slider').show().flexslider({
            animation: "slide",
            controlNav: false,
            prevText: "",
            nextText: "",
            animationLoop: false,
            slideshow: false,
            sync: "#gallery_nav"
        });

        jQuery(".product-gallery__trigger").click(function (){
            var pswpElement = document.querySelectorAll('.pswp')[0];
            
            // build items array
            var items = [];
            if (jQuery("#gallery_slider .slides li").length > 0) {
                jQuery("#gallery_slider .slides li").each(function (i, el) {
                    var img = jQuery(el).find('img'),
                        large_image_src = img.attr('data-large_image'),
                        large_image_w = img.attr('data-large_image_width'),
                        large_image_h = img.attr('data-large_image_height'),
                        item = {
                            src: large_image_src,
                            w: large_image_w,
                            h: large_image_h,
                            title: img.attr('alt')
                        };
                    items.push(item);
                });
            }

            // define options (if needed)
            var options = {
                // optionName: 'option value'
                // for example:
                index: 0, // start at first slide,
                closeOnScroll: false,
                pinchToClose: false
            };

            // Initializes and opens PhotoSwipe
            var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();

            return false;
        });
    }

    if (jQuery("#product-content-tabs").length > 0) {
        jQuery("#product-content-tabs").tabs();
    }
    
    // Popup form
    jQuery(".btn-req, .btn-regiser").click(function(){
        jQuery("#myModal").modal();
    });
});
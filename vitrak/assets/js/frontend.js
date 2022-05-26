(function ($) {
    'use strict';

    var get_url       = function (endpoint) {
            return ecotech_params.ecotech_ajax_url.toString().replace(
                '%%endpoint%%',
                endpoint
            );
        },
        get_cookie    = function (name) {

            var e, b, cookie = document.cookie, p = name + '=';

            if (!cookie) {
                return;
            }

            b = cookie.indexOf('; ' + p);

            if (b === -1) {
                b = cookie.indexOf(p);

                if (b !== 0) {
                    return null;
                }
            } else {
                b += 2;
            }

            e = cookie.indexOf(';', b);

            if (e === -1) {
                e = cookie.length;
            }

            return decodeURIComponent(cookie.substring(b + p.length, e));

        },
        set_cookie    = function (name, value, expires, path, domain, secure) {

            var d = new Date();

            if (typeof (expires) === 'object' && expires.toGMTString) {
                expires = expires.toGMTString();
            } else if (parseInt(expires, 10)) {
                d.setTime(d.getTime() + (parseInt(expires, 10) * 1000));
                expires = d.toGMTString();
            } else {
                expires = '';
            }

            document.cookie = name + '=' + encodeURIComponent(value) +
                              (expires ? '; expires=' + expires : '') +
                              (path ? '; path=' + path : '') +
                              (domain ? '; domain=' + domain : '') +
                              (secure ? '; secure' : '');

        },
        remove_cookie = function (name, path, domain, secure) {
            set_cookie(name, '', -1000, path, domain, secure);
        };

    var Mobile_Detect = {
        Mobile: function () {
            return navigator.userAgent.match(
                /(iPhone|iPod|Android|Phone|DROID|ZuneWP7|silk|BlackBerry|BB10|Windows Phone|Tizen|Bada|webOS|IEMobile|Opera Mini)/
            );
        },
        Tablet: function () {
            return navigator.userAgent.match(
                /(Tablet|iPad|Kindle|Playbook|Nexus|Xoom|SM-N900T|GT-N7100|SAMSUNG-SGH-I717|SM-T330NU)/
            );
        },
        any   : function () {
            return (Mobile_Detect.Mobile() || Mobile_Detect.Tablet());
        }
    };

    $(document).on('click', '.view-all-menu > a', function () {
        var button   = $(this),
            vertical = button.closest('.header-vertical'),
            items    = button.data('items'),
            open     = button.data('alltext'),
            close    = button.data('closetext'),
            menus    = vertical.find('ul.vertical-menu > li:nth-child(n+' + (items + 1) + ')');

        button.toggleClass('open-cate close-cate');

        if (button.hasClass('close-cate')) {
            button.html(close);
            menus.slideDown();
        } else {
            button.html(open);
            menus.slideUp();
        }

        return false;
    });

    /* AJAX TABS */
    $(document).on('click', '.ovic-tabs .tabs-list .tab-link, .ovic-accordion .panel-heading a', function (e) {
        e.preventDefault();
        var $this       = $(this),
            $data       = $this.data(),
            $tabID      = $($this.attr('href')),
            $tabItem    = $this.closest('.tab-item'),
            $tabContent = $tabID.closest('.tabs-container,.ovic-accordion'),
            $loaded     = $this.closest('.tabs-list,.ovic-accordion').find('a.loaded').attr('href');

        if ($data.ajax == 1 && !$this.hasClass('loaded')) {
            $tabContent.addClass('loading');
            $tabItem.addClass('active').closest('.tabs-list').find('.tab-item').not($tabItem).removeClass('active');
            $.ajax({
                type     : 'POST',
                url      : get_url('content_ajax_tabs'),
                data     : {
                    security: ecotech_params.security,
                    section : $data.section,
                },
                success  : function (response) {
                    $('[href="' + $loaded + '"]').removeClass('loaded');
                    if (response) {
                        $tabID.html(response);
                        if ($tabID.find('.owl-slick').length) {
                            $tabID.find('.owl-slick').ecotech_init_carousel();
                        }
                        if ($tabID.find('.elementor-section-slide').length) {
                            $tabID.find('.elementor-section-slide').ecotech_init_carousel();
                        }
                        if ($tabID.find('.equal-container.better-height').length) {
                            $tabID.find('.equal-container.better-height').ecotech_better_equal_elems();
                        }
                        if ($tabID.find('.ecotech-countdown').length && $.fn.ecotech_countdown) {
                            $tabID.find('.ecotech-countdown').ecotech_countdown();
                        }
                        if ($tabID.find('.ovic-products').length && $.fn.ecotech_load_infinite) {
                            $tabID.find('.ovic-products').ecotech_load_infinite();
                        }
                        if ($tabID.find('.yith-wcqv-button,.compare-button a.compare,.yith-wcwl-add-to-wishlist a').length) {
                            $tabID.find('.yith-wcqv-button,.compare-button a.compare,.yith-wcwl-add-to-wishlist a').ecotech_bootstrap_tooltip();
                        }
                    } else {
                        $tabID.html('<div class="alert alert-warning">' + ecotech_params.tab_warning + '</div>');
                    }
                    /* for accordion */
                    $this.closest('.panel-default').addClass('active').siblings().removeClass('active');
                    $this.closest('.ovic-accordion').find($tabID).slideDown(400);
                    $this.closest('.ovic-accordion').find('.panel-collapse').not($tabID).slideUp(400);
                },
                complete : function () {
                    $this.addClass('loaded');
                    $tabContent.removeClass('loading');
                    setTimeout(function ($tabID, $tab_animated, $loaded) {
                        $tabID.addClass('active').siblings().removeClass('active');
                        $tabID.animation_tabs($tab_animated);
                        $($loaded).html('');
                    }, 10, $tabID, $data.animate, $loaded);
                },
                ajaxError: function () {
                    $tabContent.removeClass('loading');
                    $tabID.html('<div class="alert alert-warning">' + ecotech_params.tab_warning + '</div>');
                }
            });
        } else {
            $tabItem.addClass('active').closest('.tabs-list').find('.tab-item').not($tabItem).removeClass('active');
            $tabID.addClass('active').siblings().removeClass('active');
            /* for accordion */
            $this.closest('.panel-default').addClass('active').siblings().removeClass('active');
            $this.closest('.ovic-accordion').find($tabID).slideDown(400);
            $this.closest('.ovic-accordion').find('.panel-collapse').not($tabID).slideUp(400);
            /* for animate */
            $tabID.animation_tabs($data.animate);
        }
    });
    /* ANIMATE */
    $.fn.animation_tabs             = function ($tab_animated) {
        $tab_animated = ($tab_animated === undefined || $tab_animated === '') ? '' : $tab_animated;
        if ($tab_animated !== '') {
            $(this).find('.owl-slick .slick-active, .product-list-grid .product-item').each(function (i) {
                var $this  = $(this),
                    $style = $this.attr('style'),
                    $delay = i * 200;

                $style = ($style === undefined) ? '' : $style;
                $this.attr('style',
                    $style +
                    ';-webkit-animation-delay:' + $delay + 'ms;' +
                    '-moz-animation-delay:' + $delay + 'ms;' +
                    '-o-animation-delay:' + $delay + 'ms;' +
                    'animation-delay:' + $delay + 'ms;'
                ).addClass($tab_animated + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $this.removeClass($tab_animated + ' animated');
                    $this.attr('style', $style);
                });
            });
        }
    };
    $.fn.ecotech_init_carousel      = function () {
        $(this).not('.slick-initialized').each(function () {
            var $this   = $(this),
                $config = $this.data('slick') !== undefined ? $this.data('slick') : [];

            if ($this.hasClass('flex-control-thumbs')) {
                $config = $this.closest('.single-product-wrapper').data('slick');
            }
            if ($this.hasClass('elementor-section-slide')) {
                $this = $this.children('.elementor-container');

                if ($this.children('.elementor-row').length) {
                    $this = $this.children('.elementor-row');
                }
                if ($this.hasClass('slick-initialized')) {
                    return false;
                }
            }
            if ($config.length <= 0) {
                return false;
            }
            if ($('body').hasClass('rtl')) {
                $config.rtl = true;
            }
            if ($config.vertical == true) {
                $config.prevArrow = '<span class="fa fa-angle-up prev"></span>';
                $config.nextArrow = '<span class="fa fa-angle-down next"></span>';
            } else {
                $config.prevArrow = '<span class="fa fa-angle-left prev"></span>';
                $config.nextArrow = '<span class="fa fa-angle-right next"></span>';
            }
            if ($this.hasClass('custom-dots')) {
                $config.customPaging = function (slider, i) {
                    var $thumb = $(slider.$slides[i]).data('thumb');
                    var $title = $(slider.$slides[i]).data('title');
                    return '<figure><img src="' + $thumb + '" alt="' + $title + '"></figure>';
                };
            }

            $this.slick($config);

            if ($this.hasClass('custom-dots')) {
                $this.find('.slick-dots').not('.slick-initialized').each(function () {
                    var $dots = {
                        slidesToShow : 3,
                        initialSlide : 1,
                        centerPadding: 0,
                        slidesMargin : 0,
                        infinite     : true,
                        centerMode   : true,
                        focusOnSelect: true,
                        dots         : true,
                        arrows       : false,
                    };

                    if ($('body').hasClass('rtl')) {
                        $dots.rtl = true;
                    }

                    $(this).slick($dots);
                });
            }
        });
    };
    $.fn.ecotech_better_equal_elems = function () {
        if (!Mobile_Detect.Mobile() && ecotech_params.disable_equal == false) {
            var $this = $(this);

            $this.on('ecotech_better_equal_elems', function () {
                setTimeout(function () {
                    $this.each(function () {
                        if ($(this).find('.equal-elem').length) {
                            $(this).find('.equal-elem').css({
                                'height': 'auto'
                            });
                            var $height = 0;
                            $(this).find('.equal-elem').each(function () {
                                if ($height < $(this).height()) {
                                    $height = $(this).height();
                                }
                            });
                            $(this).find('.equal-elem').height($height);
                        }
                    });
                }, 300);
            }).trigger('ecotech_better_equal_elems');

            $(window).on('resize', function () {
                $this.trigger('ecotech_better_equal_elems');
            });
        }
    };
    $.fn.ecotech_sticky_header      = function () {
        $(this).each(function () {
            var $this     = $(this),
                $sticky   = $this.find('.header-sticky'),
                $height   = $sticky.height(),
                $vertical = $this.find('.header-vertical .block-content').height();

            if (ecotech_params.sticky_menu == 'template') {
                $sticky = $('#header-sticky');
            }

            $(document).on('scroll', function (event) {
                var sh = $height,
                    st = $(this).scrollTop();

                if ($this.find('.header-vertical .block-content').length) {
                    sh = sh + $vertical;
                }

                if (st > sh) {
                    $sticky.addClass('is-sticky');
                } else {
                    $sticky.removeClass('is-sticky');
                    $('#header-sticky').find('.ecotech-dropdown.open').removeClass('open');
                }
            });
        });
    };
    /* DROPDOWN */
    $(document).on('click', function (event) {
        var $target  = $(event.target).closest('.ecotech-dropdown'),
            $current = $target.closest('.ecotech-parent-toggle'),
            $parent  = $('.ecotech-dropdown');

        if ($target.length) {
            $parent.not($target).not($current).removeClass('open');
            if ($(event.target).is('[data-ecotech="ecotech-dropdown"]') ||
                $(event.target).closest('[data-ecotech="ecotech-dropdown"]').length) {
                if ($target.hasClass('overlay')) {
                    if ($target.hasClass('open')) {
                        $('body').removeClass('active-overlay');
                    } else {
                        $('body').addClass('active-overlay');
                    }
                }
                $target.toggleClass('open');
                event.preventDefault();
            }
        } else {
            $('.ecotech-dropdown').removeClass('open');
            if ($target.hasClass('overlay') || !$target.length) {
                $('body').removeClass('active-overlay');
            }
        }
    });
    /* LOOP GALLERY IMAGE */
    $(document).on('click', '.product-item .product-loop-gallery a', function (event) {
        var $this     = $(this),
            $img      = $this.attr('data-image'),
            $index    = $this.attr('data-index'),
            $parent   = $this.closest('.product-item'),
            $slide    = $parent.find('.thumb-wrapper'),
            $main_img = $parent.find('.wp-post-image');

        if ($main_img) {
            if ($this.hasClass('dot-item') && $slide.length) {
                $slide.slick('slickGoTo', $index);
            } else {
                $main_img.attr('src', $img).attr('srcset', $img);
                $main_img.css({
                    '-webkit-transform' : 'scale(0.5)',
                    '-moz-transform'    : 'scale(0.5)',
                    '-ms-transform'     : 'scale(0.5)',
                    '-o-transform'      : 'scale(0.5)',
                    'transform'         : 'scale(0.5)',
                    'opacity'           : '0',
                    '-webkit-transition': 'all 0.3s ease',
                    '-moz-transition'   : 'all 0.3s ease',
                    '-ms-transition'    : 'all 0.3s ease',
                    '-o-transition'     : 'all 0.3s ease',
                    'transition'        : 'all 0.3s ease',
                }).load(function () {
                    var image = $(this);
                    setTimeout(function () {
                        image.css({
                            '-webkit-transform' : 'scale(1)',
                            '-moz-transform'    : 'scale(1)',
                            '-ms-transform'     : 'scale(1)',
                            '-o-transform'      : 'scale(1)',
                            'transform'         : 'scale(1)',
                            'opacity'           : '1',
                            '-webkit-transition': 'all 0.3s ease',
                            '-moz-transition'   : 'all 0.3s ease',
                            '-ms-transition'    : 'all 0.3s ease',
                            '-o-transition'     : 'all 0.3s ease',
                            'transition'        : 'all 0.3s ease',
                        });
                    }, 300);
                });
            }
            $(this).addClass('gallery-active').siblings().removeClass('gallery-active');
        }

        event.preventDefault();
    });
    /* BUTTON TOOLTIP */
    $.fn.ecotech_bootstrap_tooltip = function () {
        if ($.fn.ovic_add_notify) {
            $(this).each(function () {
                var $this    = $(this),
                    $product = $this.closest('.product-item'),
                    $text    = $this.text(),
                    $place   = 'left';

                if ($('body').hasClass('rtl')) {
                    $place = 'right';
                }
                if ($product.length) {
                    if (
                        $product.hasClass('list') ||
                        $product.hasClass('style-02') ||
                        $product.hasClass('style-13') ||
                        $product.hasClass('style-16')
                    ) {
                        $this.tooltip({
                            trigger  : 'hover',
                            placement: 'top',
                            container: 'body',
                            title    : $text,
                        });
                    }
                    if (
                        $product.hasClass('style-01') ||
                        $product.hasClass('style-05') ||
                        $product.hasClass('style-06') ||
                        $product.hasClass('style-12')
                    ) {
                        $this.tooltip({
                            trigger  : 'hover',
                            placement: $place,
                            container: 'body',
                            title    : $text,
                        });
                    }
                }
            });
        }
    }
    /* TOGGLE WIDGET */
    $.fn.ovic_category_product = function () {
        $(this).each(function () {
            var $main = $(this);
            $main.find('.cat-parent').each(function () {
                if ($(this).hasClass('current-cat-parent')) {
                    $(this).addClass('show-sub');
                    $(this).children('.children').slideDown(400);
                }
                $(this).children('.children').before('<span class="carets"></span>');
            });
            $main.children('.cat-parent').each(function () {
                var curent = $(this).find('.children');
                $(this).children('.carets').on('click', function () {
                    $(this).parent().toggleClass('show-sub');
                    $(this).parent().children('.children').slideToggle(400);
                    $main.find('.children').not(curent).slideUp(400);
                    $main.find('.cat-parent').not($(this).parent()).removeClass('show-sub');
                });
                var next_curent = $(this).find('.children');
                next_curent.children('.cat-parent').each(function () {
                    var child_curent = $(this).find('.children');
                    $(this).children('.carets').on('click', function () {
                        $(this).parent().toggleClass('show-sub');
                        $(this).parent().parent().find('.cat-parent').not($(this).parent()).removeClass('show-sub');
                        $(this).parent().parent().find('.children').not(child_curent).slideUp(400);
                        $(this).parent().children('.children').slideToggle(400);
                    })
                });
            });
        });
    };
    /* QUANTITY */
    if (!String.prototype.getDecimals) {
        String.prototype.getDecimals = function () {
            var num   = this,
                match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            if (!match) {
                return 0;
            }
            return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
        };
    }
    $(document).on('click', '.quantity-plus, .quantity-minus', function (e) {
        e.preventDefault();
        // Get values
        var $qty       = $(this).closest('.quantity').find('.qty'),
            currentVal = parseFloat($qty.val()),
            max        = parseFloat($qty.attr('max')),
            min        = parseFloat($qty.attr('min')),
            step       = $qty.attr('step');

        if (!$qty.is(':disabled')) {
            // Format values
            if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
            if (max === '' || max === 'NaN') max = '';
            if (min === '' || min === 'NaN') min = 0;
            if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = '1';

            // Trigger change event
            $qty.trigger('change');
        }
    });
    /* UPDATE COUNT WISHLIST */
    $(document).on('added_to_wishlist removed_from_wishlist', function () {
        $.get(get_url('update_wishlist_count'), function (count) {
            if (!count) {
                count = 0;
            }
            $('.block-wishlist .count').text(count);
        });
    });

    $(document).on('click', '.action-to-top', function (e) {
        $('html, body').animate({scrollTop: 0}, 800);
        e.preventDefault();
    });

    if (ecotech_params.ajax_comment == 1) {
        $(document).on('click', '#comments .woocommerce-pagination a', function () {
            var $this        = $(this),
                $comment     = $this.closest('#comments'),
                $commentlist = $comment.find('.commentlist'),
                $pagination  = $this.closest('.woocommerce-pagination');

            $comment.addClass('loading');
            $.ajax({
                type   : 'GET',
                url    : $this.attr('href'),
                data   : {
                    ovic_raw_content: 1,
                },
                success: function (response) {
                    if (!response) {
                        return;
                    }
                    var $html    = $.parseHTML(response, document, true),
                        $nav     = $('#comments .woocommerce-pagination', $html).length ? $('#comments .woocommerce-pagination', $html)[0].innerHTML : '',
                        $content = $('#comments .commentlist', $html).length ? $('#comments .commentlist', $html)[0].innerHTML : '';

                    if ($content !== '') {
                        $commentlist.html($content);
                    }
                    $pagination.html($nav);
                    $comment.removeClass('loading');
                },
            });

            return false;
        });
    }

    $(document).on('click', '.scroll-content .scroll-prev', function (e) {

        event.preventDefault();

        var content = $(this).closest('.scroll-content'),
            type    = content.data('scroll'),
            mobile  = content.data('mobile'),
            step    = content.data('step') != undefined ? content.data('step') : '200',
            config  = {
                scrollLeft: '-=' + step + 'px'
            };

        if (type == 'vertical') {
            if (mobile == true && window.matchMedia("(max-width: 767px)").matches) {
                config = {
                    scrollLeft: '-=' + step + 'px'
                };
            } else {
                config = {
                    scrollTop: '-=' + step + 'px'
                };
            }
        }

        content.children('.scroll-list').animate(config, 'slow');

    });

    $(document).on('click', '.scroll-content .scroll-next', function (e) {

        event.preventDefault();

        var content = $(this).closest('.scroll-content'),
            type    = content.data('scroll'),
            mobile  = content.data('mobile'),
            step    = content.data('step') != undefined ? content.data('step') : '200',
            config  = {
                scrollLeft: '+=' + step + 'px'
            };

        if (type == 'vertical') {
            if (mobile == true && window.matchMedia("(max-width: 767px)").matches) {
                config = {
                    scrollLeft: '+=' + step + 'px'
                };
            } else {
                config = {
                    scrollTop: '+=' + step + 'px'
                };
            }
        }

        content.children('.scroll-list').animate(config, 'slow');

    });

    $(document).on('change', '#ecotech_disabled_popup_by_user', function () {
        if ($(this).is(':checked')) {
            set_cookie('ecotech_disabled_popup_by_user', 'true');
        } else {
            set_cookie('ecotech_disabled_popup_by_user', '');
        }
    });

    $(document).on('wc-product-gallery-after-init', function (event, gallery, params) {
        if ($(this).find('.flex-control-thumbs').length) {
            $(this).find('.flex-control-thumbs').ecotech_init_carousel();
        }
    });

    if ($('.woocommerce-product-gallery').attr("data-columns")) {
        $('.woocommerce-product-gallery').css({ '--columns' : $('.woocommerce-product-gallery').attr("data-columns") });
    }

    $(document).on('ovic_success_load_more_post', function (event, content) {
        if ($.fn.ecotech_bootstrap_tooltip && $(event.target).find('.yith-wcqv-button,.compare-button a.compare,.yith-wcwl-add-to-wishlist a').length) {
            $(event.target).find('.yith-wcqv-button,.compare-button a.compare,.yith-wcwl-add-to-wishlist a').ecotech_bootstrap_tooltip();
        }
        if ($(event.target).find('.owl-slick').length) {
            $(event.target).find('.owl-slick').ecotech_init_carousel();
        }
        if ($('.equal-container.better-height').length) {
            $('.equal-container.better-height').ecotech_better_equal_elems();
        }
    });

    $(document).on('scroll', function () {
        if ($(window).scrollTop() > 400) {
            $('.backtotop').addClass('show');
        } else {
            $('.backtotop').removeClass('show');
        }
    });

    $(document).on('click', '.overlay-body', function (e) {
        $('body').removeClass('ovic-open-mobile-menu');
        $('body').removeClass('open-header-settings');
        $('body').removeClass('open-mobile-sidebar');
        $('body').removeClass('open-header-minicart');
        $('.ovic-menu-clone-wrap').removeClass('open');
        e.preventDefault();
    });

    $(document).on('click', '.entry-summary-end .close-entry', function (e) {
        $(this).closest('.ecotech-dropdown').removeClass('open');
        $('body').removeClass('active-overlay');
        e.preventDefault();
    });

    $(document).on('click', '.open-sidebar', function () {
        $('body').addClass('open-mobile-sidebar');
        return false;
    });

    $(document).on('click', '.close-sidebar', function () {
        $('body').removeClass('open-mobile-sidebar');
        return false;
    });

    $(document).on('click', '.block-minicart.popup .woo-cart-link', function () {
        $('body').addClass('open-header-minicart');
        return false;
    });

    $(document).on('click', '.close-minicart', function () {
        $('body').removeClass('open-header-minicart');
        return false;
    });

    $(document).on('click', '.vertical-menu > .menu-item-has-children > .carets:not(:last-child), .vertical-menu > .menu-item > .sub-menu:not(.megamenu) .menu-item-has-children > .carets:not(:last-child)', function () {
        var menu_item = $(this).closest('.menu-item');
        menu_item.toggleClass('show-sub');
        if (menu_item.find('.sub-menu.megamenu .owl-slick').length) {
            menu_item.find('.sub-menu.megamenu .owl-slick').slick('setPosition');
        }
        return false;
    });

    $(document).on('wc_fragments_refreshed wc_fragments_loaded', function () {
        if ($('.woocommerce-mini-cart').length && $.fn.scrollbar) {
            $('.woocommerce-mini-cart').scrollbar({'ignoreMobile': true});
        }
    });

    $(document).on('updated_wc_div', function (event) {
        if ($(event.target).find('.cross-sells .owl-slick').length > 0) {
            $(event.target).find('.cross-sells .owl-slick').ecotech_init_carousel();
        }
    });

    $(document).ready(function () {
        $('.ovic-tabs').each(function (index, el) {
            $(this).find('.section-down').on('click', function (e) {
                if ($('.ovic-tabs').eq(index + 1).length == 1) {
                    $('html, body').animate({
                        scrollTop: $('.ovic-tabs').eq(index + 1).offset().top - 100
                    }, 'slow');
                }

                e.preventDefault();
            });
            $(this).find('.section-up').on('click', function (e) {
                if ($('.ovic-tabs').eq(index - 1).length == 1) {
                    $('html, body').animate({
                        scrollTop: $('.ovic-tabs').eq(index - 1).offset().top - 100
                    }, 'slow');
                }

                e.preventDefault();
            });
        });
    });

    $(document).ready(function () {
        if ($('.category-search-option').length) {
            $('.category-search-option').chosen();
            $('.category-search-option').on('change', function (event, value) {
                var $this  = $(this),
                    $form  = $this.closest('form'),
                    $input = $form.find('input[type="search"]');

                $input.removeData();

                if ('selected' in value) {
                    $input.attr('data-custom-params', JSON.stringify({"product_cat": value.selected}));
                }
            });
        }
    });

    window.addEventListener("load", function load() {
        /**
         * remove listener, no longer needed
         * */
        window.removeEventListener("load", load, false);
        /**
         * start functions
         * */
        if ($('.owl-slick').length) {
            $('.owl-slick').ecotech_init_carousel();
        }
        if ($('.elementor-section-slide').length) {
            $('.elementor-section-slide').ecotech_init_carousel();
        }
        if ($('.equal-container.better-height').length) {
            $('.equal-container.better-height').ecotech_better_equal_elems();
        }
        if ($('.shop-before-control select').length) {
            $('.shop-before-control select').chosen({disable_search_threshold: 10});
        }
        if ($('.widget_product_categories .product-categories').length) {
            $('.widget_product_categories .product-categories').ovic_category_product();
        }
        if ($('.ecotech-popup-newsletter').length && get_cookie('ecotech_disabled_popup_by_user') !== 'true' && $.fn.magnificPopup) {
            var popup  = document.getElementById('ecotech-popup-newsletter'),
                effect = popup.getAttribute('data-effect'),
                delay  = popup.getAttribute('data-delay');

            setTimeout(function () {
                $.magnificPopup.open({
                    items       : {
                        src: '#ecotech-popup-newsletter'
                    },
                    type        : 'inline',
                    removalDelay: 600,
                    callbacks   : {
                        beforeOpen: function () {
                            this.st.mainClass = effect;
                        }
                    },
                    midClick    : true
                });
            }, delay);
        }
        /**
         * check not mobile
         * */
        if (!Mobile_Detect.any()) {
            if ($('.header').length && ecotech_params.sticky_menu !== 'none' && window.matchMedia("(min-width: 1199px)").matches) {
                $('.header').ecotech_sticky_header();
            }
            if ($('.yith-wcqv-button,.compare-button a.compare,.yith-wcwl-add-to-wishlist a').length) {
                $('.yith-wcqv-button,.compare-button a.compare,.yith-wcwl-add-to-wishlist a').ecotech_bootstrap_tooltip();
            }
        }
        /* SCROLLBAR */
        if ($.fn.scrollbar) {
            if ($('.dokan-store-widget #cat-drop-stack > ul').length) {
                $('.dokan-store-widget #cat-drop-stack > ul').scrollbar({'ignoreMobile': true});
            }
            if ($('.widget-area .widget_product_categories .product-categories').length) {
                $('.widget-area .widget_product_categories .product-categories').scrollbar({'ignoreMobile': true});
            }
            if ($('.widget-area .widget_layered_nav .woocommerce-widget-layered-nav-list').length) {
                $('.widget-area .widget_layered_nav .woocommerce-widget-layered-nav-list').scrollbar({'ignoreMobile': true});
            }
            if ($('.widget-area .widget_layered_nav .group-color').length) {
                $('.widget-area .widget_layered_nav .group-color').scrollbar({'ignoreMobile': true});
            }
            if ($('.widget-area .widget_layered_nav .group-image').length) {
                $('.widget-area .widget_layered_nav .group-image').scrollbar({'ignoreMobile': true});
            }
            if ($('.widget-area .ovic-price-filter .price-filter-inner').length) {
                $('.widget-area .ovic-price-filter .price-filter-inner').scrollbar({'ignoreMobile': true});
            }
        }
    }, false);

    if (ecotech_params.is_preview) {
        //
        // Elementor scripts
        //
        $(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope, $) {
                $scope.find('.owl-slick').ecotech_init_carousel();
                $scope.find('.elementor-section-slide').ecotech_init_carousel();
                $scope.find('.equal-container.better-height').ecotech_better_equal_elems();
                if ($.fn.ecotech_countdown) {
                    $scope.find('.ecotech-countdown').ecotech_countdown();
                }
            });
        });
    }

})(window.jQuery);
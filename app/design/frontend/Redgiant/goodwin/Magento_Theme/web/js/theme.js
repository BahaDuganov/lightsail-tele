/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'mage/smart-keyboard-handler',
    'mage/loader',
    'mage/mage',
    'mage/ie-class-fixer',
    'jquery/jquery.cookie',
    'imagesloaded',
    'domReady!'
], function ($, keyboardHandler, loader) {
    'use strict';
    
    var GOODWIN = GOODWIN || {};

    if ($('body').hasClass('checkout-cart-index')) {
        if ($('#co-shipping-method-form .fieldset.rates').length > 0 &&
            $('#co-shipping-method-form .fieldset.rates :checked').length === 0
        ) {
            $('#block-shipping').on('collapsiblecreate', function () {
                $('#block-shipping').collapsible('forceActivate');
            });
        }
    }

    // $('.cart-summary').mage('sticky', {
    //     container: '#maincontent'
    // });

    $('.page-header div:not(.customer-menu) > .header.links').clone().appendTo('#store\\.links');

    $('a.links-mobile.link-search').on("click", function(event){
        event.stopPropagation();
        $('.dropdn_search > .dropdn-link').trigger("click");
    });

    keyboardHandler.apply();

    $.fn.extend({
        scrollToMe: function(){
            if($(this).length){
                var top = $(this).offset().top - 100;
                $('html,body').animate({scrollTop: top}, 600);
            }
        },
        scrollToJustMe: function(){
            if($(this).length){
                var top = $(this).offset().top;
                $('html,body').animate({scrollTop: top}, 600);
            }
        },
        noticeBlock: function (close) {
            var $notice_block = $(this),
                $close = $(close),
                speed = 300,
                timeout = 1000;

            function checkCookie() {
                if ($.cookie('goodwinNoticeBlock') != 'yes') {
                    setTimeout(function () {
                        $notice_block.slideDown(speed);
                    }, timeout);
                } else {
                    $notice_block.slideUp(0);
                }
            }

            $close.on('click', function () {
                $.cookie('goodwinNoticeBlock', 'yes', {
                    expires: parseInt($notice_block.attr('data-expires'), 10)
                });
                checkCookie();
            });
            checkCookie();
        },
        footerCollapse: function () {
            var $collapsed = this;
            $('.title', $collapsed).on('click', function (e) {
                e.preventDefault;
                $(this).closest('.collapsed-mobile').toggleClass('open');
            });
        },
        flowtype: function () {
            var $elem = $(this);
            var FlowType = {
                default: {
                    maximum: 9999,
                    minimum: 1,
                    maxFont: 9999,
                    minFont: 1
                },
                init: function () {
                    var that = this;
                    $elem.each(function () {
                        var $this = $(this);
                        window.setTimeout(function () {
                            var fontratio = Math.round($this.attr("data-fontratio") * 100) / 100;
                            if (fontratio > 0) {
                                that._changes($this, fontratio)
                            }
                        }, 500);
                    });
                },
                hide: function () {
                    var that = this;
                    $elem.each(function () {
                        $(this).removeClass('fontratio-calc');
                    });
                },
                reinit: function () {
                    var that = this;
                    $elem.each(function () {
                        var $this = $(this),
                            fontratio = Math.round($this.attr("data-fontratio") * 100) / 100;
                        $this.removeClass('fontratio-calc');
                        if (fontratio > 0) {
                            that._changes($this, fontratio)
                        }
                    });
                },
                _changes: function (el, fontRatio) {
                    var $el = $(el),
                        elw = $el.width(),
                        width = elw > this.default.maximum ? this.default.maximum : elw < this.default.minimum ? this.default.minimum : elw,
                        fontBase = width / fontRatio,
                        fontSize = fontBase > this.default.maxFont ? this.default.maxFont : fontBase < this.default.minFont ? this.default.minFont : fontBase;
                    $el.css('font-size', fontSize + 'px').addClass('fontratio-calc');
                }
            };
            return FlowType;
        }
    });

    $(".dropdn:not('.link-only') .dropdn-link").on("click", function(){
        $(".page-header .switcher div.active").removeClass("active");

        if(!$(this).parent().hasClass("active")) {
            $(".dropdn").removeClass("active");
            $(this).parent().addClass("active");
        } else {
            $(this).parent().removeClass("active");
        }
    });

    $(".dropdn").on("click", function(event){
        event.stopPropagation();
    });

    $(".page-header .switcher .switcher-trigger").on("click", function(){
        $(".dropdn").removeClass("active");
    });

    $(window).on("click", function() {
        $(".dropdn").removeClass("active");
    });

    $(".sidemenu-close").on("click", function(){
        $(".nav-toggle").trigger("click");
    });

    $(document).ready(function(){
        $(".page-loading").fadeOut("slow");
        $(".page-wrapper").fadeIn('slow');
        
        var $button = $('#totop'),
            windowH = $(window).height();
        if ($(window).scrollTop() > windowH / 2) {
            $button.addClass('is-visible');
        }
        $(window).scroll(function () {
            if ($(this).scrollTop() > windowH / 2) {
                $button.addClass('is-visible');
            } else {
                $button.removeClass('is-visible');
            }
        });
        
        $('.filter-current-subtitle').off('click').on('click', function(){
            $('.filter-current-subtitle').off('click').on('click', function(){
                var slidespeed = 250;
                var $this = $(this),
                    $thiscontent = $(this).siblings('.items');
                if ($this.parent().is('.open')) {
                    $this.parent().removeClass('open');
                    $thiscontent.slideUp(slidespeed);
                } else {
                    $this.parent().addClass('open');
                    $thiscontent.slideDown(slidespeed);
                }
            });
        });

        $('.bnr[data-fontratio]').flowtype().init();

        $('#totop').off("click").on("click",function(){
            $('html, body').animate({scrollTop: 0}, 600);
        });

        $(".navigation li > a[href*='#']").click(function(){
            if($($(this).attr("href")).length)
                $($(this).attr("href")).scrollToMe();
            else
                window.location.href=store_base_url + $(this).attr("href");
        });

        $(".promo-topline").noticeBlock(".promo-topline-close");

        $('.collapsed-mobile').footerCollapse();
    });
    $(window).on('resize',function(){
        $('.bnr[data-fontratio]').flowtype().hide();
        $('.bnr[data-fontratio]').flowtype().reinit();
    });
    $(document).on('click', '.btn-filter-toggle, .filter-close' , function (e) {
        $('body').toggleClass('sidebar-fixed');
        $('.sidebar-main').toggleClass('active');
        $('.block.filter .filtered-result .number').html($('.toolbar-amount .toolbar-number.totals').html());
    });
    $(document).on('touchstart click', '.gd-overlay', function (e) {
        if ($('.sidebar-main').hasClass('active')) {
            $('body').removeClass('sidebar-fixed');
            $('.sidebar-main').removeClass('active');
        }
    });
    $(document).on('click', '.qty-changer' , function (e) {
        var $this = $(this);
        var qty = parseInt($this.parent().find('input').val());
        if($this.is('.qty-inc')){
            qty ++;
        }else if($this.is('.qty-dec')) {
            if (qty == 1)
                return ;
            qty --;
        }
        $this.parent().parent().find('input').val(qty);
    });
    $('.goodwin-tabs').imagesLoaded( function() {
        $('.goodwin-tabs .tab-panel:not(".active")').hide();
        $('.goodwin-tabs .tab-nav a').on('click', function(){
            event.preventDefault();
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            $(this).parents('.goodwin-tabs').find('.tab-panel.active').hide();
            $(this).parents('.goodwin-tabs').find('.tab-panel.active').removeClass('active');
            $(this).parents('.goodwin-tabs').find($(this).attr('data-tabid')).show();
            $(this).parents('.goodwin-tabs').find($(this).attr('data-tabid')).addClass('active');
        });
    });
});
define(
    [
        'jquery',
        'fullpage'
    ],
    function ($,fullpage) {
        'use strict';

        return {
            init : function (container) {
                if ($(container).length) {
                    var doAnimations = function doAnimations(elements) {
                        $(elements).each(function () {
                            var $this = $(this);
                            var animationDelay = $this.data('animation-delay');
                            var animationType = 'animated ' + $this.data('animation');
                            $this.css({
                                'animation-delay': animationDelay,
                                '-webkit-animation-delay': animationDelay
                            });
                            $this.addClass(animationType);
                        });
                    };
                    $('.fullpage-section').each(function () {
                        var $this = $(this);
                        if (!$.trim($this.html()).length > 0) $this.remove();
                    });
                    var fullpageobj = new fullpage(container, {
                        licenseKey: '9472EE4F-F4F54BF6-815B4F05-9A29E818',
                        menu: '.hdr',
                        sectionSelector: '.fullpage-section',
                        slideSelector: '.fullpage-section-slide',
                        scrollOverflow: false,
                        navigation: true,
                        navigationPosition: 'right',
                        afterLoad: function afterLoad() {
                            doAnimations('.fullpage-section.active .load-animate');
                        }
                    });

                    var $lastSection = $(container).find('.fullpage-section').last(),
                        $footer = $('.page-footer');
                    $footer.detach().appendTo($lastSection);
                    $lastSection.find('.fp-tableCell').css({
                        'padding-bottom': $footer.outerHeight()
                    });
                }
            }
        }
    }
);
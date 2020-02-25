define(
    [
        'jquery',
        'slick',
    ],
    function ($) {
        'use strict';
        var step = 1;
        return {
            init : function (container) {
                var $this = $(container);
                $this.each(function(){
                    var options = {
                        slidesToShow    : 4,
                        slidesToScroll  : 2,
                        autoplay        : false,
                        autoplaySpeed   : 2000,
                        infinite        : false,
                        speed           : 500,
                        dots            : false,
                        arrows          : true,
                        responsive: [{
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                centerPadding: 0,
                            }
                        }, {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerPadding: 0,
                            }
                        }, {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerPadding: 0,
                            }
                        }]
                    }
                    if($(this).data('slick')){
                        var settings = $(this).data('slick');
                        for (var obj in settings) {
                            options[obj] = settings[obj];
                        }
                    }
                    if(options.slidesToShow < 3) {
                       options.responsive[0].settings.slidesToShow =  options.slidesToShow;
                    }
                    if ($(this).parent().find('.carousel-arrows').length) {
                        options.appendArrows = $(this).parent().find('.carousel-arrows');
                    }else if($(this).parents('.prod-carousel-wrapper').find('.carousel-arrows').length){
                        options.appendArrows = $(this).parents('.prod-carousel-wrapper').find('.carousel-arrows');
                    }
                    
                    if(!$(this).hasClass('slick-initialized'))
                        $(this).slick(options);
                });
            },
            insideCarousel: function (el) {
                var $carousel = this,
                    next = '.carousel-control.next',
                    prev = '.carousel-control.prev';
                // $carousel.carousel({
                //     interval: false
                // });
                $(document).on('click', next, function () {
                    $(el).carousel('next');
                });
                $(document).on('click', prev, function () {
                    $(el).carousel('prev');
                });
            }
        };
    }
);
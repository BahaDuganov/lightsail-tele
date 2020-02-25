define(
    [
        'jquery',
    ],
    function ($) {
        'use strict';
        var TimeLine = {
            options: {
                timeLine: '.timeLine',
                leftCol: 'timeLine-left',
                rightCol: 'timeLine-right',
                item: 'timeLine-item',
                oneColBreikpoint: 600
            },
            init: function (options) {
                $.extend(this.options, options);
                var isMobile = (window.innerWidth || $window.width()) < this.options.oneColBreikpoint;
                isMobile ? TimeLine._oneCol() : TimeLine._twoCol();
                var timeLine = this.options.timeLine
                setTimeout(function () {
                    $(timeLine).addClass('loaded');
                }, 1000)
            },
            reinit: function (windowW) {
                var windowW = windowW ? windowW : (window.innerWidth || $(window).width()),
                    isMobile = windowW < this.options.oneColBreikpoint;
                isMobile ? TimeLine._oneCol() : TimeLine._twoCol();
            },
            _oneCol: function () {
                var timeLine = this.options.timeLine,
                    leftCol = '.' + this.options.leftCol,
                    rightCol = '.' + this.options.rightCol,
                    item = '.' + this.options.item;
                if ($(timeLine).hasClass('timeLine--twocols')) {
                    $(leftCol).children().detach().appendTo(timeLine);
                    $(rightCol).children().detach().appendTo(timeLine);
                    $(leftCol).remove();
                    $(rightCol).remove();
                    $(timeLine).removeClass('timeLine--twocols');

                    function sortItem(a, b) {
                        return ($(b).data('order')) < ($(a).data('order')) ? 1 : -1;
                    }

                    $(item).sort(sortItem).appendTo(timeLine);
                } else {
                    return this;
                }
            },
            _twoCol: function () {
                var $timeLine = $(this.options.timeLine),
                    leftCol = '.' + this.options.leftCol,
                    rightCol = '.' + this.options.rightCol,
                    item = '.' + this.options.item;
                if ($timeLine.hasClass('timeLine--twocols')) {
                    return this;
                } else {
                    $(item, $timeLine).each(function (index, obj) {
                        var $this = $(this);
                        $this.attr('data-order', index);
                        (index % 2 === 0) ? $this.attr('data-col', 'left') : $this.attr('data-col', 'right');
                    })
                    $timeLine.addClass('timeLine--twocols');
                    $timeLine.append("<div class=" + this.options.leftCol + "></div>");
                    $timeLine.append("<div class=" + this.options.rightCol + "></div>");
                    $('[data-col="left"]', $timeLine).each(function () {
                        $(this).detach().appendTo(leftCol)
                    })
                    $('[data-col="right"]', $timeLine).each(function () {
                        $(this).detach().appendTo(rightCol)
                    })
                    return this;
                }
            }
        }
        return {
            init : function () {
                var timeline  = Object.create(TimeLine);
                timeline.init();
            }
        };
    }
);
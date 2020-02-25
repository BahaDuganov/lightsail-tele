/**
 */

define(
    [
        'jquery'
    ],
    function ($) {
        'use strict';

        return {
            /**
             * Start full page loader action
             */
            startLoader: function () {
                $('.loader-wrap').css('opacity', '1');
                $('.loader-wrap').css('pointer-events','all');
            },

            /**
             * Stop full page loader action
             */
            stopLoader: function () {
                $('.loader-wrap').css('opacity', '0');
                $('.loader-wrap').css('pointer-events','none');
                $('.swatch-option-tooltip').hide();
            }
        };
    }
);

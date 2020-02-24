define([
    'jquery'
], function ($) {
    'use strict';
    $.fn.rg_dailydeal_init = function( countdown, currentdate ) {
        var _second = 1000;
        var _minute = _second * 60;
        var _hour = _minute * 60;
        var _day = _hour * 24;
        var timer;

        //Set date as magentodatetime 
        var date = new Date(currentdate);
        var l_date = new Date();
        var offset_date = l_date - date;

        function timer_func() {
            $(countdown).each(function(){
                var enddate = new Date($(this).data("to-date"));
                var currentdate=new Date();

                //Get Difference between Two dates
                var distance = enddate - (currentdate - offset_date);
                
                $(this).show();

                if (distance < 0) {
                    $(this).find('.expired').html("<span style='font-size:25px; color:#000;'>EXPIRED!<span>");
                } else {
                    var days = Math.floor(distance / _day);
                    var hours = Math.floor((distance % _day) / _hour);
                    var minutes = Math.floor((distance % _hour) / _minute);
                    var seconds = Math.floor((distance % _minute) / _second);

                    if(hours < 10)
                        hours = "0" + hours;
                    if(minutes < 10)
                        minutes = "0" + minutes;
                    if(seconds < 10)
                        seconds = "0" + seconds;

                    $(this).find('.countdowncontainer').show();
                    $(this).find('.number.day span').html(days);
                    $(this).find('.number.hour span').html(hours);
                    $(this).find('.number.min span').html(minutes);
                    $(this).find('.number.sec span').html(seconds);
                }
            });
        }

        function init() {
            setInterval(function() {
                timer_func();
            }, 1000); 
        }
        
        init();
    }
});
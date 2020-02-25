define([
    'jquery',
    'jquery/ui',
    'mage/loader'],
function ($) {

    $.widget('goodwin.loader', $.mage.loader, {
        options: {
            texts: {
                loaderText: $.mage.__('Goodwin')
            },
            template:
                '<div>Goodwin Loader</div>'
        }
    });

    return $.goodwin.loader;
});
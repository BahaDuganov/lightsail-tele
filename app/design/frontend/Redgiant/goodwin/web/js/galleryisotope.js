define(
    [
        'jquery', 'jquery-bridget', 'isotope' , 'imagesloaded', 'fancybox'
    ],
    function ($, jqBridget, Isotope) {
        'use strict';

        jqBridget( 'isotope', Isotope, $ ); 

        var GalleryIsotope = {
            data: {
                gallery: '.js-gallery-isotope',
                galleryItem: '.gallery-item',
                filtersList: '.js-filters-gallery',
                filtersLabel: '.filters-label',
                filtersCount: '.filters-label-count',
                activeClass: 'active',
                dataAttr: 'data-filter',
                layoutMode: 'fitRows',
                popupImage: '[data-fancybox="gallery"]',
                currentFilter: ''
            },
            init: function (options) {
                $.extend(this.data, options);
                this._galleryInit(this);
                this._filters(this);
                this._popup(this);
            },
            reinit: function () {
                var $gallery = $(obj.data.gallery);
                $gallery.isotope();
                return this;
            },
            _galleryInit: function (obj) {
                var $gallery = $(obj.data.gallery);
                $gallery.imagesLoaded(function () {
                    $gallery.isotope({
                        itemSelector: obj.data.galleryItem,
                        layoutMode: obj.data.layoutMode,
                        percentPosition: true,
                        filter: function () {
                            var filterResult = obj.data.currentFilter ? $(this).is(obj.data.currentFilter) : true;
                            return filterResult;
                        }
                    });
                    $gallery.isotope();
                    $gallery.find('.has-loader').addClass('loaded');
                });
                return this;
            },
            _popup: function (obj) {
                $('[data-fancybox]').fancybox({
                    touch: false,
                    buttons: ["close"]
                })
                var $popupImage = $(obj.data.gallery + ' ' + obj.data.popupImage);
                if ($popupImage.length) {
                    $popupImage.fancybox({
                        touch: false,
                        buttons: ["close"]
                    })
                }
                return this;
            },
            _filters: function (obj) {
                var activeStart,
                    $gallery = $(obj.data.gallery),
                    $filtersList = $(obj.data.filtersList, $gallery.closest('.holder')),
                    $filtersLabel = $(obj.data.filtersList + ' ' + obj.data.filtersLabel),
                    activeClass = obj.data.activeClass,
                    dataAttr = obj.data.dataAttr;
                $filtersLabel.each(function () {
                    var $this = $(this);
                    var filtered = $this.attr(dataAttr),
                        count = (filtered == null) ? $gallery.find(obj.data.galleryItem).length : $gallery.find(filtered).length;
                    $this.find(obj.data.filtersCount).html(count);
                    if ($this.hasClass(activeClass)) {
                        activeStart = true;
                        obj.data.currentFilter = $this.attr(dataAttr);
                        $gallery.isotope();
                    }
                });
                if (!activeStart) $(obj.data.filtersList + ' ' + obj.data.filtersLabel + ':first-child').addClass(activeClass);
                $filtersLabel.on('click', function (e) {
                    e.preventDefault();
                    var $this = $(this);
                    if ($this.hasClass(activeClass)) return false;
                    else {
                        $filtersLabel.removeClass(activeClass);
                        $this.addClass(activeClass)
                    }
                    obj.data.currentFilter = $this.attr(dataAttr);
                    $gallery.isotope();
                });
            }
        }
        return {
            init : function () {
                var gallery = Object.create(GalleryIsotope);
			    gallery.init({});
            }
        };
    }
);
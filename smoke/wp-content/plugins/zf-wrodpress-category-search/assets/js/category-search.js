/**
 * jQuery ZT WordPress Category Search  plugin
 * @version    2.3
 * @author     ZuFusion
 * @copyright  Copyright (C) 2021 ZuFusion.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * Websites: http://www.zufusion.com
 */

(function ($) {

    "use strict";

    function ZFCategorySearch(element, options) {

        this.element = element;
        this.$elem = $(this.element);
        this.options = $.extend({}, this.defaults, options);
        this.catType = $('#cat_type', this.element).val();
        this.init();

    }

    ZFCategorySearch.prototype = {

        defaults: {
            title: '',
            displayCatType: 'tabs', // tabs,dropdown,radio
            tabPrevClass: 'zf-control-prev',
            tabNextClass: 'zf-control-next',
            tabAlignment: '', // tab-left, tab-center, tab-right
            dropdownWidth: '200',
            dropdownPlaceholder: 'Select category',
            dropdownSelectAllText: 'All Categories',
            minumimCountSelected: 0,
            showSubCategories: 1,
            enableAutoSuggest: 1,
            matchType:'+',
            limitSuggest: 10
        },

        init: function () {

            var $this = this;
            var inputCat = $('#form-search', $this.element).find('#cats');
            if (inputCat.length > 0) {
                if ($this.options.displayCatType == 'dropdown') {

                    // init dropdown list
                    var dropCat = $('.dropdown-categories', $this.element).multipleSelect({
                        single: false,
                        selectAll: true,
                        width: 'auto',
                        minWidth: '180',
                        maxHeight: 'auto',
                        filter: false,
                        displayValues: false,
                        minumimCountSelected:$this.options.minumimCountSelected,
                        delimiter: ', ',
                        textTemplate: function ($elm) {
                            return '<span></span>' + $elm.text();
                        },
                        placeholder: $this.options.dropdownPlaceholder,
                        selectAllText: $this.options.selectAllText,
                        onCheckAll: function () {
                            inputCat.val('');
                        },
                        onUncheckAll: function () {
                            inputCat.val('');
                        },
                        onClick: function (view) {
                            var vals = dropCat.multipleSelect('getSelects').join($this.options.matchType);
                            inputCat.val(vals);
                        }
                    });

                    if (inputCat.val() != '') {
                        var defaultValues = inputCat.val().split($this.options.matchType);
                        dropCat.multipleSelect('setSelects', defaultValues);
                    }

                } else {

                    var ulCheckBox = $('.checkbox-categories', $this.element);
                    var subCategoriesText = $('.subcategories-label', $this.element);

                    var strCats = inputCat.val();

                    // init for active parent category
                    var iniSubcategories = function () {

                        ulCheckBox.find('input[type="checkbox"]').on('change', function () {

                            var $checkbox = $(this);
                            if ($checkbox.is(':checked')) {
                                strCats += $this.options.matchType + $checkbox.val();
                            } else {
                                strCats = strCats.replace($this.options.matchType + $checkbox.val(), '');
                            }

                            inputCat.val(strCats);

                        });

                    }

                    if ($this.options.displayCatType == 'tabs') {

                        var slideW = 0, count = 0, total = 0;
                        $this.divWrapper = $('.tabs-wrapper', $this.element);
                        $this.tabsNavigation = $('ul.tabs-navigation', $this.element);
                        $this.wrapperW = $this.divWrapper.width();
                        $this.tabsNavigationH = $this.tabsNavigation.find('li.tab-nav').first().height() + 26;
                        $this.tabLeftStatus = false;
                        $this.tabRightStatus = true;

                        $this.tabsNavigation.find('li.tab-nav').each(function () {

                            var liWidth = $(this).width() + 70;
                            slideW += liWidth;
                            $(this).attr('data-wd', liWidth);
                        });

                        $this.sliderUlW = slideW;
                        if ($this.sliderUlW > $this.wrapperW) {

                            $this.tabsNavigation.removeClass($this.options.tabAlignment);
                            $this.divWrapper.attr('style', '');

                            $this.tabsNavigation.css({ width: $this.sliderUlW, height: $this.tabsNavigationH });

                            var prev = $('<span/>', {class: $this.options.tabPrevClass + ' zf-disabled'});
                            var next = $('<span/>', {class: $this.options.tabNextClass});

                            prev.on('click', function () {

                                if ($this.tabLeftStatus == false) {
                                    return false;
                                } else {
                                    total += parseInt($this.tabsNavigation.find('li').eq(count - 1).attr('data-wd'));
                                    count--;
                                    $this.moveLeft(prev, total, next);
                                }

                            });

                            next.on('click', function () {

                                if ($this.tabRightStatus == false) {
                                    return false;
                                } else {
                                    total -= parseInt($this.tabsNavigation.find('li').eq(count).attr('data-wd'));
                                    count++;
                                    $this.moveRight(prev, total, next);
                                }

                            });

                            $this.divWrapper.prepend(next);
                            $this.divWrapper.prepend(prev);

                        } else {
                            $this.divWrapper.attr('style', 'background: transparent !important');
                        }
                        // show tabs when processing done
                        $this.divWrapper.css({visibility: 'visible'});

                        iniSubcategories();

                        $this.tabsNavigation.find('li.tab-nav').on('click', function (e) {
                            e.preventDefault();
                            if (!$(this).hasClass('zf-current')) {
                                strCats = '';
                                var catID = $(this).attr('data-cat');
                                var catSlug = $(this).attr('data-slug');
                                $this.tabsNavigation.find('li.tab-nav').removeClass('zf-current');
                                $(this).addClass('zf-current');

                                checkChildByID(catID, catSlug);
                            } else {
                                return false;
                            }

                        });

                    } else if ($this.options.displayCatType == 'radio') {

                        iniSubcategories();

                        $('.radio-categories', $this.element).find('input[name="radio"]').on('change', function (e) {
                            e.preventDefault();
                            strCats = '';
                            var catID = $(this).val();
                            var catSlug = $(this).attr('data-slug');
                            checkChildByID(catID, catSlug);

                        });

                    }

                    var checkChildByID = function (catID, catSlug) {

                        subCategoriesText.hide();
                        ulCheckBox.empty();

                        if (catID != '') {

                            inputCat.val(catSlug);
                            strCats += catSlug;
                            // check child category
                            var data = {
                                action: 'get_child_category_url',
                                id: catID,
                                cat_type: $this.catType
                            };

                            if ($this.options.showSubCategories == 1) {

                                $.ajax({
                                    url: zfwcs_ajaxurl,
                                    type: 'POST',
                                    //dataType: 'json',
                                    data: data,
                                    beforeSend: function () {
                                        $('.zf-loading', $this.element).show();
                                    },
                                    success: function (data) {

                                        if (data != '') {
                                            ulCheckBox.append(data);
                                            // init subcategories
                                            iniSubcategories();
                                            subCategoriesText.show();
                                        } else {
                                            ulCheckBox.empty();
                                        }

                                        $('.zf-loading', $this.element).hide();

                                    }
                                });
                            }

                        } else {

                            ulCheckBox.empty();
                            inputCat.val('');
                        }

                    }

                }
            }

            if ($this.options.enableAutoSuggest == 1) {

                // constructs the suggestion engine
                var $queries = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    limit: $this.options.limitSuggest,

                    remote: {
                        url: zfwcs_ajaxurl + '?action=auto_suggest&',
                        replace: function (url, query) {
                            url += $('#form-search', $this.element).serialize();
                            return url;
                        },
                        filter: function (items) {
                            // Map the remote source JSON array to a JavaScript array
                            return $.map(items, function (item) {
                                return {
                                    value: item.title
                                };
                            });
                        },
//                        cache: false,
                        rateLimitWait: 100,
                    },

                });

                $queries.initialize();

                $('#input-search', $this.element).typeahead(
                    null,
                    {
                        name: 'suggest-titles',
                        displayKey: 'value',
                        // `ttAdapter` wraps the suggestion engine in an adapter that
                        // is compatible with the typeahead jQuery plugin
                        source: $queries.ttAdapter(),

                    }
                );

            }
            // init advanced box
            $this.advanced_box();
        },

        advanced_box: function() {

            var $this = this;
            // init multiple select
            var chosenMultiple = $('.zf-chosen-multiple', $this.element);
            chosenMultiple.on('change', function() {
                var taxonomy = $(this).attr('data-taxonomy');
                var tem_val = $(this).val();
                console.log(tem_val);
                var tax_val = $.isArray(tem_val) ? tem_val.join($this.options.matchType) : tem_val;
                $("#" + taxonomy, $this.element).val(tax_val);

            });

            // init use checkbox
            $('.zf-use-checkbox', $this.element).each(function() {
                var $_this = $(this),
                taxonomy_name = $_this.find(' > input[type="hidden"]');
                $_this.find('input[type="checkbox"]').on('change', function() {
                    var temp = [];
                    $_this.find('input[type="checkbox"]').each(function() {
                        if ($(this).is(":checked")) {
                            temp.push($(this).val());
                        }
                    })
                    taxonomy_name.val(temp.join($this.options.matchType));
                });
            });

            // slider price range
            var priceSliderRange = $("#price-slider-range", $this.element);

            if (priceSliderRange.length > 0) {

                var eminPrice = $("#min_price", $this.element);
                var emaxPrice = $("#max_price", $this.element);
                var spanFrom = $("span#from", $this.element);
                var spanTo = $("span#to", $this.element);
                var minPrice = eminPrice.data('minprice');
                var maxPrice = emaxPrice.data('maxprice');
                var currentMin = parseInt(eminPrice.val());
                var currentMax = parseInt(emaxPrice.val());
                priceSliderRange.slider({
                    range: true,
                    min: minPrice,
                    max: maxPrice,
                    values: [currentMin, currentMax],
                    slide: function(event, ui ) {
                        eminPrice.val(ui.values[0]);
                        emaxPrice.val(ui.values[1]);
                        spanFrom.html(ui.values[0]);
                        spanTo.html(ui.values[1]);
                    },
                    change: function ( event , ui) {

                    }
                });
            }

            //init date range
            var dateFrom = $('#date_from', $this.element);
            var dateTo = $('#date_to', $this.element);
            if (dateFrom.length > 0) {

                dateFrom.datepicker({
                    defaultDate: "+1w",
                    changeMonth: false,
                    dateFormat: 'yy-mm-dd',
                    onClose: function (selectDate) {
                        dateTo.datepicker("option", "minDate", selectDate);
                    }
                });

                dateTo.datepicker({
                    defaultDate: "+1w",
                    changeMonth: false,
                    dateFormat: 'yy-mm-dd',
                    onClose: function (selectDate) {
                        dateFrom.datepicker("option", "maxDate", selectDate);
                    }
                });

            }

            var init_chosen = false;

            $('a[data-popup-id]', $this.element).on('click', function(e) {
                e.preventDefault();
                var box = $(this).attr('data-popup-id');
                console.log(box);

                $('#'+box, $this.element).fadeIn(400, function() {

                });
                // init chosen
                if (!init_chosen) {
                    $( ".zf-chosen, .zf-chosen-full",$this.element ).chosen({
                        disable_search_threshold: 10,
                        disable_search: true
                    });
                    init_chosen = true;
                }

            });

            $("#input-search, .advanced-popup-close", this.element).on('click', function(e) {
                e.preventDefault();
                $(".advanced-popup-box", this.element).fadeOut(500, function() {

                });
            });
        },

        moveLeft: function (prev, slideW, next) {

            var $this = this;
            $this.tabsNavigation.animate({
                left: slideW
            }, 100, function () {

                if (slideW == 0) {
                    prev.addClass('zf-disabled');
                    $this.tabLeftStatus = false;
                    next.removeClass('zf-disabled');
                    $this.tabRightStatus = true;
                } else {
                    next.removeClass('zf-disabled');
                    $this.tabRightStatus = true;
                }
            });
        },

        moveRight: function (prev, slideW, next) {
            var $this = this;
            $this.tabsNavigation.animate({
                left: slideW
            }, 100, function () {

                var ulSlideW = slideW + $this.sliderUlW;
                prev.removeClass('zf-disabled');
                $this.tabLeftStatus = true;

                if (ulSlideW < $this.wrapperW) {
                    next.addClass('zf-disabled');
                    $this.tabRightStatus = false;
                }
            });
        },

    }

    $.fn.zfcategorysearch = function (options) {

        return this.each(function () {

            var $this = $(this);

            new ZFCategorySearch(this, options);


        });

    }

})(jQuery);
/**
 * jQuery ZT WordPress Category Search  plugin
 * @version    2.0
 * @author     ZuFusion
 * @copyright  Copyright (C) 2021 ZuFusion.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * Websites: http://www.zufusion.com
 */

(function ($) {

    "use strict";

    /*=========== depend field  ==============*/
    // load default value
    $('.zf-depend').each(function() {
        dependOn(this);
    });

    $('.zf-depend').on('change', function() {
        dependOn(this);
    });

    function dependOn(el) {
        var object = $(el);
        var value = object.val();
        var name = object.attr('name');
        $('[data-for="'+name+'"]').each(function() {

            var _this = $(this);
            var el_value = _this.attr('data-value');

            if (typeof el_value != 'undefined') {
                el_value = el_value.split(',');
                if ($.inArray(value,el_value) < 0) {
                    _this.hide();
                } else {
                    _this.show();
                }

            } else {
                _this.hide();
            }
        });

    }

    /*=========== for custom post type ==============*/


    $('#custom_post_type').on('change', function() {
        var data = {
            action: 'get_custom_post_type_layout',
            custom_post_type: $(this).val()
        };

        $.ajax({
            url: ajaxurl,
            type: 'POST',
//            dataType: 'json',
            data: data,
            beforeSend: function () {
                $('#elements-box').html('<span class="zf-loading"></span>');
            },
            success: function (data) {
                $('#elements-box').html(data);
                init_custom_post_type();
            }
        });
    });
    init_custom_post_type();
    function init_custom_post_type() {
        on_checkbox_multiple();
        function on_checkbox_multiple() {
            $('#advanced-multiple-elements input[type="checkbox"]').on('change', function() {
                custom_post_type_data();
            });
        }
        // drap vs drop elements
        $('#elements-box .sortable-elements').sortable({
            connectWith: '#elements-box .sortable-elements',
            update: function(e, ui){
                custom_post_type_data();
            },
            stop: function(e, ui) {
                on_checkbox_multiple();
            }
        });
        checkbox_available();
    }

    function checkbox_available() {
        $('#advanced-multiple-elements input[type="checkbox"]:not(.is-checkbox-field)').on('click', function() {
            var key = $(this).attr('data-key');
            if ($(this).prop( "checked" )) {
                $('#use-checkbox-' + key).removeAttr('disabled');
            } else {
                $('#use-checkbox-' + key).attr('disabled', true);
            }
        });
    }

    // get current custom post type
    function custom_post_type_data() {

        var data = {};
        var advanced_multiple = [];
        var use_checkbox = [];

        $('#elements-box ul.sortable-elements').each(function(){
            data[$(this).attr('data-key')] = $(this).sortable('toArray').join(',');
        });

        var advanced_arr = data['advanced'].split(',');
        // remove elements if multiple search not in advanced box
        $('#advanced-multiple-elements input[type="checkbox"]').each(function() {

            var check_key = $(this).attr('data-key');
            if($.inArray(""+check_key+"", advanced_arr) > -1) {
            } else {
                $(this).parent().parent().remove();
            }

        });
        // append to multiple elements
        $('#advanced-search-box ul.sortable-elements li').each(function() {

            if ($('#advanced-multiple-elements #checkbox-'+$(this).attr('data-key')+'').length > 0 ) {
                // nothing
            } else {
                $('#advanced-multiple-elements').append('<li><label for="checkbox-'+$(this).attr('data-key')+'"><input type="checkbox" name="checkbox-'+$(this).attr('data-key')+'" id="checkbox-'+$(this).attr('data-key')+'" data-key="'+$(this).attr('data-key')+'"> '+$(this).attr('data-label')+'</label>' +
                '<label class="use-checkbox"><input type="checkbox" name="use-checkbox-'+$(this).attr('data-key')+'" id="use-checkbox-'+$(this).attr('data-key')+'" class="is-checkbox-field" disabled="true" data-key="'+$(this).attr('data-key')+'"> Use checkbox?</label></li>');
            }
        });

        $('#advanced-multiple-elements input[type="checkbox"]').each(function() {
            if($(this).is(":checked")) {

                if ($(this).hasClass('is-checkbox-field')) {
                    use_checkbox.push($(this).attr('data-key'));
                } else {
                    advanced_multiple.push($(this).attr('data-key'));
                }
            }
        });

        data['advanced-multiple'] =  advanced_multiple.join(',');
        data['use-checkbox'] =  use_checkbox.join(',');

        $('#custom_post_type_data').val(JSON.stringify(data));

    }



})(jQuery);
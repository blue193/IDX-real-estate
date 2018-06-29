var $ = jQuery;

(function ($) {
    "use strict";
    $.fn.wp_rem_req_loop = function (callback, thisArg) {
        var me = this;
        return this.each(function (index, element) {
            return callback.call(thisArg || element, element, index, me);
        });
    };
})(jQuery);

$(document).ready(function ($) {
    "use strict";
    if ($(".selectpicker").length != '') {
        $('.selectpicker').selectpicker({
            size: 5
        });
    }

    if ($(".service-list").length != '') {
        var timesRun = 0;
        setInterval(function () {
            timesRun++;
            if (timesRun === 1) {
                $('.service-list > ul').sortable({
                    handle: '.drag-option',
                    cursor: 'move'
                });
            }
        }, 500);
    }

    if ($(".floor-plan-list").length != '') {
        var timesRun = 0;
        setInterval(function () {
            timesRun++;
            if (timesRun === 1) {
                $('.floor-plan-list > ul').sortable({
                    handle: '.drag-option',
                    cursor: 'move'
                });
            }
        }, 500);
    }

});

$(document).on('submit', 'form.wp-rem-dev-payment-form', function () {
    "use strict";
    var returnType = wp_rem_validation_process(jQuery(".wp-rem-dev-payment-form"));
    if (returnType == false) {
        return false;
    }
    var thisObj = jQuery(".payment-submit-btn");
    wp_rem_show_loader('.payment-submit-btn', '', 'button_loader', thisObj);
});

$(document).on('submit', 'form.wp-rem-dev-property-form', function () {
    "use strict";
    var returnType = wp_rem_validation_process(jQuery(".wp-rem-dev-property-form"));
    if (returnType == false) {
        return false;
    }
    var thisObj = jQuery(".add-property-loader");
    wp_rem_show_loader('.add-property-loader', '', 'button_loader', thisObj);
});

function validate_register_add_restaurant_form(that) {
    "use strict";
    var req_class = 'wp-rem-dev-req-field',
            _this_form = $(that),
            _this_id = $(that).data('id'),
            form_validity = 'valid';
    _this_form.find('.' + req_class).wp_rem_req_loop(function (element, index, set) {
        if ($(element).attr('id') == 'terms-' + _this_id) {
            if ($(element).is(':checked')) {
                $(element).next('label').css({"color": "#484848"});
            } else {
                $(element).next('label').css({"color": "#ff0000"});
                form_validity = 'invalid';
            }
        } else {
            if ($(element).is('select')) {
                if ($(element).val() != '') {
                    $(element).next('.chosen-container').css({"border": "1px solid #cccccc"});
                } else if ($(element).val() == '') {
                    form_validity = 'invalid';
                    $(element).next('.chosen-container').css({"border": "1px solid #ff0000"});
                }
            } else {
                if ($(element).val() != '') {
                    $(element).css({"border": "1px solid #cccccc"});
                    $(element).parent().parent().parent().css({"border": "1px solid #cccccc"});
                    $(element).css({"border": "1px solid #cccccc"});
                } else if ($(element).val() == '') {
                    form_validity = 'invalid';
                    var animate_to = '';
                    if ($(element).hasClass('wp_rem_editor')) {
                        $(element).parent().parent().parent().css({"border": "1px solid #ff0000"});
                        var animate_to = $(element).parent().parent().parent();
                    } else {
                        $(element).css({"border": "1px solid #ff0000"});
                        var animate_to = $(element);
                    }
                    $('html, body').animate({scrollTop: $(animate_to).offset().top}, 1000);
                }
            }
        }

        if ($(element).hasClass('usererror')) {
            form_validity = 'invalid';
            $(element).css({"border": "1px solid #ff0000"});
        }
    });

    if ($("input[name='wp_rem_property_package']").length > 0) {
        if ($("input[name='wp_rem_property_package']:checked").length < 1) {
            form_validity = 'invalid';
            $("input[name='wp_rem_property_package']").closest('.wp-rem-pkg-header').css({"border": "1px solid #ff0000"});
        } else {
            $("input[name='wp_rem_property_package']").closest('.wp-rem-pkg-header').css({"border": "1px solid #f4f4f4"});
        }
    }

    if (form_validity == 'valid') {
        return true;
    } else {
        return false;
    }
}
;

$(document).on('change', '.wp-rem-dev-username, .wp-rem-dev-user-email', function () {
    "use strict";
    var checkig_user,
            _this_ = $(this),
            _this_id = $(this).data('id'),
            _this_type = $(this).data('type'),
            _this_val = $(this).val(),
            ajax_url = $("#wp-rem-dev-posting-main-" + _this_id).data('ajax-url'),
            _plugin_url = $("#wp-rem-dev-posting-main-" + _this_id).data('plugin-url'),
            color,
            this_loader;

    if (_this_type == 'username') {
        this_loader = $('#wp-rem-dev-user-signup-' + _this_id).find('.wp-rem-dev-username-check');
    } else {
        this_loader = $('#wp-rem-dev-user-signup-' + _this_id).find('.wp-rem-dev-useremail-check');
    }

    this_loader.html('<div class="loader-holder" style="width:18px;"><img src="' + _plugin_url + 'assets/frontend/images/ajax-loader.gif" alt=""></div>');
    checkig_user = $.ajax({
        url: ajax_url,
        method: "POST",
        data: {
            field_type: _this_type,
            field_val: _this_val,
            property_add_counter: _this_id,
            action: 'wp_rem_property_user_authentication'
        },
        dataType: "json"
    }).done(function (response) {
        if (typeof response.action !== 'undefined' && response.action == 'true') {
            color = 'green';
            _this_.css({"border": "1px solid #cccccc"});
            _this_.removeClass('usererror');
            _this_.removeClass('frontend-field-error');
        } else {
            color = 'red';
            _this_.css({"border": "1px solid #ff0000"});
            _this_.addClass('usererror');
        }
        if (typeof response.msg !== 'undefined' && response.msg != '') {
            this_loader.html('<em style="color:' + color + ';">' + response.msg + '</em>');
        } else {
            this_loader.html('<em style="color:' + color + ';">' + wp_rem_property_strings.action_error + '</em>');
        }
    }).fail(function () {
        this_loader.html(wp_rem_property_strings.action_error);
    });
});

if ($('.wp-rem-dev-username').length > 0 && $('.wp-rem-dev-username').val().length > 0) {
    $('.wp-rem-dev-username').trigger('change');
}

if ($('.wp-rem-dev-user-email').length > 0 && $('.wp-rem-dev-user-email').val().length > 0) {
    $('.wp-rem-dev-user-email').trigger('change');
}

$(document).on('click', '.wp-rem-dev-select-type', function () {
    "use strict";
    var selecting_type,
            _this_id = $(this).data('id'),
            _this_val = $(this).val(),
            _this_form = $("#wp-rem-dev-property-form-" + _this_id),
            ajax_url = $("#wp-rem-dev-posting-main-" + _this_id).data('ajax-url'),
            _plugin_url = $("#wp-rem-dev-posting-main-" + _this_id).data('plugin-url'),
            cf_append = $('#wp-rem-dev-cf-con-' + _this_id),
            main_append = $('#wp-rem-dev-main-con-' + _this_id),
            after_append = $('#wp-rem-dev-main-con-' + _this_id).find('#wp-rem-type-sec-' + _this_id),
            this_loader = $('#wp-rem-dev-loader-' + _this_id);
    
    this_loader.html('<div class="loader-holder"><img src="' + _plugin_url + 'assets/frontend/images/ajax-loader.gif" alt=""></div>');
    selecting_type = $.ajax({
        url: ajax_url,
        method: "POST",
        data: 'select_type=' + _this_val + '&property_add_counter=' + _this_id + '&action=wp_rem_property_load_cf' + '&' + _this_form.serialize(),
        dataType: "json"
    }).done(function (response) {
        if (typeof response.cf_html !== 'undefined') {
            cf_append.html(response.cf_html);
        }
        if (typeof response.main_html !== 'undefined') {
            main_append.find('li.wp-rem-dev-appended').remove();
            after_append.after(response.main_html);
        }
        this_loader.html('');
    }).fail(function () {
        this_loader.html('');
    });
});


/*
 * Floor Plan add property
 */
$(document).on('click', 'a[id^="wp-rem-dev-add-floor-plan-"]', function () {
    "use strict";

    var adding_service,
            _this_ = $(this),
            _this_id = $(this).data('id'),
            ajax_url = $("#wp-rem-dev-posting-main-" + _this_id).data('ajax-url'),
            _plugin_url = $("#wp-rem-dev-posting-main-" + _this_id).data('plugin-url'),
            _this_con = $('#wp-rem-dev-insert-floor-plan-con-' + _this_id),
            _title_field = _this_con.find('.floor-plan-title'),
            _desc_field = _this_con.find('.floor-plan-desc'),
            _this_append = $('#wp-rem-dev-add-floor-plan-app-' + _this_id),
            no_service_msg = _this_append.find('#no-floor-plan-' + _this_id),
            this_loader = $('#dev-floor-plans-loader-' + _this_id),
            this_act_msg = $('#wp-rem-dev-act-msg-' + _this_id);
    

    if (typeof _title_field !== 'undefined' && _title_field.val() != '') {
        
        var thisObj = jQuery('#wp-rem-dev-add-floor-plan-'+ _this_id +'');
        wp_rem_show_loader('#wp-rem-dev-add-floor-plan-'+ _this_id +'', '', 'button_loader', thisObj);
        
        
        var data = new FormData();
        $.each($("input.floor-plan-image")[0].files, function (key, value) {
            data.append(key, value);
        });
        data.append('title_field', _title_field.val());
        data.append('desc_field', _desc_field.val());
        data.append('property_add_counter', _this_id);
        data.append('action', 'wp_rem_property_floor_plan_to_list');
        adding_service = $.ajax({
            url: ajax_url,
            method: "POST",
            data: data,
            cache: false,
            dataType: "json",
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        }).done(function (response) {
            if (typeof response.html !== 'undefined') {
                no_service_msg.remove();
                _this_append.append(response.html);
                _title_field.val('');

                $('#wp-rem-dev-insert-floor-plan-con-' + _this_id).find('.icons-selector .selector .selected-icon > i').removeAttr('class');
                $('#wp-rem-dev-insert-floor-plan-con-' + _this_id).find('.icons-selector .selector .selected-icon > i').addClass('icon-cancel2');
                _desc_field.val('');
                _this_con.find('img.floor-plan-image-viewer').attr('src', '');
                _this_con.find('input.floor-plan-image').val('');
                $('#wp-rem-dev-insert-floor-plan-con-' + _this_id).find('.jqte_editor').html('');
            }
            jQuery('.service-list').find(".wp_rem_editor").jqte({
                'sub': false,
                'sup': false,
                'indent': false,
                'outdent': false,
                'unlink': false,
                'format': false,
                'color': false,
                'left': false,
                'right': false,
                'center': false,
                'strike': false,
                'rule': false,
                'fsize': false,
            });
            var response = {
                type: 'success',
                msg: wp_rem_property_strings.ploor_plan_added
            };
            wp_rem_show_response(response, '', thisObj);
            $('#wp-rem-dev-insert-floor-plan-con-' + _this_id).slideUp();
        }).fail(function () {
            wp_rem_show_response('', '', thisObj);
        });
    } else {
        var response = {
            type: 'error',
            msg: wp_rem_property_strings.compulsory_fields
        };
        wp_rem_show_response(response);
    }
});

$(document).on('change', 'input.floor-plan-image', function () {
    "use strict";
    var input = this;
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('img.floor-plan-image-viewer')
                    .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
        $('.floor-plan-image-viewer-holder').show();
    }
});

$(document).on('click', '.remove-this-floor-plan', function () {
    $(this).parent('.info-holder').slideUp();
});

/*
 * End Floor Plan add property
 */


/*
 * Add Near by 
 */

$(document).on('click', 'a[id^="wp-rem-dev-add-near-by-"]', function () {
    "use strict";
    var adding_service,
            _this_ = $(this),
            _this_id = $(this).data('id'),
            ajax_url = $("#wp-rem-dev-posting-main-" + _this_id).data('ajax-url'),
            _plugin_url = $("#wp-rem-dev-posting-main-" + _this_id).data('plugin-url'),
            _this_con = $('#wp-rem-dev-insert-near-by-con-' + _this_id),
            _title_field = _this_con.find('.near-by-title'),
            _desc_field = _this_con.find('.near-by-desc'),
            _this_append = $('#wp-rem-dev-add-near-by-app-' + _this_id),
            no_service_msg = _this_append.find('#no-near-by-' + _this_id),
            this_loader = $('#dev-near-by-loader-' + _this_id),
            this_act_msg = $('#wp-rem-dev-act-msg-' + _this_id);
    if (typeof _title_field !== 'undefined' && _title_field.val() != '') {
        
        var thisObj = jQuery('#wp-rem-dev-add-near-by-'+ _this_id +'');
        wp_rem_show_loader('#wp-rem-dev-add-near-by-'+ _this_id +'', '', 'button_loader', thisObj);

        var data = new FormData();
        $.each($("input.near-by-image")[0].files, function (key, value) {
            data.append(key, value);
        });
        data.append('title_field', _title_field.val());
        data.append('desc_field', _desc_field.val());
        data.append('property_add_counter', _this_id);
        data.append('action', 'wp_rem_property_near_by_to_list');
        adding_service = $.ajax({
            url: ajax_url,
            method: "POST",
            data: data,
            cache: false,
            dataType: "json",
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        }).done(function (response) {
            if (typeof response.html !== 'undefined') {
                no_service_msg.remove();
                _this_append.append(response.html);
                _title_field.val('');
                $('#wp-rem-dev-insert-near-by-con-' + _this_id).find('.icons-selector .selector .selected-icon > i').removeAttr('class');
                $('#wp-rem-dev-insert-near-by-con-' + _this_id).find('.icons-selector .selector .selected-icon > i').addClass('icon-cancel2');
                _desc_field.val('');
                _this_con.find('img.near-by-image-viewer').attr('src', '');
                _this_con.find('input.near-by-image').val('');
                $('#wp-rem-dev-insert-near-by-con-' + _this_id).find('.jqte_editor').html('');
            }
            
            var response = {
                type: 'success',
                msg: wp_rem_property_strings.nearby_added
            };
            wp_rem_show_response(response, '', thisObj);
            $('#wp-rem-dev-insert-near-by-con-' + _this_id).slideUp();
        }).fail(function () {
            wp_rem_show_response('', '', thisObj);
        });
    } else {
        var response = {
            type: 'error',
            msg: wp_rem_property_strings.compulsory_fields
        };
        wp_rem_show_response(response);
    }
});

$(document).on('change', 'input.near-by-image', function () {
    "use strict";
    var input = this;
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('img.near-by-image-viewer')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
        };

        reader.readAsDataURL(input.files[0]);
        $('img.near-by-image-viewer').show();
    }
});

$(document).on('click', '.remove-this-near-by', function () {
    $(this).parent('.info-holder').slideUp();
});
/*
 * End Near by
 */

/*
 * End Near by
 */
$(document).on('click', '.wp-rem-dev-insert-off-days .wp-rem-dev-calendar-days .day a', function () {
    "use strict";
    var adding_off_day,
            _this_ = $(this),
            _this_id = $(this).parents('.wp-rem-dev-insert-off-days').data('id'),
            ajax_url = $("#wp-rem-dev-posting-main-" + _this_id).data('ajax-url'),
            _plugin_url = $("#wp-rem-dev-posting-main-" + _this_id).data('plugin-url'),
            _day = $(this).data('day'),
            _month = $(this).data('month'),
            _year = $(this).data('year'),
            _adding_date = _year + '-' + _month + '-' + _day,
            _add_date = true,
            _this_append = $('#wp-rem-dev-add-off-day-app-' + _this_id),
            no_off_day_msg = _this_append.find('#no-book-day-' + _this_id),
            this_loader = $('#dev-off-day-loader-' + _this_id),
            this_act_msg = $('#wp-rem-dev-act-msg-' + _this_id);

    _this_append.find('li').each(function () {
        var date_field = $(this).find('input[name^="wp_rem_property_off_days"]');
        if (_adding_date == date_field.val()) {
            var response = {
                type: 'success',
                msg: wp_rem_property_strings.off_day_already_added
            };
            wp_rem_show_response(response);
            _add_date = false;
        }
    });
    if (typeof _day !== 'undefined' && typeof _month !== 'undefined' && typeof _year !== 'undefined' && _add_date === true) {
        
        var thisObj = jQuery('.book-btn');
        wp_rem_show_loader('.book-btn', '', 'button_loader', thisObj);
        adding_off_day = $.ajax({
            url: ajax_url,
            method: "POST",
            data: {
                off_day_day: _day,
                off_day_month: _month,
                off_day_year: _year,
                property_add_counter: _this_id,
                action: 'wp_rem_property_off_day_to_list'
            },
            dataType: "json"
        }).done(function (response) {
            if (typeof response.html !== 'undefined') {
                no_off_day_msg.remove();
                _this_append.append(response.html);
                this_act_msg.html(wp_rem_property_strings.off_day_added);
            }
            var response = {
                type: 'success',
                msg: wp_rem_property_strings.off_day_added
            };
            wp_rem_show_response(response, '', thisObj);
            $('#wp-rem-dev-cal-holder-' + _this_id).slideUp('fast');
        }).fail(function () {
            wp_rem_show_response('', '', thisObj);
        });
    }
});

$(document).on('click', 'div[id^="wp-rem-dev-tag-info"] button', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            _this_tag_field = $('#wp-rem-dev-tag-info-' + _this_id).find('input'),
            _this_tag = $('#wp-rem-dev-tag-info-' + _this_id).find('input').val(),
            _this_append = $('#tag-cloud-' + _this_id),
            no_tag_msg = _this_append.find('#no-tag-' + _this_id),
            _this_tag_html = '<li class="tag-cloud">' + _this_tag + '<input type="hidden" name="wp_rem_tags[]" value="' + _this_tag + '"></li>';
    if (typeof _this_tag !== 'undefined' && _this_tag != '') {
        no_tag_msg.remove();
        _this_append.append(_this_tag_html);
        _this_tag_field.val('');
    }
});

$(document).on('click', 'a[id^="wp-rem-dev-open-time"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            _this_day = $(this).data('day'),
            _this_con = $('#open-close-con-' + _this_day + '-' + _this_id),
            _this_status = $('#wp-rem-dev-open-day-' + _this_day + '-' + _this_id);
    if (typeof _this_id !== 'undefined' && typeof _this_day !== 'undefined') {
        _this_status.val('on');
        _this_con.addClass('opening-time');
    }
});

$(document).on('click', 'a[id^="wp-rem-dev-close-time"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            _this_day = $(this).data('day'),
            _this_con = $('#open-close-con-' + _this_day + '-' + _this_id),
            _this_status = $('#wp-rem-dev-open-day-' + _this_day + '-' + _this_id);
    if (typeof _this_id !== 'undefined' && typeof _this_day !== 'undefined') {
        _this_status.val('');
        _this_con.removeClass('opening-time');
    }
});

$(document).on('click', 'a[id^="wp-rem-dev-floor-plan-edit-"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            _this_con = $('#wp-rem-dev-floor-plan-edit-con-' + _this_id);

    _this_con.slideToggle();

    _this_con.find(".floor-plan-desc").jqte({
        'sub': false,
        'sup': false,
        'indent': false,
        'outdent': false,
        'unlink': false,
        'format': false,
        'color': false,
        'left': false,
        'right': false,
        'center': false,
        'strike': false,
        'rule': false,
        'fsize': false,
    });
});

$(document).on('click', 'a[id^="wp-rem-dev-near-by-edit-"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            _this_con = $('#wp-rem-dev-near-by-edit-con-' + _this_id);

    _this_con.slideToggle();
});

$(document).on('click', 'a[id^="wp-rem-dev-insert-floor-plan-"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            _this_con = $('#wp-rem-dev-insert-floor-plan-con-' + _this_id);

    _this_con.slideToggle();

    _this_con.find(".wp_rem_editor").jqte({
        'sub': false,
        'sup': false,
        'indent': false,
        'outdent': false,
        'unlink': false,
        'format': false,
        'color': false,
        'left': false,
        'right': false,
        'center': false,
        'strike': false,
        'rule': false,
        'fsize': false,
    });

});

$(document).on('click', 'a[id^="wp-rem-dev-insert-near-by-"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            _this_con = $('#wp-rem-dev-insert-near-by-con-' + _this_id);

    _this_con.slideToggle();

    _this_con.find(".wp_rem_editor").jqte({
        'sub': false,
        'sup': false,
        'indent': false,
        'outdent': false,
        'unlink': false,
        'format': false,
        'color': false,
        'left': false,
        'right': false,
        'center': false,
        'strike': false,
        'rule': false,
        'fsize': false,
    });

});

$(document).on('click', 'a[id^="wp-rem-dev-floor-plan-save-"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
    _this_con = $('#wp-rem-dev-floor-plan-edit-con-' + _this_id),
    title_val = _this_con.find('.floor-plan-title').val();
    
    var thisObj = jQuery('#wp-rem-dev-floor-plan-save-'+ _this_id +'');
    wp_rem_show_loader('#wp-rem-dev-floor-plan-save-'+ _this_id +'', '', 'button_loader', thisObj);
    
    var input = _this_con.find('input[type="file"]')[0];
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            _this_con.find('img').attr('src', e.target.result);
            $('#floor-plan-image-' + _this_id + ' img').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
    $('#floor-plan-title-' + _this_id).html('<h6>' + title_val + '</h6>');
    
    setTimeout(function () {
        wp_rem_show_response('', '', thisObj);
        _this_con.slideUp();
    }, 500);
});

$(document).on('click', 'a[id^="wp-rem-dev-near-by-save-"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
    _this_con = $('#wp-rem-dev-near-by-edit-con-' + _this_id),
    title_val = _this_con.find('.near-by-title').val();
    
    var thisObj = jQuery('#wp-rem-dev-near-by-save-'+ _this_id +'');
    wp_rem_show_loader('#wp-rem-dev-near-by-save-'+ _this_id +'', '', 'button_loader', thisObj);
    
    var input = _this_con.find('input[type="file"]')[0];
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            _this_con.find('img').attr('src', e.target.result);
            $('#near-by-image-' + _this_id + ' img').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
    $('#near-by-title-' + _this_id).html('<h6>' + title_val + '</h6>');
    
    setTimeout(function () {
        wp_rem_show_response('', '', thisObj);
        _this_con.slideUp();
    }, 500);
});

$(document).on('click', '.book-btn', function () {
    $(this).next('.calendar-holder').slideToggle("fast");
});

$(document).on('click', 'a[id^="wp-rem-dev-day-off-rem-"]', function () {
    var _this_id = $(this).data('id');
    $('#day-remove-' + _this_id).remove();
});

$(document).on('click', 'a[id^="choose-all-apply-"]', function () {
    "use strict";
    var _this = $(this);
    var _this_id = $(this).data('id');

    if (_this.hasClass('feat-checked')) {
        _this.removeClass('feat-checked');
        $('#features-check-list-' + _this_id).find('input[type="checkbox"]').prop('checked', false);
    } else {
        _this.addClass('feat-checked');
        $('#features-check-list-' + _this_id).find('input[type="checkbox"]').prop('checked', 'checked');
    }
});

// Gallery btn
$(document).on('click', '.wp-rem-dev-gallery-upload-btn', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            this_triger = $('#image-uploader-' + _this_id);
    this_triger.trigger('click');
});

// Gallery btn
$(document).on('click', '.wp-rem-dev-featured-upload-btn', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            this_triger = $('#featured-image-uploader-' + _this_id);

    this_triger.trigger('click');
});
$(document).on('click', '.wp-rem-dev-video-cover-btn', function () {
    var _this_id = $(this).data('id'),
            this_triger = $('#video-image-uploader-' + _this_id);

    this_triger.trigger('click');
});

//add Gallery
function wp_rem_handle_file_single_select(event, counter) {
    "use strict";
    //Check File API support
    if (window.File && window.FileList && window.FileReader) {

        var files = event.target.files;
        var image_file = true;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            //Only pics
            if (!file.type.match('image')) {
                alert(wp_rem_property_strings.upload_images_only);
                image_file = false;
            }

            if (image_file === true) {
                var picReader = new FileReader();
                picReader.addEventListener("load", function (event) {
                    var picFile = event.target;
                    if (picFile.result) {
                        console.log(picFile);
                        document.getElementById("featured-placeholder-" + counter).style.display = "none";
                        var listItems = jQuery('#wp-rem-dev-featured-img-' + counter + '').children().length;
                        //alert( picFile.result );
                        if (listItems > 0) {
                            $('#wp-rem-dev-featured-img-' + counter + ' img').attr('src', picFile.result);
                            $('#wp-rem-dev-featured-img-' + counter + ' img').attr('title', picFile.name);
                            $('#wp-rem-dev-featured-img-' + counter + ' input').val('');
                        } else {
			    document.getElementById("wp-rem-dev-featured-img-" + counter).innerHTML += '\
                            <li class="gal-img">\
                                <div class="drag-list">\
                                    <div class="item-thumb"><img class="thumbnail" src="' + picFile.result + '" + "title="' + picFile.name + '"/></div>\
                                    <div class="item-assts">\
                                        <ul class="list-inline pull-right">\
                                            <li class="drag-btn"><a href="javascript:void(0);"><i class="icon-bars"></i></a></li>\
                                            <li class="close-btn"><a href="javascript:void(0);"><i class="icon-cross-out"></i></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </li>';
                        }
                    }
                });
                //Read the image
                picReader.readAsDataURL(file);
            }
        }
    } else {
        alert("Your browser does not support File API");
    }
}

$(document).on('click', '.property-radios li', function () {
    var _this_ = $(this);
    _this_.parents('ul').find('li').removeAttr('class');
    _this_.addClass('active');
});

$(document).on('click', '.browse-attach-icon-img', function () {
    var _this_ = $(this);
    var this_id = _this_.attr('data-id');
    $('#browse-attach-icon-img-' + this_id).trigger('click');
});

$(document).on('click', '.browse-floor-icon-img', function () {
    var _this_ = $(this);
    var this_id = _this_.attr('data-id');
    $('#browse-floor-icon-img-' + this_id).trigger('click');
});

// add video cover
function wp_rem_handle_file_single_select_video(event, counter) {
	//Check File API support
	"use strict";
	if (window.File && window.FileList && window.FileReader) {

	    var files = event.target.files;
	    var image_file = true;

	    for (var i = 0; i < files.length; i++) {
		var file = files[i];
		//Only pics
		if (!file.type.match('image')) {
		    alert(wp_rem_property_strings.upload_images_only);
		    image_file = false;
		}

		if (image_file === true) {
		    var picReader = new FileReader();
		    picReader.addEventListener("load", function (event) {
			var picFile = event.target;
			if (picFile.result) {
			    console.log(picFile);
			    document.getElementById("video-placeholder-" + counter).style.display = "none";
			    var listItems = jQuery('#wp-rem-dev-video-img-' + counter + '').children().length;
			    //alert( picFile.result );
			    if (listItems > 0) {
				$('#wp-rem-dev-video-img-' + counter + ' img').attr('src', picFile.result);
				$('#wp-rem-dev-video-img-' + counter + ' img').attr('title', picFile.name);
				$('#wp-rem-dev-video-img-' + counter + ' input').val('');
			    } else {
				document.getElementById("wp-rem-dev-video-img-" + counter).innerHTML += '\
                            <li class="gal-img">\
                                <div class="drag-list">\
                                    <div class="item-thumb"><img class="thumbnail" src="' + picFile.result + '" + "title="' + picFile.name + '"/></div>\
                                    <div class="item-assts">\
                                        <ul class="list-inline pull-right">\
                                            <li class="drag-btn"><a href="javascript:void(0);"><i class="icon-bars"></i></a></li>\
                                            <li class="close-btn"><a href="javascript:void(0);"><i class="icon-cross-out"></i></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </li>';
			    }
			}
		    });
		    //Read the image
		    picReader.readAsDataURL(file);
		}
	    }
	} else {
	    alert("Your browser does not support File API");
	}
    }

//add Gallery
function wp_rem_handle_file_select(event, counter) {
    //Check File API support
    "use strict";
    if (window.File && window.FileList && window.FileReader) {

        var files = event.target.files;
        var image_file = true;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            //Only pics
            if (!file.type.match('image')) {
                alert(wp_rem_property_strings.upload_images_only);
                image_file = false;
            }

            if (image_file === true) {
                var picReader = new FileReader();
                picReader.addEventListener("load", function (event) {
                    var picFile = event.target;
                    if (picFile.result) {
                        console.log(picFile);
                        document.getElementById("attach-placeholder-" + counter).style.display = "none";
                        document.getElementById("wp-rem-dev-gal-attach-sec-" + counter).innerHTML += '\
                        <li class="gal-img">\
                            <div class="drag-list">\
                                <div class="item-thumb"><img class="thumbnail" src="' + picFile.result + '" + "title="' + picFile.name + '"/></div>\
                                <div class="item-assts">\
                                    <div class="list-inline pull-right">\
                                        <div class="drag-btn"><a href="javascript:void(0);"><i class="icon-bars"></i></a></div>\
                                        <div class="close-btn"><a href="javascript:void(0);"><i class="icon-cross-out"></i></a></div>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>';
                    }
                    $('#wp-rem-dev-gal-attach-sec-' + counter).sortable();
                });
                //Read the image
                picReader.readAsDataURL(file);
            }
        }
    } else {
        alert("Your browser does not support File API");
    }
}

$(document).on('click', '.gal-img .close-btn', function () {
    $(this).parents('.gal-img').remove();
    $('.wp-rem-dev-gallery-uploader').val('');
});

// Property package update button
$(document).on('click', '.dev-wp-rem-property-update-package', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            property_info_con = $('#property-info-sec-' + _this_id),
            packages_con = $('#property-packages-sec-' + _this_id);

    property_info_con.hide();
    packages_con.slideDown();
});

// Property package update Cancel button
$(document).on('click', '.wp-rem-dev-cancel-pkg', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            property_info_con = $('#property-info-sec-' + _this_id),
            _check_new_btn = $('#wp-rem-dev-new-pkg-checkbox-' + _this_id),
            _new_pkgs_con = $('#new-packages-' + _this_id),
            _active_pkgs_con = $('#purchased-packages-' + _this_id),
            _purchased_pkg_head = $('#purchased-package-head-' + _this_id),
            _new_pkg_head = $('#buy-package-head-' + _this_id),
            packages_con = $('#property-packages-sec-' + _this_id);

    property_info_con.slideDown();
    packages_con.hide();
    $('.all-pckgs-sec').find('.pkg-detail-btn input[type="radio"]').prop('checked', false);
    $('.all-pckgs-sec').find('input[name="wp_rem_property_featured"]').prop('checked', false);
    $('.all-pckgs-sec').find('input[name="wp_rem_property_top_cat"]').prop('checked', false);
    $('.all-pckgs-sec').find('.package-info-sec').hide();
    $('.all-pckgs-sec').find('.wp-rem-pkg-header').removeAttr('style');

    if ($('.dir-switch-packges-btn').length === 1) {
        var btn_switch = $('#wp-rem-dev-new-pkg-btn-' + _this_id);
        _check_new_btn.prop('checked', false);
        _new_pkgs_con.hide();
        _active_pkgs_con.slideDown();

        _new_pkg_head.hide();
        _purchased_pkg_head.slideDown();

        btn_switch.html(wp_rem_property_strings.buy_new_packg);
    }

});

// Package detail Click
$(document).on('click', '.wp-rem-dev-detail-pkg', function () {
    "use strict";
    var _this_id = $(this).data('id'),
            package_detail_sec = $('#package-detail-' + _this_id);

    if (!package_detail_sec.is(':visible')) {
        $('.all-pckgs-sec').find('.package-info-sec').hide();
        package_detail_sec.slideDown();
    }

});

// Package cancel detail Click
$(document).on('click', '.pkg-cancel-btn', function () {
    "use strict";
    var _this = $(this),
            _this_id = $(this).data('id'),
            package_detail_sec = $('#package-detail-' + _this_id),
            package_btn = $('#package-' + _this_id);

    package_detail_sec.slideUp(400, function () {
        _this.parents('.wp-rem-pkg-holder').find('.wp-rem-pkg-header').removeAttr('style');
    });
    package_btn.prop('checked', false);
    _this.parents('.wp-rem-pkg-holder').find('input[name="wp_rem_property_featured"]').prop('checked', false);
    _this.parents('.wp-rem-pkg-holder').find('input[name="wp_rem_property_top_cat"]').prop('checked', false);
});

// Package Select Submit Click
$(document).on('click', '.pkg-choose-btn', function () {
    var _this = $(this),
            _this_id = _this.data('id'),
            package_detail_sec = $('#package-detail-' + _this_id),
            package_btn = $('#package-' + _this_id);
    $('.all-pckgs-sec').find('.wp-rem-pkg-header').removeAttr('style');

    package_btn.prop('checked', true);
    package_detail_sec.slideUp(400, function () {
        _this.parents('.wp-rem-pkg-holder').find('.wp-rem-pkg-header').css({'background-color': '#b7b7b7'});
    });
});

$(document).on('click', 'a[id^="wp-rem-dev-new-pkg-btn-"]', function () {
    "use strict";
    var _this = $(this),
            _this_id = $(this).data('id'),
            _check_new_btn = $('#wp-rem-dev-new-pkg-checkbox-' + _this_id),
            _new_pkgs_con = $('#new-packages-' + _this_id),
            _active_pkgs_con = $('#purchased-packages-' + _this_id),
            _purchased_pkg_head = $('#purchased-package-head-' + _this_id),
            _new_pkg_head = $('#buy-package-head-' + _this_id),
            _featured_top_checks = $('.dev-property-featured-top-cat');

    _featured_top_checks.remove();
    if (_check_new_btn.is(':checked')) {
        _check_new_btn.prop('checked', false);
    } else {
        _check_new_btn.prop('checked', true);
    }

    if (_check_new_btn.is(':checked')) {
        _active_pkgs_con.hide();
        _new_pkgs_con.slideDown();

        _purchased_pkg_head.hide();
        _new_pkg_head.slideDown();

        _this.html(wp_rem_property_strings.buy_exist_packg);
    } else {
        _new_pkgs_con.hide();
        _active_pkgs_con.slideDown();

        _new_pkg_head.hide();
        _purchased_pkg_head.slideDown();

        _this.html(wp_rem_property_strings.buy_new_packg);
    }
});


/*
 * Add Attachemts 
 */

$(document).on('click', 'a[id^="wp-rem-dev-insert-attachments-"]', function () {
    var _this_id = $(this).data('id'),
    _this_con = $('#wp-rem-dev-insert-attachments-con-' + _this_id);
    _this_con.slideToggle();
});

$(document).on('click', 'a[id^="wp-rem-dev-add-attachments-"]', function () {
    "use strict";
    var adding_service,
            _this_ = $(this),
            _this_id = $(this).data('id'),
            ajax_url = $("#wp-rem-dev-posting-main-" + _this_id).data('ajax-url'),
            _this_con = $('#wp-rem-dev-insert-attachments-con-' + _this_id),
            _title_field = _this_con.find('.attachment-title'),
            _file_field = _this_con.find('.attachment-file'),
            _this_append = $('#wp-rem-dev-add-attachments-app-' + _this_id),
            no_attachments_msg = _this_append.find('#no-attachments-' + _this_id),
            this_act_msg = $('#wp-rem-dev-act-msg-' + _this_id);
    if (typeof _title_field !== 'undefined' && _title_field.val() != '' && typeof _file_field !== 'undefined' && _file_field.val() != '') {
        
        var thisObj = jQuery('#wp-rem-dev-add-attachments-'+ _this_id +'');
        wp_rem_show_loader('#wp-rem-dev-add-attachments-'+ _this_id +'', '', 'button_loader', thisObj);

        var data = new FormData();
        $.each($("input.attachment-file")[0].files, function (key, value) {
            data.append(key, value);
        });
        data.append('title_field', _title_field.val());
        data.append('allowed_extentions', _file_field.attr('data-allowed-extentions'));
        data.append('property_add_counter', _this_id);
        data.append('action', 'wp_rem_property_attachments_to_list');
        adding_service = $.ajax({
            url: ajax_url,
            method: "POST",
            data: data,
            cache: false,
            dataType: "json",
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        }).done(function (response) {
            if (typeof response.html !== 'undefined') {
                no_attachments_msg.remove();
                _this_append.append(response.html);
                _title_field.val('');
                $('#wp-rem-dev-insert-attachments-con-' + _this_id).find('.icons-selector .selector .selected-icon > i').removeAttr('class');
                $('#wp-rem-dev-insert-attachments-con-' + _this_id).find('.icons-selector .selector .selected-icon > i').addClass('icon-cancel2');
                _this_con.find('img.attachment-file-viewer').attr('src', '');
                _this_con.find('input.attachment-file').val('');
            }
            
            var response = {
                type: 'success',
                msg: wp_rem_property_strings.attachment_added
            };
            wp_rem_show_response(response, '', thisObj);
            $('#wp-rem-dev-insert-attachments-con-' + _this_id).slideUp();
            $('.attachment-file-viewer-holder').hide();
        }).fail(function () {
            wp_rem_show_response('', '', thisObj);
        });
    } else {
        var response = {
            type: 'error',
            msg: wp_rem_property_strings.compulsory_fields
        };
        wp_rem_show_response(response);
    }
});

$(document).on('change', 'input.attachment-file', function () {
    "use strict";
    var input = this;
    var this_id = jQuery(input).data('id');
    if (typeof this_id !== 'undefined'){
        jQuery('span.allowed-extensions-'+ this_id).css('color', '');
    }else{
        jQuery('span.allowed-extensions').css('color', '');
    }
    if (input.files && input.files[0]) {
        var allowed_extentions = jQuery(input).attr('data-allowed-extentions');
        var new_allowed_extentions = new Array();
        new_allowed_extentions = allowed_extentions.split(",");
        var ext = input.value.match(/\.(.+)$/)[1];
        if ($.inArray(ext, new_allowed_extentions) == -1) {
            var response = {
                type: 'error',
                msg: 'Invalid Extension!'
            };
            if (typeof this_id !== 'undefined'){
                jQuery('span.allowed-extensions-'+ this_id).css('color', 'red');
            }else{
                jQuery('span.allowed-extensions').css('color', 'red');
            }
            wp_rem_show_response(response);
            jQuery('.attachment-file').val('');
            $('.attachment-file-viewer-holder').hide();
            $('img.attachment-file-viewer').attr('src', '');
            return false;
        }else{
            if (typeof this_id !== 'undefined'){
                $('img.attached-file-'+ this_id).attr('src', wp_rem_property_strings.plugin_url+'/assets/common/attachment-images/attach-'+ ext +'.png');
            }else{
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('img.attachment-file-viewer')
                        .attr('src', wp_rem_property_strings.plugin_url+'/assets/common/attachment-images/attach-'+ ext +'.png');
                };
                reader.readAsDataURL(input.files[0]);
                $('.attachment-file-viewer-holder').show();
            }
        }
    }
});
$(document).on('click', 'a[id^="wp-rem-dev-attachments-edit-"]', function () {
    var _this_id = $(this).data('id'),
    _this_con = $('#wp-rem-dev-attachments-edit-con-' + _this_id);
    _this_con.slideToggle();
});

$(document).on('click', 'a[id^="wp-rem-dev-attachments-save-"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
    _this_con = $('#wp-rem-dev-attachments-edit-con-' + _this_id),
    title_val = _this_con.find('.attachment-title').val();
    var file_val = _this_con.find('.attachment-file').val();
    
    var thisObj = jQuery('#wp-rem-dev-attachments-save-'+ _this_id +'');
    wp_rem_show_loader('#wp-rem-dev-attachments-save-'+ _this_id +'', '', 'button_loader', thisObj);
    
    var input = _this_con.find('input[type="file"]')[0];
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var ext = input.value.match(/\.(.+)$/)[1];
        reader.onload = function (e) {
            _this_con.find('img').attr('src', wp_rem_property_strings.plugin_url+'/assets/common/attachment-images/attach-'+ ext +'.png');
            $('#attachment-file-' + _this_id + ' img').attr('src', wp_rem_property_strings.plugin_url+'/assets/common/attachment-images/attach-'+ ext +'.png');
        };
        reader.readAsDataURL(input.files[0]);
    }
    $('#attachment-title-' + _this_id).html('<h6>' + title_val + '</h6>');
    
    var data = new FormData();
    $.each(_this_con.find('input.attachment-file')[0].files, function (key, value) {
        data.append(key, value);
    });
    data.append('ajax_filter', 'true');
    data.append('action', 'get_atachment_id_by_file');
    adding_service = $.ajax({
        url: wp_rem_property_strings.ajax_url,
        method: "POST",
        data: data,
        cache: false,
        dataType: "json",
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
    }).done(function (response) {
        _this_con.find('.property-attachment-id').val(response.html);
    })
    
    setTimeout(function () {
        wp_rem_show_response('', '', thisObj);
        _this_con.slideUp();
    }, 500);
});

$(document).on('click', '.remove-this-attachment', function () {
    $(this).parent('.info-holder').slideUp();
});



/*
 * Add Apartment 
 */

$(document).on('click', 'a[id^="wp-rem-dev-add-apartment-"]', function () {
    "use strict";
    var adding_service,
            _this_ = $(this),
            _this_id = $(this).data('id'),
            ajax_url = $("#wp-rem-dev-posting-main-" + _this_id).data('ajax-url'),
            _plugin_url = $("#wp-rem-dev-posting-main-" + _this_id).data('plugin-url'),
            _this_con = $('#wp-rem-dev-insert-apartment-con-' + _this_id),
            _plot_field = _this_con.find('.apartment-plot'),
	    _beds_field = _this_con.find('.apartment-beds'),
	    _price_field = _this_con.find('.apartment-price-from'),
	    _floor_field = _this_con.find('.apartment-floor'),
	    _address_field = _this_con.find('.apartment-address'),
	    _availability_field = _this_con.find('.apartment-availability'),
            _link_field = _this_con.find('.apartment-link'),
            _this_append = $('#wp-rem-dev-add-apartment-app-' + _this_id),
            no_service_msg = _this_append.find('#no-apartment-' + _this_id),
            this_loader = $('#dev-apartment-loader-' + _this_id),
            this_act_msg = $('#wp-rem-dev-act-msg-' + _this_id);
    if (typeof _plot_field !== 'undefined' && _plot_field.val() != '') {
        
        var thisObj = jQuery('#wp-rem-dev-add-apartment-'+ _this_id +'');
        wp_rem_show_loader('#wp-rem-dev-add-apartment-'+ _this_id +'', '', 'button_loader', thisObj);

        var data = new FormData();
        data.append('plot_field', _plot_field.val());
        data.append('beds_field', _beds_field.val());
	data.append('price_from_field', _price_field.val());
        data.append('floor_field', _floor_field.val());
        data.append('address_field', _address_field.val());
	data.append('availability_field', _availability_field.val());
	data.append('link_field', _link_field.val());
        data.append('property_add_counter', _this_id);
        data.append('action', 'wp_rem_property_apartment_to_list');
        adding_service = $.ajax({
            url: ajax_url,
            method: "POST",
            data: data,
            cache: false,
            dataType: "json",
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        }).done(function (response) {
            if (typeof response.html !== 'undefined') {
                no_service_msg.remove();
                _this_append.append(response.html);
                _plot_field.val('');
                $('#wp-rem-dev-insert-apartment-con-' + _this_id).find('.icons-selector .selector .selected-icon > i').removeAttr('class');
                $('#wp-rem-dev-insert-apartment-con-' + _this_id).find('.icons-selector .selector .selected-icon > i').addClass('icon-cancel2');
                _beds_field.val('');
		_price_field.val('');
		_floor_field.val('');
		_address_field.val('');
		_availability_field.val('');
		_link_field.val('');
	    }
            
            var response = {
                type: 'success',
                msg: wp_rem_property_strings.apartment_added
            };
            wp_rem_show_response(response, '', thisObj);
            $('#wp-rem-dev-insert-apartment-con-' + _this_id).slideUp();
        }).fail(function () {
            wp_rem_show_response('', '', thisObj);
        });
    } else {
        var response = {
            type: 'error',
            msg: wp_rem_property_strings.compulsory_fields
        };
        wp_rem_show_response(response);
    }
});

$(document).on('click', '.remove-this-apartment', function () {
    $(this).parent('.info-holder').slideUp();
});

$(document).on('click', 'a[id^="wp-rem-dev-apartment-edit-"]', function () {
    var _this_id = $(this).data('id'),
            _this_con = $('#wp-rem-dev-apartment-edit-con-' + _this_id);
    _this_con.slideToggle();

});

$(document).on('click', 'a[id^="wp-rem-dev-insert-apartment-"]', function () {
    var _this_id = $(this).data('id'),
            _this_con = $('#wp-rem-dev-insert-apartment-con-' + _this_id);
    _this_con.slideToggle();

});

$(document).on('click', 'a[id^="wp-rem-dev-apartment-save-"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
    _this_con = $('#wp-rem-dev-apartment-edit-con-' + _this_id),
    plot_val = _this_con.find('.apartment-plot').val();
    beds_val = _this_con.find('.apartment-beds').val();
    price_val = _this_con.find('.apartment-price-from').val();
    floor_val = _this_con.find('.apartment-floor').val();
    address_val = _this_con.find('.apartment-address').val();
    availibility_val = _this_con.find('.apartment-availability').val();
    link_val = _this_con.find('.apartment-link').val();
    
    var thisObj = jQuery('#wp-rem-dev-apartment-save-'+ _this_id +'');
    wp_rem_show_loader('#wp-rem-dev-apartment-save-'+ _this_id +'', '', 'button_loader', thisObj);

    $('#apartment-plot-' + _this_id).html('<h6>' + plot_val + '</h6>');
    $('#apartment-beds-' + _this_id).html('<h6>' + beds_val + '</h6>');
    $('#apartment-price-' + _this_id).html('<h6>' + price_val + '</h6>');
    $('#apartment-floor-' + _this_id).html('<h6>' + floor_val + '</h6>');
    $('#apartment-address-' + _this_id).html('<h6>' + address_val + '</h6>');
    $('#apartment-availability-' + _this_id).html('<h6>' + availibility_val + '</h6>');
    $('#apartment-title-' + _this_id).html('<h6>' + link_val + '</h6>');
    
    setTimeout(function () {
        wp_rem_show_response('', '', thisObj);
        _this_con.slideUp();
    }, 500);
});


/*
 * End Apartment
 */


/*
 * Adding Open House
 */

$(document).on('click', 'a[id^="wp-rem-dev-insert-opening_house-"]', function () {
    var _this_id = $(this).data('id'),
            _this_con = $('#wp-rem-dev-insert-opening_house-con-' + _this_id);
    _this_con.slideToggle();

});

/*
 * Add Open House 
 */

$(document).on('click', 'a[id^="wp-rem-dev-add-opening_house-"]', function () {
    "use strict";
    
    var     _this_ = $(this),
            _this_id = $(this).data('id'),
            ajax_url = $("#wp-rem-dev-posting-main-" + _this_id).data('ajax-url'),
            _plugin_url = $("#wp-rem-dev-posting-main-" + _this_id).data('plugin-url'),
            _this_con = $('#wp-rem-dev-insert-opening_house-con-' + _this_id),
            _date_field = _this_con.find('.opening-house-date'),
	    _time_from_field = _this_con.find('.opening-house-time-from'),
	    _time_to_field = _this_con.find('.opening-house-time-to'),
            _this_append = $('#wp-rem-dev-add-opening_house-app-' + _this_id),
            no_service_msg = _this_append.find('#no-opening_house-' + _this_id),
            this_loader = $('#dev-opening_house-loader-' + _this_id),
            this_act_msg = $('#wp-rem-dev-act-msg-' + _this_id);
    if (typeof _date_field !== 'undefined' && _date_field.val() != '') {
        
        var thisObj = jQuery('#wp-rem-dev-add-opening_house-'+ _this_id +'');
        wp_rem_show_loader('#wp-rem-dev-add-opening_house-'+ _this_id +'', '', 'button_loader', thisObj);

        var data = new FormData();
        data.append('date_field', _date_field.val());
        data.append('time_from_field', _time_from_field.val());
	data.append('time_to_field', _time_to_field.val());
        data.append('property_add_counter', _this_id);
        data.append('action', 'wp_rem_property_opening_house_to_list');
        
        var adding_opening_house = $.ajax({
            url: ajax_url,
            method: "POST",
            data: data,
            cache: false,
            dataType: "json",
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        }).done(function (response) {
            if (typeof response.html !== 'undefined') {
                no_service_msg.remove();
                _this_append.append(response.html);
                _date_field.val('');
                $('#wp-rem-dev-insert-opening_house-con-' + _this_id).find('.icons-selector .selector .selected-icon > i').removeAttr('class');
                $('#wp-rem-dev-insert-opening_house-con-' + _this_id).find('.icons-selector .selector .selected-icon > i').addClass('icon-cancel2');
                _time_from_field.val('');
		_time_to_field.val('');
	    }
            var response = {
                type: 'success',
                msg: wp_rem_property_strings.opening_house_added
            };
            wp_rem_show_response(response, '', thisObj);
            $('#wp-rem-dev-insert-opening_house-con-' + _this_id).slideUp();
        }).fail(function () {
            wp_rem_show_response('', '', thisObj);
        });
    } else {
        var response = {
            type: 'error',
            msg: wp_rem_property_strings.compulsory_fields
        };
        wp_rem_show_response(response);
    }
});

/*
 * Edit Opening House
 */

$(document).on('click', 'a[id^="wp-rem-dev-opening_house-edit-"]', function () {
    var _this_id = $(this).data('id'),
            _this_con = $('#wp-rem-dev-opening_house-edit-con-' + _this_id);
    _this_con.slideToggle();

});

$(document).on('click', 'a[id^="wp-rem-dev-opening_house-save-"]', function () {
    "use strict";
    var _this_id = $(this).data('id'),
    _this_con = $('#wp-rem-dev-opening_house-edit-con-' + _this_id),
    date_val = _this_con.find('.opening-house-date').val();
    var time_from_val = _this_con.find('.opening-house-time-from').val();
    var time_to_val = _this_con.find('.opening-house-time-to').val();
    
    var thisObj = jQuery('#wp-rem-dev-opening_house-save-'+ _this_id +'');
    wp_rem_show_loader('#wp-rem-dev-opening_house-save-'+ _this_id +'', '', 'button_loader', thisObj);

    $('#opening-house-date-' + _this_id).html('<h6>' + date_val + '</h6>');
    $('#opening-house-time-from-' + _this_id).html('<h6>' + time_from_val + '</h6>');
    $('#opening-house-time-to-' + _this_id).html('<h6>' + time_to_val + '</h6>');
    
    setTimeout(function () {
        wp_rem_show_response('', '', thisObj);
        _this_con.slideUp();
    }, 500);
});
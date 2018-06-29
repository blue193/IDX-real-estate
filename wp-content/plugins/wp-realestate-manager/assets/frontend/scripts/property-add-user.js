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

var first_time = true;
function change_tab(tab_id, e) {
    "use strict";
    if (typeof e != "undefined") {
        e.stopPropagation();
    }

    var change_tab_head = true;
    var this_li = $('.property-settings-nav > li a[data-act="' + tab_id + '"]');

    // Used by Register and Add property shortcode.
    if (this_li.hasClass('cond-property-settings1')) {
        var change_tab = true;
        var tab_container = this_li.data('act');
        var active_tab_container = $('.property-settings-nav > li.active a').data('act');
        if (active_tab_container == 'property-information') {
            if (!first_time) {
                change_tab = validate_register_add_property_form($(this).parents('form'));
            } else {
                change_tab = true;
            }
        } else if (active_tab_container == 'property-information') {
            change_tab = ($("input[name='wp_rem_property_package']:checked").length > 0 || $("input[name='wp_rem_property_active_package']:checked").length > 0);
        }

        if ((active_tab_container == tab_container) || change_tab) {
            $("#property-sets-holder ul.register-add-property-tab-container").hide();
            $("." + tab_container + "-tab-container", $("#property-sets-holder")).show();
        } else {
            change_tab_head = false;
        }
    }

    if (change_tab_head) {
        if ($(this_li).hasClass('cond-property-settings1')) {
            $('html,body').animate({scrollTop: 0}, 1000);
        }

        if (!first_time || this_li.parent('li').hasClass('cond-property-settings')) {
            $('.property-settings-nav > li').removeClass('processing');
            if (tab_id == "property-information") {
            } else if (tab_id == "property-detail-info") {
            } else if (tab_id == "package") {
            } else if (tab_id == "payment-information") {
            } else if (tab_id == "activation") {
            }

            this_li.parent('li').addClass('active processing');
        }
    }

    if (first_time) {
        first_time = false;
    }
}

$(document).ready(function ($, e) {
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
    return validate_register_add_property_form(this);
});

$(document).on('submit', 'form.wp-rem-dev-property-form', function () {
    "use strict";
    var returnType = wp_rem_validation_process(jQuery(".wp-rem-dev-property-form"));

    if (returnType == false) {
        return false;
    } else {
        var thisObj = jQuery('#update-property-holder');
        wp_rem_show_loader('#update-property-holder', '', 'button_loader', thisObj);
    }
    return validate_register_add_property_form(this);
});

function validate_register_add_property_form(that) {
    "use strict";
    var req_class = 'wp-rem-dev-req-field',
            _this_form = $(that),
            _this_id = $(that).data('id'),
            form_validity = 'valid';
    var is_already_animated = false;
    var animate_to = '';
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
                if ($("option:selected", $(element)).attr('value') != '') {
                    $(element).next('.chosen-container').css({"border": "1px solid #eceef4"});
                } else if ($("option:selected", $(element)).attr('value') == '') {
                    form_validity = 'invalid';
                    $(element).next('.chosen-container').css({"border": "1px solid #ff0000"});
                    animate_to = $(element).parent().parent();
                }
            } else if ($(element).is('textarea')) {
                if ($(element).val() != '') {
                    $(element).parents('.jqte').attr("style", "border: 1px solid #eceef4 !important;");
                    $(element).attr("style", "border: 1px solid #eceef4 !important;");
                } else if ($(element).val() == '') {
                    form_validity = 'invalid';
                    $(element).parents('.jqte').attr("style", "border: 1px solid #ff0000 !important;");
                    $(element).attr("style", "border: 1px solid #ff0000 !important;");
                    animate_to = $(element).parent().parent();
                }
            } else {
                if ($(element).val() != '') {
                    $(element).css({"border": "1px solid #eceef4"});
                    $(element).parent().parent().parent().css({"border": "none"});
                } else if ($(element).val() == '') {
                    form_validity = 'invalid';
                    if ($(element).hasClass('wp_rem_editor')) {
                        $(element).parent().parent().parent().css({"border": "1px solid #ff0000"});
                        animate_to = $(element).parent().parent().parent();
                    } else {
                        $(element).css({"border": "1px solid #ff0000"});
                        animate_to = $(element);
                    }
                }
            }
            if (!is_already_animated) {
                if (animate_to != '') {
                    $('html, body').animate({scrollTop: $(animate_to).offset().top - 100}, 1000);
                    is_already_animated = true;
                }
            }
        }
        if ($(element).hasClass('usererror')) {
            form_validity = 'invalid';
            $(element).css({"border": "1px solid #ff0000"});
        }
    });

    if (form_validity == 'valid') {
        return true;
    } else {
        return false;
    }
}

function getParameterByName(name) {
    "use strict";
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

$(document).on('click', '.property-settings-nav > li.cond-property-settings', function (e) {
    change_tab($(this).data('act'), e);
});

$(document).on('click', '.cond-property-settings', function () {
    "use strict";

    var _this = $(this);
    var _this_act = _this.data('act');
    var _main_counter = _this.parents('ul').data('mcounter');
    var property_id = _this.parents('ul').data('property');
    var ajax_url = wp_rem_property_strings.ajax_url;

    if (typeof _this_act !== 'undefined' && _this_act != '') {

        var this_action = 'property_show_set_' + _this_act;
        wp_rem_show_loader('.loader-holder');
        $.ajax({
            url: ajax_url,
            method: "POST",
            data: {
                set_type: _this_act,
                _main_counter: _main_counter,
                property_id: property_id,
                action: this_action
            },
            dataType: "json"
        }).done(function (response) {
            $('#property-sets-holder').html(response.html);
            chosen_selectionbox();
            var data_vals = 'tab=add-property&property_id=' + property_id + '&property_tab=' + _this_act;
            var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_vals;
            window.history.pushState(null, null, decodeURIComponent(current_url));
            wp_rem_hide_loader();
        }).fail(function () {
            wp_rem_hide_loader();
        });
    }
});

function property_pkg_info_show(pkg_id, p_type, p_price) {
    var property_doing = $("#property-sets-holder").attr('data-doing');
    var package_tab = $('a[data-act="package"]');
    var appender = $('.wp-rem-dev-property-pckg-info');
    $.ajax({
        url: wp_rem_property_strings.ajax_url,
        method: "POST",
        data: {
            p_price: p_price,
            p_type: p_type,
            pkg_id: pkg_id,
            action: 'wp_rem_show_property_pkg_info'
        },
        dataType: "json"
    }).done(function (response) {
        appender.html(response.html);
        if (response.show_pay == 'hide') {
            if (property_doing == 'updating') {
                $('#register-property-order').val(wp_rem_property_strings.update_txt);
            } else {
                $('#register-property-order').val(wp_rem_property_strings.create_list_txt);
            }
            package_tab.html(wp_rem_property_strings.update_txt);
            $('.register-payment-gw-holder').hide();
        } else {
            $('#register-property-order').val(wp_rem_property_strings.submit_order_txt);
            package_tab.html(wp_rem_property_strings.payment_txt);
            $('.register-payment-gw-holder').show();
        }
    }).fail(function () {

    });
}

function property_ajax_pkg_activation_msg(that) {
    
    var appender = $('.wp-rem-dev-property-pckg-info');
    $.ajax({
        url: wp_rem_property_strings.ajax_url,
        method: "POST",
        data: {
            p_pkg: 'ajax',
            action: 'wp_rem_show_pkg_activation_msg'
        },
        dataType: "json"
    }).done(function (response) {
        appender.html(response.html);
        appender.parents('ul.package-tab-container').find('.btns-section').hide();
        var response = {
            type: 'success',
            msg: wp_rem_property_strings.property_created
        };
        wp_rem_show_response(response);
        that.prop('disabled', false);
    }).fail(function () {
        var response = {
            type: 'success',
            msg: wp_rem_property_strings.property_created
        };
        wp_rem_show_response(response);
        that.prop('disabled', false);
    });
}

// Used by Register and Add property shortcode.
function add_event_listners(strings, $) {
    "use strict";
    $("select").trigger("chosen:updated");

    var property_doing = $("#property-sets-holder").attr('data-doing');
    
    $(document).on('click', '.dir-purchased-packages .dev-property-pakcge-step', function (e) {
        var pkg_id = $(this).data('id');
        $('#package-'+ pkg_id).prop('checked', true);
    });
    
    $(document).on('click', '.dev-property-pakcge-step', function (e) {
        e.stopPropagation();
        var this_id = $(this).data('main-id');
        var pkg_id = $(this).data('id');
        
        var pkg_ptype = $(this).data('ptype');
        var pkg_ppric = $(this).data('ppric');
        var img_nums = $(this).data('picnum');
        var doc_nums = $(this).data('docnum');
        
        var is_form_valid = validate_register_add_property_form($(this).parents('ul#wp-rem-dev-main-con-' + this_id));

        if (is_form_valid) {
            // update image nums
            $('ul.property-photos-tab-container').find('.wp_rem_dev_property_gallery_images').attr('data-count', img_nums);
            //
            // update doc nums
            $('ul.property-photos-tab-container').find('.wp_rem_property_attachment_images').attr('data-count', doc_nums);
            //
            var package_tab = $('a[data-act="package"]');
            if ($("input[name='wp_rem_property_package']:checked").length > 0 && ($("input[name='wp_rem_property_package']:checked").parents('td').find('a').attr('data-ppric') == 'free')) {
                $("input[name='trans_first_name'], input[name='trans_last_name'], input[name='trans_email'], input[name='trans_phone_number'], textarea[name='trans_address']").removeClass('wp-rem-dev-req-field');
            } else {
                $("input[name='trans_first_name'], input[name='trans_last_name'], input[name='trans_email'], input[name='trans_phone_number'], textarea[name='trans_address']").addClass('wp-rem-dev-req-field');
            }
            
            if (($("input[name='wp_rem_property_package']:checked").length > 0 || $("input[name='wp_rem_property_active_package']:checked").length > 0) && property_doing != 'updating') {
                $('li[data-act="property-detail-info"]').addClass('active processing');
                change_tab('property-detail-info', e);
            } else if (($("input[name='wp_rem_property_package']:checked").length > 0 || $("input[name='wp_rem_property_active_package']:checked").length > 0) && strings.is_property_posting_free != "on" && property_doing == 'updating') {
                package_tab.html(wp_rem_property_strings.payment_txt);
                $('.register-payment-gw-holder').show();
                $('#register-property-order').val(wp_rem_property_strings.submit_order_txt);
                $('li[data-act="property-detail-info"]').addClass('active processing');
                change_tab('property-detail-info', e);
            } else {
                if (property_doing == 'updating') {
                    package_tab.html(wp_rem_property_strings.update_txt);
                    $('.register-payment-gw-holder').hide();
                    $('#register-property-order').val(wp_rem_property_strings.update_txt);
                    $('li[data-act="property-detail-info"]').addClass('active processing');
                    change_tab('property-detail-info', e);
                } else {
                    var response = {
                        type: 'error',
                        msg: strings.package_required_error
                    };
                    wp_rem_show_response(response);
                }
            }
            property_pkg_info_show(pkg_id, pkg_ptype, pkg_ppric);
        }
        return false;
    });

    $("#btn-next-property-information").click(function (e) {
        e.stopPropagation();
        var this_id = $(this).data('id');
        var is_form_valid = validate_register_add_property_form($(this).parents('ul#wp-rem-dev-main-con-' + this_id));

        if (is_form_valid) {
            var package_tab = $('a[data-act="package"]');
            if (($("input[name='wp_rem_property_package']:checked").length > 0 || $("input[name='wp_rem_property_active_package']:checked").length > 0) && property_doing != 'updating') {
                $('li[data-act="property-detail-info"]').addClass('active processing');
                change_tab('property-detail-info', e);
            } else if (($("input[name='wp_rem_property_package']:checked").length > 0 || $("input[name='wp_rem_property_active_package']:checked").length > 0) && strings.is_property_posting_free != "on" && property_doing == 'updating') {
                package_tab.html(wp_rem_property_strings.payment_txt);
                $('.register-payment-gw-holder').show();
                $('#register-property-order').val(wp_rem_property_strings.submit_order_txt);
                $('li[data-act="property-detail-info"]').addClass('active processing');
                change_tab('property-detail-info', e);
            } else {
                if (property_doing == 'updating') {
                    package_tab.html(wp_rem_property_strings.update_txt);
                    $('.register-payment-gw-holder').hide();
                    $('#register-property-order').val(wp_rem_property_strings.update_txt);
                    $('li[data-act="property-detail-info"]').addClass('active processing');
                    change_tab('property-detail-info', e);
                } else {
                    var response = {
                        type: 'error',
                        msg: strings.package_required_error
                    };
                    wp_rem_show_response(response);
                }
            }
        }
        return false;
    });

    $(document).on('click', '.dev-property-pakcge-login-step', function (e) {
        e.stopPropagation();
        var this_id = $(this).data('main-id');
        var pkg_id = $(this).data('id');
        var pkg_ptype = $(this).data('ptype');
        var pkg_ppric = $(this).data('ppric');

        var is_form_valid = validate_register_add_property_form($(this).parents('ul#wp-rem-dev-main-con-' + this_id));

        var this_container = $(this).parents('ul#wp-rem-dev-main-con-' + this_id);

        property_pkg_info_show(pkg_id, pkg_ptype, pkg_ppric);
        if (is_form_valid) {
            if ($("input[name='wp_rem_property_package']:checked").length > 0 || $("input[name='wp_rem_property_active_package']:checked").length > 0 || strings.is_property_posting_free == "on") {
                $('#sign-in').modal('show');
                $('#sign-in').find('div[id^="user-login-tab-"]').addClass('active in');
                $('#sign-in').find('div[id^="user-register-"]').removeClass('active in');
                var property_type = this_container.find('input[name="wp_rem_property_type"]:checked').val();
                var property_categ = '';
                var property_sub_categ = '';
                var property_categ_list = this_container.find('ul.property-cats-list').find('li');
                if (property_categ_list.length > 0) {
                    property_categ = this_container.find('ul.property-cats-list').find('li input:checked').val();
                    if (this_container.find('.wp_rem_property_category_field').find('select').length > 0) {
                        property_sub_categ = this_container.find('.wp_rem_property_category_field').find('select').val();
                    }
                }

                var property_pkge = '';
                if (this_container.find('input[name="wp_rem_property_package"]').length > 0) {
                    property_pkge = this_container.find('input[name="wp_rem_property_package"]:checked').val();
                }

                if (this_container.find('input[name="wp_rem_property_active_package"]').length > 0) {
                    property_pkge = this_container.find('input[name="wp_rem_property_active_package"]:checked').val();
                }

                $.ajax({
                    url: wp_rem_property_strings.ajax_url,
                    method: "POST",
                    data: {
                        login_type: 'create_property',
                        login_property_type: property_type,
                        login_property_categ: property_categ,
                        login_property_sub_categ: property_sub_categ,
                        login_property_pkge: property_pkge,
                        action: 'wp_rem_create_property_login'
                    },
                    dataType: "json"
                }).done(function () {});
            } else {
                var response = {
                    type: 'error',
                    msg: strings.package_required_error
                };
                wp_rem_show_response(response);
            }
        }
        return false;
    });

    $("#btn-next-user-login").click(function (e) {
        e.stopPropagation();
        var this_id = $(this).data('id');
        var is_form_valid = validate_register_add_property_form($(this).parents('ul#wp-rem-dev-main-con-' + this_id));

        var this_container = $(this).parents('ul#wp-rem-dev-main-con-' + this_id);

        if (is_form_valid) {
            if ($("input[name='wp_rem_property_package']:checked").length > 0 || $("input[name='wp_rem_property_active_package']:checked").length > 0 || strings.is_property_posting_free == "on") {
                $('#sign-in').modal('show');
                $('#sign-in').find('div[id^="user-login-tab-"]').addClass('active in');
                $('#sign-in').find('div[id^="user-register-"]').removeClass('active in');
                var property_type = this_container.find('input[name="wp_rem_property_type"]:checked').val();
                var property_categ = '';
                var property_sub_categ = '';
                var property_categ_list = this_container.find('ul.property-cats-list').find('li');
                if (property_categ_list.length > 0) {
                    property_categ = this_container.find('ul.property-cats-list').find('li input:checked').val();
                    if (this_container.find('.wp_rem_property_category_field').find('select').length > 0) {
                        property_sub_categ = this_container.find('.wp_rem_property_category_field').find('select').val();
                    }
                }

                var property_pkge = '';
                if (this_container.find('input[name="wp_rem_property_package"]').length > 0) {
                    property_pkge = this_container.find('input[name="wp_rem_property_package"]:checked').val();
                }

                if (this_container.find('input[name="wp_rem_property_active_package"]').length > 0) {
                    property_pkge = this_container.find('input[name="wp_rem_property_active_package"]:checked').val();
                }

                $.ajax({
                    url: wp_rem_property_strings.ajax_url,
                    method: "POST",
                    data: {
                        login_type: 'create_property',
                        login_property_type: property_type,
                        login_property_categ: property_categ,
                        login_property_sub_categ: property_sub_categ,
                        login_property_pkge: property_pkge,
                        action: 'wp_rem_create_property_login'
                    },
                    dataType: "json"
                }).done(function () {});
            } else {
                var response = {
                    type: 'error',
                    msg: strings.package_required_error
                };
                wp_rem_show_response(response);
            }
        }
        return false;
    });

    $("#btn-back-property-detail").click(function (e) {

        change_tab('property-information', e);
        $('li[data-act="property-detail-info"]').removeClass('active processing');
        return false;
    });

    $("#btn-next-property-detail").click(function (e) {
        var this_id = $(this).data('id');
        var is_form_valid = validate_register_add_property_form($(this).parents('ul#wp-rem-dev-main-con-' + this_id));

        if (is_form_valid) {
            change_tab('advance-options', e);
            $('li[data-act="advance-options"]').addClass('active processing');
        }
        return false;
    });

    $("#btn-back-advance-options").click(function (e) {

        change_tab('property-detail-info', e);
        $('li[data-act="advance-options"]').removeClass('active processing');
        return false;
    });

    $("#btn-next-advance-options").click(function (e) {
        var this_id = $(this).data('id');
        var is_form_valid = validate_register_add_property_form($(this).parents('ul#wp-rem-dev-main-con-' + this_id));

        if (is_form_valid) {
            change_tab('loc-address', e);
        }
        return false;
    });

    $("#btn-back-loc-address").click(function (e) {

        change_tab('advance-options', e);
        $('li[data-act="loc-address"]').removeClass('active processing');
        return false;
    });

    $("#btn-next-loc-address").click(function (e) {
        var this_id = $(this).data('id');
        var is_form_valid = validate_register_add_property_form($(this).parents('ul#wp-rem-dev-main-con-' + this_id));

        if (is_form_valid) {
            change_tab('property-photos', e);
        }
        return false;
    });

    $("#btn-back-property-photos").click(function (e) {

        change_tab('loc-address', e);
        $('li[data-act="property-photos"]').removeClass('active processing');
        return false;
    });

    $("#btn-next-property-photos").click(function (e) {
        var this_id = $(this).data('id');
        var is_form_valid = validate_register_add_property_form($(this).parents('ul#wp-rem-dev-main-con-' + this_id));

        if (is_form_valid) {
            if (strings.is_property_posting_free == "on") {
                process_form_add_property_and_register_user(strings, false, '');
            } else {
                change_tab('package', e);
            }
        }
        return false;
    });

    $("#btn-next-package").click(function (e) {
        e.stopPropagation();
        if ($("input[name='wp_rem_property_package']:checked").length > 0 || $("input[name='wp_rem_property_active_package']:checked").length > 0 || strings.is_property_posting_free == "on") {
            change_tab('payment-information', e);
        } else {
            var response = {
                type: 'error',
                msg: strings.package_required_error
            };
            wp_rem_show_response(response);
        }
        return false;
    });
    $(".wp-rem-dev-payment-form input[type='submit']").prop("disabled", false);

    $(document).on('click', '#register-property-order', function (e) {
        e.stopPropagation();
        
        var free_pkg = 'false';
        if( $("input[name='wp_rem_property_package']:checked").length > 0 && $("input[name='wp_rem_property_package']:checked").parents('td').find('a').attr('data-ppric') == 'free' ){
            free_pkg = 'true';
        }else if($("input[name='wp_rem_property_active_package']:checked").length > 0 && $("input[name='wp_rem_property_active_package']:checked").parents('td').find('a').attr('data-ppric') == 'free'){
            free_pkg = 'true';
        }else if( $(".dir-purchased-packages input[name='wp_rem_property_active_package']:checked").length > 0 && $(".dir-purchased-packages input[name='wp_rem_property_active_package']:checked").attr('data-ppric') == 'free' ){
            free_pkg = 'true';
        }
        
        if (property_doing == 'updating' && free_pkg != 'true' ) {
            var returnType = wp_rem_validation_process(jQuery(".wp-rem-dev-payment-form"));
            if (returnType == false) {
                return false;
            }
        } else if (property_doing != 'updating' && free_pkg != 'true' ) {
            var returnType = wp_rem_validation_process(jQuery(".wp-rem-dev-payment-form"));
            if (returnType == false) {
                return false;
            }
        }

        process_form_add_property_and_register_user(strings, true, '');

        return false;
    });

    $(document).on('click', '.do_updating_btn', function (e) {
        e.stopPropagation();

        process_form_add_property_and_register_user(strings, true, 'do_updating_btn');

        return false;
    });

    function process_form_add_property_and_register_user(strings, package_verification, do_update) {
        "use strict";
        var form_elem = $(".wp-rem-dev-payment-form");

        if (do_update == 'do_updating_btn') {
            that = $('.' + do_update);
        } else {
            var that = $("input[id='register-property-order']");
            if (that.length < 1) {
                that = $("input[type='submit']:last");
            }
        }

        var old_value = that.val();
        if (do_update == 'do_updating_btn') {
            var thisObj = $('.property-update-dashboard');
            wp_rem_show_loader('.property-update-dashboard', '', 'button_loader', thisObj);
        } else {
            var thisObj = jQuery('.wp-rem-property-submit-loader');
            wp_rem_show_loader('.wp-rem-property-submit-loader', '', 'button_loader', thisObj);
        }
        that.prop('disabled', true);

        if (do_update == 'do_updating_btn') {
            var loadr_div = $('.' + do_update).parents('.property-update-dashboard');
        } else {
            var loadr_div = jQuery('#register-property-order').parents('.wp-rem-property-submit-process');
        }

        loadr_div.addClass('active-ajax');

        var data = new FormData();

        if ($('.wp_rem_dev_property_gallery_images').length) {
            var files = $('.wp_rem_dev_property_gallery_images').prop('files');
            if (files.length > 0) {
                $.each($('.wp_rem_dev_property_gallery_images'), function (i, obj) {
                    $.each(obj.files, function (j, file) {
                        data.append('wp_rem_property_gallery_images[' + j + ']', file);
                    })
                });
            }
        }
        if ($('.wp_rem_property_floor_images').length) {
            var floor_files = $('.wp_rem_property_floor_images').prop('files');
            if (floor_files.length > 0) {
                $.each($('.wp_rem_property_floor_images'), function (i, obj) {
                    $.each(obj.files, function (j, file) {
                        data.append('wp_rem_property_floor_images[' + j + ']', file);
                    })
                });
            }
        }
        if ($('.wp_rem_property_attachment_images').length) {
            var attach_files = $('.wp_rem_property_attachment_images').prop('files');
            if (attach_files.length > 0) {
                $.each($('.wp_rem_property_attachment_images'), function (i, obj) {
                    $.each(obj.files, function (j, file) {
                        data.append('wp_rem_property_attachment_images[' + j + ']', file);
                    })
                });
            }
        }

        var other_data = $("form.wp-rem-dev-property-form").serializeArray();
        $.each(other_data, function (key, input) {
            data.append(input.name, input.value);
        });

        $.ajax({
            url: wp_rem_property_strings.ajax_url,
            method: "POST",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json"
        }).done(function (response) {
            if (response.status == true) {
                if (package_verification == true) {
                    if (property_doing == 'updating') {
                        if ($("input[name='wp_rem_property_package']:checked").length > 0 || $("input[name='wp_rem_property_active_package']:checked").length > 0) {
                            $("input[name='trans_id']").val(response.msg);
                            var page_location = window.location + "";
                            if (page_location.indexOf('?') > -1) {
                                page_location += '&tab=activation';
                            } else {
                                page_location += '?tab=activation';
                            }
                            $("input[name='trans_id']").parent().append('<input type="hidden" name="transaction_return_url" value="' + page_location + '">');
                            if ($("input[name='wp_rem_property_active_package']:checked").length > 0) {
                                var response = {
                                    type: 'success',
                                    msg: wp_rem_property_strings.property_created
                                };
                                wp_rem_show_response(response);
                                that.prop('disabled', false);
                            } else if ($("input[name='wp_rem_property_package']:checked").length > 0 && ($("input[name='wp_rem_property_package']:checked").parents('td').find('a').attr('data-ppric') == 'free')) {
                                property_ajax_pkg_activation_msg(that);
                                
                            } else {
                                process_payment_form(old_value, that, $("form.wp-rem-dev-property-form"));
                            }
                        } else {
                            var response = {
                                type: 'success',
                                msg: wp_rem_property_strings.property_updated
                            };
                            wp_rem_show_response(response);
                            that.prop('disabled', false);
                        }
                    } else {
                        $("input[name='trans_id']").val(response.msg);
                        var page_location = window.location + "";
                        if (page_location.indexOf('?') > -1) {
                            page_location += '&tab=activation';
                        } else {
                            page_location += '?tab=activation';
                        }
                        $("input[name='trans_id']").parent().append('<input type="hidden" name="transaction_return_url" value="' + page_location + '">');
                        if ($("input[name='wp_rem_property_active_package']:checked").length > 0) {
                            var response = {
                                type: 'success',
                                msg: wp_rem_property_strings.property_created
                            };
                            wp_rem_show_response(response);
                            that.prop('disabled', false);
                        } else if ($("input[name='wp_rem_property_package']:checked").length > 0 && ($("input[name='wp_rem_property_package']:checked").parents('td').find('a').attr('data-ppric') == 'free')) {
                            property_ajax_pkg_activation_msg(that);
                            
                        } else {
                            process_payment_form(old_value, that, $("form.wp-rem-dev-property-form"));
                        }
                    }
                } else {
                    change_tab('activation', undefined);
                }
                //wp_rem_show_response('', '', thisObj);
                that.prop('disabled', false);
            } else {
                if (typeof response.msg != "undefined") {
                    var response = {
                        type: 'error',
                        msg: response.msg
                    };
                    wp_rem_show_response(response);
                    that.prop('disabled', false);
                    return false;
                }
            }
            loadr_div.removeClass('active-ajax');
        }).fail(function () {
            loadr_div.removeClass('active-ajax');
            return false;
        });

        function process_payment_form(old_value, that, form_elem) {
            "use strict";
            var data = $(form_elem).serialize() + "&action=wp_rem_payment_gateways_package_selected";
            $.ajax({
                url: wp_rem_property_strings.ajax_url,
                method: "POST",
                data: data,
                'dataType': "json"
            }).done(function (response) {
                if (response.status == true && response.payment_gateway == "wooCommerce") {
                    jQuery("#property-sets-holder").append(response.msg);
                } else {
                    if (response.status == true) {
                        if (typeof response.payment_gateway != "undefined") {
                            if (response.payment_gateway == "WP_REM_PRE_BANK_TRANSFER") {
                                $(".reservation-form").html(response.msg);
                            } else {
                                $(".reservation-form").hide();
                                $(".payment-process-form-container").html(response.msg).find("form").submit();
                            }
                        }
                    } else {
                        if (typeof response.msg != "undefined") {
                            alert(response.msg);
                        }
                        $(that).html(old_value);
                        $(that).prop('disabled', false);
                    }
                }
            }).fail(function () {
                $(that).html(old_value);
                $(that).prop('disabled', false);
            });
        }
    }

    $("#btn-back-package").click(function (e) {
        e.stopPropagation();
        change_tab('property-photos', e);
        $('li[data-act="package"]').removeClass('active processing');
        return false;
    });

    $("#btn-back-payment-information").click(function (e) {
        e.stopPropagation();
        change_tab('package', e);
        return false;
    });
}

$(document).on('change', '.wp-rem-dev-username, .wp-rem-dev-user-email', function () {
    "use strict";
    var checkig_user,
            _this_ = $(this),
            _this_id = $(this).data('id'),
            _this_type = $(this).data('type'),
            _this_val = $(this).val(),
            ajax_url = wp_rem_property_strings.ajax_url,
            _plugin_url = wp_rem_property_strings.plugin_url,
            color,
            this_loader;

    if (_this_type == 'username') {
        this_loader = $('#wp-rem-dev-user-signup-' + _this_id).find('.wp-rem-dev-username-check');
    } else {
        this_loader = $('#wp-rem-dev-user-signup-' + _this_id).find('.wp-rem-dev-useremail-check');
    }

    this_loader.html('<div class="loader-holder" style="width:18px;"><img src="' + _plugin_url + 'assets/frontend/images/ajax-loader.gif" alt=""></div>');
    checkig_user = $.ajax({
        url: wp_rem_globals.ajax_url,
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

$(document).on('click', '.cus-num-field .btn-decrementmin-num', function () {
    "use strict";
    var inp = $(this).parents('.cus-num-field').find('input');
    if (inp.val() > 0) {
        var new_val = parseInt(inp.val()) - 1;
        inp.val(new_val);
    } else {
        inp.val(0);
    }
});

$(document).on('click', '.cus-num-field .btn-incrementmin-num', function () {
    "use strict";
    var inp = $(this).parents('.cus-num-field').find('input');
    if ($.isNumeric(inp.val())) {
        var new_val = parseInt(inp.val()) + 1;
        inp.val(new_val);
    } else {
        inp.val(0);
    }

});

$(document).on('click', '.wp-rem-dev-select-type', function () {
    "use strict";
    var selecting_type,
            _this_id = $(this).data('id'),
            _this_val = $(this).val(),
            _this_form = $("#wp-rem-dev-property-form-" + _this_id),
            ajax_url = wp_rem_property_strings.ajax_url,
            _plugin_url = wp_rem_property_strings.plugin_url,
            cf_append = $('#wp-rem-dev-cf-con'),
            main_append = $('#wp-rem-dev-main-con-' + _this_id),
            after_append = $('.wp-rem-dev-appended-cats'),
            price_append = $('.wp-rem-dev-appended-price'),
            pckgs_append = $('#property-membership-info-main'),
            this_loader = $(this).parent('.type-holder-main');

    this_loader.addClass('active-ajax');
    selecting_type = $.ajax({
        url: ajax_url,
        method: "POST",
        data: 'select_type=' + _this_val + '&p_property_typ=' + _this_val + '&property_add_counter=' + _this_id + '&action=wp_rem_property_load_cf_cats',
        dataType: "json"
    }).done(function (response) {
        if (typeof response.cf_html !== 'undefined') {
            cf_append.html(response.cf_html);
        }
        if (typeof response.cats_html !== 'undefined') {
            after_append.html(response.cats_html);
        }
        if (typeof response.price_html !== 'undefined') {
            price_append.html(response.price_html);
        }
        if (typeof response.pckgs_html !== 'undefined') {
            pckgs_append.html(response.pckgs_html);
        }
        this_loader.removeClass('active-ajax');
    }).fail(function () {
        this_loader.removeClass('active-ajax');
    });
});

$(document).on('click', '.property-pkg-select', function () {
    var _this_id = $(this).data('id');
    $('.pkg-selected').hide();
    $('#package-' + _this_id).prop('checked', true);
    $('#pkg-selected-' + _this_id).show();

});

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


/*
 * Floor Plan add property
 */
$(document).on('click', 'a[id^="wp-rem-dev-add-floor-plan-"]', function () {
    "use strict";

    var adding_service,
            _this_ = $(this),
            _this_id = $(this).data('id'),
            ajax_url = wp_rem_property_strings.ajax_url,
            _plugin_url = wp_rem_property_strings.plugin_url,
            _this_con = $('#wp-rem-dev-insert-floor-plan-con-' + _this_id),
            _title_field = _this_con.find('.floor-plan-title'),
            _desc_field = _this_con.find('.floor-plan-desc'),
            _this_append = $('#wp-rem-dev-add-floor-plan-app-' + _this_id),
            no_service_msg = _this_append.find('#no-floor-plan-' + _this_id),
            this_loader = $('#dev-floor-plans-loader-' + _this_id),
            this_act_msg = $('#wp-rem-dev-act-msg-' + _this_id);


    if (typeof _title_field !== 'undefined' && _title_field.val() != '') {

        var thisObj = jQuery('#wp-rem-dev-add-floor-plan-' + _this_id + '');
        wp_rem_show_loader('#wp-rem-dev-add-floor-plan-' + _this_id + '', '', 'button_loader', thisObj);


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

function wp_rem_property_price_calculating(obj, change_trigger) {
    "use strict";

    if (change_trigger == 'type') {
        var this_prcie = $('#wp_rem_property_price').val();
        var price_type = obj.val();
    } else {
        var this_prcie = obj.val();
        var price_type = $('#wp_rem_price_type').val();
    }
    var this_append = $('#wp-rem-property-calculating-price');
    var loader_append = $('#wp_rem_property_price_type_toggle').find('.price-loader');

    if ((price_type == 'variant_month' || price_type == 'variant_week') && this_prcie > 0) {
        loader_append.show();
        loader_append.html('<div class="loader-holder"><img src="' + wp_rem_property_strings.plugin_url + 'assets/frontend/images/ajax-loader.gif" alt=""></div>');
        var data = 'price=' + this_prcie + '&price_type=' + price_type + '&action=wp_rem_property_price_calculating';
        jQuery.ajax({
            url: wp_rem_property_strings.ajax_url,
            method: "POST",
            data: data,
            dataType: "json",
        }).done(function (response) {
            this_append.html(response.price);
            this_append.show();
            loader_append.html('');
            loader_append.hide();
        }).fail(function () {
            this_append.html('');
            this_append.hide();
            loader_append.html('');
            loader_append.hide();
        });
    } else {
        this_append.hide();
    }
}

$(document).on('keyup', '#wp_rem_property_price', function () {
    "use strict";
    var obj = $(this);
    wp_rem_property_price_calculating(obj, 'price');
});

$(document).on('change', '#wp_rem_price_type', function () {
    "use strict";
    var obj = $(this);
    wp_rem_property_price_calculating(obj, 'type');
});

/*
 * Add Near by 
 */

$(document).on('click', 'a[id^="wp-rem-dev-add-near-by-"]', function () {
    "use strict";
    var adding_service,
            _this_ = $(this),
            _this_id = $(this).data('id'),
            ajax_url = wp_rem_property_strings.ajax_url,
            _plugin_url = wp_rem_property_strings.plugin_url,
            _this_con = $('#wp-rem-dev-insert-near-by-con-' + _this_id),
            _title_field = _this_con.find('.near-by-title'),
            _desc_field = _this_con.find('.near-by-desc'),
            _this_append = $('#wp-rem-dev-add-near-by-app-' + _this_id),
            no_service_msg = _this_append.find('#no-near-by-' + _this_id),
            this_loader = $('#dev-near-by-loader-' + _this_id),
            this_act_msg = $('#wp-rem-dev-act-msg-' + _this_id);
    if (typeof _title_field !== 'undefined' && _title_field.val() != '') {

        var thisObj = jQuery('#wp-rem-dev-add-near-by-' + _this_id + '');
        wp_rem_show_loader('#wp-rem-dev-add-near-by-' + _this_id + '', '', 'button_loader', thisObj);

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

$(document).on('click', '.wp-rem-dev-insert-off-days .wp-rem-dev-calendar-days .day a', function () {
    "use strict";
    var adding_off_day,
            _this_ = $(this),
            _this_id = $(this).parents('.wp-rem-dev-insert-off-days').data('id'),
            ajax_url = wp_rem_property_strings.ajax_url,
            _plugin_url = wp_rem_property_strings.plugin_url,
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

    var thisObj = jQuery('#wp-rem-dev-floor-plan-save-' + _this_id + '');
    wp_rem_show_loader('#wp-rem-dev-floor-plan-save-' + _this_id + '', '', 'button_loader', thisObj);

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

    var thisObj = jQuery('#wp-rem-dev-near-by-save-' + _this_id + '');
    wp_rem_show_loader('#wp-rem-dev-near-by-save-' + _this_id + '', '', 'button_loader', thisObj);

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
    var _this_id = $(this).data('id'),
            this_triger = $('#image-uploader-' + _this_id);
    this_triger.trigger('click');
});

$(document).on('click', '.wp-rem-dev-attachment-upload-btn', function () {
    var _this_id = $(this).data('id'),
            this_triger = $('#attachment-uploader-' + _this_id);
    this_triger.trigger('click');
});

$(document).on('click', '.wp-rem-dev-floor-upload-btn', function () {
    var _this_id = $(this).data('id'),
            this_triger = $('#floor-uploader-' + _this_id);
    this_triger.trigger('click');
});

// Gallery btn
$(document).on('click', '.wp-rem-dev-featured-upload-btn', function () {
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


// add video cover
function wp_rem_handle_file_single_select_video(event, counter) {
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
    "use strict";
    //Check File API support
    if (window.File && window.FileList && window.FileReader) {
        
        var files = event.target.files;
        var image_file = true;

        var images_added_length = ($('#wp-rem-dev-gal-attach-sec-' + counter).find('li.gal-img').length) + files.length;
        var images_num_allowed = $('#image-uploader-' + counter).attr('data-count');
        
        if (images_added_length <= images_num_allowed) {
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

                            document.getElementById("wp-rem-dev-gal-attach-sec-" + counter).innerHTML = '\
                            <li class="gal-img">\
                                <div class="drag-list">\
                                    <div class="item-thumb"><img class="thumbnail" src="' + picFile.result + '" alt=""/></div>\
                                    <div class="item-assts">\
                                        <div class="list-inline pull-right">\
                                            <div class="close-btn" data-id="' + counter + '"><a href="javascript:void(0);"><i class="icon-cross-out"></i></a></div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </li>' + document.getElementById("wp-rem-dev-gal-attach-sec-" + counter).innerHTML;
                        }
                        $('#wp-rem-dev-gal-attach-sec-' + counter).sortable({
                            handle: '.drag-list',
                            cursor: 'move'
                        });
                    });
                    //Read the image
                    picReader.readAsDataURL(file);
                }
            }
        } else {
            alert(wp_rem_property_strings.more_than_f + " " + images_num_allowed + " " + wp_rem_property_strings.more_than_image_change);
        }
    } else {
        alert("Your browser does not support File API");
    }
}

function wp_rem_handle_attach_file_select(event, counter) {
    "use strict";
    //Check File API support
    if (window.File && window.FileList && window.FileReader) {

        var files = event.target.files;
        var docs_added_length = ($('#wp-rem-dev-docs-attach-sec-' + counter).find('li.gal-img').length) + files.length;
        var docs_num_allowed = $('#attachment-uploader-' + counter).attr('data-count');
        
        var allowd_extnx_erer = $("#wp-rem-dev-docs-attach-sec-" + counter).data('ext-error');
        var allowd_extnx = $("#wp-rem-dev-docs-attach-sec-" + counter).data('allow-ext');
        allowd_extnx = allowd_extnx.split(",");

        var is_error = false;
        
        if (docs_added_length <= docs_num_allowed) {

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var file_name = file.name;
                var file_ext = file_name.split(".").pop().toLowerCase();
                if (jQuery.inArray(file_ext, allowd_extnx) == -1) {
                    is_error = true;
                } else {

                    var img_thumb = wp_rem_property_strings.plugin_url + '/assets/common/attachment-images/attach-' + file_ext + '.png';
                    document.getElementById("wp-rem-dev-docs-attach-sec-" + counter).innerHTML = '\
                    <li class="gal-img">\
                        <div class="drag-list">\
                            <div class="item-thumb"><img class="thumbnail" src="' + img_thumb + '" alt=""/></div>\
                            <div class="item-assts">\
                                <div class="list-inline pull-right">\
                                    <div class="close-btn" data-id="' + counter + '"><a href="javascript:void(0);"><i class="icon-cross-out"></i></a></div>\
                                </div>\
                            </div>\
                        </div>\
                    </li>' + document.getElementById("wp-rem-dev-docs-attach-sec-" + counter).innerHTML;

                    $('#wp-rem-dev-docs-attach-sec-' + counter).sortable({
                        handle: '.drag-list',
                        cursor: 'move'
                    });
                }
            }
            if (is_error === true) {
                alert(allowd_extnx_erer);
                return false;
            }
        } else {
            alert(wp_rem_property_strings.more_than_f + " " + docs_num_allowed + " " + wp_rem_property_strings.more_than_doc_change);
        }
    } else {
        alert("Your browser does not support File API");
    }
}

//add Gallery
function wp_rem_handle_floor_file_select(event, counter) {
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
                        document.getElementById("wp-rem-dev-floor-attach-sec-" + counter).innerHTML = '\
                        <li class="gal-img">\
                            <div class="drag-list">\
                                <div class="item-thumb"><img class="thumbnail" src="' + picFile.result + '" alt=""/></div>\
                                <div class="item-assts">\
                                    <div class="list-inline pull-right">\
                                        <div class="close-btn" data-id="' + counter + '"><a href="javascript:void(0);"><i class="icon-cross-out"></i></a></div>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>' + document.getElementById("wp-rem-dev-floor-attach-sec-" + counter).innerHTML;
                    }
                    $('#wp-rem-dev-floor-attach-sec-' + counter).sortable({
                        handle: '.drag-list',
                        cursor: 'move'
                    });
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
    var this_id = $(this).attr('data-id');
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
    $('.all-pckgs-sec').find('.wp-rem-pkg-header').removeClass('active-pkg');

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
        $(this).html(wp_rem_property_strings.close_txt);
    } else {
        package_detail_sec.slideUp();
        $(this).html(wp_rem_property_strings.detail_txt);
    }

});

// Package check Click
$(document).on('click', '.pkg-detail-btn .check-select', function () {
    "use strict";
    var input_radio = $(this).parents('.pkg-detail-btn').find('input[type="radio"]');

    if (!input_radio.is(':checked')) {
        $(this).parents('.wp-rem-pkg-header').addClass('active-pkg');
        input_radio.prop('checked', true);
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
        _this.parents('.wp-rem-pkg-holder').find('.wp-rem-pkg-header').removeClass('active-pkg');
    });
    package_btn.prop('checked', false);
    $('.register-payment-gw-holder').slideUp();
    $('#register-property-order').hide();
    _this.parents('.wp-rem-pkg-holder').find('input[name="wp_rem_property_featured"]').prop('checked', false);
    _this.parents('.wp-rem-pkg-holder').find('input[name="wp_rem_property_top_cat"]').prop('checked', false);
});

// Package Select Submit Click
$(document).on('click', '.pkg-choose-btn', function () {
    "use strict";
    var _this = $(this),
            _this_id = _this.data('id'),
            package_detail_sec = $('#package-detail-' + _this_id),
            package_btn = $('#package-' + _this_id);
    $('.all-pckgs-sec').find('.wp-rem-pkg-header').removeClass('active-pkg');

    package_btn.prop('checked', true);
    $('.register-payment-gw-holder').slideDown();
    $('#register-property-order').show();
    package_detail_sec.slideUp(400, function () {
        _this.parents('.wp-rem-pkg-holder').find('.wp-rem-pkg-header').addClass('active-pkg');
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
    "use strict";
    var _this_id = $(this).data('id'),
            _this_con = $('#wp-rem-dev-insert-attachments-con-' + _this_id);
    _this_con.slideToggle();
});

$(document).on('click', 'a[id^="wp-rem-dev-add-attachments-"]', function () {
    "use strict";
    var adding_service,
            _this_ = $(this),
            _this_id = $(this).data('id'),
            ajax_url = wp_rem_property_strings.ajax_url,
            _this_con = $('#wp-rem-dev-insert-attachments-con-' + _this_id),
            _title_field = _this_con.find('.attachment-title'),
            _file_field = _this_con.find('.attachment-file'),
            _this_append = $('#wp-rem-dev-add-attachments-app-' + _this_id),
            no_attachments_msg = _this_append.find('#no-attachments-' + _this_id),
            this_act_msg = $('#wp-rem-dev-act-msg-' + _this_id);
    if (typeof _title_field !== 'undefined' && _title_field.val() != '' && typeof _file_field !== 'undefined' && _file_field.val() != '') {

        var thisObj = jQuery('#wp-rem-dev-add-attachments-' + _this_id + '');
        wp_rem_show_loader('#wp-rem-dev-add-attachments-' + _this_id + '', '', 'button_loader', thisObj);

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
    if (typeof this_id !== 'undefined') {
        jQuery('span.allowed-extensions-' + this_id).css('color', '');
    } else {
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
            if (typeof this_id !== 'undefined') {
                jQuery('span.allowed-extensions-' + this_id).css('color', 'red');
            } else {
                jQuery('span.allowed-extensions').css('color', 'red');
            }
            wp_rem_show_response(response);
            jQuery('.attachment-file').val('');
            $('.attachment-file-viewer-holder').hide();
            $('img.attachment-file-viewer').attr('src', '');
            return false;
        } else {
            if (typeof this_id !== 'undefined') {
                $('img.attached-file-' + this_id).attr('src', wp_rem_property_strings.plugin_url + '/assets/common/attachment-images/attach-' + ext + '.png');
            } else {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('img.attachment-file-viewer')
                            .attr('src', wp_rem_property_strings.plugin_url + '/assets/common/attachment-images/attach-' + ext + '.png');
                };
                reader.readAsDataURL(input.files[0]);
                $('.attachment-file-viewer-holder').show();
            }
        }
    }
});
$(document).on('click', 'a[id^="wp-rem-dev-attachments-edit-"]', function () {
    "use strict";
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

    var thisObj = jQuery('#wp-rem-dev-attachments-save-' + _this_id + '');
    wp_rem_show_loader('#wp-rem-dev-attachments-save-' + _this_id + '', '', 'button_loader', thisObj);

    var input = _this_con.find('input[type="file"]')[0];
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var ext = input.value.match(/\.(.+)$/)[1];
        reader.onload = function (e) {
            _this_con.find('img').attr('src', wp_rem_property_strings.plugin_url + '/assets/common/attachment-images/attach-' + ext + '.png');
            $('#attachment-file-' + _this_id + ' img').attr('src', wp_rem_property_strings.plugin_url + '/assets/common/attachment-images/attach-' + ext + '.png');
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
            ajax_url = wp_rem_property_strings.ajax_url,
            _plugin_url = wp_rem_property_strings.plugin_url,
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

        var thisObj = jQuery('#wp-rem-dev-add-apartment-' + _this_id + '');
        wp_rem_show_loader('#wp-rem-dev-add-apartment-' + _this_id + '', '', 'button_loader', thisObj);

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

    var thisObj = jQuery('#wp-rem-dev-apartment-save-' + _this_id + '');
    wp_rem_show_loader('#wp-rem-dev-apartment-save-' + _this_id + '', '', 'button_loader', thisObj);

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
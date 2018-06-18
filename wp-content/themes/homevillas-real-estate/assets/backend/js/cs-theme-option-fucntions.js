function theme_option_save(admin_url, theme_url) {
    "use strict";

    jQuery(".form-msg > i").show();
    jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);
    function newValues() {
        var serializedValues = jQuery("#frm input,#frm select,#frm textarea[name!=wp_rem_cs_var_export_theme_options]").serialize();
        return serializedValues;
    }
    var serializedReturn = newValues();
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: serializedReturn,
        dataType: 'json',
        success: function (response) {

            if (typeof response.purchase_code !== 'undefined' && response.purchase_code == 'true') {
                jQuery(".form-msg > i").hide();
                jQuery(".outerwrapp-layer .loading_div").fadeOut(100);
                jQuery(".form-msg .innermsg").html(response.msg);
                jQuery(".form-msg").show();
            } else {
                jQuery(".loading_div").hide();
                jQuery(".form-msg .innermsg").html(response.msg);
                jQuery(".form-msg").show();
                jQuery(".outerwrapp-layer").delay(100).fadeOut(100)
                window.location.reload(true);
                slideout();
            }
        }
    });
}

jQuery(document).on('click', '#purchase-code-cancel-btn', function () {
    jQuery(".outerwrapp-layer").delay(100).fadeOut(100);
    jQuery(".form-msg").hide();
});

jQuery(document).on('click', '#purchase-code-verify-btn', function () {
    var admin_url = wp_rem_theme_options_vars.ajax_url;
    if (jQuery("input[name='item-purchase-code']").val() != '') {
        jQuery('#verify-purchase-code-loader').html(wp_rem_theme_options_vars.purchase_verifiying);
        jQuery.ajax({
            "method": "post",
            "url": admin_url,
            "data": {
                "action": "wp_rem_cs_import_demo_data_callback",
                "action_type": "verify_purchase_code",
                "item_purchase_code": jQuery("input[name='item-purchase-code']").val(),
            },
            "dataType": "json",
        }).done(function (data) {
            if (data.success == true) {
                jQuery('#verify-purchase-code-loader').html('');
                jQuery(".outerwrapp-layer").delay(100).fadeOut(100);
                jQuery(".form-msg").hide();
            } else {
                jQuery('#verify-purchase-code-loader').html(wp_rem_theme_options_vars.verify_code_incorrect);
            }
        }).fail(function () {
            jQuery('#verify-purchase-code-loader').html('');
        });
    } else {
        jQuery('#verify-purchase-code-loader').html(wp_rem_theme_options_vars.verify_blank_error);
    }
});

jQuery(document).ready(function ($) {
    "use strict";
    $('.bg_color').wpColorPicker();
    $('[data-toggle="popover"]').popover();
});

function wp_rem_cs_var_rest_all_options(admin_url) {
    "use strict";

    var var_confirm = confirm("You current theme options will be replaced with the default theme activation options.");
    if (var_confirm == true) {
        var dataString = 'action=theme_option_rest_all';
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {

                jQuery(".form-msg").show();
                jQuery(".form-msg").html(response);
                jQuery(".loading_div").hide();

                window.location.reload(true);
                slideout();
            }
        });
    }
    //return false;
}

function wp_rem_cs_var_set_filename(file_value, file_path) {
    "use strict";
    jQuery(".backup_action_btns").find('input[type="button"]').attr('data-file', file_value);
    jQuery(".backup_action_btns").find('> a').attr('href', file_path + file_value);
    jQuery(".backup_action_btns").find('> a').attr('download', file_value);
}

function wp_rem_cs_var_backup_generate(admin_url) {
    "use strict";
    jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);

    var dataString = 'action=wp_rem_cs_var_settings_backup_generate';
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {

            jQuery(".loading_div").hide();
            jQuery(".form-msg .innermsg").html(response);
            jQuery(".form-msg").show();
            jQuery(".outerwrapp-layer").delay(100).fadeOut(100);
            window.location.reload(true);
            slideout();
        }
    });
    //return false;
}

jQuery('.backup_generates_area').on('click', '#cs-backup-delte', function () {
    "use strict";

    var var_confirm = confirm("This action will delete your selected Backup File. Are you want to continue?");
    if (var_confirm == true) {
        jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);

        var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
        var file_name = jQuery(this).data('file');

        var dataString = 'file_name=' + file_name + '&action=wp_rem_cs_var_backup_file_delete';
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {

                jQuery(".loading_div").hide();
                jQuery(".form-msg .innermsg").html(response);
                jQuery(".form-msg").show();
                jQuery(".outerwrapp-layer").delay(2000).fadeOut(100);
                window.location.reload(true);
                slideout();
            }
        });
        //return false;
    }
});

jQuery('.backup_generates_area').on('click', '#cs-backup-restore, #cs-backup-url-restore', function () {
    "use strict";

    jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);

    var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
    var file_name = jQuery(this).data('file');

    var dataString = 'file_name=' + file_name + '&action=wp_rem_cs_var_backup_file_restore';

    if (typeof (file_name) === 'undefined') {

        var file_name = jQuery('#bkup_import_url').val();

        var dataString = 'file_name=' + file_name + '&file_path=yes&action=wp_rem_cs_var_backup_file_restore';
    }

    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {

            jQuery(".loading_div").hide();
            jQuery(".form-msg .innermsg").html(response);
            jQuery(".form-msg").show();
            jQuery(".outerwrapp-layer").delay(2000).fadeOut(100);


            window.location.reload(true);
            slideout();
        }
    });
    //return false;
});

function wp_rem_cs_var_remove_image(id) {
    "use strict";
    var $ = jQuery;
    $('#' + id).val('');
    $('#' + id + '_img_div').hide();
}

jQuery(document).ready(function ($) {
    "use strict";
    jQuery(".sub-menu").parent("li").addClass("parentIcon");
    jQuery(document).on('click', 'a.nav-button', function (event) {
        $(".admin-navigtion").toggleClass("navigation-small");
    });
    jQuery(document).on('click', 'a.nav-button', function (event) {
        $(".inner").toggleClass("shortnav");
    });
    jQuery(document).on('click', '#frm .admin-navigtion > ul > li > a', function (event) {
        var a = $(this).next('ul')
        $(".admin-navigtion > ul > li > a").not($(this)).removeClass("changeicon")
        $(".admin-navigtion > ul > li ul").not(a).slideUp();
        $(this).next('.sub-menu').slideToggle();
        $(this).toggleClass('changeicon');
    });
});

function show_hide(id) {
    "use strict";
    var link = id.replace('#', '');
    jQuery('.horizontal_tab').fadeOut(0);
    jQuery('#' + link).fadeIn(400);
    if (link == 'custom_image_tab') {
        jQuery('#custom_image_position').fadeIn(400);
    }

}

function toggleDiv(id) {
    "use strict";
    jQuery('.col2').children().hide();
    jQuery(id).show();
    jQuery(id + " .main_tab").show();
    location.hash = id + "-show";
    var link = id.replace('#', '');
    jQuery('.categoryitems li').removeClass('active');
    jQuery(".menuheader.expandable").removeClass('openheader');
    jQuery(".categoryitems").hide();
    jQuery("." + link).addClass('active');
    jQuery("." + link).parent("ul").show().prev().addClass("openheader");
}
jQuery(document).ready(function () {
    "use strict";
    jQuery(".categoryitems").hide();
    jQuery(".categoryitems:first").show();
    jQuery(".menuheader:first").addClass("openheader");
    jQuery(".menuheader").live('click', function (event) {
        if (jQuery(this).hasClass('openheader')) {
            jQuery(".menuheader").removeClass("openheader");
            jQuery(this).next().slideUp(200);
            return false;
        }
        jQuery(".menuheader").removeClass("openheader");
        jQuery(this).addClass("openheader");
        jQuery(".categoryitems").slideUp(200);
        jQuery(this).next().slideDown(200);
        return false;
    });

    var hash = window.location.hash.substring(1);
    var id = hash.split("-show")[0];
    if (id) {
        jQuery('.col2').children().hide();
        jQuery("#" + id).show();
        jQuery('.categoryitems li').removeClass('active');
        jQuery(".menuheader.expandable").removeClass('openheader');
        jQuery(".categoryitems").hide();
        jQuery("#" + id).find('.main_tab').show();
        jQuery("." + id).addClass('active');
        jQuery("." + id).parent("ul").slideDown(300).prev().addClass("openheader");
    }
});

function social_icon_del(id) {
    "use strict";
    jQuery("#del_" + id).remove();
    jQuery("#" + id).remove();
}

function ads_del(id) {
    "use strict";
    jQuery("#del_" + id).remove();
    jQuery("#" + id).remove();
}

function wp_rem_cs_var_banner_type_toggle(type, id) {
    "use strict";
    if (type == 'image') {
        jQuery("#ads_image" + id).show();
        jQuery("#ads_code" + id).hide();
    } else if (type == 'code') {
        jQuery("#ads_image" + id).hide();
        jQuery("#ads_code" + id).show();
    }
}
function banner_widget_toggle(view, id) {
    "use strict";
    if (view == "random") {
        jQuery(".banner_style_field_" + id).show();
        jQuery(".banner_code_field_" + id).hide();
    } else if (view == "single") {
        jQuery(".banner_style_field_" + id).hide();
        jQuery(".banner_code_field_" + id).show();
    }
}

function wp_rem_cs_var_google_font_att(admin_url, att_id, id) {
    "use strict";

    var $ = jQuery;
    if (att_id != "") {
        jQuery('#' + id).parent().next().remove(0);
        jQuery('#' + id).parent().parent().append('<i style="font-size:20px;color:#ff6363;" class="icon-spinner icon-spin"></i>');
        jQuery('#' + id).parent().hide(0);
        var dataString = 'index=' + att_id + '&id=' + id +
                '&action=wp_rem_cs_var_get_google_font_attributes';
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery('#' + id).parent().show(0);
                jQuery('#' + id).parent().html(response);
                jQuery('#' + id).parent().next().remove(0);

            }
        });
    }
}

function wp_rem_cs_var_google_fonts_type(att_id, id) {
    "use strict";
    var $ = jQuery;
    if (att_id === "google_fonts") {
        jQuery('#wp_rem_cs_var_' + id + '_select').show();
        jQuery('.' + id + '_holder').show();
        jQuery('.custom_' + id + '_holder').hide();
        jQuery('#wp_rem_cs_var_' + id + '_att_select').show();

    } else {
        jQuery('#wp_rem_cs_var_' + id + '_select').hide();
        jQuery('.' + id + '_holder').hide();
        jQuery('.custom_' + id + '_holder').show();
        jQuery('#wp_rem_cs_var_' + id + '_att_select').hide();
    }
}


var counter_banner = 0;
function  wp_rem_cs_var_add_banner(admin_url) {
    "use strict";
    counter_banner++;
    var image_path = jQuery('#wp_rem_cs_var_banner_field_image').val();

    var banner_title_input = jQuery("#banner_title_input").val();
    var banner_style_input = jQuery("#banner_style_input").val();
    var banner_type_input = jQuery("#banner_type_input").val();
    var banner_field_url_input = jQuery("#banner_field_url_input").val();
    var banner_target_input = jQuery("#banner_target_input").val();
    var adsense_code_input = jQuery("#adsense_code_input").val();

    if (banner_style_input != "") {
        var dataString = 'image_path=' + image_path +
                '&banner_title_input=' + banner_title_input +
                '&banner_style_input=' + banner_style_input +
                '&banner_type_input=' + banner_type_input +
                '&banner_field_url_input=' + banner_field_url_input +
                '&banner_target_input=' + banner_target_input +
                '&counter_banner=' + counter_banner +
                '&adsense_code_input=' + adsense_code_input +
                '&action=wp_rem_cs_var_ads_banner';
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery("#banner_area").append(response);
                jQuery(".social-area").show(200);
                jQuery("#wp_rem_cs_var_banner_field_image,#banner_title_input,#banner_field_url_input,#adsense_code_input").val("");
                jQuery("#banner_style_input").val("image");
            }
        });
        //return false;
    }
}






var counter_social_network = 0;
function wp_rem_cs_var_add_social_icon(admin_url) {
    "use strict";

    counter_social_network++;
    var social_net_icon_path = jQuery("#wp_rem_cs_var_social_icon_input").val();
    var social_net_awesome = jQuery(".selected-icon i").attr("class");
    var cs_icon_group = jQuery(".selected-icon i").closest('.cs-icon-choser').find('.cs-icon-library').val();
    var social_net_url = jQuery("#social_net_url_input").val();
    var social_net_tooltip = jQuery("#social_net_tooltip_input").val();
    var social_font_awesome_color = jQuery("#social_font_awesome_color").val();
    if (social_net_url != "" && (social_net_icon_path != "" || social_net_awesome != "")) {
        var dataString = 'social_net_icon_path=' + social_net_icon_path +
                '&social_net_awesome=' + social_net_awesome +
                '&cs_icon_group=' + cs_icon_group +
                '&social_net_url=' + social_net_url +
                '&social_net_tooltip=' + social_net_tooltip +
                '&counter_social_network=' + counter_social_network +
                '&social_font_awesome_color=' + social_font_awesome_color +
                '&action=wp_rem_cs_var_add_social_icon';
        jQuery(".add-social-icon-button").append(' <span class="loader-spinner"><i class="icon-spinner"></i></span>');
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery(".wp-rem-social-list-wrap .wp-rem-list-layout").append(response);
                jQuery(".social-area").show(200);
                jQuery("#wp_rem_cs_var_social_icon_input,#social_net_awesome_input,#social_net_url_input,#social_net_tooltip_input").val("");
                jQuery("#social_font_awesome_color").val("");
                jQuery('.loader-spinner').remove();
            }
        });
        //return false;
    } else {
        alert(wp_rem_theme_options_vars.social_sharing_error);
    }
}


var counter_custom_font = 0;
function wp_rem_cs_var_add_custom_fonts(admin_url) {
    "use strict";

    counter_custom_font++;
    var custom_font_name = jQuery("#wp_rem_custom_font_name").val();
    var custom_font_woff = jQuery("#custom_fonts_woff").val();
    var custom_font_ttf = jQuery("#custom_fonts_ttf").val();
    var custom_font_svg = jQuery("#custom_fonts_svg").val();
    var custom_font_eot = jQuery("#custom_fonts_eot").val();
    if (custom_font_name != "" && custom_font_woff != "" && custom_font_ttf != "" && custom_font_svg != "" && custom_font_eot != "") {
        var dataString = 'custom_font_name=' + custom_font_name +
                '&custom_font_woff=' + custom_font_woff +
                '&custom_font_ttf=' + custom_font_ttf +
                '&custom_font_svg=' + custom_font_svg +
                '&counter_custom_font=' + counter_custom_font +
                '&custom_font_eot=' + custom_font_eot +
                '&action=wp_rem_cs_var_add_custom_font';
        jQuery(".add-custom-font-button").append(' <span class="font-loader-spinner"><i class="icon-spinner"></i></span>');
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery(".wp-rem-custom-fonts-list-wrap").show();
                jQuery(".wp-rem-custom-fonts-list-wrap .wp-rem-list-layout").append(response);
                jQuery("#wp_rem_custom_font_name,#custom_fonts_woff,#custom_fonts_ttf,#custom_fonts_svg,#custom_fonts_eot").val("");
                jQuery('.font-loader-spinner').remove();
            }
        });
        //return false;
    } else {
        alert(wp_rem_theme_options_vars.social_sharing_error);
    }
}


var counter_clients = 0;
function wp_rem_cs_var_clients(admin_url) {
    "use strict";
    counter_clients++;
    var clients_image = jQuery("#wp_rem_cs_var_clients_image").val();
    var clients_title = jQuery("#clients_title").val();
    var clients_url = jQuery("#clients_url").val();
    if (clients_image != "") {
        jQuery(".add-clients-button").append(' <span class="loader-spinner"><i class="icon-spinner"></i></span>');
        var dataString = 'clients_image=' + clients_image +
                '&clients_title=' + clients_title +
                '&clients_url=' + clients_url +
                '&counter_clients=' + counter_clients +
                '&action=wp_rem_cs_var_add_clients';

        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery(".wp-rem-clients-list-wrap .wp-rem-list-layout").append(response);
                jQuery(".clients-area").show(200);
                jQuery("#wp_rem_cs_var_clients_image,#clients_title,#clients_url").val("");
                jQuery('.loader-spinner').remove();
            }
        });
        //return false;
    } else {
        alert(wp_rem_theme_options_vars.client_logo_error);
    }
}
function select_bg(layout, value, theme_url, admin_url) {
    "use strict";
    var $ = jQuery;
    jQuery('input[name="' + layout + '"]').live('click', function () {
        jQuery(this).parent().parent().find(".check-list").removeClass("check-list");
        jQuery(this).siblings("label").children("#check-list").addClass("check-list");
        jQuery(this).addClass('selected').siblings().removeClass('selected');
    });
    if (value == 'boxed' && layout == 'wp_rem_cs_var_layout') {
        jQuery('.horizontal_tabs,.main_tab').show();
        jQuery('.main_tab #background_tab').show();
        jQuery('.main_tab #custom_favicon').show();
    } else if (value == 'full_width' && layout == 'wp_rem_cs_var_layout') {
        jQuery('.horizontal_tabs,.main_tab').hide();
        jQuery('.main_tab #background_tab').hide();
        jQuery('.main_tab #custom_favicon').hide();
    }

    jQuery('input[name="' + layout + '"]').live('click', function () {
        jQuery(this).parent().parent().find(".check-list").removeClass("check-list");
        jQuery(this).siblings("label").children("#check-list").addClass("check-list");
        jQuery(this).addClass('selected').siblings().removeClass('selected');
    });
    if (value == 'boxed' && layout == 'wp_rem_cs_layout') {
        jQuery('.horizontal_tabs,.main_tab').show();
    } else if (value == 'full_width' && layout == 'wp_rem_cs_layout') {
        jQuery('.horizontal_tabs,.main_tab').hide();
        jQuery('#wp_rem_cs_bg_color').hide();

    }


}

function wp_rem_cs_var_div_remove(id) {
    "use strict";
    jQuery("#" + id).remove();
}

var counter_sidebar = 0;
function add_sidebar() {
    "use strict";
    counter_sidebar++;
    var sidebar_input = jQuery("#sidebar_input").val();
    if (sidebar_input != "") {
        jQuery(".wp-rem-sidebar-list-wrapper .wp-rem-list-layout").append('<li class="wp-rem-list-item"><div class="col-lg-12 col-md-12 col-sm-6 col-xs-12"><div class="input-element"><div class="input-holder">' + sidebar_input + '<input type="hidden" name="wp_rem_cs_var_sidebar[]" value="' + sidebar_input + '"></div></div></div><a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a></li>');
        jQuery("#sidebar_input").val("");
        jQuery(".sidebar-area").slideDown();
    } else {
        alert(wp_rem_theme_options_vars.sidebar_error);
    }
}


var counter_footer_sidebar = 0;

function add_footer_sidebar() {
    "use strict";
    counter_footer_sidebar++;
    var footer_sidebar_input = jQuery("#footer_sidebar_input").val();
    var footer_sidebar_width = jQuery("#footer_sidebar_width").val();

    if (footer_sidebar_input != "" || footer_sidebar_width != "") {
        jQuery(".wp-rem-footer-sidebar-list-wrap .wp-rem-list-layout").append('<li class="wp-rem-list-item"><div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="input-element"><div class="input-holder"><input type="hidden" name="wp_rem_cs_var_footer_sidebar[]" value="' + footer_sidebar_input + '" />' + footer_sidebar_input + '</div></div></div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><div class="input-element"><div class="input-holder"><input type="hidden" name="wp_rem_cs_var_footer_width[]" value="' + footer_sidebar_width + '" />' + footer_sidebar_width + '</div></div></div><a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a></li>');
        jQuery("#footer_sidebar_input").val("");
        jQuery(".footer_sidebar-area").slideDown();
    }
}

// set header bg options

function wp_rem_cs_var_set_headerbg(value) {
    "use strict";

    if (value == 'absolute') {

        jQuery('#wp_rem_cs_var_headerbg_options_header,#wp_rem_cs_var_headerbg_image_upload,#wp_rem_cs_var_headerbg_color_color,#wp_rem_cs_var_headerbg_slider_1,#wp_rem_cs_var_headerbg_image_box').show();
        if (jQuery('#wp_rem_cs_var_headerbg_options').val() == 'wp_rem_cs_var_rev_slider') {
            jQuery('#wp_rem_cs_var_headerbg_slider_1').show();
            jQuery('#wp_rem_cs_var_headerbg_image_upload,#wp_rem_cs_var_headerbg_color_color,#tab-header-options #wp_rem_cs_var_headerbg_image_box').hide();
        } else if (jQuery('#wp_rem_cs_var_headerbg_options').val() == 'wp_rem_cs_var_bg_image_color') {
            jQuery('#wp_rem_cs_var_headerbg_slider_1').hide();
            jQuery('#wp_rem_cs_var_headerbg_image_upload,#wp_rem_cs_var_headerbg_color_color,#tab-header-options #wp_rem_cs_var_headerbg_image_box').show();
        } else {
            jQuery('#wp_rem_cs_var_headerbg_slider_1').hide();
            jQuery('#wp_rem_cs_var_headerbg_image_upload,#wp_rem_cs_var_headerbg_color_color,#tab-header-options #wp_rem_cs_var_headerbg_image_box,#wp_rem_cs_var_headerbg_slider_1').hide();
        }

    } else if (value == 'relative') {

        jQuery('#wp_rem_cs_var_headerbg_options_header,#wp_rem_cs_var_headerbg_image_upload,#wp_rem_cs_var_headerbg_color_color,#wp_rem_cs_var_headerbg_slider_1,#tab-header-options #wp_rem_cs_var_headerbg_image_box').hide();

    } else if (value == 'wp_rem_cs_var_rev_slider') {

        jQuery('#wp_rem_cs_var_headerbg_slider_1').show();

        jQuery('#wp_rem_cs_var_headerbg_image_upload,#wp_rem_cs_var_headerbg_color_color,#tab-header-options #wp_rem_cs_var_headerbg_image_box').hide();

    } else if (value == 'wp_rem_cs_var_bg_image_color') {

        jQuery('#wp_rem_cs_var_headerbg_slider_1').hide();

        jQuery('#wp_rem_cs_var_headerbg_image_upload,#wp_rem_cs_var_headerbg_color_color,#tab-header-options #wp_rem_cs_var_headerbg_image_box').show();

    } else if (value == 'none') {

        jQuery('#wp_rem_cs_var_headerbg_slider_1').hide();

        jQuery('#wp_rem_cs_var_headerbg_image_upload,#wp_rem_cs_var_headerbg_color_color,#tab-header-options #wp_rem_cs_var_headerbg_image_box,#wp_rem_cs_var_headerbg_slider_1').hide();

    }

}


function popup_over() {
    jQuery('[data-toggle="popover"]').popover({trigger: "hover", placement: "right"});
}

function rem_load_all_pages(field_class, field_id, selected_page) {
    jQuery('.' + field_class + ' .pages-loader').html("<img src='" + wp_rem_theme_options_vars.theme_url + "/assets/backend/images/ajax-loader2.gif' />").show();
    jQuery.ajax({
        type: "POST",
        url: wp_rem_theme_options_vars.ajax_url,
        data: 'action=rem_load_all_pages&selected_page=' + selected_page,
        dataType: "json",
        success: function (response) {
            if (typeof response.html !== 'undefined') {
                jQuery('.' + field_class).prop("onclick", null);
                jQuery('.' + field_class).html('');
                jQuery('.' + field_class).html(response.html);
                jQuery('.' + field_class + ' .pages-loader').html('').hide();
                setTimeout(function () {
                    jQuery('.' + field_class + ' #wp_rem_cs_var_' + field_id).trigger('chosen:open');
                }, 5);
            }
        }
    });
}

function wp_rem_footer_views(view) {
    if (view == "classic" || view == "advance") {
        jQuery("#wp_rem_footer_style_dynamic").show();
    } else {
        jQuery("#wp_rem_footer_style_dynamic").hide();
    }

    if (view == "advance") {
        jQuery("#wp_rem_footer_menu_dynamic").show();
    } else {
        jQuery("#wp_rem_footer_menu_dynamic").hide();
    }


}
			
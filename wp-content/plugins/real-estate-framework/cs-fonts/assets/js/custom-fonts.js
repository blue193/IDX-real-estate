function wp_rem_add_custom_fonts_list() {
    "use strict";
    var custom_font_name = jQuery(".wp-rem-custom-fonts #custom_font_name").val();
    var custom_font_woff = jQuery(".wp-rem-custom-fonts #custom_fonts_woff").val();
    var custom_font_ttf = jQuery(".wp-rem-custom-fonts #custom_fonts_ttf").val();
    var custom_font_svg = jQuery(".wp-rem-custom-fonts #custom_fonts_svg").val();
    var custom_font_eot = jQuery(".wp-rem-custom-fonts #custom_fonts_eot").val();
    if (custom_font_name != "" && custom_font_woff != "" && custom_font_ttf != "" && custom_font_svg != "" && custom_font_eot != "") {
        var dataString = 'custom_font_name=' + custom_font_name +
                '&custom_font_woff=' + custom_font_woff +
                '&custom_font_ttf=' + custom_font_ttf +
                '&custom_font_svg=' + custom_font_svg +
                '&custom_font_eot=' + custom_font_eot +
                '&action=wp_rem_add_custom_fonts_list';
        jQuery(".wp-rem-custom-fonts .add-custom-font-button").append(' <span class="font-loader-spinner"><i class="icon-spinner"></i></span>');
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: dataString,
            success: function (response) {
                jQuery(".wp-rem-custom-fonts .custom-fonts-list-holder").append(response);
                jQuery("#custom_font_name, #custom_fonts_woff, #custom_fonts_ttf, #custom_fonts_svg, #custom_fonts_eot").val("");
                jQuery('#wp-rem-custom-fonts .font-loader-spinner').remove();
                jQuery("#new-custom-font-outerlay").hide();
            }
        });
    } else {
        alert(wp_rem_custom_fonts.fields_error);
    }
}

jQuery('body').on('click', '.add-custom-font', function () {
    var button = jQuery(this);
    var font_name = jQuery(this).attr('data-font_name');
    var woff_font = jQuery(this).attr('data-woff_font');
    var ttf_font = jQuery(this).attr('data-ttf_font');
    var svg_font = jQuery(this).attr('data-svg_font');
    var eot_font = jQuery(this).attr('data-eot_font');
    if (!button.hasClass('font-added')) {
        button.next().next('.spinner').show();
        button.next().next('.spinner').css({'float': 'right', 'visibility': 'visible'});
        var data = {
            action: 'wp_rem_add_selected_custom_font',
            font_name: font_name,
            woff_font: woff_font,
            ttf_font: ttf_font,
            svg_font: svg_font,
            eot_font: eot_font
        };
        jQuery.post(ajaxurl, data, function (response) {
            button.next().next('.spinner').hide();
            button.val(wp_rem_custom_fonts.added_in);
            button.addClass('font-added');
            jQuery('#custom-fonts-selected-wrapper').append(response);
        });
    }
});

jQuery('body').on('click', '.selected-custom-font-delete', function () {
    jQuery('.custom-font-overlay').remove();
    jQuery('.custom-font-confirmation').remove();
    var button = jQuery(this);
    var font_key = jQuery(this).attr('data-font_key');
    jQuery('body').append('<div class="custom-font-overlay"></div>');
    jQuery('body').append('<div class="custom-font-confirmation"><div class="custom-font-confirmation-header"><h3>' + wp_rem_custom_fonts.are_you_sure_remove_font + '</h3></div><div class="custom-font-message"><input type="button" id="" data-font_key="' + font_key + '" class="custom-font-message-buttons selected-custom-font-message-delete custom-font-buttons" value="' + wp_rem_custom_fonts.yes + '"/><input type="button" id="" class="custom-font-message-buttons custom-font-message-no-delete custom-font-buttons" value="' + wp_rem_custom_fonts.no + '"/></div><a href="javacript:void(0);" class="custom-font-anchor-buttons custom-font-buttons custom-font-message-no-delete"><i class="dashicons dashicons-no-alt"></i></a></div>');
    jQuery('.custom-font-overlay').fadeIn(100);
    jQuery('.custom-font-confirmation').fadeIn(100);
});
jQuery('body').on('click', '.custom-font-buttons', function () {
    if (jQuery(this).hasClass('selected-custom-font-message-delete')) {
        var font_key = jQuery(this).attr('data-font_key');
        var data = {
            action: 'wp_rem_delete_selected_custom_font',
            font_key: font_key
        };
        jQuery.post(ajaxurl, data, function (response) {
            jQuery('.selected-custom-font-delete').each(function (i, e) {
                var button = jQuery(this);
                var button_font_key = jQuery(this).attr('data-font_key');
                if (button_font_key == font_key) {
                    button.parent().remove();
                }
            });
            jQuery('.add-custom-font').each(function (i, e) {
                var button = jQuery(this);
                var button_font_key = jQuery(this).attr('data-font_key');
                if (button_font_key == font_key) {
                    button.removeClass('font-added');
                    button.val(wp_rem_custom_fonts.added_to);
                }
            });
        });
    }
    jQuery('.custom-font-confirmation').fadeOut(200);
    jQuery('.custom-font-overlay').fadeOut(200);
});


jQuery('body').on('click', '.custom-font-delete', function () {
    jQuery('.custom-font-overlay').remove();
    jQuery('.custom-font-confirmation').remove();
    var button = jQuery(this);
    var font_key = jQuery(this).attr('data-font_key');
    jQuery('body').append('<div class="custom-font-overlay"></div>');
    jQuery('body').append('<div class="custom-font-confirmation"><div class="custom-font-confirmation-header"><h3>' + wp_rem_custom_fonts.are_you_sure_remove_font + '</h3></div><div class="custom-font-message"><input type="button" id="" data-font_key="' + font_key + '" class="custom-font-message-buttons custom-font-message-delete custom-font-buttons" value="' + wp_rem_custom_fonts.yes + '"/><input type="button" id="" class="custom-font-message-buttons custom-font-message-no-delete custom-font-buttons" value="' + wp_rem_custom_fonts.no + '"/></div><a href="javacript:void(0);" class="custom-font-anchor-buttons custom-font-buttons custom-font-message-no-delete"><i class="dashicons dashicons-no-alt"></i></a></div>');
    jQuery('.custom-font-overlay').fadeIn(100);
    jQuery('.custom-font-confirmation').fadeIn(100);
});
jQuery('body').on('click', '.custom-font-buttons', function () {
    if (jQuery(this).hasClass('custom-font-message-delete')) {
        var font_key = jQuery(this).attr('data-font_key');
        var data = {
            action: 'wp_rem_delete_custom_font_list',
            font_key: font_key
        };
        jQuery.post(ajaxurl, data, function (response) {
            jQuery('.custom-font-delete').each(function (i, e) {
                var button = jQuery(this);
                var button_font_key = jQuery(this).attr('data-font_key');
                if (button_font_key == font_key) {
                    button.parent().remove();
                }
            });
        });
    }
    jQuery('.custom-font-confirmation').fadeOut(200);
    jQuery('.custom-font-overlay').fadeOut(200);
});
jQuery(document).ready(function () {
    jQuery(document).on('click', '#add_custom_font', function () {
        jQuery("#new-custom-font-outerlay").show();
    });
    jQuery(document).on('click', '#custom-fonts-popup #close_div', function () {
        jQuery("#new-custom-font-outerlay").hide();
        jQuery("#custom_font_name, #custom_fonts_woff, #custom_fonts_ttf, #custom_fonts_svg, #custom_fonts_eot").val("");
    });
});

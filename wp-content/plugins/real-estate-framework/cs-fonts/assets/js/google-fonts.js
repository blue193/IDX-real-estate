jQuery(document).ready(function () {
    jQuery('body').on('click', '#get-new-google-fonts', function () {
        jQuery(this).next('.spinner').css({'display': 'inline-block', 'float': 'none', 'vertical-align': 'middle', 'visibility': 'visible'});
        var data = {
            action: 'wp_rem_google_fonts_refresh',
        };
        jQuery.post(ajaxurl, data, function (response) {
            var object = jQuery.parseJSON(response);
            var count = object.count;
            var msg = object.message;
            if (count == 0) {
                var msg_res = msg;
            } else {
                var msg_res = msg + wp_rem_google_fonts.page_loading;
                window.location.reload(true);
            }
            jQuery('#wp-rem-fonts-msg').html('<div class="updated">' + msg_res + '</div>').hide();
            jQuery('#wp-rem-fonts-msg').slideDown(300);
            jQuery('#get-new-google-fonts').next('.spinner').css({'display': 'none'});
            setTimeout(function () {
                jQuery('#wp-rem-fonts-msg').slideUp(300);
            }, 4000);
        });
    });

    jQuery('body').on('click', '.add-google-font', function () {
        var button = jQuery(this);
        var font_family = jQuery(this).attr('data-font_family');
        var font_name = jQuery(this).attr('data-font_name');
        var font_slug = font_name.toLowerCase();
        var font_slug = font_slug.replace(" ", "-");
        if (!button.hasClass('font-added'))
        {
            button.next('.spinner').show();
            button.next('.spinner').css({'float': 'right', 'visibility': 'visible'});

            var variants_array = new Array();
            var subsets_array = new Array();
            button.parent().find('.variants').find('.font-variant').each(function (iv, variant) {
                $v = jQuery(variant);
                var temp_arr = {};
                var variant_value = $v.find('.font-variant-inputs').val();
                temp_arr['variant_value'] = variant_value;
                if ($v.find('.font-variant-inputs').is(':checked')) {
                    temp_arr['variant_selected'] = true;
                } else {
                    temp_arr['variant_selected'] = false;
                }
                variants_array.push(temp_arr);
            });
            button.parent().find('.subsets').find('.font-subset').each(function (iv, subset) {
                $s = jQuery(subset);
                var temp_arr = {};
                var subset_value = $s.find('.font-subset-inputs').val();
                temp_arr['subset_value'] = subset_value;
                if ($s.find('.font-subset-inputs').is(':checked')) {
                    temp_arr['subset_selected'] = true;
                } else {
                    temp_arr['subset_selected'] = false;
                }
                subsets_array.push(temp_arr);
            });
            var data = {
                action: 'wp_rem_add_selected_google_font',
                font_family: font_family,
                font_name: font_name,
                variants: variants_array,
                subsets: subsets_array
            };
            jQuery.post(ajaxurl, data, function (response) {
                button.next('.spinner').hide();
                button.val(wp_rem_google_fonts.added_in);
                button.addClass('font-added');
                if (variants_array.length > 0 || subsets_array.length > 0) {
                    var xclass = 'have-variants';
                } else {
                    var xclass = '';
                }
                var font_html = '<div class="selected-font"><div class="selected-font-top fopened ' + xclass + '"><div class="font-header" style="font-family:\'' + font_name + '\'">' + font_name + '</div>';
                if (variants_array.length > 0)
                    font_html += '<i class="dashicons dashicons-arrow-down"></i>';
                font_html += '<div class="clear"></div></div><span class="font-delete" data-font_name="' + font_name + '"><i class="dashicons dashicons-no-alt"></i></span>';

                if (variants_array.length > 0 || subsets_array.length > 0)
                {
                    font_html += '<div class="selected-font-content" style="display:block">';

                    if (temp = font_name.split(' '))
                    {
                        var ctemp = temp.length;
                        var temp_id = '';
                        jQuery.each(temp, function (i, val) {
                            temp_id += val;
                            if ((ctemp - 1) != i)
                                temp_id += '-';
                        })
                    } else
                        var temp_id = font_name;

                    var temp_subset_class = '';

                    if (variants_array.length > 0)
                    {
                        font_html += '<div class="'+ font_slug +' selected-font-varient-wrapper">';
                        jQuery.each(variants_array, function (index, variant) {
                            var lid = temp_id + '-dynamic-' + variant.variant_value + '-' + index;
                            var font_style = 'font-family:\'' + font_name + '\';';
                            if (/italic/i.test(variant.variant_value)) {
                                font_style += 'font-style:italic;';
                            }
                            var weight = 'normal';
                            if (weight = variant.variant_value.match(/\d+/)) {
                                font_style += 'font-weight:' + weight + ';';
                            }
                            font_html += '<span class="font-variant"><input type="checkbox" id="' + lid + '" value="' + variant.variant_value + '" class="selected-variant-checkbox" /><label style="' + font_style + '" for="' + lid + '">' + variant.variant_value + '</label></span>';
                        });
                        font_html += '</div>';
                        temp_subset_class = ''+ font_slug +' selected-font-subset-wrapper';
                    }

                    if (subsets_array.length > 0)
                    {
                        font_html += '<div class="' + temp_subset_class + '">';
                        jQuery.each(subsets_array, function (index, subset) {
                            var lid = temp_id + '-dynamic-subset-' + subset.subset_value + '-' + index;
                            font_html += '<span class="font-subset"><input type="checkbox" id="' + lid + '" value="' + subset.subset_value + '" class="selected-subset-checkbox" /><label for="' + lid + '">' + subset.subset_value + '</label></span>';
                        });
                        font_html += '</div>';
                    }
                    font_html += '<div class="font-select-holder">';
                        font_html += '<span class="select-butns">';
                            font_html += '<a class="select-all" date-font_slug="'+ font_slug +'">'+ wp_rem_google_fonts.select_all +'</a>';
                            font_html += '<a class="unselect-all" date-font_slug="'+ font_slug +'">'+ wp_rem_google_fonts.unselect_all +'</a>';
                        font_html += '</span>';
                    font_html += '</div>';
                    font_html += '<input type="button" class="button alignleft update-google-font-button" value="Update font" data-font_name="' + font_name + '" /><span class="spinner fspinner"></span><div class="clear"></div></div>';
                }
                font_html += '</div>';
                jQuery('#fonts-selected-wrapper').prepend(font_html);
            });
        }
    });
    jQuery('body').on('click', '.font-delete', function () {
        jQuery('.google-font-overlay').remove();
        jQuery('.google-font-confirmation').remove();
        var button = jQuery(this);
        var font_name = jQuery(this).attr('data-font_name');
        jQuery('body').append('<div class="google-font-overlay"></div>');
        jQuery('body').append('<div class="google-font-confirmation"><div class="google-font-confirmation-header"><h3>' + wp_rem_google_fonts.are_you_sure_remove_font + '</h3></div><div class="google-font-message"><input type="button" id="" data-google-font_name="' + font_name + '" class="google-font-message-buttons google-font-message-delete google-font-buttons" value="' + wp_rem_google_fonts.yes + '"/><input type="button" id="" class="google-font-message-buttons google-font-message-no-delete google-font-buttons" value="' + wp_rem_google_fonts.no + '"/></div><a href="javacript:void(0)" class="google-font-anchor-buttons google-font-buttons google-font-message-no-delete"><i class="dashicons dashicons-no-alt"></i></a></div>');
        jQuery('.google-font-overlay').fadeIn(100);
        jQuery('.google-font-confirmation').fadeIn(100);
    });
    jQuery('body').on('click', '.google-font-buttons', function () {
        if (jQuery(this).hasClass('google-font-message-delete')) {
            var font_name = jQuery(this).attr('data-google-font_name');
            var data = {
                action: 'wp_rem_delete_google_font',
                font_name: font_name
            };
            jQuery.post(ajaxurl, data, function (response) {
                jQuery('.font-delete').each(function (i, e) {
                    var button = jQuery(this);
                    var bfont_name = jQuery(this).attr('data-font_name');
                    if (bfont_name == font_name) {
                        button.parent().remove();
                    }
                });
            });
        }
        jQuery('.google-font-confirmation').fadeOut(200);
        jQuery('.google-font-overlay').fadeOut(200);
    });
    jQuery('body').on('click', '.update-google-font-button', function () {
        var font_name = jQuery(this).attr('data-font_name');
        var parent = jQuery(this).parent();
        var variant_array = new Array();
        var subset_array = new Array();
        jQuery(parent).find('.font-variant').each(function (index, variant_wrap) {
            var temp_array = {};
            var variant_checkbox = jQuery(variant_wrap).find('.selected-variant-checkbox');
            temp_array['variant_value'] = jQuery(variant_checkbox).val();
            if (jQuery(variant_checkbox).is(':checked')) {
                temp_array['variant_selected'] = true;
            } else {
                temp_array['variant_selected'] = false;
            }
            variant_array.push(temp_array);
        });
        jQuery(parent).find('.font-subset').each(function (index, subset_wrap) {
            var temp_array = {};
            var subset_checkbox = jQuery(subset_wrap).find('.selected-subset-checkbox');
            temp_array['subset_value'] = jQuery(subset_checkbox).val();
            if (jQuery(subset_checkbox).is(':checked')) {
                temp_array['subset_selected'] = true;
            } else {
                temp_array['subset_selected'] = false;
            }
            subset_array.push(temp_array);
        });
        var data = {
            action: 'wp_rem_update_google_font',
            font_name: font_name,
            variants: variant_array,
            subsets: subset_array
        };
        jQuery(this).next('.fspinner').addClass('fspinner-show');
        jQuery.post(ajaxurl, data, function (response) {
            jQuery('.fspinner').removeClass('fspinner-show');
        });
    });
    jQuery('body').on('click', '.selected-font-top', function () {
        if (jQuery(this).hasClass('fopened')) {
            jQuery(this).parent().find('.selected-font-content').slideUp(200);
            jQuery(this).removeClass('fopened');
            return;
        }
        jQuery('.selected-font .selected-font-content').slideUp(200);
        jQuery('.selected-font-top').removeClass('fopened');
        jQuery(this).addClass('fopened');
        jQuery(this).parent().find('.selected-font-content').slideToggle(200);
    });

    jQuery('body').on('click', '.font-select-holder .select-all', function () {
        var font_slug = jQuery(this).attr('date-font_slug');
        if( font_slug !== '' && font_slug != 'undefined' ){
            jQuery('.'+ font_slug + '.selected-font-varient-wrapper').find('input[type=checkbox]').prop('checked', true);
            jQuery('.'+ font_slug + '.selected-font-subset-wrapper').find('input[type=checkbox]').prop('checked', true);
        }
    });
    jQuery('body').on('click', '.font-select-holder .unselect-all', function () {
        var font_slug = jQuery(this).attr('date-font_slug');
        if( font_slug !== '' && font_slug != 'undefined' ){
            jQuery('.'+ font_slug + '.selected-font-varient-wrapper').find('input[type=checkbox]').prop('checked', false);
            jQuery('.'+ font_slug + '.selected-font-subset-wrapper').find('input[type=checkbox]').prop('checked', false);
        }
    });

    wp_rem_get_google_fonts();
});

jQuery(window).scroll(function () {
    if (jQuery(window).height() + jQuery(window).scrollTop() == jQuery(document).height()) {
        var search_font = jQuery('#search_google_font').val();
        if (search_font == '')
            wp_rem_get_google_fonts();
    }
});

function wp_rem_get_google_fonts() {
    jQuery('#load-more').show();
    $google_fonts_list_wrapper = jQuery('#google-fonts-list');
    var gstart = $google_fonts_list_wrapper.attr('data-gstart');
    var gfetch = $google_fonts_list_wrapper.attr('data-gfetch');
    var gsearch = jQuery('#search_google_font').val();
    var data = {
        action: 'wp_rem_get_google_fonts',
        start: gstart,
        fetch: gfetch,
        search: gsearch
    };
    jQuery.post(ajaxurl, data, function (response) {
        var object = jQuery.parseJSON(response);
        var font_count = object.fonts_count;
        var fonts = object.fonts;
        var is_search = object.is_search;
        if (font_count == 0 && is_search == 'false')
        {
            var ghtml = '<div class="google-font">'+ wp_rem_google_fonts.seems_dont_have_font +' <a href="javascript:void(0);" id="get-new-google-fonts">'+ wp_rem_google_fonts.font_just_click +'.</a> <span class="spinner"></span></div>';
            $google_fonts_list_wrapper.html(ghtml);
        } else
        {
            if (fonts.length == 0)
            {
                var ghtml = '<div class="google-font">';
                ghtml += wp_rem_google_fonts.not_font_search;
                ghtml += '</div>';
                $google_fonts_list_wrapper.html(ghtml);
            } else
            {
                var ghtml = convert_json_to_html(fonts);
                $google_fonts_list_wrapper.append(ghtml);
            }
        }
        jQuery('#load-more').hide();
        $google_fonts_list_wrapper.attr('data-gstart', parseInt(gstart) + parseInt(gfetch));
    });
}
function convert_json_to_html(object) {
    var html = '';
    jQuery.each(object, function (index, google_font) {
        var font_call = google_font.font_call;
        var font_name = google_font.font_name;
        var font_variants = google_font.variants;
        var font_subsets = google_font.subsets;
        var selected = google_font.selected;
        if (temp = font_name.split(' '))
        {
            var ctemp = temp.length;
            var temp_id = '';
            jQuery.each(temp, function (i, val) {
                temp_id += val;
                if ((ctemp - 1) != i)
                    temp_id += '-';
            })
        } else
            var temp_id = font_name;

        var variants_length = font_variants.length;
        var subsets_length = font_subsets.length;

        if (selected == 'true') {
            var button_text = wp_rem_google_fonts.added_in;
            var button_class = 'font-added';
        } else {
            var button_text = wp_rem_google_fonts.add_to;
            var button_class = '';
        }
        html += '<div class="google-font">';
        html += '<div class="font-header" style="font-family:\'' + font_name + '\'">' + font_name + '</div>';
        html += '<input type="button" class="add-google-font alignright ' + button_class + '" data-font_family="' + font_call + '" data-font_name="' + font_name + '" value="' + button_text + '"/><span class="spinner"></span><div class="clear"></div>';
        if (variants_length > 1) {
            font_call += ':';
            html += '<span class="variants">';
            jQuery.each(font_variants, function (vindex, variant) {
                if (variant != 'regular') {
                    var font_style = 'font-family:\'' + font_name + '\';';
                    if (/italic/i.test(variant)) {
                        font_style += 'font-style:italic;';
                    }
                    var weight = 'normal';
                    if (weight = variant.match(/\d+/)) {
                        font_style += 'font-weight:' + weight + ';';
                    }
                    html += '<span class="font-variant">';
                    html += '<input type="checkbox" class="font-variant-inputs" value="' + variant + '" id="' + temp_id + '-' + variant + '-' + vindex + '"/>';
                    html += '<label for="' + temp_id + '-' + variant + '-' + vindex + '" style="' + font_style + '">' + variant + '</label>';
                    html += '</span>';
                    font_call += variant;
                    if (variants_length > 0 && (variants_length - 1) != vindex) {
                        font_call += ',';
                    }
                }
            });
            html += '</span>';
        } //end of varients
        if (subsets_length > 1)
        {
            html += '<span class="subsets">';
            jQuery.each(font_subsets, function (sindex, subset) {
                html += '<span class="font-subset">';
                html += '<input type="checkbox" class="font-subset-inputs" value="' + subset + '" id="' + temp_id + '-' + subset + '-' + sindex + '"/>';
                html += '</span>';
            });
            html += '</span>';
        } //end of subsets
        html += '<div class="clear"></div>';
        html += '</div>';
        jQuery('head').append('<link href="http://fonts.googleapis.com/css?family=' + font_call + '" type="text/css" media="all" rel="stylesheet"/>');
    });
    return html;
}

jQuery(document).ready(function () {
    var typingTimer;                //timer identifier
    var doneTypingInterval = 500;  //time in ms, 2 second for example
    //on keyup, start the countdown
    jQuery('#search_google_font').keyup(function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(search_google_font, doneTypingInterval);
    });
    //on keydown, clear the countdown 
    jQuery('#search_google_font').keydown(function () {
        clearTimeout(typingTimer);
    });
});
function search_google_font()
{
    var gsearch = jQuery('#search_google_font').val();
    $google_fonts_list_wrapper = jQuery('#google-fonts-list');
    $google_fonts_list_wrapper.html('');
    if (gsearch == '') {
        $google_fonts_list_wrapper.attr('data-gstart', parseInt(0));
    }
    wp_rem_get_google_fonts();
}
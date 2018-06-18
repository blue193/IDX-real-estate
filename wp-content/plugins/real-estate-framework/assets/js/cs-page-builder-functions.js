var counter = 0;
function delete_this(id) {
    "use strict";
    jQuery('#' + id).remove();
    jQuery('#' + id + '_del').remove();
    count_widget--;
    if (count_widget < 1)
        jQuery("#add_page_builder_item").addClass("hasclass");
}

var html_popup = "<div id='confirmOverlay' style='display:block'> \
					<div id='confirmBox'><div id='confirmText'>Are you sure to do this?</div> \
					<div id='confirmButtons'><div class='button confirm-yes'>Delete</div>\
					<div class='button confirm-no'>Cancel</div><br class='clear'></div></div>\
				</div>";

var Data = [
    {"Class": "column_100", "title": "100", "element": ["locations","newsletter","quote","wp_rem_properties","wp_rem_map_properties","dealer", "mail_chimp", "price_table", "blog_search", "blog_categories", "tweets", "tabs", "maintenance","inventory_type", "package", "team", "contact_info", "flex_column", "promobox" ,"inventories", "compare_inventories", "clients", "woo_feature", "image_frame", "flex_editor", "stylist", "heading","tabs_fancy", "video", "call_to_action", "price_services", "button", "maintenance", "property_price", "counter", "ads", "gallery", "faq", "blog", "author" ,"map", "contact_form", "image_frame", "spacer", "accordion", "testimonial", "promobox", "list", "divider", "sitemap", "icon_box", "progressbars", "table", "schedule", "editor", "dropcap", "infobox", "faqs_fancy", "column", "about_info"]},
    {"Class": "column_75", "title": "75", "element": ["locations","newsletter","quote","wp_rem_properties","wp_rem_map_properties", "dealer", "price_table", "mail_chimp", "blog_search", "blog_categories", "tweets", "tabs", "maintenance","inventory_type", "package", "team", "contact_info", "flex_column", "promobox" ,"inventories", "compare_inventories", "clients", "woo_feature", "flex_editor", "stylist", , "heading","tabs_fancy", "video", "call_to_action", "price_services", "button", "maintenance", "property_price", "counter", "ads", "gallery", "faq", "blog", "author" ,"map", "contact_form", "spacer", "accordion", "testimonial", "promobox", "list", "divider", "image_frame", "sitemap", "icon_box", "progressbars", "table", "schedule", "editor", "dropcap", "infobox", "faqs_fancy", "column", "about_info"]},
    {"Class": "column_67", "title": "67", "element": ["locations","newsletter","quote","wp_rem_properties","wp_rem_map_properties", "dealer", "price_table", "mail_chimp", "blog_search", "blog_categories", "tweets", "tabs", "maintenance","inventory_type", "package", "team", "contact_info", "flex_column", "promobox" ,"inventories", "compare_inventories", "clients", "woo_feature", "image_frame", "flex_editor", "stylist", "heading","tabs_fancy", "video", "call_to_action", "price_services", "button", "maintenance", "property_price", "counter", "ads", "gallery", "faq", "blog", "author" ,"map", "contact_form", "spacer", "accordion", "testimonial", "promobox", "list", "divider", "sitemap", "icon_box", "progressbars", "table", "schedule", "editor", "dropcap", "infobox", "faqs_fancy", "column", "about_info"]},
    {"Class": "column_50", "title": "50", "element": ["locations","newsletter","quote","wp_rem_properties","wp_rem_map_properties", "dealer", "price_table", "mail_chimp", "blog_search", "blog_categories", "tweets", "tabs", "maintenance","inventory_type", "package", "team", "contact_info", "flex_column", "promobox" ,"inventories", "compare_inventories", "clients", "woo_feature", "image_frame", "flex_editor", "stylist", "heading","tabs_fancy", "video", "call_to_action", "price_services", "button", "maintenance", "property_price", "counter", "ads", "gallery", "faq", "blog", "author" ,"map", "contact_form", "spacer", "accordion", "testimonial", "promobox", "list", "divider", "sitemap", "icon_box", "progressbars", "table", "schedule", "editor", "dropcap", "infobox", "faqs_fancy", "column", "about_info"]},
    {"Class": "column_33", "title": "33", "element": ["locations","newsletter","quote","wp_rem_properties","wp_rem_map_properties", "dealer", "price_table", "mail_chimp", "blog_search", "blog_categories", "tweets", "tabs", "maintenance","inventory_type", "package", "team", "contact_info", "flex_column", "promobox" ,"inventories", "compare_inventories", "clients", "woo_feature", "image_frame", "flex_editor", "stylist", "heading","tabs_fancy", "video", "call_to_action", "price_services", "button", "maintenance", "property_price", "counter", "ads", "gallery", "faq", "flex_editor", "blog", "author" ,"map", "contact_form", "spacer", "accordion", "testimonial", "promobox", "list", "divider", "sitemap", "icon_box", "progressbars", "table", "schedule", "editor", "dropcap", "infobox", "faqs_fancy", "column", "about_info"]},
    {"Class": "column_25", "title": "25", "element": ["locations","newsletter","quote","wp_rem_properties","wp_rem_map_properties", "dealer", "price_table", "mail_chimp", "blog_search", "blog_categories", "tweets", "tabs", "maintenance","inventory_type", "package", "team", "contact_info", "flex_column", "promobox" ,"inventories", "compare_inventories", "clients", "woo_feature", "image_frame", "flex_editor", "stylist", "heading","tabs_fancy", "video", "call_to_action", "price_services", "button", "maintenance", "property_price", "counter", "ads", "gallery", "faq", "blog", "author" ,"map", "contact_form", "spacer", "accordion", "testimonial", "promobox", "list", "divider", "sitemap", "icon_box", "progressbars", "table", "schedule", "editor", "dropcap", "infobox", "faqs_fancy", "column", "about_info"]},
];

jQuery(document).on("click", ".btndeleteitsection", function () {
    jQuery(this).parents(".parentdeletesection").addClass("warning");
    jQuery(this).parent().append(html_popup);

    jQuery(".confirm-yes").click(function () {
        jQuery(this).parents(".parentdeletesection").fadeOut(400, function () {
            jQuery(this).remove();
        });
        jQuery("#confirmOverlay").remove();
        count_widget--;
        if (count_widget == 0)
            jQuery("#add_page_builder_item").removeClass("hasclass");
    });
    jQuery(".confirm-no").click(function () {
        jQuery(this).parents(".parentdeletesection").removeClass("warning");
        jQuery("#confirmOverlay").remove();
    });
    return false;
});

jQuery(document).on("click", ".btndeleteit", function () {

    jQuery(this).parents(".parentdelete").addClass("warning");
    jQuery(this).parent().append(html_popup);

    jQuery(".confirm-yes").click(function () {
        var prev_parent_id = jQuery(this).closest('.parentdeletesection').attr('id');
        var prev_total_columns = jQuery('#' + prev_parent_id + ' input[name="total_column[]"]').val();
        jQuery('#' + prev_parent_id + ' input[name="total_column[]"]').val(parseInt(prev_total_columns) - parseInt(1));
        
        jQuery(this).closest(".parentdelete").fadeOut(400, function () {
            jQuery(this).remove();
        });

        jQuery(this).parents(".parentdelete").each(function () {
            var lengthitem = jQuery(this).parents(".dragarea").find(".parentdelete").size() - 1;
            jQuery(this).parents(".dragarea").find("input.textfld").val(lengthitem);
        });

        jQuery("#confirmOverlay").remove();
        count_widget--;
        if (count_widget == 0)
            jQuery("#add_page_builder_item").removeClass("hasclass");

    });
    jQuery(".confirm-no").click(function () {
        jQuery(this).parents(".parentdelete").removeClass("warning");
        jQuery("#confirmOverlay").remove();
    });

    return false;
});

jQuery(document).on("click", "button.notice-dismiss", function () {
    var admin_url = jQuery(this).parent('div').data('ajax-url');
    var newCustomerForm = "admin=yes&action=wp_rem_cs_admin_dismiss_notice";
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: newCustomerForm,
        success: function (data) {

        }
    });
});

function wp_rem_cs_page_composer_filterable(id) {
    "use strict";
    var $container = jQuery("#page_element_container" + id),
            elclass = "cs-filter-item";
    $container.find('.element-item').addClass("cs-filter-item");
    jQuery("#filters" + id + " li").click(function (event) {
        var $selector = jQuery(this).attr('data-filter'),
                $elem = $container.find("." + $selector + "");
        jQuery("#filters" + id + " li").removeClass("active");
        jQuery(this).addClass("active");
        $container.find('.element-item').removeClass(elclass);
        if ($selector == "all") {
            $container.find('.element-item').addClass(elclass);
        } else {
            jQuery($elem).addClass(elclass);
        }
        event.preventDefault();
    });
    // Search By input
    jQuery("#quicksearch" + id).keyup(function () {
        var _val = jQuery(this).val(),
                $this = jQuery(this);
        $container.find('.element-item').addClass("cs-filter-item");
        jQuery("#filters" + id + " li").removeClass("active");
        var filter = jQuery(this).val(),
                count = 0;
        jQuery("#page_element_container" + id + " .element-item span").each(function () {
            if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
                jQuery(this).parents(".element-item").removeClass(elclass);
            } else {
                jQuery(this).parents(".element-item").addClass(elclass);
                count++;
            }
        });
    })
}

function wp_rem_cs_frame_createpop(data, type) {
    "use strict";
    var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>",
            $elem = jQuery('#cs-widgets-list');
    jQuery('body').addClass("cs-overflow");
    if (type == "csmedia") {
        $elem.append(data);
    }
    if (type == "filter") {
        jQuery('#' + data).wrap(_structure).delay(100).fadeIn(150);
        jQuery('#' + data).parent().addClass("wide-width");
    }
    if (type == "filterdrag") {
        jQuery('#' + data).wrap(_structure).delay(100).fadeIn(150);
    }


    if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
        var config = {
            '.chosen-select': {width: "100%"},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%", search_contains: true},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            jQuery(selector).chosen(config[selector]);
        }
    }

}

function wp_rem_cs_frame_removeoverlay(id, text) {
    "use strict";
    jQuery("#cs-widgets-list .loader").remove();
    var _elem1 = "<div id='cs-pbwp-outerlay'></div>",
            _elem2 = "<div id='cs-widgets-list'></div>",
            $elem = jQuery("#" + id);
    jQuery("#cs-widgets-list").unwrap(_elem1);
    if (text == "append" || text == "filterdrag") {
        $elem.hide().unwrap(_elem2);
    }
    if (text == "widgetitem") {
        $elem.hide().unwrap(_elem2);
        jQuery("body").append("<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>");
        return false;

    }
    if (text == "ajax-drag") {
        jQuery("#cs-widgets-list").remove();
    }
    jQuery("body").removeClass("cs-overflow");
}

function wp_rem_cs_frame_loader() {
    "use strict";
    jQuery("#cs-widgets-list div:first").hide();
    var loader = "<div class='loader'><i class='icon-spinner icon-spin'></i></div>"
    jQuery("#cs-widgets-list").append(loader)

}

function wp_rem_cs_frame_callme() {
    "use strict";
    jQuery(".dragarea").each(function (index) {
        var lengthitem = jQuery(this).find(".parentdelete").size()
        jQuery(this).find("input.textfld").val(lengthitem);
    });
}

function wp_rem_cs_createpopshort(object) {
    var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>";
    var a = object.closest(".column-in").next();
    jQuery(a).wrap(_structure).delay(100).fadeIn(150);
}

function ajax_shortcode_widget_element(object, admin_url, POSTID, name) {
    var action = '';
    var wraper = object.closest(".column-in").next();
    var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>",
            $elem = jQuery('#cs-widgets-list');

    jQuery(wraper).wrap(_structure).delay(100).fadeIn(150);
    var shortcodevalue = object.closest(".column-in").next().find(".cs-textarea-val").val();

    if (shortcodevalue) {

        var elementnamevalue = object.closest(".column-in").next().find(".cs-dcpt-element").val();
        wp_rem_cs_frame_loader();
        counter++;
        var dcpt_element_data = '';
        if (elementnamevalue) {
            var dcpt_element_data = '&element_name=' + elementnamevalue;
        }
        var wp_rem_cs_random_num = Math.floor((Math.random() * 98989) + 1);

        var newCustomerForm = "action=wp_rem_cs_var_page_builder_" + name + '&counter=' + wp_rem_cs_random_num + '&shortcode_element_id=' + encodeURIComponent(shortcodevalue) + '&POSTID=' + POSTID + dcpt_element_data;
        var edit_url = action + counter;
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: newCustomerForm,
            success: function (data) {
                rsponse = jQuery(data);
                var response_html = rsponse.find(".cs-pbwp-content").html();
                object.closest(".column-in").next().find(".pagebuilder-data-load").html(response_html);
                object.closest(".column-in").next().find(".cs-wiget-element-type").val('form');
                var wp_rem_cs_close_id = object.closest(".column-in").next().find(".cs-heading-area").parent('div').attr('id');
                var wp_rem_cs_save_btn = object.closest(".column-in").next().find(".cs-wp_rem_cs-admin-btn");
                wp_rem_cs_save_btn.attr('onclick', 'javascript:wp_rem_cs_frame_removeoverlay(\'' + wp_rem_cs_close_id + '\', \'filterdrag\')');
                jQuery('.loader').remove();
                jQuery('.bg_color').wpColorPicker();
                jQuery('div.cs-drag-slider').each(function () {
                    var _this = jQuery(this);
                    _this.slider({
                        range: 'min',
                        step: _this.data('slider-step'),
                        min: _this.data('slider-min'),
                        max: _this.data('slider-max'),
                        value: _this.data('slider-value'),
                        slide: function (event, ui) {
                            jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
                        }
                    });
                });
                jQuery(".draginner").sortable({
                    connectWith: '.draginner',
                    handle: '.column-in',
                    cancel: '.draginner .poped-up,#confirmOverlay',
                    revert: false,
                    receive: function (event, ui) {
                        var sender_id   = ui.sender.attr('id');
                        var prev_parent_id   = jQuery('#'+sender_id).closest('.parentdeletesection').attr('id');
                        var prev_total_columns   = jQuery( '#'+prev_parent_id+' input[name="total_column[]"]' ).val();
                        jQuery( '#'+prev_parent_id+' input[name="total_column[]"]' ).val(parseInt(prev_total_columns)-parseInt(1));
                        var parent_id   = jQuery(this).closest('.parentdeletesection').attr('id');
                        var total_columns   = jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val();
                        jQuery( '#'+parent_id+' input[name="total_column[]"]' ).val(parseInt(total_columns)+parseInt(1));
                        
                        wp_rem_cs_frame_callme();
                        getsorting(ui)
                    },
                    placeholder: "ui-state-highlight",
                    forcePlaceholderSize: true

                });
                chosen_selectionbox();
                jQuery('[data-toggle="popover"]').popover();
            }
        });
    }
}

function wp_rem_cs_decrement(id) {

    "use strict";
    var i, c;
    var $ = jQuery;
    var parent, ColumnIndex, CurrentWidget, CurrentColumn, module;
    parent = $(id).parent('.column-in');
    parent = $(parent).parent('.column');
    CurrentColumn = parseInt($(parent).attr('data'));
    CurrentWidget = $(parent).attr('widget');
    ColumnIndex = parseInt($(parent).attr('data'));
    module = $(parent).attr('item').toString();
    for (i = ColumnIndex + 1; i < Data.length; i++) {
        for (c = 0; c <= Data[i].element.length; c++) {
            if (Data[i].element[c] == module) {
                $(parent).removeClass(Data[ColumnIndex].Class)
                $(parent).addClass(Data[i].Class)
                $(parent).find('.ClassTitle').text(Data[i].title);
                $(parent).find('.item').val(Data[i].title);
                $(parent).find('.columnClass').val(Data[i].Class)
                $(parent).attr('data', i);
                return false;
            }
        }
    }
}

function wp_rem_cs_increment(id) {
    "use strict";
    var i, c;
    var $ = jQuery;
    var parent, ColumnIndex, CurrentWidget, CurrentColumn, module;
    parent = $(id).parent('.column-in');
    parent = $(parent).parent('.column');
    CurrentColumn = parseInt($(parent).attr('data'));
    CurrentWidget = $(parent).attr('widget');
    ColumnIndex = parseInt($(parent).attr('data'));
    module = $(parent).attr('item').toString();
    if (ColumnIndex > 0) {
        for (i = ColumnIndex - 1; i < Data.length; i--) {//
            for (c = 0; c <= Data[i].element.length; c++) {
                if (Data[i].element[c] == module) {
                    $(parent).removeClass(Data[ColumnIndex].Class)
                    $(parent).addClass(Data[i].Class)
                    $(parent).find('.ClassTitle').text(Data[i].title);
                    $(parent).find('.item').val(Data[i].title);
                    $(parent).find('.columnClass').val(Data[i].Class)
                    $(parent).attr('data', i);
                    return false;
                }
            }
        }
    }
}

function wp_rem_cs_shortcode_insert_editor(element_name, id) {
    "use strict";
    var $id = jQuery("#" + id),
            _this = jQuery(this),
            attributes = '',
            content = '',
            contentToEditor = '',
            template = $id.data('shortcode-template'),
            childTemplate = $id.data('shortcode-child-template'),
            tables = $id.find(".cs-wrapp-clone.cs-shortcode-wrapp");
    for (var i = 0; i < tables.length; i++) {
        var elems = jQuery(tables[i]).find('input, select, textarea').not('.cs-search-icon,.wp-picker-clear');
        attributes = jQuery.map(elems, function (el, index) {
            var $el = jQuery(el);
            if ($el.data('content-text') === 'cs-shortcode-textarea') {
                content = $el.val();
                return '';
            } else if ($el.data('check-box') === 'check-field') {
                if ($el.is(':checked')) {
                    return $el.attr('name') + '="true"';
                } else {
                    return '';
                }
            } else {

                if ($el.attr('name') != undefined)
                    if ($el.attr('name')) {

                        var _name = $el.attr('name').replace('[]', '');

                        _name = _name.replace('[1]', '');
                        _name = _name.replace(/[0-9]/g, "")
                        _name = _name.replace('[]', "")
                        if ($el.val() != '' && _name != 'fontawesome_icon' && _name != 'users') {
                            return _name + '="' + $el.val() + '"';
                        }
                    }
            }
        });
        attributes = attributes.join(' ').trim();
        if (childTemplate) {
            var a = jQuery(tables[i]).data('template');
            if (a) {
                contentToEditor += a.replace('{{attributes}}', attributes);

            } else {
                contentToEditor += childTemplate.replace('{{attributes}}', attributes).replace('{{attributes}}', attributes).replace('{{content}}', content);
            }
        } else {
            contentToEditor += template.replace('{{attributes}}', attributes).replace('{{attributes}}', attributes).replace('{{content}}', content);
        }
    }
    ;
    if (childTemplate) {
        contentToEditor = template.replace('{{child_shortcode}}', contentToEditor);
    }
    window.send_to_editor(contentToEditor);
    jQuery('body').removeClass('cs-overflow')
    jQuery("#cs-pbwp-outerlay").remove();
    return false;
}

var wp_rem_cs_shortocde_selection = (function (val, admin_url, id) {

    wp_rem_cs_frame_loader();
    jQuery("#" + id).parents('#cs-widgets-list').removeClass('wide-width');
    if (val != "") {
        var shortcode_counter = 1
        var action = "wp_rem_cs_var_page_builder_" + val;
        var newCustomerForm = "action=" + action + '&counter=' + shortcode_counter + '&shortcode_element=shortcode';
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: newCustomerForm,
            success: function (data) {
                wp_rem_cs_fontnamesearch();
                wp_rem_cs_frame_removeoverlay(id, 'widgetitem');
                wp_rem_cs_frame_createpop(data, "csmedia");
                jQuery('.bg_color').wpColorPicker();
                jQuery('div.cs-drag-slider').each(function () {
                    var _this = jQuery(this);
                    _this.slider({
                        range: 'min',
                        step: _this.data('slider-step'),
                        min: _this.data('slider-min'),
                        max: _this.data('slider-max'),
                        value: _this.data('slider-value'),
                        slide: function (event, ui) {
                            jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
                        }
                    });
                });
            }
        });
    }

});

function wp_rem_cs_fontnamesearch() {
    jQuery(".cs-search-icon").bind('keyup', function () {
        var _val = jQuery(this).val(),
                count = 0;
        var $elem = jQuery(this).parents(".cs-custom-fonts").find('.webfonts-wrapper li')
        $elem.each(function () {
            if (jQuery(this).data('icon-title').search(new RegExp(_val, "i")) < 0) {
                jQuery(this).hide();
            } else {
                jQuery(this).show(100);
                count++;
            }
        });
    });
}

function show_sidebar(id, random_id) {
    "use strict";
    var $ = jQuery;
    jQuery('input[class="radio_wp_rem_sidebar"]').click(function () {
        jQuery(this).parent().parent().find(".check-list").removeClass("check-list");
        jQuery(this).siblings("label").children("#check-list").addClass("check-list");
    });
    var randomeID = "#" + random_id;
    if ((id == '') || (id == 'none')) {
        $(randomeID + "_sidebar_right," + randomeID + "_sidebar_left," + randomeID + "_sidebar_right_second," + randomeID + "_sidebar_left_second").hide();
    } else if ((id == 'left') || (id == 'right') || (id == 'small_right') || (id == 'small_left')) {
        $(randomeID + "_sidebar_right," + randomeID + "_sidebar_left," + randomeID + "_sidebar_right_second," + randomeID + "_sidebar_left_second").hide();
        if(id == 'small_right') {
            id = 'right';
        } else if(id == 'small_left') {
            id = 'left';
        }
        $(randomeID + "_sidebar_" + id).show();
    } else if ((id == 'small_left_large_right') || (id == 'large_left_small_right')) {
        $(randomeID + "_sidebar_right," + randomeID + "_sidebar_left," + randomeID + "_sidebar_right_second," + randomeID + "_sidebar_left_second").hide();
        $(randomeID + "_sidebar_right").show();
        $(randomeID + "_sidebar_left").show();
    } else if (id == 'both_left') {
        $(randomeID + "_sidebar_right," + randomeID + "_sidebar_left," + randomeID + "_sidebar_right_second," + randomeID + "_sidebar_left_second").hide();
        $(randomeID + "_sidebar_left").show();
        $(randomeID + "_sidebar_left_second").show();
    } else if (id == 'both_right') {
        $(randomeID + "_sidebar_right," + randomeID + "_sidebar_left," + randomeID + "_sidebar_right_second," + randomeID + "_sidebar_left_second").hide();
        $(randomeID + "_sidebar_right").show();
        $(randomeID + "_sidebar_right_second").show();
    }
}

function wp_rem_cs_section_background_settings_toggle(id, rand_no) {
    "use strict";
    if (id == "no-image") {
        jQuery(".section-custom-background-image-" + rand_no).hide();
        jQuery(".section-slider-" + rand_no).hide();
        jQuery(".section-custom-slider-" + rand_no).hide();
        jQuery(".section-background-video-" + rand_no).hide();
    } else if (id == "section-custom-background-image") {
        jQuery(".section-slider-" + rand_no).hide();
        jQuery(".section-custom-slider-" + rand_no).hide();
        jQuery(".section-background-video-" + rand_no).hide();
        jQuery(".section-custom-background-image-" + rand_no).show();
    } else if (id == "section-slider") {
        jQuery(".section-custom-background-image-" + rand_no).hide();
        jQuery(".section-slider-" + rand_no).show();
        jQuery(".section-custom-slider-" + rand_no).hide();
        jQuery(".section-background-video-" + rand_no).hide();

    } else if (id == "section-custom-slider") {
        jQuery(".section-custom-background-image-" + rand_no).hide();
        jQuery(".section-slider-" + rand_no).hide();
        jQuery(".section-custom-slider-" + rand_no).show();
        jQuery(".section-background-video-" + rand_no).hide();

    } else if (id == "section_background_video") {
        jQuery(".section-custom-background-image-" + rand_no).hide();
        jQuery(".section-slider-" + rand_no).hide();
        jQuery(".section-custom-slider-" + rand_no).hide();
        jQuery(".section-background-video-" + rand_no).show();

    } else {
        jQuery(".section-custom-background-image-" + rand_no).hide();
        jQuery(".section-slider-" + rand_no).hide();
        jQuery(".section-custom-slider-" + rand_no).hide();
        jQuery(".section-background-video-" + rand_no).hide();
    }
}

function wp_rem_cs_header_element_toggle(id) {
    "use strict";

    if (id == "no-header") {
        jQuery("#wp_rem_cs_var_custom_header").hide();
        jQuery("#wp_rem_cs_var_rev_slider_header").hide();
        jQuery("#wp_rem_cs_var_map_header").hide();
        jQuery("#wp_rem_cs_var_no_header").show();
    } else if (id == "breadcrumb_header") {
        jQuery("#wp_rem_cs_var_rev_slider_header").hide();
        jQuery("#wp_rem_cs_var_map_header").hide();
        jQuery("#wp_rem_cs_var_no_header").hide();
        jQuery("#wp_rem_cs_var_custom_header").show();
    } else if (id == "custom_slider") {
        jQuery("#wp_rem_cs_var_custom_header").hide();
        jQuery("#wp_rem_cs_var_no_header").hide();
        jQuery("#wp_rem_cs_var_map_header").hide();
        jQuery("#wp_rem_cs_var_rev_slider_header").show();
    } else if (id == "map") {
        jQuery("#wp_rem_cs_var_custom_header").hide();
        jQuery("#wp_rem_cs_var_no_header").hide();
        jQuery("#wp_rem_cs_var_rev_slider_header").hide();
        jQuery("#wp_rem_cs_var_map_header").show();
    } else {
        jQuery("#wp_rem_cs_var_custom_header").hide();
        jQuery("#wp_rem_cs_var_rev_slider_header").hide();
        jQuery("#wp_rem_cs_var_map_header").hide();
        jQuery("#wp_rem_cs_var_no_header").hide();
    }
}

function show_sidebar_page(id) {
    "use strict";
    var $ = jQuery;
    jQuery(document).on('click', 'input[name="wp_rem_cs_var_page_layout"]', function () {
        jQuery(this).parent().parent().find(".check-list").removeClass("check-list");
        jQuery(this).siblings("label").children("#check-list").addClass("check-list");
    });
    if (id == 'left') {
        $("#wp_rem_cs_var_right_layout").hide();
        $("#wp_rem_cs_var_left_layout").show();
        $("#wp_rem_cs_var_second_right_layout").hide();
        $("#wp_rem_cs_var_second_left_layout").hide();
    } else if (id == 'right') {
        $("#wp_rem_cs_var_right_layout").show();
        $("#wp_rem_cs_var_left_layout").hide();
        $("#wp_rem_cs_var_second_right_layout").hide();
        $("#wp_rem_cs_var_second_left_layout").hide();
    } else if (id == 'small_right') {
        $("#wp_rem_cs_var_right_layout").show();
        $("#wp_rem_cs_var_left_layout").hide();
        $("#wp_rem_cs_var_second_right_layout").hide();
        $("#wp_rem_cs_var_second_left_layout").hide();
    } else if (id == 'small_left') {
        $("#wp_rem_cs_var_right_layout").hide();
        $("#wp_rem_cs_var_left_layout").show();
        $("#wp_rem_cs_var_second_right_layout").hide();
        $("#wp_rem_cs_var_second_left_layout").hide();
    } else if (id == 'small_left_large_right') {
        $("#wp_rem_cs_var_right_layout").show();
        $("#wp_rem_cs_var_left_layout").show();
        $("#wp_rem_cs_var_second_right_layout").hide();
        $("#wp_rem_cs_var_second_left_layout").hide();
    } else if (id == 'large_left_small_right') {
        $("#wp_rem_cs_var_right_layout").show();
        $("#wp_rem_cs_var_left_layout").show();
        $("#wp_rem_cs_var_second_right_layout").hide();
        $("#wp_rem_cs_var_second_left_layout").hide();
    } else if (id == 'both_left') {
        $("#wp_rem_cs_var_right_layout").hide();
        $("#wp_rem_cs_var_left_layout").show();
        $("#wp_rem_cs_var_second_right_layout").hide();
        $("#wp_rem_cs_var_second_left_layout").show();
    } else if (id == 'both_right') {
        $("#wp_rem_cs_var_right_layout").show();
        $("#wp_rem_cs_var_left_layout").hide();
        $("#wp_rem_cs_var_second_right_layout").show();
        $("#wp_rem_cs_var_second_left_layout").hide();
    } else {
        $("#wp_rem_cs_var_right_layout").hide();
        $("#wp_rem_cs_var_left_layout").hide();
        $("#wp_rem_cs_var_second_right_layout").hide();
        $("#wp_rem_cs_var_second_left_layout").hide();
    }
}

jQuery(document).on("click", "a.deleteit_node", function () {
    var mainConitem = jQuery(this).parents(".cs-wrapp-tab-box");
    jQuery(this).parent().append(html_popup);
    jQuery(this).parents(".cs-wrapp-clone").addClass("warning");
    jQuery(document).on('click', '.confirm-yes', function (event) {
        var totalItemCon = mainConitem.find(".cs-wrapp-clone").size();
        var totalItems = jQuery(".cs-wrapp-tab-box .fieldCounter").val();
        mainConitem.find(".fieldCounter").val(totalItems - 1);
        jQuery(this).parents(".cs-wrapp-clone").fadeOut(400, function () {
            jQuery(this).remove();
            return false;
        });

        jQuery("#confirmOverlay").remove();
    });

    jQuery(document).on('click', '.confirm-no', function (event) {
        jQuery(".cs-wrapp-clone").removeClass("warning");
        jQuery("#confirmOverlay").remove();
    });
    return false;
});


function wp_rem_cs_shortcode_element_ajax_call(val, id, admin_url) {

    if (val != "") {
        var shortcode_counter = 1
        var action = val;
        var newCustomerForm = "shortcode_element=" + val + '&action=wp_rem_cs_shortcode_element_ajax_call';
        var options='';
        if(val=='tabs_fancy'){
            $('input[name^="wp_rem_cs_var_tabs_title"]').each(function() {
                if($(this).val()!=''){
                options  +='<option>'+$(this).val()+'</option>';
            }
    
});
       
        }
        if(val=='faqs_fancy'){
            $('input[name^="wp_rem_cs_var_faqs_title"]').each(function() {
                if($(this).val()!=''){
                options  +='<option>'+$(this).val()+'</option>';
            }
    
});
       
        }
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: newCustomerForm,
            success: function (data) {
                jQuery('.shortcodeload').html("");
                jQuery("#" + id).append(data);
                $('select[name^="wp_rem_cs_var_tabs_fancy_active"]').append(options);
                  $('select[name^="wp_rem_cs_var_faqs_fancy_active"]').append(options);
                jQuery('.bg_color').wpColorPicker();
                //_commonshortcode(id);
                var a = jQuery("#" + id + " .cs-wrapp-clone.cs-shortcode-wrapp").not('.cs-disable-true').length;
                jQuery("#" + id).next('.hidden-object').find('.fieldCounter').val(a);
                jQuery('div.cs-drag-slider').each(function () {
                    var _this = jQuery(this);
                    _this.slider({
                        range: 'min',
                        step: _this.data('slider-step'),
                        min: _this.data('slider-min'),
                        max: _this.data('slider-max'),
                        value: _this.data('slider-value'),
                        slide: function (event, ui) {
                            jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
                        }
                    });
                });
                chosen_selectionbox();
                jQuery('[data-toggle="popover"]').popover();
            }
        });
    }
}


function chosen_selectionbox() {
    if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
        var config = {
            '.chosen-select': {width: "100%"},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%", search_contains: true},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        };
        for (var selector in config) {
            jQuery(selector).chosen(config[selector]);
        }
    }
}

function popup_view_box() {
    $ = jQuery;
    $('.thumbnail').viewbox();
}
function wp_rem_cs_var_page_subheader_style(wp_rem_cs_value) {

    if (wp_rem_cs_value == 'with_bg') {
        $('#wp_rem_cs_var_subheader_with_bg').show();
        $('#wp_rem_cs_var_subheader_with_bc').hide();
    } else {
        $('#wp_rem_cs_var_subheader_with_bg').hide();
        $('#wp_rem_cs_var_subheader_with_bc').show();
    }
}


/*
 *  Shortcode element ajax call function
 
 function wp_rem_cs_shortcode_element_ajax_call(val, id, admin_url) {
 "use strict";
 
 if (val != "") {
 var shortcode_counter = 1
 var action = val;
 var newCustomerForm = "shortcode_element=" + val + '&action=wp_rem_cs_var_page_builder_testimonial';
 jQuery.ajax({
 type: "POST",
 url: admin_url,
 data: newCustomerForm,
 success: function (data) {
 jQuery('.shortcodeload').html("");
 jQuery("#" + id).append(data);
 jQuery('.bg_color').wpColorPicker();
 //_commonshortcode(id);
 var a = jQuery("#" + id + " .cs-wrapp-clone.cs-shortcode-wrapp").not('.cs-disable-true').length;
 jQuery("#" + id).next('.hidden-object').find('.fieldCounter').val(a);
 jQuery('div.cs-drag-slider').each(function () {
 var _this = jQuery(this);
 _this.slider({
 range: 'min',
 step: _this.data('slider-step'),
 min: _this.data('slider-min'),
 max: _this.data('slider-max'),
 value: _this.data('slider-value'),
 slide: function (event, ui) {
 jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
 }
 });
 });
 
 }
 });
 }
 }
 */




function wp_rem_cs_frame_option_save(admin_url) {
    "use strict"
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
        success: function (response) {

            jQuery(".loading_div").hide();
            jQuery(".form-msg .innermsg").html(response);
            jQuery(".form-msg").show();
            jQuery(".outerwrapp-layer").delay(100).fadeOut(100)
            window.location.reload(true);
            slideout();
        }
    });
}
/*
 *  End Shortcode element ajax call function
 */
function wp_rem_cs_service_view_change(value) {
    "use strict";
    if (value == 'image') {
        jQuery(".cs-sh-service-image-area").show();
        jQuery(".cs-sh-service-icon-area").hide();
    } else {
        jQuery(".cs-sh-service-image-area").hide();
        jQuery(".cs-sh-service-icon-area").show();
    }
}

/**
 * @Sorting
 *
 */


function wp_rem_cs_var_gallery_sorting_list(id, random_id) {
    var gallery = []; // more efficient than new Array()
    jQuery('#gallery_sortable_' + random_id + ' li').each(function () {
        var data_value = jQuery.trim(jQuery(this).data('attachment_id'));
        gallery.push(jQuery(this).data('attachment_id'));
    });

    jQuery("#" + id).val(gallery.toString());
}

function wp_rem_cs_var_num_of_items(id, rand_id, numb) {
    var wp_rem_cs_var_gal_count = 0;
    jQuery("#gallery_sortable_" + rand_id + " > li").each(function (index) {
        wp_rem_cs_var_gal_count++;
        jQuery('input[name="wp_rem_cs_var_' + id + '_num"]').val(wp_rem_cs_var_gal_count);
    });

    if ( numb == '1' && numb != '' ) {
        var wp_rem_cs_var_data_temp = jQuery('#wp_rem_cs_var_' + id + '_temp');
        //if (jQuery('input[name="wp_rem_cs_' + id + '_num"]').val() == numb) {
            wp_rem_cs_var_data_temp.html('<input type="hidden" name="wp_rem_cs_var_' + id + '[]" value="">');
        //}
    }
}

function wp_rem_cs_var_createpop(data, type) {
    "use strict";
    var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>",
            $elem = jQuery('#cs-widgets-list');
    jQuery('body').addClass("cs-overflow");
    if (type == "csmedia") {
        $elem.append(data);
    }
    if (type == "filter") {
        jQuery('#' + data).wrap(_structure).delay(100).fadeIn(150);
        jQuery('#' + data).parent().addClass("wide-width");
    }
    if (type == "filterdrag") {
        jQuery('#' + data).wrap(_structure).delay(100).fadeIn(150);
    }

    if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
        var config = {
            '.chosen-select': {width: "100%"},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%", search_contains: true},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            jQuery(selector).chosen(config[selector]);
        }
    }

}

function wp_rem_cs_var_remove_overlay(id, text) {
    "use strict";
    jQuery("#cs-widgets-list .loader").remove();
    var _elem1 = "<div id='cs-pbwp-outerlay'></div>",
            _elem2 = "<div id='cs-widgets-list'></div>",
            $elem = jQuery("#" + id);
    jQuery("#cs-widgets-list").unwrap(_elem1);
    if (text == "append" || text == "filterdrag") {
        $elem.hide().unwrap(_elem2);
    }
    if (text == "widgetitem") {
        $elem.hide().unwrap(_elem2);
        jQuery("body").append("<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>");
        return false;

    }
    if (text == "ajax-drag") {
        jQuery("#cs-widgets-list").remove();
    }
    jQuery("body").removeClass("cs-overflow");
}



function wp_rem_switching_editor(is_builder_active, thisObj){
    var formData = new FormData($('#post')[0]);
    if (is_builder_active == "true") {
        jQuery("#add_page_builder_item").html("<div class='loader'><i class='icon-spinner icon-spin'></i></div>");
        formData.append('action', 'wp_rem_generate_shortcode');
         jQuery.ajax({
            url : wp_rem_globals.ajax_url,
            data : formData,
            type : 'POST',
            processData: false,
            contentType: false,
            success : function(response){
                if( typeof tinyMCE != 'undefined' && tinyMCE.activeEditor != null && tinyMCE.activeEditor != undefined ){
                    parent.tinyMCE.activeEditor.setContent(response);
                }else{
                    jQuery(".wp-editor-area").val(response);
                }
                toggle_builder("#postdivrich", "#id_page_builder");
                thisObj.removeAttr('disabled');
            }
        });
    }else{
        jQuery("#add_page_builder_item").html("<div class='loader'><i class='icon-spinner icon-spin'></i></div>");
        //formData.append('action', 'wp_rem_generate_elements_view');
        if( typeof tinyMCE != 'undefined' && tinyMCE.activeEditor != null && tinyMCE.activeEditor != undefined ){
            var content = tinyMCE.activeEditor.getContent();
        }else{
            var content = jQuery(".wp-editor-area").val();
        }
        content     = encodeURIComponent(content);
        var post_id = jQuery("#post_ID").val();
         jQuery.ajax({
            url : wp_rem_globals.ajax_url,
            data : 'post_id='+post_id+'&content='+content+'&action=wp_rem_generate_elements_view',
            type : 'POST',
            success : function(response){
                jQuery("#add_page_builder_item").html(response);
                thisObj.removeAttr('disabled');
            }
        });
    }
}

function toggle_builder(active, inactive) {
    jQuery(inactive).fadeOut("fast", function () {
        jQuery(active).fadeIn();
    });
    window.editorExpand && window.editorExpand.off && window.editorExpand.off();
}
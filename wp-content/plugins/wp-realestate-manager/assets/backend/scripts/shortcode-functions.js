/**
 *
 *Shortcode
 */
function wp_rem_shortocde_selection(val, admin_url, id) {
    "use strict";
    SuccessLoader();
    jQuery("#" + id).parents('#cs-widgets-list').removeClass('wide-width');
    if (val != "" && val != "Shortcode") {
	jQuery('#cs-shrtcode-loader').html('<i class="icon-spinner8 icon-spin"></i>');
	var shortcode_counter = 1
	var action = "wp_rem_shortcode_" + val;
	var newCustomerForm = "action=" + action + '&counter=' + shortcode_counter + '&shortcode_element=shortcode';
	jQuery.ajax({
	    type: "POST",
	    url: admin_url,
	    data: newCustomerForm,
	    success: function (data) {
		removeoverlay(id, 'widgetitem');
		_createpop(data, "csmedia");
		jQuery('.bg_color').wpColorPicker();
		jQuery('#cs-shrtcode-loader').html('');
	    }
	});
    }
}


function chosen_selectionbox() {
    "use strict";
    if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
	var config = {
	    '.chosen-select': {width: "100%"},
	    '.chosen-select-deselect': {allow_single_deselect: true},
	    '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%",search_contains: true},
	    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
	    '.chosen-select-width': {width: "95%"}
	}
	for (var selector in config) {
	    jQuery(selector).chosen(config[selector]);
	}
    }
}
/**
 *
 *SuccessLoader
 */
function SuccessLoader() {
    "use strict";
    jQuery("#cs-widgets-list div:first").hide();
    var loader = "<div class='loader'><i class='icon-spinner icon-spin'></i></div>"
    jQuery("#cs-widgets-list").append(loader)

}
/**
 *
 *removeoverlay
 */
function removeoverlay(id, text) {
    "use strict";
    jQuery("#cs-widgets-list .loader").remove();
    var _elem1 = "<div id='cs-pbwp-outerlay'></div>";
    var _elem2 = "<div id='cs-widgets-list'></div>";
    var $elem = jQuery("#" + id);
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
/**
 *
 *_createpop
 */
function _createpop(data, type) {
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

}
/**
 *
 *Shortcode_tab_insert_editor
 */
function Shortcode_tab_insert_editor(element_name, id) {
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
		if ($el.attr('name') != undefined) {

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
    jQuery('body').removeClass('cs-overflow');
    jQuery("#cs-pbwp-outerlay").remove();
    return false;
}

/*
 *  page composer filter function
 */
function wp_rem_page_composer_filterable(id) {
    "use strict";
    var $container = jQuery("#page_element_container" + id),
	    elclass = "cs-filter-item";
    $container.find('.element-item').addClass("cs-filter-item");
    jQuery(document).on('click', "#filters" + id + " li", function (event) {
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


/*
 * Getting Categories for Type
 */

jQuery(document).on("change", ".get-property-cats-by-type", function () {
    var property_type   = jQuery(this).val();
    $.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: 'property_type='+property_type+'&action=get_property_cats_by_type',
        success: function (response) {
            jQuery(".type-categories-selection").html(response);
        }
    });
});
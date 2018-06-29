var propertyCategoryFilterAjax;
function wp_rem_load_category_models(selected_val, post_id, main_container, load_saved_value, data_child, parent_loader) {
    'use strict';
    data_child = data_child = parent_loader || '';
    var data_vals = '';
    if (typeof (propertyCategoryFilterAjax) != 'undefined') {
        propertyCategoryFilterAjax.abort();
    }

    var this_loader = $('.type-categry-holder-main-' + post_id);

    if (parent_loader == 'parent_loader') {
        this_loader.addClass('active-ajax');
    }

    var wp_rem_property_category = jQuery("#wp_rem_property_category").val();
    propertyCategoryFilterAjax = jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: wp_rem_globals.ajax_url,
        data: data_vals + '&action=wp_rem_meta_property_categories&selected_val=' + selected_val + '&data_child=' + data_child + '&post_id=' + post_id + '&wp_rem_property_category=' + wp_rem_property_category + '&load_saved_value=' + load_saved_value,
        success: function (response) {
            jQuery("." + main_container).html(response.html);
            jQuery(".chosen-select").chosen();

            if (parent_loader == 'parent_loader') {
                this_loader.removeClass('active-ajax');
            }
        }
    });
}
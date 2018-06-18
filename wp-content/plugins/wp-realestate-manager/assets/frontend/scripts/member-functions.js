var memberFilterAjax;

jQuery(document).ready(function () {
    jQuery(function () {
        var $checkboxes = jQuery("input[type=checkbox]");
        $checkboxes.on('change', function () {
            var ids = $checkboxes.filter(':checked').map(function () {
                return this.id;
            }).get().join(',');
            jQuery('#hidden_input').val(ids);
        });
    });
});
function wp_rem_member_content(counter) {
    "use strict";
    counter = counter || '';
    var member_arg = jQuery("#member_arg" + counter).html();
    var this_frm = jQuery("#frm_member_arg" + counter);

    var ads_list_count = jQuery("#ads_list_count_" + counter).val();
    var ads_list_flag = jQuery("#ads_list_flag_" + counter).val();
    var list_flag_count = jQuery("#ads_list_flag_count_" + counter).val();
    jQuery('.slide-loader-holder').addClass('slide-loader');
    jQuery('html, body').animate({scrollTop: jQuery('#wp-rem-member-content-' + counter).parent().parent().offset().top - 100}, 'slow');
    if( jQuery("#frm_member_arg" + counter).length > 0 ){
        var data_vals = jQuery(jQuery("#frm_member_arg" + counter)[0].elements).not(":input[name='alerts-email'], :input[name='alert-frequency']").serialize();
        data_vals = data_vals.replace(/[^&]+=\.?(?:&|$)/g, ''); // remove extra and empty variables
        data_vals = data_vals + '&ajax_filter=true';
        wp_rem_show_loader('#wp-rem-member-content-' + counter);

        if (!jQuery('body').hasClass('wp-rem-changing-view')) {
             
        }

        jQuery('#wp-rem-data-member-content-' + counter + ' .all-results').addClass('slide-loader');
        if (typeof (memberFilterAjax) != 'undefined') {
            memberFilterAjax.abort();
        }
        memberFilterAjax = jQuery.ajax({
            type: 'POST',
            dataType: 'HTML',
            url: wp_rem_globals.ajax_url,
            data: data_vals + '&action=wp_rem_members_content&member_arg=' + member_arg,
            success: function (response) {
                jQuery('.slide-loader-holder').removeClass('slide-loader');
                jQuery('body').removeClass('wp-rem-changing-view');
                jQuery('#Member-content-' + counter).html(response);
                var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_vals; //window.location.href;
                window.history.pushState(null, null, decodeURIComponent(current_url));
                jQuery(".chosen-select").chosen();
                jQuery('#wp-rem-data-member-content-' + counter + ' .all-results').removeClass('slide-loader');
                wp_rem_hide_loader();
            }
        });
    }
} 
function wp_rem_member_view_switch(view, counter, member_short_counter) {
    "use strict";
    wp_rem_show_loader('.page-content');
    jQuery.ajax({
        type: 'POST',
        dataType: 'HTML',
        url: wp_rem_globals.ajax_url,
        data: '&action=wp_rem_member_view_switch&view=' + view + '&member_short_counter=' + member_short_counter,
        success: function () {
            jQuery('body').addClass('wp-rem-changing-view');
            wp_rem_member_content(counter);
        }
    });
}
function wp_rem_member_pagenation_ajax(page_var, page_num, counter) { 
    "use strict";
    jQuery('#' + page_var + '-' + counter).val(page_num);
    wp_rem_member_content(counter);
}
function wp_rem_member_alphanumaric_ajax(field, value, counter) { 
    "use strict";
    jQuery('#' + field + '-' + counter).val(value);
    wp_rem_member_content(counter);
}

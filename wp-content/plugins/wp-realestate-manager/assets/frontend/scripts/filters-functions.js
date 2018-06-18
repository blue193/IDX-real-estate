function wp_rem_date_range_filter( field_name, actionString, date_picker_position ){
    "use strict";
    if (typeof date_picker_position === "undefined" || date_picker_position === '' ) {
        date_picker_position = 'left';
    }
    jQuery('#'+ field_name).daterangepicker({
        autoUpdateInput: false,
        opens: date_picker_position,
        locale: {
            format: 'DD/MM/YYYY',
        }
    },
    function(start, end) {
        var date_range = start.format('DD/MM/YYYY')+ ' - ' + end.format('DD/MM/YYYY');
        jQuery('#'+ field_name).val(date_range);
        var pageNum = 1;
        wp_rem_show_loader('.loader-holder');
        var filter_parameters = wp_rem_get_filter_parameters();
        if (typeof (ajaxRequest) != 'undefined') {
            ajaxRequest.abort();
        }
        ajaxRequest = jQuery.ajax({
            type: "POST",
            url: wp_rem_globals.ajax_url,
            data: 'page_id_all=' + pageNum + '&action=' + actionString + filter_parameters,
            success: function (response) {
                    wp_rem_hide_loader();
                    jQuery('.user-holder').html(response);

            }
        });
    });
    jQuery('#'+ field_name).on('cancel.daterangepicker', function(ev, picker) {
        "use strict";
        jQuery('#'+ field_name).val('');
        var pageNum = 1;
        wp_rem_show_loader('.loader-holder');
        var filter_parameters = wp_rem_get_filter_parameters();
        if (typeof (ajaxRequest) != 'undefined') {
            ajaxRequest.abort();
        }
        ajaxRequest = jQuery.ajax({
            type: "POST",
            url: wp_rem_globals.ajax_url,
            data: 'page_id_all=' + pageNum + '&action=' + actionString + filter_parameters,
            success: function (response) {
                    wp_rem_hide_loader();
                    jQuery('.user-holder').html(response);

            }
        });
    });
}

function wp_rem_get_filter_parameters() {

    "use strict";

    var date_range = jQuery(".user-holder").find("#date_range").val();

    var filter_var = "";

    if (typeof date_range != "undefined" && date_range !== "") {

        filter_var += "&date_range=" + date_range;

    }

    return filter_var;

}
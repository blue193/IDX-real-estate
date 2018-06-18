/*
 * Hide Notification from Member Dashboard
 */
jQuery(document).on("click", ".hide_notification", function () {
    thisObj = jQuery(this);
    var id = thisObj.parent('li').data('id');
    wp_rem_show_loader('.loader-holder');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: wp_rem_globals.ajax_url,
        data: 'id=' + id + '&action=wp_rem_hide_notification',
        success: function (response) {
            wp_rem_show_response(response);
            thisObj.parent('li').remove();
        }
    });
});

/*
 * Clearing All Notifications from member dashboard
 */
jQuery(document).on("click", ".wp-rem-clear-notifications a", function () {
    thisObj = jQuery(this);
    wp_rem_show_loader('.loader-holder');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: wp_rem_globals.ajax_url,
        data: 'action=wp_rem_clear_all_notification',
        success: function (response) {
            wp_rem_show_response(response);
            thisObj.closest('.user-notification').remove();
        }
    });
});
(function ($) {
    $(function () {
        $(".email-properties-top").click(function () {
            $(".property-alert-container-top .validation").addClass("hide");
            //$(".name-input-top").val('');
            $(".property-alert-container-top").slideToggle();
            return false;
        });
       
        $(".btn-close-property-alert-box").click(function () {
            $(".property-alert-container-top").slideToggle();
            return false;
        });
        $('body').on('click', '.propertyalert-submit', function () { 
            var email = $(".email-input-top").val();
            // This one is removed
            var name = $(".name-input-top").val();
            //var name = email;
            var frequency = $('input[name="alert-frequency"]:checked').val();
            if (typeof frequency == "undefined") {
                frequency = "never";
            }
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var thisObj = jQuery('.propertyalert-submit-button');
            wp_rem_show_loader('.propertyalert-submit-button', '', 'button_loader', thisObj);
            $.ajax({
                "type": "POST",
                "url": wp_rem_notifications.ajax_url,
                "data": {
                    "action": "wp_rem_create_property_alert",
                    "email": email,
                    "name": name,
                    "frequency": frequency,
                    "location": window.location.toString(),
                    "security": wp_rem_notifications.security,
                    "query": $(".properties_query").text(),
                },
                "dataType": "json",
                "success": function (response) {

                    wp_rem_show_response(response, '.property-alert-box', thisObj);
                    if (response.type == 'success') {
                        $(".name-input-top").val('');
                    }
                },
            });
            return false;
        });
    });
})(jQuery);

function wp_rem_dashboard_tab_load_property_alerts(tabid, type, admin_url, uid, pkg_array, page_id_all, tab_options) {
    var dataString = "wp_rem_uid=" + uid + "&action=wp_rem_employer_propertyalerts" + "&page_id_all=" + page_id_all;
    ajaxRequest = jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            alert("a");
            jQuery("#property-alerts").html(response);
            wp_rem_change_dashboard_tab(tab_options);
        }
    });
}
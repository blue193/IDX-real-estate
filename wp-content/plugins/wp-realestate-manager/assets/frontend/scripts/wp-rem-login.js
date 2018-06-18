/*
 * Login Block
 */


/*** User Login Authentication*/

function wp_rem_user_authentication(admin_url, id, thisObjClass) {
    "use strict";
    var formDivClass = ".login-form-id-" + id;
    if (typeof thisObjClass == "undefined" || thisObjClass == "") {
        var thisObjClass = ".ajax-login-button";
    } else if (thisObjClass === ".shortcode-ajax-login-button") {
        formDivClass = "";
    }
    var thisObj = jQuery(thisObjClass);
    wp_rem_show_loader(thisObjClass, "", "button_loader", thisObj);
    
    function newValues(id) {
        var serializedValues = jQuery("#ControlForm_" + id).serialize();
        return serializedValues;
    }
    var serializedReturn = newValues(id);
    jQuery(".login-form-id-" + id + " .status-message").removeClass("success error");
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        dataType: "json",
        data: serializedReturn,
        success: function(data) {
            if (data.type == "error") {
                wp_rem_show_response(data, formDivClass, thisObj);
            } else if (data.type == "success") {
                wp_rem_show_response(data, formDivClass, thisObj);
                document.location.href = data.redirecturl;
            }
        }
    });
}

/*
 * Company Name based on Profile Type
 */

jQuery(document).on("change", ".wp_rem_profile_type", function() {
    "use strict";
    var current_val = jQuery(this).val();
    if (current_val == "company") {
        jQuery(".wp-rem-company-name").show();
        jQuery(".display-name-field").hide();
        jQuery(".member-type-field").show();
    } else {
        jQuery(".wp-rem-company-name").hide();
        jQuery(".display-name-field").show();
        jQuery(".member-type-field").hide();
    }
});

jQuery(document).on("click", ".user-tab-register, .user-tab-login", function() {

    "use strict";

    var thisObj = jQuery(this);

    if (thisObj.hasClass("user-tab-register")) {

        var tab_name = "register";

    } else {

        var tab_name = "login";

    }

    var serializedValues = "member_user_tab=" + tab_name;

    jQuery.ajax({

        type: "POST",

        url: wp_rem_globals.ajax_url,

        data: serializedValues + "&action=wp_rem_set_user_tab_cookie",

        success: function(response) {}

    });
    
});

function wp_rem_registration_validation(admin_url, id, thisObjClas) {

    "use strict";

    $(".status-message").removeClass("text-danger").hide();

    var formDivID = "#user-register-" + id + " .modal-body";

    if (typeof thisObjClas == "undefined" || thisObjClas == "") {

        thisObjClas = ".ajax-signup-button";

    } else if (thisObjClas === ".shortcode-ajax-signup-button") {

        formDivID = "";

    }

    var thisObj = jQuery(thisObjClas);

    wp_rem_show_loader(thisObjClas, "", "button_loader", thisObj);



    function newValues(id) {

        jQuery("#user_profile").val();

        var serializedValues = jQuery("#wp_signup_form_" + id).serialize() + "&id=" + id;

        return serializedValues;

    }

    var serializedReturn = newValues(id);

    jQuery("div#result_" + id).removeClass("success error");

    jQuery.ajax({

        type: "POST",

        url: admin_url,

        dataType: "json",

        data: serializedReturn,

        success: function(response) {

            wp_rem_show_response(response, formDivID, thisObj);

        }

    });

}

$(".login-form .nav-tabs > li").on("click", function(e) {

    "use strict";

    if (!$(this).hasClass("active")) {

        jQuery(this).closest(".modal-body .loader").show();

        if ($(".login-form .modal-body .loader").length == 0) {

            $(".login-form .modal-body").append('<span class="loader"></span>');

        }

        setTimeout(function() {

            $(".login-form .modal-body .loader").fadeOut();

        }, 400);

    }

});

jQuery(document).ready(function($) {
    "use strict";

    jQuery(".login-box").hide();
    
    jQuery(".login-link").on("click", function(e) {
        e.preventDefault();
        jQuery(".nav-tabs, .nav-tabs~.tab-content, .forgot-box").fadeOut(function() {
            jQuery(".login-box").fadeIn();
        });
    });

    /*
     * frontend login tabs function
     */

    jQuery(".login-link-page").on("click", function(e) {
        e.preventDefault();
        jQuery(".nav-tabs-page, .nav-tabs-page~.tab-content-page, .forgot-box").fadeOut(function() {
            jQuery(".login-box").fadeIn();
            jQuery(".tab-content-page").fadeOut();
        });
    });

    /*
     * frontend register tabs function
     */

    jQuery(".register-link").on("click", function(e) {
        e.preventDefault();
        jQuery(".login-box, .forgot-box").fadeOut(function() {
            jQuery(".nav-tabs, .nav-tabs~.tab-content").fadeIn();
        });
    });

    /*
     * frontend register tabs function
     */

    jQuery(".register-link-page").on("click", function(e) {
        e.preventDefault();
        jQuery(".login-box, .forgot-box").fadeOut(function() {
            jQuery(".tab-content-page").fadeIn();
            jQuery(".nav-tabs-page").fadeIn();
        });
    });

    /*
     * frontend page element forgotpassword function
     */

    jQuery(".user-forgot-password-page").on("click", function(e) {
        e.preventDefault();
        jQuery(".login-box, .nav-tabs-page, .nav-tabs-page~.tab-content-page").fadeOut(function() {
            jQuery(".forgot-box").fadeIn();
        });
    });

    /*
    * frontend forgotpassword function
     */

    jQuery(".user-forgot-password").on("click", function(e) {
        e.preventDefault();
        jQuery(".login-box, .nav-tabs, .nav-tabs~.tab-content").fadeOut(function() {
            jQuery(".forgot-box").fadeIn();
        });
    });
});
jQuery(document).on("click", ".team-option .add_team_member", function(e) {
    "use strict";
    e.preventDefault();
    jQuery(".add-member").addClass("active");
    jQuery("body").append('<div id="overlay" style="display:none"></div>');
    jQuery("#overlay").fadeIn(300);
});

jQuery(document).on("click", ".user-profile .add-member .cancel", function(e) {
    "use strict";
    e.preventDefault();
    jQuery(".add-member").removeClass("active");
    jQuery("#overlay").fadeOut(300);
    setTimeout(function() {
        jQuery("#overlay").remove();
    }, 400);
});

jQuery(document).on("click", ".restaurant-team-member-det", function(e) {
    "use strict";
    e.preventDefault();
    var dat_id = jQuery(this).attr("data-id");
    jQuery("#team-member-det-" + dat_id).addClass("active");
    jQuery("body").find("#overlay").remove();
    jQuery(this).parent().append('<div id="overlay" style="display:none"></div>');
    jQuery("#overlay").fadeIn(300);
    jQuery("#team-member-det-" + dat_id).show();
});

jQuery(document).on("click", ".team-member-det-box .cancel", function(e) {
    "use strict";
    e.preventDefault();
    jQuery(this).parents(".team-member-det-box").removeClass("active");
    jQuery(this).parents(".team-member-det-box").hide();
    jQuery("#overlay").fadeOut(300);
    setTimeout(function() {
        jQuery("#overlay").remove();
    }, 400);
});

jQuery(document).on("click", ".add_team_member, .restaurant-team-member-det", function() {
    if (jQuery("body").hasClass("invite-member-open") == false) {
        jQuery("body").addClass("invite-member-open");
    }
    jQuery(document).on("click", ".invite-member .cancel", function() {
        jQuery("body").removeClass("invite-member-open");
    });
});

/*
 * Adding Team Member
 */
jQuery(document).on("click", "#add_member", function() {
    "use strict";
    var thisObj = jQuery(this);
    wp_rem_show_loader("#add_member", "", "button_loader", thisObj);
    var serializedValues = jQuery("#team_add_form").serialize();
    var form = $('#team_add_form')[0];
    var form_data = new FormData(form);
    form_data.append('action', 'wp_rem_add_team_member');
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        url: wp_rem_globals.ajax_url,
        data: form_data,
        success: function(response) {
            wp_rem_show_response(response, ".team-fields", thisObj);
        }
    });
});

/*
 * Update Team Member
 */
jQuery(document).on("click", "#team_update_form", function() {
    "use strict";
    var user_id = jQuery(this).closest("form").data("id");
    var data_id = jQuery(this).data("id");
    var thisClass = ".team-update-button-" + data_id;
    var thisObj = jQuery(this);
    wp_rem_show_loader(thisClass, "", "button_loader", thisObj);
    var serializedValues = jQuery("#wp_rem_update_team_member" + user_id).serialize();
    var form = $("#wp_rem_update_team_member" + user_id)[0];
    var form_data = new FormData(form);
    form_data.append('wp_rem_user_id', user_id);
    form_data.append('action', 'wp_rem_update_team_member');
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        url: wp_rem_globals.ajax_url,
        data: form_data,
        success: function(response) {
            jQuery("#wp_rem_member_company").trigger("click");
            wp_rem_show_response(response, "", thisObj);
        }
    });
});

/*
 * Remove Team Member
 */
jQuery(document).on("click", ".remove_member", function() {
    "use strict";
    var thisObj = jQuery(this);
    var user_id = thisObj.closest("form").data("id");
    var count_supper_admin = thisObj.closest("form").data("count_supper_admin");
    var selected_user_type = thisObj.closest("form").data("selected_user_type");
    wp_rem_show_loader();
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: wp_rem_globals.ajax_url,
        data: "wp_rem_user_id=" + user_id + "&selected_user_type=" + selected_user_type + "&count_supper_admin=" + count_supper_admin + "&action=wp_rem_remove_team_member",
        success: function(response) {
            if (response.type == "success") {
                jQuery("#wp_rem_member_company").trigger("click");
                thisObj.closest("form").fadeOut("slow");
            }
            wp_rem_show_response(response);
        }
    });
});
    
/* ---------------------------------------------------------------------------
 * get posts by alphabatial order
 * --------------------------------------------------------------------------- */

function wp_rem_member_content(counter, char, page_var, post_per_page, page_num) {

    "use strict";

    wp_rem_show_loader(".member-alphabatic");

    if (typeof ajaxRequest != "undefined") {
        ajaxRequest.abort();
    }

    jQuery.ajax({
        type: "POST",
        dataType: "HTML",
        url: wp_rem_globals.ajax_url,
        data: "page_num=" + page_num + "&post_per_page=" + post_per_page + "&counter=" + counter + "&page_var=" + page_var + "&char=" + char + "&action=wp_rem_member_content",
        success: function(response) {
            jQuery(".ajax-div").html(response);
            wp_rem_hide_loader();
        }
    });

}

function wp_rem_member_pagenation_ajax(page_var, page_num, counter, post_per_page) {
    "use strict";
    jQuery("#" + page_var + "-" + counter).val(page_num);
    wp_rem_member_content(counter, "", page_var, post_per_page, page_num);
}

jQuery(document).on("click", "#profile_form", function() {
    "use strict";
    var returnType = wp_rem_validation_process(jQuery("#member_profile"));
    if (returnType == false) {
        return false;
    }
    var thisObj = jQuery(this);
    wp_rem_show_loader("#profile_form", "", "button_loader", thisObj);
    // Get all the forms elements and their values in one ste
    var serializedValues = jQuery("#member_profile").serialize();
    var ajax_url = $("#member_profile").attr("data-action");
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: wp_rem_globals.ajax_url,
        data: serializedValues + "&action=wp_rem_member_accounts_save",
        success: function(response) {
            if (jQuery("#member_profile").find("#wp_rem_member_display_name").length > 0) {
                var display_name = jQuery("#member_profile #wp_rem_member_display_name").val();
                wp_rems_update_display_name(display_name);
            }
            var default_image_url = jQuery("#cropContainerModal").attr("data-def-img");
            if (jQuery("#cropContainerModal").find("img.croppedImg2").length > 0) {
                var upload_image_src = jQuery("#cropContainerModal .croppedImg2").attr("src");
                wp_rems_appned_profile_image(upload_image_src, default_image_url, true);
            } else if (jQuery("#cropContainerModal").find("img").length > 0) {
                var image_src = jQuery("#cropContainerModal img").attr("src");
                wp_rems_appned_profile_image(image_src, default_image_url, false);
            }
            wp_rem_show_response(response, "", thisObj);
        }
    });
});



function wp_rems_update_display_name(display_name) {
    "use strict";
    if (typeof display_name !== "undefined" && display_name != "") {
        if (jQuery(".user-info-sidebar").find("h3.user-full-name").length > 0) {
            jQuery(".user-info-sidebar").find("h3.user-full-name").text(display_name);
        }
        if (jQuery(".user-dashboard-menu").find("span.user-full-name").length > 0) {
            jQuery(".user-dashboard-menu").find("span.user-full-name").text(display_name);
        }
    }
}



function wp_rems_appned_profile_image(image_url, default_image_url, appned_span) {
    "use strict";
    if (image_url != "") {
        jQuery(".user-dashboard-menu .profile-image").find("img").attr("src", image_url);
        if (jQuery(".user-info-sidebar .img-holder").find("img").length > 0) {
            jQuery(".user-info-sidebar .img-holder").find("img").attr("src", image_url);
        }

    } else if (default_image_url != "") {
        jQuery(".user-dashboard-menu .profile-image").find("img").attr("src", default_image_url);
        jQuery("#cropContainerModal").find("img").attr("src", default_image_url);
        jQuery("#cropContainerModal").find("img").show();
        if (jQuery(".user-info-sidebar .img-holder").find("img").length > 0) {
            jQuery(".user-info-sidebar .img-holder").find("img").attr("src", default_image_url);
        }
    }

}

jQuery(document).on("click", ".ad-submit", function() {
    "use strict";
    var thisObj = jQuery(this);
    wp_rem_show_loader(".ad-submit", "", "button_loader", thisObj);
});

/*
 * 
 * change password
 */

jQuery(document).on("click", "#member_change_password", function() {
    "use strict";
    var returnType = wp_rem_validation_process(jQuery("#change_password_form"));
    if (returnType == false) {
        return false;
    }
    var thisObj = jQuery("#member_change_password");
    wp_rem_show_loader("#member_change_password", "", "button_loader", thisObj);
    var serializedValues = jQuery("#change_password_form").serialize();
    var form = $("#change_password_form")[0];
    var form_data = new FormData(form);
    form_data.append('action', 'member_change_pass');
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        url: wp_rem_globals.ajax_url,
        data: form_data,
        success: function(response) {
            wp_rem_show_response(response, "", thisObj);
        }
    });
});

/*
 * change Location
 */

jQuery(document).on("click", "#member_change_address", function() {
    "use strict";
    // Get all the forms elements and their values in one ste
    var thisObj = jQuery(this);
    wp_rem_show_loader("#member_change_address", "", "button_loader", thisObj);
    var serializedValues = jQuery("#change_address_form").serialize();
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: wp_rem_globals.ajax_url,
        data: serializedValues + "&action=member_change_address",
        success: function(response) {
            wp_rem_show_response(response, "", thisObj);
        }
    });
});

/*
 * Book Day OFF
 */

jQuery(document).on("click", "#member-book-day-off-btn", function() {
    "use strict";
    var thisObj = jQuery(this);
    wp_rem_show_loader("#member-book-day-off-btn", "", "button_loader", thisObj);
    var serializedValues = jQuery("#member-book-day-off-form").serialize();
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: wp_rem_globals.ajax_url,
        data: serializedValues + "&action=wp_rem_member_book_day_off_submission",
        success: function(response) {
            wp_rem_show_response(response, "", thisObj);
        }
    });
});

jQuery(document).on("click", ".uploaded-img li img", function() {
    "use strict";
    var img_src = jQuery(this).attr("src");
    var attachment_id = jQuery(this).attr("data-attachment_id");
    jQuery("#cropContainerModal .croppedImg2").show();
    jQuery("#cropContainerModal figure a img, #cropContainerModal .croppedImg2").attr("src", img_src);
    jQuery("#wp_rem_member_profile_image").val(attachment_id);
    jQuery("#cropContainerModal").attr("data-img-type", "selective");
    jQuery("#cropContainerModal .cropControls").show();
});

function wp_rem_user_permission($this, add_member_permission, condition) {
    "use strict";
    if (jQuery($this).val() == condition) {
        jQuery("." + add_member_permission).hide("slow");
    } else {
        jQuery("." + add_member_permission).show("slow");
    }
}

/*
 * Remove Branch
 */

jQuery(document).on("click", ".remove_branche", function() {
    "use strict";
    var branch_id = jQuery(this).parent().data("id");
    wp_rem_show_loader();
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: wp_rem_globals.ajax_url,
        data: "wp_rem_branch_id=" + branch_id + "&action=wp_rem_remove_member_branch",
        success: function(response) {
            if (response.type == "success") {
                jQuery("#wp_rem_member_change_locations").trigger("click");
            }
            wp_rem_show_response(response);
        }
    });

});

jQuery(document).on("click", ".branch-option .add_branch", function(e) {
    "use strict";
    e.preventDefault();
    var thisObj = jQuery(this);
    wp_rem_show_loader(".add_branch", "", "button_loader", thisObj);
    jQuery.ajax({
        type: "POST",
        dataType: "html",
        url: wp_rem_globals.ajax_url,
        data: "action=wp_rem_member_branch_add",
        success: function(response) {
            jQuery("#add_update_branch").html(response);
            wp_rem_show_response('');
            jQuery(".add-update-branch").addClass("active");
            jQuery("body").append('<div id="overlay" style="display:none"></div>');
            jQuery("#overlay").fadeIn(300);
        }
    });
});

jQuery(document).on("click", ".member-branch-det", function(e) {
    "use strict";
    e.preventDefault();
    var branch_id = jQuery(this).data("id");
    jQuery.ajax({
        type: "POST",
        dataType: "html",
        url: wp_rem_globals.ajax_url,
        data: "wp_rem_branch_id=" + branch_id + "&action=wp_rem_member_branch_add",
        success: function(response) {
            jQuery("#add_update_branch").html(response);
            jQuery(".add-update-branch").addClass("active");
            jQuery("body").append('<div id="overlay" style="display:none"></div>');
            jQuery("#overlay").fadeIn(300);

        }

    });

});


jQuery(document).on("click", ".user-profile .add-update-branch .cancel", function(e) {
    "use strict";
    e.preventDefault();
    jQuery(".add-update-branch").removeClass("active");
    jQuery("#overlay").fadeOut(300);
    setTimeout(function() {
        jQuery("#overlay").remove();
    }, 400);
});

/*
 * Add/Update Branch
 */

jQuery(document).on("click", "#save_branch", function() {
    "use strict";
    var thisObj = jQuery(this);
    wp_rem_show_loader("#save_branch", "", "button_loader", thisObj);
    var serializedValues = jQuery("#branch_add_form").serialize();
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: wp_rem_globals.ajax_url,
        data: serializedValues + "&action=wp_rem_add_update_branch",
        success: function(response) {
            wp_rem_show_response(response, ".branch-fields", thisObj);
            setTimeout(function() {
                if (response.type == "success") {
                    jQuery(".add-update-branch").removeClass("active");
                    jQuery("#overlay").fadeOut(300);
                    setTimeout(function() {
                        jQuery("#overlay").remove();
                    }, 400);
                    jQuery("#wp_rem_member_change_locations").trigger("click");
                }
            }, 2000);
        }
    });
});

jQuery(document).on("click", ".member-thumbnail-upload", function() {
    var data_id = jQuery(this).data('id');
    jQuery("#wp_rem_member_thumb_" + data_id).click();
});

jQuery(document).on("change", ".wp-rem-member-thumb", function(event) {
    var data_id = jQuery(this).data('id');
    var tmppath = URL.createObjectURL(event.target.files[0]);
    jQuery(".member-thumbnail-" + data_id).html('<img src="' + tmppath + '" width="124" height="124"><div class="remove-member-thumb" data-id="' + data_id + '"><i class="icon-close"></i></div>');
});

jQuery(document).on("click", ".remove-member-thumb", function() {
    var data_id = jQuery(this).data('id');
    jQuery(".member-thumbnail-" + data_id).html('');
    jQuery("#wp_rem_member_thumb_id_" + data_id).val('');
});
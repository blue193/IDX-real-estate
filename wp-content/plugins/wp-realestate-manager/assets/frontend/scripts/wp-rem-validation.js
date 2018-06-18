/*
 * Validation Block
 */
/*
 * Validation Process by Form
 */

function wp_rem_validation_process(form_name) {
    var has_empty = new Array();
    var alert_messages = new Array();
    var radio_fields = new Array();
    var checkbox_fields = new Array();
    var array_length;
    jQuery(form_name).find(".wp-rem-dev-req-field,.wp-rem-number-field,.wp-rem-email-field,.wp-rem-url-field,.wp-rem-date-field,.wp-rem-range-field").each(function(index_no) {
        var is_visible = true;
        var thisObj = jQuery(this);
        var visible_id = thisObj.data("visible");
        has_empty[index_no] = false;
        if (wp_rem_is_field(visible_id) == true) {
            is_visible = jQuery("#" + visible_id).is(":hidden");
            if (jQuery("#" + visible_id).css("display") !== "none") {
                is_visible = true;
            } else {
                is_visible = false;
            }
        }
        if (thisObj.attr("type") == "checkbox") {s
            var thisObj = jQuery("#" + thisObj.attr("name"));
            if (thisObj.val() == "off") {
                thisObj.val("");
            }
        }
        if (thisObj.attr("type") == "radio") {
            var field_name = thisObj.attr("name");
            var is_field_checked = jQuery('input[name="' + field_name + '"]').is(":checked");
            if (is_field_checked == false) {
                radio_fields[index_no] = thisObj;
            }
            is_visible = false;
        }
        if (thisObj.attr("type") == "checkbox") {
            var field_name = thisObj.attr("name");
            var is_field_checked = jQuery('input[name="' + field_name + '"]').is(":checked");
            if (is_field_checked == false) {
                checkbox_fields[index_no] = thisObj;
            }
            is_visible = false;
        }
        if (!thisObj.val() && is_visible == true) {
            if (thisObj.hasClass("wp-rem-dev-req-field")) {
                var array_length = alert_messages.length;
                alert_messages[array_length] = wp_rem_insert_error_message(thisObj, alert_messages, "");
                has_empty[index_no] = true;
            }
        } else {
            if (is_visible == true) {
                has_empty[index_no] = wp_rem_check_field_type(thisObj, alert_messages, has_empty[index_no]);
            }
        }
        if (has_empty[index_no] == false) {
            thisObj.next(".chosen-container").removeClass("frontend-field-error");
            thisObj.next(".wp-rem-dev-req-field").next(".pbwp-box").removeClass("frontend-field-error");
            thisObj.removeClass("frontend-field-error");
            thisObj.closest(".jqte").removeClass("frontend-field-error");
        }
    });
    if (radio_fields.length > 0) {
        for (i = 0; i < radio_fields.length; i++) {
            var thisnewObj = radio_fields[i];
            var array_length = alert_messages.length;
            if (typeof thisnewObj == "undefined") {
                continue;
            }
            alert_messages[array_length] = wp_rem_insert_error_message(thisnewObj, alert_messages, "");
        }
    }
    if (checkbox_fields.length > 0) {
        for (i = 0; i < checkbox_fields.length; i++) {
            var thisnewObj = checkbox_fields[i];
            var array_length = alert_messages.length;
            alert_messages[array_length] = wp_rem_insert_error_message(thisnewObj, alert_messages, "");
        }
    }
    alert_messages = alert_messages.filter(onlyUnique);
    var error_messages = "Required Fields <br />";
    if (has_empty.length > 0 && jQuery.inArray(true, has_empty) != -1) {
        var array_length = alert_messages.length;
        for (i = 0; i < array_length; i++) {
            if (i > 0) {
                error_messages = error_messages + "<br>";
            }
            error_messages = error_messages + alert_messages[i];
        }
        var error_message = jQuery.growl.error({
            message: error_messages,
            duration: 1e4
        });
        return false;
    }
}

/*
 * Check if field exists and not empty
 */

function wp_rem_is_field(field_value) {
    "use strict";
    if (field_value != "undefined" && field_value != undefined && field_value != "") {
        return true;
    } else {
        return false;
    }
}

/*
 * Check if Provided data for field is valid
 */

function wp_rem_check_field_type(thisObj, alert_messages, has_empty) {
    "use strict";
    /*
     * Check for Email Field
     */
    
    if (thisObj.hasClass("wp-rem-email-field")) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        if (!pattern.test(thisObj.val())) {
            var array_length = alert_messages.length;
            alert_messages[array_length] = wp_rem_insert_error_message(thisObj, alert_messages, "is not valid Email!");
            has_empty = true;
        }
    }

    /*
     * Check for Number Field
     */

    if (thisObj.hasClass("wp-rem-number-field")) {
        "use strict";
        var pattern = /[0-9 -()+]+$/;
        if (!pattern.test(thisObj.val())) {
            var array_length = alert_messages.length;
            alert_messages[array_length] = wp_rem_insert_error_message(thisObj, alert_messages, "is not valid Number!");
            has_empty = true;
        }
    }

    /*
     * Check for URL Field
     */

    if (thisObj.hasClass("wp-rem-url-field")) {
        "use strict";
        var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
        if (!pattern.test(thisObj.val())) {
            var array_length = alert_messages.length;
            alert_messages[array_length] = wp_rem_insert_error_message(thisObj, alert_messages, "is not valid URL!");
            has_empty = true;
        }
    }

    /*
     * Check for Date Field
     */

    if (thisObj.hasClass("wp-rem-date-field")) {
        "use strict";
        var pattern = /^\d{2}.\d{2}.\d{4}$/;
        if (!pattern.test(thisObj.val())) {
            var array_length = alert_messages.length;
            alert_messages[array_length] = wp_rem_insert_error_message(thisObj, alert_messages, "is not valid Date!");
            has_empty = true;
        }
    }

    /*
     * Check for Range Field
     */

    if (thisObj.hasClass("wp-rem-range-field")) {
        "use strict";
        var min_val = thisObj.data("min");
        var max_val = thisObj.data("max");
        if (!(thisObj.val() >= min_val) || !(thisObj.val() <= max_val)) {
            var array_length = alert_messages.length;
            alert_messages[array_length] = wp_rem_insert_error_message(thisObj, alert_messages, "is not in Range! ( " + min_val + " - " + max_val + " )");
            has_empty = true;
        }
    }
    return has_empty;
}

/*
 * Making list of errors
 */

function wp_rem_insert_error_message(thisObj, alert_messages, error_msg) {
    "use strict";
    thisObj.addClass("frontend-field-error");
    if (thisObj.is("select")) {
        thisObj.next(".chosen-container").addClass("frontend-field-error");
        var field_label = thisObj.closest(".field-holder").children("label").html();
        if (wp_rem_is_field(field_label) == false) {
            var field_label = thisObj.closest(".wp-rem-dev-appended-cats").children().children().children("label").html();
        }
        if (wp_rem_is_field(field_label) == false) {
            var field_label = thisObj.find(":selected").text();
        }
    } else {
        var field_label = thisObj.closest(".field-holder").children("label").html();
        if (typeof field_label === "undefined") {
            var field_label = thisObj.attr("placeholder");
        }
    }
    if (thisObj.is(":hidden")) {
        thisObj.next(".wp-rem-dev-req-field").next(".pbwp-box").addClass("frontend-field-error");
    }
    if (thisObj.hasClass("wp_rem_editor")) {
        thisObj.closest(".jqte").addClass("frontend-field-error");
    }
    if (thisObj.hasClass("ad-wp-rem-editor")) {
        thisObj.closest(".jqte").addClass("frontend-field-error");
    }
    var res = "";
    if (typeof field_label !== "undefined") {
        res = field_label.replace("*", " ");
    } else {
        res = "Label / Placeholder is missing";
    }
    return "* " + res + error_msg;
}

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}
function validate(evt) {
    "use strict";
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault)
            theEvent.preventDefault();
    }
}

function checkName(el, id) {
    "use strict";
    var ar_ext = ['pdf', 'doc', 'rtf', 'docx'];
// - coursesweb.net
    // get the file name and split it to separe the extension
    var name = el.value;
    var ar_name = name.split('.');
    // for IE - separe dir paths (\) from name
    var ar_nm = ar_name[0].split('\\');
    for (var i = 0; i < ar_nm.length; i++)
        var nm = ar_nm[i];
    // check the file extension
    var re = 0;
    for (var i = 0; i < ar_ext.length; i++) {
        if (ar_ext[i] == ar_name[1]) {
            re = 1;
            break;
        }
    }
    if (re != 1) {
        jQuery('.status-msg-' + id + '').addClass("error-msg");
        el.value = '';
    } else {
        jQuery('.status-msg-' + id + '').removeClass("error-msg");
        // add the name in 'to'
        var html_txt = "<div id='user-selected-file-" + id + "'><div class='alert alert-dismissible user-resume' id='user-file-" + id + "'><div>" + nm + "<div class='gal-edit-opts close'><a href=\"javascript:wp_rem_del_media('user-file-" + id + "')\" class='delete'><span aria-hidden='true'><i class=\"icon-close2\"></i></span></a></div></div></div></div>";
        jQuery("#user-selected-file-" + id + "").html(html_txt);

    }
}

function wp_rem_del_media(id) {
    "use strict";
    jQuery('#' + id + '').hide();
    jQuery('#' + id).val('');
    jQuery('#' + id).next().show();
}

function wp_rem_enquiry_detail(enquiry_id, type) {
    "use strict";
    wp_rem_show_loader('.loader-holder');
    jQuery(this).addClass('active');
    jQuery.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: 'action=wp_rem_enquiry_detail&enquiry_id=' + enquiry_id + '&type=' + type,
        success: function (response) {
            wp_rem_hide_loader('.loader-holder');
            jQuery('.user-holder').html(response);
        }
    });
}

function wp_rem_arrange_viewing_detail(viewing_id, type) {

    "use strict";
    wp_rem_show_loader('.loader-holder');
    jQuery(this).addClass('active');
    jQuery.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: 'action=wp_rem_arrange_viewing_detail&viewing_id=' + viewing_id + '&type=' + type,
        success: function (response) {
            wp_rem_hide_loader('.loader-holder');
            jQuery('.user-holder').html(response);
        }
    });
}

function wp_rem_discussion_submit(admin_url, file_field) {
    "use strict";
    wp_rem_show_loader('.discussions-list-form-holder');
    var serializedValues = jQuery("#discussion-form").serialize();
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        dataType: 'json',
        data: serializedValues + '&action=wp_rem_discussion_submit',
        success: function (response) {
            wp_rem_show_response(response);
            if (response.empty == true) {
                jQuery('#comment_message').css('border', 'solid 1px red');
            } else if (response.empty == false) {
                jQuery('#comment_message').css('border', '');
            }
            if (response.type == 'success') {
                if (response.comments_count > 1) {
                    jQuery(".element-title h3").html(response.comments_number);
                    jQuery("#discussion-list").append(response.new_comment);
                } else {
                    jQuery(".order-discussions-holder").html('<div class="order-discussions"><div class="element-title"><h3>' + response.comments_number + '</h3></div><ul id="discussion-list" class="order-discussion-list">' + response.new_comment + '</ul></div>');
                }
                jQuery('#comment_message').val('');
            }
        }
    });
}

function wp_rem_update_enquiry_status(sel, enquiry_id, admin_url) {
    "use strict";
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        dataType: 'json',
        data: 'action=wp_rem_update_enquiry_status&enquiry_id=' + enquiry_id + '&enquiry_status=' + sel.value,
        success: function (response) {
            wp_rem_show_response(response);
        }
    });
}

jQuery(document).on('click', '#enquiry_read_status', function () {
    "use strict";
    if (jQuery(this).is(":checked")) {
        jQuery(this).val('1');
    } else {
        jQuery(this).val('0');
    }
    var enquiry_read_status = jQuery(this).val();
    var enquiry_id = jQuery('#enquiry_id').val();
    var user_status = jQuery('#user_status').val();
    jQuery.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: 'action=wp_rem_update_enquiry_read_status&enquiry_id=' + enquiry_id + '&enquiry_read_status=' + enquiry_read_status + '&user_status=' + user_status,
        dataType: 'json',
        success: function (response) {
            wp_rem_show_response(response);
            if (response.read_type == 'read') {
                var read_unread = jQuery('.enquiry-read-checkbox').data('read');
            } else {
                var read_unread = jQuery('.enquiry-read-checkbox').data('unread');
            }
            jQuery('.enquiry-read-checkbox label').attr('data-original-title', read_unread);


        }
    });
});

function wp_rem_update_viewing_status(sel, viewing_id, admin_url) {
    "use strict";
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        dataType: 'json',
        data: 'action=wp_rem_update_viewing_status&viewing_id=' + viewing_id + '&viewing_status=' + sel.value,
        success: function (response) {
            wp_rem_show_response(response);
        }
    });
}

jQuery(document).on('click', '#viewing_read_status', function () {
    "use strict";
    if (jQuery(this).is(":checked")) {
        jQuery(this).val('1');
    } else {
        jQuery(this).val('0');
    }
    var viewing_read_status = jQuery(this).val();
    var viewing_id = jQuery('#viewing_id').val();
    var user_status = jQuery('#viewing_user_status').val();
    jQuery.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: 'action=wp_rem_update_viewing_read_status&viewing_id=' + viewing_id + '&viewing_read_status=' + viewing_read_status + '&user_status=' + user_status,
        dataType: 'json',
        success: function (response) {
            wp_rem_show_response(response);
            if (response.read_type == 'read') {
                var read_unread = jQuery('.viewing-read-checkbox').data('read');
            } else {
                var read_unread = jQuery('.viewing-read-checkbox').data('unread');
            }
            jQuery('.viewing-read-checkbox label').attr('viewing-original-title', read_unread);
        }
    });
});

function wp_rem_closed_enquiry(enquiry_id) {
    "use strict";
    jQuery.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: 'action=wp_rem_closed_enquiry&enquiry_id=' + enquiry_id,
        dataType: 'json',
        success: function (response) {
            jQuery('.enquiry-status p').html('');
            jQuery('.enquiry-status p').html(response.msg);
            wp_rem_show_response(response);
        }
    });
}

function wp_rem_closed_arrange_viewing(viewing_id) {
    "use strict";
    jQuery.ajax({
        type: "POST",
        url: wp_rem_globals.ajax_url,
        data: 'action=wp_rem_closed_viewing&viewing_id=' + viewing_id,
        dataType: 'json',
        success: function (response) {
            jQuery('.viewing-status p').html('');
            jQuery('.viewing-status p').html(response.msg);
            wp_rem_show_response(response);
        }
    });
}
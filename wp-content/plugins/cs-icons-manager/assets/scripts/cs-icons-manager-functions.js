/**  jquery document.ready functions */
var $ = jQuery;
var ajaxRequest;

/*
 * Uploading Zip File
 */
jQuery(document).on("change", "#cs_icons_fonts_zip_rand", function () {
    var attachment_id   = jQuery(this).val();
    jQuery(".cs-icons-uploadMedia").append('<span class="cs-upload-spinner"><i class="icon-spinner8"></i></span>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: cs_icons_manager.ajax_url,
        data: 'attachment_id=' + attachment_id + '&action=cs_reading_zip',
        success: function (response) {
            jQuery(".cs-icons-msg").html('<div class="notice notice-'+ response.type +' is-dismissible"><p>'+ response.msg +'</p></div>');
            jQuery(".cs-icons-msg").slideDown();
            setTimeout(function() {
                jQuery(".cs-icons-msg").slideUp();
            }, 5000);
            location.reload();
            jQuery(".cs-icons-uploadMedia").find('.cs-upload-spinner').remove();
        }
    });
});

/*
 * Load Library Icons
 */
jQuery(document).on("change", ".cs-icon-library", function () {
    var icons_library   = jQuery(this).val();
    var thisParent  = jQuery(this).closest('.cs-icon-choser');
    var thisName    = jQuery(this).closest('.cs-icon-choser').data('name');
    var thisId    = jQuery(this).closest('.cs-icon-choser').data('id');
    var thisValue    = jQuery(this).closest('.cs-icon-choser').data('value');
    thisParent.find('.cs-library-icons-list').find('.icons-selector').find('.selector').append('<span class="icons-manager-loader"><i class="icon-spinner8"></i></span>');
    jQuery.ajax({
        type: 'POST',
        url: cs_icons_manager.ajax_url,
        data: 'icons_library=' + icons_library + '&name=' + thisName + '&id=' + thisId + '&value=' + thisValue + '&action=cs_library_icons_list',
        success: function (response) {
           thisParent.find('.cs-library-icons-list').html(response);
        }
    });
});

/*
 * Removing Group
 */
var html_popup = "<div id='confirmOverlay' style='display:block'> \
    <div id='confirmBox'><div id='confirmText'>Are you sure to do this?</div> \
    <div id='confirmButtons'><div class='button confirm-yes'>Delete</div>\
    <div class='button confirm-no'>Cancel</div><br class='clear'></div></div></div>";


jQuery(document).on("click", ".cs-group-remove", function () {
    var thisParent   = jQuery(this).closest('.cs-icons-manager-list');
    var group_name   = thisParent.data('id');
    jQuery(this).parent().append(html_popup);
    jQuery(document).on('click', '.confirm-yes', function (event) {
        jQuery(".confirm-yes").append('<i class="icon-spinner8"></i>');
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: cs_icons_manager.ajax_url,
            data: 'group_name=' + group_name + '&action=cs_remove_group',
            success: function (response) {
                jQuery(".cs-icons-msg").html('<div class="notice notice-'+ response.type +' is-dismissible"><p>'+ response.msg +'</p></div>');
                jQuery(".cs-icons-msg").slideDown();
                setTimeout(function() {
                    jQuery(".cs-icons-msg").slideUp();
                }, 5000);
                if( response.type == 'success' ){
                    jQuery("#confirmOverlay").remove();
                    thisParent.slideUp(400, function() {
                        thisParent.remove();
                    });
                }
            },
            error: function (response) {
                jQuery("#confirmOverlay").remove();
            } 
        });
    });
    jQuery(document).on('click', '.confirm-no', function (event) {
        jQuery("#confirmOverlay").remove();
    });
});



/*
 * Media
 */
jQuery(document).on("click", ".cs-icons-uploadMedia", function () {
    "use strict";
    var $ = jQuery;
    var id = "cs_icons_fonts_zip_rand";
    var custom_uploader = wp.media({
        title: 'Select File',
        button: {
            text: 'Add File'
        },
        multiple: false
    }).on('select', function () {
        var attachment = custom_uploader.state().get('selection').first().toJSON();
        jQuery('#' + id).val(attachment.id);
        jQuery('#' + id).change();
    }).open();

});

/*
 * Enable / Disable Group
 */
jQuery(document).on("change", ".cs-icons-enable-group", function () {
    var data_id = jQuery(this).data('id');
    var data_value = jQuery("#"+data_id).val();
    var group_name = jQuery(this).data('group');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: cs_icons_manager.ajax_url,
        data: 'group_name=' + group_name + '&status_value=' + data_value + '&action=cs_group_status',
        success: function (response) {
            jQuery(".cs-icons-msg").html('<div class="notice notice-'+ response.type +' is-dismissible"><p>'+ response.msg +'</p></div>');
            jQuery(".cs-icons-msg").slideDown();
            setTimeout(function() {
                 jQuery(".cs-icons-msg").slideUp();
            }, 5000);
        }
    });
});
/*
 * 
 * Homevillas Member Added Favourite function
 */
function wp_rem_member_favourite(thisObj, property_id, member_id, favourite, favourited, before_icon,after_icon, strings) {

    "use strict";
    var favourite_icon_class = jQuery(thisObj).find("i").attr('class');
    
    var loader_class = 'icon-spinner icon-spin';
    jQuery(thisObj).find("i").removeClass(favourite_icon_class).addClass(loader_class);
    var dataString = 'property_id=' + property_id + '&member_id=' + member_id + '&action=wp_rem_favourite_submit';
    jQuery.ajax({
        type: "POST",
        url: wp_rem_favourites.admin_url,
        data: dataString,
        dataType: "json",
        success: function (response) {
           
            if (response.status == true) {
                jQuery(thisObj).removeClass('favourite').addClass('favourite');
                jQuery(thisObj).html(after_icon + favourited);
                var msg_obj = {msg : strings.added, type : 'success'};
                
                wp_rem_show_response(msg_obj);
                if (response.property_count !== 'undefined' && response.property_count !== '') {
                    jQuery(thisObj).parent().find(".likes-count span").text(response.property_count);
                }
            } else {
                jQuery(thisObj).removeClass('favourite').addClass('favourite');
                jQuery(thisObj).html(before_icon + favourite);
                var msg_obj = {msg : strings.removed, type : 'success'};
                wp_rem_show_response(msg_obj);
                if (response.property_count !== 'undefined' && response.property_count !== '') {
                    jQuery(thisObj).parent().find(".likes-count span").text(response.property_count);
                }
            }
        }
    });

}

/*
 * 
 * Homevillas Member Removed Favourite function
 */
jQuery(document).on("click", ".delete-favourite", function () { 
    var thisObj = jQuery(this);
    var property_id = thisObj.data('id');
    var delete_icon_class = thisObj.find("i").attr('class');
    var loader_class = 'icon-spinner icon-spin';
    var dataString = 'property_id=' + property_id + '&action=wp_rem_removed_favourite';
    jQuery('#id_confrmdiv').show();
    jQuery('#id_truebtn').click(function () {
        thisObj.find('i').removeClass(delete_icon_class);
        thisObj.find('i').addClass(loader_class);
        jQuery.ajax({
            type: "POST",
            url: wp_rem_favourites.admin_url,
            data: dataString,
            dataType: "json",
            success: function (response) {
                thisObj.find('i').removeClass(loader_class).addClass(delete_icon_class);
                if (response.status == true) {

                    thisObj.closest('li').hide('slow', function () {
                        thisObj.closest('li').remove();
                    });
                    
                    var msg_obj = {msg : response.message, type : 'success'};
                    wp_rem_show_response(msg_obj);
                    if (response.property_count !== 'undefined' && response.property_count !== '') {
                        jQuery('.like-btn').find(".likes-count span").text(response.property_count);
                    }
                }
            }
        });

        jQuery('#id_confrmdiv').hide();
        return false;
    });
    jQuery('#id_falsebtn').click(function () {
        jQuery('#id_confrmdiv').hide();
        return false;
    });
    return false;
});
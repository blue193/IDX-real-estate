$rem = jQuery.noConflict();
function wp_rem_selected_google_font_att_field(admin_url, att_id, id) {
    "use strict";
    if (att_id != "") {
        $rem('#' + id).parent().next().remove(0);
        $rem('#' + id).parent().parent().append('<i style="font-size:20px;color:#ff6363;" class="icon-spinner icon-spin"></i>');
        $rem('#' + id).parent().hide(0);
        var dataString = 'index=' + att_id + '&id=' + id + '&action=wp_rem_selected_google_font_att_field';
        $rem.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                $rem('#' + id).parent().show(0);
                $rem('#' + id).parent().html(response);
                $rem('#' + id).parent().next().remove(0);

            }
        });
    }
}
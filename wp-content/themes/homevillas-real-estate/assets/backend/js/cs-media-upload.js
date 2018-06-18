jQuery(document).ready(function() {
    "use strict";
	var ww = jQuery('#post_id_reference').text();
	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor_clone = function(html){
           
		var imgurl = jQuery('a','<p>'+html+'</p>').attr('href');
		jQuery('#'+formfield).val(imgurl);
		tb_remove();
	}
	jQuery('input.uploadfile').click(function() {
            
		window.send_to_editor=window.send_to_editor_clone;
		formfield = jQuery(this).attr('name');
		tb_show('', 'media-upload.php?post_id=' + ww + '&type=image&TB_iframe=true');
		return false;
	});
});
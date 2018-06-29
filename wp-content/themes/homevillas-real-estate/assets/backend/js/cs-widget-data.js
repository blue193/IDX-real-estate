!function ($) {
	"use strict";

	/**
	 * Display the notification div, populate a message, and set a CSS class
	 * @param String message Message to display
	 * @param String className CSS class of error or success
	 */
	var show_notification = function(message, className){
		var notification = $('div#notifier').empty().removeClass('error updated');
		notification.html('<p>' + message + '</p>');
		notification.addClass(className);

		notification.fadeIn('slow');
		jQuery('body,html').animate({
			scrollTop: 0
		}, 800);
	},
	wrapper = $('<div/>').css({
		height:0,
		width:0,
		'overflow':'hidden'
	});
	$(function () {
		var fileInput = $('#widget-upload-file').wrap(wrapper),
		widgetCheckboxes = $('.widget-data .widget-checkbox'),
		widgetSelectionError = $('.widget-data p.widget-selection-error');

		/**
		 * Handle click events for widget-data to select all checkboxes on click, to uncheck all
		 * checkboxes on click, and to activate the file upload when the file upload button is clicked.
		 * @param Object e Event object
		 */
		$(document).on('click', '.select-all, .unselect-all, .upload-button', function(e){
			e.preventDefault();
			if( $(this).hasClass('select-all') ){
				widgetCheckboxes.not(":checked").each(function(){
					$(this).attr( 'checked', true );
				});
			} else if( $(this).hasClass('unselect-all') ){
				widgetCheckboxes.filter(":checked").each(function(){
					$(this).attr( 'checked', false );
				});
			} else if( $(this).hasClass('upload-button') ){
				fileInput.click();
			}
		});

		/**
		 * Handle the export form submission
		 * @param Object e Event object
		 */
		$('form#widget-export-settings').submit(function(e) {
			// return and show notification if no widgets are selected
			if (widgetCheckboxes.filter(':checked').length === 0) {
				e.preventDefault();
				show_notification('Please select a widget to continue.', 'error');
				return;
			}
			var message = 'All of the requested widgets have been exported.';
			$('form#widget-export-settings').fadeOut('slow');
			window.setTimeout(function () {
				window.location.replace(widgets_url);
			}, 4000);
			show_notification(message, 'updated');
		});

		/***
		 * Handle imports
		 * @param Object e Event object
		 */
		$('form#import-widget-data').submit(function(e){
			e.preventDefault();

			if (widgetCheckboxes.filter(':checked').length === 0) {
				widgetSelectionError.fadeIn('slow').delay(2000).fadeOut('slow');
				return false;
			}
			var message, newClass;
			$.post( ajaxurl, $("#import-widget-data").serialize(), function(r){
				var res = wpAjax.parseAjaxResponse(r, 'notifier');
				if( ! res )
					return;

				$('.import-wrapper').fadeOut('slow');
				show_notification('All widgets with registered sidebars have been imported successfully.', 'updated');
			});
		});

		/**
		 *
		 */
		fileInput.change(function(){
			var outputText = $('#upload-widget-data .file-name'),
			sub = $(this).val().lastIndexOf('\\') + 1,
			filename = $(this).val().substring(sub);

			outputText.val(filename);
		});

	});
}(window.jQuery);

jQuery('.import-widget-settings').on('click', '#widget-import-submit', function(){
    "use strict";
	
	var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
	var file_name = jQuery('#cs-widget-upload-file').val();
	
	if( file_name != '' ) {
		
		jQuery("#cs-import-widget-loader").html('<i class="icon-spinner8 icon-spin"></i>');
		
		var dataString = 'file_name='+file_name+'&action=import_settings_page';
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:dataString, 
			success:function(response){
				
				jQuery("#cs-import-widget-loader").html('');
				jQuery("#cs-import-widgets-con").html(response);
			}
		});
	}
});

jQuery(document).on('click', '#cs-wid-backup-restore', function(){
    "use strict";
	
	var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
	var file_path = jQuery(this).data('path');
	var file_name = jQuery('#cs-wid-backup-change').val();
	
	if( file_name != '' ) {
		
		jQuery("#cs-import-widgets-con").html('');
		
		jQuery("#cs-import-widget-loader").html('<i class="icon-spinner8 icon-spin"></i>');
		
		var dataString = 'file_name='+file_path+file_name+'&action=import_settings_page';
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:dataString, 
			success:function(response){
				
				jQuery("#cs-import-widget-loader").html('');
				jQuery("#cs-import-widgets-con").html(response);
			}
		});
	}
});

jQuery(document).on('click', '#cs-import-wgts-btn', function(){
    "use strict";
	
	var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
	
	jQuery("#cs-import-widget-loader").html('<i class="icon-spinner8 icon-spin"></i>');
	
	var dataString = jQuery('#cs-import-widget-form input').serialize()+'&action=import_widget_data';
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		data:dataString, 
		success:function(response){
			
			jQuery("#cs-import-widget-loader").html('');
			
			jQuery(".import-widget-settings .cs-import-wrapper").html('Import Done');
			
		}
	});
	setTimeout(function () {
		jQuery("#cs-import-widget-loader").html('');
		jQuery(".import-widget-settings .cs-import-wrapper").html('Import Done');
	}, 4000);
	
});

jQuery(document).on('click', '#cs-export-wgts-btn', function(){
    "use strict";
	
	var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
	
	jQuery("#cs-export-widget-loader").html('<i class="icon-spinner8 icon-spin"></i>');
	
	var dataString = jQuery('#cs-widget-export-form input').serialize()+'&action=export_widget_settings';
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		data:dataString, 
		success:function(response){
			
			jQuery("#cs-export-widget-loader").html('');
			
			jQuery(".cs-export-widget-settings .cs-export-wrapper").html(response);
			
			window.location.reload(true);
		}
	});
});

jQuery(document).on('click', '#cs-wid-backup-delte', function(){
	"use strict";
	var var_confirm = confirm("This action will delete your selected Backup File. Are you want to continue?");
	if ( var_confirm == true ){
		jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);
		
		var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
		var file_name = jQuery(this).data('file');
		
		var dataString = 'file_name='+file_name+'&action=wp_rem_cs_widget_file_delete';
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data:dataString, 
			success:function(response){
				
				jQuery(".loading_div").hide();
				jQuery(".form-msg .innermsg").html(response);
				jQuery(".form-msg").show();
				jQuery(".outerwrapp-layer").delay(2000).fadeOut(100);
				window.location.reload(true);
				slideout();
			}
		});
	}
});

jQuery(document).on('click', '.imp-select-all, .imp-unselect-all', function(){
    "use strict";
	var impWidgetCheckboxes = jQuery('#cs-import-widget-form .widget-checkbox');
	if( jQuery(this).hasClass('imp-select-all') ){
		impWidgetCheckboxes.not(":checked").each(function(){
			jQuery(this).attr( 'checked', true );
		});
	} else if( jQuery(this).hasClass('imp-unselect-all') ){
		impWidgetCheckboxes.filter(":checked").each(function(){
			jQuery(this).attr( 'checked', false );
		});
	}
});
		
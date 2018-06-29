	jQuery(document).ready(function () {
		$('.masnory').children('.row').first().each(function(){
			$(this).csGallery();
		});
	});	
	$.fn.csGallery = function() {
		var $this = $(this);
		$this.freetile({
			animate: true,
			elementDelay: 2,
		});
	}
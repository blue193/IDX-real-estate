	$(window).load(function() {
		$('.rem-gallery').children('ul').first().each(function(){
			$(this).csGallery();
		});
	});	
	$.fn.csGallery = function() {
		var $this = $(this);
		$this.freetile({
			animate: true,
			elementDelay: 5,
		});
	}
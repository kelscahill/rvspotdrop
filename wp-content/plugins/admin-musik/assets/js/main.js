(function ($) {
  	"use strict";
  	$(document).on('click', '.box > h3, .box > h4, .toggle', function(){
		$(this).toggleClass('active');
		$(this).next( ".hide" ).toggleClass('show');
	});

	jQuery(document).ready(function($){
	    // menu sortable
		$('.admin-menus').sortable({
			items: '.admin-menu-item',
			cursor: 'move',
			containment: 'parent',
			placeholder: 'box box-placeholder'
		});

		// color
		$('.color-field').wpColorPicker();

		// uploader
		$('.upload-btn').click(function(e) {
	        e.preventDefault();
	        var that = $(this);
	        var image = wp.media({ 
	            title: 'Upload Image',
	            multiple: false
	        }).open()
	        .on('select', function(e){
	            var uploaded_image = image.state().get('selection').first();
	            var image_url = uploaded_image.toJSON().url;
	            that.prev().val(image_url);
	        });
	    });

	});

})(jQuery);

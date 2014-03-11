	// magnific Popup a jquery Lightbox plugin
	$('.single .images .slides').magnificPopup({
		delegate: 'li:not(".clone") a',
		type: 'image',
		gallery: {
			enabled: true
		}  
	});
.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


Imageslider in single view
==========================


Use Slider for images in single view
------------------------------------

I prefer to use flexslider2 with jquery to build a slideshow with the images in single view. But you can use another plugin if you want.

Go to http://flexslider.woothemes.com/ and download the plugin. Include this and the jquery library. Use the following little javascript code to run the slider.
CSS and HTML is prepared for this in default template.

	:code:
	`$('.operations.single .images').flexslider({
		slideshow:true,
		controlNav:false,
		directionNav:true,
		slideshowSpeed: 3000,
		animationSpeed: 500,
		direction: 'vertical',
		animation: 'slide',
		pauseOnHover: true,
		smoothHeight: false,
		multipleKeyboard: true
	});`_


Use lightbox for big image in single view
-----------------------------------------
 

I prefer to use Magnific Popup, download here: http://dimsemenov.com/plugins/magnific-popup/, for a responsive jquery lightbox plugin.

Use the following javascript code to run the lightbox in single view:


	:code:
	`// magnific Popup Lightbox
	$('.single .images .slides').magnificPopup({
		delegate: 'li:not(".clone") a',
		type: 'image',
		gallery: {
			enabled: true
		}  
	});`_
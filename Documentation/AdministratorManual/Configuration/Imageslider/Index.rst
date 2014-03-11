.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt

.. _sliderSection
.. _options: http://www.woothemes.com/flexslider/
.. _lightbox-options: http://dimsemenov.com/plugins/magnific-popup/


Imageslider and Lightbox
========================



Use Slider for images in single view
------------------------------------

I prefer to use `flexslider2 <http://www.woothemes.com/flexslider/>`_ with jquery to build a slideshow with the images in single view. But you can use another plugin if you want. All CSS, HTML and JS is prepared for use the slide function in single view of operation.

To your own `options`_ you can edit the path to .js file in constants, copy the default JS to your new file and add `options`_ you want.

Following javascript runs the slider: 



::

			$('.operations.single .images').flexslider({
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
			});


Use lightbox for big image in single view
-----------------------------------------
 

I prefer to use Magnific Popup (also a jquery plugin), look here: http://dimsemenov.com/plugins/magnific-popup/, for examples and options to use this responsive jquery lightbox plugin. All CSS, HTML and JS is prepared for use the slide function in single view of operation.

For your individual options here also go to constants and change path to your own file and add your own `lightbox-options` in this file.

Following javascript code runs the lightbox:



::

			$('.single .images .slides').magnificPopup({
				delegate: 'li:not(".clone") a',
				type: 'image',
				gallery: {
					enabled: true
				}  
			});
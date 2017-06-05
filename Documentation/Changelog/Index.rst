.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _changelog:

Changelog
=========



.. t3-field-list-table::
 :header-rows: 1

 - :Version:
		Version:
   :Changes:
		Changes:

 - :Version:
		2.0.0
  :Changes:
		TYPO3 8.7 compatibility, clean up code. TYPO3 8.7 is now minimum requirement
 - :Version:
		1.3.7
  :Changes:
		No changes, update extension manual.
 - :Version:
		1.3.6
  :Changes:
		Some Bugfixing. #72535 Fix error with pagination in TYPO3 7.6.
 - :Version:
		1.3.5
  :Changes:
		Bugfix and update extension manual.
		New setting in plugin for template layout, adjustable by page ts config.
 - :Version:
		1.3.4
   :Changes:
		Bugfixing release and compatibility for TYPO3 7.
 - :Version:
		1.3.3
   :Changes:
		Rename constants "listImgWidthResources" to "listImgWidthResource", same for height.
		Split actions for vehicles and resources, separate list and show action. Please change your plugin elements.
 - :Version:
		1.3.2
   :Changes:
		Add new icons from "`The Noun Project <http://thenounproject.com>`_" for data in backend.
 - :Version:
		1.3.1
   :Changes:
		Some Bugfixes. Also in Documentation and translating.
		#60667 Fixed bug when using pagebrowser in filter results in TYPO3 6.2
 - :Version:
		1.3.0
   :Changes:
		Database tables for resources renamed and other important Changes! Please read manual!
		Use update script in ext-manager to rename database tables
		Add setting in constants to use your own api key for google maps.
		More infos in :ref:`Manual <users-manual>`.
		#60380 Fixed bug with missing injectPropertyMappingConfiguration in Controller, TYPO3 6.2
		#58376 Add list view for resources and vehicles. When using your own templates please read :ref:`Manual <users-manual>`.
		Bugfixing: the property of images from operation types are now file reference
 - :Version:
		1.2.0
   :Changes:
		Add new filter for type. When using your own templates please check Partials/List/Form.html, Templates/Operation/List.html and Templates/Operation/Search.html to use the new filter. More infos here in :ref:`Manual <users-manual>`.
 - :Version:
		1.1.0
   :Changes:
		Change name of ts-constant and ts-setup from "overrideCenterLangList" to "overrideCenterLongList". Please check your ts after update.

		#57792 correct counted result for list view with map

		#57967 Add note in documentation because of missing list view of vehicles and resources

		#58037 add settings to override centering and zoom for map list view

		#58036 add link wizard to assistance link field and viewhelper for typolink rendering

		#57969 add RTE for description field in vehicles and resources

		#57968 spelling error in german translation

		#57966 change title for map list view

		#57965 every time "no result" at bottom of list view

 - :Version:
		1.0.7
   :Changes:
		Add new field for teaser. Please go to installTool and compare database to add the new field. Extend documentation because of new map views. Set status to beta.
 - :Version:
		1.0.6
   :Changes:
		Add 2 viewhelpers, to build a map for list and single view, add settings for map options
 - :Version:
		1.0.4
   :Changes:
		Bugfixes uid in template partial, #56675
 - :Version:
		1.0.3
   :Changes:
		Add ReST documentation
 - :Version:
		1.0.2
   :Changes:
		Javascript and CSS for using lightbox and slider without any own configuration. Many values are now customizable in constants.
 - :Version:
		1.0.1

   :Changes:
		Bugfixing in flexform translations

 - :Version:
		1.0.0
   :Changes:
		Initial upload

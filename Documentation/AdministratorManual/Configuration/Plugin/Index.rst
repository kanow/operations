.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt

.. _pluginSection

Plugin
------

The most important configuration settings can be done through the settings of a plugin.

Because of using Extbase every setting can also be done by using typoscript but remember that the settings of the plugin always override the ones from typoscript.


Tab "Options"
""""""""""""""



.. t3-field-list-table::
 :header-rows: 1

 - :Property:
		Property:		
   :View:
		View:
   :Description:
		Description:
   :Key:
		Key:


 - :Property:
		What to display
   :View:
		All
   :Description:
		Selection of view:

		- Operations: List and single single view of operations
		- Vehciles: Shows the single view of used vehicle
		- Resources: Shows the single view of used resource

   :Key:

 - :Property:
		Storage folder
   :View:
		All
   :Description:
		Sysfolder where are the data sets
   :Key:
		persistence.storagePid
 - :Property:
		Items per page
   :View:
		Operations
   :Description:
		How many items will showing in list view. When pagination is hide is this the limit for the complete result.
   :Key:
		settings.itemsPerPage
 - :Property:
		Max chars of teaser text in list view
   :View:
		Operations
   :Description:
		Maximum length of teaser Text in list view.
   :Key:
		settings.cropTeaser
 - :Property:
		Hide pagination
   :View:
		Operations
   :Description:
		Hide the pagination and show the whole in one list. Default Limit for whole list is 200. 
   :Key:
		settings.hidePagination
 - :Property:
		Hide filter for result
   :View:
		Operations
   :Description:
		Hide the form to filter the list by years (more selection can be added in future)
   :Key:
		settings.hideFilter
 - :Property:
		Show list of operations on a map
   :View:
		Operations
   :Description:
		Show the listed result in frontend on a google map.
   :Key:
		settings.showMap


Tab "Image options"
""""""""""""""



.. t3-field-list-table::
 :header-rows: 1

 - :Property:
					Property:
					
   :View:
	 				View:
					
   :Description:
					Description:

   :Key:
					Key:

		
 - :Property:
					Thumbnail in list view

   :View:
					Operations

   :Description:
					Show the first image of item as thumbnail in list

   :Key:
					settings.showImgInList

					
					
 - :Property:
					Image dimension in list/single view

   :View:
					All

   :Description:
					Set image dimensions for list and single view if you like.

   :Key:
					settings.listImgWidth
					settings.listImgHeight
					settings.singleImgWidth
					settings.singleImgHeight

 
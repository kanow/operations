.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt

.. _referenceSection

Reference
---------


Typoscript Setup
================

Here you find the most important settings in typoscript. Please note that the recommended way to editing is in constants.
For all possibly settings take a look at Classes/Configuration/TypoScript/setup.txt in extension folder.


General settings
================

**plugin.tx_operations.settings**


.. container:: ts-properties

	==================================== ====================================== ============== ===============
	Property                             Title                                  Sheet          Type
	==================================== ====================================== ============== ===============
	templateRootPath_                        Template RootPath                  General         string
	==================================== ====================================== ============== ===============

.. _tsTemplateRootPath:

templateRootPath
""""""""""""""""
.. container:: table-row

   Property
         templateRootPath
   Data type
         string
   Default
         EXT:operations/Resources/Private/Templates/
   Description
         Default path to template files





 - :Property:
		partialRootPath
   :Type:
		string
   :Description:
		Default path to partial files
   :Default:
		EXT:operations/Resources/Private/Partials/
 - :Property:
		layoutRootPath
   :Type:
	 	string
   :Description:
		Default path to layout files
   :Default:
	 	EXT:operations/Resources/Private/Layouts/
 - :Property:
		operationPid
   :Type:
	 	integer
   :Description:
		Set page with operation list and single view here
   :Default:
	 
 - :Property:
		vehiclePid
   :Type:
		integer
   :Description:
		Set page with vehicle single view here
   :Default:
		
 - :Property:
		resourcePid
   :Type:
		integer
   :Description:
		Set page with resource single view here
   :Default:
 - :Property:
		overrideFlexformSettingsIfEmpty
   :Type:
		string/comma separated list
   :Description:
		When using typoscript settings for this fields, they are not overwritten with empty flexform fields.
   :Default:
		itemsPerPage,showImgInList,listImgWidth,listImgHeight,singleImgWidth,singleImgHeight,cropTeaser


Settings for list view
""""""""""""""""""""""

**plugin.tx_operations.settings**

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
		Property:	
   :Type:
	 	Data type:
   :Description:
		Description:
   :Default:
		Default:


 - :Property:
		itemsPerPage
   :Type:
	 	integer
   :Description:
		Items per page with pagination
   :Default:
		  10
 - :Property:
		limit
   :Type:
	 	integer
   :Description:
		Limit the whole result
   :Default:
		200
 - :Property:
		hidePagination
   :Type:
		boolean
   :Description:
		Hide the pagination and show the whole result in a list
   :Default:
		0
 - :Property:
		hideFilter
   :Type:
		boolean
   :Description:
		Hide the form for filtering the result
   :Default:
		0
 - :Property:
		showImgInList
   :Type:
		boolean
   :Description:
		Show thumbnail image in list view
   :Default:
		  1
 - :Property:
		listImgWidth
   :Type:
		integer/string
   :Description:
		Image width in list view (add "c" for cropping the image)
   :Default:
		100c
 - :Property:
		listImgHeight
   :Type:
		integer/string
   :Description:
		Image height in list view (add "c" for cropping the image)
   :Default:
					65
					
					
Settings for single view
""""""""""""""""""""""""

**plugin.tx_operations.settings**

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
		Property:
   :Type:
		Data type:
   :Description:
		Description:
   :Default:
		Default:


 - :Property:
		singleImgWidth
   :Type:
		integer/string
   :Description:
		Image width in single view (add "c" for cropping the image)
   :Default:
		225c
 - :Property:
		singleImgHeight
   :Type:
		integer/string
   :Description:
		Image height in single view (add "c" for cropping the image)
   :Default:
		180	


Settings for maps
"""""""""""""""""

**plugin.tx_operations.settings.map**

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
		Property:
   :Type:
		Data type:
   :Description:
		Description:
   :Default:
		Default:


 - :Property:
		apikey
   :Type:
		string
   :Description:
		Use your own api key when you need it
   :Default:
		
 - :Property:
		defaultZoomSingle
   :Type:
		integer
   :Description:
		Default zoom in single view using when no zoom in item is set
   :Default:
		15
 - :Property:
		overrideCenterLatList
   :Type:
		integer/string
   :Description:
		Override the automatic centering position latitude for map in list view.
   :Default:
	 
 - :Property:
		overrideCenterLongList
   :Type:
		integer/string
   :Description:
		Override the automatic centering position longitude for map in list view. 
   :Default:
	 
 - :Property:
		overrideZoomList
   :Type:
		integer
   :Description:
		Override the automatic zoom for map in list view. 
   :Default:
	 
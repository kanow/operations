.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt

.. _referenceSection

Reference
---------


Typoscript Setup
^^^^^^^^^^^^^^^^


plugin.tx_operations.settings


General settings
""""""""""""""""


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
					templateRootPath
					
   :Type:
	 				string
					
   :Description:
					Default path to template files

   :Default:
				  EXT:operations/Resources/Private/Templates/
					

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



Settings for list view
""""""""""""""""


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
""""""""""""""""


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
				  
         
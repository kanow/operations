.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _plugin-configuration:

====================
Plugin configuration
====================

The most important configuration settings can be done in the content element plugin.

Because of using Extbase every setting can also be done by using typoscript but remember that the settings of the plugin always override the settings from typoscript.


Tab "Options"
"""""""""""""



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
        `Selection of view:`

    - Operations: List and single view of operations
    - Vehciles: List and single view of vehicles
    - Resources: List and single view of resources
   :Key:
 - :Property:
		Category Mode
   :View:
		Operations
   :Description:
		Set category mode for selected categories.
   :Key:
		settings.categoryConjunction
 - :Property:
		Categories
   :View:
		Operations
   :Description:
		Categories can be select to constrain the result.
   :Key:
		settings.category
 - :Property:
		Items per page
   :View:
		Operations
   :Description:
		How many items will showing in list view. When pagination is hide is this the limit for the complete result.
   :Key:
		settings.itemsPerPage
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
 - :Property:
		Record Storage Page
   :View:
		All
   :Description:
		Sysfolder where are the data sets in
   :Key:
		persistence.storagePid


Tab "Media options"
"""""""""""""""""""



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
        Show the first media of item as thumbnail in list
   :Key:
        settings.showMediaInList

 - :Property:
        Media dimension in list/single view
   :View:
        All
   :Description:
        Set media dimensions for list and single view if you like.
   :Key:
        settings.listMediaWidth
        settings.listMediaHeight
        settings.singleMediaWidth
        settings.singleMediaHeight


Tab "Template Options"
""""""""""""""""""""""

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
        Template layout selector
   :View:
        All
   :Description:
        Set items in Page TS-Config before using
        ::
        tx_operations.templateLayouts {
            key = value
        }
   :Key:
        settings.templateLayout
 - :Property:
		Max chars of teaser text in list view
   :View:
		Operations
   :Description:
		Maximum length of teaser text in list view.
   :Key:
		settings.cropTeaser

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
Those setting can also be done by using TypoScript but settings in the plugin always override the settings
in TypoScript. With that is possible to set default settings in TypoScript and override it
in a plugin if necessary.


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
		Show
   :View:
		All
   :Description:
      Choose list or single view for operations, vehicles or resources.
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
		Max result items
   :View:
		All
   :Description:
		Limit the result for the list.
   :Key:
		settings.limit

 - :Property:
		Items per page
   :View:
		Operations
   :Description:
		How many items per page are showing with activated pagination.
   :Key:
		settings.itemsPerPage

 - :Property:
		Hide pagination
   :View:
		Operations
   :Description:
		Hide the pagination and show the result in one list. Default Limit for whole list is 200.
   :Key:
		settings.hidePagination

 - :Property:
		Hide filter
   :View:
		Operations
   :Description:
		Hide the form to filter the list
   :Key:
		settings.hideFilter

 - :Property:
		Show list of operations on a map
   :View:
		Operations
   :Description:
		Show the result on a map.
   :Key:
		settings.showMap

 - :Property:
		Record Storage Page
   :View:
		All
   :Description:
		Sysfolder for operations data.
   :Key:
		persistence.storagePid

 - :Property:
		Recursive
   :View:
		All
   :Description:
		Recursive setting for the sysfolder.
   :Key:
		persistence.recursive


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
        All
   :Description:
        Show the first media of item as thumbnail in list
   :Key:
        settings.showMediaInList

 - :Property:
        Media dimension in list/single view
   :View:
        All
   :Description:
        Set media dimensions for list and single view.
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
        Select Template Layout
   :View:
        All
   :Description:
      With this is possible to use other layout variants in Fluid templates.
      Set items in Page TS-Config before using
      example::

         tx_operations.templateLayouts {
             key = value
         }

   :Key:
        settings.templateLayout

 - :Property:
		Max chars of teaser text in list view
   :View:
		All
   :Description:
		Maximum length of teaser text in list view. Text will be cropped automatically.
   :Key:
		settings.cropTeaser

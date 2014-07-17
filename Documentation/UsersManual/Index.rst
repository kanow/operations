.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _users-manual:
.. _forge: http://forge.typo3.org/projects/extension-operations


Users manual
============

Installing the Extension
^^^^^^^^^^^^^^^^^^^^^^^^

Look here: :ref:`Install <install>` for install the extension and create 4 pages for 

- list and single view for operations (one page)
- list and single view for vehicles (one page)
- list and single view for resources (one page)
- list all locations on a google map (one page)

After this create sysfolder for data sets of vehicles, resources, assistance, type and operation itself.
Set the pids of pages for vehicle, resource and operation view in typoscript constants.
Look at the settings in plugin flexform fields or use typoscript constants to fit the settings.

Now you can add your data for types, vehicles, resources and assistance to use this relations in operation reports.

Note: You must save the plugin in backend once after choosing the operations plugin! After the first saving all settings are shown!


Use your own templates
^^^^^^^^^^^^^^^^^^^^^^

Please copy these three folders completely in your fileadmin folder:

- Resources/Private/Layouts
- Resources/Private/Templates
- Resources/Private/Partials

Then change the path in constants to your own. Now you can edit the template files if you want.


Use the map view
^^^^^^^^^^^^^^^^


In single view the google map is automatically shown, when coordinates are specify in operation records. The zoom for this map comes from default setting or from record when it was specify in it.

For showing the map in list view please activate the checkbox in plugin flexform. To override the automatic centering of the map in list view, you can use the settings in constants. Please note that the **override only works when you set all three values: latitude, longitude and zoom!**
Please check that you have the right constant in ts. I had changed "overrideCenterLangList" to the correct acronym "overrideCenterLongList" in Version 1.1.0.

The content in info window of google map you can change in fluid template in partial of operations. 

Since version 1.3.0 is it possible to use your own api key for google maps. Set this in constants when you need it.



Update from version 1.2.0 - Important!
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

I changed the identifier of the model "Resources" to correct singular "Resource". It was needed to beware problems in future.
Not correctly named objects in singular and plural are possible errors even more if the extension will be expanded.
I hope that makes the extension more stable in future.

**It's strongly recommended to make a backup of your database tables before you do the next things!!!**

Following database tables are renamed:
""""""""""""""""""""""""""""""""""""""

- tx_operations_domain_model_resources
- tx_operations_operation_resources_mm

Please use **update script** in extensionmanager or rename the tables manually with following sql commands:

RENAME TABLE tx_operations_domain_model_resources TO tx_operations_domain_model_resource;

and

RENAME TABLE tx_operations_operation_resources_mm TO tx_operations_operation_resource_mm;


Don't use compare in Install Tool. The Install-Tool will only make new database tables.
You did it anyway? Ok, no problem. Now you have to copy all entrys from the old tables to the new tables. Important: all field values must be the same! Especially th uid's!
Don't delete the old tables before you copy the entrys!

Now clear all caches.


New actions were added to the switchable controller actions in plugin flexform
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Two new action one for the list view of vehicles and one for the list view of resources. You have to change and save the plugin once in all content elements where they used.


Clear all cache again.
When you use your own template files you have to change some arguments in it. Compare with the original template files in Resources folder. The following Templates needs your attention:

- Resources/Private/Templates/Operation/List.html
- Resources/Private/Templates/Resource/List.html
- Resources/Private/Templates/Resource/Show.html


**Please check the paths to template files of resources in your typscript and the path to partials of resources. The "s" at the end of names must be removed.**


You have problems with this update? You find help on: `forge.typo3.org <http://forge.typo3.org/projects/extension-operations>`_.





Update from version 1.1.0
^^^^^^^^^^^^^^^^^^^^^^^^^

Following Templates are changed in version 1.2.0. Arguments and markup for new filter (type) were added. Please change your own templates to use the new filter!


Partials/List/Form.html
"""""""""""""""""""""""
- The translate-key for the prependOptionLabel were changed.
- please add the new <f:form.select> tag where you want.


Templates/Operation/List.html and Templates/Operation/Search.html
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
- Add the new argument in line 23: <f:render partial="List/Form" arguments="{demand:demand,begin:begin,**types:types**}" />


If i forgot anything (i hope i did not ;-)) feel free to write an e-mail or open an issue on `forge`.



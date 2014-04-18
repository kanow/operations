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
- single view for vehicles (one page)
- single view for resources (one page)
- locations on a google map (one page)

After this create sysfolder for data sets of vehicles, resources, assistance, type and operation itself.
Set the pids of pages for vehicle, resource and operation view in typoscript constants.
Look at the settings in plugin flexform fields or use typoscript constants to fit the settings.

Now you can add your data for types, vehicles, resources and assistance to use this relations in operation reports.

Note: You must save the plugin in backend once after choosing the operations plugin! After the first saving all settings are shown!


Use the map view
^^^^^^^^^^^^^^^^


In single view the google map is automatically shown, when coordinates are specify in operation records. The zoom for this map comes from default setting or from record when it was specify in it.

For showing the map in list view please activate the checkbox in plugin flexform. Zoom and centering position of the map are automatically adjusted. Settings for override this feature are already prepared but without any effect this time.

The content in info window of google map you can change in fluid template or partial of operations. Please copy these three folders completely in your fileadmin folder:

- Resources/Private/Layouts
- Resources/Private/Templates
- Resources/Private/Partials

Then change the path in constants to your own. Now you can edit the template files as whatever you want.

To override the automatic centering of map in list view, you can use the settings in constants. Please note that the override only works when you set all three values: latitude, longitude and zoom!
Please check that you have the right constant in ts. I had changed this "overrideCenterLangList" to the correct acronym "overrideCenterLongList" in Version 1.1.0.




If i forgot anything (i hope i did not ;-)) feel free to write an e-mail or open an issue on `forge`.



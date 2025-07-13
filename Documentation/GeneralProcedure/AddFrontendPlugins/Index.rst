.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _addfrontendplugins:

====================
Add content elements
====================

Ok, you are almost ready with the configuration and preparing data in backend.
The last step before you see the results in frontend is creating the different Content Elements.

.. note:

   In older TYPO3 version there were known as plugins with differents views.
   Now one Content Element for each view are used.

`operations` comes with some different content element types.

For "Operations", "Resources" and Vehicles existing list and single view content elements. They do exactly what they say.
They showing you list and single views either from operations, resources or vehicles.

The "Operation Statistics view" content element will show you the statistics of operations in the last years, grouped by
year and type.

Ok, let's go.

.. rst-class:: bignums

1. Select the :guilabel:`"Web" > "Page"` module on the left and select the page in page tree
   where you want to have the plugin and create a new content element.

   .. image:: /Images/Backend/create-content.png
      :alt: The button to create new content elements
      :class: with-shadow

2. Switch to tha tab "Operations" in open modal box to see all entries. Choose your type.

   .. image:: /Images/Backend/AddNewContent.png
      :alt: Create new content elements
      :class: with-shadow

3. Switch to tha tab "Plugin" in the Content Element and configure needed settings for the selected type.

   .. image:: /Images/Backend/SwitchToPlugin.png
      :alt: Field for Switchable Controller Actions
      :class: with-shadow

   |

Repeat these steps to create all needed content types for the frontend. At least a single view for the operations.

.. tip::

   Use default settings in TypoScript and just define settings in Plugins to overwrite the settings from TypoScript.

.. tip::

   Use TS-Config to define different `templateLayouts`,
   for setting in the "Template Options".


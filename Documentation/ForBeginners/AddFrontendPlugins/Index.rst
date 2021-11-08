.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _addfrontendplugins:

====================
Add frontend plugins
====================

Ok, your almost ready with the configuration and preparing data in backend.
The last step before you see the results in frontend is creating the frontend plugins.

`operations` comes with two frontend plugins. One is called "Operations" and the other is "Operations Statistics".
That is what you see in the field "Selected Plugin".

The "Operations" plugin will show you the list and single views for operations, resources or vehicles in frontend.
The single different views are controlled by the so called `Switchable Controller Actions`. That is the field
"Show" in tab "Plugin". That will be changed in future but for now is this the way to go.

The "Operations Statistics" plugin will show you the statistics of operations in the last years, grouped by
year and type.

Ok, let's go.

.. rst-class:: bignums

1. Select the :guilabel:`"Web" > "Page"` module on the left and select the page in page tree
   where you want to have the plugin and create a new content element.

   .. image:: /Images/Backend/create-content.png
      :alt: The button to create new content elements
      :class: with-shadow

2. Switch to tha tab "Plugins" in open modal box to see the entries of `Operations`. Choose your plugin.

   .. image:: /Images/Backend/newcontent-plugins.png
      :alt: The button to create new content elements
      :class: with-shadow

3. Switch to tha tab "Plugin" in the Content Element (you should be automatically already there) and
   select your needed View in the field "Show" (the Switchable Controller Action).

   .. image:: /Images/Backend/switchablecontrolleractions.png
      :alt: Field for Switchable Controller Actions
      :class: with-shadow

   |

   Now configure needed settings for the selected view like described here in :ref:`Configuration <plugin-configuration>`
   Repeat these step to create all needed views for the frontend. At least a single view for the operations.

.. tip::

   Use default settings in TypoScript and just define settings in Plugins to overwrite the settings from TypoScript.


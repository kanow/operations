.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _typoscript-configuration:

========================
TypoScript configuration
========================


Include static TypoScript
=========================

The extension come with some TypoScript which needs to be included.

#. Select the root page of your site.

#. Switch to the **Template module** and select *Info/Modify*.

#. Press the link **Edit the whole template record** and switch to the tab *Includes*.

#. Select **Operations (operations)** at the field *Include static (from extensions):*

.. figure:: ../Images/IncludeTs.png
   :class: with-shadow
   :alt: Include static TypoScript

   Include static TypoScript



TypoScript Example
==================

Minimal example of TypoScript to overwrite a setting in operations:

.. code-block:: typoscript

    plugin.tx_operations.settings {
        # set length of cropped teaser
        cropTeaser = 200
        single {
            showNoReport = 1
        }
    }

Use your own template files
===========================

Please copy the needed folders and files in your fileadmin folder.

You need at least one folder for *Layouts*, *Templates* and *Partials*

You find those folders in the extension folder of operations:

* Resources/Private/Layouts
* Resources/Private/Templates
* Resources/Private/Partials

You don't need to copy all files. Just copy the files and folders you need.
Then change the paths in constants to your own. Now you can edit the files you want to change.

Change the templates paths in TypoScript constants
""""""""""""""""""""""""""""""""""""""""""""""""""
Use the following TypoScript in  **constants** to change the paths

.. code-block:: typoscript

   plugin.tx_operations {
           view {
                   templateRootPath = fileadmin/templates/ext/operations/Templates/
                   partialRootPath = fileadmin/templates/ext/operations/Partials/
                   layoutRootPath = fileadmin/templates/ext/operations/Layouts/
           }
   }

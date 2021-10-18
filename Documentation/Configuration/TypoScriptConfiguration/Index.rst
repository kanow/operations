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
You can include TypoScript in different ways. The preferred way should be include TypoScript from Extensions
in your Site Package. See  :ref:`Include TypoScript in Site Package <t3sitepackage:typoscript-configuration>`

The old way is also possible. Include TypoScript of the Extension in your root TypoScript Template (`sys_template`)
in database.

#. Select the root page of your site.

#. Switch to the **Template module** and select *Info/Modify*.

#. Press the link **Edit the whole template record** and switch to the tab *Includes*.

#. Select **Operations (operations)** at the field *Include static (from extensions):*

.. figure:: ../../Images/IncludeTs.png
   :class: with-shadow
   :alt: Include static TypoScript

   Include static TypoScript



TypoScript Example
==================

You can override TypoScript in your Site Package or in database sys_templates. Small example of TypoScript to
overwrite some settings from the Extension:

.. code-block:: typoscript

    plugin.tx_operations {
      persistence.storagePid = 45
      settings {
        cropTeaser = 150
        itemsPerPage = 8
      }
    }

.. note::

   Add your own additional settings if you need some and use those settings with
   :html:`{settings.yourNewSetting}` in Fluid Templates.

.. attention::

   Add your own TypoScript after the includes of TypoScript from `operations`!

.. _own-template-files:

Use your own template files
===========================

If you need changes on the template files, you should copy the needed files to your
:ref:`Site Package <t3tmsa:tmsa-Sitepackages>`.
You need the same folder structure as described her: :ref:`Fluid Templates <t3sitepackage:fluid-templates>`.
Please copy the needed folders and files in your
:ref:`Site Package <t3tmsa:tmsa-Sitepackages>` ``Resources/Private`` folder.


You find those structure also in operations:

* Resources/Private/Layouts
* Resources/Private/Templates
* Resources/Private/Partials

You don't need to copy all files. Just copy the files and folders you need.

.. note::

   If you copy files from subfolders, you must keep the existing subfolder structure also in your Site Packages!
   That means ``Templates/Operation/List.html`` must be copied to a subfolder ``Operation`` in the
   ``Templates`` folder.

After that you can change the paths in constants to your own :ref:`Site Package <t3tmsa:tmsa-Sitepackages>`
or in :ref:`Constants Editor <t3tsref:constant-editor>`.
This way you can edit some files but not all. It's easier if you upgrade `operations`.
Probably you have to change less files after updating.


Change the templates paths in TypoScript constants
""""""""""""""""""""""""""""""""""""""""""""""""""
Here an example for TypoScript constants to change the paths

.. code-block:: typoscript

   plugin.tx_operations {
           view {
                   templateRootPath = EXT:your_site_package/Resources/Private/Extensions/operations/Templates/
                   partialRootPath = EXT:your_site_package/Resources/Private/Extensions/operations/Partials/
                   layoutRootPath = EXT:your_site_package/Resources/Private/Extensions/operations/Layouts/
           }
   }

.. tip::

   Some setting should be placed in Site Package and some are better placed in database.
   Example: :typoscript:`storagePid` should better set in database, but :typoscript:`itemsPerPage` is
   more an default setting which can be used in different environments in generally. It doesn't depends
   on database (e.g. different pages)

Whole list of TypoScript Settings
=================================

You can find the whole list of TypoScript Reference for `operations` in those file:

``Configuration/TypoScript/setup.typoscript``

Settings starting here:

.. code-block:: typoscript

   plugin.tx_operations {
      settings {
         …
      }
   }

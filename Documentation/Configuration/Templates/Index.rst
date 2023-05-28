.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _fluid-template-files:

===========================
Use your own template files
===========================

If you need changes on the Fluid template files, you should copy the needed files to your
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
   That means ``Templates/Operation/List.html`` must be copied to a subfolder ``Operation`` in your
   ``Templates`` folder.

After that you can change the paths in constants to your own :ref:`Site Package <t3tmsa:tmsa-Sitepackages>`
or in :ref:`Constants Editor <t3tsref:constant-editor>`.
This way you can edit some files but not all. It's easier to check differences if you upgrade `operations`.
Probably you have to change less files after updating.


Change the templates paths in TypoScript constants
""""""""""""""""""""""""""""""""""""""""""""""""""
Here an example for TypoScript constants to change the paths to Fluid templates.

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

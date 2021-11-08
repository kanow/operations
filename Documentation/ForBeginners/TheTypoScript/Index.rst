.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _thetyposcript:

==============
The TypoScript
==============

To get `operations` working you need to load the TypoScript of the extension. I described this already here in the docs
:ref:`TypoScript Configuration <typoscript-configuration>`. Here I will do it a little bit more detailed.
I hope that will help beginners to understand it easier.

I assume that you have already a page tree for your site. If not, please create them first. I have
:ref:`here <pagetree>` an example for a useful page tree of a firefighter website.


Include TypoScript of `operations` in the database
==================================================

.. rst-class:: bignums

1. Select the root page of your site. It's the page with the globe icon.

   .. image:: /Images/Backend/rootpage.png
      :alt: Root page in page tree
      :class: with-shadow

2. Switch to the Template module on the left

   .. image:: /Images/Backend/template-module.png
      :alt: Template module on the left
      :class: with-shadow

3. In the select box in Docheader choose "Info/Modify"

   .. image:: /Images/Backend/choose-infomodify.png
      :alt: Open select box for TS Template
      :class: with-shadow

4. Click the Button "Edit the whole template record"

   .. image:: /Images/Backend/button-wholetemplate.png
      :alt: Button to edit the whole template
      :class: with-shadow

5. Now switch to the tab "Includes" and select the entry of "Operations"

   .. image:: /Images/Backend/include-ts.png
      :alt: Include TypoScript from operations
      :class: with-shadow

   |

   .. attention::

      If you want to overwrite TypoScript of `operations` in your Site Package, be sure that
      the include of the TypoScript from your Site Package comes after the TypoScript from `operations`!
      In those case the TypoScript of `FireDepartment` should be the last entry in list!

6. Save the changes and close it.

.. tip::

   You can choose the TypoScript Object Browser to test whether the TypoScript of `operations` is successfully included.

   .. image:: /Images/Backend/tsob.png
      :alt: operations TypoScript in TypoScript Object Browser
      :class: with-shadow


Use Constant editor to configure some individual settings
=========================================================

There are some settings that need to be adjusted to your installation. A simple way to find such settings is the
:ref:`TYPO3 Constant Editor <t3tsref:constant-editor>`. To use them click on the module :guilabel:`"Web" > "Template"`
on the left side, then select your Homepage in page tree and select "Constant Editor" in the select box in Docheader.

In the select box "Category" you find the entries for tx_operations. Choose them one after another
and have look to the proposal settings.

.. image:: /Images/Backend/tx_operations-constants.png
   :alt: Tx_Operations constants in constant editor
   :class: with-shadow

|

All those constants have a description for each setting. So you can see what does the setting will do.


Necessary Settings
------------------

To get `operations` working you need at least this 4 settings in the category: "TX_OPERATIONS-STORAGE-AND-PIDS".
The necessary settings are:

.. container:: row m-0 p-0

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: persistence.storagePid

         .. container:: card-body

            This is the uid of your sysfolder where the operation data in backend is.

            .. image:: /Images/Backend/operation-data.png
               :alt: Sysfolder for operation data

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: settings.operationSinglePid

         .. container:: card-body

            This is the uid of the single view page for operations.

            .. image:: /Images/Backend/operation-singleviewpage.png
               :alt: Single view page in page tree for operations

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: settings.vehicleSinglePid

         .. container:: card-body

            This is the uid of the single view page for vehicles.

            .. image:: /Images/Backend/vehicle-singleviewpage.png
               :alt: Single view page in page tree for vehicles

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: settings.resourceSinglePid

         .. container:: card-body

            This is the uid of the single view page for resources.

            .. image:: /Images/Backend/resource-singleviewpage.png
               :alt: Single view page in page tree for resources



.. tip::

   You can find the uid (and other useful informations) of a page / sysfolder when you hover with your mouse over the
   icon before the text.

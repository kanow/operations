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

Use Constant Editor
===================

After including operations TypoScript there are some settings in :ref:`TYPO3 Constants Editor <t3tsref:constant-editor>`
available.
The most important setting to use the extension can be set here.

Necessary Settings
------------------

To get `operations` working you need at least this 4 settings in the category: "TX_OPERATIONS-STORAGE-AND-PIDS".
The necessary settings are:

.. code-block:: typoscript

    plugin.tx_operations {
      # This is the uid of your sysfolder where the operation data in backend is.
      persistence.storagePid = 45
      settings {
        # This is the uid of the single view page for operations.
        operationSinglePid =
        # This is the uid of the single view page for vehicles.
        vehicleSinglePid =
        # This is the uid of the single view page for resources.
        resourceSinglePid =
      }
    }

.. tip::

   You can find the uid (and other useful informations) of a page / sysfolder when you hover with your mouse over the
   icon before the text.

Whole list of TypoScript Settings
=================================

You can find the whole list of TypoScript settings for `operations` in those file:

``Configuration/TypoScript/setup.typoscript``

Settings starting here:

.. code-block:: typoscript

   plugin.tx_operations {
      settings {
         …
      }
   }

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _configuration-categories:

========================
Categories in operations
========================

Using Categories
================
You can use categories to organize your operations. e.g.
Create a structure with a main fire department and sub departments.
Select categories in Operations plugin to control the result of list view or statistic view in frontend.

You don't need those main department and sub department stuff? Ok, use the categories for whatever
you want or ignore it.

.. important::

    There is only a **flat** category handling. That means, if you select a category, no child categories are respected.

Set a root category in extension configuration (that is the global setting) or in PageTS-Config to restrict the
displayed categories in operation plugin in backend. PageTS-Config setting overrides the setting in extension
configuration.

.. code-block:: typoscript

    tx_operations {
        categoryRootId = 4
    }

.. tip::

   Set a global Root-Category in extension configuration and use different Root-Category uid's on pages in the tree,
   to show different categories in plugin. Depending on the related department or whatever.

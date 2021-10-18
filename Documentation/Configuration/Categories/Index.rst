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
You can use categories to organize your operations. E.g.
Create a structure with a main fire department and sub departments.
Select categories in Operations plugin to control the result of list view or statistic view in frontend.

You don't need those main department and sub department stuff? Ok, use the categories for whatever
you want or ignore it.

.. note::

    There is only a **flat** category handling. That means, if you select a category, no child categories are respected.

.. tip::

   Set a :yaml:`rootCategory` in your :ref:`Site Configuration <t3coreapi:sitehandling-basics>` to restrict the displayed categories in your operation
   data and plugins in backend. This is useful if you have a multi domain instance.
   This way you can use different categories for each site.

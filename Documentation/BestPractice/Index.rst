.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _bestPractice:
.. _forge: http://forge.typo3.org/projects/extension-operations


Best Practice
=============

Using Categories
^^^^^^^^^^^^^^^^
You can use categories to organize your operations. Create a structure with a main fire department and sub departments. Select categories in Operations plugin (List-, Search-View) to control the result in frontend.

You don't need those main department and sub department stuff? Ok, use the categories for whatever you want or ignore it.

.. important::

    There is only a **flat** category handling. That means, if you select a category, no child categories are respected.

Set a root category in PageTS-Config to restrict the displayed categories in operation plugin in backend.

.. code-block:: typoscript

    tx_operations {
        categoryRootId = 4
    }

.. tip::

    Set different Root-Category uid's on pages in tree, to show different categories in plugin. Depending on the related department or whatever.

.. tip::

    Categories can be used in Operations Statistics plugin too!

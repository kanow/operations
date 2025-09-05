.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt

.. _plugin-statistics:

========================
Statistics configuration
========================


Display operations statistics
=============================

Add a content element type "Operation Statistics view". Set category if
you want and the last years to show.
Of courses, storage pid should be already set in TypoScript.
If not you have to set this in plugin settings too.

This will show you all operations grouped by type and year depending on the
settings you did.

The setting "lastYears" define how many years descending from now should be
respected for the statistics.
It's the same setting as in the normal list and can be overridden directly in the "Operation Statistics" plugin.
Years without any operations will be ignored.


Change JavaScript for statistics
================================

If you need adapting the chart, please use your own JavaScript file and change the path to it in template file:
``Resources/Private/Templates/Operation/Statistics.html``

.. code-block:: html

    <f:section name="FooterAssets">
        <!-- chart library -->
        <script src="{f:uri.resource(path: 'Js/Chart.bundle.js')}"></script>
        <!-- change path to your own js file if you need -->
        <script src="{f:uri.resource(path: 'Js/OperationsChart.js')}"></script>
    </f:section>

I suggest to put those things in an own :ref:`Site Package <t3start:creating-a-site-package>`.
Change the path in your own template files. using your own template files is described
here :ref:`Templates <fluid-template-files>`.


.. attention::

   Do not remove those table with data from the template!
   :html:`<table data-chart="operationsChart-{contentObjectData.uid}"
   class="operationsChart-{contentObjectData.uid} dataset">`
   That is used to generate the data in the chart.
   Hide the table with css if necessary.

.. tip::

   You can build a switch with little JavaScript that toggles the view.
   Showing the table or the chart.
   That is helpful for people with a disabilities.

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _statistics:

========================
Statistics configuration
========================


Display operation statistics
============================

Add a content element and use the plugin "Operations Statistics". Set category if you want and maybe the last years to show.
Of courses, storage pid should be already set in TypoScript. If not you have to set this in plugin settings.

This will show you all operations grouped by type and year depending of the settings you did.

The setting "lastYears" define how many years descending from now should be respected for the statistics. Years without any operations will be ignored.

It is the same setting as in the normal list and can be overridden directly in the "Operations Statistics" plugin.

Change JavaScript for statistics
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If you need adapting the chart, please use your own JavaScript file and change the path to it in template file:
`Resources/Private/Templates/Operation/Statistics.html`

.. code-block:: html

    <f:section name="FooterAssets">
        <!-- chart library -->
        <script src="{f:uri.resource(path: 'Js/Chart.bundle.js')}"></script>
        <!-- change path to your own js file if you need -->
        <script src="{f:uri.resource(path: 'Js/OperationsChart.js')}"></script>
    </f:section>

I suggest to put those things in an own :ref:`Site Package <t3tmsa:tmsa-Sitepackages>`.
Change the paths to your own template files, described here :ref:`TypoScriptConfiguration <own-template-files>` .


.. important::

   Do not remove the table with data from the template!
   :html:`<table data-chart="operationsChart-{contentObjectData.uid}" class="operationsChart-{contentObjectData.uid} dataset">`
   That is used to generate the data in the chart.
   Hide the table with css if necessary.

.. tip::

   You can build a switch with little JavaScript that toggles the view. Showing the table or the chart.
   That is helpful for people with a disabilities.

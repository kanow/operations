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

There is nothing to configure. Add a content element and use the plugin "Operations Statistics". That's all.

This will show you all operations grouped by type and year.
The setting "lastYears" define wich years should be used for the statistics. Years without operations will be ignored.

Change templating for statistics
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If you nee adapting the chart, please use your own JavaScript file and change the path to it in template file:
`Resources/Private/Templates/Operation/statistics.html`

.. code-block:: html

    <f:section name="FooterAssets">
        <!-- chart library -->
        <script src="{f:uri.resource(path: 'Js/Chart.bundle.js')}"></script>
        <!-- change path to your own js file if you need -->
        <script src="{f:uri.resource(path: 'Js/MyChart.js')}"></script>
    </f:section>

I suggest to put those things in an own extension/site package. Change the paths like described in :ref:`TypoScriptConfiguration <own-template-files>` .


.. important::

   Do not remove the table with data from the template! They is used to generate the data in chart.
   Hide the table with css.

.. tip::

   You can build a switch with little JavaScript that toggles the view. Showing the table or the chart.
   That is helpful for people with a disability.

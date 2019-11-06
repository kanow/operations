.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _bestPractice:
.. _forge: http://forge.typo3.org/projects/extension-operations


Best Practice
=============

Speaking Urls
^^^^^^^^^^^^^

Here is an example configuration for using speaking urls on operations. Put them into your config of your site configuration.
Typically that will be found in typo3conf folder (non composer) or config folder in project root (composer). Please replace "x" with your page ID's for the different sites. e.g. Operations list view, single-view and the other single vies for vehicles and resources.

.. code-block:: yaml
    :linenos:

    routeEnhancers:
    OperationsPlugin:
        type: Extbase
        limitToPages: [x,x,x]
        extension: Operations
        plugin: List
        routes:
        - { routePath: '/{page}', _controller: 'Operation::list', _arguments: {'page': '@widget_0/currentPage'} }
        - { routePath: '/{operation_title}', _controller: 'Operation::show', _arguments: {'operation_title': 'operation'} }
        - { routePath: '/{vehicle_title}', _controller: 'Vehicle::show', _arguments: {'vehicle_title': 'vehicle'} }
        - { routePath: '/{resource_title}', _controller: 'Resource::show', _arguments: {'resource_title': 'resource'} }
        defaultController: 'Operation::list'
        defaults:
            page: '0'
        requirements:
            page: '\d+'
        aspects:
            page:
                type: StaticRangeMapper
                start: '1'
                end: '200'
            operation_title:
                type: PersistedAliasMapper
                tableName: 'tx_operations_domain_model_operation'
                routeFieldName: 'path_segment'
            vehicle_title:
                type: PersistedAliasMapper
                tableName: 'tx_operations_domain_model_vehicle'
                routeFieldName: 'path_segment'
            resource_title:
                type: PersistedAliasMapper
                tableName: 'tx_operations_domain_model_resource'
                routeFieldName: 'path_segment'


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

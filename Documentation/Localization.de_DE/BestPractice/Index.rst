.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _bestPractice:
.. _forge: http://forge.typo3.org/projects/extension-operations


Best Practice
=========

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
.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _speakingUrl:


=======================================
Sample RouteEnhancer for speaking url's
=======================================



Use it in your site configuration
---------------------------------


Here is a sample `Extbase Plugin Enhancer <https://docs.typo3.org/typo3cms/extensions/core/Changelog/9.5/Feature-86365-RoutingEnhancersAndAspects.html#extbase-plugin-enhancer>`_ to use speaking url's for single views of operations, vehicles,  resources and the pages in list with pagination.
You don't know about the site configuration? Read here: `TYPO3 Site Configuration Storage <https://docs.typo3.org/m/typo3/reference-coreapi/9.5/en-us/ApiOverview/SiteHandling/Basics.html#site-configuration-storage>`_


.. highlight:: yaml

::

    routeEnhancers:
        OperationsPlugin:
            type: Extbase
            limitToPages: [2,4,6,8]
            extension: Operations
            plugin: List
            routes:
            - { routePath: '/list-{page}', _controller: 'Operation::list', _arguments: {'page': '@widget_0/currentPage'} }
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

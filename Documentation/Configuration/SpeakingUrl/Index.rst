.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _speakingUrl:


=======================================
Sample RouteEnhancer for speaking url's
=======================================


Usage in your Site Configuration
================================

Url routing for TYPO3 Extensions are explained more detailed here
:ref:`Advanced routing configuration <t3coreapi:routing-advanced-routing-configuration>`.
That's also needed to to use nice url's for single views of operations, vehicles, resources and the pages in list with
pagination.

More information about Routing: :ref:`Speaking Urls <t3tmsa:Speaking-Urls>`

You don't know about the Site Configuration? Read here: :ref:`Sitehandling <t3coreapi:sitehandling-basics>`

Here is an example RouteEnhancer configuration that I'm using in my develop environment.


.. highlight:: yaml

::

      routeEnhancers:
        OperationsPlugin:
          # set "limitToPages" for route enhancer directly in your site config
          type: Extbase
          extension: Operations
          plugin: List
          routes:
            -
              routePath: '/{localized_page}-{page}'
              _controller: 'Operation::list'
              _arguments:
                page: currentPage
            -
              routePath: '/{operation_title}'
              _controller: 'Operation::show'
              _arguments:
                operation_title: operation
            -
              routePath: '/{vehicle_title}'
              _controller: 'Vehicle::show'
              _arguments:
                vehicle_title: vehicle
            -
              routePath: '/{resource_title}'
              _controller: 'Resource::show'
              _arguments:
                resource_title: resource

          defaultController: 'Operation::list'
          defaults:
            page: '1'
          requirements:
            page: \d+
          aspects:
            page:
              type: StaticRangeMapper
              start: '1'
              end: '200'
            operation_title:
              type: PersistedAliasMapper
              tableName: tx_operations_domain_model_operation
              routeFieldName: path_segment
            vehicle_title:
              type: PersistedAliasMapper
              tableName: tx_operations_domain_model_vehicle
              routeFieldName: path_segment
            resource_title:
              type: PersistedAliasMapper
              tableName: tx_operations_domain_model_resource
              routeFieldName: path_segment
            localized_page:
              type: LocaleModifier
              default: 'page'
              localeMap:
                - locale: 'de_DE.*'
                  value: 'seite'


This example is included in TYPO3 Extension `fire_department <https://extensions.typo3.org/extension/fire_department>`_
in folder: ``Configuration/Yaml/Routes/Operations.yaml``.
Use an :yaml:`@import` statement in your site config and set :yaml:`limitToPages`:

.. highlight:: yaml

::

      imports:
        - { resource: "EXT:fire_department/Configuration/Yaml/Routes/Operations.yaml" }
      routeEnhancers:
        OperationsPlugin:
          limitToPages: [5,7,9]

.. tip::

   Copy that file to your Site Package and use the import for those file if you don't want using the default
   configuration.

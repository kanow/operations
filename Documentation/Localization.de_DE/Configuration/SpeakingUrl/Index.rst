﻿.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _speakingUrl:


========================================
Beispiel RouteEnhancer für lesbare Url's
========================================



Definition für eure "Site Configuration"
----------------------------------------


Der neue "RouteEnhancer" in TYPO3 wird benutzt um die Url's von Extensions lesbar zu kriegen. Generelle Erklärungen findet ihr hier: `Extbase Plugin Enhancer (englisch) <https://docs.typo3.org/typo3cms/extensions/core/Changelog/9.5/Feature-86365-RoutingEnhancersAndAspects.html#extbase-plugin-enhancer>`_
Diese Konfiguration muss in der ebenfalls neu unter TYPO3 9.5 "Site Configuration" angegeben werden. Wenn ihr die Site Configuration noch nicht kennt gibt's hier die notwendige Einführung: `TYPO3 Site Configuration Storage (englisch) <https://docs.typo3.org/m/typo3/reference-coreapi/9.5/en-us/ApiOverview/SiteHandling/Basics.html#site-configuration-storage>`_

Das nachfolgende Beispiel zeigt euch eine Konfiguration wie sie für die Extension `operations` aussehen kann. Damit bekommt ihr lesbare Url's für die List- und Einzelansicht, sowie die Seiten/Blätternavigation bei längeren Listen.

.. highlight:: yaml

::

    routeEnhancers:
        OperationsPlugin:
            type: Extbase
            limitToPages: [2,4,6,8]
            extension: Operations
            plugin: List
            routes:
            - { routePath: '/{localized_page}-{page}', _controller: 'Operation::list', _arguments: {'page': 'currentPage'} }
            - { routePath: '/{operation_title}', _controller: 'Operation::show', _arguments: {'operation_title': 'operation'} }
            - { routePath: '/{vehicle_title}', _controller: 'Vehicle::show', _arguments: {'vehicle_title': 'vehicle'} }
            - { routePath: '/{resource_title}', _controller: 'Resource::show', _arguments: {'resource_title': 'resource'} }
            defaultController: 'Operation::list'
            defaults:
                page: '1'
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
                localized_page:
                    type: LocaleModifier
                    default: 'page'
                    localeMap:
                      - locale: 'de_DE.*'
                      value: 'seite'

Natürlich könnt ihr diese Konfiguration nach euren Vorstellungen anpassen. Mindestens die Seiten ID's bei dem Punkt
:yaml:`limitToPages` solltet ihr anpassen.

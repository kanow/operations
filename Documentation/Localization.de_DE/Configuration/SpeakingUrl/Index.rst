.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _speakingUrl:


========================================
Beispiel RouteEnhancer für lesbare Url's
========================================



Definition für eure Site Configuration
======================================


Schöne und lesbare Url's werden in TYPO3 mit Hilfe von sogenannten "Route Enhancern" konfiguriert. Eine Beschreibung
dieser Funktionalität findet ihr hier:
:ref:`Advanced routing configuration <t3coreapi:routing-advanced-routing-configuration>`.

Mehr Information zum Url Routing von TYPO3: :ref:`Speaking Urls <t3tmsa:Speaking-Urls>`

Information zur Nutzung der Site Configuration in TYPO3: :ref:`Sitehandling <t3coreapi:sitehandling-basics>`

Damit werden auch die schönen/lesbaren Url's für die Einzelansichten der Einsätze, Fahrzeuge und Hilfsmittel gebaut.
Diese Konfiguration muss dazu in eurer "Site Configuration" eingefügt werden.

Nachfolgend findet ihr ein Beispiel für eine solche Konfiguration, wie ich sie in meiner Testumgebung einsetze.
Damit bekommt ihr lesbare Url's für die Einzelansichten, sowie die Seiten/Blätternavigation bei längeren Listen.

.. highlight:: yaml

::

      routeEnhancers:
        OperationsPlugin:
          # set `limitToPages:` for route enhancer directly in your site config
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


Dieses Beispiel findet ihr auch in der TYPO3 Extension `fire_department <https://extensions.typo3.org/extension/fire_department>`_
im Ordner: ``Configuration/Yaml/Routes/Operations.yaml``.
Das könnt ihr dann einfach mit einem :yaml:`@import` in eure "Site Configuration" einbauen und dann noch die Einstellung
für :yaml:`limitToPages` setzen.

.. highlight:: yaml

::

      imports:
        - { resource: "EXT:fire_department/Configuration/Yaml/Routes/Operations.yaml" }
      routeEnhancers:
        OperationsPlugin:
          limitToPages: [5,7,9]

.. tip::

   Ihr könnt die Datei auch in euer eigenes "Site Package" kopieren und diese dann importieren wenn das Beispiel
   nicht ausreicht oder ihr etwas ändern wollt.


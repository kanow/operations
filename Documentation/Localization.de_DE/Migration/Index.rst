.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _migration:

=========
Migration
=========

Migration nach Änderung Feld image nach media
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Achtung, bitte unbedingt die Datenbanktabellen von `operations` einmal vorher sichern. Ich übernehme keine Garantie für die Richtigkeit dieser SQL Anweisungen.

Die nachfolgenden SQL Anweisungen schreiben die Angaben von image nach media in den `operations` Datenbanktabellen und die Feldnamen in der sys_file_reference Tabelle um.

.. code-block:: sql

    UPDATE tx_operations_domain_model_operation LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_operation.uid AND sys_file_reference.tablenames='tx_operations_domain_model_operation' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_operation.media=tx_operations_domain_model_operation.image, tx_operations_domain_model_operation.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_operation.image > 0;

    UPDATE tx_operations_domain_model_vehicle LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_vehicle.uid AND sys_file_reference.tablenames='tx_operations_domain_model_vehicle' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_vehicle.media=tx_operations_domain_model_vehicle.image, tx_operations_domain_model_vehicle.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_vehicle.image > 0;

    UPDATE tx_operations_domain_model_resource LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_resource.uid AND sys_file_reference.tablenames='tx_operations_domain_model_resource' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_resource.media=tx_operations_domain_model_resource.image, tx_operations_domain_model_resource.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_resource.image > 0;

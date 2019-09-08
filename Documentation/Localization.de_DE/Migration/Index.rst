.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _migration:

=========
Migration
=========

Migrate after changing image to media in 3.0.0
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Please backup your database before excute the following commands! There is no warranty for correct working!

.. code-block:: sql
    :linenos:

    UPDATE tx_operations_domain_model_operation LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_operation.uid AND sys_file_reference.tablenames='tx_operations_domain_model_operation' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_operation.media=tx_operations_domain_model_operation.image, tx_operations_domain_model_operation.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_operation.image > 0;

    UPDATE tx_operations_domain_model_vehicle LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_vehicle.uid AND sys_file_reference.tablenames='tx_operations_domain_model_vehicle' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_vehicle.media=tx_operations_domain_model_vehicle.image, tx_operations_domain_model_vehicle.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_vehicle.image > 0;

    UPDATE tx_operations_domain_model_resource LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_resource.uid AND sys_file_reference.tablenames='tx_operations_domain_model_resource' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_resource.media=tx_operations_domain_model_resource.image, tx_operations_domain_model_resource.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_resource.image > 0;

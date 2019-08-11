.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _3.0.0:


3.0.0
=====

.. tip::
	For detailed list of changes got to github and show commit history `Operations on Github <https://github.com/kanow/operations>`_



**TYPO3 9.5 compatibility!**
----------------------------

Remove support for TYPO3 8.7. Complete refactoring at all kind of code.



Change field **image** to **media** on operation, resource and vehicle
^^^^^^^^^^^^^^^^^^^^^^

- Compare database after upgrade.
- You find SQL code for migration here: :ref:`Migration <migration>`


Improved slug handling
^^^^^^^^^^^^^^^^^^^^^^

The slug configuration for `tx_operations_domain_model_operation`, `tx_operations_domain_model_vehilce` and `tx_operations_domain_model_resource` improved by using features of the core.
The configuration looks now like: ::

    'generatorOptions' => [
      'fields' => ['title'],
      'replacements' => [
          '/' => '-'
      ],
    ],
    'fallbackCharacter' => '-',
    'eval' => 'uniqueInSite',

Upgrade wizards in the Install Tool can be used to fill the slug field.





Many changes in template files
^^^^^^^^^^^^^^^^^^^^^^

- Some viewhelpers are removed.
- Change map rendering from googleMap to leaflet. The values for longitude and latitude are still in use.
- Remove slider and lightbox stuff. Please templating your own if needed.
- Some JavaScript files are removed.

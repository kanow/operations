.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _adddata:

===================
Add data in backend
===================

If you've created the sysfolder for the data you can start creating the first operations data.
You should start with data for the relations. Types, vehicles, resources and assistance.


.. rst-class:: bignums


1. Got to the :guilabel:`"Web" > "List"` module and select the operation data sysfolder.

   .. image:: /Images/Backend/sysfolder-operations.png
      :alt: Sysfolder with operations data
      :class: with-shadow

   .. note::

      You need the translation of the sysfolder only if you have a multilanguage site and you are planning to
      translate the operation data.

   .. important::

      Without the translated sysfolder you can't translate the operation data!

2. Click on the :guilabel:`"+"` button on Docheader to create new data.

   .. image:: /Images/Backend/button-createnew.png
      :alt: Button to create new data
      :class: with-shadow

3. Click on the text to choose the type of data you want to create.

   .. image:: /Images/Backend/choose-datatype.png
      :alt: List datatypes of operations
      :class: with-shadow

4. If you need categories, create new category data.

   .. image:: /Images/Backend/create-category.png
      :alt: Create a new category
      :class: with-shadow

   .. tip::

      Create a root/main category first that is the parent category for all operation categories.
      You can restrict the visibility of categories in frontend plugins and in operation data with the
      setting in Site Configuration.

5. Set root category uid in Site Configuration to restrict the visible categories in frontend plugins and operation
   data. If you don't have a Site Configuration yet, create one in :guilabel:`"Site Management" > "Sites"` module.

   .. image:: /Images/Backend/module-siteconfig.png
      :alt: Site Configuration module
      :class: with-shadow

   |

   .. image:: /Images/Backend/button-addsiteconfiguration.png
      :alt: Button Add news Site Configuration"      :class: with-shadow

   |

   When creating a new site configuration, a folder in the file system is created located at
   :file:`<project-root>/config/sites/<identifier>/`. The site configuration is stored in a
   file called :file:`config.yaml`.

   .. note::
      If you are using a non-composer based installation, the location is :file:`typo3conf/sites/`.
      If your are using a composer based installation, the location is :file:`<project-root>/config/sites`.

   .. hint::
      Add this folder to your version control.

   Here are few lines of example code in a Site Configuration. Add `settings` on the first level.

   .. code:: yaml

      rootPageId: 1
      base: 'https://typo3-11.ddev.site/'
      settings:
        operations:
          rootCategory: 2
      ...

   |

   Sure, you need more than these few line for a working Site Configuration. This is just an example where
   you can add the `settings`.

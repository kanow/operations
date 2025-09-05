.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _changelog:

=========
Changelog
=========

8.2.0
=====

Some small improvements on code quality checks and support now postgres and
sqlite db systems.

8.1.0
=====

TYPO3 13 compatibility

Update to 8.0.0
===============

This version brings TYPO3 12 compatibility and retains compatibility with
TYPO3 11. So `operations` currently runs with both LTS versions of TYPO3.

The hard dependency to Georg Ringer's `numbered_pagination` has been removed.
There was no 12 compatible version of it available. Maybe there won't be one,
because the TYPO3 core has now its own solution.
For TYPO3 11 installations this means that you have to take care of the
installation of the `numbered_pagination` by yourself.
Depending on the TYPO3 version, `operations` selects either the
`NumberedPagination` class (if exists) or the newer `SlidingWindowPagination` class.
If neither is available, then `SimplePagination` is used.
In TypoScript there is the possibility to override this and using another
pagination class.

.. code-block:: typoscript

   plugin.tx_operations {
      settings {
         paginate {
            class = Vendor/YourOwn/PaginationClass
         }
      }
   }


Breaking Change
^^^^^^^^^^^^^^^

Instead of the old "SwitchableControllerActions" in the plugins now real
content elements are used. There is an "Migrate old plugins"
:ref:`Upgrade Wizard <t3coreapi:postupgradetasks>` which must be
executed after installing the update. This converts old plugins into the
new content elements. Corresponding settings should be applied.

If the single view for the operations was not on an extra page, with the
extra action, manually adjustments may be necessary.

Update to 7.1.0
===============

*  Before this update you always had a limit for operations data. That is not useful in statistics view.
   Now there is no limit by default for statistics. You can deactivate this to get back the old behaviour
   with the TypoScript setting `noLimitForStatistics = 0`.

*  Now the extension "numbered_pagination" by georg ringer is used for the pagination. Check the TypoScript settings and
   Fluid Templates/Partials for changes. The extension will be installed automatically on composer based TYPO3
   installations. If you have a non composer installation you have to install the extension by yourself manually before
   updating operations.

*  The colors in operation type are now excluded on translations. You dont have to set a color for the translation.

Update to 7.0.0
===============

This version is only running on TYPO3 11. In that version I fixed some small bugs and switch to some new features
of TYPO3 11.

Changing of category relations
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Database table for category relations was changed.
There is an :ref:`Upgrade Wizard <t3coreapi:postupgradetasks>` of operations to migrate old category relations
automatically to the new table.
In this version `sys_category_mm` table is used and the old relation table should be removed.

.. attention::

   Don't delete the table `tx_operations_operation_category_mm` before data was migrated to
   `sys_category_mm` table.


Breaking Change
^^^^^^^^^^^^^^^

Extension setting for ``rootCategory`` is moved to Site Configuration! Related setting in TypoScript and Page TS-Config
was completely removed.
To restrict the categories in plugin/operation/filter view many code was needed. With TYPO3 11 this is
not longer necessary because of the new TCA type "category" with "startingpoints" and using values from
:ref:`Site Configuration <t3coreapi:sitehandling-basics>` to define that startingpoints.
Therefore I switched to set this rootCategory in :ref:`Site Config <t3coreapi:sitehandling-basics>`.

Example code for your :ref:`Site Configuration <t3coreapi:sitehandling-basics>`:

.. code-block:: yaml

    settings:
     operations:
       rootCategory: 2

If you are using default templates, then you shouldn't have problems with the other changes. Please check your site
after updating the Extension.

Update to 6.x
===============

Bugfix and maintenance release.
Attention, Breaking Changes in this version! The new Pagination API of TYPO3 10 is used.
The old Fluid Pagination Widget was removed. TypoScript setting `maxNumberOfLinks`
not longer necessary and therefore removed.
If you use the original template files for List and Search Action from operations version 5.1.x, then nothing should
to do for you. If not, check if you changed one of the following files and have a look at the changes in original files:

* Resources/Private/Templates/Operation/List.html
* Resources/Private/Templates/Operation/Search.html
* Resources/Private/Partials/List/Pagination.html

If you configured the current page of pagination in the url (in the site configuration) you have to change the
configuration for the page argument. It's not longer that `@widget` stuff. Have a look at the
:ref:`Speaking url example page in manual <speakingUrl>`.


Slug behaviour was changed to `unique`. With an updated TYPO3 version it is now possible to use the sysfolder with
operations data outside of the page tree. You can use one folder for multiple Sites in the same TYPO3 Instance.
If you need uniqueInSite for your page, then you can switch that behaviour in the BE module "Settings" -> Extension Configuration.

Update to 5.1.0
===============

Fix exception in list view of operations. Stand out just in TYPO3 10.

Improve translation handling with excluding some fields they don't need to be translated. Catgeories, resources, vehicles, lat and long, assistance, type, onlEld are the same in all languages.

Of course data for categories, resources, vehicles, assistance and type can be translated. Then translated field values are shown. Probably this depends on your language settings for sys_language_mode and sys_language_overlay.


.. note::
   I've tested translations with the following settings in my site configuration.
    * default language: german (0), second language: english (1)
    * Connected mode for translations.

   .. code-block:: yaml

       fallbackType: strict
       fallbacks: '0,1'

   With those settings the translated relations (resources,vehicles,…) of the operation were shown in frontend if they are translated. Otherwise default language were used. In search form (type, categories), only translated values are shown. If those properties are not translated, then they won't be shown in the form.

Update to 5.0.0
===============

TYPO3 10 compatibility.

Update to 4.0.0
===============

Complete refactoring of the templates to prepare it for using with the TYPO3 Site Package for `fire department <https://extensions.typo3.org/extension/fire_department>`_. With this package all views becomes default styles. Check frontend views.

Update to 3.2.2
===============

Fix error if concatenation for JS and CSS files is activated in TYPO3.

Update to 3.2.0
===============

Categories
^^^^^^^^^^

Now you can use categories to organize your operations. With those feature you can create a structure with a main fire department and sub departments. Show only operations from the main department or a single sub department in frontend.

There is only a **flat** category handling. That means, if you select a category, no child categories are respected. Only the selected category.
Set a root category in PageTS-Config to restrict the displayed categories in operation plugin in backend.

.. code-block:: typoscript

    tx_operations {
        categoryRootId = 4
    }

Additional link field on vehicles and resources
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

You can define new link targets for every single vehicles or resources data. Maybe another page in your project or an external link. By default it will be respected in list view of vehicles and resources and in that short list in the operation single view.

Some little bugfixes, code improvements.

Update to 3.1.0
===============

Some little bugfixes. Add a new plugin to display statistics in frontend.

Update to 3.0.0 from a version below
====================================

Setting for storagePid (sysfolder)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Configuring the storagePid has changed. The old flexform setting `storageFolder` is not longer used. The TypoScript setting `persistence.storagePid` is the proper setting. In plugin element the core feature "Record storage Page [pages]" is used to override those setting in TypoScript. Now it's working correct with an general storagePid in TypoScript setup and overriding those value on a special page with the plugin setting. If you use the RecordStoragePage field in plugin element, the recursive setting from plugin is active. If not, then the recursive setting from TypoScript is active.

.. code-block:: typoscript

    plugin.tx_operations {
        persistence {
            storagePid = 99
            recursive = 2
        }
    }

It's recommend to set this in constant editor, not directly in TypoScript setup.


Settings for images
^^^^^^^^^^^^^^^^^^^

Many settings for images are changed into `media` settings. They are renamed as follows::

    settings.listImgWidth -> settings.listMediaWidth
    settings.showImgInList -> settings.showMediaInList

Have a look at the new TypoScript setup in `configuration/TypoScript/setup.txt`.

Database migration for images to media
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Please backup your database before execute the following commands! There is no warranty for correct working!

.. code-block:: sql
    :linenos:

    UPDATE tx_operations_domain_model_operation LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_operation.uid AND sys_file_reference.tablenames='tx_operations_domain_model_operation' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_operation.media=tx_operations_domain_model_operation.image, tx_operations_domain_model_operation.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_operation.image > 0;

    UPDATE tx_operations_domain_model_vehicle LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_vehicle.uid AND sys_file_reference.tablenames='tx_operations_domain_model_vehicle' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_vehicle.media=tx_operations_domain_model_vehicle.image, tx_operations_domain_model_vehicle.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_vehicle.image > 0;

    UPDATE tx_operations_domain_model_resource LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_resource.uid AND sys_file_reference.tablenames='tx_operations_domain_model_resource' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_resource.media=tx_operations_domain_model_resource.image, tx_operations_domain_model_resource.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_resource.image > 0;


Detailed changelog with git log
===============================

Clone the github repository and use following command to get a detailed list of the commits. Replace the version number in the command (2.0.2) with the number of version you are using before updating.

`git log 2.0.2..HEAD --abbrev-commit --pretty='%ad %s (Commit %h by %an)' --date=short`

Replace the word *HEAD* with another version, if you want to see the commits between this two versions.

.. tip::

    I try to mark commits with breaking changes with [!!!]. That will help to inform you about problems after updating `operations`.

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _changelog:

=========
Changelog
=========

Update to 3.2.0
===============

Now you can use categories to organize your operations. With those feature you can create a structure with a main fire department and sub departments. Show only operations from the main department or a single sub department in frontend.

There is only a **flat** category handling. That means, if you select a category, no child categories are respected. Only the selected category.
Set a root category in PageTS-Config to restrict the displayed categories in operation plugin in backend.

.. code-block:: typoscript

    tx_operations {
        categoryRootId = 4
    }

You can define new link targets for every single vehicles or resources data. Maybe another page in your project or an external link. By default it will be respected in list view of vehicles and resources and in that short list in the operation single view.

Some little bugfixes, code improvements.

Update to 3.1.0
====================================

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

See at the Migration page in documentation. :ref:`migration`


Detailed changelog with git log
===============================

Clone the github repository and use following command to get a detailed list of the commits. Replace the version number in the command (2.0.2) with the number of version you are using before updating.

`git log 2.0.2..HEAD --abbrev-commit --pretty='%ad %s (Commit %h by %an)' --date=short`

Replace the word *HEAD* with another version, if you want to see the commits between this two versions.

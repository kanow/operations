.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _changelog:

=========
Changelog
=========

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

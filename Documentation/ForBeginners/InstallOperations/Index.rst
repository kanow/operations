.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _installoperations:

=====================
Installing operations
=====================

You can install `operations` in various ways.

The installation with composer is the preferred way for modern TYPO3 Installations. I described this already in
:ref:`Installation <installation>` chapter.

.. tip::

   You find detailed information about installing extensions with composer here in
   TYPO3 documentation :ref:`Getting Started <t3start:extensions_management>`.


Install operations by downloading it in Extension Manager
=========================================================

Most of the beginners in TYPO3 are not familiar with Composer and using the backend for it. Therefore I want to
describe how to install `operations` with Extension Manager in backend.

.. rst-class:: bignums

1. Go to :guilabel:`"ADMIN TOOLS" > "Extensions"`

   .. image:: /Images/Backend/admintools-extensions.png
      :alt: Screen of AdminTools
      :class: with-shadow


2. In the Docheader, select :guilabel:`"Get Extensions"`

   .. image:: /Images/Backend/get-extensions.png
      :alt: Screen of Dropdown in Extensions Manager
      :class: with-shadow


3. Click :guilabel:`"Update now"` The button is on the top right.

   .. image:: /Images/Backend/update-now.png
      :alt: Update Button in Extensions Manager
      :class: with-shadow

4. Enter the name of the extension (operations) in the search field

   .. image:: /Images/Backend/searchfield.png
      :alt: Searchfield in Extensions Manager
      :class: with-shadow

5. Click on :guilabel:`"Go"`

   .. image:: /Images/Backend/searchfield-go.png
      :alt: Searchfield in Extensions Manager with search button
      :class: with-shadow

6. Click on the Action icon on the left for the extension :guilabel:`"Import and Install"`

   .. image:: /Images/Backend/import.png
      :alt: Import Button in Extensions Manager
      :class: with-shadow

   |

   Now the extension is installed, but not activated. To activate it:

7. Choose :guilabel:`"Installed Extensions"` in the Docheader

   .. image:: /Images/Backend/installed-extensions.png
      :alt: Screen of Dropdown in Extensions Manager
      :class: with-shadow

8. Click on the icon with a :guilabel:`"+"` sign for your extension in the :guilabel:`"A/D"` column.

   .. image:: /Images/Backend/activate.png
      :alt: Button Activate in Extensions Manager
      :class: with-shadow

**Now you have installed operations successfully.**

Install operations after downloading the zip file
=================================================

Many users are download `operations` directly from `TER <https://extensions.typo3.org/extension/operations>`__.
Therefore I described here the manually upload too.

.. rst-class:: bignums

1. Go to :guilabel:`"ADMIN TOOLS" > "Extensions"`

   .. image:: /Images/Backend/admintools-extensions.png
      :alt: Screen of AdminTools
      :class: with-shadow

2. Click the small icon in the Docheader to open the upload form

   .. image:: /Images/Backend/upload.png
      :alt: Upload button in Extensions Manager
      :class: with-shadow

   |

   .. image:: /Images/Backend/choose-file.png
      :alt: Upload form in Extensions Manager
      :class: with-shadow

3. After uploading the file you have to activate it. It's the same step as described already before in step 8.


The next steps are to load and configure the TypoScript. That is necessary to get `operations` working.

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _fluid-template-files:

==============================
Eigene Template Dateien nutzen
==============================


Falls ihr Änderungen an den Template Dateien vornehmen wollt, kopiert einfach
die Dateien welche ihr bearbeiten wollt in euer eigenes
:ref:`Site Package <t3tmsa:tmsa-Sitepackages>`. Beachtet dabei, dass die
Ordnerstruktur beibehalten werden muss. Hier gibt es dazu einige Erklärungen:
:ref:`Fluid Templates <t3sitepackage:fluid-templates>`.

Je nachdem welche Dateien ihr auslagern wollt, braucht ihr einen oder alle
drei der folgenden Ordner.

*Layouts*, *Templates* und *Partials*

Die Struktur wird euch in der Extension im Ordner ``Resources/Private``
vorgegeben

* ``Resources/Private/Layouts``
* ``Resources/Private/Templates``
* ``Resources/Private/Partials``

Ihr müsst nicht alle Dateien kopieren, kopiert einfach nur die,
die ihr ändern wollt.

.. note::

   Wenn ihr Dateien aus Unterordnern kopiert, müssen diese Unterordner auch in
   eurem Site Package vorhanden sein.
   Das heißt, die Datei ``Templates/Operation/List.html`` muss auch in einen
   Ordner ``Operation`` unterhalb von eurem Ordner ``Templates`` kopiert werden.

Dann müsst ihr noch in den Konstanten die neue Pfade zu euren Templates angeben.
Das macht ihr am besten auch in eurem
:ref:`Site Package <t3tmsa:tmsa-Sitepackages>` oder im
:ref:`Konstanten Editor <t3tsref:constant-editor>` im TYPO3 Backend.
Auf diese Weise könnt ihr einzelne Dateien ändern und habt bei Updates
wahrscheinlich weniger anzupassen.

Pfade in den TypoScript Konstanten anpassen
"""""""""""""""""""""""""""""""""""""""""""
Hier ein Beispiel TypoScript um im Feld  **Konstanten** die Pfade zu ändern:

.. code-block:: typoscript

   plugin.tx_operations {
           view {
                   templateRootPath = EXT:your_site_package/Resources/Private/Extensions/operations/Templates/
                   partialRootPath = EXT:your_site_package/Resources/Private/Extensions/operations/Partials/
                   layoutRootPath = EXT:your_site_package/Resources/Private/Extensions/operations/Layouts/
           }
   }

.. tip::

   Einige Einstellungen sollten in der Datenbank gesetzt sein und andere nicht.
   Beispiel: :typoscript:`storagePid` setzt man besser in der Datenbank, aber
   :typoscript:`itemsPerPage` ist eher eine generelle Einstellung, die in
   verschiedenen Umgebungen verwendet werden kann.
   Sie ist unabhängig von der Datenbank (z.Bsp. verschiedene Seiten/uids)

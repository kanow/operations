.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _typoscript-configuration:

========================
TypoScript Konfiguration
========================


Statisches TypoScript einbinden
===============================

Die Extension bringt eine TypoScript Konfiguration mit. Damit euer TYPO3 die Einstellungen auch kennt, müsst ihr
das TypoScript einbinden.
TypoScript könnt ihr auf verschiedene Arten einbinden. Die empfohlene Variante für die Einbindung von TypoScript aus
Extensions ist in einem Site Package. Wie das geht ist hier beschrieben: :ref:`TypoScript von Extensions im Site Package <t3sitepackage:typoscript-configuration>`


Ein anderer möglicher Weg, so wurde das früher einmal gemacht, ist die Einbindung im Root-TS Template in der Danbank
eurer Seite. Dazu wären die folgenden Schritte nötig:

#. Wählt im Seitenbaum die Seite auf der sich euer Root-TS Template befindet

#. Wechselt links bei den Modulen auf das Modul **Template** und wählt dann oberhalb im Dropdown *Info/Bearbeiten* aus

#. Über den Button **Vollständigen Template-Datensatz bearbeiten** kommt ihr in die Bearbeitungsmaske für den Template-Datensatz. Dort müsst ihr zum Reiter *Enthält* wechseln, wenn ihr da nicht schon seid

#. Jetzt könnt ihr bei dem Feld *Statische Templates einschließen (aus Erweiterungen)* in der rechten Box **Operations (operations)** auswählen

.. figure:: ../../Images/IncludeTs.png
   :class: with-shadow
   :alt: Include static TypoScript

   Statisches TypoScript aus der Extension einfügen



TypoScript Beispiel
===================

Wenn ihr Einstellungen überschreiben wollt, die nicht in Konstanten einstellbar sind, ist hier ist ein kleines Beispiel wie man die Einstellungen der Extension überschreiben kann.

.. code-block:: typoscript

    plugin.tx_operations.settings {
        # Beispiel um die Zeichenanzahl des Teasertextes zu überschreiben
        cropTeaser = 200
        single {
            # oder hier in der Einzelansicht keinen Bericht anzuzeigen
            showNoReport = 1
        }
    }

.. note::

   Fügt eure eigenen Einstellungen bei Bedarf einfach hinzu. Später könnt ihr diese dann in den Fluid-Templates abfragen.

.. important::

   Wichtig dabei ist, das euer TypoScript **nach** dem TypoScript der Extensions eingebunden wird.

.. _own-template-files:

Eigene Template Dateien nutzen
==============================


Falls ihr Änderungen an den Template Dateien vornehmen wollt, kopiert einfach die Dateien welche ihr bearbeiten wollt in euer eigenes :ref:`Site Package <t3tmsa:tmsa-Sitepackages>`. Beachtet dabei, dass die Ordnerstruktur beibehalten werden muss. Hier gibt es dazu einige Erklärungen: :ref:`Fluid Templates <t3sitepackage:fluid-templates>`.

Je nachdem welche Dateien ihr auslagern wollt, braucht ihr einen oder alle drei der folgenden Ordner.

*Layouts*, *Templates* oder *Partials*

Die Struktur wird euch in der Extension im Ordner *Resources/Private* vorgegeben

* Resources/Private/Layouts
* Resources/Private/Templates
* Resources/Private/Partials

Ihr müsst nicht alle Dateien kopieren, einfach nur die die ihr ändern wollt.

.. important::

   Wenn ihr Dateien aus Unterordnern kopiert, müssen diese Unterordner auch in eurem Site Package vorhanden sein.
   Das heißt, die Datei `Templates\Operation\List.html` muss auch in einen Ordner `Operation` unterhalb von `Templates` kopiert werden.


Dann müsst ihr noch in den Konstanten die neue Pfade zu euren Templates angeben. Das macht ihr am besten auch in eurem :ref:`Site Package <t3tmsa:tmsa-Sitepackages>` oder im Konstanten Editor im TYPO3 Backend.
Auf diese Weise könnt ihr einzelne Dateien ändern und habt bei Updates wahrscheinlich weniger anzupassen.

Pfade in den TypoScript Konstanten anpassen
"""""""""""""""""""""""""""""""""""""""""""
Hier das TypoScript um im Feld  **Konstanten** die Pfade zu ändern:

.. code-block:: typoscript

   plugin.tx_operations {
           view {
                   templateRootPath = EXT:your_site_package/Resources/Private/Extensions/operations/Templates/
                   partialRootPath = EXT:your_site_package/Resources/Private/Extensions/operations/Partials/
                   layoutRootPath = EXT:your_site_package/Resources/Private/Extensions/operations/Layouts/
           }
   }

Es ist empfohlen diese Konstanten im :ref:`Site Package <t3tmsa:tmsa-Sitepackages>` zu setzen.

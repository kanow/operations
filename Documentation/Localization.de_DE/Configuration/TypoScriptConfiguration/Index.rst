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

Die Extension bringt einiges an TypoScript Konfiguration mit. Damit euer TYPO3 die Einstellungen auch kennt, müsst ihr
das TypoScript einbinden. Ein möglicher Weg ist die Einbindung im Root-TS Template eurer Seite.

#. Wählt die Seite auf der sich euer Root-TS Template befindet

#. Wechselt links bei den Modulen auf das Modul **Template** wählt oberhalb im Dropdown *Info/Bearbeiten* aus

#. Über den Button **Vollständigen Template-Datensatz bearbeiten** kommt ihr in die Bearbeitungsmaske für den Template-Datensatz. Dort müsst ihr zum Reiter *Enthält* wechseln, wenn ihr da nicht schon seid

#. Jetzt könnt ihr bei dem Feld *Statische Templates einschließen (aus Erweiterungen)* in der rechten Box **Operations (operations)** auswählen

.. figure:: ../../Images/IncludeTs.png
   :class: with-shadow
   :alt: Include static TypoScript

   Statisches TypoScript aus der Extension einfügen



TypoScript Beispiel
===================

Wenn ihr Einstellungen überschreiben wollt, die nicht in Konstanten einstellbar sind, ist hier ist ein kleines Beispiel wie man die Einstellungen der Extension überschreiben oder auch neue Einstellungen hinzufügen kann. Später kann man diese dann in den Fluid-Templates auch abfragen.

.. code-block:: typoscript

    plugin.tx_operations.settings {
        # Beispiel um die Zeichenanzahl des Teasertextes zu überschreiben
        cropTeaser = 200
        single {
            # oder hier in der Einzelansicht keinen Bericht anzuzeigen
            showNoReport = 1
        }
    }

Dieses TypoScript könnt ihr irgendwo in euren TS-Templates unterbringen. Wichtig dabei ist, das eure TS-Templates nach dem Statischen TypoScript der Extensions eingebunden werden.

.. _own-template-files:

Eigene Template Datein nutzen
=============================


Ihr könnt eure eigenen Templates nutzen. Kopiert dazu einf

Je nachdem welche Dateien ihr auslagern wollt, braucht ihr einen oder alle drei der folgenden Ordner.

 *Layouts*, *Templates* and *Partials*

Die Struktur wird euch in der Extension im Ordner *Resources/Private* vorgegeben

* Resources/Private/Layouts
* Resources/Private/Templates
* Resources/Private/Partials

Ihr müsst nicht alle Dateien kopieren, einfach nur die die ihr ändern wollt. Nur auf die Ordnerstruktur achten.
Dann müsst ihr in den Konstanten die neue Pfade zu euren Templates angeben. Das macht ihr am besten im Konstanten Editor im TYPO3 Backend. Aber natürlich könnt ihr es auch an jeder anderen Stelle tun, an der man in TYPO3 Konstanten bearbeiten kann.

Pfade in den TypoScript Konstanten anpassen
"""""""""""""""""""""""""""""""""""""""""""
Hier das TypoScript um im Feld  **Konstanten** im Backend Datensatz die Pfade zu ändern:

.. code-block:: typoscript

   plugin.tx_operations {
           view {
                   templateRootPath = fileadmin/templates/ext/operations/Templates/
                   partialRootPath = fileadmin/templates/ext/operations/Partials/
                   layoutRootPath = fileadmin/templates/ext/operations/Layouts/
           }
   }

Im Beispiel liegen die neuen Pfade im fileadmin. Mittlerweile ist das aber nicht mehr der empfohlene Weg. Heutzutage ist das empfohlene Vorgehen eine entsprechend aufbereitete Extension für ein SitePackage oder Theme. Dort gibt sollten solche Templatedateien hin ausgelagert werden. Als Pafd könnte dann soetwas stehen: *EXT:site_package/Resources/Private/Extensions/Operations/Templates/*

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

Die Extension bringt eine TypoScript Konfiguration mit. Damit euer TYPO3 die
Einstellungen auch kennt, müsst ihr das TypoScript einbinden.
TypoScript könnt ihr auf verschiedene Arten einbinden. Die empfohlene Variante
für die Einbindung von TypoScript aus Extensions ist in einem Site Package.
Wie das geht ist hier beschrieben: :ref:`TypoScript von Extensions im Site Package <t3sitepackage:typoscript-configuration>`


Ein anderer möglicher Weg, so wurde das früher einmal gemacht, ist die
Einbindung im Root-TS Template in der Datenbank eurer Seite. Dazu wären die
folgenden Schritte nötig:

#. Wählt im Seitenbaum die Seite auf der sich euer Root-TS Template befindet

#. Wechselt links bei den Modulen auf das Modul **Template** und wählt dann oberhalb im Dropdown *Info/Bearbeiten* aus

#. Über den Button **Vollständigen Template-Datensatz bearbeiten** kommt ihr in die Bearbeitungsmaske für den Template-Datensatz. Dort müsst ihr zum Reiter *Enthält* wechseln, wenn ihr da nicht schon seid

#. Jetzt könnt ihr bei dem Feld *Statische Templates einschließen (aus Erweiterungen)* in der rechten Box **Operations (operations)** auswählen

.. figure:: ../../Images/IncludeTs.png
   :class: with-shadow
   :alt: Include static TypoScript

   Statisches TypoScript aus der Extension einfügen


Nutzung vom Constant Editor
===========================

Wenn ihr das TypoScript der Extension eingefügt habt, gibt es einige
Einstellungen in dem :ref:`TYPO3 Konstanten Editor <t3tsref:constant-editor>`.
Die meisten wichtigen Einstellungen können hir vorgenommen werden.

Notwendige Einstellungen
------------------------

Um die Extension benutzen zu können sind mindestens diese Einstellungen in der
Kategorie "TX_OPERATIONS-STORAGE-AND-PIDS" vorzunehmen.

.. code-block:: typoscript

    plugin.tx_operations {
      # Hier die Uid von eurem Sys-Ordner mit den Einsatzdaten im Backend angeben
      persistence.storagePid = 45
      settings {
        # Hier die Uid der Einzelansichtsseite für die Einsätze angeben
        operationSinglePid =
        # Hier die Uid der Einzelansichtsseite der Fahrzeuge angeben
        vehicleSinglePid =
        # Hier die Uid der Einzelansichtsseite der Hilfsmittel angeben
        resourceSinglePid =
      }
    }

.. tip::

   Ihr findet die Uid heraus, indem ihr mit dem Mauszeiger über dem Icon
   der jeweiligen Seite im Seitenbaum einen Moment verharrt.

Komplette Liste der TypoScript Einstellungen
============================================

Ihr könnt euch alle verfügbaren TypoScript Einstellungen in folgender Datei anschauen:

``Configuration/TypoScript/setup.typoscript``

Die Einstellungen fangen hier an:

.. code-block:: typoscript

   plugin.tx_operations {
      settings {
         …
      }
   }

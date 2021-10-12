.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _configuration-categories:


==========================
Kategorien in "operations"
==========================

Kategorien nutzen
=================

Ihr könnt Kategorien nutzen um die Einsätzdaten zu strukturieren. Damit lassen sich Dinge wie: Haupt-Feuerwehrwache
und Unter-Feuerwehrwachen abbilden. Durch die Auswahl der verschiedenen Kategorien im Plugin,
könnt ihr die Ausgabe im Frontend für Liste oder die Statistiken entsprechend einschränken.

Wenn ihr keine Kategorien braucht, dann ignoriert sie einfach.

.. important::

   Momentan ist nur eine flache Hierarchie bei den Kategorien möglich. Das heißt, bei der Auswahl
   einer Elternkategorie werden die Kindkategorien nicht berücksichtigt. Es muss wirklich jede
   Kategorie explizit ausgewählt werden, wenn sie berücksichtigt werden soll.

Ihr könnt die ID einer Root-Kategorie im Page-TS festlegen um die Anzeige der Kategorien im Plugin einzuschränken.

.. code-block:: typoscript

    tx_operations {
        categoryRootId = 4
    }

.. tip::

   Stellt eine generelle Root Kategorie ID in den Extension Einstellungen ein und nutzt
   die Einstellung im Seiten-TS Config um die Anzeige innerhalb des Seitenbaums
   (auf verschiedenen Seiten) unterschiedlich zu gestalten.


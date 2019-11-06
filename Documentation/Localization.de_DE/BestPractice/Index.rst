.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _bestPractice:
.. _forge: http://forge.typo3.org/projects/extension-operations


Empfehlungen
============


Benutzt Kategorien
^^^^^^^^^^^^^^^^^
Ihr könnt Kategorien nutzen um die Einsätze zu strukturieren. Damit lassen sich Dinge wie: Haupt-Feuerwehrwache und Unter-Feuerwehrwachen abbilden. durch die Auswahl der verschiedenen Kategorien im Plugin, könnt ihr die Ausgabe im Frontend entsprechend anpassen.

wenn ihr keine Kategorien braucht, dann ignoriert sie einfach.

.. important::

    Momentan ist nur eine flache Hierarchie bei den Kategorien möglich. Das heißt, bei der Auswahl einer Elternkategorie werden die Kindkategorien nicht berücksichtigt. Es muss wirklich jede Kategorie explizit ausgewählt werden, wenn sie berücksichtigt werden soll.

Ihr könnt die ID einer Root-Kategorie im Page-TS festlegen um die Anzeige der Kategorien im Plugin einzuschränken.

.. code-block:: typoscript

    tx_operations {
        categoryRootId = 4
    }

.. tip::

    Ihr könnt verschiedenen Root-Kategorien setzen, um die Anzeige innerhalb des Seitenbaums (auf verschiedenen Seiten) unterschiedlich zu gestalten.

.. tip::

    Kategorien können auch bei den Statistiken verwendet werden!

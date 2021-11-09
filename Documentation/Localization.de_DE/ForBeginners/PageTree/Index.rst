.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _pagetree:

======================
Empfohlener Seitenbaum
======================

Hier hab ich für euch ein Beispiel für einen Seitenbaum einer Feuerwehr Webseite.
Das ist nur ein Vorschlag den ihr nutzen könnt falls ihr überhaupt keine Idee habt wie ihr anfangen sollt.
Den könnt ihr natürlich an eure Anforderungen anpassen. Für `operations` solltet ihr aber mindestens einen
SysOrdner für die Einsatzdaten sowie eine List- und Einzelansicht für die Einsätze haben.

Der News/Meldungen Ordner hier ist einfach nur in meiner Entwicklungsumgebung enthalten und für den laufenden
Betrieb von `operations` nicht notwendig.

Ihr solltet den Seitenbaum anlegen bevor ihr mit der TypoScript Konfiguration beginnt. Oft braucht ihr
Uid Angaben von Seiten die wichtig sind und die ihr dann eventuell erst einmal anlegen müsst.
Das macht es unnötig kompliziert.

.. image:: /Images/Backend/pagetree.png
   :alt: Example page tree for a firefighter website with operations
   :class: with-shadow

.. note::

   Die Seiten für die Einzelansichten sollten nicht im Menü zu sehen sein. Das könnt ihr mit der
   Einstellung "Seite in Menüs aktiviert" steuern. Deaktiviert diese einfach.


.. image:: /Images/Backend/disable-pageinmenu.png
   :alt: Switch to disable page in menu
   :class: with-shadow

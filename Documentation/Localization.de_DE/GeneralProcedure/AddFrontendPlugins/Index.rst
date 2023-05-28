.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _addfrontendplugins:

=======================
Inhaltselemente anlegen
=======================

Ok, jetzt seid ihr fast fertig mit den Vorbereitungen im Backend.
Der letzte Schritt ist jetzt noch die Inhalte für die Ausgabe im Frontend
anzulegen.

.. note:

   In älteren TYPO3 Versionen waren das noch Plugins mit verschiedenen
   Ansichten. In aktuellen TYPO3 Versionen Aktuell gibt es ein Inhaltselement
   für jede Ansicht.


`operations` bringt verschiedene neue Inhaltstypen mit.

Für die Einsätze, Hilfsmittel und Fahrzeuge gibt es jeweils eine Listen- und
eine Einzelansicht. Die machen genau das was sie sagen. Ihr könnt damit einfach die entsprechenden Ansicht anlegen.

Das "Einsätze Statistiken Ansicht" Inhaltselement zeigt euch die Statistiken der Einsätze gruppiert nach Jahr und Einsatzart an.

Ok, jetzt gehts los.

.. rst-class:: bignums

1. Wählt links bei den Modulen das Modul the :guilabel:`"Web" > "Seite"` aus und wählt danach im Seitenbaum
   die Seite für euer Inhaltselement aus. Legt ein neues Inhaltselement an.

   .. image:: /Images/Backend/create-content.png
      :alt: Button für das Anlegen neuer Inhalte
      :class: with-shadow

2. Geht zum Reiter "Einsatzverwaltung" in dem öffnenden Fenster und wählt aus den Einträgen den gewünschten Inhaltstyp aus.

   .. image:: /Images/Backend/newcontent-plugins.png
      :alt: Neues Plugins erstellen
      :class: with-shadow

3. Geht jetzt im Inhaltselement zum Reiter "Plugin" und nehmt ggf.
gewünschte Einstellungen für das Element vor.

   .. image:: /Images/Backend/switchablecontrolleractions.png
      :alt: Feld für Switchable Controller Actions
      :class: with-shadow

   |


Wiederholt diese Schritte für jedes weitere im Frontend benötigte
Inhaltselement.

.. tip::

   Nutzt Standard Einstellungen im TypoScript und dann die Einstellungen in
   den Plugins um diese Standardeinstellungen im Einzelfall zu überschreiben.


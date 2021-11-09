.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _addfrontendplugins:

========================
Frontend Plugins anlegen
========================

Ok, jetzt seid ihr fats fertig mit den Vorbereitungen im Backend.
Der letzte Schritt ist jetzt noch die Frontend Plugins anzulegen.

`operations` kommt mit 2 Frontend Plugins. Eins ist "Einsatzverwaltung" und das andere "Einsatzverwaltung Statistiken".
Das seht ihr im Feld "Ausgewähltes Plugin" in eurem Inhaltselement. Momentan steht da noch nicht die Übersetzung ;-).

Das "Einsatzverwaltungs" Plugin zeigt die List- und Einzelansichten der Einsätze, Hilfsmittel oder Fahrzeuge im
Frontend. Die unterschiedlichen Ansichten werden über sogenannte `Switchable Controller Actions` gesteuert.
Das ist das Feld "Anzeigen von" im Reiter "Plugin". Das wird sich in der Zukunft ändern aber momentan läuft
das noch genau so.

Das "Einsatzverwaltung Statistiken" Plugin zeigt euch die Statistiken der Einsätze gruppiert nach Jahr und Einsatzart.

Ok, jetzt gehts los.

.. rst-class:: bignums

1. Wählt links bei den Modulen das Modul the :guilabel:`"Web" > "Seite"` aus und wählt danach im Seitenbaum
   die Seite für euer Inhaltselement aus. Legt ein neues Inhaltselement an.

   .. image:: /Images/Backend/create-content.png
      :alt: The button to create new content elements
      :class: with-shadow

2. Geht zum Reiter "Plugins" in dem öffnenden Fenster und wählt aus den Einträgen das gewünschte Einsatzplugin aus.

   .. image:: /Images/Backend/newcontent-plugins.png
      :alt: The button to create new content elements
      :class: with-shadow

3. Geht jetzt im Inhaltselement wieder zum Reiter "Plugin" (sollte schon angewählt sein)
   wählt die gewünschte Ansicht im Feld "Anzeigen von" (the Switchable Controller Action) aus.

   .. image:: /Images/Backend/switchablecontrolleractions.png
      :alt: Field for Switchable Controller Actions
      :class: with-shadow

   |

   Jetzt könnt ihr die notwendigen Einstellungen im Plugin vornehmen. Das habe ich hier
   :ref:`Configuration <plugin-configuration>` beschrieben.
   Wiederholt das für alle weiteren im Frontend benötigten Plugins.

.. tip::

   Nutzt Standard Einstellungen im TypoScript und die Einstellungen in den Plugins um diese im
   Einzelfall zu überschreiben.


.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt

.. _plugin-statistics:

==========================
Statistiken  Konfiguration
==========================


Einsatzstatistik(en) anzeigen
=============================

Erstellt einfach ein neues Inhaltselement vom Typ
"Einstzverwaltung Statistiken".
Wenn ihr wollt, könnt ihr noch eine Kategorieauswahl vornehmen und ihr solltet
die Anzahl der zurückliegenden Jahre einstellen.
Ich gehe davon aus, dass die Einstellungen für den SysOrdner mit den
Einsatzdaten im TypoScript bereits gesetzt wurde.
Wenn nicht, müsste ihr das natürlich auch noch im Plugin einstellen.

Das Plugin zeigt euch im Frontend eine Statistik der Einsätze gruppiert nach
Jahr und Typ.

Die Einstellung "letzte Jahre" legt fest, wieviele Jahre rückwirkend für die
Statistik genutzt werden sollen.
Es ist die gleiche Einstellung wie bei der normalen Listenansicht.
Jahre in denen keine Einsätze stattfanden, werden ignoriert und nicht mit
ausgegeben.

JavaScript für Statistiken anpassen
===================================

Wenn ihr die Statistiken anpassen wollt, könnt ihr das mit einem eigenen JavaScript machen. Kopiert dazu die
Templatedatei ``Resources/Private/Templates/Operation/Statistics.html`` an einen Ort eurer Wahl
und passt den Pfad für das JavaScript hier an:

.. code-block:: html

    <f:section name="FooterAssets">
        <!-- chart library -->
        <script src="{f:uri.resource(path: 'Js/Chart.bundle.js')}"></script>
        <!-- change path to your own js file if you need -->
        <script src="{f:uri.resource(path: 'Js/MyChart.js')}"></script>
    </f:section>

Am besten nutzt ihr dafür ein eigenes :ref:`Site Package / Theme Extension <t3start:creating-a-site-package>`.

Ändert dann die Templatepfade wie hier beschrieben :ref:`Templates <fluid-template-files>` .


.. attention::

   Bitte nicht diese Tabelle mit den Daten aus dem Template entfernen!
   :html:`<table data-chart="operationsChart-{contentObjectData.uid}"
   class="operationsChart-{contentObjectData.uid} dataset">`
   Diese stellt die Daten für das Diagramm bereit. Wenn die Tabelle nicht
   angezeigt werden soll, blendet sie einfach durch CSS Angaben aus.

.. tip::

   Mit einem kleinen JavaScript kann man einen Umschalter bauen. Der blendet
   dann entweder das Diagramm oder die Tabelle ein. Das ist nützlich für
   Leute mit Sehbehinderungen.

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _thetyposcript:

==============
Das TypoScript
==============

Um die Erweiterung `operations` zu nutzen muss das TypoScript geladen werden. Ich habe das bereits hier in der
Dokumentation beschrieben. :ref:`TypoScript Configuration <typoscript-configuration>`

Hier werde ich das aber ein wenig genauer erklären. Ich hoffe das Einsteiger das dann einfacher verstehen können
und schneller zum Erfolg kommen.

Ich gehe davon aus, dass ihr bereits einen Seitenbaum angelegt habt. Falls doch nicht, ist jetzt
der Zeitpunkt einen anzulegen.
Ich habe :ref:`hier <pagetree>` einen Beispiel-Seitenbaum angelegt, wie er in einer Feuerwehr Webseite
genutzt werden könnte.


TypoScript von `operations` in der Datenbank einfügen
=====================================================

.. rst-class:: bignums

1. Wählt im Seitenbaum eure Root Seite aus. Das ist die Seite mit der Weltkugel.

   .. image:: /Images/Backend/rootpage.png
      :alt: Root Seite im Seitenbaum
      :class: with-shadow

2. Wechselt links bei den Modulen zum "Template" Modul

   .. image:: /Images/Backend/template-module.png
      :alt: Template Modul links
      :class: with-shadow

3. In der Auswahlbox oben im Fenster wählt ihr "Info/Bearbeiten"

   .. image:: /Images/Backend/choose-infomodify.png
      :alt: Auswahlbox für TypoScript Template Werkzeuge
      :class: with-shadow

4. Klickt auf den Button "Vollständigen Templatedatensatz bearbeiten"

   .. image:: /Images/Backend/button-wholetemplate.png
      :alt: Button für vollständigen Templatedatensatz bearbeiten
      :class: with-shadow

5. Nun wechselt zum Reiter "Enthält" und wählt dein Eintrag von "Operations" aus

   .. image:: /Images/Backend/include-ts.png
      :alt: TypoScript von operations einfügen
      :class: with-shadow

   |

   .. attention::

      Wenn ihr TypoScript der Extension `operations` in eurem Site Package überschreiben wollt,
      stellt sicher, dass das TypoScript von dem Site Package erst nach dem TypoScript von `operations`
      eingefügt wird. In diesem Fall muss das TypoScript vom "FireDepartment" der letzte Eintrag sein.

6. Speichert die Änderungen und schließt den Templatedatensatz.

.. tip::

   Ihr könnt hinterher den TypoScriptObjectBrowser nutzen um zu prüfen ob das TypoScript erfolgreich eingefügt wurde.

   .. image:: /Images/Backend/tsob.png
      :alt: operations TypoScript angezeigt im TypoScript Object Browser
      :class: with-shadow


Den Konstanten Editor für individuelle Einstellungen nutzen
===========================================================

Es gibt einige Einstellungen die ihr an eure Installation anpassen müsst oder könnt.
Der :ref:`TYPO3 Konstanten Editor <t3tsref:constant-editor>` ist eine einfache Art dies zu tun.
Um ihn zu nutzen wählt links wieder das Modul :guilabel:`"Web" > "Template"` aus, wählt dann danach wieder eure Homepage
aus und wählt oben am Fensterrand in der Auswahlbox den "Konstanten-Editor" aus.

In der Auswahlbox "Kategorie" findet ihr die Einträge für "tx_operations". Wählt sie nacheinander aus und
schaut euch die einzelnen Einstelllungen mal an. Ein paar Voreinstellungen sind dort schon getätigt.
Diese könnt ihr anpassen oder auch erst einmal so lassen.

.. image:: /Images/Backend/tx_operations-constants.png
   :alt: Tx_Operations Konstanten im Konstanten Editor
   :class: with-shadow

|

Alle Konstanten haben eine Beschreibung. So könnt ihr relativ einfach sehen für was sie gut sind.


Benötigte Einstellungen
-----------------------

Um `operations` zu nutzen müsst ihr mindestens diese 4 Einstellungen aus der Kategorie "TX_OPERATIONS-STORAGE-AND-PIDS"

Das sind diese Einstellungen:

.. container:: row m-0 p-0

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: persistence.storagePid

         .. container:: card-body

            Das ist die Uid eures SysOrdners mit den Einsatzdaten.

            .. image:: /Images/Backend/operation-data.png
               :alt: SysOrdner für die Einsatzdaten

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: settings.operationSinglePid

         .. container:: card-body

           Das ist die Uid der Seite für die Einzelansicht der Einsätze.

            .. image:: /Images/Backend/operation-singleviewpage.png
               :alt: Einzelansicht für Einsätze im Seitenbaum

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: settings.vehicleSinglePid

         .. container:: card-body

            Das ist die Uid der Seite für die Einzelansicht der Fahrzeuge.

            .. image:: /Images/Backend/vehicle-singleviewpage.png
               :alt: Einzelansicht für Fahrzeuge im Seitenbaum

   .. container:: col-md-6 pl-0 pr-3 py-3 m-0

      .. container:: card px-0 h-100

         .. rst-class:: card-header h3

            .. rubric:: settings.resourceSinglePid

         .. container:: card-body

            Das ist die Uid der Seite für die Einzelansicht der Hilfsmittel.

            .. image:: /Images/Backend/resource-singleviewpage.png
               :alt: Einzelansicht für Hilfsmittel im Seitenbaum



.. tip::

   Ihr könnt die uid (und andere nützliche Infos) einer Seite oder eines SysOrdners herausfinden
   wenn ihr mit der Maus ein wenig über dem Icon vor dem Text verharrt.

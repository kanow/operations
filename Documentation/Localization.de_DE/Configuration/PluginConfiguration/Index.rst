.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _plugin-configuration:

====================
Plugin Konfiguration
====================

Die meisten wichtigen Einstellungen könnt ihr im Plugin vornehmen. Diese Einstellungen können aber auch über TypoScript
vorgenommen werden. Die Einstellungen im Plugin überschreiben immer Einstellungen die ihr im TypoScript vorgenommen
habt. Dadurch könnt ihr im TypoScript Standards definieren, die ihr in einzelnen Plugins überschreiben könnt.

Plugin Operations (operations_list)
===================================

Reiter "Einstellungen"
""""""""""""""""""""""



.. t3-field-list-table::
 :header-rows: 1

 - :Property:
		Property:
   :View:
		View:
   :Description:
		Description:
   :Key:
		Key:

 - :Property:
		Anzeigen von
   :View:
		Alle
   :Description:
      Auswahl der gewünschten Anzeige. Listen- oder Einzelansicht für Einsätze, Fahrzeuge, Hilfsmittel.
   :Key:

 - :Property:
        Maximale Anzahl Datensätze
   :View:
        Alle
   :Description:
        Wieviel Datensätze sollen maximal ausgegeben werden.
   :Key:
        settings.limit

 - :Property:
        Datensätze pro Seite
   :View:
        Einsätze
   :Description:
        Wieviel Datensätze pro Seite sollen bei aktivierter Blätternavigation angezeigt werden.
   :Key:
        settings.itemsPerPage

 - :Property:
		Alle Ergebnisse auf einer Seite anzeigen
   :View:
		Einsätze
   :Description:
		Zeigt alle ausgegebenern Einsätze in einer Liste an. Die Blätternavigation ist hier deaktiviert. Das Standardlimit liegt hierfür bei 200.
   :Key:
		settings.hidePagination

 - :Property:
		Filter für Ergebnisliste ausblenden
   :View:
		Einsätze
   :Description:
		Blendet das Formular mit der Suche und den verschiedenen Filtermöglichkeiten in der Ergebnisliste aus.
   :Key:
		settings.hideFilter

 - :Property:
		Zeige Liste der Einsätze auf einer Karte
   :View:
		Einsätze
   :Description:
		Statt einer Liste werden die Einsätze auf einer Karte dargestellt. Vorraussetzung hierfür sind allerdings die Geo-Daten (Längen- und Breitengrade) in den Einsatzdaten.
   :Key:
		settings.showMap

 - :Property:
		Datensatzsammlung
   :View:
		Alle
   :Description:
		Seite/Ordner aus dem Seitenbaum wo die Datensätzen angelegt sind
   :Key:
		persistence.storagePid

 - :Property:
		Rekursiv
   :View:
		Alle
   :Description:
		Bestimmt das Level/die Ebenen, wie tief nach unten die Ordner nach Einsatzdaten durchsucht werden sollen.
   :Key:
		persistence.recursive


Reiter "Medieneinstellungen"
""""""""""""""""""""""""""""



.. t3-field-list-table::
 :header-rows: 1

 - :Property:
        Property:
   :View:
        View:
   :Description:
        Description:
   :Key:
        Key:

 - :Property:
        Vorschaubild in der Listenansicht
   :View:
        Alle
   :Description:
        Zeigt das erste Bild des Einsatzes als kleines Vorschaubild in der Listenansicht an.
   :Key:
        settings.showMediaInList

 - :Property:
        Bildgrößen in List- und Einzelansicht
   :View:
        Alle
   :Description:
        Bildgrößenangaben für List- und Einzelansicht.
   :Key:
        settings.listMediaWidth
        settings.listMediaHeight
        settings.singleMediaWidth
        settings.singleMediaHeight


Reiter "Template-Einstellungen"
"""""""""""""""""""""""""""""""

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
        Property:
   :View:
        View:
   :Description:
        Description:
   :Key:
        Key:

 - :Property:
        Template Layout auswählen
   :View:
        Alle
   :Description:
      Hiermit ist es möglich andere Layout Varianten im Fluid Templates nutzen zu können.
      Die Werte müssen vorher im Page TS-Config definiert werden.

      Beispiel Page TS-Config::

         tx_operations.templateLayouts {
             layout1 = Mein extra Layout
         }

   :Key:
        settings.templateLayout

 - :Property:
		Maximale Zeichenanzahl Teasertext in der Listansicht
   :View:
		Alle
   :Description:
		Die maximale Länge / Zeichanzahl des Teasertextes in der Listansicht. Längerer Text wird automatisch gekürzt.
   :Key:
		settings.cropTeaser

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _plugin-configuration:

====================
Plugin Konfiguration
====================

Die meisten wichtigen Einstellungen könnt ihr im Plugin vornehmen. Diese Settings können aber auch über TypoScript vorgenommen werden. Die Einstellungen im Plugin überschreiben immer Einstellungen die ihr im TypoScript vorgenommen habt. Dadurch könnt ihr im TypoScript Standards definieren, die ihr in einzelnen Plugins überschreiben könnt.

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
		All
   :Description:
        `Auswahlmöglichkeiten:`

    - Einsätze: List- oder Einzelansicht
    - Fahrzeuge: List- oder Einzelansicht
    - Hilfsmittel: List- oder Einzelansicht
   :Key:

 - :Property:
        Datensätze pro Seite
   :View:
        Einsätze
   :Description:
        Wieviel Datensätze sollen angezeigt werden. Wenn die Seitenavigation ausgeblendet ist, wird hiermit die Zahl der maximal anzuzeigenden Einsätze eingestellt.
   :Key:
        settings.itemsPerPage

 - :Property:
		Alle Ergebnisse auf einer Seite anzeigen
   :View:
		Operations
   :Description:
		Zeigt alle vorhandenen oder per Limit begrenzte Einsätze in der Liste an. Eine Seitennavigation wird hier nicht angezeigt. Das Standardlimit, wenn keines gesetzt ist, liegt bei 200.
   :Key:
		settings.hidePagination

 - :Property:
		Filter für Ergebnisliste ausblenden
   :View:
		Operations
   :Description:
		Blendet das Formular mit der Suche und den verschiedenen Filtermöglichkeiten in der Ergebnisliste aus.
   :Key:
		settings.hideFilter

 - :Property:
		Zeige Liste der Einsätze auf einer Karte
   :View:
		Operations
   :Description:
		Statt einer Liste werden die einsätze auf einer Karte dargestellt. Vorraussetzung hierfür sind allerdings die Geo-Daten (Längen- und Breitengrade) in den Einsatzdaten.
   :Key:
		settings.showMap

 - :Property:
		Datensatzsammlung
   :View:
		All
   :Description:
		Sysordner mit Datensätzen
   :Key:
		persistence.storagePid

 - :Property:
		Rekursiv
   :View:
		All
   :Description:
		Bestimmt das Level/die Ebenen, wie tief nach unten die Ordner nach Einsatzdaten durchsucht werden sollen. Damit kann man einen Hauptdatenordner für die Einsätze erstellen und mit Unterordnern weitere Unterscheidungen vornehmen.
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
        Operations
   :Description:
        Zeigt das erste Bild des Einsatzes als kleines Vorschaubild in der Listenansicht
   :Key:
        settings.showMediaInList

 - :Property:
        Bildgrößen in List- und Einzelansicht
   :View:
        All
   :Description:
        Bildgrößenangaben für List- und Einzelansicht bei Bedarf ändern.
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
        Template Auswahlfeld
   :View:
        All
   :Description:
        Werte müssen vorher im Page TS-Config definiert werden.

        Beispiel Page TS-Config::

            tx_operations.templateLayouts {
                layout1 = Mein extra Layout
            }

   :Key:
        settings.templateLayout

 - :Property:
		Maximale Zeichenanzahl Teasertext in der Listansicht
   :View:
		Operations
   :Description:
		Wie es der Titel schon sagt, die maximale Zeichanzahl des Teasertextes in der Listansicht. Wenn der Teaser länger sein sollte, wird der Text automatisch gekürzt.
   :Key:
		settings.cropTeaser

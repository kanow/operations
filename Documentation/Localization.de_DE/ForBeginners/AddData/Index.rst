.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _adddata:

========================
Daten im Backend pflegen
========================

Wenn ihr einen SysOrdner für die Einsatzdaten habt, könnt ihr anfangen diese anzulegen.
Ihr solltet mit den notwendigen Verknüpfungen (Einsatzart, Fahrzeuge, Hilfsmittel) anfangen
da diese bei den Einsätzen später benötigt werden.


.. rst-class:: bignums


1. Geht zum Modul :guilabel:`"Web" > "Liste"` und wählt im Seitenbaum den SysOrdner für die Einsatzdaten aus.

   .. image:: /Images/Backend/sysfolder-operations.png
      :alt: Sysfolder with operations data
      :class: with-shadow

   .. note::

      Ihr braucht die Übersetzung des SysOrdners nur wenn ihr die Webseite mehrsprachig aufbauen wollt und
      die Einsatzdaten übersetzt werden sollen.

   .. important::

      Ohne übersetzten SysOrdner könnt ihr die Einsatzdaten nicht übersetzen!

2. Klickt auf das :guilabel:`"+"` Icon oben am Rand um einen neuen Datensatz anzulegen.

   .. image:: /Images/Backend/button-createnew.png
      :alt: Button to create new data
      :class: with-shadow

3. Jetzt wählt ihr den gewünschten Datensatztyp aus den ihr anlegen wollt.

   .. image:: /Images/Backend/choose-datatype.png
      :alt: List datatypes of operations
      :class: with-shadow

4. Wenn ihr mit Kategorien arbeiten wollt, legt diese auch an.

   .. image:: /Images/Backend/create-category.png
      :alt: Create a new category
      :class: with-shadow

   .. tip::

      Create a root/main category first that is the parent category for all operation categories.
      You can restrict the visibility of categories in frontend plugins and in operation data with the
      setting in Site Configuration.

5. Setzt die Root-Kategorie in eurer SiteConfiguration um die Anzeige der Kategorien in den Datensätzen und
   den Plugins auf die Einsatzkategorien einzuschränken. Wenn ihr noch keine "Site Configuration" habt, erstellt
   eine im :guilabel:`"Seiten Verwaltung" > "Seiten"` Modul.

   .. image:: /Images/Backend/module-siteconfig.png
      :alt: Create a new category
      :class: with-shadow

   .. image:: /Images/Backend/button-addsiteconfiguration.png
      :alt: Button "Add news Site Configuration"
      :class: with-shadow

   |

   Wenn ihr eine neue "Site Configuration" erstellt habt, wurde ein Ordner dafür erstellt.
   Normalerweise ist das im Ordner :file:`<project-root>/config/sites/<identifier>/`.
   Dort findet ihr dann eine Datei namens :file:`config.yaml`.

   .. note::
      Wenn ihr keine Composer basierte Installation habt, befindet sich der config Ordner in :file:`typo3conf/sites`.
      Wenn eure Installation Composer basiert ist, findet ihr den config Ordner in :file:`<project-root>/config/sites`.

   .. tip::
      Fügt diesen Ordner eurer Versionsverwaltung hinzu wenn ihr eine nutzt.

   Öffnet diese Datei mit einem Text-Editor eurer Wahl und fügt das `settings` auf der ersten Ebene mit ein.
   Hier ein paar Zeilen Beispiel Code mit dem extra eingefügten Setting für die Root Kategorie `rootCategory`.

   .. code:: yaml

      rootPageId: 1
      base: 'https://typo3-11.ddev.site/'
      settings:
        operations:
          rootCategory: 2
      ...

   |

   Sicher, man braucht mehr als nur diese paar Zeilen für eine funktionierende "Site Configuration".
   Das soll nur ein Beispiel sein wie und wo ihr zusätzliche Einstellungen mittels der Angabe von `settings`
   dort einfügen könnt.

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _changelog:

==========
Änderungen
==========

Update to 8.0.0
===============

Diese Version bringt TYPO3 12 Kompatibilität mit und behält die Kompatibilität
zu TYPO3 11. `operations` läuft aktuell also mit beiden LTS Versionen von
TYPO3.

Die feste Abhängigkeit zu Georg Ringers `numbered_pagination` wurde aufgelöst,
da es zum aktuellen Zeitpunkt der Entwicklung noch keine 12er kompatible
Version davon gab. Wird es vielleicht auch gar nicht geben, da der TYPO3 Kern
mittlerweile eine eigene Lösung mitbringt.
Für TYPO3 11 Installationen bedeutet dies, dass man sich selbst um die
Installation der `numbered_pagination` kümmern muss.
`operations` wählt abhängig von der TYPO3 Version entweder die
`NumberedPagination` Klasse (wenn vorhanden) oder die neuere `SlidingWindowPagination` aus.
Wenn keins von beiden verfügbar ist, wird dann die `SimplePagination` genutzt.
Im TypoScript gibt es die Möglichkeit diese genutzte Klasse zu überschreiben.

.. code-block:: typoscript

   plugin.tx_operations {
      settings {
         paginate {
            class = Vendor/YourOwn/PaginationClass
         }
      }
   }


Wichtige Änderung
^^^^^^^^^^^^^^^^^

Statt der alten "SwitchableControllerActions" in den Plugins werden jetzt
echte Inhaltselemente verwendet. Es gibt einen "Migrate old plugins"
:ref:`Upgrade Assistenten <t3install:postupgradetasks>` der nach
der Installation ausgeführt werden muss. Damit werden alte Plugins in die
neuen Inhaltselemente umgewandelt. Entsprechende Einstellungen sollten mit
übernommen werden.

Falls die Einzelansicht für der Einsätze nicht auf einer extra Seite, mit der
extra Action dafür genutzt wurde, sind eventuell manuelle Anpassungen nötig.

Update to 7.1.0
===============

*  Vor dem Update gab es immer ein Limit bei den Einsatzdaten. Auch für die Statistiken.
   Das ist da aber eher nicht sinnvoll.
   Jetzt gibt es erstmal kein Limit für die Statistikdaten. Ihr könnte das aber deaktivieren um das alte Verhalten
   wieder zu haben. Deaktiviert das einfach mit dem TypoScript setting `noLimitForStatistics = 0`.

*  Die Extension "numbered_pagination" von Georg Ringer wird jetzt für die Paginierung der Liste verwendet. Die ist
   komfortabler und zeigt nicht immer alle Seiten an sondern nur einen bestimmten Teil. Schaut ins TypoScript
   und nach euren Fluid Templates/Partials für die Änderungen. Die Extension wird bei Composer basierten Installationen
   einfach mit installiert. Bei nicht Composer basierten Installationen müsst ihr die Extension extra installieren.

*  Die Farbe bei der Einsatzart ist nun bei Übersetzungen ausgenommen. Damit ist es nicht mehr notwendig die Farbe
   extra bei der Übersetzung anzugeben.

Update auf 7.0.0
================

Diese Version läuft nur noch unter TYPO3 11. In dieser Version wurden ein paar kleine Bugs behoben und auf verschiedene neue
TYPO3 11 Features umgestellt.

Änderung der Kategorie Verknüpfung
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Die Datenbanktabelle für die Verknüpfungen der Kategorien mit den Einsätzen wurde umgestellt.
Es gibt einen :ref:`Upgrade Wizard <t3install:postupgradetasks>` mit dem ihr die Verknüpfungen automatisch
in die neue Tabelle schreiben könnt.
Es wird jetzt die Tabelle genutzt, die auch von TYPO3 als Standard für MM Verknüpfungen von Kategorien vorgesehen ist.

.. attention::

   Wichtig! Die Tabelle `tx_operations_operation_category_mm` darf nicht entfernt/geleert werden
   bevor der Upgrade Wizard alle Relationen in die neue Tabelle `sys_category_mm` kopiert hat.


Breaking Change
^^^^^^^^^^^^^^^

Die Einstellung in den "Extension Settings" für die ``rootCategory``, bei der ihr die Uid der obersten Kategorie
für die Einsätze angeben konntet, wurde verschoben. Das zugehörige TypoScript Setting, sowie die Möglichkeit
das in den Seiteneigenschaften per Page TS zu setzen wurde komplett entfernt.

Diese Einstellung muss jetzt in der :ref:`Site Configuration <t3coreapi:sitehandling-basics>`
vorgenommen werden. Durch diese Änderung wird einiges an Code eingespart und die neuen Möglichketen
von TYPO3 11 genutzt.

Folgendes muss in eurer :ref:`Site Configuration <t3coreapi:sitehandling-basics>` ergänzt werden:

.. code-block:: yaml

    settings:
     operations:
       rootCategory: 2

Wenn ihr die Standard Template Dateien aus der Extension nutzt, solltet ihr keine weiteren Probleme
durch das Update haben. Hoffe ich zumindest ;-).

Update to 6.x
=============

In dieser Version wurden kleine und große Fehler behoben und Wartungsarbeiten vorgenommen.

Achtung, Breaking Change! Neue Pagination API von TYPO3 wird benutzt. Die alte Fluid Widget Pagination wurde entfernt.

Das TypoScript Setting `maxNumberOfLinks` wird nicht länger benutzt und daher ebenfalls entfernt.
Wenn ihr die Standard Templates von operations benutzt, solltet ihr nichts weiter tun müssen.
Wenn nicht, prüft bitte eure ausgelagerten Templates und führt die Änderungen nach. Folgende Dateien müsst ihr prüfen:

* Resources/Private/Templates/Operation/List.html
* Resources/Private/Templates/Operation/Search.html
* Resources/Private/Partials/List/Pagination.html

Falls ihr die Ausgabe der aktuellen Seite der PAgination in der Url konfiguroert habt müsst ihr diese anpassen.
Das alte @widget Zeug wird nicht mehr genutzt. Schaut einfach mal auf die :ref:`Beispielkonfiguration für schöne Url's<speakingUrl>`.

Das Verhalten bei der Überprüfung der path_segment Felder (slug) wurde umgestellt auf `unique`. Damit kann man jetzt
den Sysordner mit den Daten auch außerhalb seiner Root-Seite haben. Die Einzelansicht funktioniert damit jetzt auch.
Installationen mit mehreren Seiten die sich einen solchen Sysordner teilen hatten bisher ein Problem. Mit einer
aktuellen TYPO3 Version sollte das jetzt alles laufen.
Falls ihr jedoch den anderen Fall braucht, könnt ihr das in der Extension Konfiguration im BE Modul Einstellungen
ändern.

Update to 5.1.0
===============

Fehlerbehebung für eine Exception in der List Ansicht in TYPO3 10 auf.

Die Übersetzungen der Einsätze im Backend zeigen jetzt nur die für eine Übersetzung notwendigen Felder an. Kategorien, Hilfsmittel,
Fahrzeuge, Unterstützung, Koordinaten, Typ, Einsatzleitdienst sind nicht sprachabhängig.

Natürlich können die Datensätze für Kategorien, Hilfsmittel, Fahrzeuge, Unterstützung und Typ selbst weiterhin übersetzt werden. Je nachdem wie die Einstellungen für
`sys_language_mode` und `sys_language_overlay` gesetzt sind, gibt es einen Fallback falls keine Überstezung für die aktueller Sprache existiert.



.. note::
   Beispiel für Einstellungen bezüglich der Sprachen in der Site-Config
    * Standardsprache: deutsch (0), zweite Sprache: english (1)
    * Connected mode für Übersetzungen (Übersetzung hat einen Elterndatensatz)

   .. code-block:: yaml

       fallbackType: strict
       fallbacks: '0,1'

   Mit diesen Einstellungen wird werden die übersetzten Verknüpfungen (Hilfsmittel, Fahrzeuge,…) im Frontend ausgegeben
   wenn sie übersetzt sind. Wenn nicht wird die Standardsprache benutzt.
   Im Suchformular (Typ, Kategorien) werden nur übersetzte Daten angezeigt. Wenn diese Datensätze nicht übersetzt sind,
   werden sie nicht angezeigt.

Update to 5.0.0
===============

TYPO3 10 Kompatibilität.

Update to 4.0.0
===============

Komplettumbau der Template Dateien um das Site-Package `fire department <https://extensions.typo3.org/extension/fire_department>`_ ganz einfach zu nutzen. Damit kann man jetzt einfach Standard-Styles verwenden.


Update auf 3.2.2
================

Behebt einen Fehler wenn Concatenation für JS und CSS Dateien im TYPO3 aktiviert ist.

Update auf 3.2.0
================

Kategorien
^^^^^^^^^^

Ihr könnt nun Kategorien zur Einteilung der Einsatzdaten benutzen. Damit könnt ihr die Einsatzdaten für Haupt- und Unterwachen strukturieren und die Listen auch entsprechend im Frontend ausgeben.

Momentan ist nur eine flache Hierachie bei den Kategorien möglich. Verschachtelungen / Unterkategorien werden bei der Ausgabe nicht beachtet. Das heißt, wenn eine Kategorie im Flexform für die Anzeige ausgewählt ist, kommen nur Einsätze mit dieser Kategorie raus. Zugewiesene Kind-Kategorien haben da keine Auswirkungen.

Ihr habt die Möglichkeit im Page TS-Config eine Root-Kategorie (ID) festzulegen. Damit kann man die Kategorieliste bzw. deren Startpunkt im Flexform des Operation Plugins einschränken.

.. code-block:: typoscript

    tx_operations {
        categoryRootId = 4
    }

Extra Linkfeld bei Fahrzeugen und Hilfsmitteln
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Außerdem kann man jetzt bei den Daten für Fahrzeuge und Hilfsmittel einen extra Link angeben, der die Einzelansicht ersetzen kann. Damit kann man statt der automatischen Verlinkung auf die Fahrzeugeinzelansicht einfach eine andere Seite als Ziel angeben. Auch ein externer Link ist möglich. Die Templates für die Listansicht der Fahrzeuge und Hilfsmittel sowie die kleine Liste in der Einsatz-Einzelansicht wurden dahingehend angepasst.

Und auch in dieser Version kleinere Fehlerbehebungen.

Update auf 3.1.0
================

Kleinere Fehlerbehebungen. Neuer Plugintyp für Statistiken Anzeige im Frontend.

Update auf 3.0.0
================

Änderung der Einstellung für Ordner mit Datensätzen (Sysordner)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Die Konfiguration für den Speicherort/SysOrdner im Backend der Einsatzdaten hat sich geändert. Die alte Einstellung `storageFolder` wir nicht mehr genutzt. Die neue Einstellung  ist: `persistence.storagePid` im TypoScript. Im Plugin stellt ihr nun mit der Standardeinstellung von TYPO3 `Datensatzsammlung` ein. Mit dieser Änderung funktioniert jetzt auch die Überschreibung der Angabe der `storagePid` im TypoScript mit der im Plugin eingestellten Einstellung.
Wenn die Einstellung `Datensatzsammlung` im Plugin genutzt wird, greift auch die Plugin-Einstellung für das Recursive Level.

.. code-block:: typoscript

    plugin.tx_operations {
        persistence {
            storagePid = 99
            recursive = 2
        }
    }

.. tip::

    Setzt diese Einstellung als generelle Einstellung in den Konstanten bzw. im Konstanten Editor von TYPO3.


Änderung der Einstellungen für Bilder
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Einige Einstellungen für Bilder wurden umbenannt in `media`. Sie wurden wie folgt umbenannt::

    settings.listImgWidth -> settings.listMediaWidth
    settings.showImgInList -> settings.showMediaInList

Schaut euch einfach mal das TypoScript in `configuration/TypoScript/setup.txt` an. Dort findet ihr die Änderungen.

Datenbankmigration des Felds `images` nach `media`
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Achtung, bitte unbedingt die Datenbanktabellen von `operations` einmal vorher sichern. Ich übernehme keine Garantie
für die Richtigkeit dieser SQL Anweisungen.

Die nachfolgenden SQL Anweisungen schreiben die Angaben von image nach media in den `operations` Datenbanktabellen
und die Feldnamen in der sys_file_reference Tabelle um.

.. code-block:: sql

    UPDATE tx_operations_domain_model_operation LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_operation.uid AND sys_file_reference.tablenames='tx_operations_domain_model_operation' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_operation.media=tx_operations_domain_model_operation.image, tx_operations_domain_model_operation.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_operation.image > 0;

    UPDATE tx_operations_domain_model_vehicle LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_vehicle.uid AND sys_file_reference.tablenames='tx_operations_domain_model_vehicle' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_vehicle.media=tx_operations_domain_model_vehicle.image, tx_operations_domain_model_vehicle.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_vehicle.image > 0;

    UPDATE tx_operations_domain_model_resource LEFT JOIN sys_file_reference ON sys_file_reference.uid_foreign=tx_operations_domain_model_resource.uid AND sys_file_reference.tablenames='tx_operations_domain_model_resource' AND sys_file_reference.fieldname='image' SET tx_operations_domain_model_resource.media=tx_operations_domain_model_resource.image, tx_operations_domain_model_resource.image=0, sys_file_reference.fieldname='media' WHERE tx_operations_domain_model_resource.image > 0;


Ausführliche Liste mit Hilfe des Git-Logs
=========================================

Klont das Github Repository von 'operations' und nutzt das folgende Kommando um eine Lsite der Commits zu bekommen. Ersetzt die Versionsnummer in dem Beispiel mit der Nummer der Version die ihr momentan benutzt.

`git log 2.0.2..HEAD --abbrev-commit --pretty='%ad %s (Commit %h by %an)' --date=short`

Wenn ihr das Wort *HEAD* mit einer Versionsnummer ersetzt, könnt ihr die Commits zwischen zwei Versionen anzeigen lassen.

.. tip::

    Ich versuche Commits mit "Breaking Changes" immer mit [!!!] zu kennzeichnen. Das hilft bei der Orientierung ob beim Update etwas kaputt gehen kann.

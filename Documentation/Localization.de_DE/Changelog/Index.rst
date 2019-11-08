.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _changelog:

==========
Änderungen
==========

Update auf 3.2.2
================

Behebt einen Fehler wenn Concatenation für JS und CSS Datein im TYPO3 aktiviert ist.

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

Datenbankmigration der `images` nach `media`
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Siehe Seite Migration hier in der Doku :ref:`migration`


Ausführliche Liste mit Hilfe des Git-Logs
=========================================

Klont das Github Repository von 'operations' und nutzt das folgende Kommando um eine Lsite der Commits zu bekommen. Ersetzt die Versionsnummer in dem Beispiel mit der Nummer der Version die ihr momentan benutzt.

`git log 2.0.2..HEAD --abbrev-commit --pretty='%ad %s (Commit %h by %an)' --date=short`

Wenn ihr das Wort *HEAD* mit einer Versionsnummer ersetzt, könnt ihr die Commits zwischen zwei Versionen anzeigen lassen.

.. tip::

    Ich versuche Commits mit "Breaking Changes" immer mit [!!!] zu kennzeichnen. Das hilft bei der Orientierung ob beim Update etwas kaputt gehen kann.

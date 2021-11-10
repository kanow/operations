.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _installoperations:

=======================
Operations installieren
=======================

Es gibt mehrer Möglichkeiten `operations` zu installieren.

Die Installation mit Composer ist die empfohlene Variante für moderne TYPO3 Installationen.
Ich habe das hier :ref:`Installation <installation>` bereits beschrieben.

.. tip::

   Ihr findet mehr Informationen über die Installation mit Composer hier in der TYPO3
   Dokumentation  :ref:`Getting Started <t3start:extensions_management>`.


Operations im Extension Manager installieren
============================================

Die meisten der Einsteiger in TYPO3 kennen sich mit der Composer Installation nicht so gut aus oder sind unsicher.
Daher beschreibe ich hier die Installation von `operations` im Backend mit dem Extension Manager.

.. rst-class:: bignums

1. Geht zu :guilabel:`"Verwaltungswerkzeuge" > "Erweiterungen"`

   .. image:: /Images/Backend/admintools-extensions.png
      :alt: Bildschirmausschnitt der Module: Verwaltungswerkzeuge
      :class: with-shadow


2. Am oberen Fensterrand wählt  :guilabel:`"Erweiterungen hinzufügen"`

   .. image:: /Images/Backend/get-extensions.png
      :alt: Bildschirmausschnitt der Auswahlbox im Extension Manager
      :class: with-shadow


3. Klickt :guilabel:`"Jetzt aktualisieren"` Der Button ist rechts am Rand.

   .. image:: /Images/Backend/update-now.png
      :alt: Jetzt aktualisieren Button im Extensions Manager
      :class: with-shadow

4. Gebt den Namen der Extension (operations) in das Suchfeld ein.

   .. image:: /Images/Backend/searchfield.png
      :alt: Suchfeld für Extensions im Extensions Manager
      :class: with-shadow

5. Klickt auf  :guilabel:`"Absenden"`

   .. image:: /Images/Backend/searchfield-go.png
      :alt: Absenden der Suche im Extensions Manager
      :class: with-shadow

6. Importiert die Extension mit Klick auf das Icon vor dem Extensionname :guilabel:`"Importieren and installieren"`

   .. image:: /Images/Backend/import.png
      :alt: Importieren Button im Extensions Manager
      :class: with-shadow

   |

   Jetzt ist die Extension zwar importiert aber noch nicht aktiviert.

7. Aktiviert die Extension nun. Wählt :guilabel:`"Installierte Erweiterungen"` am oberen Rand in der Auswahlbox.

   .. image:: /Images/Backend/installed-extensions.png
      :alt: Bildschirmausschnitt der Auswahlbox im Extension Manager
      :class: with-shadow

8. Klickt auf das :guilabel:`"+"` Icon in der :guilabel:`"A/D"` Spalte um die Extension zu aktivieren.

   .. image:: /Images/Backend/activate.png
      :alt: Button zum Aktivieren der Extension im Extensions Manager
      :class: with-shadow

**Jetzt habt ihr die Extension erfolgreich installiert.**

Operations installieren nach download einer Zip Datei
=====================================================

Viele User gehen über das TYPO3 Extension Repository `TER <https://extensions.typo3.org/extension/operations>`__
und laden sich die Extension vorher manuell auf ihren Computer herunter um sie dann zu installieren.
Deswegen beschreibe ich auch diese Schritte hier noch.

.. rst-class:: bignums

1. Geht hier auch wieder zu :guilabel:`"Verwaltungswerkzeuge" > "Erweiterungen"`

   .. image:: /Images/Backend/admintools-extensions.png
      :alt: Bildschirmausschnitt der Module: Verwaltungswerkzeuge
      :class: with-shadow

2. Klickt auf das kleine Icon um das Uploadformular zu öffnen und wählt dann die Datei auf eurem Rechner aus.

   .. image:: /Images/Backend/upload.png
      :alt: Button für Upload einer Extension im Extensions Manager
      :class: with-shadow

   |

   .. image:: /Images/Backend/choose-file.png
      :alt: Upload Formular im Extensions Manager
      :class: with-shadow

3.  Nach dem Upload müsst ihr die Extension nur noch installieren. Das geht genauso wie vorher in Schritt 8 beschrieben.

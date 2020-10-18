.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _install:

====================
Operations erweitern
====================

.. note::

   Die Entwicklung von TYPO3 ist ziemlich schnell voran gekommen. Daher sind wahrscheinlich einige
   Angaben im Code unter der aktuellen TYPO3 Version nicht so einfach lauffähig.
   Auch wenn ich diesen Teil der Doku wohl nicht immer auf den aktuellsten Stand bringen kann
   lasse ich das Beispiel hier aber trotzdem drin. So bekommt man eine grobe Vorstellung von dem was notwendig ist.

Es gibt auch eine Beispielextension auf Github mit der man `operations` um ein neues Feld/Eigenschaft erweitern kann.

`extend_operations <https://github.com/kanow/extend_operations>`_

.. note::

    Auch diese Extension ist schon etwas älter und läuft nur unter TYPO3 8, nicht unter der aktuellen TYPO3 Version!
    Sehr wahrscheinlich müsst ihr die Extension anpassen, damit sie unter einem aktuellen TYPO3 läuft.

Wenn euch ein Feld/Eigenschaft fehlt, könnt ihr das mit solch einer Extension nachrüsten.
In dieser Beispielextension wird das Model "operation" (der Einsatz) mit einer zusätzlichen Eigenschaft
"subtitle" (Untertitel) erweitert. Wenn ihr mehr Felder/Eigenschaften braucht könnt ihr natürlich mehr Felder
in der gleichen Art und Weise hinzufügen. Ersetzt "newfield" mit dem Namen eurer neuen Eigenschaft.

Classes/Domain/Model/Operation.php
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Neue Getter und Setter hinzufügen. In der gleichen Art könnt ihr das auch für ein anderes Model tun.

.. code-block:: php

    <?php

	class Operation extends \KN\Operations\Domain\Model\Operation {

        /**
         * newfield
         *
         * @var \string
         */
        protected $newfield;

        /**
         * Returns the newfield
         *
         * @return \string $newfield
         */
        public function getNewfield() {
            return $this->newfield;
        }

        /**
         * Sets the newfield
         *
         * @param \string $newfield
         * @return void
         */
        public function setNewfield($newfield) {
            $this->newfield = $newfield;
        }
    }


Configuration/TCA/Overrides/tx_operations_domain_model_operation.php
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

TCA Konfiguration für die Anzeige der Felder im Backend.

.. code-block:: php

    <?php
    if (!defined ('TYPO3_MODE')) {
        die ('Access denied.');
    }

    use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

    // define new fields
    $tempColumns = array(
        // --- newfield begin ---
        'newfield' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:extend_operations/Resources/Private/Language/locallang_db.xlf:tx_extend_operations_domain_model_operation.newfield',
            'config' => array(
                'type' => 'input',
                'size' => 60,
                'eval' => 'trim'
            ),
        ),
        // --- newfield end ---
    );

    // add all new fields to tca
    ExtensionManagementUtility::addTCAcolumns(
        'tx_operations_domain_model_operation',
        $tempColumns
    );

    // place new field where you need it
    ExtensionManagementUtility::addToAllTCAtypes("tx_operations_domain_model_operation", 'newfield', '', 'after:title');


Resources/Private/Language/locallang_db.xlf
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Locallang Key für die Übersetzungen der Feldnamen im Backend.

.. code-block:: xml

    <?xml version="1.0" encoding="utf-8" standalone="yes" ?>
    <xliff version="1.0">
        <file source-language="en" datatype="plaintext" original="messages" date="2013-11-11T21:36:44Z" product-name="operations">
            <header/>
            <body>

                <trans-unit id="tx_extend_operations_domain_model_operation.newfield">
                    <source>My new field</source>
                </trans-unit>

            </body>
        </file>
    </xliff>



ext_tables.sql
^^^^^^^^^^^^^^

Neue Felder für die Datenbank. Installiert die Extension oder nutzt den Datenbank Compare im Install-Tool um die neuen Felder
 nun auch hinzuzufügen.

.. code-block:: sql

    #
    # Table structure for table 'tx_operations_domain_model_operation'
    #
    CREATE TABLE tx_operations_domain_model_operation (
        newfield varchar(255) DEFAULT '' NOT NULL,
    );

Leert den Cache im Install-Tool um die neuen Felder im Backend zu sehen. Später könnt ihr die neuen Daten auch im Fluid Template ausgeben lassen. Prüft dazu auch das TypoScript und passt ggf. die Template Pfade an.

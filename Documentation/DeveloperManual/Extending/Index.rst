.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _install:

=================
Extend operations
=================

.. note::

   TYPO3 development was quickly going forward. Therefore some code snippets are not up to date.
   I can't update those part of documention in the future. But I leave the example her to become an idea
   how it works.

If you want to extend operations, there is an example extension on github.

`extend_operations <https://github.com/kanow/extend_operations>`_

.. note::

    Those extensions is only running on TYPO3 8. They doesn't work on current TYPO3 version!
    Probably the code must be changed to get a running version on current TYPO3.


In this example extension is only one new property "subtitle" for the operation model. If you need more than this single field, you can add more in this way. Replace "newfield" with the name of your new property.

Classes/Domain/Model/Operation.php
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Add the new property with getter and setter in the operation model. You can do this in the same way for the other models too.

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

Write the TCA definition to show the new field in backend.

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

Add a key for the new field in the locallang file.

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

Add the field(s) to the database. Install the extension or use Install-Tool compare to add the new fields.

.. code-block:: sql

    #
    # Table structure for table 'tx_operations_domain_model_operation'
    #
    CREATE TABLE tx_operations_domain_model_operation (
        newfield varchar(255) DEFAULT '' NOT NULL,
    );

Clear Install-Tool Cache and you should be able to see your new field(s) in the backend and after using the new field(s) in the fluid templates you can show them also in frontend. Please check your TypoScript and adapt fluid template paths.

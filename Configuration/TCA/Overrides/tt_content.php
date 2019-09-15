<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$pluginConfiguration = [
    '0' => [
        'pluginName' => 'List',
        'extensionName' => 'operations',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_list.xml',
        'title' => 'Operations',
        'icon' => 'ext-operations-wizard-icon'
    ],
    '1' => [
        'pluginName' => 'Statistics',
        'extensionName' => 'operations',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_statistics.xml',
        'title' => 'Operations Statistics',
        'icon' => 'ext-operations-wizard-icon'
    ]
];

foreach ($pluginConfiguration as $plugin) {
    ExtensionUtility::registerPlugin(
        $plugin['extensionName'],
        $plugin['pluginName'],
        $plugin['title'],
        $plugin['icon']
    );
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][strtolower($plugin['extensionName']).'_'.strtolower($plugin['pluginName'])] = 'select_key';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][strtolower($plugin['extensionName']).'_'.strtolower($plugin['pluginName'])] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        strtolower($plugin['extensionName']).'_'.strtolower($plugin['pluginName']),
        $plugin['flexformFile']);
}

ExtensionManagementUtility::addToInsertRecords('tx_operations_domain_model_operation');

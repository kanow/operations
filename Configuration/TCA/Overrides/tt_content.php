<?php
if (!defined ('TYPO3')) {
    die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$pluginConfiguration = [
    '0' => [
        'extensionName' => 'operations',
        'pluginName' => 'List',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_list.xml',
        'title' => 'Operations',
        'icon' => 'ext-operations-wizard-icon'
    ],
    '1' => [
        'extensionName' => 'operations',
        'pluginName' => 'Show',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_show.xml',
        'title' => 'Operations show',
        'icon' => 'ext-operations-wizard-icon'
    ],
    '2' => [
        'extensionName' => 'operations',
        'pluginName' => 'Statistics',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_statistics.xml',
        'title' => 'Operations Statistics',
        'icon' => 'ext-operations-wizard-icon'
    ],
    '3' => [
        'extensionName' => 'operations',
        'pluginName' => 'VehiclesList',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_vehicles_list.xml',
        'title' => 'Vehicles list view',
        'icon' => 'ext-operations-vehicle'
    ],
    '4' => [
        'extensionName' => 'operations',
        'pluginName' => 'VehiclesShow',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_vehicles_show.xml',
        'title' => 'Vehicles single view',
        'icon' => 'ext-operations-vehicle'
    ],
    '5' => [
        'extensionName' => 'operations',
        'pluginName' => 'ResourcesList',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_resources_list.xml',
        'title' => 'Resources list view',
        'icon' => 'ext-operations-resource'
    ],
    '6' => [
        'extensionName' => 'operations',
        'pluginName' => 'ResourcesShow',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_resources_show.xml',
        'title' => 'Resources single view',
        'icon' => 'ext-operations-resource'
    ]
];

foreach ($pluginConfiguration as $plugin) {
    ExtensionUtility::registerPlugin(
        $plugin['extensionName'],
        $plugin['pluginName'],
        $plugin['title'],
        $plugin['icon'],
        'operations'
    );

    $contentTypeName = 'operations_' . strtolower($plugin['pluginName']);
    $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$contentTypeName] = 'ext-operations-plugin-' . strtolower($plugin['pluginName']);

    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        $plugin['flexformFile'],
        $contentTypeName
    );
    $GLOBALS['TCA']['tt_content']['types'][$contentTypeName]['showitem'] = '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;headers,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin,
            pi_flexform,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ';
}

ExtensionManagementUtility::addToInsertRecords('tx_operations_domain_model_operation');

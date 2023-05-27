<?php
if (!defined ('TYPO3')) {
    die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$pluginConfiguration = [
    '0' => [
        'extensionName' => 'operations',
        'pluginName' => 'OperationList',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_operation_list.xml',
        'title' => 'Operation list view',
        'icon' => 'ext-operations-wizard-icon'
    ],
    '1' => [
        'extensionName' => 'operations',
        'pluginName' => 'OperationShow',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_operation_show.xml',
        'title' => 'Operation single view',
        'icon' => 'ext-operations-wizard-icon'
    ],
    '2' => [
        'extensionName' => 'operations',
        'pluginName' => 'OperationStatistics',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_operation_statistics.xml',
        'title' => 'Operation Statistics view',
        'icon' => 'ext-operations-wizard-icon'
    ],
    '3' => [
        'extensionName' => 'operations',
        'pluginName' => 'VehicleList',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_vehicle_list.xml',
        'title' => 'Vehicle list view',
        'icon' => 'ext-operations-vehicle'
    ],
    '4' => [
        'extensionName' => 'operations',
        'pluginName' => 'VehicleShow',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_vehicle_show.xml',
        'title' => 'Vehicle single view',
        'icon' => 'ext-operations-vehicle'
    ],
    '5' => [
        'extensionName' => 'operations',
        'pluginName' => 'ResourceList',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_resource_list.xml',
        'title' => 'Resource list view',
        'icon' => 'ext-operations-resource'
    ],
    '6' => [
        'extensionName' => 'operations',
        'pluginName' => 'ResourceShow',
        'flexformFile' => 'FILE:EXT:operations/Configuration/FlexForms/flexform_resource_show.xml',
        'title' => 'Resource single view',
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
            pi_flexform, pages,recursive,
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

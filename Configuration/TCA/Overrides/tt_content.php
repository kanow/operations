<?php

defined('TYPO3') || die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

(static function (): void {
    $languageFile = 'LLL:EXT:operations/Resources/Private/Language/locallang_be.xlf:';

    ExtensionManagementUtility::addTcaSelectItemGroup(
        'tt_content',
        'CType',
        'operations',
        $languageFile . 'plugin.title',
        'after:plugins'
    );

    $plugins = [
        'OperationList' => ['flexForm' => 'flexform_operation_list.xml', 'icon' => 'ext-operations-wizard-icon'],
        'OperationShow' => ['flexForm' => 'flexform_operation_show.xml', 'icon' => 'ext-operations-wizard-icon'],
        'OperationStatistics' => ['flexForm' => 'flexform_operation_statistics.xml', 'icon' => 'ext-operations-wizard-icon'],
        'VehicleList' => ['flexForm' => 'flexform_vehicle_list.xml', 'icon' => 'ext-operations-vehicle'],
        'VehicleShow' => ['flexForm' => 'flexform_vehicle_show.xml', 'icon' => 'ext-operations-vehicle'],
        'ResourceList' => ['flexForm' => 'flexform_resource_list.xml', 'icon' => 'ext-operations-resource'],
        'ResourceShow' => ['flexForm' => 'flexform_resource_show.xml', 'icon' => 'ext-operations-resource'],
    ];

    foreach ($plugins as $pluginName => $configuration) {
        $labelPrefix = $languageFile . 'plugin.' . strtolower($pluginName);
        $contentType = ExtensionUtility::registerPlugin(
            'Operations',
            $pluginName,
            $labelPrefix . '.title',
            $configuration['icon'],
            'operations',
            $labelPrefix . '.description',
            'FILE:EXT:operations/Configuration/FlexForms/' . $configuration['flexForm']
        );

        // Record storage page and recursion level, shown below the plugin options
        ExtensionManagementUtility::addToAllTCAtypes(
            'tt_content',
            'pages, recursive',
            $contentType,
            'after:pi_flexform'
        );
    }
})();

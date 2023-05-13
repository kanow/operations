<?php

use Kanow\Operations\Updates\MigrateCategoryRelations;
use Kanow\Operations\Controller\OperationController;
use Kanow\Operations\Controller\ResourceController;
use Kanow\Operations\Controller\VehicleController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

if (!defined('TYPO3')) {
	die ('Access denied.');
}

ExtensionUtility::configurePlugin(
    'Operations',
    'List',
    [
        OperationController::class => 'list',
    ],
    [
        OperationController::class => 'search',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
    'Show',
    [
        OperationController::class => 'show',
    ],
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
	'Statistics',
	[
		OperationController::class => 'statistics',

    ],
	// non-cacheable actions
	[
		OperationController::class => 'statistics',

    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
    'VehiclesList',
    [
        OperationController::class => 'list',
    ],
    [
        OperationController::class => '',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
    'VehiclesShow',
    [
        OperationController::class => 'show',
    ],
    [
        OperationController::class => '',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
    'ResourcesList',
    [
        OperationController::class => 'list',
    ],
    [
        OperationController::class => '',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
    'ResourcesShow',
    [
        OperationController::class => 'show',
    ],
    [
        OperationController::class => '',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionManagementUtility::addPageTSConfig('@import "EXT:operations/Configuration/TsConfig/ContentElementWizard.page.typoscript"');

ExtensionManagementUtility::addTypoScriptSetup(trim('
    plugin {
        tx_operations_list.view.pluginNamespace = tx_operations_pi1
        tx_operations_show.view.pluginNamespace = tx_operations_pi1
        tx_operations_statistics.view.pluginNamespace = tx_operations_pi1
        tx_operations_vehicleslist.view.pluginNamespace = tx_operations_pi1
        tx_operations_vehiclesshow.view.pluginNamespace = tx_operations_pi1
        tx_operations_resourceslist.view.pluginNamespace = tx_operations_pi1
        tx_operations_resourcesshow.view.pluginNamespace = tx_operations_pi1
    }
'));

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['operations_migrateCategoryRelations']
    = MigrateCategoryRelations::class;

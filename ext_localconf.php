<?php

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
    'OperationList',
    [
        OperationController::class => 'list,search',
    ],
    [
        OperationController::class => 'search',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
    'OperationShow',
    [
        OperationController::class => 'show',
    ],
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
	'OperationStatistics',
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
    'VehicleList',
    [
        VehicleController::class => 'list',
    ],
    [
        VehicleController::class => '',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
    'VehicleShow',
    [
        VehicleController::class => 'show',
    ],
    [
        VehicleController::class => '',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
    'ResourceList',
    [
        ResourceController::class => 'list',
    ],
    [
        ResourceController::class => '',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'Operations',
    'ResourceShow',
    [
        ResourceController::class => 'show',
    ],
    [
        ResourceController::class => '',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionManagementUtility::addTypoScriptSetup(trim('
    plugin {
        tx_operations_operationlist.view.pluginNamespace = tx_operations_pi1
        tx_operations_operationshow.view.pluginNamespace = tx_operations_pi1
        tx_operations_operationstatistics.view.pluginNamespace = tx_operations_pi1
        tx_operations_vehiclelist.view.pluginNamespace = tx_operations_pi1
        tx_operations_vehicleshow.view.pluginNamespace = tx_operations_pi1
        tx_operations_resourcelist.view.pluginNamespace = tx_operations_pi1
        tx_operations_resourceshow.view.pluginNamespace = tx_operations_pi1
    }
'));

    ExtensionManagementUtility::addTypoScriptSetup(trim('
# set class in your TypoScript if other pagination should be used
plugin.tx_operations.settings.paginate.class = TYPO3\CMS\Core\Pagination\SlidingWindowPagination'));


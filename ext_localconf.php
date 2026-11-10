<?php

declare(strict_types=1);

use Kanow\Operations\Controller\OperationController;
use Kanow\Operations\Controller\ResourceController;
use Kanow\Operations\Controller\VehicleController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

ExtensionUtility::configurePlugin(
    'Operations',
    'OperationList',
    [
        OperationController::class => 'list,search',
    ],
    [
        OperationController::class => 'search',
    ]
);
ExtensionUtility::configurePlugin(
    'Operations',
    'OperationShow',
    [
        OperationController::class => 'show',
    ],
    []
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
    ]
);
ExtensionUtility::configurePlugin(
    'Operations',
    'VehicleList',
    [
        VehicleController::class => 'list',
    ],
    []
);
ExtensionUtility::configurePlugin(
    'Operations',
    'VehicleShow',
    [
        VehicleController::class => 'show',
    ],
    []
);
ExtensionUtility::configurePlugin(
    'Operations',
    'ResourceList',
    [
        ResourceController::class => 'list',
    ],
    []
);
ExtensionUtility::configurePlugin(
    'Operations',
    'ResourceShow',
    [
        ResourceController::class => 'show',
    ],
    []
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
    plugin.tx_operations.settings.paginate.class = TYPO3\CMS\Core\Pagination\SlidingWindowPagination
'));

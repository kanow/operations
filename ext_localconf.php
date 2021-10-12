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
	'List',
	[
		OperationController::class => 'list, show, stats',
        ResourceController::class => 'list, show',
        VehicleController::class => 'list, show',

    ],
	// non-cacheable actions
	[
        OperationController::class => 'search',
        ResourceController::class => '',
        VehicleController::class => '',

    ]
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

    ]
);

ExtensionManagementUtility::addPageTSConfig('@import "EXT:operations/Configuration/TsConfig/ContentElementWizard.page.typoscript"');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['operations_migrateCategoryRelations']
    = \Kanow\Operations\Updates\MigrateCategoryRelations::class;

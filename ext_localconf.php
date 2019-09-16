<?php

use TYPO3\CMS\Core\Utility\GeneralUtility as GeneralCoreUtility;

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Operations',
	'List',
	array(
		'Operation' => 'list, show, stats',
		'Resource' => 'list, show',
		'Vehicle' => 'list, show',

	),
	// non-cacheable actions
	array(
		'Operation' => 'search',
		'Vehicle' => '',
		'Resource' => '',

	)
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Operations',
	'Statistics',
	array(
		'Operation' => 'statistics',
	),
	// non-cacheable actions
	array(
		'Operation' => 'statistics',
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:operations/Configuration/TsConfig/ContentElementWizard.txt">');

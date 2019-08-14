<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Kanow.' . $_EXTKEY,
	'List',
	array(
		'Operation' => 'list, show',
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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:operations/Configuration/TsConfig/ContentElementWizard.txt">');
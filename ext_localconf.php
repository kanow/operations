<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'KN.' . $_EXTKEY,
	'List',
	array(
		'Operation' => 'list, show',
		'Resources' => 'list, show',
		'Vehicle' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Operation' => 'search',
		'Vehicle' => '',
		'Resources' => '',
		
	)
);

?>
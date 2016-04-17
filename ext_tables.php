<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility as GeneralCoreUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'KN.'.$_EXTKEY,
	'List',
	'Operations'
);

$extensionName = strtolower(GeneralCoreUtility::underscoredToUpperCamelCase($_EXTKEY));
$pluginName = strtolower('List');
$pluginSignature = $extensionName.'_'.$pluginName;

// get first main part of TYPO3 version number
$currentTypo3Version = \KN\Operations\Utility\Div::getPartOfTypo3Version();

if($currentTypo3Version < 7){
	// old conf for be icons
	$iconPath = ExtensionManagementUtility::extRelPath($_EXTKEY);
} else {
	// new icon registery in TYPO3 7.6
	$iconRegistry = GeneralCoreUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
	// register wizard icon for operation
	$iconRegistry->registerIcon(
		'ext-operations-wizard-icon',
		BitmapIconProvider::class,
		['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_operation.svg']
	);
	// register icon for operation
	$iconRegistry->registerIcon(
		 'ext-operations-operation',
		 BitmapIconProvider::class,
		 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_operation.svg']
	);
	// register icon for assistance
	$iconRegistry->registerIcon(
		 'ext-operations-assistance',
		 BitmapIconProvider::class,
		 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_assistance.svg']
	);
	// register icon for resource
	$iconRegistry->registerIcon(
		 'ext-operations-resource',
		 BitmapIconProvider::class,
		 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_resource.svg']
	);
	// register icon for vehicle
	$iconRegistry->registerIcon(
		 'ext-operations-vehicle',
		 BitmapIconProvider::class,
		 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_vehicle.svg']
	);
	// register icon for type
	$iconRegistry->registerIcon(
		 'ext-operations-type',
		 BitmapIconProvider::class,
		 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_type.svg']
	);
}


$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');

ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Operations');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_operation', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_operation.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_operations_domain_model_operation');
/** @noinspection PhpUndefinedVariableInspection */
$TCA['tx_operations_domain_model_operation'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		//'sortby' => 'sorting',
		'default_sortby' => 'ORDER BY begin DESC',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'number,title,location,begin,end,report,longitude,latitude,zoom,image,type,assistance,vehicles,resources,',
		'dynamicConfigFile' => ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Operation.php',
		'iconfile' => $iconPath . '/Resources/Public/Icons/tx_operations_domain_model_operation.png',
		'typeicon_classes' => \KN\Operations\Utility\Div::getTypeIconClasses('ext-operations-operation'),
	),
);

ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_assistance', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_assistance.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_operations_domain_model_assistance');
$TCA['tx_operations_domain_model_assistance'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_assistance',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,description,link,',
		'dynamicConfigFile' => ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Assistance.php',
		'iconfile' => $iconPath . '/Resources/Public/Icons/tx_operations_domain_model_assistance.png',
		'typeicon_classes' => \KN\Operations\Utility\Div::getTypeIconClasses('ext-operations-assistance')
	),
);

ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_vehicle', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_vehicle.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_operations_domain_model_vehicle');
$TCA['tx_operations_domain_model_vehicle'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_vehicle',
		//'label' => 'title',
		'label' => 'short',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,short,description,image,',
		'dynamicConfigFile' => ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Vehicle.php',
		'iconfile' => $iconPath . '/Resources/Public/Icons/tx_operations_domain_model_vehicle.png',
		'typeicon_classes' => \KN\Operations\Utility\Div::getTypeIconClasses('ext-operations-vehicle')
	),
);

ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_resource', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_resource.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_operations_domain_model_resource');
$TCA['tx_operations_domain_model_resource'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_resource',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,short,description,image,',
		'dynamicConfigFile' => ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Resource.php',
		'iconfile' => $iconPath . '/Resources/Public/Icons/tx_operations_domain_model_resource.png',
		'typeicon_classes' => \KN\Operations\Utility\Div::getTypeIconClasses('ext-operations-resource')
	),
);

ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_type', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_type.xlf');
ExtensionManagementUtility::allowTableOnStandardPages('tx_operations_domain_model_type');
$TCA['tx_operations_domain_model_type'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_type',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,image,',
		'dynamicConfigFile' => ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Type.php',
		'iconfile' => $iconPath . '/Resources/Public/Icons/tx_operations_domain_model_type.png',
		'typeicon_classes' => \KN\Operations\Utility\Div::getTypeIconClasses('ext-operations-type')
	),
);

if($currentTypo3Version < 7) {
	TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('sys_file_reference');
}
$TCA['sys_file_reference']['columns']['uid_local']['config']['foreign_table'] = 'sys_file';

?>

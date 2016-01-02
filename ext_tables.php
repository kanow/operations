<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility as GeneralCoreUtility;

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'KN.'.$_EXTKEY,
	'List',
	'Operations'
);

$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));
$pluginName = strtolower('List');
$pluginSignature = $extensionName.'_'.$pluginName;

// get first main part of TYPO3 version number
$currentTypo3Version = \KN\Operations\Utility\Div::getPartOfTypo3Version();

// old iconfile
$iconPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY);

if($currentTypo3Version > 6) {
// new icon registery in TYPO3 7.6
$iconRegistry = GeneralCoreUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
// register icon for operation
$iconRegistry->registerIcon(
	 'ext-operations-operation',
	 \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
	 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_domain_model_operation.png']
);
// register icon for assistance
$iconRegistry->registerIcon(
	 'ext-operations-assistance',
	 \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
	 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_domain_model_assistance.png']
);
// register icon for resource
$iconRegistry->registerIcon(
	 'ext-operations-resource',
	 \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
	 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_domain_model_resource.png']
);
// register icon for vehicle
$iconRegistry->registerIcon(
	 'ext-operations-vehicle',
	 \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
	 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_domain_model_vehicle.png']
);
// register icon for type
$iconRegistry->registerIcon(
	 'ext-operations-type',
	 \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
	 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_domain_model_type.png']
);
}

// if($currentTypo3Version < 7) {
// 	$iconPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY);
// } else {
// 	//$iconPath = 'EXT:' . $_EXTKEY;
// 	$iconPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY);
//
// 	$iconRegistry = GeneralCoreUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
//
// 	// DebuggerUtility::var_dump($iconRegistry->registerIcon(
// 	// 'tx_operations_domain_model_operation',
// 	// \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
// 	// ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_domain_model_operation.png']));
// 	$iconRegistry->registerIcon(
// 						 'ext-operations-operation',
// 						 \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
// 						 ['source' => 'EXT:operations/Resources/Public/Icons/tx_operations_domain_model_operation.png']
// 				 );
// // $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
// // $iconFactory->getIcon($identifier, Icon::SIZE_SMALL)->render();
// //
// // 	$iconPath = 'EXT:operations/Resources/Public/Icons/tx_operations_domain_model_operation.png';
// // 	DebuggerUtility::var_dump($iconRegistry->getIconConfigurationByIdentifier($identifier));
// }

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Operations');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_operation', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_operation.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_operations_domain_model_operation');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Operation.php',
		'iconfile' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/tx_operations_domain_model_operation.png',
		'typeicon_classes' => array(
			'default' => 'ext-operations-operation'
		)
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_assistance', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_assistance.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_operations_domain_model_assistance');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Assistance.php',
		'iconfile' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/tx_operations_domain_model_assistance.png',
		'typeicon_classes' => array(
			'default' => 'ext-operations-assistance'
		)
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_vehicle', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_vehicle.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_operations_domain_model_vehicle');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Vehicle.php',
		'iconfile' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/tx_operations_domain_model_vehicle.png',
		'typeicon_classes' => array(
			'default' => 'ext-operations-vehicle'
		)
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_resource', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_resource.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_operations_domain_model_resource');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Resource.php',
		'iconfile' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/tx_operations_domain_model_resource.png',
		'typeicon_classes' => array(
			'default' => 'ext-operations-resource'
		)
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_type', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_type.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_operations_domain_model_type');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Type.php',
		'iconfile' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/tx_operations_domain_model_type.png',
		'typeicon_classes' => array(
			'default' => 'ext-operations-type'
		)
	),
);

if($currentTypo3Version < 7) {
	TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('sys_file_reference');
}
$TCA['sys_file_reference']['columns']['uid_local']['config']['foreign_table'] = 'sys_file';

?>

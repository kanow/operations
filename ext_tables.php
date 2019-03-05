<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
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


// @todo use array and foreach for cycle
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



$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');

ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Operations');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_operation', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_operation.xlf');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_assistance', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_assistance.xlf');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_vehicle', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_vehicle.xlf');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_resource', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_resource.xlf');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_type', 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_type.xlf');

$TCA['sys_file_reference']['columns']['uid_local']['config']['foreign_table'] = 'sys_file';


<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\GeneralUtility as GeneralCoreUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$extensionName = strtolower(GeneralCoreUtility::underscoredToUpperCamelCase('operations'));
$pluginName = strtolower('List');
$pluginSignature = $extensionName.'_'.$pluginName;

ExtensionUtility::registerPlugin(
    'operations',
    'List',
    'Operations'
);


ExtensionManagementUtility::addToInsertRecords('tx_operations_domain_model_operation');

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:operations/Configuration/FlexForms/flexform_list.xml');


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'operations',
    'Statistics',
    'Operations Statistics'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['operations_statistics'] = 'select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['operations_statistics'] = 'pi_flexform';

ExtensionManagementUtility::addPiFlexFormValue('operations_statistics', 'FILE:EXT:operations/Configuration/FlexForms/flexform_statistics.xml');

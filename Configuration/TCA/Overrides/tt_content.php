<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\GeneralUtility as GeneralCoreUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$extensionName = strtolower(GeneralCoreUtility::underscoredToUpperCamelCase('operations'));
$pluginName = strtolower('List');
$pluginSignature = $extensionName.'_'.$pluginName;

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'KN.operations',
    'List',
    'Operations'
);

ExtensionManagementUtility::addToInsertRecords('tx_operations_domain_model_operation');

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:operations/Configuration/FlexForms/flexform_list.xml');

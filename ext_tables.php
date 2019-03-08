<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
use TYPO3\CMS\Core\Utility\GeneralUtility as GeneralCoreUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

$icons = [
    'wizard-icon' => 'tx_operations_operation.svg',
    'operation' => 'tx_operations_operation.svg',
    'assistance' => 'tx_operations_assistance.svg',
    'resource' => 'tx_operations_resource.svg',
    'vehicle' => 'tx_operations_vehicle.svg',
    'type' => 'tx_operations_type.svg'
];

$iconRegistry = GeneralCoreUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
foreach ($icons as $key => $value)
{
    $iconRegistry->registerIcon(
        'ext-operations-'.$key,
        SvgIconProvider::class,
        ['source' => 'EXT:operations/Resources/Public/Icons/'.$value]
    );
}

$llRefs = ['operation','assistance','vehicle','resource','type'];
foreach ($llRefs as $llRef)
{
    ExtensionManagementUtility::addLLrefForTCAdescr('tx_operations_domain_model_'.$llRef, 'EXT:operations/Resources/Private/Language/locallang_csh_tx_operations_domain_model_'.$llRef.'.xlf');
}


<?php
use TYPO3\CMS\Core\Imaging\IconRegistry;
if (!defined('TYPO3')) {
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

$iconRegistry = GeneralCoreUtility::makeInstance(IconRegistry::class);
foreach ($icons as $key => $value)
{
    $iconRegistry->registerIcon(
        'ext-operations-'.$key,
        SvgIconProvider::class,
        ['source' => 'EXT:operations/Resources/Public/Icons/'.$value]
    );
}

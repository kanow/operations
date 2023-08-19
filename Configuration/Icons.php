<?php

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

$defaultPath = 'EXT:operations/Resources/Public/Icons/';

return [
    // icon identifier
    'ext-operations-wizard-icon' => [
        'provider' => SvgIconProvider::class,
        'source' => $defaultPath . 'tx_operations_operation.svg',
    ],
    'ext-operations-operation' => [
        'provider' => SvgIconProvider::class,
        'source' => $defaultPath . 'tx_operations_operation.svg',
    ],
    'ext-operations-assistance' => [
        'provider' => SvgIconProvider::class,
        'source' => $defaultPath . 'tx_operations_assistance.svg',
    ],
    'ext-operations-resource' => [
        'provider' => SvgIconProvider::class,
        'source' => $defaultPath . 'tx_operations_resource.svg',
    ],
    'ext-operations-vehicle' => [
        'provider' => SvgIconProvider::class,
        'source' => $defaultPath . 'tx_operations_vehicle.svg',
    ],
    'ext-operations-type' => [
        'provider' => SvgIconProvider::class,
        'source' => $defaultPath . 'tx_operations_type.svg',
    ],

];
<?php

use TYPO3\CMS\Core\Resource\FileType;

defined('TYPO3') or die();

$imageSettingsFalMedia = [
    'behaviour' => [
        'allowLanguageSynchronization' => true,
    ],
    'appearance' => [
        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
        'showPossibleLocalizationRecords' => true,
        'showAllLocalizationLink' => true,
        'showSynchronizationLink' => true,
    ],
    // custom configuration for displaying fields in the overlay/reference table
    'overrideChildTca' => [
        'types' => [
            '0' => [
                'showitem' => '
                    --palette--;;imageoverlayPalette,
                    --palette--;;filePalette',
            ],
            FileType::TEXT->value => [
                'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
            ],
            FileType::IMAGE->value => [
                'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
            ],
            FileType::AUDIO->value => [
                'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette',
            ],
            FileType::VIDEO->value => [
                'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette',
            ],
        ],
    ],
];

$imageConfigurationFalMedia = [
    'type' => 'file',
    'appearance' => $imageSettingsFalMedia['appearance'],
    'behaviour' => $imageSettingsFalMedia['behaviour'],
    'overrideChildTca' => $imageSettingsFalMedia['overrideChildTca'],
    'allowed' => 'common-image-types',
];
$tcaForColorField = [
    'type' => 'color',
    'searchable' => false,
    'size' => 10,
    'default' => '',
];

return [
    'ctrl' => [
        'title' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_type',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'typeicon_classes' => ['default' => 'ext-operations-type'],
    ],
    'types' => [
        '0' => ['showitem' => 'sys_language_uid,l10n_parent,title,color,image,
		--div--;core.form.tabs:access,
            --palette--;;paletteHidden,
            --palette--;;paletteAccess,',
        ],
    ],
    'palettes' => [
        'paletteHidden' => [
            'showitem' => 'hidden',
        ],
        'paletteAccess' => [
            'label' => 'core.form.palettes:access',
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel,
                --linebreak--
            ',
        ],
    ],
    'columns' => [
        'title' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_type.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'color' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_type.color',
            'config' => $tcaForColorField,
        ],
        'image' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_type.image',
            'config' => $imageConfigurationFalMedia,
        ],
    ],
];

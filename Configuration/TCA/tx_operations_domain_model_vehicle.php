<?php

use TYPO3\CMS\Core\Resource\FileType;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

$extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('operations');

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

return [
    'ctrl' => [
        'title' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_vehicle',
        //'label' => 'title',
        'label' => 'short',
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
        'typeicon_classes' => ['default' => 'ext-operations-vehicle'],
    ],
    'types' => [
        '0' => [
            'showitem' => 'sys_language_uid,l10n_parent,title,path_segment,short,description,link,--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.media,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitleVehicles.media;paletteImg,
            --div--;core.form.tabs:access,
                --palette--;;paletteHidden,
                --palette--;;paletteAccess,',
        ],
    ],
    'palettes' => [
        'paletteImg' => [
            'showitem' => 'media',
        ],
        'paletteHidden' => [
            'showitem' => '
                hidden
            ',
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
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_vehicle.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'path_segment' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.path_segment',
            'config' => [
                'type' => 'slug',
                'searchable' => false,
                'generatorOptions' => [
                    'fields' => ['title'],
                    'fieldSeparator' => '/',
                    'prefixParentPageSlug' => true,
                ],
                'fallbackCharacter' => '-',
                'eval' => $extensionConfiguration['slugBehaviour'],
            ],
        ],
        'short' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_vehicle.short',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'description' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_vehicle.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'media' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_vehicle.media',
            'config' => $imageConfigurationFalMedia,
        ],
        'link' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_vehicle.link',
            'config' => [
                'type' => 'link',
                'searchable' => false,
                'size' => 30,
                'default' => '',
            ],
        ],
    ],
];

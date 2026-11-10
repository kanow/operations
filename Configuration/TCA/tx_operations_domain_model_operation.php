<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Resource\FileType;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') || die();

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
$tcaForDatetimeFields = [
    'type' => 'datetime',
    'size' => 16,
    'default' => 0,
    'format' => 'datetime',
];

return [
    'ctrl' => [
        'title' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        //'sortby' => 'sorting',
        'default_sortby' => 'ORDER BY begin DESC',
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
        'typeicon_classes' => ['default' => 'ext-operations-operation'],
    ],
    'types' => [
        '0' => [
            'showitem' => 'sys_language_uid,l10n_parent,
            --palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.meta;paletteMeta,title,path_segment,location,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.time;paletteTime,teaser,report,--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.map,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.coordinates;paletteMap,--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.relations,assistance,vehicles,resources,--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.media,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.media;paletteImg,--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tabs.categories,category,
            --div--;core.form.tabs:access,
            --palette--;;paletteHidden,
            --palette--;;paletteAccess,',
        ],
    ],
    'palettes' => [
        'paletteMap' => [
            'showitem' => 'latitude,--linebreak--,longitude,
			--linebreak--,zoom',
        ],
        'paletteImg' => [
            'showitem' => 'media',
        ],
        'paletteTime' => [
            'showitem' => 'begin,end',
        ],
        'paletteMeta' => [
            'showitem' => 'number, type, onlyEld',
        ],
        'paletteHidden' => [
            'showitem' => '
                hidden
            ',
        ],
        'paletteAccess' => [
            'label' => 'core.form.palettes:access',
            'showitem' => '
                starttime;core.db.general:starttime,
                endtime;core.db.general:endtime,
                --linebreak--
            ',
        ],
    ],
    'columns' => [
        'number' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.number',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'onlyEld' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.onlyEld',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'title' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.title',
            'config' => [
                'type' => 'input',
                'size' => 60,
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
        'location' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.location',
            'config' => [
                'type' => 'text',
                'cols' => 60,
                'rows' => 3,
                'eval' => 'trim',
                'required' => true,
                'default' => '',
            ],
        ],
        'begin' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.begin',
            'config' => array_merge_recursive($tcaForDatetimeFields, [
                'required' => true,
            ]),
        ],
        'end' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.end',
            'config' => array_merge_recursive($tcaForDatetimeFields, [
                'required' => false,
            ]),
        ],
        'teaser' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.teaser',
            'config' => [
                'type' => 'text',
                'cols' => 60,
                'rows' => 5,
                'searchable' => false,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'report' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.report',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'longitude' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.longitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'latitude' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.latitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'zoom' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.zoom',
            'config' => [
                'type' => 'number',
                'size' => 4,
                'default' => 0,
            ],
        ],
        'media' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.media',
            'config' => $imageConfigurationFalMedia,
        ],
        'type' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.type',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_operations_domain_model_type',
                'foreign_table_where' => 'AND tx_operations_domain_model_type.sys_language_uid = ###REC_FIELD_sys_language_uid###',
                'MM' => 'tx_operations_operation_type_mm',
                'size' => 1,
                'autoSizeMax' => 40,
                'maxitems' => 1,
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.choose', 'value' => 0],
                ],
                'default' => 0,
            ],
        ],
        'assistance' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.assistance',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_operations_domain_model_assistance',
                'MM' => 'tx_operations_operation_assistance_mm',
                'foreign_table_where' => 'AND tx_operations_domain_model_assistance.sys_language_uid = ###REC_FIELD_sys_language_uid###',
                'size' => 10,
                'autoSizeMax' => 40,
                'minitems' => 0,
                'maxitems' => 9999,
                'renderType' => 'selectMultipleSideBySide',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.edit',
                        ],
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.createNew',
                        ],
                    ],
                ],
                'default' => 0,
            ],
        ],
        'vehicles' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.vehicles',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_operations_domain_model_vehicle',
                'MM' => 'tx_operations_operation_vehicle_mm',
                'foreign_table_where' => 'AND tx_operations_domain_model_vehicle.sys_language_uid = ###REC_FIELD_sys_language_uid###',
                'size' => 10,
                'autoSizeMax' => 40,
                'minitems' => 0,
                'maxitems' => 9999,
                'renderType' => 'selectMultipleSideBySide',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.edit',
                        ],
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.createNew',
                        ],
                    ],
                ],
                'default' => 0,
            ],
        ],
        'resources' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.resources',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_operations_domain_model_resource',
                'MM' => 'tx_operations_operation_resource_mm',
                'foreign_table_where' => 'AND tx_operations_domain_model_resource.sys_language_uid = ###REC_FIELD_sys_language_uid###',
                'size' => 10,
                'autoSizeMax' => 40,
                'minitems' => 0,
                'maxitems' => 9999,
                'renderType' => 'selectMultipleSideBySide',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.edit',
                        ],
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.createNew',
                        ],
                    ],
                ],
                'default' => 0,
            ],
        ],
        'category' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.fieldLabel.category',
            'config' => [
                'type' => 'category',
                'treeConfig' => [
                    'startingPoints' => '###SITE:settings.operations.rootCategory###',
                    'appearance' => [
                        'expandAll' => true,
                        'showHeader' => true,
                    ],
                ],
                'size' => 30,
                'maxitems' => 9999,
                'default' => 0,
            ],
        ],
    ],
];

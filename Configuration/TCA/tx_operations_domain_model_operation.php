<?php

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

if (!defined ('TYPO3')) {
	die ('Access denied.');
}

$extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('operations');

$imageSettingsFalMedia = [
    'behaviour' => [
        'allowLanguageSynchronization' => true,
    ],
    'appearance' => [
        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.asset_references.addFileReference',
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
                    --palette--;;filePalette'
            ],
            \TYPO3\CMS\Core\Resource\FileType::TEXT->value => [
                'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
            ],
            \TYPO3\CMS\Core\Resource\FileType::IMAGE->value => [
                'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
            ],
            \TYPO3\CMS\Core\Resource\FileType::AUDIO->value => [
                'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette'
            ],
            \TYPO3\CMS\Core\Resource\FileType::VIDEO->value => [
                'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette'
            ],
        ],
    ],
];

$versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
$typo3Version = $versionInformation->getMajorVersion();

    $imageConfigurationFalMedia = [
        'type' => 'file',
        'appearance' => $imageSettingsFalMedia['appearance'],
        'behaviour' => $imageSettingsFalMedia['behaviour'],
        'overrideChildTca' => $imageSettingsFalMedia['overrideChildTca'],
        'allowed' => 'common-image-types',
    ];
    $renderTypeDatetime = 'dateTime';
    $tcaForDatetimeFields = [
        'type' => 'datetime',
        'size' => 16,
        'eval' => 'int',
        'default' => 0,
        'format' => 'datetime'
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
                'searchFields' => 'number,title,location,begin,end,report,longitude,latitude,zoom,media,type,assistance,vehicles,resources,',
                'typeicon_classes' => ['default' => 'ext-operations-operation'],
    ],
	'types' => [
		'0' => [
            'showitem' => 'sys_language_uid;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language,l10n_parent;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent,l10n_diffsource,
            --palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.meta;paletteMeta,title,path_segment,location,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.time;paletteTime,teaser,report,--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.map,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.coordinates;paletteMap,--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.relations,assistance,vehicles,resources,--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.media,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.media;paletteImg,--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tabs.categories,category,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;paletteHidden,
            --palette--;;paletteAccess,',
        ],
    ],
	'palettes' => [
		'paletteMap' => [
			'showitem' => 'latitude,--linebreak--,longitude,
			--linebreak--,zoom',
			'canNotCollapse' => 'TRUE'
        ],
		'paletteImg' => [
			'showitem' => 'media',
			'canNotCollapse' => 'TRUE'
        ],
		'paletteTime' => [
			'showitem' => 'begin,end',
			'canNotCollapse' => 'TRUE'
        ],
		'paletteMeta' => [
			'showitem' => 'number, type, onlyEld',
			'canNotCollapse' => 'TRUE'
        ],
        'paletteHidden' => [
            'showitem' => '
                hidden
            ',
        ],
        'paletteAccess' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access',
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel,
                --linebreak--
            ',
        ],
    ],
	'columns' => [
		'sys_language_uid' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
			'config' => ['type' => 'language'],
        ],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => $typo3Version < 12 ? [
                    ['', 0],
                ] : [
                    ['label' => '', 'value' => 0],
                ],
				'foreign_table' => 'tx_operations_domain_model_operation',
				'foreign_table_where' => 'AND tx_operations_domain_model_operation.pid=###CURRENT_PID### AND tx_operations_domain_model_operation.sys_language_uid IN (-1,0)',
                'default' => 0
            ],
        ],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
            ],
        ],
		't3ver_label' => [
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
            ]
        ],
		'hidden' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
            ],
        ],
		'starttime' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => $tcaForDatetimeFields,
        ],
		'endtime' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => $tcaForDatetimeFields,
        ],
		'number' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.number',
			'config' => [
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim',
                'required' => true
            ],
        ],
		'onlyEld' => [
			'exclude' => 1,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.onlyEld',
			'config' => [
				'type' => 'check',
            ],
        ],
		'title' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.title',
			'config' => [
				'type' => 'input',
				'size' => 60,
				'eval' => 'trim',
                'required' => true
            ],
        ],
        'path_segment' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.path_segment',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['title'],
                    'fieldSeparator' => '/',
                    'prefixParentPageSlug' => true
                ],
                'fallbackCharacter' => '-',
                'eval' => $extensionConfiguration['slugBehaviour'],
            ]
        ],
		'location' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.location',
			'config' => [
				'type' => 'text',
				'cols' => 60,
				'rows' => 3,
				'eval' => 'trim',
                'required' => true
            ],
        ],
		'begin' => [
			'exclude' => 1,
            'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.begin',
			'config' => array_merge_recursive($tcaForDatetimeFields,[
                'required' => true
            ]),
        ],
		'end' => [
			'exclude' => 1,
            'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.end',
            'config' => array_merge_recursive($tcaForDatetimeFields,[
                'required' => false
            ]),
        ],
		'teaser' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.teaser',
			'config' => [
				'type' => 'text',
				'cols' => 60,
				'rows' => 5,
				'eval' => 'trim'
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
				'eval' => 'trim'
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
				'eval' => 'trim'
            ],
        ],
		'zoom' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.zoom',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'num'
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
				'minItems' => 0,
				'maxitems' => 1,
				'multiple' => 0,
				'renderType' => 'selectSingle',
                'items' => $typo3Version < 12 ? [
                    ['LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.choose','0'],
                ] : [
                    ['label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.choose', 'value' => 0],
                ],
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
				'multiple' => 0,
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
				'multiple' => 0,
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
				'multiple' => 0,
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
                        'expandAll' => TRUE,
                        'showHeader' => TRUE,
                    ],
                ],
                'size' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
            ],
        ],
    ],
];

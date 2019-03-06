<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// get first main part of TYPO3 version number
$currentTypo3Version = \KN\Operations\Utility\Div::getPartOfTypo3Version();

ExtensionManagementUtility::addToInsertRecords('tx_operations_domain_model_operation');

return [
	'ctrl' => [
                'title' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation',
                'label' => 'title',
                'tstamp' => 'tstamp',
                'crdate' => 'crdate',
                'cruser_id' => 'cruser_id',
                'dividers2tabs' => TRUE,
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
                'searchFields' => 'number,title,location,begin,end,report,longitude,latitude,zoom,image,type,assistance,vehicles,resources,',
                'typeicon_classes' => ['default' => 'ext-operations-operation'],
    ],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, number, onlyEld, title, location, begin, end, teaser, report, longitude, latitude, zoom, image, type, assistance, vehicles, resources',
    ],
	'types' => [
		'0' => [
            'showitem' => 'sys_language_uid;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language, l10n_parent;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent, l10n_diffsource,hidden;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden,
		--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.meta;paletteMeta,
		title, location,
		--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.time;paletteTime,
		teaser,report,
		--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.map,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.coordinates;paletteMap,
		--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.relations,assistance,vehicles, resources,
		--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.img,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.img;paletteImg,'
        ],
    ],
	'palettes' => [
		'paletteMap' => [
			'showitem' => 'latitude,--linebreak--,longitude,
			--linebreak--,zoom',
			'canNotCollapse' => 'TRUE'
        ],
		'paletteImg' => [
			'showitem' => 'image',
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
    ],
	'columns' => [
		'sys_language_uid' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    [
                        'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.default_value',
                        0
                    ],
                    [
                        'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0
            ],
        ],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
					['', 0],
                ],
				'foreign_table' => 'tx_operations_domain_model_operation',
				'foreign_table_where' => 'AND tx_operations_domain_model_operation.pid=###CURRENT_PID### AND tx_operations_domain_model_operation.sys_language_uid IN (-1,0)',
            ],
        ],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
            ],
        ],
		't3ver_label' => [
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
            ]
        ],
		'hidden' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
            ],
        ],
		'starttime' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
                'renderType' => 'inputDateTime',
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
                'behaviour' => ['allowLanguageSynchronization' => true],
            ],
        ],
		'endtime' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
                'renderType' => 'inputDateTime',
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
                'behaviour' => ['allowLanguageSynchronization' => true],
            ],
        ],
		'number' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.number',
			'config' => [
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim,required'
            ],
        ],
		'onlyEld' => [
			'exclude' => 1,
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
				'eval' => 'trim,required'
            ],
        ],
		'location' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.location',
			'config' => [
				'type' => 'text',
				'cols' => 60,
				'rows' => 3,
				'eval' => 'trim,required'
            ],
        ],
		'begin' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.begin',
			'config' => [
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime,required',
                'renderType' => 'inputDateTime',
				'checkbox' => 1,
				'default' => time()
            ],
        ],
		'end' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.end',
			'config' => [
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
                'renderType' => 'inputDateTime',
				'checkbox' => 1,
				'default' => time()
            ],
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
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.longitude',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
            ],
        ],
		'latitude' => [
			'exclude' => 1,
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
				'eval' => 'int'
            ],
        ],
		'image' => [
				'exclude' => 1,
				'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.image',
				'config' => ExtensionManagementUtility::getFileFieldTCAConfig('image', [
					'appearance' => [
						'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                    ],
					'foreign_types' => [
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
                        ],
                    ]
                ], $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
        ],
		'type' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.type',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_operations_domain_model_type',
				'MM' => 'tx_operations_operation_type_mm',
				'size' => 1,
				'autoSizeMax' => 40,
				'minItems' => 0,
				'maxitems' => 1,
				'multiple' => 0,
				'wizards' => [
					'_PADDING' => 1,
					'_VERTICAL' => 1,
                ],
				'renderType' => 'selectSingle',
				'items' => [
					['LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.choose','0']
                ]
            ],
        ],
		'assistance' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.assistance',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_operations_domain_model_assistance',
				'MM' => 'tx_operations_operation_assistance_mm',
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
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.vehicles',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_operations_domain_model_vehicle',
				'MM' => 'tx_operations_operation_vehicle_mm',
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
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.resources',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_operations_domain_model_resource',
				'MM' => 'tx_operations_operation_resource_mm',
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
    ],
];

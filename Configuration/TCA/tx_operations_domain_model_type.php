<?php

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

if (!defined ('TYPO3')) {
	die ('Access denied.');
}

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
            File::FILETYPE_TEXT => [
                'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
            ],
            File::FILETYPE_IMAGE => [
                'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
            ],
            File::FILETYPE_AUDIO => [
                'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette'
            ],
            File::FILETYPE_VIDEO => [
                'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette'
            ],
        ],
    ],
];

$versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
$typo3Version = $versionInformation->getMajorVersion();
if ($typo3Version > 11) {
    $imageConfigurationFalMedia = [
        'type' => 'file',
        'appearance' => $imageSettingsFalMedia['appearance'],
        'behaviour' => $imageSettingsFalMedia['behaviour'],
        'overrideChildTca' => $imageSettingsFalMedia['overrideChildTca'],
        'allowed' => 'common-image-types',
    ];
    $renderTypeDatetime = 'dateTime';
} else {
    /** @noinspection PhpDeprecationInspection */
    // @extensionScannerIgnoreLine
    $imageConfigurationFalMedia = ExtensionManagementUtility::getFileFieldTCAConfig(
        'fal_media',
        $imageSettingsFalMedia,
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
    );
    $renderTypeDatetime = 'inputDateTime';
}

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
                'searchFields' => 'uid,title',
                'typeicon_classes' => ['default' => 'ext-operations-type']
    ],
	'types' => [
		'0' => ['showitem' => 'sys_language_uid;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language,l10n_parent;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent,l10n_diffsource,hidden;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden,title,color,image'
        ],
    ],
	'palettes' => [
		'1' => ['showitem' => ''],
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
                'foreign_table' => 'tx_operations_domain_model_type',
                'foreign_table_where' => 'AND tx_operations_domain_model_type.pid=###CURRENT_PID### AND tx_operations_domain_model_type.sys_language_uid IN (-1,0)',
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
			'config' => [
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
                'renderType' => $renderTypeDatetime,
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
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
                'renderType' => $renderTypeDatetime,
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
                'behaviour' => ['allowLanguageSynchronization' => true],
            ],
        ],
		'title' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_type.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
                'required' => true
            ],
        ],
        'color' => array(
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_type.color',
            'config' => array(
                'type' => 'input',
                'renderType' => $renderTypeDatetime,
                'eval' => 'trim'
            ),
        ),
		'image' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_type.image',
            'config' => $imageConfigurationFalMedia,
        ],
    ],
];

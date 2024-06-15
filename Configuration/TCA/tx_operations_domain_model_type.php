<?php

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;

if (!defined('TYPO3')) {
    die('Access denied.');
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
                    --palette--;;filePalette',
            ],
            \TYPO3\CMS\Core\Resource\FileType::TEXT->value => [
                'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
            ],
            \TYPO3\CMS\Core\Resource\FileType::IMAGE->value => [
                'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
            ],
            \TYPO3\CMS\Core\Resource\FileType::AUDIO->value => [
                'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette',
            ],
            \TYPO3\CMS\Core\Resource\FileType::VIDEO->value => [
                'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette',
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
$tcaForDatetimeFields = [
    'type' => 'datetime',
    'size' => 16,
    'eval' => 'int',
    'default' => 0,
    'format' => 'datetime',
];
$tcaForColorField = [
    'type' => 'color',
    'size' => 10,
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
        'searchFields' => 'uid,title',
        'typeicon_classes' => ['default' => 'ext-operations-type'],
    ],
    'types' => [
        '0' => ['showitem' => 'sys_language_uid;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language,l10n_parent;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent,l10n_diffsource,title,color,image,
		--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;paletteHidden,
            --palette--;;paletteAccess,',
        ],
    ],
    'palettes' => [
        'paletteHidden' => [
            'showitem' => 'hidden',
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
                'foreign_table' => 'tx_operations_domain_model_type',
                'foreign_table_where' => 'AND tx_operations_domain_model_type.pid=###CURRENT_PID### AND tx_operations_domain_model_type.sys_language_uid IN (-1,0)',
                'default' => 0,
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
            ],
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

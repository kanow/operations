<?php

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;

if (!defined ('TYPO3')) {
	die ('Access denied.');
}
$versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
$typo3Version = $versionInformation->getMajorVersion();
if ($typo3Version > 11) {
    $renderTypeLinkField = 'link';
    $renderTypeDatetime = 'dateTime';
} else {
    $renderTypeLinkField = 'inputLink';
    $renderTypeDatetime = 'inputDateTime';
}
return [
	'ctrl' => [
                'title' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_assistance',
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
                'searchFields' => 'title,description,link,',
                'typeicon_classes' => ['default' => 'ext-operations-assistance']
    ],
	'types' => [
		'0' => ['showitem' => 'sys_language_uid;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language,l10n_parent;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent,l10n_diffsource,hidden;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden,title,description,link'
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
				'foreign_table' => 'tx_operations_domain_model_assistance',
				'foreign_table_where' => 'AND tx_operations_domain_model_assistance.pid=###CURRENT_PID### AND tx_operations_domain_model_assistance.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_assistance.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
                'required' => true
            ],
        ],
		'description' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_assistance.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
            ],
        ],
		'link' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_assistance.link',
			'config' => [
				'type' => 'input',
                'renderType' => $renderTypeLinkField,
				'size' => 30,
				'eval' => 'trim',
            ],
        ],
    ],
];

<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// get first main part of TYPO3 version number
$currentTypo3Version = \KN\Operations\Utility\Div::getPartOfTypo3Version();
$iconPath = ExtensionManagementUtility::extRelPath('operations');

ExtensionManagementUtility::addToInsertRecords('tx_operations_domain_model_resource');

$tx_operations_domain_model_resource = array(
	'ctrl' => array(
                'title' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_resource',
                'label' => 'title',
                'tstamp' => 'tstamp',
                'crdate' => 'crdate',
                'cruser_id' => 'cruser_id',
                'dividers2tabs' => TRUE,
                'sortby' => 'sorting',
                'versioningWS' => 2,
                'versioning_followPages' => TRUE,
                'origUid' => 't3_origuid',
                'languageField' => 'sys_language_uid',
                'transOrigPointerField' => 'l10n_parent',
                'transOrigDiffSourceField' => 'l10n_diffsource',
                'delete' => 'deleted',
                'enablecolumns' => array(
                        'disabled' => 'hidden',
                        'starttime' => 'starttime',
                        'endtime' => 'endtime',
                ),
                'searchFields' => 'title,short,description,image,',
                'iconfile' => $iconPath . '/Resources/Public/Icons/tx_operations_domain_model_resource.png',
                'typeicon_classes' => \KN\Operations\Utility\Div::getTypeIconClasses('ext-operations-resource')
        ),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, short, description, image',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, short, description,
		--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.img,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitleResources.img;paletteImg,
		--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'paletteImg' => array(
			'showitem' => 'image',
			'canNotCollapse' => 'TRUE'
		),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_operations_domain_model_resource',
				'foreign_table_where' => 'AND tx_operations_domain_model_resource.pid=###CURRENT_PID### AND tx_operations_domain_model_resource.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_resource.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'short' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_resource.short',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_resource.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => \KN\Operations\Utility\Div::getWizardIcon('rte',$currentTypo3Version),
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'module' => array(
							'name' => 'wizard_rte',
						),
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
			'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts]',
		),
		// mit FAL
		'image' => array(
				'exclude' => 1,
				'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_resource.image',
				'config' => ExtensionManagementUtility::getFileFieldTCAConfig('image', array(
					'appearance' => array(
						'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
					),
					'foreign_types' => array(
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
					)
				), $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
			),
	),
);

return $tx_operations_domain_model_resource;

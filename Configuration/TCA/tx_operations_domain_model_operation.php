<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// get first main part of TYPO3 version number
$currentTypo3Version = \KN\Operations\Utility\Div::getPartOfTypo3Version();
$iconPath = ExtensionManagementUtility::extPath('operations');

ExtensionManagementUtility::addToInsertRecords('tx_operations_domain_model_operation');

$tx_operations_domain_model_operation = array(
	'ctrl' => array(
                'title' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation',
                'label' => 'title',
                'tstamp' => 'tstamp',
                'crdate' => 'crdate',
                'cruser_id' => 'cruser_id',
                'dividers2tabs' => TRUE,
                //'sortby' => 'sorting',
                'default_sortby' => 'ORDER BY begin DESC',
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
                'searchFields' => 'number,title,location,begin,end,report,longitude,latitude,zoom,image,type,assistance,vehicles,resources,',
                'iconfile' => $iconPath . '/Resources/Public/Icons/tx_operations_domain_model_operation.png',
                'typeicon_classes' => \KN\Operations\Utility\Div::getTypeIconClasses('ext-operations-operation'),
        ),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, number, onlyEld, title, location, begin, end, teaser, report, longitude, latitude, zoom, image, type, assistance, vehicles, resources',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource;;1,
		--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.meta;paletteMeta,
		title, location,
		--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.time;paletteTime,
		teaser,report,
		--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.map,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.coordinates;paletteMap,
		--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.relations,assistance,vehicles, resources,
		--div--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.divTitle.img,--palette--;LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tca.paletteTitle.img;paletteImg,
		--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, hidden, starttime, endtime'),
	),
	'palettes' => array(
		'paletteMap' => array(
			'showitem' => 'latitude,--linebreak--,longitude,
			--linebreak--,zoom',
			'canNotCollapse' => 'TRUE'
		),
		'paletteImg' => array(
			'showitem' => 'image',
			'canNotCollapse' => 'TRUE'
		),
		'paletteTime' => array(
			'showitem' => 'begin,end',
			'canNotCollapse' => 'TRUE'
		),
		'paletteMeta' => array(
			'showitem' => 'number, type, onlyEld',
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
				'foreign_table' => 'tx_operations_domain_model_operation',
				'foreign_table_where' => 'AND tx_operations_domain_model_operation.pid=###CURRENT_PID### AND tx_operations_domain_model_operation.sys_language_uid IN (-1,0)',
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
		'number' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.number',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim,required'
			),
		),
		'onlyEld' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.onlyEld',
			'config' => array(
				'type' => 'check',
			),
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.title',
			'config' => array(
				'type' => 'input',
				'size' => 60,
				'eval' => 'trim,required'
			),
		),
		'location' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.location',
			'config' => array(
				'type' => 'text',
				'cols' => 60,
				'rows' => 3,
				'eval' => 'trim,required'
			),
		),
		'begin' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.begin',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime,required',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'end' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.end',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'teaser' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.teaser',
			'config' => array(
				'type' => 'text',
				'cols' => 60,
				'rows' => 5,
				'eval' => 'trim'
			),
		),
		'report' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.report',
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
							'name' => 'wizard_rte'
						),
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
			'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts]',
		),
		'longitude' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.longitude',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'latitude' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.latitude',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'zoom' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.zoom',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'image' => array(
				'exclude' => 1,
				'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.image',
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
		'type' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.type',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_operations_domain_model_type',
				'MM' => 'tx_operations_operation_type_mm',
				'size' => 1,
				'autoSizeMax' => 40,
				'minItems' => 0,
				'maxitems' => 1,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
				),
				'renderType' => 'selectSingle',
				'items' => array(
					array('LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.choose','0')
				)
			),
		),
		'assistance' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.assistance',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_operations_domain_model_assistance',
				'MM' => 'tx_operations_operation_assistance_mm',
				'size' => 10,
				'autoSizeMax' => 40,
				'minitems' => 0,
				'maxitems' => 9999,
				'multiple' => 0,
				'renderType' => 'selectMultipleSideBySide',
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'module' => array(
							'name' => 'wizard_edit'
						),
						'icon' => \KN\Operations\Utility\Div::getWizardIcon('edit',$currentTypo3Version),
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => \KN\Operations\Utility\Div::getWizardIcon('add',$currentTypo3Version),
						'params' => array(
							'table' => 'tx_operations_domain_model_assistance',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'module' => array(
							'name' => 'wizard_add'
						),
					),
				),
			),
		),
		'vehicles' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.vehicles',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_operations_domain_model_vehicle',
				'MM' => 'tx_operations_operation_vehicle_mm',
				'size' => 10,
				'autoSizeMax' => 40,
				'minitems' => 0,
				'maxitems' => 9999,
				'multiple' => 0,
				'renderType' => 'selectMultipleSideBySide',
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'module' => array(
							'name' => 'wizard_edit'
						),
						'icon' => \KN\Operations\Utility\Div::getWizardIcon('edit',$currentTypo3Version),
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => \KN\Operations\Utility\Div::getWizardIcon('add',$currentTypo3Version),
						'params' => array(
							'table' => 'tx_operations_domain_model_vehicle',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'module' => array(
							'name' => 'wizard_add'
						),
					),
				),
			),
		),
		'resources' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:operations/Resources/Private/Language/locallang_db.xlf:tx_operations_domain_model_operation.resources',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_operations_domain_model_resource',
				'MM' => 'tx_operations_operation_resource_mm',
				'size' => 10,
				'autoSizeMax' => 40,
				'minitems' => 0,
				'maxitems' => 9999,
				'multiple' => 0,
				'renderType' => 'selectMultipleSideBySide',
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'module' => array(
							'name' => 'wizard_edit'
						),
						'icon' => \KN\Operations\Utility\Div::getWizardIcon('edit',$currentTypo3Version),
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => \KN\Operations\Utility\Div::getWizardIcon('add',$currentTypo3Version),
						'params' => array(
							'table' => 'tx_operations_domain_model_resource',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'module' => array(
							'name' => 'wizard_add'
						),
					),
				),
			),
		),
	),
);

return $tx_operations_domain_model_operation;

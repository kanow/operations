<?php

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Operations',
	'description' => 'Manage (firefighter,Feuerwehr) operations with detailed reports, images used resources or vehicles, map view for locations. Possibly to use it for other reportable events like THW and so on.',
	'category' => 'plugin',
	'version' => '3.0.0',
	'state' => 'beta',
	'uploadfolder' => true,
	'createDirs' => '',
	'clearcacheonload' => true,
	'author' => 'Karsten Nowak',
	'author_email' => 'captnnowi@gmx.de',
	'author_company' => 'undkonsorten',
	'constraints' => array (
		'depends' => array (
			'typo3' => '9.5.0 - 9.5.99',
		),
		'conflicts' => array (
		),
		'suggests' => array (
		),
	),
);

<?php

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Operations',
	'description' => 'Manage (firefighter,Feuerwehr) operations with detailed reports, images used resources or vehicles, google map view for locations, slider and lightbox for images. Possibly to use it for other reportable events like THW and so on.',
	'category' => 'plugin',
	'version' => '2.0.0',
	'state' => 'beta',
	'uploadfolder' => true,
	'createDirs' => '',
	'clearcacheonload' => false,
	'author' => 'Karsten Nowak',
	'author_email' => 'captnnowi@gmx.de',
	'author_company' => 'undkonsorten',
	'constraints' => array (
		'depends' => array (
			'php' => '5.6',
			'typo3' => '8.7.0 - 8.7.99',
		),
		'conflicts' => array (
		),
		'suggests' => array (
		),
	),
);

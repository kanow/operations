<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "operations".
 *
 * Auto generated 31-07-2014 23:32
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Operations',
	'description' => 'Manage (firefighter,Feuerwehr) operations with detailed reports, images used resources or vehicles, google map view for locations, slider and lightbox for images. Possibly to use it for other reportable events like THW and so on.',
	'category' => 'plugin',
	'version' => '1.3.5',
	'state' => 'beta',
	'uploadfolder' => true,
	'createDirs' => '',
	'clearcacheonload' => false,
	'author' => 'Karsten Nowak',
	'author_email' => 'captnnowi@gmx.de',
	'author_company' => 'undkonsorten',
	'constraints' =>
	array (
		'depends' =>
		array (
			'extbase' => '6.2',
			'fluid' => '6.2',
			'typo3' => '6.2.0-7.6.99',
		),
		'conflicts' =>
		array (
		),
		'suggests' =>
		array (
		),
	),
);

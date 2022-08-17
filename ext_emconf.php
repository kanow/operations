<?php

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Operations',
	'description' => 'TYPO3 extension to manage firefighter operations with detailed reports, images, used resources or vehicles, map view for locations. Use extension fire_department to build a complete website for fire departments.',
	'category' => 'plugin',
	'version' => '7.1.1',
	'state' => 'stable',
	'clearCacheOnLoad' => true,
	'author' => 'Karsten Nowak',
	'author_email' => 'captnnowi@gmx.de',
	'author_company' => 'undkonsorten',
	'constraints' => array (
		'depends' => array (
			'typo3' => '11.5.0 - 11.5.99',
			'numbered-pagination' => '1.0.2 - 0.0.0',
		),
        'conflicts' => array (
        ),
        'suggests' => array (
            'fire_department' => '1.1.0 - 0.0.0',
        ),
	),
);

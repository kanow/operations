<?php

/**
 * Only required for TER and tailor. Since TYPO3 v14.2 the extension metadata
 * is read from composer.json.
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'Operations',
    'description' => 'TYPO3 extension to manage firefighter operations with detailed reports, images, used resources or vehicles, map view for locations.',
    'category' => 'plugin',
    'version' => '8.2.0',
    'state' => 'stable',
    'author' => 'Karsten Nowak',
    'author_email' => 'captnnowi@gmx.de',
    'author_company' => 'undkonsorten',
    'constraints' => [
        'depends' => [
            'php' => '8.2.0-8.5.99',
            'typo3' => '14.3.0-14.3.99',
            'backend' => '14.3.0-14.3.99',
            'extbase' => '14.3.0-14.3.99',
            'fluid' => '14.3.0-14.3.99',
            'frontend' => '14.3.0-14.3.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

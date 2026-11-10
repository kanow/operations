<?php

declare(strict_types=1);

use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;
use TYPO3\CodingStandards\CsFixerConfig;

$config = CsFixerConfig::create();
$config->addRules([
    // Do not lowercase "meta" types like "resource": the domain model
    // Kanow\Operations\Domain\Model\Resource is referenced in docblocks
    // (e.g. ObjectStorage<Resource>), which Extbase evaluates for mapping.
    'phpdoc_types' => ['groups' => ['simple', 'alias']],
]);

// @TODO 4.0 no need to call this manually
$config->setParallelConfig(ParallelConfigFactory::detect());

$config->getFinder()
    ->in('Classes')
    ->in('Configuration')
    ->in('Tests')
    ->append([
        'ext_emconf.php',
        'ext_localconf.php',
    ]);
return $config;

<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;

return static function (Configuration $config): Configuration {
    // Only used in Fluid templates and TypoScript, not in PHP code
    $config->addNamedFilter(NamedFilter::fromString('typo3/cms-fluid'));
    $config->addNamedFilter(NamedFilter::fromString('typo3/cms-frontend'));

    return $config;
};

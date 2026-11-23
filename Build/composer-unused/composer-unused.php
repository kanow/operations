<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;

return static function (Configuration $config): Configuration {
    // These packages are only used via Fluid templates and TypoScript,
    // so composer-unused cannot detect their usage in the PHP code.
    $config->addNamedFilter(NamedFilter::fromString('typo3/cms-fluid'));
    $config->addNamedFilter(NamedFilter::fromString('typo3/cms-frontend'));

    return $config;
};

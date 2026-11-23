<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;

return static function (Configuration $config): Configuration {
    // typo3/cms-frontend is only used via TypoScript and request attributes,
    // so composer-unused cannot detect its usage in the PHP code.
    $config->addNamedFilter(NamedFilter::fromString('typo3/cms-frontend'));

    return $config;
};

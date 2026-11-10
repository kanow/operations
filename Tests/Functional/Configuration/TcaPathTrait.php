<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Configuration;

use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * Provides typed access to the TCA for the configuration tests.
 */
trait TcaPathTrait
{
    /**
     * @param non-empty-string $path path separated by "/", e.g. "tt_content/ctrl/typeicon_classes"
     */
    private static function getTcaValue(string $path): mixed
    {
        $tca = $GLOBALS['TCA'] ?? null;
        self::assertIsArray($tca);

        return ArrayUtility::isValidPath($tca, $path) ? ArrayUtility::getValueByPath($tca, $path) : null;
    }

    /**
     * @param non-empty-string $path
     *
     * @return array<array-key, mixed>
     */
    private static function getTcaArray(string $path): array
    {
        $value = self::getTcaValue($path);
        self::assertIsArray($value, 'TCA path "' . $path . '" is no array.');

        return $value;
    }

    /**
     * @return list<array<array-key, mixed>>
     */
    private static function getContentTypeItems(): array
    {
        $items = array_filter(
            self::getTcaArray('tt_content/columns/CType/config/items'),
            static fn(mixed $item): bool => is_array($item) && in_array($item['value'] ?? null, TcaTest::CONTENT_TYPES, true)
        );

        return array_values(array_filter($items, 'is_array'));
    }
}

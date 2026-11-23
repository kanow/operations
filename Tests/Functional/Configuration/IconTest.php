<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Configuration;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks that all icons used in the TCA are registered (Configuration/Icons.php).
 */
#[CoversNothing]
final class IconTest extends FunctionalTestCase
{
    use TcaPathTrait;

    protected array $testExtensionsToLoad = ['kanow/operations'];

    /**
     * @return \Generator<string, array{0: string}>
     */
    public static function tableDataProvider(): \Generator
    {
        foreach (TcaTest::TABLES as $table) {
            yield $table => [$table];
        }
    }

    /**
     * @return \Generator<string, array{0: string}>
     */
    public static function contentTypeDataProvider(): \Generator
    {
        foreach (TcaTest::CONTENT_TYPES as $contentType) {
            yield $contentType => [$contentType];
        }
    }

    #[Test]
    #[DataProvider('tableDataProvider')]
    public function recordIconsOfTableAreRegistered(string $table): void
    {
        $typeIcons = self::getTcaArray($table . '/ctrl/typeicon_classes');
        self::assertNotSame([], $typeIcons);

        $iconRegistry = $this->get(IconRegistry::class);
        foreach ($typeIcons as $iconIdentifier) {
            self::assertIsString($iconIdentifier);
            self::assertTrue($iconRegistry->isRegistered($iconIdentifier), 'Icon "' . $iconIdentifier . '" is not registered.');
        }
    }

    #[Test]
    #[DataProvider('contentTypeDataProvider')]
    public function contentTypeIconIsRegistered(string $contentType): void
    {
        $iconIdentifier = self::getTcaValue('tt_content/ctrl/typeicon_classes/' . $contentType);

        self::assertIsString($iconIdentifier);
        self::assertTrue($this->get(IconRegistry::class)->isRegistered($iconIdentifier), 'Icon "' . $iconIdentifier . '" is not registered.');
    }

    #[Test]
    #[DataProvider('contentTypeDataProvider')]
    public function iconOfContentTypeItemIsRegistered(string $contentType): void
    {
        $matchingItems = array_values(array_filter(
            self::getContentTypeItems(),
            static fn(array $item): bool => ($item['value'] ?? null) === $contentType
        ));
        self::assertCount(1, $matchingItems);

        $iconIdentifier = $matchingItems[0]['icon'] ?? null;
        self::assertIsString($iconIdentifier);
        self::assertTrue($this->get(IconRegistry::class)->isRegistered($iconIdentifier), 'Icon "' . $iconIdentifier . '" is not registered.');
    }
}

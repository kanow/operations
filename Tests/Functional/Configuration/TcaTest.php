<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Configuration;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Configuration\Tca\TcaFactory;
use TYPO3\CMS\Core\Configuration\Tca\TcaMigration;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the TCA of the extension (Configuration/TCA).
 */
#[CoversNothing]
final class TcaTest extends FunctionalTestCase
{
    use TcaPathTrait;

    public const TABLES = [
        'tx_operations_domain_model_assistance',
        'tx_operations_domain_model_operation',
        'tx_operations_domain_model_resource',
        'tx_operations_domain_model_type',
        'tx_operations_domain_model_vehicle',
    ];

    public const CONTENT_TYPES = [
        'operations_operationlist',
        'operations_operationshow',
        'operations_operationstatistics',
        'operations_vehiclelist',
        'operations_vehicleshow',
        'operations_resourcelist',
        'operations_resourceshow',
    ];

    protected array $testExtensionsToLoad = ['kanow/operations'];

    /**
     * @return \Generator<string, array{0: string}>
     */
    public static function tableDataProvider(): \Generator
    {
        foreach (self::TABLES as $table) {
            yield $table => [$table];
        }
    }

    /**
     * @return \Generator<string, array{0: string}>
     */
    public static function contentTypeDataProvider(): \Generator
    {
        foreach (self::CONTENT_TYPES as $contentType) {
            yield $contentType => [$contentType];
        }
    }

    /**
     * Runs the TCA migration on the TCA as it is provided by the extensions (without the migration done during
     * bootstrap) and returns all migration messages.
     *
     * @return list<string>
     */
    private function getTcaMigrationMessages(): array
    {
        $tcaBackup = $GLOBALS['TCA'] ?? null;
        try {
            $notMigratedTca = $this->get(TcaFactory::class)->createNotMigrated();
        } finally {
            // The TcaFactory unsets $GLOBALS['TCA'].
            $GLOBALS['TCA'] = $tcaBackup;
        }

        return array_values(array_map('strval', (new TcaMigration())->migrate($notMigratedTca)->getMessages()));
    }

    #[Test]
    #[DataProvider('tableDataProvider')]
    public function tableIsDefined(string $table): void
    {
        self::assertNotSame([], self::getTcaArray($table . '/columns'));
    }

    #[Test]
    #[DataProvider('tableDataProvider')]
    public function tableNeedsNoTcaMigration(string $table): void
    {
        $messages = array_filter(
            $this->getTcaMigrationMessages(),
            static fn(string $message): bool => str_contains($message, $table)
        );

        self::assertSame([], array_values($messages));
    }

    #[Test]
    public function ttContentNeedsNoTcaMigration(): void
    {
        $messages = array_filter(
            $this->getTcaMigrationMessages(),
            static fn(string $message): bool => str_contains($message, 'tt_content')
        );

        self::assertSame([], array_values($messages));
    }

    #[Test]
    #[DataProvider('contentTypeDataProvider')]
    public function contentTypeIsRegisteredAsSelectableItem(string $contentType): void
    {
        $values = array_map(static fn(array $item): mixed => $item['value'] ?? null, self::getContentTypeItems());

        self::assertContains($contentType, $values);
    }

    #[Test]
    #[DataProvider('contentTypeDataProvider')]
    public function contentTypeShowsFlexFormAndRecordStorageFields(string $contentType): void
    {
        $showItem = self::getTcaValue('tt_content/types/' . $contentType . '/showitem');
        self::assertIsString($showItem);

        self::assertStringContainsString('pi_flexform', $showItem);
        self::assertStringContainsString('pages', $showItem);
        self::assertStringContainsString('recursive', $showItem);
    }

    #[Test]
    #[DataProvider('contentTypeDataProvider')]
    public function contentTypeHasOwnFlexFormDataStructure(string $contentType): void
    {
        $dataStructure = self::getTcaValue('tt_content/types/' . $contentType . '/columnsOverrides/pi_flexform/config/ds');

        self::assertIsString($dataStructure);
        self::assertStringStartsWith('FILE:EXT:operations/Configuration/FlexForms/', $dataStructure);
    }
}

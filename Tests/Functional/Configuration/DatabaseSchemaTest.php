<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Configuration;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Database\Schema\Information\ColumnInfo;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the database schema created from TCA and ext_tables.sql.
 */
#[CoversNothing]
final class DatabaseSchemaTest extends FunctionalTestCase
{
    private const INTEGER_TYPES = ['integer', 'smallint', 'bigint'];

    protected array $testExtensionsToLoad = ['kanow/operations'];

    /**
     * Relation fields store the number of relations, date fields store timestamps.
     *
     * @return \Generator<string, array{0: string, 1: string}>
     */
    public static function integerColumnDataProvider(): \Generator
    {
        $columnsByTable = [
            'tx_operations_domain_model_operation' => [
                'onlyEld', 'begin', 'end', 'zoom', 'media', 'type', 'assistance', 'vehicles', 'resources', 'category',
            ],
            'tx_operations_domain_model_vehicle' => ['media'],
            'tx_operations_domain_model_resource' => ['media'],
            'tx_operations_domain_model_type' => ['image'],
        ];
        foreach ($columnsByTable as $table => $columns) {
            foreach ($columns as $column) {
                yield $table . '.' . $column => [$table, $column];
            }
        }
    }

    /**
     * @return \Generator<string, array{0: string, 1: string}>
     */
    public static function textColumnDataProvider(): \Generator
    {
        $columnsByTable = [
            'tx_operations_domain_model_operation' => [
                'title', 'number', 'location', 'teaser', 'report', 'latitude', 'longitude', 'path_segment',
            ],
            'tx_operations_domain_model_vehicle' => ['title', 'short', 'description', 'link', 'path_segment'],
            'tx_operations_domain_model_resource' => ['title', 'short', 'description', 'link', 'path_segment'],
            'tx_operations_domain_model_type' => ['title', 'color'],
            'tx_operations_domain_model_assistance' => ['title', 'description', 'link'],
        ];
        foreach ($columnsByTable as $table => $columns) {
            foreach ($columns as $column) {
                yield $table . '.' . $column => [$table, $column];
            }
        }
    }

    /**
     * @return \Generator<string, array{0: string}>
     */
    public static function mmTableDataProvider(): \Generator
    {
        yield 'type' => ['tx_operations_operation_type_mm'];
        yield 'assistance' => ['tx_operations_operation_assistance_mm'];
        yield 'vehicles' => ['tx_operations_operation_vehicle_mm'];
        yield 'resources' => ['tx_operations_operation_resource_mm'];
    }

    private function getColumnInfo(string $table, string $column): ColumnInfo
    {
        $columnInfo = $this->getConnectionPool()->getConnectionForTable($table)
            ->getSchemaInformation()->getTableInfo($table)->getColumnInfo($column);
        self::assertInstanceOf(ColumnInfo::class, $columnInfo, 'Column "' . $table . '.' . $column . '" does not exist.');

        return $columnInfo;
    }

    #[Test]
    #[DataProvider('integerColumnDataProvider')]
    public function columnExistsAsIntegerColumn(string $table, string $column): void
    {
        self::assertContains($this->getColumnInfo($table, $column)->typeName, self::INTEGER_TYPES);
    }

    #[Test]
    #[DataProvider('textColumnDataProvider')]
    public function columnExistsAsTextColumn(string $table, string $column): void
    {
        self::assertContains($this->getColumnInfo($table, $column)->typeName, ['string', 'text']);
    }

    /**
     * The column is defined in ext_tables.sql, because the column created from TCA type "color" would only be
     * varchar(7).
     */
    #[Test]
    public function colorColumnOfTypeKeepsItsLength(): void
    {
        $columnInfo = $this->getColumnInfo('tx_operations_domain_model_type', 'color');

        self::assertSame('string', $columnInfo->typeName);
        self::assertSame(25, $columnInfo->length);
    }

    #[Test]
    #[DataProvider('mmTableDataProvider')]
    public function mmTableExistsWithRelationColumns(string $table): void
    {
        foreach (['uid_local', 'uid_foreign', 'sorting', 'sorting_foreign'] as $column) {
            self::assertContains($this->getColumnInfo($table, $column)->typeName, self::INTEGER_TYPES);
        }
    }
}

<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Utility;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MariaDBPlatform;
use Doctrine\DBAL\Platforms\MySQL80Platform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Kanow\Operations\Utility\SqlUtility;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(SqlUtility::class)]
final class SqlUtilityTest extends UnitTestCase
{
    /**
     * @return \Generator<string, array{0: AbstractPlatform, 1: string}>
     */
    public static function selectYearFromUnixTimeDataProvider(): \Generator
    {
        yield 'MySQL' => [new MySQLPlatform(), "FROM_UNIXTIME(o.begin, '%Y')"];
        yield 'MySQL 8.0' => [new MySQL80Platform(), "FROM_UNIXTIME(o.begin, '%Y')"];
        yield 'MariaDB' => [new MariaDBPlatform(), "FROM_UNIXTIME(o.begin, '%Y')"];
        yield 'PostgreSQL' => [new PostgreSQLPlatform(), 'EXTRACT(YEAR FROM TO_TIMESTAMP(o.begin))'];
        yield 'SQLite' => [new SQLitePlatform(), "STRFTIME('%Y', DATETIME(o.begin, 'unixepoch'))"];
    }

    #[Test]
    #[DataProvider('selectYearFromUnixTimeDataProvider')]
    public function getSelectYearFromUnixTimeReturnsPlatformSpecificExpression(
        AbstractPlatform $platform,
        string $expected
    ): void {
        $connection = $this->createConnectionStub($platform);

        self::assertSame($expected, SqlUtility::getSelectYearFromUnixTime($connection, 'o.begin'));
    }

    /**
     * @return \Generator<string, array{0: AbstractPlatform, 1: list<int|string>, 2: string}>
     */
    public static function whereYearInStringDataProvider(): \Generator
    {
        yield 'MySQL with one year' => [new MySQLPlatform(), ['2024'], 'IN(2024)'];
        yield 'MySQL with several years' => [new MySQLPlatform(), ['2022', '2023', '2024'], 'IN(2022,2023,2024)'];
        yield 'MySQL 8.0 with several years' => [new MySQL80Platform(), ['2023', '2024'], 'IN(2023,2024)'];
        yield 'MariaDB with several years' => [new MariaDBPlatform(), ['2023', '2024'], 'IN(2023,2024)'];
        yield 'MariaDB with integer years' => [new MariaDBPlatform(), [2023, 2024], 'IN(2023,2024)'];
        yield 'PostgreSQL with one year' => [new PostgreSQLPlatform(), ['2024'], 'IN(2024)'];
        yield 'PostgreSQL with several years' => [new PostgreSQLPlatform(), ['2023', '2024'], 'IN(2023,2024)'];
        yield 'SQLite with one year' => [new SQLitePlatform(), ['2024'], "IN('2024')"];
        yield 'SQLite with several years' => [new SQLitePlatform(), ['2023', '2024'], "IN('2023','2024')"];
        yield 'SQLite with integer years' => [new SQLitePlatform(), [2023, 2024], "IN('2023','2024')"];
    }

    /**
     * @param list<int|string> $years
     */
    #[Test]
    #[DataProvider('whereYearInStringDataProvider')]
    public function getWhereYearInStringReturnsPlatformSpecificExpression(
        AbstractPlatform $platform,
        array $years,
        string $expected
    ): void {
        $connection = $this->createConnectionStub($platform);

        self::assertSame($expected, SqlUtility::getWhereYearInString($connection, $years));
    }

    private function createConnectionStub(AbstractPlatform $platform): Connection
    {
        $connection = self::createStub(Connection::class);
        $connection->method('getDatabasePlatform')->willReturn($platform);

        return $connection;
    }
}

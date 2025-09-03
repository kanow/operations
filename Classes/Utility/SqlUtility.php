<?php

namespace Kanow\Operations\Utility;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use TYPO3\CMS\Core\Database\Connection;

class SqlUtility
{

    public static function getSelectYearFromUnixTime(Connection $connection): string
    {
        $isPostgres = $connection->getDatabasePlatform() instanceof PostgreSQLPlatform;
        $isSqlite = $connection->getDatabasePlatform() instanceof SQLitePlatform;
        if($isPostgres) {
            return 'EXTRACT(YEAR FROM TO_TIMESTAMP(o.begin))';
        } elseif ($isSqlite) {
            return 'STRFTIME(\'%Y\', DATETIME(o.begin, \'unixepoch\'))';
        } else {
            return 'FROM_UNIXTIME(o.begin, \'%Y\')';
        }
    }

    public static function getWhereYearInString(Connection $connection, array $years): string
    {
        $isPostgres = $connection->getDatabasePlatform() instanceof PostgreSQLPlatform;
        $isSqlite = $connection->getDatabasePlatform() instanceof SQLitePlatform;
        if($isPostgres) {
            return 'IN(' . self::convertYearsToString($years) . ')';
        } elseif ($isSqlite) {
            return 'IN(' . self::convertYearsToStringForSqlite($years) . ')';
        } else {
            return 'IN(' . self::convertYearsToString($years) . ')';
        }
    }

    /*
     *  convert years array to comma separated list
     *  which can be check in sql
     *
     * @param array $years
     * @return string
     */
    private static function convertYearsToString(array $years): string
    {
        return implode(',', $years);
    }

    /*
     *  convert years array to comma separated list
     *  and wrapped with '' to get proper result in sqlite databases
     *
     * @param array $years
     * @return string
     */
    private static function convertYearsToStringForSqlite(array $years): string
    {
        // Every year must be set between '' to get a proper list for sqlite
        return implode(',', array_map(function(string $year) {
            return "'$year'";
        }, $years));
    }

}

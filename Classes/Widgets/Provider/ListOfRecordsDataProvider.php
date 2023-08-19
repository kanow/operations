<?php
declare(strict_types=1);

namespace Kanow\Operations\Widgets\Provider;

use Kanow\Operations\Widgets\ListOfRecordsDataProviderInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Provides records based on following configuration:
 * - table           string         The table the records should be fetched from
 * - limit           int            The maximum number of records to be fetched
 * - orderField      string         The order field
 * - order           string         The order direction
 *
 *
 * @author Karsten Nowak <captnnowi@gmx.de>
 */
class ListOfRecordsDataProvider implements ListOfRecordsDataProviderInterface
{
    private string $table;
    private int $limit;
    private string $orderField;
    private string $order;

    public function __construct(string $table, int $limit = 5, string $orderField = 'uid', string $order = 'DESC')
    {
        $this->table = $table;
        $this->limit = $limit;
        $this->orderField = $orderField;
        $this->order = $order;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getItems(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->table);
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        return $queryBuilder
            ->select('*')
            ->from($this->table)
            ->setMaxResults($this->limit)
            ->addOrderBy($this->orderField, $this->order)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}

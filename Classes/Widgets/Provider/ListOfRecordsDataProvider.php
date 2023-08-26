<?php
declare(strict_types=1);

namespace Kanow\Operations\Widgets\Provider;

use Kanow\Operations\Widgets\ListOfRecordsDataProviderInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
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
    private bool $onlyHidden;

    public function __construct(string $table, int $limit = 5, string $orderField = 'uid', string $order = 'DESC', bool $onlyHidden = false)
    {
        $this->table = $table;
        $this->limit = $limit;
        $this->orderField = $orderField;
        $this->order = $order;
        $this->onlyHidden = $onlyHidden;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getItems(): array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->table);
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $queryBuilder
            ->select('*')
            ->from($this->table)
            ->setMaxResults($this->limit)
            ->addOrderBy($this->orderField, $this->order);
        if($this->onlyHidden) {
            $queryBuilder->where(
                $queryBuilder->expr()->eq('hidden', $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT))
            );
        } else {
            $queryBuilder
            ->getRestrictions()
            ->add(GeneralUtility::makeInstance(HiddenRestriction::class));
        }
        return $queryBuilder
            ->executeQuery()
            ->fetchAllAssociative();
    }
}

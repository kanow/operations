<?php
declare(strict_types=1);

namespace Kanow\Operations\Widgets;

/**
 * Interface for all data providers which fetches a list
 * of records from a given table.
 *
 * @author Karsten Nowak <captnnowi@gmx.de>
 */
interface ListOfRecordsDataProviderInterface
{
    /**
     * Return the table, the records are fetched from
     *
     * @return string
     */
    public function getTable(): string;

    /**
     * Return the records to be shown
     *
     * @return array
     */
    public function getItems(): array;
}

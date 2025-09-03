<?php

namespace Kanow\Operations\Domain\Repository;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Kanow\Operations\Domain\Model\Category;
use Kanow\Operations\Domain\Model\Operation;
use Kanow\Operations\Domain\Model\OperationDemand;
use Kanow\Operations\Domain\Model\Type;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Karsten Nowak <captnnowi@gmx.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @extends Repository<Operation>
 */
class OperationRepository extends Repository
{
    /**
     * default ordering
     *
     * @return array
     */
    protected $defaultOrderings = [
        'begin' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Returns the objects of this repository matching the demand
     *
     * @param OperationDemand $demand
     * @param array<mixed> $settings
     * @return QueryResultInterface<Operation>
     * @throws InvalidQueryException
     */
    public function findDemanded(OperationDemand $demand, array $settings): QueryResultInterface
    {
        $query = $this->generateQuery($demand, $settings);
        return $query->execute();
    }

    /**
     * Category Returns the raw query result of this repository matching the demand
     *
     * @param OperationDemand $demand
     * @param array<mixed> $settings
     * @return array<int,Operation>
     * @throws InvalidQueryException
     */
    public function findDemandedForStatistics(OperationDemand $demand, array $settings): array
    {
        $query = $this->generateQuery($demand, $settings, (bool)($settings['noLimitForStatistics'] ?? false));
        return $query->execute(true);
    }

    /**
     * Counts all available operations
     * @param OperationDemand $demand
     * @param array<mixed> $settings
     * @return int
     * @throws InvalidQueryException
     */
    public function countDemandedForStatistics(OperationDemand $demand, array $settings): int
    {
        return count($this->findDemandedForStatistics($demand, $settings));
    }

    /**
     * Counts all available operations grouped by a year and type
     * Optionally use operation uid list, which created before with category constraints
     *
     * @param array $years
     * @param array $types
     * @param string $operationUids
     * @return array
     */
    public function countGroupedByYearAndType(array $years, array $types, string $operationUids = ''): array
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connection->getQueryBuilderForTable('tx_operations_domain_model_operation');
        $connection = $connection->getConnectionForTable('tx_operations_domain_model_operation');

        $result = $queryBuilder
            ->addSelectLiteral('MIN(ot.color) as color, MIN(ot.title) as title, ot.uid as type_uid, COUNT(*) as count, '. $this->getSelectYearFromUnixTime($connection, $years) . ' as year')
            ->from('tx_operations_domain_model_type', 'ot')
            ->innerJoin('ot', 'tx_operations_operation_type_mm', 'type_mm', 'type_mm.uid_foreign = ot.uid')
            ->innerJoin('type_mm', 'tx_operations_domain_model_operation', 'o', 'type_mm.uid_local = o.uid')
            ->where($this->getSelectYearFromUnixTime($connection, $years) . $this->getWhereYearInString($connection, $years));
        if ($operationUids != '') {
            $result = $result->andWhere('o.uid IN (' . $operationUids . ')');
        }
        $result = $result->groupBy('year')
           ->addGroupBy('ot.uid')
           ->executeQuery()->fetchAllAssociative();

        $preparedResult = $this->prepareResultForChartArray($result);

        foreach ($years as $year) {
            // add empty years to result
            $preparedResult = $this->addEmptyYear($preparedResult, $year);
            // add missing types to result
            $preparedResult = $this->addMissingType($preparedResult, $types, $year);
        }
        $resultWithEmptyYearsSorted = $this->sortResultByYears($preparedResult);
        $resultWithEmptyYearsSorted = $this->sortResultByTypeUid($resultWithEmptyYearsSorted);

        return $resultWithEmptyYearsSorted;
    }

    /**
     * Prepare result for Chart.
     * the "type_uid" will be the array key for the result instead of ascending uids
     * the "year" will be the array key in new array key "years" with "count" as value
     *
     * @param array $result
     * @return array $preparedResult
     * @throws Exception
     */
    protected function prepareResultForChartArray(array $result): array
    {
        $preparedResult = [];

        foreach ($result as $key => $value) {
            $title = $this->getTypeTitle($value);
            if (!array_key_exists($value['type_uid'], $preparedResult)) {
                $preparedResult[$value['type_uid']] = [
                    'title' => $title,
                    'color' => $value['color'],
                    'years' => [
                        $value['year'] => $value['count'],
                    ],
                ];
            } else {
                $preparedResult[$value['type_uid']]['years'][$value['year']] = $value['count'];
            }
        }
        return $preparedResult;
    }

    /*
     * add missing type (no operations in year
     *
     * @param array<mixed> $data
     * @param array<Type> $types
     * @param int $year
     * @return array
     */
    protected function addMissingType(array $data, array $types, int $year): array
    {
        foreach ($types as $type) {
            /** @var Type $type */
            if (!array_key_exists($type->getUid(), $data)) {
                $data[$type->getUid()]['title'] =  $type->getTitle();
                $data[$type->getUid()]['color'] =  $type->getColor();
                $data[$type->getUid()]['years'][$year] = 0;
            }
        }
        return $data;
    }

    /*
     * Add empty years to result array
     *
     * @param array $data
     * @param int $year
     * @return array
     */
    protected function addEmptyYear(array $data, int $year): array
    {
        foreach ($data as $key => $value) {
            if (!isset($data[$key]['years'][$year])) {
                $data[$key]['years'][$year] = 0;
            }
        }
        return $data;
    }

    /*
     * sort result array by years
     *
     * @param array $result
     * @return array
     */
    protected function sortResultByYears(array $result): array
    {
        $resultSorted = [];
        foreach ($result as $key => $value) {
            // sort by array key (years) in revers order
            krsort($value['years']);
            $resultSorted[$key] = [
                'title' => $value['title'],
                'color' => $value['color'],
                'years' => $value['years'],
            ];
        }
        return $resultSorted;
    }

    /*
     * sort result by the key, that is the typeUid
     *
     * @param array $data
     * @return array
     */
    protected function sortResultByTypeUid(array $data): array
    {
        // sort by array key (typeUid)
        ksort($data);
        return $data;
    }

    /*
     *  convert years array to comma separated list
     *  which can be check in sql
     *
     * @param array $years
     * @return string
     */
    protected function convertYearsToString(array $years): string
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
    protected function convertYearsToStringForSqlite(array $years): string
    {
        // Every year must be set between '' to get a proper list for sqlite
        return implode(',', array_map(function(string $year) {
            return "'$year'";
        }, $years));
    }

    protected function getSelectYearFromUnixTime(Connection $connection, array $years): string
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
    protected function getWhereYearInString(Connection $connection, array $years): string
    {
        $isPostgres = $connection->getDatabasePlatform() instanceof PostgreSQLPlatform;
        $isSqlite = $connection->getDatabasePlatform() instanceof SQLitePlatform;
        if($isPostgres) {
            return 'IN(' . $this->convertYearsToString($years) . ')';
        } elseif ($isSqlite) {
            return 'IN(' . $this->convertYearsToStringForSqlite($years) . ')';
        } else {
            return 'IN(' . $this->convertYearsToString($years) . ')';
        }
    }

    /**
     * Counts all available operations grouped by year
     * Optionally use operation uid list, which created before with category constraints
     *
     * @param array $years
     * @param string $operationUids
     * @return array
     */
    public function countGroupedByYear(array $years, string $operationUids = ''): array
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_operations_domain_model_operation');

        $statement = $queryBuilder
            ->addSelectLiteral('COUNT(*) as count, FROM_UNIXTIME(begin, \'%Y\') as year')
            ->from('tx_operations_domain_model_operation', 'o')
            ->where('FROM_UNIXTIME(begin, \'%Y\') IN(' . $this->convertYearsToString($years) . ')');
        if ($operationUids != '') {
            $statement = $statement->andWhere('o.uid IN (' . $operationUids . ')');
        }
        $statement = $statement->groupBy('year')
            ->orderBy('year', 'DESC')
            ->executeQuery();
        return $statement->fetchAllAssociative();
    }

    /**
     * Generates the query
     *
     *
     * @param OperationDemand $demand
     * @param array<mixed> $settings
     * @param bool $noLimit
     * @return QueryInterface
     * @throws InvalidQueryException
     */
    protected function generateQuery(OperationDemand $demand, array $settings, bool $noLimit = false): QueryInterface
    {
        $query = $this->createQuery();
        if (isset($settings['dontRespectStoragePage']) && $settings['dontRespectStoragePage'] === 1) {
            $query->getQuerySettings()->setRespectStoragePage(false);
        }
        $constraints = $this->createConstraintsFromDemand($query, $demand, $settings);
        if (count($constraints) > 0) {
            $query->matching(
                $query->logicalAnd(...$constraints)
            );
        }
        $limit = $demand->getLimit() ?? ($settings['limit'] ?? 0);
        if (!$noLimit && $limit > 0) {
            $query->setLimit((int)$limit);
        }
        return $query;
    }

    /**
     * Returns an array of constraints created from a given demand object.
     *
     * @param QueryInterface $query
     * @param OperationDemand $demand
     * @param array $settings
     * @throws InvalidQueryException
     * @return (\TYPO3\CMS\Extbase\Persistence\Generic\Qom\AndInterface|\TYPO3\CMS\Extbase\Persistence\Generic\Qom\ComparisonInterface|\TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface|\TYPO3\CMS\Extbase\Persistence\Generic\Qom\NotInterface|\TYPO3\CMS\Extbase\Persistence\Generic\Qom\OrInterface|null)[]
     */
    protected function createConstraintsFromDemand(
        QueryInterface $query,
        OperationDemand $demand,
        array $settings
    ): array {
        $constraints = [];

        $this->addDateConstraints($query, $demand, $constraints);
        $this->addCategoryConstraintsFromSettings($query, $settings, $constraints);
        $this->addCategoryConstraintsFromDemand($query, $demand, $constraints);
        $this->addTypeConstraints($query, $demand, $constraints);
        $this->addSearchConstraints($query, $demand, $settings, $constraints);
        $this->addMapConstraints($query, $settings, $constraints);

        $constraints = $this->cleanUnusedConstraints($constraints);
        return $constraints;
    }

    /**
     * @param QueryInterface $query
     * @param OperationDemand $demand
     * @param array $constraints
     * @throws InvalidQueryException
     */
    protected function addDateConstraints(QueryInterface $query, OperationDemand $demand, array &$constraints): void
    {
        if ($demand->getBegin() > 0) {
            $fromTimestamp = mktime(0, 0, 0, 1, 1, $demand->getBegin());
            $toTimestamp = mktime(23, 59, 59, 12, 31, $demand->getBegin());
            $constraints[] = $query->logicalAnd(
                $query->greaterThanOrEqual('begin', $fromTimestamp),
                $query->lessThanOrEqual('begin', $toTimestamp)
            );
        }
    }

    /**
     * @param QueryInterface $query
     * @param array $settings
     * @param array $constraints
     * @throws InvalidQueryException
     */
    protected function addCategoryConstraintsFromSettings(QueryInterface $query, array $settings, array &$constraints): void
    {
        if (isset($settings['category']) && $settings['category'] != '') {
            $createdCategoryConstraints = $this->createCategoryConstraints(
                $query,
                GeneralUtility::trimExplode(',', $settings['category'], true),
                'category',
                $settings
            );
            if ($createdCategoryConstraints != null) {
                $constraints[] = $createdCategoryConstraints;
            }
        }
    }

    /**
     * @param QueryInterface $query
     * @param OperationDemand $demand
     * @param array $constraints
     * @throws InvalidQueryException
     */
    protected function addCategoryConstraintsFromDemand(QueryInterface $query, OperationDemand $demand, array &$constraints): void
    {
        if ($demand->getCategory() > 0) {
            $constraints[] = $query->contains('category', $demand->getCategory());
        }
    }

    /**
     * @param QueryInterface $query
     * @param OperationDemand $demand
     * @param array $constraints
     * @throws InvalidQueryException
     */
    protected function addTypeConstraints(QueryInterface $query, OperationDemand $demand, array &$constraints): void
    {
        if ($demand->getType() > 0) {
            $constraints[] = $query->contains('type', $demand->getType());
        }
    }

    /**
     * @param QueryInterface $query
     * @param OperationDemand $demand
     * @param array $settings
     * @param array $constraints
     * @throws InvalidQueryException
     */
    protected function addSearchConstraints(QueryInterface $query, OperationDemand $demand, array $settings, array &$constraints): void
    {
        if ($demand->getSearchstring() !== '') {
            $searchSubject = $demand->getSearchstring();
            $searchFields = $this->getSearchFields($settings);
            $searchConstraints = $this->buildSearchConstraints($query, $searchSubject, $searchFields);

            if (count($searchConstraints) > 0) {
                $constraints[] = $query->logicalOr(...$searchConstraints);
            }
        }
    }

    /**
     * @param array $settings
     * @return array
     */
    protected function getSearchFields(array $settings): array
    {
        $searchFields = GeneralUtility::trimExplode(',', $settings['searchFields'], true);
        if (count($searchFields) === 0) {
            throw new \UnexpectedValueException('No search fields in TypoScript setup defined', 1506861158);
        }
        return $searchFields;
    }

    /**
     * @param QueryInterface $query
     * @param string $searchSubject
     * @param array $searchFields
     * @return array
     * @throws InvalidQueryException
     */
    protected function buildSearchConstraints(QueryInterface $query, string $searchSubject, array $searchFields): array
    {
        $searchConstraints = [];
        foreach ($searchFields as $field) {
            if ($searchSubject !== '') {
                $searchConstraints[] = $query->like($field, '%' . $searchSubject . '%');
            }
        }
        return $searchConstraints;
    }

    /**
     * @param QueryInterface $query
     * @param array $settings
     * @param array $constraints
     * @throws InvalidQueryException
     */
    protected function addMapConstraints(QueryInterface $query, array $settings, array &$constraints): void
    {
        if (isset($settings['showMap']) && $settings['showMap'] == 1){
            $constraints[] = $query->logicalAnd(
                $query->greaterThan('latitude', 0),
                $query->greaterThan('longitude', 0)
            );
        }
    }

    /**
     * Build the constraints for the category logic
     * @param QueryInterface<Category> $query
     * @param mixed $categories
     * @param string $property
     * @param array<mixed> $settings
     * @return ConstraintInterface $constraint
     * @throws InvalidQueryException
     */
    protected function createCategoryConstraints(
        QueryInterface $query,
        mixed $categories,
        string $property,
        array $settings
    ): ?\TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface {
        if ($categories != null && count($categories) != 0) {
            $categoryConstraint = [];
            foreach ($categories as $category) {
                $categoryConstraint[] = $query->contains($property, $category);
            }
            switch ($settings['categoryConjunction']) {
                case 'or':
                    $constraint = $query->logicalOr(...$categoryConstraint);
                    break;
                case 'and':
                    $constraint = $query->logicalAnd(...$categoryConstraint);
                    break;
                case 'notor':
                    $constraint = $query->logicalOr(...$categoryConstraint);
                    $constraint = $query->logicalNot($constraint);
                    break;
                case 'notand':
                    $constraint = $query->logicalAnd(...$categoryConstraint);
                    $constraint = $query->logicalNot($constraint);
                    break;
                case 'default':
                    break;
            }
        }
        return $constraint ?? null;
    }

    /**
     *  Clean not used constraints
     *
     * @param array $constraints
     * @return array
     */
    protected function cleanUnusedConstraints(array $constraints): array
    {
        foreach ($constraints as $key => $value) {
            if (is_null($value)) {
                unset($constraints[$key]);
            }
        }
        return $constraints;
    }

    /**
     * Get proper title for Types in chart array
     *
     * @param array $value
     * @return string
     */
    protected function getTypeTitle(array $value): string
    {
        return GeneralUtility::makeInstance(TypeRepository::class)->findByUid($value['type_uid'])->getTitle();
    }
}

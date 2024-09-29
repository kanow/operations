<?php

namespace Kanow\Operations\Domain\Repository;

use Doctrine\DBAL\Exception;
use Kanow\Operations\Domain\Model\Category;
use Kanow\Operations\Domain\Model\Operation;
use Kanow\Operations\Domain\Model\OperationDemand;
use Kanow\Operations\Domain\Model\Type;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\LanguageAspect;
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
    public function findDemanded(OperationDemand $demand, array $settings)
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
    public function findDemandedForStatistics(OperationDemand $demand, array $settings) :array
    {
        $query = $this->generateQuery($demand,$settings,(bool)($settings['noLimitForStatistics'] ?? false));
        return $query->execute(true);
    }

    /**
     * Counts all available operations
     * @param OperationDemand $demand
     * @param array<mixed> $settings
     * @return int
     * @throws InvalidQueryException
     */
    public function countDemandedForStatistics(OperationDemand $demand, array$settings) :int
    {
        return count($this->findDemandedForStatistics($demand, $settings));
    }

    /**
     * Counts all available operations grouped by a year and type
     * Optionally use operation uid list, which created before with category constraints
     *
     * @param array<string,int> $years
     * @param array<mixed> $types
     * @param string $operationUids
     * @return array<mixed>
     */
    public function countGroupedByYearAndType(array $years, array $types, string $operationUids = '') :array
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_operations_domain_model_operation');
        $result = $queryBuilder
            ->addSelectLiteral('ot.color as color, ot.title as title, ot.uid as type_uid, COUNT(*) as count, FROM_UNIXTIME(o.begin, \'%Y\') as year')
            ->from('tx_operations_domain_model_type', 'ot')
            ->innerJoin('ot', 'tx_operations_operation_type_mm', 'type_mm', 'type_mm.uid_foreign = ot.uid')
            ->innerJoin('type_mm', 'tx_operations_domain_model_operation', 'o', 'type_mm.uid_local = o.uid')
            ->where('FROM_UNIXTIME(o.begin, \'%Y\') IN(' . $this->convertYearsToString($years) . ')');
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
    protected function prepareResultForChartArray(array $result) :array
    {
        $preparedResult = [];

        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        /** @var LanguageAspect $languageAspect */
        $lang_uid = $languageAspect->getId();

        if ($lang_uid > 0) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('tx_operations_domain_model_type');
        }

        foreach ($result as $key => $value) {
            if ($lang_uid > 0) {
                /** @var QueryBuilder $queryBuilder */
                $translatedType = $queryBuilder
                    ->addSelectLiteral('type.title')
                    ->from('tx_operations_domain_model_type', 'type')
                    ->where('type.l10n_parent = ' . $value['type_uid']);
                $translatedType = $translatedType->executeQuery()->fetchAllAssociative();
            }
            $title = $translatedType['title'] ?? $value['title'];

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
    protected function addMissingType(array $data, array $types, int $year) :array
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
    protected function addEmptyYear(array $data, int $year) :array
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
    protected function sortResultByYears(array $result) :array
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
    protected function sortResultByTypeUid(array $data) :array
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
    protected function convertYearsToString(array $years) :string
    {
        return implode(',', $years);
    }

    /**
     * Counts all available operations grouped by year
     * Optionally use operation uid list, which created before with category constraints
     *
     * @param array $years
     * @param string $operationUids
     * @return array
     */
    public function countGroupedByYear(array $years, string $operationUids = '') :array
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
        if ($constraints != null && count($constraints) != 0 ) {
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

        if ($demand->getBegin() > 0) {
            $fromTimestamp = mktime(0, 0, 0, 1, 1, $demand->getBegin());
            $toTimestamp = mktime(23, 59, 59, 12, 31, $demand->getBegin());
            $constraints[] = $query->logicalAnd(
                $query->greaterThanOrEqual('begin', $fromTimestamp),
                $query->lessThanOrEqual('begin', $toTimestamp)
            );
        }

        //category constraints from plugin settings
        /** @var array $settings */
        if ($settings['category'] ?? null != '') {
            $categories = GeneralUtility::trimExplode(',', $settings['category']);
            $constraints[] = $this->createCategoryConstraints($query, $categories, 'category', $settings);
        }
        // category constraints from filter form
        if ($demand->getCategory() > 0) {
            $constraints[] = $query->contains('category', $demand->getCategory());
        }

        if ($demand->getType() > 0) {
            $constraints[] = $query->contains('type', $demand->getType());
        }
        // search
        if ($demand->getSearchstring() != '') {
            $searchSubject = $demand->getSearchstring();
            $searchFields = GeneralUtility::trimExplode(',', $settings['searchFields'], true);
            $searchConstraints = [];
            if (count($searchFields) === 0) {
                throw new \UnexpectedValueException('No search fields in TypoScript setup defined', 1506861158);
            }
            foreach ($searchFields as $field) {
                if ($searchSubject != '') {
                    $searchConstraints[] = $query->like($field, '%' . $searchSubject . '%');
                }
            }
            if (count($searchConstraints) > 0) {
                $constraints[] = $query->logicalOr(...$searchConstraints);
            }
        }

        // map constraints
        if (isset($settings['showMap'])) {
            $constraints[] = $query->logicalAnd(
                $query->greaterThan('latitude', 0),
                $query->greaterThan('longitude', 0)
            );
        }

        $constraints = $this->cleanUnusedConstraints($constraints);
        return $constraints;
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
        $constraint = [];
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
        return $constraint;
    }

    /**
     *  Clean not used constraints
     *
     * @param array $constraints
     * @return array
     */
    protected function cleanUnusedConstraints(array $constraints) :array
    {
        foreach ($constraints as $key => $value) {
            if (is_null($value)) {
                unset($constraints[$key]);
            }
        }
        return $constraints;
    }
}

<?php

namespace Kanow\Operations\Domain\Repository;

use Kanow\Operations\Domain\Model\OperationDemand;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

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
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

/**
 *
 *
 * @package operations
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class OperationRepository extends Repository
{

    /**
     * default ordering
     *
     * @return array
     */
    protected $defaultOrderings = array(
        'begin' => QueryInterface::ORDER_DESCENDING,
    );

    /**
     * Returns the objects of this repository matching the demand
     *
     * @param OperationDemand $demand
     * @param array $settings
     * @return QueryResultInterface
     * @throws InvalidQueryException
     */
    public function findDemanded(OperationDemand $demand, $settings)
    {
        $query = $this->generateQuery($demand, $settings);
        return $query->execute();
    }

    /**
     * Category Returns the raw query result of this repository matching the demand
     *
     * @param OperationDemand $demand
     * @param array $settings
     * @return array
     * @throws InvalidQueryException
     */
    public function findDemandedForStatistics(OperationDemand $demand, $settings)
    {
        $query = $this->generateQuery($demand, $settings);
        return $query->execute(true);
    }

    /**
     * Counts all available operations without the limit
     * @todo maybe not longer needed. Can be removed soon
     *
     * @param OperationDemand $demand
     * @return integer $count
     * @throws InvalidQueryException
     */
    public function countDemanded($demand) {
        return $this->findDemanded($demand, NULL)->count();
    }

    /**
     * Counts all available operations
     * @param OperationDemand $demand
     * @param array $settings
     * @return integer
     * @throws InvalidQueryException
     */
    public function countDemandedForStatistics($demand, $settings) {
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
    public function countGroupedByYearAndType($years,$types, $operationUids = '') {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_operations_domain_model_operation');
        $result = $queryBuilder
            ->add('select','ot.color as color, ot.title as title, ot.uid as type_uid, COUNT(*) as count, FROM_UNIXTIME(o.begin, \'%Y\') as year')
            ->from('tx_operations_domain_model_type','ot')
            ->innerJoin('ot','tx_operations_operation_type_mm','type_mm','type_mm.uid_foreign = ot.uid')
            ->innerJoin('type_mm','tx_operations_domain_model_operation','o','type_mm.uid_local = o.uid')
            ->where('FROM_UNIXTIME(o.begin, \'%Y\') IN('. $this->convertYearsToString($years) .')' );
        if($operationUids != '') {
            $result = $result->andWhere('o.uid IN (' . $operationUids . ')');
        }
         $result = $result->groupBy('year')
            ->addGroupBy('ot.uid')
            ->execute()->fetchAll();

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
     */
    protected function prepareResultForChartArray($result) {
        $preparedResult = [];
        foreach ($result as $key => $value) {
            if(!array_key_exists($value['type_uid'],$preparedResult)) {
                $preparedResult[$value['type_uid']] = array(
                    'title' => $value['title'],
                    'color' => $value['color'],
                    'years' => array(
                        $value['year'] => $value['count']
                    )
                );
            } else {
                $preparedResult[$value['type_uid']]['years'][$value['year']] = $value['count'];
            }
        }
        return $preparedResult;
    }

    /*
     * add missing type (no operations in year
     *
     * @param array $data
     * @param array $types
     * @param string $year
     * @return array
     */
    protected function addMissingType($data,$types,$year)
    {
        foreach ($types as $type) {
            if(!array_key_exists($type->getUid(),$data)) {
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
     * @param string $year
     * @return array
     */
    protected function addEmptyYear($data,$year)
    {
        foreach($data as $key => $value) {
            if(!isset($data[$key]['years'][$year])) {
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
    protected function sortResultByYears($result)
    {
        $resultSorted = [];
        foreach($result as $key => $value) {
            // sort by array key (years) in revers order
            krsort($value['years']);
            $resultSorted[$key] = array(
                'title' => $value['title'],
                'color' => $value['color'],
                'years' => $value['years']
            );
        }
        return $resultSorted;
    }

    /*
     * sort result by the key, that is the typeUid
     *
     * @param array $data
     * @return array
     */
    protected function sortResultByTypeUid($data)
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
    protected function convertYearsToString($years)
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
    public function countGroupedByYear($years, $operationUids = '') {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_operations_domain_model_operation');

        $statement = $queryBuilder
            ->add('select','COUNT(*) as count, FROM_UNIXTIME(begin, \'%Y\') as year',true)
            ->from('tx_operations_domain_model_operation','o')
            ->where('FROM_UNIXTIME(begin, \'%Y\') IN('. $this->convertYearsToString($years) .')' );
        if($operationUids != '') {
            $statement = $statement->andWhere('o.uid IN (' . $operationUids . ')');
        }
        $statement = $statement->groupBy('year')
            ->orderBy('year', 'DESC')
            ->execute();
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Generates the query
     *
     * @param OperationDemand $demand
     * @param array $settings
     * @return QueryInterface
     * @throws InvalidQueryException
     */
    protected function generateQuery(OperationDemand $demand, $settings)
    {
        $query = $this->createQuery();

        $constraints = $this->createConstraintsFromDemand($query, $demand, $settings);
        if (!empty($constraints)) {
            $query->matching(
                $query->logicalAnd($constraints)
            );
        }
        $limit = $settings['limit'];
        if ($limit <= 0) {
            $limit = 300;
        }
        if ($demand->getLimit() != NULL) {
            $query->setLimit((int)$demand->getLimit());
        } else {
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
     * @return array<\TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface>
     * @throws InvalidQueryException
     */
    protected function createConstraintsFromDemand(QueryInterface $query, OperationDemand $demand, $settings)
    {
        $constraints = array();

        $fromTimestamp = mktime(0, 0, 0, 1, 1, $demand->getBegin());
        $toTimestamp = mktime(23, 59, 59, 12, 31, $demand->getBegin());

        if ($demand->getBegin()) {
            $constraints[] = $query->logicalAnd([
                $query->greaterThanOrEqual('begin', $fromTimestamp),
                $query->lessThanOrEqual('begin', $toTimestamp)
            ]);
        }

        //category constraints from plugin settings
        if ($settings['category'] != '') {
            $categories = GeneralUtility::trimExplode(',', $settings['category']);
            $constraints[] = $this->createCategoryConstraints($query, $categories, 'category', $settings);
        }
        // category constraints from filter form
        if ($demand->getCategory()) {
            $constraints[] = $query->contains('category', $demand->getCategory());
        }

        if ($demand->getType()) {
            $constraints[] = $query->contains('type', $demand->getType());
        }
        // search
        if(!empty($demand->getSearchString())){
            $searchSubject = $demand->getSearchstring();
            $searchFields = GeneralUtility::trimExplode(',', $settings['searchFields'], true);
            $searchConstraints = [];
            if (count($searchFields) === 0) {
                throw new \UnexpectedValueException('No search fields in TypoScript setup defined', 1506861158);
            }
            foreach ($searchFields as $field) {
                if (!empty($searchSubject)) {
                    $searchConstraints[] = $query->like($field, '%' . $searchSubject . '%');
                }
            }
            if (count($searchConstraints)) {
                $constraints[] = $query->logicalOr($searchConstraints);
            }
        }

        // map constraints
        if($settings['showMap']) {
            $constraints[] = $query->logicalAnd([
                $query->greaterThan('latitude',0),
                $query->greaterThan('longitude',0)
            ]);
        }

        $constraints = $this->cleanUnusedConstaints($constraints);
        return $constraints;
    }

    /**
     * Build the constraints for the category logic
     * @param QueryInterface $query
     * @param mixed $categories
     * @param string $property
     * @param array $settings
     * @return ConstraintInterface $constraint
     * @throws InvalidQueryException
     */
    protected  function createCategoryConstraints(QueryInterface $query, $categories, $property, $settings){

        if ($categories && count($categories) != 0) {
            foreach ($categories as $category){
                $categoryConstraint[] = $query->contains($property, $category);
            }
            switch ($settings['categoryConjunction']) {
                case 'or':
                    $constraint = $query->logicalOr($categoryConstraint);
                    break;
                case 'and':
                    $constraint = $query->logicalAnd($categoryConstraint);
                    break;
                case 'notor':
                    $constraint = $query->logicalOr($categoryConstraint);
                    $constraint = $query->logicalNot($constraint);
                    break;
                case 'notand':
                    $constraint = $query->logicalAnd($categoryConstraint);
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
    protected function cleanUnusedConstaints($constraints)
    {
        foreach ($constraints as $key => $value) {
            if (is_null($value)) {
                unset($constraints[$key]);
            }
        }
        return $constraints;
    }

}

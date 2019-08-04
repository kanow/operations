<?php
namespace KN\Operations\Domain\Repository;

use KN\Operations\Domain\Model\OperationDemand;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
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

/**
 *
 *
 * @package operations
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class OperationRepository extends Repository {


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

	public function findDemanded(OperationDemand $demand, $settings) {
		$query = $this->generateQuery($demand, $settings);
		return $query->execute();
	}

	/**
	 * Counts all available operations without the limit
	 *
	 * @param integer $count
	 */
	/*
	public function countDemanded($demand) {
		return $this->findDemanded($demand, NULL)->count();
	}
	*/

	/**
	 * Generates the query
	 *
	 * @param OperationDemand $demand
	 * @param array $settings
	 * @return QueryInterface
     * @throws InvalidQueryException
	 */
	protected function generateQuery(OperationDemand $demand, $settings) {
		$query = $this->createQuery();
		//$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$constraints = $this->createConstraintsFromDemand($query, $demand, $settings);
		if (!empty($constraints)) {
			$query->matching(
					$query->logicalAnd($constraints)
			);
		}
		$limit = $settings['limit'];
		if($limit<=0){
			$limit = 300;
		}
		if ($demand->getLimit() != NULL) {
			$query->setLimit((int) $demand->getLimit());
		} else {
			$query->setLimit((int) $limit);
		}
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
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
	protected function createConstraintsFromDemand(QueryInterface $query, OperationDemand $demand, $settings) {

		$constraints = array();

		$fromTimestamp = mktime(0,0,0,1,1,$demand->getBegin());
		$toTimestamp = mktime(23,59,59,12,31,$demand->getBegin());

		if($demand->getBegin()) {
			$constraints[] = $query->logicalAnd([
				$query->greaterThanOrEqual('begin', $fromTimestamp),
				$query->lessThanOrEqual('begin', $toTimestamp)
			]);
		}

		if($demand->getType()){
			$constraints[] = $query->contains('type',$demand->getType());
		}

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
	 *  Clean not used constraints
	 *
	 * @param array $constraints
	 * @return array
	 */

	protected function cleanUnusedConstaints($constraints){
		foreach ($constraints as $key => $value) {
			if (is_null($value)) {
				unset($constraints[$key]);
			}
		}
		return $constraints;
	}

}

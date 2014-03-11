<?php
namespace KN\Operations\Domain\Repository;

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
class OperationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	
	
	/**
	* default ordering
	* 
	* @return array
	*/
	protected $defaultOrderings = array( 
	    'begin' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING, 
	); 
	
	
	/**
	* Returns the objects of this repository matching the demand
	*
	* @param \KN\Operations\Domain\Model\OperationDemand $demand
	* @param integer $limit
	* @return Tx_Extbase_Persistence_QueryResultInterface
	*/
		
	public function findDemanded(\KN\Operations\Domain\Model\OperationDemand $demand,$limit) {
		if($limit<=0){
			$limit = 200;
		}
		
		$query = $this->generateQuery($demand, $limit);
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
	 * @param \KN\Operations\Domain\Model\OperationDemand $demand
	 * @param integer $limit
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
	 */
	protected function generateQuery(\KN\Operations\Domain\Model\OperationDemand $demand, $limit) {
		$query = $this->createQuery();
		//$query->getQuerySettings()->setRespectStoragePage(FALSE);
		
		$constraints = $this->createConstraintsFromDemand($query, $demand);
		if (!empty($constraints)) {
			$query->matching(
					$query->logicalAnd($constraints)
			);
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
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
	 * @param \KN\Operation\Domain\Model\OperationDemand $demand
	 * @return array<Tx_Extbase_Persistence_QOM_Constraint>
	 */
	protected function createConstraintsFromDemand(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query, \KN\Operations\Domain\Model\OperationDemand $demand) {
		
		$constraints = array();

		$fromTimestamp = mktime(0,0,0,1,1,$demand->getBegin());
		$toTimestamp = mktime(23,59,59,12,31,$demand->getBegin());
		
		
		if($demand->getBegin()) {
			$constraints[] = $query->logicalAnd(
				$query->greaterThanOrEqual('begin', $fromTimestamp),
				$query->lessThanOrEqual('begin', $toTimestamp)
			);
		}
		
		if($demand->getType()){
			$constraints[] = $query->contains('type',$demand->getType());
		}
			
		$constraints = $this->cleanUnusedConstaints($constraints);
	
		return $constraints;
	}
	
	
	/**
	 *  Clean not used constraints
	 *
	 * @param array $contrains
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
?>
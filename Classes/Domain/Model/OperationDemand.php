<?php
namespace Kanow\Operations\Domain\Model;

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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Operation Demand object which holds all information to get the correct
 * media records.
 *
 * @package operations
 * @subpackage dto
 */
class OperationDemand extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject {
	
	/**
	 * Operation onlyEld for demand
	 *
	 * @var integer
	 */
	protected $onlyEld;
	
	/**
	 * Type of operation
	 *
	 * @var integer
	 */
	protected $type;
	
	/**
	 * @var integer
	 */
	protected $limit;

	/**
	 * Begin
	 *
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $begin;

	/**
	 * Searchstring
	 *
	 * @var string
	 */
	protected $searchstring;
	
	/**
     * onlyEld for demanded
	 * @param integer
	 * @return void
	 */
	public function setOnlyEld($onlyEld) {
		$this->onlyEld = $onlyEld;
	}

	/**
     * onlyEld for demanded
	 * @return integer
	 */
	public function getOnlyEld() {
		return $this->onlyEld;
	}
	
	/**
	 * Returns the type
	 *
	 * @return integer $type
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * Sets the type
	 *
	 * @param integer $type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}
	
	/**
	 * Set limit
	 *
	 * @param integer $limit limit
	 * @return void
	 */
	public function setLimit($limit) {
		$this->limit = (int)$limit;
	}

	/**
	 * Get limit
	 *
	 * @return integer
	 */
	public function getLimit() {
		return $this->limit;
	}
	
	/**
	 * Returns the begin
	 *
	 * @return string
	 */
	public function getBegin() {
		return $this->begin;
	}

	/**
	 * Sets the begin
	 *
	 * @param string $begin
	 * @return void
	 */
	public function setBegin($begin) {
		$this->begin = $begin;
	}

	/**
	 * Returns the searchstring
	 *
	 * @return string
	 */
	public function getSearchstring() {
		return $this->searchstring;
	}

	/**
	 * Sets the searchstring
	 *
	 * @param string $searchstring
	 * @return void
	 */
	public function setSearchstring($searchstring) {
		$this->searchstring = $searchstring;
	}
	
	const ARRAY_PROPERTIES = 'begin,type';
	
	/**
	 * get demand parameter for additionalParams in pagination 
	 */
	public function getParameter(){
		$returnArray = array();
		foreach (explode(',', self::ARRAY_PROPERTIES) as $property) {
			$method = 'get' . ucfirst($property);
			$propertyValue =  $this->$method();
			if(!is_null($propertyValue)) {
				if(is_a($propertyValue, '\TYPO3\CMS\Extbase\Persistence\ObjectStorage')) {
					$propertyValue = $propertyValue->toArray();
				}
				$returnArray [$property]= $propertyValue;
			}
		}
		return $returnArray;
	}
}

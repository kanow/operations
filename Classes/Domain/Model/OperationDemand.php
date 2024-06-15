<?php

namespace Kanow\Operations\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;

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
 * record.
 */
class OperationDemand extends AbstractValueObject
{
    /**
     * Operation onlyEld for demand
     *
     * @var int
     */
    protected $onlyEld;

    /**
     * Type of operation
     *
     * @var int
     */
    protected $type;

    /**
     * @var int
     */
    protected $limit;

    /**
      * Begin
      *
      * @var string
      */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $begin;

    /**
     * Searchstring
     *
     * @var string
     */
    protected $searchstring;

    /**
     * Category
     *
     * @var int
     */
    protected $category;

    /**
     * onlyEld for demanded
     * @param int
     */
    public function setOnlyEld($onlyEld): void
    {
        $this->onlyEld = $onlyEld;
    }

    /**
     * onlyEld for demanded
     * @return int
     */
    public function getOnlyEld()
    {
        return $this->onlyEld;
    }

    /**
     * Returns the type
     *
     * @return int $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param int $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * Set limit
     *
     * @param int $limit limit
     */
    public function setLimit($limit): void
    {
        $this->limit = (int)$limit;
    }

    /**
     * Get limit
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Returns the begin
     *
     * @return string
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Sets the begin
     *
     * @param string $begin
     */
    public function setBegin($begin): void
    {
        $this->begin = $begin;
    }

    /**
     * Returns the searchstring
     *
     * @return string
     */
    public function getSearchstring()
    {
        return $this->searchstring;
    }

    /**
     * Sets the searchstring
     *
     * @param string $searchstring
     */
    public function setSearchstring($searchstring): void
    {
        $this->searchstring = $searchstring;
    }

    public const ARRAY_PROPERTIES = 'begin,type';

    /**
     * get demand parameter for additionalParams in pagination
     */
    public function getParameter()
    {
        $returnArray = [];
        foreach (explode(',', self::ARRAY_PROPERTIES) as $property) {
            $method = 'get' . ucfirst($property);
            $propertyValue =  $this->$method();
            if (!is_null($propertyValue)) {
                if (is_a($propertyValue, '\TYPO3\CMS\Extbase\Persistence\ObjectStorage')) {
                    $propertyValue = $propertyValue->toArray();
                }
                $returnArray [$property] = $propertyValue;
            }
        }
        return $returnArray;
    }

    /**
     * Returns the category
     *
     * @return int $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the category
     *
     * @param int $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }
}

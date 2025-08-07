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
    protected int $onlyEld = 0;

    /**
     * Type of operation
     *
     * @var ?int $type
     */
    protected ?int $type = null;

    /**
     * @var ?int $limit
     */
    protected ?int $limit = null;

    /**
      * Begin (year)
      *
      * @var int $begin
      */
    #[Validate(['validator' => 'NotEmpty'])]
    protected int $begin = 0;

    /**
     * Searchstring
     *
     * @var string $searchstring
     */
    protected string $searchstring = '';

    /**
     * Category
     *
     * @var ?int $category
     */
    protected ?int $category = null;

    /**
     * onlyEld for demanded
     *
     * @param int $onlyEld
     */
    public function setOnlyEld(int $onlyEld): void
    {
        $this->onlyEld = $onlyEld;
    }

    /**
     * onlyEld for demanded
     * @return int
     */
    public function getOnlyEld(): int
    {
        return $this->onlyEld;
    }

    /**
     * Returns the type
     *
     * @return int $type
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * Set limit
     *
     * @param ?int $limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Get limit
     *
     * @return ?int $limit
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Returns the begin
     *
     * @return int
     */
    public function getBegin(): int
    {
        return $this->begin;
    }

    /**
     * Sets the begin
     *
     * @param int $begin
     */
    public function setBegin(int $begin): void
    {
        $this->begin = $begin;
    }

    /**
     * Returns the searchstring
     *
     * @return string
     */
    public function getSearchstring(): string
    {
        return $this->searchstring;
    }

    /**
     * Sets the searchstring
     *
     * @param string $searchstring
     */
    public function setSearchstring(string $searchstring): void
    {
        $this->searchstring = $searchstring;
    }

    /**
     * Returns the category
     *
     * @return ?int $category
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * Sets the category
     *
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }
}

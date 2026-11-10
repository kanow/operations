<?php

declare(strict_types=1);

namespace Kanow\Operations\Domain\Model;

use TYPO3\CMS\Extbase\Attribute as Extbase;
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
     */
    protected int $onlyEld = 0;

    /**
     * Type of operation
     */
    protected ?int $type = null;

    protected ?int $limit = null;

    /**
     * Begin (year)
     */
    #[Extbase\Validate(validator: 'NotEmpty')]
    protected int $begin = 0;

    /**
     * Searchstring
     */
    protected string $searchstring = '';

    /**
     * Category
     */
    protected ?int $category = null;

    /**
     * onlyEld for demanded
     */
    public function setOnlyEld(int $onlyEld): void
    {
        $this->onlyEld = $onlyEld;
    }

    /**
     * onlyEld for demanded
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
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * Set limit
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
     */
    public function getBegin(): int
    {
        return $this->begin;
    }

    /**
     * Sets the begin
     */
    public function setBegin(int $begin): void
    {
        $this->begin = $begin;
    }

    /**
     * Returns the searchstring
     */
    public function getSearchstring(): string
    {
        return $this->searchstring;
    }

    /**
     * Sets the searchstring
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
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }
}

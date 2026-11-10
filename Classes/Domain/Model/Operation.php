<?php

namespace Kanow\Operations\Domain\Model;

use TYPO3\CMS\Extbase\Attribute as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Operation extends AbstractEntity
{
    /**
     * Operation number
     */
    #[Extbase\Validate(validator: 'NotEmpty')]
    protected string $number = '';

    /**
     * Operation onlyEld
     */
    protected int $onlyEld = 0;

    /**
     * Title
     */
    #[Extbase\Validate(validator: 'NotEmpty')]
    protected string $title = '';

    /**
     * Location of operation
     */
    #[Extbase\Validate(validator: 'NotEmpty')]
    protected string $location = '';

    /**
     * Begin
     */
    #[Extbase\Validate(validator: 'NotEmpty')]
    protected ?\DateTime $begin = null;

    /**
     * Ending
     */
    protected ?\DateTime $end = null;

    /**
     * Operation short teaser
     */
    protected string $teaser = '';

    /**
     * Operation report
     */
    protected string $report = '';

    /**
     * Longitude
     */
    protected string $longitude = '';

    /**
     * Latitude
     */
    protected string $latitude = '';

    /**
     * Zoom for maps
     */
    protected int $zoom = 0;

    /**
     * Media
     * @var ObjectStorage<FileReference>
     */
    protected ?ObjectStorage $media = null;

    /**
     * Type of operation
     *
     * @var ObjectStorage<Type>
     */
    protected ?ObjectStorage $type = null;

    /**
     * Assistance to this operation
     * @var ObjectStorage<Assistance>
     */
    #[Extbase\ORM\Lazy]
    protected ?ObjectStorage $assistance = null;

    /**
     * Vehicles use on this operation
     * @var ObjectStorage<Vehicle>
     */
    #[Extbase\ORM\Lazy]
    protected ?ObjectStorage $vehicles = null;

    /**
     * resources used
     * @var ObjectStorage<\Kanow\Operations\Domain\Model\Resource>
     */
    #[Extbase\ORM\Lazy]
    protected ?ObjectStorage $resources = null;

    /**
     * Category
     *
     * @var ObjectStorage<Category>
     */
    protected ?ObjectStorage $category = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     */
    protected function initStorageObjects(): void
    {
        $this->type = new ObjectStorage();
        $this->assistance = new ObjectStorage();
        $this->vehicles = new ObjectStorage();
        $this->resources = new ObjectStorage();
        $this->media = new ObjectStorage();
        $this->category = new ObjectStorage();
    }

    /**
     * Returns the number
     *
     * @return string $number
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Sets the number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * Returns the onlyEld
     *
     * @return int $onlyEld
     */
    public function getOnlyEld(): int
    {
        return $this->onlyEld;
    }

    /**
     * Sets the onlyEld
     */
    public function setOnlyEld(int $onlyEld): void
    {
        $this->onlyEld = $onlyEld;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the location
     *
     * @return string $location
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * Sets the location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * Returns the begin
     *
     * @return \DateTime $begin
     */
    public function getBegin(): ?\DateTime
    {
        return $this->begin;
    }

    /**
     * Sets the begin
     */
    public function setBegin(\DateTime $begin): void
    {
        $this->begin = $begin;
    }

    /**
     * Returns the end
     *
     * @return \DateTime $end
     */
    public function getEnd(): ?\DateTime
    {
        return $this->end;
    }

    /**
     * Sets the end
     */
    public function setEnd(\DateTime $end): void
    {
        $this->end = $end;
    }

    /**
     * Returns the teaser
     *
     * @return string $teaser
     */
    public function getTeaser(): string
    {
        return $this->teaser;
    }

    /**
     * Sets the teaser
     */
    public function setTeaser(string $teaser): void
    {
        $this->teaser = $teaser;
    }

    /**
     * Returns the report
     *
     * @return string $report
     */
    public function getReport(): string
    {
        return $this->report;
    }

    /**
     * Sets the report
     */
    public function setReport(string $report): void
    {
        $this->report = $report;
    }

    /**
     * Returns the longitude
     *
     * @return string $longitude
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude
     */
    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * Returns the latitude
     *
     * @return string $latitude
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude
     */
    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * Returns the zoom
     *
     * @return int $zoom
     */
    public function getZoom(): int
    {
        return $this->zoom;
    }

    /**
     * Sets the zoom
     */
    public function setZoom(int $zoom): void
    {
        $this->zoom = $zoom;
    }

    /**
     * Returns the media
     *
     * @return ObjectStorage<FileReference> $media
     */
    public function getMedia(): ?ObjectStorage
    {
        return $this->media;
    }

    /**
     * Returns the first media
     *
     * @return ?FileReference $media
     */
    public function getFirstMedia(): ?FileReference
    {
        $media = $this->getMedia()?->toArray() ?? [];
        return $media[0] ?? null;
    }

    /**
     * Sets the media
     *
     * @param ObjectStorage<FileReference> $media
     */
    public function setMedia(ObjectStorage $media): void
    {
        $this->media = $media;
    }

    /**
     * Adds a Type
     */
    public function addType(Type $type): void
    {
        $this->type->attach($type);
    }

    /**
     * Removes a Type
     *
     * @param Type $typeToRemove The Type to be removed
     */
    public function removeType(Type $typeToRemove): void
    {
        $this->type->detach($typeToRemove);
    }

    /**
     * Returns the type
     *
     * @return ObjectStorage<Type> $type
     */
    public function getType(): ?ObjectStorage
    {
        return $this->type;
    }

    /**
     * Returns directly the assigned type. Prevent to unnecessary iteration in operation data.
     *
     * @return Type $type
     */
    public function getAssignedType(): ?Type
    {
        $type = $this->getType()?->toArray() ?? [];
        return $type[0] ?? null;
    }

    /**
     * Sets the type
     *
     * @param ObjectStorage<Type> $type
     */
    public function setType(ObjectStorage $type): void
    {
        $this->type = $type;
    }

    /**
     * Adds a Assistance
     */
    public function addAssistance(Assistance $assistance): void
    {
        $this->assistance->attach($assistance);
    }

    /**
     * Removes a Assistance
     *
     * @param Assistance $assistanceToRemove The Assistance to be removed
     */
    public function removeAssistance(Assistance $assistanceToRemove): void
    {
        $this->assistance->detach($assistanceToRemove);
    }

    /**
     * Returns the assistance
     *
     * @return ObjectStorage<Assistance> $assistance
     */
    public function getAssistance(): ?ObjectStorage
    {
        return $this->assistance;
    }

    /**
     * Sets the assistance
     *
     * @param ObjectStorage<Assistance> $assistance
     */
    public function setAssistance(ObjectStorage $assistance): void
    {
        $this->assistance = $assistance;
    }

    /**
     * Adds a Vehicle
     */
    public function addVehicle(Vehicle $vehicle): void
    {
        $this->vehicles->attach($vehicle);
    }

    /**
     * Removes a Vehicle
     *
     * @param Vehicle $vehicleToRemove The Vehicle to be removed
     */
    public function removeVehicle(Vehicle $vehicleToRemove): void
    {
        $this->vehicles->detach($vehicleToRemove);
    }

    /**
     * Returns the vehicles
     *
     * @return ObjectStorage<Vehicle> $vehicles
     */
    public function getVehicles(): ?ObjectStorage
    {
        return $this->vehicles;
    }

    /**
     * Sets the vehicles
     *
     * @param ObjectStorage<Vehicle> $vehicles
     */
    public function setVehicles(ObjectStorage $vehicles): void
    {
        $this->vehicles = $vehicles;
    }

    /**
     * Returns the resources
     *
     * @return ObjectStorage<Resource> $resources
     */
    public function getResources(): ?ObjectStorage
    {
        return $this->resources;
    }

    /**
     * Sets the resources
     *
     * @param ObjectStorage<Resource> $resources
     */
    public function setResources(ObjectStorage $resources): void
    {
        $this->resources = $resources;
    }

    /**
     * Adds a Category
     */
    public function addCategory(Category $category): void
    {
        $this->category->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param Category $categoryToRemove The Category to be removed
     */
    public function removeCategory(Category $categoryToRemove): void
    {
        $this->category->detach($categoryToRemove);
    }

    /**
     * Returns the category
     *
     * @return ObjectStorage<Category> $category
     */
    public function getCategory(): ?ObjectStorage
    {
        return $this->category;
    }

    /**
     * Sets the category
     *
     * @param ObjectStorage<Category> $category
     */
    public function setCategory(ObjectStorage $category): void
    {
        $this->category = $category;
    }
}

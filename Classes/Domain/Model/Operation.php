<?php

namespace Kanow\Operations\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\Validate;
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
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected string $number;

    /**
     * Operation onlyEld
     *
     * @var int
     */
    protected int $onlyEld;

    /**
     * Title
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected string $title;

    /**
     * Location of operation
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected string $location;

    /**
     * Begin
     *
     * @var \DateTime
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected \DateTime $begin;

    /**
     * Ending
     *
     * @var \DateTime
     */
    protected \DateTime $end;

    /**
     * Operation short teaser
     *
     * @var string
     */
    protected string $teaser;

    /**
     * Operation report
     *
     * @var string
     */
    protected string $report;

    /**
     * Longitude
     *
     * @var string
     */
    protected string $longitude;

    /**
     * Latitude
     *
     * @var string
     */
    protected string $latitude;

    /**
     * Zoom for maps
     *
     * @var int
     */
    protected int $zoom;

    /**
     * Media
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $media;

    /**
     * Type of operation
     *
     * @var ObjectStorage<\Kanow\Operations\Domain\Model\Type>
     */
    protected ObjectStorage $type;

    /**
     * Assistance to this operation
     * @var ObjectStorage<\Kanow\Operations\Domain\Model\Assistance>
     */
    #[Lazy]
    protected ObjectStorage $assistance;

    /**
     * Vehicles use on this operation
     * @var ObjectStorage<\Kanow\Operations\Domain\Model\Vehicle>
     */
    #[Lazy]
    protected ObjectStorage $vehicles;

    /**
     * resources used
     * @var ObjectStorage<\Kanow\Operations\Domain\Model\Resource>
     */
    #[Lazy]
    protected ObjectStorage $resources;

    /**
     * Category
     *
     * @var ObjectStorage<Category>
     */
    protected ObjectStorage $category;

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
    protected function initStorageObjects() :void
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
    public function getNumber() :string
    {
        return $this->number;
    }

    /**
     * Sets the number
     *
     * @param string $number
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
    public function getOnlyEld() :int
    {
        return $this->onlyEld;
    }

    /**
     * Sets the onlyEld
     *
     * @param int $onlyEld
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
    public function getTitle() :string
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
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
    public function getLocation() :string
    {
        return $this->location;
    }

    /**
     * Sets the location
     *
     * @param string $location
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
    public function getBegin() :\DateTime
    {
        return $this->begin;
    }

    /**
     * Sets the begin
     *
     * @param \DateTime $begin
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
    public function getEnd() :\DateTime
    {
        return $this->end;
    }

    /**
     * Sets the end
     *
     * @param \DateTime $end
     */
    public function setEnd( \DateTime $end): void
    {
        $this->end = $end;
    }

    /**
     * Returns the teaser
     *
     * @return string $teaser
     */
    public function getTeaser() :string
    {
        return $this->teaser;
    }

    /**
     * Sets the teaser
     *
     * @param string $teaser
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
    public function getReport() :string
    {
        return $this->report;
    }

    /**
     * Sets the report
     *
     * @param string $report
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
    public function getLongitude() :string
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude
     *
     * @param string $longitude
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
    public function getLatitude() :string
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude
     *
     * @param string $latitude
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
    public function getZoom() :int
    {
        return $this->zoom;
    }

    /**
     * Sets the zoom
     *
     * @param int $zoom
     */
    public function setZoom(int $zoom): void
    {
        $this->zoom = $zoom;
    }

    /**
     * Returns the media
     *
     * @return ObjectStorage $media
     */
    public function getMedia() :ObjectStorage
    {
        return $this->media;
    }

    /**
     * Returns the first media
     *
     * @return ?FileReference $media
     */
    public function getFirstMedia() :?FileReference
    {
        $media = $this->getMedia()->toArray();
        return $media[0];
    }

    /**
     * Sets the media
     *
     * @param ObjectStorage $media
     */
    public function setMedia(ObjectStorage $media): void
    {
        $this->media = $media;
    }

    /**
     * Adds a Type
     *
     * @param Type $type
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
     * @return ObjectStorage<\Kanow\Operations\Domain\Model\Type> $type
     */
    public function getType() :ObjectStorage
    {
        return $this->type;
    }

    /**
     * Returns directly the assigned type. Prevent to unnecessary iteration in operation data.
     *
     * @return ObjectStorage<\Kanow\Operations\Domain\Model\Type> $type
     */
    public function getAssignedType() :Type
    {
        $type = $this->getType()->toArray();
        return $type[0];
    }

    /**
     * Sets the type
     *
     * @param ObjectStorage<\Kanow\Operations\Domain\Model\Type> $type
     */
    public function setType(Type $type): void
    {
        $this->type = $type;
    }

    /**
     * Adds a Assistance
     *
     * @param Assistance $assistance
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
     * @return ObjectStorage<\Kanow\Operations\Domain\Model\Assistance> $assistance
     */
    public function getAssistance() :ObjectStorage
    {
        return $this->assistance;
    }

    /**
     * Sets the assistance
     *
     * @param ObjectStorage<\Kanow\Operations\Domain\Model\Assistance> $assistance
     */
    public function setAssistance(ObjectStorage $assistance): void
    {
        $this->assistance = $assistance;
    }

    /**
     * Adds a Vehicle
     *
     * @param Vehicle $vehicle
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
     * @return ObjectStorage<\Kanow\Operations\Domain\Model\Vehicle> $vehicles
     */
    public function getVehicles() :ObjectStorage
    {
        return $this->vehicles;
    }

    /**
     * Sets the vehicles
     *
     * @param ObjectStorage<\Kanow\Operations\Domain\Model\Vehicle> $vehicles
     */
    public function setVehicles(ObjectStorage $vehicles): void
    {
        $this->vehicles = $vehicles;
    }

    /**
     * Adds a Resource
     *
     * @param resource $resource
     */
    public function addResource(Resource $resource): void
    {
        $this->resources->attach($resource);
    }

    /**
     * Removes a Resource
     *
     * @param resource $resourceToRemove The Resources to be removed
     */
    public function removeResource(Resource $resourceToRemove): void
    {
        $this->resources->detach($resourceToRemove);
    }

    /**
     * Returns the resources
     *
     * @return ObjectStorage<\Kanow\Operations\Domain\Model\Resource> $resources
     */
    public function getResources() :ObjectStorage
    {
        return $this->resources;
    }

    /**
     * Sets the resources
     *
     * @param ObjectStorage<\Kanow\Operations\Domain\Model\Resource> $resources
     */
    public function setResources(ObjectStorage $resources): void
    {
        $this->resources = $resources;
    }

    /**
     * Adds a Category
     *
     * @param Category $category
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
    public function getCategory() :ObjectStorage
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

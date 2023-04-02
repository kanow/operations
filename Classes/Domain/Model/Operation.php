<?php

namespace Kanow\Operations\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
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
 *
 *
 * @package operations
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Operation extends AbstractEntity
{

    /**
     * Operation number
     *
     * @var string
     * @Validate("NotEmpty")
     */
    protected $number;

    /**
     * Operation onlyEld
     *
     * @var integer
     */
    protected $onlyEld;

    /**
     * Title
     *
     * @var string
     * @Validate("NotEmpty")
     */
    protected $title;

    /**
     * Location of operation
     *
     * @var string
     * @Validate("NotEmpty")
     */
    protected $location;

    /**
     * Begin
     *
     * @var \DateTime
     * @Validate("NotEmpty")
     */
    protected $begin;

    /**
     * Ending
     *
     * @var \DateTime
     */
    protected $end;

    /**
     * Operation short teaser
     *
     * @var string
     */
    protected $teaser;

    /**
     * Operation report
     *
     * @var string
     */
    protected $report;

    /**
     * Longitude
     *
     * @var string
     */
    protected $longitude;

    /**
     * Latitude
     *
     * @var string
     */
    protected $latitude;

    /**
     * Zoom for maps
     *
     * @var integer
     */
    protected $zoom;

    /**
     * Media
     * @var ObjectStorage<FileReference>
     */
    protected $media;

    /**
     * Type of operation
     *
     * @var ObjectStorage<Type>
     */
    protected $type;

    /**
     * Assistance to this operation
     * @Lazy
     * @var ObjectStorage<Assistance>
     */
    protected $assistance;

    /**
     * Vehicles use on this operation
     * @Lazy
     * @var ObjectStorage<Vehicle>
     */
    protected $vehicles;

    /**
     * resources used
     * @Lazy
     * @var ObjectStorage<Resource>
     */
    protected $resources;

    /**
     * Category
     *
     * @var ObjectStorage<Category>
     */
    protected $category;

    /**
     * __construct
     *
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
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
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets the number
     *
     * @param string $number
     * @return void
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Returns the onlyEld
     *
     * @return integer $onlyEld
     */
    public function getOnlyEld()
    {
        return $this->onlyEld;
    }

    /**
     * Sets the onlyEld
     *
     * @param integer $onlyEld
     * @return void
     */
    public function setOnlyEld($onlyEld)
    {
        $this->onlyEld = $onlyEld;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the location
     *
     * @return string $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Sets the location
     *
     * @param string $location
     * @return void
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Returns the begin
     *
     * @return \DateTime $begin
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Sets the begin
     *
     * @param \DateTime $begin
     * @return void
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;
    }


    /**
     * Returns the end
     *
     * @return \DateTime $end
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Sets the end
     *
     * @param \DateTime $end
     * @return void
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * Returns the teaser
     *
     * @return string $teaser
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * Sets the teaser
     *
     * @param string $teaser
     * @return void
     */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;
    }

    /**
     * Returns the report
     *
     * @return string $report
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Sets the report
     *
     * @param string $report
     * @return void
     */
    public function setReport($report)
    {
        $this->report = $report;
    }

    /**
     * Returns the longitude
     *
     * @return string $longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude
     *
     * @param string $longitude
     * @return void
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Returns the latitude
     *
     * @return string $latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude
     *
     * @param string $latitude
     * @return void
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Returns the zoom
     *
     * @return integer $zoom
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     * Sets the zoom
     *
     * @param integer $zoom
     * @return void
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
    }

    /**
     * Returns the media
     *
     * @return ObjectStorage $media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Returns the first media
     *
     * @return FileReference $media
     */
    public function getFirstMedia()
    {
        $media = $this->getMedia()->toArray();
        return $media[0];
    }

    /**
     * Sets the media
     *
     * @param ObjectStorage $media
     * @return void
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * Adds a Type
     *
     * @param Type $type
     * @return void
     */
    public function addType(Type $type)
    {
        $this->type->attach($type);
    }

    /**
     * Removes a Type
     *
     * @param Type $typeToRemove The Type to be removed
     * @return void
     */
    public function removeType(Type $typeToRemove)
    {
        $this->type->detach($typeToRemove);
    }

    /**
     * Returns the type
     *
     * @return ObjectStorage<Type> $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns directly the assigned type. Prevent to unnecessary iteration in operation data.
     *
     * @return ObjectStorage<Type> $type
     */
    public function getAssignedType()
    {
        $type = $this->getType()->toArray();
        return $type[0];
    }

    /**
     * Sets the type
     *
     * @param ObjectStorage<Type> $type
     * @return void
     */
    public function setType(ObjectStorage $type)
    {
        $this->type = $type;
    }

    /**
     * Adds a Assistance
     *
     * @param Assistance $assistance
     * @return void
     */
    public function addAssistance(Assistance $assistance)
    {
        $this->assistance->attach($assistance);
    }

    /**
     * Removes a Assistance
     *
     * @param Assistance $assistanceToRemove The Assistance to be removed
     * @return void
     */
    public function removeAssistance(Assistance $assistanceToRemove)
    {
        $this->assistance->detach($assistanceToRemove);
    }

    /**
     * Returns the assistance
     *
     * @return ObjectStorage<Assistance> $assistance
     */
    public function getAssistance()
    {
        return $this->assistance;
    }

    /**
     * Sets the assistance
     *
     * @param ObjectStorage<Assistance> $assistance
     * @return void
     */
    public function setAssistance(ObjectStorage $assistance)
    {
        $this->assistance = $assistance;
    }

    /**
     * Adds a Vehicle
     *
     * @param Vehicle $vehicle
     * @return void
     */
    public function addVehicle(Vehicle $vehicle)
    {
        $this->vehicles->attach($vehicle);
    }

    /**
     * Removes a Vehicle
     *
     * @param Vehicle $vehicleToRemove The Vehicle to be removed
     * @return void
     */
    public function removeVehicle(Vehicle $vehicleToRemove)
    {
        $this->vehicles->detach($vehicleToRemove);
    }

    /**
     * Returns the vehicles
     *
     * @return ObjectStorage<Vehicle> $vehicles
     */
    public function getVehicles()
    {
        return $this->vehicles;
    }

    /**
     * Sets the vehicles
     *
     * @param ObjectStorage<Vehicle> $vehicles
     * @return void
     */
    public function setVehicles(ObjectStorage $vehicles)
    {
        $this->vehicles = $vehicles;
    }

    /**
     * Adds a Resource
     *
     * @param Resource $resource
     * @return void
     */
    public function addResource(Resource $resource)
    {
        $this->resources->attach($resource);
    }

    /**
     * Removes a Resource
     *
     * @param Resource $resourceToRemove The Resources to be removed
     * @return void
     */
    public function removeResource(Resource $resourceToRemove)
    {
        $this->resources->detach($resourceToRemove);
    }

    /**
     * Returns the resources
     *
     * @return ObjectStorage<Resource> $resources
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Sets the resources
     *
     * @param ObjectStorage<Resource> $resources
     * @return void
     */
    public function setResources(ObjectStorage $resources)
    {
        $this->resources = $resources;
    }

    /**
     * Adds a Category
     *
     * @param Category $category
     * @return void
     */
    public function addCategory(Category $category)
    {
        $this->category->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(Category $categoryToRemove)
    {
        $this->category->detach($categoryToRemove);
    }

    /**
     * Returns the category
     *
     * @return ObjectStorage<Category> $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the category
     *
     * @param ObjectStorage<Category> $category
     * @return void
     */
    public function setCategory(ObjectStorage $category)
    {
        $this->category = $category;
    }


}

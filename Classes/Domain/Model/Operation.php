<?php
namespace KN\Operations\Domain\Model;

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
class Operation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Operation number
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $number;
	
	/**
	 * Operation onlyEld
	 *
	 * @var \integer
	 */
	protected $onlyEld;

	/**
	 * Title
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Location of operation
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $location;

	/**
	 * Begin
	 *
	 * @var \DateTime
	 * @validate NotEmpty
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
	 * @var \string
	 */
	protected $teaser;

	/**
	 * Operation report
	 *
	 * @var \string
	 */
	protected $report;

	/**
	 * Longitude
	 *
	 * @var \string
	 */
	protected $longitude;

	/**
	 * Latitude
	 *
	 * @var \string
	 */
	protected $latitude;

	/**
	 * Zoom for maps
	 * @lazy
	 * @var \integer
	 */
	protected $zoom;

	/**
  	* Image
   	* @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
   	*/
  	protected $image;

	/**
	 * Type of operation
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Type>
	 */
	protected $type;

	/**
	 * Assistance to this oparation
	 * @lazy
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Assistance>
	 */
	protected $assistance;

	/**
	 * Vehicles use on this operation
	 * @lazy
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Vehicle>
	 */
	protected $vehicles;

	/**
	 * resources
	 * @lazy
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Resources>
	 */
	protected $resources;

	/**
	 * __construct
	 *
	 * @return Operation
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->type = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		$this->assistance = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		$this->vehicles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		$this->resources = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->image = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the number
	 *
	 * @return \string $number
	 */
	public function getNumber() {
		return $this->number;
	}

	/**
	 * Sets the number
	 *
	 * @param \string $number
	 * @return void
	 */
	public function setNumber($number) {
		$this->number = $number;
	}
	
	/**
	 * Returns the onlyEld
	 *
	 * @return \integer $onlyEld
	 */
	public function getOnlyEld() {
		return $this->onlyEld;
	}

	/**
	 * Sets the onlyEld
	 *
	 * @param \integer $onlyEld
	 * @return void
	 */
	public function setOnlyEld($onlyEld) {
		$this->onlyEld = $onlyEld;
	}

	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the location
	 *
	 * @return \string $location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * Sets the location
	 *
	 * @param \string $location
	 * @return void
	 */
	public function setLocation($location) {
		$this->location = $location;
	}

	/**
	 * Returns the begin
	 *
	 * @return \DateTime $begin
	 */
	public function getBegin() {
		return $this->begin;
	}

	/**
	 * Sets the begin
	 *
	 * @param \DateTime $begin
	 * @return void
	 */
	public function setBegin($begin) {
		$this->begin = $begin;
	}


	/**
	 * Returns the end
	 *
	 * @return \DateTime $end
	 */
	public function getEnd() {
		return $this->end;
	}

	/**
	 * Sets the end
	 *
	 * @param \DateTime $end
	 * @return void
	 */
	public function setEnd($end) {
		$this->end = $end;
	}

	/**
	 * Returns the teaser
	 *
	 * @return \string $teaser
	 */
	public function getTeaser() {
		return $this->teaser;
	}

	/**
	 * Sets the teaser
	 *
	 * @param \string $teaser
	 * @return void
	 */
	public function setTeaser($teaser) {
		$this->teaser = $teaser;
	}

	/**
	 * Returns the report
	 *
	 * @return \string $report
	 */
	public function getReport() {
		return $this->report;
	}

	/**
	 * Sets the report
	 *
	 * @param \string $report
	 * @return void
	 */
	public function setReport($report) {
		$this->report = $report;
	}

	/**
	 * Returns the longitude
	 *
	 * @return \string $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * Sets the longitude
	 *
	 * @param \string $longitude
	 * @return void
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	/**
	 * Returns the latitude
	 *
	 * @return \string $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * Sets the latitude
	 *
	 * @param \string $latitude
	 * @return void
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	/**
	 * Returns the zoom
	 *
	 * @return \integer $zoom
	 */
	public function getZoom() {
		return $this->zoom;
	}

	/**
	 * Sets the zoom
	 *
	 * @param \integer $zoom
	 * @return void
	 */
	public function setZoom($zoom) {
		$this->zoom = $zoom;
	}

 /**
   * Returns the image
   *
   * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
   */
  public function getImage() {
          return $this->image;
  }
  /**
   * Returns all images
   *
   * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
   */
  public function getAllImages() {
  $images = $this->getImage()->toArray();
  //$images = $this->getImage();
    return $images;
  }
  /**
   * Returns the first image
   *
   * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
   */
  public function getFirstImage() {
  $image = $this->getImage()->toArray();
    return $image[0];
  }
  /**
   * Sets the image
   *
   * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
   * @return void
   */
  public function setImage($image) {
          $this->image = $image;
  }

	/**
	 * Adds a Type
	 *
	 * @param \KN\Operations\Domain\Model\Type $type
	 * @return void
	 */
	public function addType(\KN\Operations\Domain\Model\Type $type) {
		$this->type->attach($type);
	}

	/**
	 * Removes a Type
	 *
	 * @param \KN\Operations\Domain\Model\Type $typeToRemove The Type to be removed
	 * @return void
	 */
	public function removeType(\KN\Operations\Domain\Model\Type $typeToRemove) {
		$this->type->detach($typeToRemove);
	}

	/**
	 * Returns the type
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Type> $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Type> $type
	 * @return void
	 */
	public function setType(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $type) {
		$this->type = $type;
	}

	/**
	 * Adds a Assistance
	 *
	 * @param \KN\Operations\Domain\Model\Assistance $assistance
	 * @return void
	 */
	public function addAssistance(\KN\Operations\Domain\Model\Assistance $assistance) {
		$this->assistance->attach($assistance);
	}

	/**
	 * Removes a Assistance
	 *
	 * @param \KN\Operations\Domain\Model\Assistance $assistanceToRemove The Assistance to be removed
	 * @return void
	 */
	public function removeAssistance(\KN\Operations\Domain\Model\Assistance $assistanceToRemove) {
		$this->assistance->detach($assistanceToRemove);
	}

	/**
	 * Returns the assistance
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Assistance> $assistance
	 */
	public function getAssistance() {
		return $this->assistance;
	}

	/**
	 * Sets the assistance
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Assistance> $assistance
	 * @return void
	 */
	public function setAssistance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $assistance) {
		$this->assistance = $assistance;
	}

	/**
	 * Adds a Vehicle
	 *
	 * @param \KN\Operations\Domain\Model\Vehicle $vehicle
	 * @return void
	 */
	public function addVehicle(\KN\Operations\Domain\Model\Vehicle $vehicle) {
		$this->vehicles->attach($vehicle);
	}

	/**
	 * Removes a Vehicle
	 *
	 * @param \KN\Operations\Domain\Model\Vehicle $vehicleToRemove The Vehicle to be removed
	 * @return void
	 */
	public function removeVehicle(\KN\Operations\Domain\Model\Vehicle $vehicleToRemove) {
		$this->vehicles->detach($vehicleToRemove);
	}

	/**
	 * Returns the vehicles
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Vehicle> $vehicles
	 */
	public function getVehicles() {
		return $this->vehicles;
	}

	/**
	 * Sets the vehicles
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Vehicle> $vehicles
	 * @return void
	 */
	public function setVehicles(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $vehicles) {
		$this->vehicles = $vehicles;
	}

	/**
	 * Adds a Resources
	 *
	 * @param \KN\Operations\Domain\Model\Resources $resource
	 * @return void
	 */
	public function addResource(\KN\Operations\Domain\Model\Resources $resource) {
		$this->resources->attach($resource);
	}

	/**
	 * Removes a Resources
	 *
	 * @param \KN\Operations\Domain\Model\Resources $resourceToRemove The Resources to be removed
	 * @return void
	 */
	public function removeResource(\KN\Operations\Domain\Model\Resources $resourceToRemove) {
		$this->resources->detach($resourceToRemove);
	}

	/**
	 * Returns the resources
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Resources> $resources
	 */
	public function getResources() {
		return $this->resources;
	}

	/**
	 * Sets the resources
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KN\Operations\Domain\Model\Resources> $resources
	 * @return void
	 */
	public function setResources(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $resources) {
		$this->resources = $resources;
	}

}
?>

<?php

namespace Kanow\Operations\Tests;
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
 * Test case for class \Kanow\Operations\Domain\Model\Operation.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Operations
 *
 * @author Karsten Nowak <captnnowi@gmx.de>
 */
class OperationTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \Kanow\Operations\Domain\Model\Operation
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Kanow\Operations\Domain\Model\Operation();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getNumberReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNumberForStringSetsNumber() { 
		$this->fixture->setNumber('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getNumber()
		);
	}
	
	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getLocationReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLocationForStringSetsLocation() { 
		$this->fixture->setLocation('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLocation()
		);
	}
	
	/**
	 * @test
	 */
	public function getBeginReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setBeginForDateTimeSetsBegin() { }
	
	/**
	 * @test
	 */
	public function getEndReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setEndForDateTimeSetsEnd() { }
	
	/**
	 * @test
	 */
	public function getReportReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setReportForStringSetsReport() { 
		$this->fixture->setReport('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getReport()
		);
	}
	
	/**
	 * @test
	 */
	public function getLongitudeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLongitudeForStringSetsLongitude() { 
		$this->fixture->setLongitude('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLongitude()
		);
	}
	
	/**
	 * @test
	 */
	public function getLatitudeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLatitudeForStringSetsLatitude() { 
		$this->fixture->setLatitude('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLatitude()
		);
	}
	
	/**
	 * @test
	 */
	public function getZoomReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getZoom()
		);
	}

	/**
	 * @test
	 */
	public function setZoomForIntegerSetsZoom() { 
		$this->fixture->setZoom(12);

		$this->assertSame(
			12,
			$this->fixture->getZoom()
		);
	}
	
	/**
	 * @test
	 */
	public function getImageReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setImageForStringSetsImage() { 
		$this->fixture->setImage('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getImage()
		);
	}
	
	/**
	 * @test
	 */
	public function getTypeReturnsInitialValueForType() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getType()
		);
	}

	/**
	 * @test
	 */
	public function setTypeForObjectStorageContainingTypeSetsType() { 
		$type = new \Kanow\Operations\Domain\Model\Type();
		$objectStorageHoldingExactlyOneType = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneType->attach($type);
		$this->fixture->setType($objectStorageHoldingExactlyOneType);

		$this->assertSame(
			$objectStorageHoldingExactlyOneType,
			$this->fixture->getType()
		);
	}
	
	/**
	 * @test
	 */
	public function addTypeToObjectStorageHoldingType() {
		$type = new \Kanow\Operations\Domain\Model\Type();
		$objectStorageHoldingExactlyOneType = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneType->attach($type);
		$this->fixture->addType($type);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneType,
			$this->fixture->getType()
		);
	}

	/**
	 * @test
	 */
	public function removeTypeFromObjectStorageHoldingType() {
		$type = new \Kanow\Operations\Domain\Model\Type();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($type);
		$localObjectStorage->detach($type);
		$this->fixture->addType($type);
		$this->fixture->removeType($type);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getType()
		);
	}
	
	/**
	 * @test
	 */
	public function getAssistanceReturnsInitialValueForAssistance() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getAssistance()
		);
	}

	/**
	 * @test
	 */
	public function setAssistanceForObjectStorageContainingAssistanceSetsAssistance() { 
		$assistance = new \Kanow\Operations\Domain\Model\Assistance();
		$objectStorageHoldingExactlyOneAssistance = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneAssistance->attach($assistance);
		$this->fixture->setAssistance($objectStorageHoldingExactlyOneAssistance);

		$this->assertSame(
			$objectStorageHoldingExactlyOneAssistance,
			$this->fixture->getAssistance()
		);
	}
	
	/**
	 * @test
	 */
	public function addAssistanceToObjectStorageHoldingAssistance() {
		$assistance = new \Kanow\Operations\Domain\Model\Assistance();
		$objectStorageHoldingExactlyOneAssistance = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneAssistance->attach($assistance);
		$this->fixture->addAssistance($assistance);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneAssistance,
			$this->fixture->getAssistance()
		);
	}

	/**
	 * @test
	 */
	public function removeAssistanceFromObjectStorageHoldingAssistance() {
		$assistance = new \Kanow\Operations\Domain\Model\Assistance();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($assistance);
		$localObjectStorage->detach($assistance);
		$this->fixture->addAssistance($assistance);
		$this->fixture->removeAssistance($assistance);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getAssistance()
		);
	}
	
	/**
	 * @test
	 */
	public function getVehiclesReturnsInitialValueForVehicle() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getVehicles()
		);
	}

	/**
	 * @test
	 */
	public function setVehiclesForObjectStorageContainingVehicleSetsVehicles() { 
		$vehicle = new \Kanow\Operations\Domain\Model\Vehicle();
		$objectStorageHoldingExactlyOneVehicles = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneVehicles->attach($vehicle);
		$this->fixture->setVehicles($objectStorageHoldingExactlyOneVehicles);

		$this->assertSame(
			$objectStorageHoldingExactlyOneVehicles,
			$this->fixture->getVehicles()
		);
	}
	
	/**
	 * @test
	 */
	public function addVehicleToObjectStorageHoldingVehicles() {
		$vehicle = new \Kanow\Operations\Domain\Model\Vehicle();
		$objectStorageHoldingExactlyOneVehicle = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneVehicle->attach($vehicle);
		$this->fixture->addVehicle($vehicle);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneVehicle,
			$this->fixture->getVehicles()
		);
	}

	/**
	 * @test
	 */
	public function removeVehicleFromObjectStorageHoldingVehicles() {
		$vehicle = new \Kanow\Operations\Domain\Model\Vehicle();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($vehicle);
		$localObjectStorage->detach($vehicle);
		$this->fixture->addVehicle($vehicle);
		$this->fixture->removeVehicle($vehicle);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getVehicles()
		);
	}
	
	/**
	 * @test
	 */
	public function getResourcesReturnsInitialValueForResources() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getResources()
		);
	}

	/**
	 * @test
	 */
	public function setResourcesForObjectStorageContainingResourcesSetsResources() { 
		$resource = new \Kanow\Operations\Domain\Model\Resource();
		$objectStorageHoldingExactlyOneResources = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneResources->attach($resource);
		$this->fixture->setResources($objectStorageHoldingExactlyOneResources);

		$this->assertSame(
			$objectStorageHoldingExactlyOneResources,
			$this->fixture->getResources()
		);
	}
	
	/**
	 * @test
	 */
	public function addResourceToObjectStorageHoldingResources() {
		$resource = new \Kanow\Operations\Domain\Model\Resource();
		$objectStorageHoldingExactlyOneResource = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneResource->attach($resource);
		$this->fixture->addResource($resource);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneResource,
			$this->fixture->getResources()
		);
	}

	/**
	 * @test
	 */
	public function removeResourceFromObjectStorageHoldingResources() {
		$resource = new \Kanow\Operations\Domain\Model\Resource();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($resource);
		$localObjectStorage->detach($resource);
		$this->fixture->addResource($resource);
		$this->fixture->removeResource($resource);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getResources()
		);
	}
	
}
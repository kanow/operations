<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Domain\Model\Operation;
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
use Kanow\Operations\Domain\Model\Operation;
use Kanow\Operations\Domain\Model\Type;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
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
 * @covers \Kanow\Operations\Domain\Model\Operation
 */
class OperationTest extends UnitTestCase {

	private Operation $subject;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->subject = new Operation();
    }

    /**
     * @test
     */
    public function isAbstractEntity(): void
    {
        self::assertInstanceOf(AbstractEntity::class, $this->subject);
    }

    /**
     * @test
     */
    public function titleCanBeSet(): void
    {
        $value = 'This is an operation title';
        $this->subject->setTitle($value);
        $this->assertSame($value, $this->subject->getTitle());
    }

    /**
     * @test
     */
    public function numberCanBeSet(): void
    {
        $value = '2023';
        $this->subject->setNumber($value);
        $this->assertIsString($this->subject->getNumber());
        $this->assertSame($value, $this->subject->getNumber());
    }

    /**
     * @test
     */
    public function onlyEldCanBeSet(): void
    {
        $value = 1;
        $this->subject->setOnlyEld($value);
        $this->assertIsInt($this->subject->getOnlyEld());
        $this->assertSame($value, $this->subject->getOnlyEld());
    }

    /**
     * @test
     */
    public function locationCanBeSet(): void
    {
        $value = 'My location';
        $this->subject->setLocation($value);
        $this->assertSame($value, $this->subject->getLocation());
    }

    /**
     * @test
     */
    public function beginCanBeSet(): void
    {
        $value = '1600899999';
        //$value = new \DateTime();
        $this->subject->setBegin($value);
        $this->assertSame($value, $this->subject->getBegin());
    }

    /**
     * @test
     */
    public function endCanBeSet(): void
    {
        $value = '1610899999';
        $this->subject->setEnd($value);
        $this->assertSame($value, $this->subject->getEnd());
    }

    /**
     * @test
     */
    public function teaserCanBeSet(): void
    {
        $value = 'This is an operation teaser';
        $this->subject->setTeaser($value);
        $this->assertSame($value, $this->subject->getTeaser());
    }

    /**
     * @test
     */
    public function reportCanBeSet(): void
    {
        $value = 'This is an operation report';
        $this->subject->setReport($value);
        $this->assertSame($value, $this->subject->getReport());
    }

    /**
     * @test
     */
    public function longitudeCanBeSet(): void
    {
        $value = '11.03773';
        $this->subject->setLongitude($value);
        $this->assertSame($value, $this->subject->getLongitude());
    }

    /**
     * @test
     */
    public function latitudeCanBeSet(): void
    {
        $value = '51.75745';
        $this->subject->setLatitude($value);
        $this->assertSame($value, $this->subject->getLatitude());
    }

    /**
     * @test
     */
    public function zoomCanBeSet(): void
    {
        $value = 15;
        $this->subject->setZoom($value);
        $this->assertIsInt($this->subject->getZoom());
        $this->assertSame($value, $this->subject->getZoom());
    }

    /**
     * @test
     */
    public function mediaCanBeAdded(): void
    {
        $mediaItem = new FileReference();
        $media = new ObjectStorage();
        $media->attach($mediaItem);
        $this->subject->setMedia($media);
        $this->assertEquals($media, $this->subject->getMedia());
        $this->assertEquals($mediaItem, $this->subject->getFirstMedia());
    }

    /**
     * @test
     */
    public function typeCanBeSet(): void
    {
        $type = new Type();
        $type->setTitle('Typ fire');

        $operationType = new ObjectStorage();
        $operationType->attach($type);

        $this->subject->setType($operationType);
        $this->assertEquals($operationType,$this->subject->getType());
    }

}
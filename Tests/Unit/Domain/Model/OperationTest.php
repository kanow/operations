<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Domain\Model;

use Kanow\Operations\Domain\Model\Assistance;
use Kanow\Operations\Domain\Model\Category;
use Kanow\Operations\Domain\Model\Operation;
use Kanow\Operations\Domain\Model\Resource;
use Kanow\Operations\Domain\Model\Type;
use Kanow\Operations\Domain\Model\Vehicle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(Operation::class)]
final class OperationTest extends UnitTestCase
{
    private Operation $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new Operation();
    }

    #[Test]
    public function isAbstractEntity(): void
    {
        self::assertInstanceOf(AbstractEntity::class, $this->subject);
    }

    #[Test]
    public function getNumberInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getNumber());
    }

    #[Test]
    public function setNumberSetsNumber(): void
    {
        $value = '2024-042';
        $this->subject->setNumber($value);

        self::assertSame($value, $this->subject->getNumber());
    }

    #[Test]
    public function getOnlyEldInitiallyReturnsZero(): void
    {
        self::assertSame(0, $this->subject->getOnlyEld());
    }

    #[Test]
    public function setOnlyEldSetsOnlyEld(): void
    {
        $this->subject->setOnlyEld(1);

        self::assertSame(1, $this->subject->getOnlyEld());
    }

    #[Test]
    public function getTitleInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getTitle());
    }

    #[Test]
    public function setTitleSetsTitle(): void
    {
        $value = 'Fire in residential building';
        $this->subject->setTitle($value);

        self::assertSame($value, $this->subject->getTitle());
    }

    #[Test]
    public function getLocationInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getLocation());
    }

    #[Test]
    public function setLocationSetsLocation(): void
    {
        $value = 'Main Street 1';
        $this->subject->setLocation($value);

        self::assertSame($value, $this->subject->getLocation());
    }

    #[Test]
    public function getBeginInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getBegin());
    }

    #[Test]
    public function setBeginSetsBegin(): void
    {
        $value = new \DateTime('2024-05-01 12:30:00');
        $this->subject->setBegin($value);

        self::assertSame($value, $this->subject->getBegin());
    }

    #[Test]
    public function getEndInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getEnd());
    }

    #[Test]
    public function setEndSetsEnd(): void
    {
        $value = new \DateTime('2024-05-01 14:00:00');
        $this->subject->setEnd($value);

        self::assertSame($value, $this->subject->getEnd());
    }

    #[Test]
    public function getTeaserInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getTeaser());
    }

    #[Test]
    public function setTeaserSetsTeaser(): void
    {
        $value = 'A short teaser.';
        $this->subject->setTeaser($value);

        self::assertSame($value, $this->subject->getTeaser());
    }

    #[Test]
    public function getReportInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getReport());
    }

    #[Test]
    public function setReportSetsReport(): void
    {
        $value = '<p>The full report.</p>';
        $this->subject->setReport($value);

        self::assertSame($value, $this->subject->getReport());
    }

    #[Test]
    public function getLongitudeInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getLongitude());
    }

    #[Test]
    public function setLongitudeSetsLongitude(): void
    {
        $value = '13.404954';
        $this->subject->setLongitude($value);

        self::assertSame($value, $this->subject->getLongitude());
    }

    #[Test]
    public function getLatitudeInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getLatitude());
    }

    #[Test]
    public function setLatitudeSetsLatitude(): void
    {
        $value = '52.520008';
        $this->subject->setLatitude($value);

        self::assertSame($value, $this->subject->getLatitude());
    }

    #[Test]
    public function getZoomInitiallyReturnsZero(): void
    {
        self::assertSame(0, $this->subject->getZoom());
    }

    #[Test]
    public function setZoomSetsZoom(): void
    {
        $this->subject->setZoom(14);

        self::assertSame(14, $this->subject->getZoom());
    }

    #[Test]
    public function getMediaInitiallyReturnsEmptyStorage(): void
    {
        $media = $this->subject->getMedia();

        self::assertInstanceOf(ObjectStorage::class, $media);
        self::assertCount(0, $media);
    }

    #[Test]
    public function setMediaSetsMedia(): void
    {
        /** @var ObjectStorage<FileReference> $media */
        $media = new ObjectStorage();
        $this->subject->setMedia($media);

        self::assertSame($media, $this->subject->getMedia());
    }

    #[Test]
    public function getFirstMediaInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getFirstMedia());
    }

    #[Test]
    public function getFirstMediaReturnsFirstAttachedMedia(): void
    {
        $firstMedia = new FileReference();
        $secondMedia = new FileReference();
        /** @var ObjectStorage<FileReference> $media */
        $media = new ObjectStorage();
        $media->attach($firstMedia);
        $media->attach($secondMedia);
        $this->subject->setMedia($media);

        self::assertSame($firstMedia, $this->subject->getFirstMedia());
    }

    #[Test]
    public function getTypeInitiallyReturnsEmptyStorage(): void
    {
        $type = $this->subject->getType();

        self::assertInstanceOf(ObjectStorage::class, $type);
        self::assertCount(0, $type);
    }

    #[Test]
    public function setTypeSetsType(): void
    {
        /** @var ObjectStorage<Type> $type */
        $type = new ObjectStorage();
        $this->subject->setType($type);

        self::assertSame($type, $this->subject->getType());
    }

    #[Test]
    public function addTypeAddsType(): void
    {
        $type = new Type();
        $this->subject->addType($type);

        self::assertSame([$type], $this->subject->getType()?->toArray());
    }

    #[Test]
    public function removeTypeRemovesType(): void
    {
        $typeToKeep = new Type();
        $typeToRemove = new Type();
        $this->subject->addType($typeToKeep);
        $this->subject->addType($typeToRemove);

        $this->subject->removeType($typeToRemove);

        self::assertSame([$typeToKeep], $this->subject->getType()?->toArray());
    }

    #[Test]
    public function getAssignedTypeInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getAssignedType());
    }

    #[Test]
    public function getAssignedTypeReturnsFirstType(): void
    {
        $firstType = new Type();
        $secondType = new Type();
        $this->subject->addType($firstType);
        $this->subject->addType($secondType);

        self::assertSame($firstType, $this->subject->getAssignedType());
    }

    #[Test]
    public function getAssistanceInitiallyReturnsEmptyStorage(): void
    {
        $assistance = $this->subject->getAssistance();

        self::assertInstanceOf(ObjectStorage::class, $assistance);
        self::assertCount(0, $assistance);
    }

    #[Test]
    public function setAssistanceSetsAssistance(): void
    {
        /** @var ObjectStorage<Assistance> $assistance */
        $assistance = new ObjectStorage();
        $this->subject->setAssistance($assistance);

        self::assertSame($assistance, $this->subject->getAssistance());
    }

    #[Test]
    public function addAssistanceAddsAssistance(): void
    {
        $assistance = new Assistance();
        $this->subject->addAssistance($assistance);

        self::assertSame([$assistance], $this->subject->getAssistance()?->toArray());
    }

    #[Test]
    public function removeAssistanceRemovesAssistance(): void
    {
        $assistanceToKeep = new Assistance();
        $assistanceToRemove = new Assistance();
        $this->subject->addAssistance($assistanceToKeep);
        $this->subject->addAssistance($assistanceToRemove);

        $this->subject->removeAssistance($assistanceToRemove);

        self::assertSame([$assistanceToKeep], $this->subject->getAssistance()?->toArray());
    }

    #[Test]
    public function getVehiclesInitiallyReturnsEmptyStorage(): void
    {
        $vehicles = $this->subject->getVehicles();

        self::assertInstanceOf(ObjectStorage::class, $vehicles);
        self::assertCount(0, $vehicles);
    }

    #[Test]
    public function setVehiclesSetsVehicles(): void
    {
        /** @var ObjectStorage<Vehicle> $vehicles */
        $vehicles = new ObjectStorage();
        $this->subject->setVehicles($vehicles);

        self::assertSame($vehicles, $this->subject->getVehicles());
    }

    #[Test]
    public function addVehicleAddsVehicle(): void
    {
        $vehicle = new Vehicle();
        $this->subject->addVehicle($vehicle);

        self::assertSame([$vehicle], $this->subject->getVehicles()?->toArray());
    }

    #[Test]
    public function removeVehicleRemovesVehicle(): void
    {
        $vehicleToKeep = new Vehicle();
        $vehicleToRemove = new Vehicle();
        $this->subject->addVehicle($vehicleToKeep);
        $this->subject->addVehicle($vehicleToRemove);

        $this->subject->removeVehicle($vehicleToRemove);

        self::assertSame([$vehicleToKeep], $this->subject->getVehicles()?->toArray());
    }

    #[Test]
    public function getResourcesInitiallyReturnsEmptyStorage(): void
    {
        $resources = $this->subject->getResources();

        self::assertInstanceOf(ObjectStorage::class, $resources);
        self::assertCount(0, $resources);
    }

    #[Test]
    public function setResourcesSetsResources(): void
    {
        /** @var ObjectStorage<\Kanow\Operations\Domain\Model\Resource> $resources */
        $resources = new ObjectStorage();
        $resources->attach(new Resource());
        $this->subject->setResources($resources);

        self::assertSame($resources, $this->subject->getResources());
    }

    #[Test]
    public function getCategoryInitiallyReturnsEmptyStorage(): void
    {
        $category = $this->subject->getCategory();

        self::assertInstanceOf(ObjectStorage::class, $category);
        self::assertCount(0, $category);
    }

    #[Test]
    public function setCategorySetsCategory(): void
    {
        /** @var ObjectStorage<Category> $category */
        $category = new ObjectStorage();
        $this->subject->setCategory($category);

        self::assertSame($category, $this->subject->getCategory());
    }

    #[Test]
    public function addCategoryAddsCategory(): void
    {
        $category = new Category();
        $this->subject->addCategory($category);

        self::assertSame([$category], $this->subject->getCategory()?->toArray());
    }

    #[Test]
    public function removeCategoryRemovesCategory(): void
    {
        $categoryToKeep = new Category();
        $categoryToRemove = new Category();
        $this->subject->addCategory($categoryToKeep);
        $this->subject->addCategory($categoryToRemove);

        $this->subject->removeCategory($categoryToRemove);

        self::assertSame([$categoryToKeep], $this->subject->getCategory()?->toArray());
    }
}

<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Persistence;

use Kanow\Operations\Domain\Model\Assistance;
use Kanow\Operations\Domain\Model\Category;
use Kanow\Operations\Domain\Model\Operation;
use Kanow\Operations\Domain\Model\Resource;
use Kanow\Operations\Domain\Model\Type;
use Kanow\Operations\Domain\Model\Vehicle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(Operation::class)]
final class OperationTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    private Operation $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->importCSVDataSet(__DIR__ . '/Fixtures/propertyMapping/OperationWithAllRelations.csv');
        $model = $this->get(PersistenceManagerInterface::class)->getObjectByIdentifier(1, Operation::class);
        self::assertInstanceOf(Operation::class, $model);
        $this->subject = $model;
    }

    #[Test]
    public function mapsAllScalarData(): void
    {
        self::assertSame('Kitchen fire', $this->subject->getTitle());
        self::assertSame('2023-17', $this->subject->getNumber());
        self::assertSame(1, $this->subject->getOnlyEld());
        self::assertSame('Thale, Main street 1', $this->subject->getLocation());
        self::assertSame('Smoke in the kitchen', $this->subject->getTeaser());
        self::assertSame('<p>The fire was extinguished quickly.</p>', $this->subject->getReport());
        self::assertSame('51.7500', $this->subject->getLatitude());
        self::assertSame('11.0400', $this->subject->getLongitude());
        self::assertSame(15, $this->subject->getZoom());
    }

    #[Test]
    public function mapsBeginAndEndToDateTime(): void
    {
        self::assertSame(1683288000, $this->subject->getBegin()?->getTimestamp());
        self::assertSame(1683295200, $this->subject->getEnd()?->getTimestamp());
    }

    #[Test]
    public function mapsTypeRelation(): void
    {
        $types = $this->subject->getType()?->toArray() ?? [];

        self::assertSame(['Fire'], array_map(static fn(Type $type): string => $type->getTitle(), $types));
        self::assertSame('Fire', $this->subject->getAssignedType()?->getTitle());
    }

    #[Test]
    public function mapsAssistanceRelationInSortingOrder(): void
    {
        $assistance = $this->subject->getAssistance()?->toArray() ?? [];

        $titles = array_map(static fn(Assistance $item): string => $item->getTitle(), $assistance);
        self::assertSame(['Ambulance', 'Police'], $titles);
    }

    #[Test]
    public function mapsVehiclesRelationInSortingOrder(): void
    {
        $vehicles = $this->subject->getVehicles()?->toArray() ?? [];

        $titles = array_map(static fn(Vehicle $vehicle): string => $vehicle->getTitle(), $vehicles);
        self::assertSame(['Rescue fire engine', 'Turntable ladder'], $titles);
    }

    #[Test]
    public function mapsResourcesRelation(): void
    {
        $resources = $this->subject->getResources()?->toArray() ?? [];

        $titles = array_map(static fn(Resource $resource): string => $resource->getTitle(), $resources);
        self::assertSame(['Thermal imaging camera'], $titles);
    }

    #[Test]
    public function mapsCategoryRelationFromSysCategory(): void
    {
        $categories = $this->subject->getCategory()?->toArray() ?? [];

        $titles = array_map(static fn(Category $category): string => $category->getTitle(), $categories);
        self::assertSame(['District North', 'Night'], $titles);
        self::assertSame('Operations', $categories[0]->getParent()?->getTitle());
    }

    #[Test]
    public function mapsMediaRelationToFileReferences(): void
    {
        $media = $this->subject->getMedia()?->toArray() ?? [];

        self::assertSame([1, 2], array_map(static fn(FileReference $reference): ?int => $reference->getUid(), $media));
    }

    #[Test]
    public function getFirstMediaReturnsFirstFileReferenceWithOriginalFile(): void
    {
        $firstMedia = $this->subject->getFirstMedia();

        self::assertInstanceOf(FileReference::class, $firstMedia);
        $originalResource = $firstMedia->getOriginalResource();
        self::assertSame('kitchen.svg', $originalResource->getName());
        self::assertSame('Burnt kitchen', $originalResource->getAlternative());
    }
}

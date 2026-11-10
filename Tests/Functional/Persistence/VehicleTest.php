<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Persistence;

use Kanow\Operations\Domain\Model\Vehicle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(Vehicle::class)]
final class VehicleTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    private Vehicle $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->importCSVDataSet(__DIR__ . '/Fixtures/propertyMapping/VehicleWithMedia.csv');
        $model = $this->get(PersistenceManagerInterface::class)->getObjectByIdentifier(1, Vehicle::class);
        self::assertInstanceOf(Vehicle::class, $model);
        $this->subject = $model;
    }

    #[Test]
    public function mapsAllScalarData(): void
    {
        self::assertSame('Rescue fire engine', $this->subject->getTitle());
        self::assertSame('HLF 20', $this->subject->getShort());
        self::assertSame('<p>Carries water.</p>', $this->subject->getDescription());
        self::assertSame('https://example.com/hlf-20', $this->subject->getLink());
    }

    #[Test]
    public function mapsMediaRelation(): void
    {
        self::assertCount(1, $this->subject->getMedia() ?? []);

        $firstMedia = $this->subject->getFirstMedia();
        self::assertInstanceOf(FileReference::class, $firstMedia);
        self::assertSame(1, $firstMedia->getUid());
        self::assertSame('vehicle.svg', $firstMedia->getOriginalResource()->getName());
    }
}

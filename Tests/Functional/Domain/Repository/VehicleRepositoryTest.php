<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Domain\Repository;

use Kanow\Operations\Domain\Model\Vehicle;
use Kanow\Operations\Domain\Repository\VehicleRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(VehicleRepository::class)]
final class VehicleRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    private VehicleRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->get(VehicleRepository::class);
    }

    private function useStoragePage(int $storagePageUid): void
    {
        $querySettings = $this->get(Typo3QuerySettings::class);
        $querySettings->setStoragePageIds([$storagePageUid]);
        $this->subject->setDefaultQuerySettings($querySettings);
    }

    /**
     * @return list<string>
     */
    private function findAllTitles(): array
    {
        $titles = [];
        foreach ($this->subject->findAll() as $vehicle) {
            self::assertInstanceOf(Vehicle::class, $vehicle);
            $titles[] = $vehicle->getTitle();
        }

        return $titles;
    }

    #[Test]
    public function isRepository(): void
    {
        self::assertInstanceOf(Repository::class, $this->subject);
    }

    #[Test]
    public function findAllForNoRecordsReturnsEmptyResult(): void
    {
        $this->useStoragePage(2);

        self::assertCount(0, $this->subject->findAll());
    }

    #[Test]
    public function findAllFindsVisibleVehiclesOnStoragePageSortedBySorting(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findAll/Vehicles.csv');
        $this->useStoragePage(2);

        self::assertSame(['Turntable ladder', 'Rescue fire engine', 'Command vehicle'], $this->findAllTitles());
    }

    #[Test]
    public function findAllRespectsStoragePage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findAll/Vehicles.csv');
        $this->useStoragePage(3);

        self::assertSame(['Vehicle on other page'], $this->findAllTitles());
    }

    #[Test]
    public function findByUidForExistingRecordReturnsModelWithData(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Vehicles.csv');

        $model = $this->subject->findByUid(1);

        self::assertInstanceOf(Vehicle::class, $model);
        self::assertSame('Rescue fire engine', $model->getTitle());
        self::assertSame('HLF 20', $model->getShort());
        self::assertSame('<p>Carries water and rescue equipment.</p>', $model->getDescription());
        self::assertSame('https://example.com/hlf-20', $model->getLink());
    }

    #[Test]
    public function findByUidForHiddenRecordReturnsNull(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Vehicles.csv');

        self::assertNull($this->subject->findByUid(2));
    }

    #[Test]
    public function findByUidForDeletedRecordReturnsNull(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Vehicles.csv');

        self::assertNull($this->subject->findByUid(3));
    }
}

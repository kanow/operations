<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Domain\Repository;

use Kanow\Operations\Domain\Model\Resource;
use Kanow\Operations\Domain\Repository\ResourceRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(ResourceRepository::class)]
final class ResourceRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    private ResourceRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->get(ResourceRepository::class);
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
        foreach ($this->subject->findAll() as $resource) {
            self::assertInstanceOf(Resource::class, $resource);
            $titles[] = $resource->getTitle();
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
    public function findAllFindsVisibleResourcesOnStoragePageSortedBySorting(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findAll/Resources.csv');
        $this->useStoragePage(2);

        self::assertSame(['Hydraulic rescue tool', 'Thermal imaging camera', 'Oil binder'], $this->findAllTitles());
    }

    #[Test]
    public function findAllRespectsStoragePage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findAll/Resources.csv');
        $this->useStoragePage(3);

        self::assertSame(['Resource on other page'], $this->findAllTitles());
    }

    #[Test]
    public function findByUidForExistingRecordReturnsModelWithData(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Resources.csv');

        $model = $this->subject->findByUid(1);

        self::assertInstanceOf(Resource::class, $model);
        self::assertSame('Thermal imaging camera', $model->getTitle());
        self::assertSame('TIC', $model->getShort());
        self::assertSame('<p>Finds people in smoke.</p>', $model->getDescription());
        self::assertSame('https://example.com/tic', $model->getLink());
    }

    #[Test]
    public function findByUidForHiddenRecordReturnsNull(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Resources.csv');

        self::assertNull($this->subject->findByUid(2));
    }

    #[Test]
    public function findByUidForDeletedRecordReturnsNull(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Resources.csv');

        self::assertNull($this->subject->findByUid(3));
    }
}

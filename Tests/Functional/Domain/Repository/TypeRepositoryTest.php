<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Domain\Repository;

use Kanow\Operations\Domain\Model\Type;
use Kanow\Operations\Domain\Repository\TypeRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(TypeRepository::class)]
final class TypeRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    private TypeRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->get(TypeRepository::class);
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
        foreach ($this->subject->findAll() as $type) {
            self::assertInstanceOf(Type::class, $type);
            $titles[] = $type->getTitle();
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
    public function findAllFindsVisibleTypesOnStoragePageSortedByTitle(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findAll/Types.csv');
        $this->useStoragePage(2);

        self::assertSame(['Fire', 'Hazardous materials', 'Technical assistance'], $this->findAllTitles());
    }

    #[Test]
    public function findAllRespectsStoragePage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findAll/Types.csv');
        $this->useStoragePage(3);

        self::assertSame(['Type on other page'], $this->findAllTitles());
    }

    #[Test]
    public function findAllWithLanguageOverlayReturnsTranslatedTypes(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findAll/Types.csv');
        $this->get(Context::class)->setAspect('language', new LanguageAspect(1, 1, LanguageAspect::OVERLAYS_MIXED));
        $this->useStoragePage(2);

        $titlesByUid = [];
        foreach ($this->subject->findAll() as $type) {
            self::assertInstanceOf(Type::class, $type);
            $titlesByUid[(int)$type->getUid()] = $type->getTitle();
        }
        ksort($titlesByUid);
        self::assertSame([1 => 'Feuer', 2 => 'Technical assistance', 3 => 'Hazardous materials'], $titlesByUid);
    }

    #[Test]
    public function findByUidForExistingRecordReturnsModelWithData(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Types.csv');

        $model = $this->subject->findByUid(1);

        self::assertInstanceOf(Type::class, $model);
        self::assertSame('Fire', $model->getTitle());
        self::assertSame('#ff0000', $model->getColor());
    }

    #[Test]
    public function findByUidIgnoresStoragePage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Types.csv');
        $this->useStoragePage(3);

        self::assertInstanceOf(Type::class, $this->subject->findByUid(1));
    }

    #[Test]
    public function findByUidForHiddenRecordReturnsNull(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Types.csv');

        self::assertNull($this->subject->findByUid(2));
    }

    #[Test]
    public function findByUidForDeletedRecordReturnsNull(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Types.csv');

        self::assertNull($this->subject->findByUid(3));
    }
}

<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Domain\Repository;

use Kanow\Operations\Domain\Model\Category;
use Kanow\Operations\Domain\Repository\CategoryRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(CategoryRepository::class)]
final class CategoryRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    private CategoryRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->get(CategoryRepository::class);
    }

    #[Test]
    public function isRepository(): void
    {
        self::assertInstanceOf(Repository::class, $this->subject);
    }

    #[Test]
    public function findAllForNoRecordsReturnsEmptyResult(): void
    {
        self::assertCount(0, $this->subject->findAll());
    }

    #[Test]
    public function findAllFindsVisibleCategoriesFromAllPages(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findAll/Categories.csv');

        $categories = $this->subject->findAll()->toArray();

        $titles = array_map(static fn(Category $category): string => $category->getTitle(), $categories);
        sort($titles);
        self::assertSame(['Category on root level', 'District North', 'District South', 'Operations'], $titles);
    }

    #[Test]
    public function findByUidForExistingRecordReturnsModelWithData(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Categories.csv');

        $model = $this->subject->findByUid(1);

        self::assertInstanceOf(Category::class, $model);
        self::assertSame('Operations', $model->getTitle());
        self::assertSame('All operations', $model->getDescription());
        self::assertNull($model->getParent());
    }

    #[Test]
    public function findByUidMapsParentCategory(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Categories.csv');

        $model = $this->subject->findByUid(2);

        self::assertInstanceOf(Category::class, $model);
        $parent = $model->getParent();
        self::assertInstanceOf(Category::class, $parent);
        self::assertSame(1, $parent->getUid());
        self::assertSame('Operations', $parent->getTitle());
    }

    #[Test]
    public function findByUidForHiddenRecordReturnsNull(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Categories.csv');

        self::assertNull($this->subject->findByUid(3));
    }

    #[Test]
    public function findByUidForDeletedRecordReturnsNull(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findByUid/Categories.csv');

        self::assertNull($this->subject->findByUid(4));
    }
}

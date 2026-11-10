<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Service;

use Kanow\Operations\Domain\Model\Category;
use Kanow\Operations\Domain\Repository\CategoryRepository;
use Kanow\Operations\Service\CategoryService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(CategoryService::class)]
final class CategoryServiceTest extends UnitTestCase
{
    private Category $root;

    private Category $childA;

    private Category $childB;

    private Category $grandchildA;

    private Category $otherRoot;

    private Category $otherChild;

    protected function setUp(): void
    {
        parent::setUp();

        $this->root = $this->createCategory('Root');
        $this->childA = $this->createCategory('Child A', $this->root);
        $this->childB = $this->createCategory('Child B', $this->root);
        $this->grandchildA = $this->createCategory('Grandchild A', $this->childA);
        $this->otherRoot = $this->createCategory('Other root');
        $this->otherChild = $this->createCategory('Other child', $this->otherRoot);
    }

    #[Test]
    public function findAllDescendantsSortsAllCategoriesByTitle(): void
    {
        $repository = $this->createMock(CategoryRepository::class);
        $repository->expects($this->once())->method('setDefaultOrderings')
            ->with(['title' => QueryInterface::ORDER_ASCENDING]);
        $repository->method('findAll')->willReturn($this->createQueryResult([]));

        (new CategoryService($repository))->findAllDescendants($this->root);
    }

    #[Test]
    public function findAllDescendantsReturnsChildrenAndGrandchildrenOfCategory(): void
    {
        $subject = $this->createSubject();

        $result = $subject->findAllDescendants($this->root);

        self::assertSame([$this->childA, $this->childB, $this->grandchildA], $result->toArray());
    }

    #[Test]
    public function findAllDescendantsReturnsOnlyDescendantsOfGivenSubtree(): void
    {
        $subject = $this->createSubject();

        $result = $subject->findAllDescendants($this->childA);

        self::assertSame([$this->grandchildA], $result->toArray());
    }

    #[Test]
    public function findAllDescendantsDoesNotContainTheCategoryItself(): void
    {
        $subject = $this->createSubject();

        $result = $subject->findAllDescendants($this->otherRoot);

        self::assertFalse($result->contains($this->otherRoot));
        self::assertSame([$this->otherChild], $result->toArray());
    }

    #[Test]
    public function findAllDescendantsForCategoryWithoutChildrenReturnsEmptyStorage(): void
    {
        $subject = $this->createSubject();

        $result = $subject->findAllDescendants($this->grandchildA);

        self::assertInstanceOf(ObjectStorage::class, $result);
        self::assertCount(0, $result);
    }

    #[Test]
    public function findAllDescendantsWithoutAnyCategoriesReturnsEmptyStorage(): void
    {
        $repository = self::createStub(CategoryRepository::class);
        $repository->method('findAll')->willReturn($this->createQueryResult([]));
        $subject = new CategoryService($repository);

        self::assertCount(0, $subject->findAllDescendants($this->root));
    }

    private function createSubject(): CategoryService
    {
        $allCategories = [
            $this->childA,
            $this->childB,
            $this->grandchildA,
            $this->otherChild,
            $this->otherRoot,
            $this->root,
        ];
        $repository = self::createStub(CategoryRepository::class);
        $repository->method('findAll')->willReturn($this->createQueryResult($allCategories));

        return new CategoryService($repository);
    }

    private function createCategory(string $title, ?Category $parent = null): Category
    {
        $category = new Category();
        $category->setTitle($title);
        if ($parent instanceof Category) {
            $category->setParent($parent);
        }

        return $category;
    }

    /**
     * @param list<Category> $categories
     * @return QueryResult<Category>
     */
    private function createQueryResult(array $categories): QueryResult
    {
        $dataMapper = self::createStub(DataMapper::class);
        $dataMapper->method('map')->willReturn($categories);
        $persistenceManager = self::createStub(PersistenceManagerInterface::class);
        $persistenceManager->method('getObjectDataByQuery')->willReturn([]);
        $query = self::createStub(QueryInterface::class);
        $query->method('getType')->willReturn(Category::class);

        /** @var QueryResult<Category> $queryResult */
        $queryResult = new QueryResult($dataMapper, $persistenceManager);
        $queryResult->setQuery($query);

        return $queryResult;
    }
}

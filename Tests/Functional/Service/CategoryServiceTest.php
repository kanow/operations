<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Service;

use Kanow\Operations\Domain\Model\Category;
use Kanow\Operations\Domain\Repository\CategoryRepository;
use Kanow\Operations\Service\CategoryService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(CategoryService::class)]
final class CategoryServiceTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    private CategoryService $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->importCSVDataSet(__DIR__ . '/Fixtures/findAllDescendants/Categories.csv');
        $this->subject = $this->get(CategoryService::class);
    }

    /**
     * @return list<string>
     */
    private function findDescendantTitles(int $parentCategoryUid): array
    {
        $parentCategory = $this->get(CategoryRepository::class)->findByUid($parentCategoryUid);
        self::assertInstanceOf(Category::class, $parentCategory);

        $titles = [];
        foreach ($this->subject->findAllDescendants($parentCategory) as $category) {
            self::assertInstanceOf(Category::class, $category);
            $titles[] = $category->getTitle();
        }

        return $titles;
    }

    #[Test]
    public function findAllDescendantsFindsVisibleChildrenAndGrandchildrenFromAllPages(): void
    {
        $titles = $this->findDescendantTitles(1);

        self::assertSame(['District North', 'District South', 'Village A', 'Street 1'], $titles);
    }

    #[Test]
    public function findAllDescendantsForCategoryInTheMiddleOfTheTreeFindsOnlyItsDescendants(): void
    {
        self::assertSame(['Village A', 'Street 1'], $this->findDescendantTitles(3));
    }

    #[Test]
    public function findAllDescendantsForLeafCategoryReturnsEmptyStorage(): void
    {
        self::assertSame([], $this->findDescendantTitles(5));
    }
}

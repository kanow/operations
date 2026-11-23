<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Persistence;

use Kanow\Operations\Domain\Model\Category;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(Category::class)]
final class CategoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    #[Test]
    public function isMappedToSysCategoryTable(): void
    {
        $dataMap = $this->get(DataMapFactory::class)->buildDataMap(Category::class);

        self::assertSame('sys_category', $dataMap->tableName);
    }

    #[Test]
    public function mapsParentPropertyToParentColumn(): void
    {
        $dataMap = $this->get(DataMapFactory::class)->buildDataMap(Category::class);

        self::assertTrue($dataMap->isPersistableProperty('parent'));
        self::assertSame('parent', $dataMap->getColumnMap('parent')?->columnName);
    }
}

<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Persistence;

use Kanow\Operations\Domain\Model\Type;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(Type::class)]
final class TypeTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    #[Test]
    public function mapsScalarDataAndImageRelation(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/propertyMapping/TypeWithImage.csv');

        $model = $this->get(PersistenceManagerInterface::class)->getObjectByIdentifier(1, Type::class);

        self::assertInstanceOf(Type::class, $model);
        self::assertSame('Fire', $model->getTitle());
        self::assertSame('#ff0000', $model->getColor());
        $images = $model->getImage()?->toArray() ?? [];
        self::assertSame([1], array_map(static fn(FileReference $reference): ?int => $reference->getUid(), $images));
    }
}

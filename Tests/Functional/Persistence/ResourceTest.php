<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Persistence;

use Kanow\Operations\Domain\Model\Resource;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(Resource::class)]
final class ResourceTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    private Resource $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->importCSVDataSet(__DIR__ . '/Fixtures/propertyMapping/ResourceWithMedia.csv');
        $model = $this->get(PersistenceManagerInterface::class)->getObjectByIdentifier(1, Resource::class);
        self::assertInstanceOf(Resource::class, $model);
        $this->subject = $model;
    }

    #[Test]
    public function mapsAllScalarData(): void
    {
        self::assertSame('Thermal imaging camera', $this->subject->getTitle());
        self::assertSame('TIC', $this->subject->getShort());
        self::assertSame('<p>Finds people in smoke.</p>', $this->subject->getDescription());
        self::assertSame('https://example.com/tic', $this->subject->getLink());
    }

    #[Test]
    public function mapsMediaRelation(): void
    {
        self::assertCount(1, $this->subject->getMedia() ?? []);

        $firstMedia = $this->subject->getFirstMedia();
        self::assertInstanceOf(FileReference::class, $firstMedia);
        self::assertSame(1, $firstMedia->getUid());
        self::assertSame('resource.svg', $firstMedia->getOriginalResource()->getName());
    }
}

<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Domain\Model;

use Kanow\Operations\Domain\Model\Vehicle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(Vehicle::class)]
final class VehicleTest extends UnitTestCase
{
    private Vehicle $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new Vehicle();
    }

    #[Test]
    public function isAbstractEntity(): void
    {
        self::assertInstanceOf(AbstractEntity::class, $this->subject);
    }

    #[Test]
    public function getTitleInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getTitle());
    }

    #[Test]
    public function setTitleSetsTitle(): void
    {
        $value = 'Tank fire engine';
        $this->subject->setTitle($value);

        self::assertSame($value, $this->subject->getTitle());
    }

    #[Test]
    public function getShortInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getShort());
    }

    #[Test]
    public function setShortSetsShort(): void
    {
        $value = 'TLF';
        $this->subject->setShort($value);

        self::assertSame($value, $this->subject->getShort());
    }

    #[Test]
    public function getDescriptionInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getDescription());
    }

    #[Test]
    public function setDescriptionSetsDescription(): void
    {
        $value = 'Fire engine with a 3000 litre water tank.';
        $this->subject->setDescription($value);

        self::assertSame($value, $this->subject->getDescription());
    }

    #[Test]
    public function getLinkInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getLink());
    }

    #[Test]
    public function setLinkSetsLink(): void
    {
        $value = 'https://www.example.com';
        $this->subject->setLink($value);

        self::assertSame($value, $this->subject->getLink());
    }

    #[Test]
    public function getMediaInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getMedia());
    }

    #[Test]
    public function setMediaSetsMedia(): void
    {
        /** @var ObjectStorage<FileReference> $media */
        $media = new ObjectStorage();
        $this->subject->setMedia($media);

        self::assertSame($media, $this->subject->getMedia());
    }

    #[Test]
    public function getFirstMediaInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getFirstMedia());
    }

    #[Test]
    public function getFirstMediaForEmptyMediaReturnsNull(): void
    {
        /** @var ObjectStorage<FileReference> $media */
        $media = new ObjectStorage();
        $this->subject->setMedia($media);

        self::assertNull($this->subject->getFirstMedia());
    }

    #[Test]
    public function getFirstMediaReturnsFirstAttachedMedia(): void
    {
        $firstMedia = new FileReference();
        $secondMedia = new FileReference();
        /** @var ObjectStorage<FileReference> $media */
        $media = new ObjectStorage();
        $media->attach($firstMedia);
        $media->attach($secondMedia);

        $this->subject->setMedia($media);

        self::assertSame($firstMedia, $this->subject->getFirstMedia());
    }
}

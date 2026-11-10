<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Domain\Model;

use Kanow\Operations\Domain\Model\Type;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(Type::class)]
final class TypeTest extends UnitTestCase
{
    private Type $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new Type();
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
        $value = 'Fire';
        $this->subject->setTitle($value);

        self::assertSame($value, $this->subject->getTitle());
    }

    #[Test]
    public function getImageInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getImage());
    }

    #[Test]
    public function setImageSetsImage(): void
    {
        /** @var ObjectStorage<FileReference> $image */
        $image = new ObjectStorage();
        $image->attach(new FileReference());

        $this->subject->setImage($image);

        self::assertSame($image, $this->subject->getImage());
    }

    #[Test]
    public function getColorInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getColor());
    }

    #[Test]
    public function setColorSetsColor(): void
    {
        $value = '#ff0000';
        $this->subject->setColor($value);

        self::assertSame($value, $this->subject->getColor());
    }
}

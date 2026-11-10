<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Domain\Model;

use Kanow\Operations\Domain\Model\Category;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(Category::class)]
final class CategoryTest extends UnitTestCase
{
    private Category $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new Category();
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
        $value = 'Technical assistance';
        $this->subject->setTitle($value);

        self::assertSame($value, $this->subject->getTitle());
    }

    #[Test]
    public function getDescriptionInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getDescription());
    }

    #[Test]
    public function setDescriptionSetsDescription(): void
    {
        $value = 'All operations with technical assistance.';
        $this->subject->setDescription($value);

        self::assertSame($value, $this->subject->getDescription());
    }

    #[Test]
    public function getParentInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getParent());
    }

    #[Test]
    public function setParentSetsParent(): void
    {
        $parent = new Category();
        $this->subject->setParent($parent);

        self::assertSame($parent, $this->subject->getParent());
    }
}

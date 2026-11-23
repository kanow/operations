<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Domain\Model;

use Kanow\Operations\Domain\Model\OperationDemand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(OperationDemand::class)]
final class OperationDemandTest extends UnitTestCase
{
    private OperationDemand $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new OperationDemand();
    }

    #[Test]
    public function isAbstractValueObject(): void
    {
        self::assertInstanceOf(AbstractValueObject::class, $this->subject);
    }

    #[Test]
    public function getOnlyEldInitiallyReturnsZero(): void
    {
        self::assertSame(0, $this->subject->getOnlyEld());
    }

    #[Test]
    public function setOnlyEldSetsOnlyEld(): void
    {
        $this->subject->setOnlyEld(1);

        self::assertSame(1, $this->subject->getOnlyEld());
    }

    #[Test]
    public function getTypeInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getType());
    }

    #[Test]
    public function setTypeSetsType(): void
    {
        $this->subject->setType(3);

        self::assertSame(3, $this->subject->getType());
    }

    #[Test]
    public function getLimitInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getLimit());
    }

    #[Test]
    public function setLimitSetsLimit(): void
    {
        $this->subject->setLimit(10);

        self::assertSame(10, $this->subject->getLimit());
    }

    #[Test]
    public function setLimitCanResetLimitToNull(): void
    {
        $this->subject->setLimit(10);
        $this->subject->setLimit(null);

        self::assertNull($this->subject->getLimit());
    }

    #[Test]
    public function getBeginInitiallyReturnsZero(): void
    {
        self::assertSame(0, $this->subject->getBegin());
    }

    #[Test]
    public function setBeginSetsBegin(): void
    {
        $this->subject->setBegin(2024);

        self::assertSame(2024, $this->subject->getBegin());
    }

    #[Test]
    public function getSearchstringInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getSearchstring());
    }

    #[Test]
    public function setSearchstringSetsSearchstring(): void
    {
        $value = 'traffic accident';
        $this->subject->setSearchstring($value);

        self::assertSame($value, $this->subject->getSearchstring());
    }

    #[Test]
    public function getCategoryInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getCategory());
    }

    #[Test]
    public function setCategorySetsCategory(): void
    {
        $this->subject->setCategory(5);

        self::assertSame(5, $this->subject->getCategory());
    }
}

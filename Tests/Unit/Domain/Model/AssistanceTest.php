<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Domain\Model;

use Kanow\Operations\Domain\Model\Assistance;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(Assistance::class)]
final class AssistanceTest extends UnitTestCase
{
    private Assistance $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new Assistance();
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
        $value = 'Police';
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
        $value = 'Supported the fire brigade with traffic control.';
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
}

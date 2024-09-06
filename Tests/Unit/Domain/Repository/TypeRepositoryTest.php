<?php

namespace Kanow\Operations\Tests\Unit\Domain\Repository\Type;

use Kanow\Operations\Domain\Repository\TypeRepository;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class TypeRepositoryTest extends UnitTestCase
{
    /**
     * @var TypeRepository
     */
    private TypeRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        if (\interface_exists(ObjectManagerInterface::class)) {
            $objectManager = $this->createMock(ObjectManagerInterface::class);
            // @phpstan-ignore-next-line This line is 11LTS-specific, but we're running PHPStan on TYPO3 12.
            $this->subject = new TypeRepository($objectManager);
        } else {
            $this->subject = new TypeRepository();
        }
    }

    /**
     * @test
     */
    public function isRepository(): void
    {
        self::assertInstanceOf(Repository::class, $this->subject);
    }
}

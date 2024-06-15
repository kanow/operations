<?php

namespace Kanow\Operations\Tests\Unit\Domain\Repository\Resource;

use Kanow\Operations\Domain\Repository\ResourceRepository;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ResourceRepositoryTest extends UnitTestCase
{
    /**
     * @var ResourceRepository
     */
    private ResourceRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        if (\interface_exists(ObjectManagerInterface::class)) {
            $objectManager = $this->createMock(ObjectManagerInterface::class);
            // @phpstan-ignore-next-line This line is 11LTS-specific, but we're running PHPStan on TYPO3 12.
            $this->subject = new ResourceRepository($objectManager);
        } else {
            $this->subject = new ResourceRepository();
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

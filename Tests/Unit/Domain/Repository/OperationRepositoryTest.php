<?php

namespace Kanow\Operations\Tests\Unit\Domain\Repository\Operation;

use Kanow\Operations\Domain\Repository\OperationRepository;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class OperationRepositoryTest extends UnitTestCase
{
    /** @var \Kanow\Operations\Domain\Repository\OperationRepository|\PHPUnit\Framework\MockObject\|\TYPO3\TestingFramework\Core\AccessibleObjectInterface */
    protected $mockedOperationRepository;


    protected function setUp(): void
    {
        $this->mockedOperationRepository = $this->getAccessibleMock(OperationRepository::class, ['getQueryBuilder'], [], '', false);

        $mockedQueryBuilder = $this->getAccessibleMock(QueryBuilder::class, ['escapeStrForLike', 'createNamedParameter'], [], '', false);
        $this->mockedOperationRepository->expects($this->any())->method('getQueryBuilder')->withAnyParameters()->will($this->returnValue($mockedQueryBuilder));
    }

    /**
     * @test
     */
    public function isRepository(): void
    {
        self::assertInstanceOf(Repository::class, $this->mockedOperationRepository);
    }

    /**
     * @test
     */
    public function convertYearsToStringReturnsString(): void
    {
        $yearsAsString = '2020,2021,2022';
        $yearsAsArray = ['2020', '2021', '2022'];

        $reflector = new \ReflectionClass(OperationRepository::class);
        $method = $reflector->getMethod('convertYearsToString');
        $method->setAccessible(true);
        $result = $method->invokeArgs($this->mockedOperationRepository, array($yearsAsArray));
        $this->assertSame($result, $yearsAsString);
    }
}
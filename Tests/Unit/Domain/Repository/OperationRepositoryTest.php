<?php

namespace Kanow\Operations\Tests\Unit\Domain\Repository\Operation;

use Kanow\Operations\Domain\Model\Type;
use Kanow\Operations\Domain\Repository\OperationRepository;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class OperationRepositoryTest extends UnitTestCase
{
    /** @var \Kanow\Operations\Domain\Repository\OperationRepository|\PHPUnit\Framework\MockObject\|\TYPO3\TestingFramework\Core\AccessibleObjectInterface */
    protected $mockedOperationRepository;

    /**
     * @var $statisticResultArray array
     */
    protected $statisticResultArray = [
        '0' => [
            'title' => 'One',
            'color' => '#000',
            'years' => [
                '2018' => 35,
                '2015' => 25,
                '2023' => 20
            ]
        ]
    ];

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

    /**
     * @test
     */
    public function cleanUnusedConstraintsRemoveNullValues(): void
    {
        $constraints = [
            '0' => 'This is not null.',
            '1' => null,
            '2' => 'This is also not null.'
        ];
        $reflector = new \ReflectionClass(OperationRepository::class);
        $method = $reflector->getMethod('cleanUnusedConstraints');
        $method->setAccessible(true);
        $result = $method->invokeArgs($this->mockedOperationRepository, array($constraints));
        $this->assertCount('2', $result);
    }

    /**
     * @test
     */
    public function addEmptyYearAddsNewYear(): void
    {
        $result = $this->statisticResultArray;
        $newYear = '2020';
        $reflector = new \ReflectionClass(OperationRepository::class);
        $method = $reflector->getMethod('addEmptyYear');
        $method->setAccessible(true);
        $resultWithNewYear = $method->invokeArgs($this->mockedOperationRepository, array($result, $newYear));
        $this->assertIsArray($resultWithNewYear);
        $this->assertEquals('2020', array_key_last($resultWithNewYear['0']['years']));
    }

    /**
     * @test
     */
    public function addMissingTypeAddsType(): void
    {
        $data = $this->statisticResultArray;
        $type = new Type();
        $type->setTitle('BMA');
        $type->setColor('#cccccc');
        $type->_setProperty('uid',1);
        $types = new ObjectStorage();
        $types->attach($type);

        $reflector = new \ReflectionClass(OperationRepository::class);
        $method = $reflector->getMethod('addMissingType');
        $method->setAccessible(true);

        $newResultWithAddedType = $method->invokeArgs($this->mockedOperationRepository, [$data,$types,'2023']);

        $this->assertArrayHasKey(1,$newResultWithAddedType);
    }

    /**
     * @test
     */
    public function sortResultByYearsReturnSortedResult(): void
    {
        $result = $this->statisticResultArray;
        $reflector = new \ReflectionClass(OperationRepository::class);
        $method = $reflector->getMethod('sortResultByYears');
        $method->setAccessible(true);
        $resultSorted = $method->invokeArgs($this->mockedOperationRepository, array($result));
        $this->assertIsArray($resultSorted);
        $this->assertArrayHasKey('years',$resultSorted['0']);
        $this->assertEquals($result['0']['title'], $resultSorted['0']['title']);
        $this->assertEquals($result['0']['color'], $resultSorted['0']['color'], );
        $this->assertNotSame(array_key_first($result['0']['years']), array_key_first($resultSorted['0']['years']));
        $this->assertNotSame(array_key_last($result['0']['years']), array_key_last($resultSorted['0']['years']));
        $this->assertEquals('2023', array_key_first($resultSorted['0']['years']));
        $this->assertEquals('2015', array_key_last($resultSorted['0']['years']));
    }
}
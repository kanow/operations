<?php

namespace Kanow\Operations\Tests\Unit\Domain\Repository\Operation;

use Kanow\Operations\Domain\Model\Type;
use Kanow\Operations\Domain\Repository\OperationRepository;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class OperationRepositoryTest extends UnitTestCase
{
    /**
     * @var OperationRepository
     */
    private OperationRepository $subject;

    /**
     * @var array $statisticResultArray
     */
    protected array $statisticResultArray = [
        '1' => [
            'title' => 'One',
            'color' => '#000',
            'years' => [
                '2018' => 35,
                '2015' => 25,
                '2023' => 20,
            ],
        ],
        '5' => [
            'title' => 'Two',
            'color' => '#f0f',
            'years' => [
                '2018' => 35,
                '2015' => 25,
                '2023' => 20,
            ],
        ],
        '3' => [
            'title' => 'Three',
            'color' => '#AA0',
            'years' => [
                '2018' => 35,
                '2015' => 25,
                '2023' => 20,
            ],
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        if (\interface_exists(ObjectManagerInterface::class)) {
            $objectManager = $this->createMock(ObjectManagerInterface::class);
            // @phpstan-ignore-next-line This line is 11LTS-specific, but we're running PHPStan on TYPO3 12.
            $this->subject = new OperationRepository($objectManager);
        } else {
            $this->subject = new OperationRepository();
        }
    }

    /**
     * @test
     */
    public function isRepository(): void
    {
        self::assertInstanceOf(Repository::class, $this->subject);
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
        $result = $method->invokeArgs($this->subject, [$yearsAsArray]);
        self::assertSame($result, $yearsAsString);
    }

    /**
     * @test
     */
    public function cleanUnusedConstraintsRemoveNullValues(): void
    {
        $constraints = [
            '0' => 'This is not null.',
            '1' => null,
            '2' => 'This is also not null.',
        ];
        $reflector = new \ReflectionClass(OperationRepository::class);
        $method = $reflector->getMethod('cleanUnusedConstraints');
        $method->setAccessible(true);
        $result = $method->invokeArgs($this->subject, [$constraints]);
        self::assertCount(2, $result);
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
        $resultWithNewYear = $method->invokeArgs($this->subject, [$result, $newYear]);
        self::assertIsArray($resultWithNewYear);
        self::assertEquals('2020', array_key_last($resultWithNewYear['1']['years']));
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
        $type->_setProperty('uid', 7);
        $types = [$type];

        $reflector = new \ReflectionClass(OperationRepository::class);
        $method = $reflector->getMethod('addMissingType');
        $method->setAccessible(true);

        $newResultWithAddedType = $method->invokeArgs($this->subject, [$data, $types, '2023']);

        self::assertArrayHasKey(7, $newResultWithAddedType);
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
        $resultSorted = $method->invokeArgs($this->subject, [$result]);
        self::assertIsArray($resultSorted);
        self::assertArrayHasKey('years', $resultSorted['1']);
        self::assertEquals($result['1']['title'], $resultSorted['1']['title']);
        self::assertEquals($result['1']['color'], $resultSorted['1']['color']);
        self::assertNotSame(array_key_first($result['1']['years']), array_key_first($resultSorted['1']['years']));
        self::assertNotSame(array_key_last($result['1']['years']), array_key_last($resultSorted['1']['years']));
        self::assertEquals('2023', array_key_first($resultSorted['1']['years']));
        self::assertEquals('2015', array_key_last($resultSorted['1']['years']));
    }

    /**
     * @test
     */
    public function sortResultByTypeUidReturnSortedResult(): void
    {
        $data = $this->statisticResultArray;

        $reflector = new \ReflectionClass(OperationRepository::class);
        $method = $reflector->getMethod('sortResultByTypeUid');
        $method->setAccessible(true);
        $dataSorted = $method->invokeArgs($this->subject, [$data]);
        self::assertEquals(5, array_key_last($dataSorted));
    }

    /**
     * @test
     */
    public function cleanUnusedConstraintsReturnCleanedArray(): void
    {
        $constraintsArray = [
            0 => 'is set',
            1 => 0,
            2 => null,
        ];

        $reflector = new \ReflectionClass(OperationRepository::class);
        $method = $reflector->getMethod('cleanUnusedConstraints');
        $method->setAccessible(true);
        $cleanedConstraintsArray = $method->invokeArgs($this->subject, [$constraintsArray]);
        self::assertArrayNotHasKey(2, $cleanedConstraintsArray);
        self::assertEquals(1, array_key_last($cleanedConstraintsArray));
        self::assertSame($cleanedConstraintsArray['0'], 'is set');
    }
}

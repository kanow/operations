<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional;

use Kanow\Operations\Domain\Model\OperationDemand;
use Kanow\Operations\Domain\Repository\OperationRepository;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class OperationRepositoryTest extends FunctionalTestCase
{
    /**
     * @var OperationRepository
     */
    private OperationRepository $subject;

    /**
     * @var string[]
     */
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/operations',
    ];

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getContainer()->get(OperationRepository::class);
        $this->importCSVDataSet(__DIR__ . '/../../Fixtures/TxOperations.csv');
    }

    /**
     * Test if storagePid is working
     *
     * @test
     */
    public function findRecordsByUid(): void
    {
        $operation = $this->subject->findByUid(1);
        self::assertEquals($operation->getTitle(), 'Einsatztest');
    }

    /**
     * Test if record by year constraint works
     *
     * @test
     */
    public function findRecordsByYear(): void
    {
        $demand = new OperationDemand();
        $_GET['id'] = 1;
        $settings = [];
        $settings['dontRespectStoragePage'] = 1;
        date_default_timezone_set('Europe/Berlin');
        // year 2020
        $demand->setBegin(2020);
        self::assertEquals((int)$this->subject->findDemanded($demand, $settings)->count(), 0);
        // year 2021
        $demand->setBegin(2021);
        self::assertEquals((int)$this->subject->findDemanded($demand, $settings)->count(), 1);
        // year 2022
        $demand->setBegin(2022);
        self::assertEquals((int)$this->subject->findDemanded($demand, $settings)->count(), 2);
    }

    /**
     * Count result for statistics without limit
     * if the setting noLimitForStatistics is active
     *
     * @test
     */
    public function noLimitSettingForStatisticsIsRespected(): void
    {
        $_GET['id'] = 1;
        $demand = new OperationDemand();
        $settings = [
            'limit' => 2,
            'noLimitForStatistics' => 0,
            'dontRespectStoragePage' => 1,
        ];
        self::assertEquals(2, (int)$this->subject->countDemandedForStatistics($demand, $settings));
        $demand->setLimit(1);
        self::assertEquals(1, (int)$this->subject->countDemandedForStatistics($demand, $settings));
        $settings['noLimitForStatistics'] = 1;
        self::assertEquals(3, (int)$this->subject->countDemandedForStatistics($demand, $settings));
    }

    /**
     * Count operations grouped by year
     *
     * @test
     */
    public function countOperationsByYear(): void
    {
        $years = [
            '2020' => 2020,
            '2021' => 2021,
            '2022' => 2022,
        ];
        $expectedResult = [
            0 => [
                'count' => 2,
                'year' => '2022',
            ],
            1 => [
                'count' => 1,
                'year' => '2021',
            ],
        ];
        $operationUids = '1,2,3';
        $result = $this->subject->countGroupedByYear($years, $operationUids);
        self::assertEquals($expectedResult, $result);
    }

    public function tearDown(): void
    {
        unset($this->subject);
    }
}

<?php

namespace Kanow\Operations\Tests\Functional;

use Kanow\Operations\Domain\Model\OperationDemand;
use Kanow\Operations\Domain\Repository\OperationRepository;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class OperationRepositoryTest extends FunctionalTestCase
{

    /**
     * @var OperationRepository
     */
    protected $operationRepository;

    /**
     * @var array
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/operations'
    ];

    /** @noinspection PhpMultipleClassDeclarationsInspection */
    public function setUp(): void
    {
        parent::setUp();
        $versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
        $this->operationRepository = $this->getContainer()->get(OperationRepository::class);
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/operations/Tests/Functional/Fixtures/DomainModelOperation.csv');
    }

    /**
     * Test if storagePid is working
     *
     * @test
     */
    public function findRecordsByUid(): void
    {
        $operation = $this->operationRepository->findByUid(1);
        $this->assertEquals($operation->getTitle(), 'Einsatztest');
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

        // year 2020
        $demand->setBegin('2020');
        $this->assertEquals((int)$this->operationRepository->findDemanded($demand, $settings)->count(), 0);
        // year 2021
        $demand->setBegin('2021');
        $this->assertEquals((int)$this->operationRepository->findDemanded($demand, $settings)->count(), 1);
        // year 2022
        $demand->setBegin('2022');
        $this->assertEquals((int)$this->operationRepository->findDemanded($demand, $settings)->count(), 2);
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
        $demand->setLimit(2);
        $settings = [
            'noLimitForStatistics' => 0
        ];
        $this->assertEquals(2, (int)$this->operationRepository->countDemandedForStatistics($demand, $settings));
        $settings['noLimitForStatistics'] = 1;
        $this->assertEquals(3, (int)$this->operationRepository->countDemandedForStatistics($demand, $settings));
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
        $result = $this->operationRepository->countGroupedByYear($years, $operationUids);
        $this->assertEquals($expectedResult, $result);

    }
}

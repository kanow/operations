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
        if ($versionInformation->getMajorVersion() === 11) {
            $this->operationRepository = $this->getContainer()->get(OperationRepository::class);
        } else {
            $this->operationRepository = GeneralUtility::makeInstance(ObjectManager::class)->get(OperationRepository::class);
        }
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/operations/Tests/Functional/Fixtures/DomainModelOperation.csv');
    }

    /**
     * Test if storagePid is working
     *
     * @test
     */
    public function findRecordsByUid(): void
    {
        $_GET['id'] = 1;
        $operation = $this->operationRepository->findByUid(1);
        $this->assertEquals($operation->getTitle(), 'Einsatztest');
    }

    /**
     * Test if record by year constraint works
     *
     * @test
     *
     * @return void
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
}

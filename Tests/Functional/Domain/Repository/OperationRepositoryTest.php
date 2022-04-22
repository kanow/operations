<?php

namespace Kanow\Operations\Tests\Functional;

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
//        $this->importDataSet('PACKAGE:typo3/testing-framework/Resources/Core/Functional/Fixtures/pages.xml');
        $this->importDataSet(__DIR__ . '/../../Fixtures/tx_operations_domain_model_operation.xml');
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
}

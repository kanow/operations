<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Controller;

use PHPUnit\Framework\Attributes\Test;
use Kanow\Operations\Controller\OperationController;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3\TestingFramework\Core\SystemEnvironmentBuilder;

final class OperationControllerTest extends FunctionalTestCase
{
    protected OperationController $subject;

    protected array $testExtensionsToLoad = [
        'typo3conf/ext/operations',
    ];
    protected function setUp(): void
    {
        parent::setUp();
        $GLOBALS['TYPO3_REQUEST'] = (new ServerRequest())
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_BE);
        $this->subject = $this->getContainer()->get(OperationController::class);
        $this->importCSVDataSet(__DIR__ . '/../Fixtures/TxOperations.csv');
    }

    #[Test]
    public function generateYearsReturnsYears(): void
    {
        $expectedResult = [
            2022 => '2022',
            2021 => '2021',
        ];
        $reflection = new \ReflectionClass($this->subject);
        $settingsProperty = $reflection->getProperty('settings');
        $settingsProperty->setValue($this->subject, ['lastYears' => 5]);
        $method = $reflection->getMethod('generateYears');

        $result = $method->invoke($this->subject, '1,2,3');
        self::assertSame($result,$expectedResult);

    }
    #[Test]
    public function generateYearsRespectSettingsForLastYears(): void
    {
        $expectedResult = [
            2022 => '2022',
        ];
        $reflection = new \ReflectionClass($this->subject);
        $settingsProperty = $reflection->getProperty('settings');
        $settingsProperty->setValue($this->subject, ['lastYears' => 1]);
        $method = $reflection->getMethod('generateYears');

        $result = $method->invoke($this->subject, '1,2,3');
        self::assertSame($result,$expectedResult);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->subject);
    }
}

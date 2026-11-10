<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Controller;

use Kanow\Operations\Controller\VehicleController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(VehicleController::class)]
final class VehicleControllerTest extends FunctionalTestCase
{
    private const LIST_PAGE_UID = 1;

    private const SHOW_PAGE_UID = 4;

    protected array $testExtensionsToLoad = ['kanow/operations'];

    protected array $coreExtensionsToLoad = ['typo3/cms-fluid-styled-content'];

    protected array $pathsToLinkInTestInstance = [
        'typo3conf/ext/operations/Tests/Functional/Controller/Fixtures/Sites/' => 'typo3conf/sites',
    ];

    protected array $pathsToProvideInTestInstance = [
        'typo3conf/ext/operations/Resources/Public/Icons/tx_operations_vehicle.svg' => 'fileadmin/user_upload/vehicle.svg',
    ];

    protected array $configurationToUseInTestInstance = [
        'FE' => [
            'cacheHash' => [
                'enforceValidation' => false,
            ],
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->importCSVDataSet(__DIR__ . '/Fixtures/Database/RootPage.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Database/VehicleController/Vehicles.csv');
    }

    /**
     * @param array<string, int> $queryParameters
     */
    private function renderPage(int $pageUid, array $queryParameters = []): string
    {
        $request = (new InternalRequest())->withPageId($pageUid)->withQueryParameters($queryParameters);
        $response = $this->executeFrontendSubRequest($request);

        self::assertSame(200, $response->getStatusCode());

        return (string)$response->getBody();
    }

    #[Test]
    public function listActionRendersVisibleVehiclesFromRecordStoragePageSortedBySorting(): void
    {
        $html = $this->renderPage(self::LIST_PAGE_UID);

        $firstPosition = strpos($html, 'Turntable ladder<span class="short"> (DLK 23)</span>');
        $secondPosition = strpos($html, 'Rescue fire engine<span class="short"> (HLF 20)</span>');
        self::assertIsInt($firstPosition);
        self::assertIsInt($secondPosition);
        self::assertLessThan($secondPosition, $firstPosition);
        self::assertStringNotContainsString('Hidden vehicle', $html);
        self::assertStringNotContainsString('Vehicle on other page', $html);
    }

    #[Test]
    public function listActionLinksVehiclesWithoutLinkToShowAction(): void
    {
        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString(
            'tx_operations_pi1%5Baction%5D=show&amp;tx_operations_pi1%5Bcontroller%5D=Vehicle&amp;tx_operations_pi1%5Bvehicle%5D=1',
            $html
        );
    }

    #[Test]
    public function listActionLinksVehiclesWithLinkToThatLink(): void
    {
        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString('<a href="https://example.com/dlk-23">', $html);
    }

    #[Test]
    public function listActionRendersFirstMediaOrDefaultImage(): void
    {
        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString('<img src="/fileadmin/user_upload/vehicle.svg"', $html);
        self::assertStringContainsString('Resources/Public/Icons/tx_operations_vehicle.svg', $html);
        self::assertStringContainsString('title="Default image (vehicles) if no image available."', $html);
    }

    #[Test]
    public function listActionRendersDescriptionWithoutMarkup(): void
    {
        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString('<p>Carries water and rescue equipment.</p>', $html);
    }

    #[Test]
    public function showActionRendersTheGivenVehicle(): void
    {
        $html = $this->renderPage(self::SHOW_PAGE_UID, ['tx_operations_pi1[vehicle]' => 1]);

        self::assertStringContainsString('<span class="number">HLF 20</span> - Rescue fire engine</h1>', $html);
        self::assertStringContainsString('<h2>Description of vehicle</h2>', $html);
        self::assertStringContainsString('<p>Carries water and rescue equipment.</p>', $html);
        self::assertStringContainsString('<img src="/fileadmin/user_upload/vehicle.svg"', $html);
        self::assertStringNotContainsString('Turntable ladder', $html);
    }

    #[Test]
    public function showActionForUnavailableVehicleThrowsTargetNotFoundException(): void
    {
        $this->expectException(TargetNotFoundException::class);

        $this->renderPage(self::SHOW_PAGE_UID, ['tx_operations_pi1[vehicle]' => 3]);
    }
}

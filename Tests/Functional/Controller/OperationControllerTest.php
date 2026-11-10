<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Controller;

use Kanow\Operations\Controller\BaseController;
use Kanow\Operations\Controller\OperationController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Mvc\Controller\Exception\RequiredArgumentMissingException;
use TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Renders the operation plugins in the frontend of a site that uses the site set "kanow/operations"
 * (see Fixtures/Sites/default).
 */
#[CoversClass(OperationController::class)]
#[CoversClass(BaseController::class)]
final class OperationControllerTest extends FunctionalTestCase
{
    private const FIXTURES_PATH = __DIR__ . '/Fixtures/Database/OperationController/';

    private const LIST_PAGE_UID = 1;

    private const SHOW_PAGE_UID = 4;

    private const STATISTICS_PAGE_UID = 5;

    protected array $testExtensionsToLoad = ['kanow/operations'];

    protected array $coreExtensionsToLoad = ['typo3/cms-fluid-styled-content'];

    protected array $pathsToLinkInTestInstance = [
        'typo3conf/ext/operations/Tests/Functional/Controller/Fixtures/Sites/' => 'typo3conf/sites',
    ];

    protected array $pathsToProvideInTestInstance = [
        'typo3conf/ext/operations/Resources/Public/Icons/tx_operations_operation.svg' => 'fileadmin/user_upload/operation.svg',
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
    }

    /**
     * @param array<string, string|int> $queryParameters
     */
    private function renderPage(int $pageUid, array $queryParameters = []): string
    {
        $request = (new InternalRequest())->withPageId($pageUid)->withQueryParameters($queryParameters);
        $response = $this->executeFrontendSubRequest($request);

        self::assertSame(200, $response->getStatusCode());

        return (string)$response->getBody();
    }

    private function renderListWithOperations(string $contentElementFixture = 'ListContentElement.csv'): string
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'Operations.csv');
        $this->importCSVDataSet(self::FIXTURES_PATH . $contentElementFixture);

        return $this->renderPage(self::LIST_PAGE_UID);
    }

    /**
     * @param array<string, string|int> $demand
     */
    private function renderSearchWithOperations(array $demand): string
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'Operations.csv');
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ListContentElement.csv');

        $queryParameters = [];
        foreach ($demand as $property => $value) {
            $queryParameters['tx_operations_pi1[demand][' . $property . ']'] = $value;
        }

        return $this->renderPage(self::LIST_PAGE_UID, $queryParameters);
    }

    private function renderStatisticsWithOperations(string $contentElementFixture = 'StatisticsContentElement.csv'): string
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'StatisticsOperations.csv');
        $this->importCSVDataSet(self::FIXTURES_PATH . $contentElementFixture);

        return $this->renderPage(self::STATISTICS_PAGE_UID);
    }

    private static function assertStringOccursBefore(string $first, string $second, string $haystack): void
    {
        $firstPosition = strpos($haystack, $first);
        $secondPosition = strpos($haystack, $second);
        self::assertIsInt($firstPosition, '"' . $first . '" not found.');
        self::assertIsInt($secondPosition, '"' . $second . '" not found.');
        self::assertLessThan($secondPosition, $firstPosition, '"' . $first . '" is not before "' . $second . '".');
    }

    #[Test]
    public function listActionRendersVisibleOperationsFromRecordStoragePage(): void
    {
        $html = $this->renderListWithOperations();

        self::assertStringContainsString('List of operations', $html);
        self::assertStringContainsString('Kitchen fire', $html);
        self::assertStringContainsString('Car accident', $html);
        self::assertStringContainsString('Chimney fire', $html);
        self::assertStringNotContainsString('Hidden operation', $html);
        self::assertStringNotContainsString('Operation on other page', $html);
    }

    #[Test]
    public function listActionRendersOperationsSortedByBeginDescending(): void
    {
        $html = $this->renderListWithOperations();

        self::assertStringOccursBefore('Car accident', 'Kitchen fire', $html);
        self::assertStringOccursBefore('Kitchen fire', 'Chimney fire', $html);
    }

    #[Test]
    public function listActionRendersMetaDataOfOperations(): void
    {
        $html = $this->renderListWithOperations();

        self::assertStringContainsString('05.05.2023, 12:00 Uhr', $html);
        self::assertStringContainsString('Type of operation: Fire', $html);
        self::assertStringContainsString('Location of operation: Thale', $html);
        self::assertStringContainsString('<span>District North</span>', $html);
        self::assertStringContainsString('Smoke in the kitchen', $html);
    }

    #[Test]
    public function listActionRendersNumberOfFoundOperations(): void
    {
        $html = $this->renderListWithOperations();

        self::assertStringContainsString('3 operations found', $html);
    }

    #[Test]
    public function listActionLinksOperationsToShowAction(): void
    {
        $html = $this->renderListWithOperations();

        self::assertStringContainsString('tx_operations_pi1%5Baction%5D=show', $html);
        self::assertStringContainsString('tx_operations_pi1%5Boperation%5D=1&amp;', $html);
    }

    #[Test]
    public function listActionRendersFilterFormWithYearsTypesAndCategories(): void
    {
        $html = $this->renderListWithOperations();

        self::assertStringContainsString('<div class="filter">', $html);
        self::assertStringContainsString('name="tx_operations_pi1[demand][begin]"', $html);
        self::assertStringContainsString('<option value="2023">2023</option>', $html);
        self::assertStringContainsString('<option value="2022">2022</option>', $html);
        self::assertStringContainsString('name="tx_operations_pi1[demand][type]"', $html);
        self::assertStringContainsString('<option value="1">Fire</option>', $html);
        self::assertStringContainsString('<option value="2">Technical assistance</option>', $html);
        self::assertStringContainsString('name="tx_operations_pi1[demand][category]"', $html);
        self::assertStringContainsString('<option value="2">District North</option>', $html);
        self::assertStringContainsString('name="tx_operations_pi1[demand][searchstring]"', $html);
    }

    #[Test]
    public function listActionWithHideFilterInFlexFormDoesNotRenderFilterForm(): void
    {
        $html = $this->renderListWithOperations('ListContentElementWithHiddenFilter.csv');

        self::assertStringNotContainsString('<div class="filter">', $html);
        self::assertStringContainsString('Kitchen fire', $html);
    }

    #[Test]
    public function listActionWithCategoryFromFlexFormOnlyRendersOperationsWithThatCategory(): void
    {
        $html = $this->renderListWithOperations('ListContentElementWithCategoryFromFlexForm.csv');

        self::assertStringContainsString('Kitchen fire', $html);
        self::assertStringNotContainsString('Car accident', $html);
        self::assertStringNotContainsString('Chimney fire', $html);
    }

    #[Test]
    public function listActionWithShowMapInFlexFormRendersMapWithOperationsWithCoordinates(): void
    {
        $html = $this->renderListWithOperations('ListContentElementWithMap.csv');

        self::assertStringContainsString('Map of operations', $html);
        self::assertStringContainsString('id="leaflet-map"', $html);
        self::assertStringContainsString('&quot;lat&quot;:&quot;51.7500&quot;', $html);
        self::assertStringContainsString('Kitchen fire</li>', $html);
        self::assertStringNotContainsString('Car accident', $html);
    }

    #[Test]
    public function listActionWithHidePaginationInFlexFormRendersOperationsWithoutPagination(): void
    {
        $html = $this->renderListWithOperations('ListContentElementWithHiddenPagination.csv');

        self::assertStringContainsString('Kitchen fire', $html);
        self::assertStringNotContainsString('class="pagination"', $html);
    }

    #[Test]
    public function listActionWithoutRecordStoragePageRendersOperationsFromCurrentPage(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'OperationsOnCurrentPage.csv');
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ListContentElementWithoutStoragePage.csv');

        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString('Operation on current page', $html);
        self::assertStringNotContainsString('Operation in storage folder', $html);
    }

    #[Test]
    public function listActionWithoutRootCategoryInSiteSettingsOffersAllCategoriesInFilter(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'Operations.csv');
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ListContentElement.csv');

        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString('<option value="1">Operations</option>', $html);
        self::assertStringContainsString('<option value="2">District North</option>', $html);
    }

    #[Test]
    public function listActionWithRootCategoryInSiteSettingsOnlyOffersDescendantCategoriesInFilter(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'SiteWithRootCategory.csv');

        $request = (new InternalRequest('http://rootcategory.localhost/'))->withPageId(10);
        $html = (string)$this->executeFrontendSubRequest($request)->getBody();

        self::assertStringContainsString('Kitchen fire', $html);
        self::assertStringContainsString('<option value="2">District North</option>', $html);
        self::assertStringContainsString('<option value="3">Village A</option>', $html);
        self::assertStringNotContainsString('<option value="1">Operations</option>', $html);
        self::assertStringNotContainsString('Other root', $html);
    }

    #[Test]
    public function listActionWithoutOperationsRendersEmptyResultMessage(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ListContentElement.csv');

        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString('No results', $html);
        self::assertStringNotContainsString('operations found', $html);
    }

    #[Test]
    public function listActionRendersFirstPageOfPaginatedOperations(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'TwelveOperations.csv');
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ListContentElement.csv');

        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString('12 operations found', $html);
        self::assertStringContainsString('Visible Operations: 1 - 10', $html);
        self::assertStringContainsString('Operation 12', $html);
        self::assertStringContainsString('Operation 03', $html);
        self::assertStringNotContainsString('Operation 02', $html);
        self::assertStringContainsString('tx_operations_pi1%5BcurrentPage%5D=2', $html);
    }

    #[Test]
    public function listActionRendersSecondPageOfPaginatedOperations(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'TwelveOperations.csv');
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ListContentElement.csv');

        $html = $this->renderPage(self::LIST_PAGE_UID, ['tx_operations_pi1[currentPage]' => 2]);

        self::assertStringContainsString('Visible Operations: 11 - 12', $html);
        self::assertStringContainsString('Operation 02', $html);
        self::assertStringContainsString('Operation 01', $html);
        self::assertStringNotContainsString('Operation 03', $html);
    }

    #[Test]
    public function listActionWithDemandForwardsToSearchActionAndFiltersBySearchString(): void
    {
        $html = $this->renderSearchWithOperations(['searchstring' => 'fire']);

        self::assertStringContainsString('2 operations found', $html);
        self::assertStringContainsString('Kitchen fire', $html);
        self::assertStringContainsString('Chimney fire', $html);
        self::assertStringNotContainsString('Car accident', $html);
        // The pagination links of the search action keep the demand
        self::assertStringContainsString('tx_operations_pi1%5Baction%5D=search', $html);
        self::assertStringContainsString('tx_operations_pi1%5Bdemand%5D%5Bsearchstring%5D=fire', $html);
    }

    #[Test]
    public function searchActionFiltersByYear(): void
    {
        $html = $this->renderSearchWithOperations(['begin' => 2022]);

        self::assertStringContainsString('1 operation found', $html);
        self::assertStringContainsString('Chimney fire', $html);
        self::assertStringNotContainsString('Kitchen fire', $html);
        self::assertStringNotContainsString('Car accident', $html);
    }

    #[Test]
    public function searchActionFiltersByType(): void
    {
        $html = $this->renderSearchWithOperations(['type' => 2]);

        self::assertStringContainsString('Car accident', $html);
        self::assertStringNotContainsString('Kitchen fire', $html);
        self::assertStringNotContainsString('Chimney fire', $html);
    }

    #[Test]
    public function searchActionFiltersByCategory(): void
    {
        $html = $this->renderSearchWithOperations(['category' => 2]);

        self::assertStringContainsString('Kitchen fire', $html);
        self::assertStringNotContainsString('Car accident', $html);
        self::assertStringNotContainsString('Chimney fire', $html);
    }

    #[Test]
    public function searchActionWithoutMatchesRendersEmptyResultMessage(): void
    {
        $html = $this->renderSearchWithOperations(['searchstring' => 'Avalanche']);

        self::assertStringContainsString('No results', $html);
        self::assertStringNotContainsString('Kitchen fire', $html);
    }

    #[Test]
    public function showActionRendersTheGivenOperation(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ShowWithOperation.csv');

        $html = $this->renderPage(self::SHOW_PAGE_UID, ['tx_operations_pi1[operation]' => 1]);

        self::assertStringContainsString('<h1>Kitchen fire</h1>', $html);
        self::assertStringContainsString('<span class="number">2023-17</span>', $html);
        self::assertStringContainsString('<p>The fire was extinguished quickly.</p>', $html);
        self::assertStringContainsString('<p>Fire</p>', $html);
        self::assertStringContainsString('05.05.2023, 12:00 Uhr', $html);
        self::assertStringContainsString('05.05.2023, 14:00 Uhr', $html);
        self::assertStringContainsString('<p>Thale, Main street 1</p>', $html);
        self::assertStringContainsString('<span>District North</span>', $html);
        self::assertStringNotContainsString('Car accident', $html);
    }

    #[Test]
    public function showActionRendersRelatedVehiclesResourcesAndAssistance(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ShowWithOperation.csv');

        $html = $this->renderPage(self::SHOW_PAGE_UID, ['tx_operations_pi1[operation]' => 1]);

        self::assertStringContainsString('Rescue fire engine<span class="short"> (HLF 20)</span>', $html);
        self::assertStringContainsString('tx_operations_pi1%5Bcontroller%5D=Vehicle&amp;tx_operations_pi1%5Bvehicle%5D=1', $html);
        self::assertStringContainsString('Thermal imaging camera<span class="short"> (TIC)</span>', $html);
        self::assertStringContainsString('tx_operations_pi1%5Bcontroller%5D=Resource&amp;tx_operations_pi1%5Bresource%5D=1', $html);
        self::assertStringContainsString('Ambulance', $html);
        self::assertStringContainsString('<a href="https://example.com/police" target="_blank" rel="noreferrer">Police</a>', $html);
    }

    #[Test]
    public function showActionRendersMediaAndMap(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ShowWithOperation.csv');

        $html = $this->renderPage(self::SHOW_PAGE_UID, ['tx_operations_pi1[operation]' => 1]);

        self::assertStringContainsString('<figure>', $html);
        self::assertStringContainsString('<img src="/fileadmin/user_upload/operation.svg"', $html);
        self::assertStringContainsString('alt="Burnt kitchen"', $html);
        self::assertStringContainsString('id="leaflet-map"', $html);
        self::assertStringContainsString('operations-pin.svg', $html);
    }

    #[Test]
    public function showActionForOperationWithoutReportRendersNoReportMessage(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ShowWithOperation.csv');

        $html = $this->renderPage(self::SHOW_PAGE_UID, ['tx_operations_pi1[operation]' => 2]);

        self::assertStringContainsString('<h1>Car accident</h1>', $html);
        self::assertStringContainsString('Sorry, there is no report here', $html);
        self::assertStringNotContainsString('<figure>', $html);
    }

    /**
     * The extension does not set "mvc.showPageNotFoundIfTargetNotFoundException", so the Extbase exception is
     * not converted to a 404 response. In the "Production" context, the content object exception handler
     * renders an error message for the plugin instead.
     */
    #[Test]
    public function showActionForUnavailableOperationThrowsTargetNotFoundException(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ShowWithOperation.csv');

        $this->expectException(TargetNotFoundException::class);
        $this->expectExceptionCode(1297933823);

        $this->renderPage(self::SHOW_PAGE_UID, ['tx_operations_pi1[operation]' => 99]);
    }

    /**
     * The extension does not set "mvc.showPageNotFoundIfRequiredArgumentIsMissingException", so the Extbase
     * exception is not converted to a 404 response.
     */
    #[Test]
    public function showActionWithoutOperationThrowsRequiredArgumentMissingException(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'ShowWithOperation.csv');

        $this->expectException(RequiredArgumentMissingException::class);
        $this->expectExceptionCode(1298012500);

        $this->renderPage(self::SHOW_PAGE_UID);
    }

    #[Test]
    public function statisticsActionRendersHeadline(): void
    {
        $html = $this->renderStatisticsWithOperations();

        self::assertStringContainsString('<h1>Statistics of operations</h1>', $html);
    }

    #[Test]
    public function statisticsActionRendersSumOfVisibleOperationsPerYear(): void
    {
        $html = $this->renderStatisticsWithOperations();

        self::assertStringContainsString('<th class="text-left">2023</th><td class="text-left">3</td>', $html);
        self::assertStringContainsString('<th class="text-left">2022</th><td class="text-left">1</td>', $html);
    }

    #[Test]
    public function statisticsActionRendersDataTableWithYearsAndCountsPerType(): void
    {
        $html = $this->renderStatisticsWithOperations();

        self::assertStringContainsString(
            '<thead><tr><th></th><th class="chart-label">2023</th><th class="chart-label">2022</th></tr></thead>',
            $html
        );
        self::assertStringContainsString(
            '<td class="data-row-label" data-color="#ff0000">Fire</td><td class="data-row-data">2</td><td class="data-row-data">1</td>',
            $html
        );
        self::assertStringContainsString(
            '<td class="data-row-label" data-color="#00ff00">Technical assistance</td><td class="data-row-data">1</td><td class="data-row-data">0</td>',
            $html
        );
        self::assertStringContainsString('<canvas id="operationsChart-3" data-uid="3" class="operations-chart"></canvas>', $html);
    }

    #[Test]
    public function statisticsActionIncludesChartScriptsExactlyOnce(): void
    {
        $html = $this->renderStatisticsWithOperations();

        self::assertSame(1, substr_count($html, 'Resources/Public/Js/Chart.bundle.js'));
        self::assertSame(1, substr_count($html, 'Resources/Public/Js/OperationsChart.js'));
    }

    /**
     * OperationsChart.js uses jQuery, which the site set includes via page.includeJSFooter.
     */
    #[Test]
    public function statisticsActionIncludesChartScriptsAfterJqueryAndChartLibraryBeforeChartScript(): void
    {
        $html = $this->renderStatisticsWithOperations();

        self::assertStringOccursBefore('jquery.min.js', 'Resources/Public/Js/OperationsChart.js', $html);
        self::assertStringOccursBefore('Resources/Public/Js/Chart.bundle.js', 'Resources/Public/Js/OperationsChart.js', $html);
    }

    #[Test]
    public function statisticsActionWithoutOperationsRendersNoDataMessage(): void
    {
        $this->importCSVDataSet(self::FIXTURES_PATH . 'StatisticsContentElement.csv');

        $html = $this->renderPage(self::STATISTICS_PAGE_UID);

        self::assertStringContainsString('No data available', $html);
        self::assertStringNotContainsString('operations-chart', $html);
    }

    #[Test]
    public function statisticsActionWithCategoryFromFlexFormOnlyCountsOperationsWithThatCategory(): void
    {
        $html = $this->renderStatisticsWithOperations('StatisticsContentElementWithCategoryFromFlexForm.csv');

        self::assertStringContainsString('<th class="text-left">2023</th><td class="text-left">1</td>', $html);
        self::assertStringContainsString('<th class="text-left">2022</th><td class="text-left">1</td>', $html);
        self::assertStringContainsString(
            '<td class="data-row-label" data-color="#ff0000">Fire</td><td class="data-row-data">1</td><td class="data-row-data">1</td>',
            $html
        );
        self::assertStringContainsString(
            '<td class="data-row-label" data-color="#00ff00">Technical assistance</td><td class="data-row-data">0</td><td class="data-row-data">0</td>',
            $html
        );
    }

    #[Test]
    public function statisticsActionWithCategoryFromFlexFormWithoutOperationsRendersNoDataMessage(): void
    {
        $html = $this->renderStatisticsWithOperations('StatisticsContentElementWithUnusedCategoryFromFlexForm.csv');

        self::assertStringContainsString('No data available', $html);
        self::assertStringNotContainsString('operations-chart', $html);
    }
}

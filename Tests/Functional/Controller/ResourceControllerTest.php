<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Controller;

use Kanow\Operations\Controller\ResourceController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(ResourceController::class)]
final class ResourceControllerTest extends FunctionalTestCase
{
    private const LIST_PAGE_UID = 1;

    private const SHOW_PAGE_UID = 4;

    protected array $testExtensionsToLoad = ['kanow/operations'];

    protected array $coreExtensionsToLoad = ['typo3/cms-fluid-styled-content'];

    protected array $pathsToLinkInTestInstance = [
        'typo3conf/ext/operations/Tests/Functional/Controller/Fixtures/Sites/' => 'typo3conf/sites',
    ];

    protected array $pathsToProvideInTestInstance = [
        'typo3conf/ext/operations/Resources/Public/Icons/tx_operations_resource.svg' => 'fileadmin/user_upload/resource.svg',
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
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Database/ResourceController/Resources.csv');
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
    public function listActionRendersVisibleResourcesFromRecordStoragePageSortedBySorting(): void
    {
        $html = $this->renderPage(self::LIST_PAGE_UID);

        $firstPosition = strpos($html, 'Hydraulic rescue tool<span class="short"> (HRT)</span>');
        $secondPosition = strpos($html, 'Thermal imaging camera<span class="short"> (TIC)</span>');
        self::assertIsInt($firstPosition);
        self::assertIsInt($secondPosition);
        self::assertLessThan($secondPosition, $firstPosition);
        self::assertStringNotContainsString('Hidden resource', $html);
        self::assertStringNotContainsString('Resource on other page', $html);
    }

    #[Test]
    public function listActionLinksResourcesWithoutLinkToShowAction(): void
    {
        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString(
            'tx_operations_pi1%5Baction%5D=show&amp;tx_operations_pi1%5Bcontroller%5D=Resource&amp;tx_operations_pi1%5Bresource%5D=1',
            $html
        );
    }

    #[Test]
    public function listActionLinksResourcesWithLinkToThatLink(): void
    {
        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString('<a href="https://example.com/hrt">', $html);
    }

    #[Test]
    public function listActionRendersFirstMediaOrDefaultImage(): void
    {
        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString('<img src="/fileadmin/user_upload/resource.svg"', $html);
        self::assertStringContainsString('Resources/Public/Icons/tx_operations_resource.svg', $html);
        self::assertStringContainsString('title="Default image (resources) if no image available."', $html);
    }

    #[Test]
    public function listActionRendersDescriptionWithoutMarkup(): void
    {
        $html = $this->renderPage(self::LIST_PAGE_UID);

        self::assertStringContainsString('<p>Finds people in smoke.</p>', $html);
    }

    #[Test]
    public function showActionRendersTheGivenResource(): void
    {
        $html = $this->renderPage(self::SHOW_PAGE_UID, ['tx_operations_pi1[resource]' => 1]);

        self::assertStringContainsString('<span class="number">TIC</span> - Thermal imaging camera</h1>', $html);
        self::assertStringContainsString('<h2>Description of resource</h2>', $html);
        self::assertStringContainsString('<p>Finds people in smoke.</p>', $html);
        self::assertStringContainsString('<img src="/fileadmin/user_upload/resource.svg"', $html);
        self::assertStringNotContainsString('Hydraulic rescue tool', $html);
    }

    #[Test]
    public function showActionForUnavailableResourceThrowsTargetNotFoundException(): void
    {
        $this->expectException(TargetNotFoundException::class);

        $this->renderPage(self::SHOW_PAGE_UID, ['tx_operations_pi1[resource]' => 3]);
    }
}

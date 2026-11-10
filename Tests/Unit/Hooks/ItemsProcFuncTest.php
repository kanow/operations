<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Hooks;

use Kanow\Operations\Hooks\ItemsProcFunc;
use Kanow\Operations\Utility\TemplateLayout;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Note: Resolving the page of a negative pid (or pid 0) uses BackendUtility::getRecord()
 * and needs a database, so it is not covered by these unit tests.
 */
#[CoversClass(ItemsProcFunc::class)]
final class ItemsProcFuncTest extends UnitTestCase
{
    private const DEFAULT_ITEM = ['label' => 'Default', 'value' => ''];

    protected bool $resetSingletonInstances = true;

    private TemplateLayout&Stub $templateLayout;

    protected function setUp(): void
    {
        parent::setUp();

        $this->templateLayout = self::createStub(TemplateLayout::class);
        GeneralUtility::setSingletonInstance(TemplateLayout::class, $this->templateLayout);

        $languageService = self::createStub(LanguageService::class);
        $languageService->method('sL')->willReturnCallback(
            static fn(string $input): string => 'translated: ' . $input
        );
        $GLOBALS['LANG'] = $languageService;
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['LANG']);

        parent::tearDown();
    }

    #[Test]
    public function userTemplateLayoutWithoutColPosKeepsItemsUntouched(): void
    {
        $this->templateLayout->method('getAvailableTemplateLayouts')->willReturn([['Layout A', 'layoutA']]);
        $config = [
            'flexParentDatabaseRow' => ['pid' => 1],
            'items' => [self::DEFAULT_ITEM],
        ];

        (new ItemsProcFunc())->user_templateLayout($config);

        self::assertSame([self::DEFAULT_ITEM], $config['items']);
    }

    #[Test]
    public function userTemplateLayoutWithoutParentRowKeepsItemsUntouched(): void
    {
        $this->templateLayout->method('getAvailableTemplateLayouts')->willReturn([['Layout A', 'layoutA']]);
        $config = ['items' => [self::DEFAULT_ITEM]];

        (new ItemsProcFunc())->user_templateLayout($config);

        self::assertSame(['items' => [self::DEFAULT_ITEM]], $config);
    }

    #[Test]
    public function userTemplateLayoutFetchesLayoutsForPidOfParentRow(): void
    {
        $templateLayout = $this->createMock(TemplateLayout::class);
        $templateLayout->expects($this->once())->method('getAvailableTemplateLayouts')->with(42)->willReturn([]);
        GeneralUtility::setSingletonInstance(TemplateLayout::class, $templateLayout);
        $config = [
            'flexParentDatabaseRow' => ['pid' => 42, 'colPos' => 0],
            'items' => [],
        ];

        (new ItemsProcFunc())->user_templateLayout($config);
    }

    #[Test]
    public function userTemplateLayoutAppendsTranslatedLayoutsToItems(): void
    {
        $this->templateLayout->method('getAvailableTemplateLayouts')->willReturn([
            ['Layout A', 'layoutA'],
            ['LLL:EXT:site/Resources/Private/Language/locallang.xlf:layoutB', 'layoutB'],
        ]);
        $config = [
            'flexParentDatabaseRow' => ['pid' => 1, 'colPos' => 0],
            'items' => [self::DEFAULT_ITEM],
        ];

        (new ItemsProcFunc())->user_templateLayout($config);

        $expected = [
            self::DEFAULT_ITEM,
            ['label' => 'translated: Layout A', 'value' => 'layoutA'],
            ['label' => 'translated: LLL:EXT:site/Resources/Private/Language/locallang.xlf:layoutB', 'value' => 'layoutB'],
        ];
        self::assertSame($expected, $config['items']);
    }

    #[Test]
    public function userTemplateLayoutAddsOptionGroupsAsItems(): void
    {
        $this->templateLayout->method('getAvailableTemplateLayouts')->willReturn([
            ['My group', '--div--'],
            ['Layout A', 'layoutA'],
        ]);
        $config = [
            'flexParentDatabaseRow' => ['pid' => 1, 'colPos' => 0],
            'items' => [],
        ];

        (new ItemsProcFunc())->user_templateLayout($config);

        $expected = [
            ['label' => 'translated: My group', 'value' => '--div--'],
            ['label' => 'translated: Layout A', 'value' => 'layoutA'],
        ];
        self::assertSame($expected, $config['items']);
    }

    /**
     * @return \Generator<string, array{0: int|string|list<int|string>, 1: list<string>}>
     */
    public static function colPosDataProvider(): \Generator
    {
        yield 'allowed colPos as int' => [2, ['layoutA', 'restricted']];
        yield 'allowed colPos as string' => ['2', ['layoutA', 'restricted']];
        yield 'allowed colPos as array (FormEngine)' => [[2], ['layoutA', 'restricted']];
        yield 'allowed colPos as array with string value (FormEngine)' => [['2'], ['layoutA', 'restricted']];
        yield 'other allowed colPos' => [5, ['layoutA', 'restricted']];
        yield 'not allowed colPos as int' => [0, ['layoutA']];
        yield 'not allowed colPos as array (FormEngine)' => [[0], ['layoutA']];
        yield 'not allowed colPos as array with string value (FormEngine)' => [['3'], ['layoutA']];
    }

    /**
     * @param int|string|list<int|string> $colPos
     * @param list<string> $expectedValues
     */
    #[Test]
    #[DataProvider('colPosDataProvider')]
    public function userTemplateLayoutRemovesLayoutsNotAllowedInColPos(int|string|array $colPos, array $expectedValues): void
    {
        $this->templateLayout->method('getAvailableTemplateLayouts')->willReturn([
            ['Layout A', 'layoutA'],
            ['Restricted layout', 'restricted'],
            [['allowedColPos' => '2, 5'], 'restricted.'],
        ]);
        $config = [
            'flexParentDatabaseRow' => ['pid' => 1, 'colPos' => $colPos],
            'items' => [],
        ];

        (new ItemsProcFunc())->user_templateLayout($config);

        self::assertSame($expectedValues, array_column($config['items'], 'value'));
    }

    #[Test]
    public function userTemplateLayoutAppliesRestrictionByLayoutIdentifierIndependentOfPosition(): void
    {
        // Layouts as delivered from TSconfig "1 = Layout 1, 1.allowedColPos = 2, 2 = Layout 2":
        // the array position (1) of "Layout 2" equals the restricted identifier "1".
        $this->templateLayout->method('getAvailableTemplateLayouts')->willReturn([
            ['Layout 1', '1'],
            ['Layout 2', '2'],
            [['allowedColPos' => '2'], '1.'],
        ]);
        $config = [
            'flexParentDatabaseRow' => ['pid' => 1, 'colPos' => 0],
            'items' => [],
        ];

        (new ItemsProcFunc())->user_templateLayout($config);

        self::assertSame([['label' => 'translated: Layout 2', 'value' => '2']], $config['items']);
    }

    #[Test]
    public function userTemplateLayoutIgnoresSubConfigurationWithoutAllowedColPos(): void
    {
        $this->templateLayout->method('getAvailableTemplateLayouts')->willReturn([
            ['Layout A', 'layoutA'],
            [['somethingElse' => '1'], 'layoutA.'],
        ]);
        $config = [
            'flexParentDatabaseRow' => ['pid' => 1, 'colPos' => 0],
            'items' => [],
        ];

        (new ItemsProcFunc())->user_templateLayout($config);

        self::assertSame([['label' => 'translated: Layout A', 'value' => 'layoutA']], $config['items']);
    }

    #[Test]
    public function userTemplateLayoutIgnoresAllowedColPosWithoutTrailingDotInIdentifier(): void
    {
        $this->templateLayout->method('getAvailableTemplateLayouts')->willReturn([
            ['Layout A', 'layoutA'],
            [['allowedColPos' => '2'], 'layoutA'],
        ]);
        $config = [
            'flexParentDatabaseRow' => ['pid' => 1, 'colPos' => 0],
            'items' => [],
        ];

        (new ItemsProcFunc())->user_templateLayout($config);

        self::assertSame([['label' => 'translated: Layout A', 'value' => 'layoutA']], $config['items']);
    }
}

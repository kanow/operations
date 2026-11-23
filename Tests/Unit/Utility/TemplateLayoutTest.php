<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Utility;

use Kanow\Operations\Tests\Unit\Utility\Fixtures\TestingTemplateLayout;
use Kanow\Operations\Utility\TemplateLayout;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(TemplateLayout::class)]
final class TemplateLayoutTest extends UnitTestCase
{
    private const GLOBAL_LAYOUTS = [
        ['Global layout 1', 'global1'],
        ['Global layout 2', 'global2'],
    ];

    protected function tearDown(): void
    {
        /** @var array<string, array<string, mixed>> $configuration */
        $configuration = $GLOBALS['TYPO3_CONF_VARS'];
        unset($configuration['EXT']['operations']);
        $GLOBALS['TYPO3_CONF_VARS'] = $configuration;

        parent::tearDown();
    }

    #[Test]
    public function isSingleton(): void
    {
        self::assertInstanceOf(SingletonInterface::class, new TemplateLayout());
    }

    #[Test]
    public function getAvailableTemplateLayoutsWithoutConfigurationReturnsEmptyArray(): void
    {
        $subject = new TestingTemplateLayout([]);

        self::assertSame([], $subject->getAvailableTemplateLayouts());
    }

    #[Test]
    public function getAvailableTemplateLayoutsWithoutPageUidReturnsGlobalLayouts(): void
    {
        $this->setGlobalTemplateLayouts(self::GLOBAL_LAYOUTS);
        $subject = new TestingTemplateLayout(['tsconfig1' => 'TSconfig layout']);

        self::assertSame(self::GLOBAL_LAYOUTS, $subject->getAvailableTemplateLayouts());
    }

    #[Test]
    public function getAvailableTemplateLayoutsWithPageUidZeroDoesNotReadTsConfig(): void
    {
        $subject = new TestingTemplateLayout(['tsconfig1' => 'TSconfig layout']);

        $subject->getAvailableTemplateLayouts(0);

        self::assertSame([], $subject->getRequestedPageUids());
    }

    #[Test]
    public function getAvailableTemplateLayoutsWithPageUidReadsTsConfigOfThatPage(): void
    {
        $subject = new TestingTemplateLayout([]);

        $subject->getAvailableTemplateLayouts(42);

        self::assertSame([42], $subject->getRequestedPageUids());
    }

    #[Test]
    public function getAvailableTemplateLayoutsWithPageUidAppendsTsConfigLayoutsToGlobalLayouts(): void
    {
        $this->setGlobalTemplateLayouts(self::GLOBAL_LAYOUTS);
        $subject = new TestingTemplateLayout(['tsconfig1' => 'TSconfig layout']);

        $expected = [
            ['Global layout 1', 'global1'],
            ['Global layout 2', 'global2'],
            ['TSconfig layout', 'tsconfig1'],
        ];
        self::assertSame($expected, $subject->getAvailableTemplateLayouts(42));
    }

    /**
     * @return \Generator<string, array{0: array<array-key, string|array<string, string>>, 1: list<array{0: string|array<string, string>, 1: string}>}>
     */
    public static function tsConfigLayoutsDataProvider(): \Generator
    {
        yield 'no layouts' => [
            [],
            [],
        ];
        yield 'layouts with string keys' => [
            ['layoutA' => 'Layout A', 'layoutB' => 'Layout B'],
            [['Layout A', 'layoutA'], ['Layout B', 'layoutB']],
        ];
        yield 'layouts with numeric keys' => [
            [1 => 'Layout 1', 99 => 'LLL:EXT:site/Resources/Private/Language/locallang.xlf:layout'],
            [['Layout 1', '1'], ['LLL:EXT:site/Resources/Private/Language/locallang.xlf:layout', '99']],
        ];
        yield 'option group' => [
            [10 => '--div--,My group', 11 => 'Layout in group'],
            [['My group', '--div--'], ['Layout in group', '11']],
        ];
        yield 'option group with whitespace around the title' => [
            [10 => '--div--,  My group  '],
            [['My group', '--div--']],
        ];
        yield 'option group with comma in title' => [
            [10 => '--div--,My group, the second'],
            [['My group, the second', '--div--']],
        ];
        yield 'layout with allowedColPos sub-configuration' => [
            [1 => 'Layout 1', '1.' => ['allowedColPos' => '0,2']],
            [['Layout 1', '1'], [['allowedColPos' => '0,2'], '1.']],
        ];
    }

    /**
     * @param array<array-key, string|array<string, string>> $tsConfigLayouts
     * @param list<array{0: string|array<string, string>, 1: string}> $expected
     */
    #[Test]
    #[DataProvider('tsConfigLayoutsDataProvider')]
    public function getAvailableTemplateLayoutsProcessesTsConfigLayouts(array $tsConfigLayouts, array $expected): void
    {
        $subject = new TestingTemplateLayout($tsConfigLayouts);

        self::assertSame($expected, $subject->getAvailableTemplateLayouts(1));
    }

    /**
     * @param list<array{0: string, 1: string}> $layouts
     */
    private function setGlobalTemplateLayouts(array $layouts): void
    {
        /** @var array<string, array<string, array<string, mixed>>> $configuration */
        $configuration = $GLOBALS['TYPO3_CONF_VARS'];
        $configuration['EXT']['operations']['templateLayouts'] = $layouts;
        $GLOBALS['TYPO3_CONF_VARS'] = $configuration;
    }
}

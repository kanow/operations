<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Utility;

use Kanow\Operations\Utility\TemplateLayout;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class TemplateLayoutTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function availableTemplateLayoutsReturnsLayouts(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['operations']['templateLayouts'] = [
            0 => [
                0 => 'Layout-1',
                1 => 'layout1',
            ],
            1 => [
                0 => 'Layout-2',
                1 => 'layout2',
            ],
        ];

        $templateLayoutUtility = $this->getAccessibleMock(TemplateLayout::class, ['getTemplateLayoutsFromTsConfig']);
        $templateLayoutUtility->expects(self::once())->method('getTemplateLayoutsFromTsConfig')->willReturn([]);
        $templateLayouts = $templateLayoutUtility->_call('getAvailableTemplateLayouts', 1);
        self::assertSame($GLOBALS['TYPO3_CONF_VARS']['EXT']['operations']['templateLayouts'], $templateLayouts);
    }

    /*
     * @test
     */
    public function templateLayoutsFoundInPageTsConfig(): void
    {
        $tsConfigArray = [
            'layout1' => 'Layout-1',
            'layout2' => 'Layout-2',
        ];
        $result = [
            0 => [
                0 => 'Layout-1',
                1 => 'layout1',
            ],
            1 => [
                0 => 'Layout-2',
                1 => 'layout2',
            ],
        ];

        // clear TYPO3_CONF_VARS
        unset($GLOBALS['TYPO3_CONF_VARS']['EXT']['operations']['templateLayouts']);

        $templateLayoutUtility = $this->getAccessibleMock(TemplateLayout::class, ['getTemplateLayoutsFromTsConfig']);
        $templateLayoutUtility->expects(self::once())->method('getTemplateLayoutsFromTsConfig')->willReturn($tsConfigArray);
        $templateLayouts = $templateLayoutUtility->_call('getAvailableTemplateLayouts', 1);
        self::assertSame($result, $templateLayouts);
    }
}

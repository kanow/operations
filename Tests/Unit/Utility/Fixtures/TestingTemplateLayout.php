<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Unit\Utility\Fixtures;

use Kanow\Operations\Utility\TemplateLayout;

/**
 * Testing subclass of TemplateLayout that returns predefined TSconfig layouts
 * instead of reading the page TSconfig via BackendUtility (which needs a database).
 */
final class TestingTemplateLayout extends TemplateLayout
{
    /**
     * @var list<int>
     */
    private array $requestedPageUids = [];

    /**
     * @param array<array-key, string|array<string, string>> $tsConfigLayouts
     */
    public function __construct(private readonly array $tsConfigLayouts) {}

    /**
     * @return array<array-key, string|array<string, string>>
     */
    protected function getTemplateLayoutsFromTsConfig(int $pageUid): array
    {
        $this->requestedPageUids[] = $pageUid;

        return $this->tsConfigLayouts;
    }

    /**
     * @return list<int>
     */
    public function getRequestedPageUids(): array
    {
        return $this->requestedPageUids;
    }
}

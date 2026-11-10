<?php

namespace Kanow\Operations\Utility;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * TemplateLayout utility class
 */
class TemplateLayout implements SingletonInterface
{
    /**
     * Get available template layouts for a certain page
     */
    public function getAvailableTemplateLayouts(int $pageUid = 0): array
    {
        $templateLayouts = $GLOBALS['TYPO3_CONF_VARS']['EXT']['operations']['templateLayouts'] ?? [];
        if ($pageUid > 0) {
            $tsConfigLayouts = $this->getTemplateLayoutsFromTsConfig($pageUid);
            $templateLayouts = array_merge($templateLayouts, $this->processTsConfigLayouts($tsConfigLayouts));
        }
        return $templateLayouts;
    }

    /**
     * Process the template layouts from TsConfig
     */
    protected function processTsConfigLayouts(array $tsConfigLayouts): array
    {
        $processedLayouts = [];
        foreach ($tsConfigLayouts as $templateKey => $title) {
            $processedLayouts[] = $this->processSingleTemplateLayout($templateKey, $title);
        }
        return $processedLayouts;
    }

    /**
     * Process a single template layout
     *
     * @param string|array<mixed> $title title or, for sub-configuration like "1.allowedColPos", the configuration array
     * @return array<int, mixed>
     */
    protected function processSingleTemplateLayout(string $templateKey, string|array $title): array
    {
        if (is_string($title) && str_starts_with($title, '--div--')) {
            [$templateKey, $title] = $this->extractTitleFromOptionGroup($title);
        }

        return [$title, $templateKey];
    }

    /**
     * Extract title from option group
     *
     * @return array<int, string>
     */
    protected function extractTitleFromOptionGroup(string $title): array
    {
        $optionGroupParts = GeneralUtility::trimExplode(',', $title, true, 2);
        return [$optionGroupParts[0], $optionGroupParts[1]];
    }

    /**
     * Get template layouts defined in TsConfig
     */
    protected function getTemplateLayoutsFromTsConfig(int $pageUid): array
    {
        $pagesTsConfig = BackendUtility::getPagesTSconfig($pageUid);
        return $pagesTsConfig['tx_operations.']['templateLayouts.'] ?? [];
    }
}

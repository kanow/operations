<?php

namespace Kanow\Operations\Hooks;

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
use Kanow\Operations\Utility\TemplateLayout;
use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ItemsProcFunc
{
    /** @var TemplateLayout $templateLayoutsUtility */
    protected $templateLayoutsUtility;

    public function __construct()
    {
        $this->templateLayoutsUtility = GeneralUtility::makeInstance(TemplateLayout::class);
    }

    /**
     * Itemsproc function to extend the selection of templateLayouts in the plugin
     *
     * @param array &$config configuration array
     */
    public function user_templateLayout(array &$config): void
    {
        $currentColPos = $config['flexParentDatabaseRow']['colPos'] ?? null;
        if ($currentColPos === null) {
            return;
        }
        // FormEngine provides processed select values (e.g. colPos) as array
        if (is_array($currentColPos)) {
            $currentColPos = reset($currentColPos);
        }
        $pageId = $this->getPageId((int)($config['flexParentDatabaseRow']['pid'] ?? 0));

        if ($pageId > 0) {
            $templateLayouts = $this->templateLayoutsUtility->getAvailableTemplateLayouts($pageId);

            $templateLayouts = $this->reduceTemplateLayouts($templateLayouts, (int)$currentColPos);
            foreach ($templateLayouts as $layout) {
                $config['items'][] = [
                    'label' => $this->getLanguageService()->sL($layout[0]),
                    'value' => $layout[1],
                ];
            }
        }
    }

    /**
     * Reduce the template layouts by the ones that are not allowed in given colPos
     *
     * @param array $templateLayouts
     * @param int $currentColPos
     * @return array
     */
    protected function reduceTemplateLayouts(array $templateLayouts, int $currentColPos): array
    {
        $restrictions = [];
        $allLayouts = [];
        foreach ($templateLayouts as $key => $layout) {
            if (is_array($layout[0])) {
                if (isset($layout[0]['allowedColPos']) && str_ends_with((string)$layout[1], '.')) {
                    $layoutKey = substr((string) $layout[1], 0, -1);
                    $restrictions[$layoutKey] = GeneralUtility::intExplode(',', $layout[0]['allowedColPos'], true);
                }
            } else {
                $allLayouts[$key] = $layout;
            }
        }
        // Restrictions are bound to the layout identifier, not to the position in the list of layouts.
        // Layouts without restriction are allowed in every colPos.
        foreach ($allLayouts as $key => $layout) {
            $allowedColPosList = $restrictions[(string)$layout[1]] ?? [$currentColPos];
            if (!in_array($currentColPos, $allowedColPosList, true)) {
                unset($allLayouts[$key]);
            }
        }

        return $allLayouts;
    }

    /**
     * Returns LanguageService
     *
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * Returns the given pid.
     * If the pid is negative, it will return the pid of the tt_content record.
     *
     * @param int $pid
     * @return int
     */
    protected function getPageId(int $pid): int
    {
        if ($pid > 0) {
            return $pid;
        }

        $row = BackendUtilityCore::getRecord('tt_content', abs($pid), 'uid,pid');
        return (int)($row['pid'] ?? 0);
    }
}

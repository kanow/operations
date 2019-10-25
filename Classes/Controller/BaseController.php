<?php

namespace Kanow\Operations\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Karsten Nowak <captnnowi@gmx.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package operations
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class BaseController extends ActionController
{

    /**
     * Constructor
     */
    protected function initializeAction()
    {
        $this->overrideFlexformSettings();
        $this->storagePidFallback();
    }

    /**
     * Initializes the view before invoking an action method.
     * Override this method to solve assign variables common for all actions
     * or prepare the view in another way before the action is called.
     *
     * @param ViewInterface $view The view to be initialized
     */
    protected function initializeView(ViewInterface $view)
    {
        $view->assign('contentObjectData', $this->configurationManager->getContentObject()->data);
        parent::initializeView($view);
    }

    /**
     * overrides flexform settings with original typoscript values when
     * flexform value is empty and settings key is defined in
     * 'settings.overrideFlexformSettingsIfEmpty'
     *
     * @return void
     */
    public function overrideFlexformSettings()
    {
        $originalSettings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
        );
        $typoScriptSettings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'operations',
            'operations_list'
        );
        if (isset($typoScriptSettings['settings']['overrideFlexformSettingsIfEmpty'])) {
			$overrideIfEmpty = GeneralUtility::trimExplode(',', $typoScriptSettings['settings']['overrideFlexformSettingsIfEmpty'], TRUE);
            foreach ($overrideIfEmpty as $settingToOverride) {
                // if flexform setting is empty and value is available in TS
                if ((!isset($originalSettings[$settingToOverride]) || empty($originalSettings[$settingToOverride]))
                    && isset($typoScriptSettings['settings'][$settingToOverride])) {
                    $originalSettings[$settingToOverride] = $typoScriptSettings['settings'][$settingToOverride];
                }
            }
            $this->settings = $originalSettings;
        }
    }


    /**
     * StoragePid fallback: TypoScript settings will be overridden by plugin date.
     * No flexform settings, field pages of tt_content will be used.
     *
     */
    protected function storagePidFallback()
    {
        $configuration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'operations',
            'operations_list'
        );

        // Storage PID in plugin data (tt_content->pages) overrides storagePid from TypoScript
        if ($configuration['persistence']['storagePid']) {
            $pid['persistence']['storagePid'] = $configuration['persistence']['storagePid'];
            $this->configurationManager->setConfiguration(array_merge($configuration, $pid));
        }
        // Use current page as storagePid if neither set in TypoScript nor plugin data
        elseif (!$configuration['persistence']['storagePid']) {
            // Use current PID as storage PID
            $pid['persistence']['storagePid'] = $GLOBALS["TSFE"]->id;
            $this->configurationManager->setConfiguration(array_merge($configuration, $pid));
        }
    }

}

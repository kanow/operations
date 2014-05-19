<?php
namespace KN\Operations\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Karsten Nowak <captnnowi@gmx.de>
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
class ResourcesController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * resourcesRepository
	 *
	 * @var \KN\Operations\Domain\Repository\ResourcesRepository
	 * @inject
	 */
	protected $resourcesRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$resourcess = $this->resourcesRepository->findAll();
		$this->view->assign('resources', $resourcess);
	}

	/**
	 * action show
	 *
	 * @param \KN\Operations\Domain\Model\Resources $resources
	 * @return void
	 */
	public function showAction(\KN\Operations\Domain\Model\Resources $resources) {
		$this->view->assign('resource', $resources);
	}
	
	
	/**
	 * Constructor
	 */
	protected function initializeAction(){
		$this->overrideFlexformSettings();
	}
	
	/**
	 * overrides flexform settings with original typoscript values when 
	 * flexform value is empty and settings key is defined in 
	 * 'settings.overrideFlexformSettingsIfEmpty'
	 * 
	 * @return void
	 */
	public function overrideFlexformSettings() {
		$originalSettings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$typoScriptSettings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'operations', 'operations_list');
		
		if(isset($typoScriptSettings['settings']['overrideFlexformSettingsIfEmpty'])) {
			$overrideIfEmpty = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $typoScriptSettings['settings']['overrideFlexformSettingsIfEmpty'], TRUE);
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

}
?>
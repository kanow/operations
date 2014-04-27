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
use KN\Operations\Domain\Model\Year;

class OperationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * configuration manager
	 * 
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * operationRepository
	 *
	 * @var \KN\Operations\Domain\Repository\OperationRepository
	 * @inject
	 */
	protected $operationRepository;
	
	/**
	 * typeRepository
	 *
	 * @var \KN\Operations\Domain\Repository\TypeRepository
	 * @inject
	 */
	protected $typeRepository;

	/**
	 * action list
	 *
	 * @param \KN\Operations\Domain\Model\OperationDemand $demand
	 * @return void
	 */
	public function listAction(\KN\Operations\Domain\Model\OperationDemand $demand = NULL) {
		$demand = $this->updateDemandObjectFromSettings($demand, $this->settings);
		$operations = $this->operationRepository->findDemanded($demand, $this->settings);
		$types = $this->typeRepository->findAll();
		$years = $this->generateYears();
		
		$this->view->assign('types', $types);
		$this->view->assign('begin',$years);
		$this->view->assign('operations', $operations);
	}
	
	/**
	 * action search
	 *
	 * @dontverifyrequesthash
	 * @param \KN\Operations\Domain\Model\OperationDemand $demand
	 * @return void
	 */
	public function searchAction(\KN\Operations\Domain\Model\OperationDemand $demand = NULL) {
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($demand);
		$demand = $this->updateDemandObjectFromSettings($demand, $this->settings);
		$demanded = $this->operationRepository->findDemanded($demand, $this->settings);
		
		$years = $this->generateYears();
		$types = $this->typeRepository->findAll();

		$this->view->assign('types', $types);
		$this->view->assign('begin',$years);
		$this->view->assign('demanded', $demanded);
		$this->view->assign('demand', $demand);
	}
	
	/**
	  * Initialize method for special action
	  */
	 public function initializeSearchAction() {
			if ($this->arguments->hasArgument('demand')) {
				$mvcPropertyMappingConfiguration = \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationBuilder::build('TYPO3\\CMS\\Extbase\\Mvc\\Controller\\MvcPropertyMappingConfiguration');
						$this->arguments->getArgument('demand')->injectPropertyMappingConfiguration($mvcPropertyMappingConfiguration);
						$propertyMappingConfiguration = $this->arguments->getArgument('demand')->getPropertyMappingConfiguration();
						$propertyMappingConfiguration->forProperty('*')->allowAllProperties();
						$propertyMappingConfiguration->forProperty('*')->allowCreationForSubProperty('*');
						$propertyMappingConfiguration->forProperty('*')->forProperty('*')->allowAllProperties();
				}
	 }
	
	/**
	 * action show
	 *
	 * @param \KN\Operations\Domain\Model\Operation $operation
	 * @return void
	 */
	public function showAction(\KN\Operations\Domain\Model\Operation $operation) {
		$this->view->assign('operation', $operation);
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
	
	/**
	 * Update demand with current settings, if not exists it creates one
	 *
	 * @param KN\Operation\Domain\Model\OperationDemand
	 * @param array
	 * @return void
	 */
	protected function updateDemandObjectFromSettings($demand , $settings) {
		if(is_null($demand)){
			$demand = $this->objectManager->get('KN\Operations\Domain\Model\OperationDemand');
		}
		return $demand;
	}
	
	protected function generateYears(){
		$now = (int)date("Y");
		$date = $now;
		$i = 0;
		while($i<$this->settings['lastYears']){
			$year = new Year();
			$year->setYear($date);
			$years[] = $year;
			$i = $i+1;
			$date = $now - $i;
		}	
		return $years;
	}
	
}
?>
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

class OperationController extends \KN\Operations\Controller\BaseController {

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
				if(function_exists('injectPropertyMappingConfiguration')) {
					$mvcPropertyMappingConfiguration = \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationBuilder::build('TYPO3\\CMS\\Extbase\\Mvc\\Controller\\MvcPropertyMappingConfiguration');
					$this->arguments->getArgument('demand')->injectPropertyMappingConfiguration($mvcPropertyMappingConfiguration);
					$propertyMappingConfiguration = $this->arguments->getArgument('demand')->getPropertyMappingConfiguration();
					$propertyMappingConfiguration->forProperty('*')->allowAllProperties();
					$propertyMappingConfiguration->forProperty('*')->allowCreationForSubProperty('*');
					$propertyMappingConfiguration->forProperty('*')->forProperty('*')->allowAllProperties();
				} else {
					$propertyMappingConfiguration = $this->arguments->getArgument('demand')->getPropertyMappingConfiguration();
					$propertyMappingConfiguration->allowAllProperties();
					$propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, TRUE);
				}
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
		$currentTypo3Version = \KN\Operations\Utility\Div::getPartOfTypo3Version();
		$statement = "SELECT FROM_UNIXTIME(begin, '%Y') AS year FROM tx_operations_domain_model_operation WHERE hidden = 0 AND deleted = 0 GROUP BY year ORDER BY year DESC LIMIT 0,".$this->settings['lastYears'];

		$query = $this->operationRepository->createQuery();

		if ($currentTypo3Version < 7) {
			$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
			$result = $query->statement($statement)->execute();
		} else {
			$result = $query->statement($statement)->execute($returnRawQueryResult = true);
		}

		foreach ($result as $year) {
	      $years[$year['year']] = $year['year'];
	  }
		return $years;
	}

}
?>

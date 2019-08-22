<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */

namespace Kanow\Operations\Controller;

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

use Kanow\Operations\Domain\Model\Operation;
use Kanow\Operations\Domain\Model\OperationDemand;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfiguration;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class OperationController extends BaseController
{

	/**
	 * configuration manager
	 *
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $configurationManager;

	/**
	 * operationRepository
	 *
	 * @var \Kanow\Operations\Domain\Repository\OperationRepository
     */
	protected $operationRepository;

	/**
	 * typeRepository
	 *
	 * @var \Kanow\Operations\Domain\Repository\TypeRepository
	 */
	protected $typeRepository;

    /**
     * Inject a operation repository to enable DI
     *
     * @param \Kanow\Operations\Domain\Repository\OperationRepository $operationRepository
     */
    public function injectOperationRepository(\Kanow\Operations\Domain\Repository\OperationRepository $operationRepository)
    {
        $this->operationRepository = $operationRepository;
    }

    /**
     * Inject a type repository to enable DI
     *
     * @param \Kanow\Operations\Domain\Repository\TypeRepository $typeRepository
     */
    public function injectTypeRepository(\Kanow\Operations\Domain\Repository\TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

	/**
	 * action list
	 *
	 * @param OperationDemand $demand
	 * @return void
     * @throws InvalidQueryException
	 */
	public function listAction(OperationDemand $demand = NULL) {
		$demand = $this->updateDemandObjectFromSettings($demand);
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
	 * @param OperationDemand $demand
	 * @return void
     * @throws InvalidQueryException
	 */
	public function searchAction(OperationDemand $demand = NULL) {
		$demand = $this->updateDemandObjectFromSettings($demand);
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
     * @throws NoSuchArgumentException
	 */
	 public function initializeSearchAction() {
			if ($this->arguments->hasArgument('demand')) {
                $propertyMappingConfiguration = $this->arguments->getArgument('demand')->getPropertyMappingConfiguration();
                $propertyMappingConfiguration->allowAllProperties();
                $propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter', PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, TRUE);
			}
	 }

	/**
	 * action show
	 *
	 * @param Operation $operation
	 * @return void
	 */
	public function showAction(Operation $operation) {
		$this->view->assign('operation', $operation);
	}

    /**
     * action statistics
     *
     * @param OperationDemand $demand
     * @return void
     */
    public function statisticsAction(OperationDemand $demand = NULL) {
        $demand = $this->updateDemandObjectFromSettings($demand);
        $years = $this->generateYears();
        $types = $this->typeRepository->findAll()->toArray();

        $operationsGroupedByYearAndType = $this->operationRepository->countGroupedByYearAndType($years,$types);

        $this->view->assignMultiple(
            array(
                'operationsGroupedByYearAndType' => $operationsGroupedByYearAndType,
                'count' => $this->operationRepository->countDemanded($demand),
                'years' => $years
            )
        );
    }

    /**
     * Update demand with current settings, if not exists it creates one
     *
     * @param OperationDemand
     * @return OperationDemand
     */
	protected function updateDemandObjectFromSettings($demand) {
		if(is_null($demand)){
			$demand = $this->objectManager->get('Kanow\Operations\Domain\Model\OperationDemand');
		}
		return $demand;
	}

    protected function generateYears(){
        $years = [];
        $lastYears = $this->settings['lastYears'];
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_operations_domain_model_operation');
        $rows = $queryBuilder
            ->add('select','FROM_UNIXTIME(begin, \'%Y\') AS year',true)
            ->from('tx_operations_domain_model_operation')
            ->groupBy('year')
            ->orderBy('year','DESC')
            ->setMaxResults($lastYears)
            ->execute()
            ->fetchAll();
        foreach ($rows as $year) {
            $years[$year['year']] = $year['year'];
        }
        return $years;
    }

}

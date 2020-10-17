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
use Kanow\Operations\Domain\Repository\OperationRepository;
use Kanow\Operations\Service\CategoryService;
use Kanow\Operations\Domain\Repository\TypeRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;

class OperationController extends BaseController
{

    /**
     * @var ConfigurationManagerInterface
     */
    protected $configurationManager;

    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

	/**
	 * operationRepository
	 *
	 * @var OperationRepository
     */
	protected $operationRepository;

    /**
     * Inject operation repository to enable DI
     */
    public function injectOperationRepository(OperationRepository $operationRepository): void
    {
        $this->operationRepository = $operationRepository;
    }

    /**
     * typeRepository
     *
     * @var TypeRepository
     */
    protected $typeRepository;

    /**
     * Inject type repository to enable DI
     */
    public function injectTypeRepository(TypeRepository $typeRepository): void
    {
        $this->typeRepository = $typeRepository;
    }

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function injectCategoryRepository(CategoryRepository $categoryRepository): void
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @var CategoryService
     */
    protected $categoryService;

    public function injectCategoryService(CategoryService $categoryService): void
    {
        $this->categoryService = $categoryService;
    }

    /**
     * action list
     *
     * @param OperationDemand $demand
     * @param int $currentPage
     * @return void
     * @throws InvalidQueryException
     * @throws NoSuchArgumentException
     */
	public function listAction(OperationDemand $demand = NULL, int $currentPage = 1) {
		$demand = $this->updateDemandObjectFromSettings($demand);
        /** @var OperationDemand $demand */
        $operations = $this->operationRepository->findDemanded($demand, $this->settings);
        $types = $this->typeRepository->findAll();
		$years = $this->generateYears();

        $currentPage = $this->request->hasArgument('currentPage') ? $this->request->getArgument('currentPage') : $currentPage;
        $paginator = new QueryResultPaginator($operations, $currentPage, $this->settings['itemsPerPage']);
        $simplePagination = new SimplePagination($paginator);
        $pagination = $this->buildSimplePagination($simplePagination, $paginator);

        $this->view->assignMultiple([
            'types' =>  $types,
            'begin' => $years,
            'operations' =>  $operations,
            'categories' =>  $this->getOperationCategories(),
            'pagination' => $pagination,
            'paginator' => $paginator
        ]);
	}

    /**
     * action search
     *
     * @param OperationDemand $demand
     * @param int $currentPage
     * @return void
     * @throws InvalidQueryException
     * @throws NoSuchArgumentException
     */
	public function searchAction(OperationDemand $demand = NULL, int $currentPage = 1) {
		$demand = $this->updateDemandObjectFromSettings($demand);
        /** @var OperationDemand $demand */
        $demanded = $this->operationRepository->findDemanded($demand, $this->settings);

		$currentPage = $this->request->hasArgument('currentPage') ? $this->request->getArgument('currentPage') : $currentPage;
        $paginator = new QueryResultPaginator($demanded, $currentPage, $this->settings['itemsPerPage']);
        $simplePagination = new SimplePagination($paginator);
        $pagination = $this->buildSimplePagination($simplePagination, $paginator);

		$years = $this->generateYears();
		$types = $this->typeRepository->findAll();

        $this->view->assignMultiple([
            'types' => $types,
            'begin' => $years,
            'demanded' => $demanded,
            'demand' => $demand,
            'categories' => $this->getOperationCategories(),
            'pagination' => $pagination,
            'paginator' => $paginator
        ]);
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
     * action for statistics
     *
     * @param OperationDemand $demand
     * @return void
     * @throws InvalidQueryException
     */
    public function statisticsAction(OperationDemand $demand = NULL) {
        $demand = $this->updateDemandObjectFromSettings($demand);

        /** @var OperationDemand $demand */
        $operations = $this->operationRepository->findDemandedForStatistics($demand, $this->settings);
        $operationUids = $this->buildUidList($operations);

        $years = $this->generateYears($operationUids);
        $types = $this->typeRepository->findAll()->toArray();

        $operationsGroupedByYearAndType = $this->operationRepository->countGroupedByYearAndType($years,$types, $operationUids);
        $operationsGroupedByYear = $this->operationRepository->countGroupedByYear($years, $operationUids);

        $this->view->assignMultiple(
            array(
                'operationsGroupedByYearAndType' => $operationsGroupedByYearAndType,
                'operationsGroupedByYear' => $operationsGroupedByYear,
                'count' => $this->operationRepository->countDemandedForStatistics($demand, $this->settings),
                'years' => $years
            )
        );
    }

    /**
     * Update demand with current settings, if not exists it creates one
     *
     * @param OperationDemand $demand
     * @return object
     */
	protected function updateDemandObjectFromSettings($demand) {
		if(is_null($demand)){
            $demand = GeneralUtility::makeInstance('Kanow\Operations\Domain\Model\OperationDemand');
		}
		return $demand;
	}

    /**
     * Get the years. Only from defined operation uid list.
     *
     * @param string $operationUids
     * @return array
     */
    protected function generateYears($operationUids = ''){
        $years = [];
        $lastYears = $this->settings['lastYears'];
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_operations_domain_model_operation');
        $rows = $queryBuilder
            ->add('select','FROM_UNIXTIME(begin, \'%Y\') AS year',true)
            ->from('tx_operations_domain_model_operation');
        if($operationUids != '') {
            $rows = $rows->andWhere('uid IN (' . $operationUids . ')');
        }
        $rows = $rows->groupBy('year')
            ->orderBy('year','DESC')
            ->setMaxResults($lastYears)
            ->execute()
            ->fetchAll();
        foreach ($rows as $year) {
            $years[$year['year']] = $year['year'];
        }
        return $years;
    }

    /**
     * Get operation categories
     *
     * @return ObjectStorage $categories
     */
    protected function getOperationCategories() {
        $operationsRootCategory = $this->categoryRepository->findByUid($this->settings['rootCategory']);
        if($operationsRootCategory != 0) {
            /** @var Category $operationsRootCategory */
            $categories = $this->categoryService->findAllDescendants($operationsRootCategory);
        } else {
            $categories = $this->categoryRepository->findAll();
        }
        return $categories;
    }

    /**
     * collect all uids from a result
     *
     * @param array $result
     * @return string
     */
    protected function buildUidList(array $result)
    {
        $uidList = [];
        foreach ($result as $item) {
            $uidList[] = $item['uid'];
        }
        $uidList = implode(',',$uidList);
        return $uidList;
    }

    /**
     * build simple pagination
     *
     * @param SimplePagination $simplePagination
     * @param QueryResultPaginator $paginator
     * @return array
     */
    protected function buildSimplePagination(SimplePagination $simplePagination, QueryResultPaginator $paginator)
    {
        $firstPage = $simplePagination->getFirstPageNumber();
        $lastPage = $simplePagination->getLastPageNumber();
        return [
            'lastPageNumber' => $lastPage,
            'firstPageNumber' => $firstPage,
            'nextPageNumber' => $simplePagination->getNextPageNumber(),
            'previousPageNumber' => $simplePagination->getPreviousPageNumber(),
            'startRecordNumber' => $simplePagination->getStartRecordNumber(),
            'endRecordNumber' => $simplePagination->getEndRecordNumber(),
            'currentPageNumber' => $paginator->getCurrentPageNumber(),
            'pages' => range($firstPage, $lastPage)
        ];
    }

}

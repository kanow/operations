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
use Psr\Log\LoggerAwareInterface;
use TYPO3\CMS\Core\SingletonInterface;
use Psr\Http\Message\ResponseInterface;
use GeorgRinger\NumberedPagination\NumberedPagination;
use Kanow\Operations\Domain\Model\Operation;
use Kanow\Operations\Domain\Model\OperationDemand;
use Kanow\Operations\Domain\Repository\OperationRepository;
use Kanow\Operations\Service\CategoryService;
use Kanow\Operations\Domain\Repository\TypeRepository;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use Kanow\Operations\Domain\Model\Category;
use Kanow\Operations\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
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

	/**
	 * operationRepository
	 *
	 * @var OperationRepository
     */
	protected $operationRepository;

    /**
     * typeRepository
     *
     * @var TypeRepository
     */
    protected $typeRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var CategoryService
     */
    protected $categoryService;


    /**
     * @param OperationRepository $operationRepository
     * @param CategoryRepository $categoryRepository
     * @param CategoryService $categoryService
     * @param TypeRepository $typeRepository
     * @param ConfigurationManagerInterface $configurationManager
     */
    public function __construct(
        OperationRepository $operationRepository,
        CategoryRepository $categoryRepository,
        CategoryService $categoryService,
        TypeRepository $typeRepository,
        ConfigurationManagerInterface $configurationManager
    )
    {
        $this->operationRepository = $operationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
        $this->typeRepository = $typeRepository;
        $this->configurationManager = $configurationManager;
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
	public function listAction(OperationDemand $demand = NULL, int $currentPage = 1): ResponseInterface {

        if ($this->request->hasArgument('demand')) {
            $forwardResponse = new ForwardResponse('search');
            return $forwardResponse->withArguments($this->request->getArguments());
        }

		$demand = $this->updateDemandObjectFromSettings($demand);
        /** @var OperationDemand $demand */
        $operations = $this->operationRepository->findDemanded($demand, $this->settings);
        $types = $this->typeRepository->findAll();
		$years = $this->generateYears();

        if ($this->settings['hidePagination'] != 1) {
            $currentPage = $this->request->hasArgument('currentPage') ? $this->request->getArgument('currentPage') : $currentPage;
            $paginationConfiguration = $this->settings['paginate'] ?? [];
            $itemsPerPage = (int)(($paginationConfiguration['itemsPerPage'] ?? '') ?: 10);
            $maximumNumberOfLinks = (int)($paginationConfiguration['maximumLinks'] ?? 0);
            /* @todo use new core pagination in TYPO3 12 by default, if this is available.
             only use SimplePagination as fallback in TYPO3 11 */
            $paginationClass = $paginationConfiguration['class'] ?? SimplePagination::class;

            $paginator = new QueryResultPaginator($operations, $currentPage, $itemsPerPage);
            $pagination = $this->getPagination($paginationClass, $maximumNumberOfLinks, $paginator);
        }

        $this->view->assignMultiple([
            'types' =>  $types,
            'begin' => $years,
            'operations' =>  $operations,
            'categories' =>  $this->getOperationCategories(),
            'pagination' => $pagination,
            'paginator' => $paginator
        ]);
        return $this->htmlResponse();
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
	public function searchAction(OperationDemand $demand = NULL, int $currentPage = 1): ResponseInterface {
		$demand = $this->updateDemandObjectFromSettings($demand);
        /** @var OperationDemand $demand */
        $demanded = $this->operationRepository->findDemanded($demand, $this->settings);

        if ($this->settings['hidePagination'] != 1) {
            $currentPage = $this->request->hasArgument('currentPage') ? $this->request->getArgument('currentPage') : $currentPage;
            $paginationConfiguration = $this->settings['paginate'] ?? [];
            $itemsPerPage = (int)(($paginationConfiguration['itemsPerPage'] ?? '') ?: 10);
            $maximumNumberOfLinks = (int)($paginationConfiguration['maximumLinks'] ?? 0);
            /* @todo use new core pagination in TYPO3 12 by default, if this is available.
            only use SimplePagination as fallback in TYPO3 11 */
            $paginationClass = $paginationConfiguration['class'] ?? SimplePagination::class;

            $paginator = new QueryResultPaginator($demanded, $currentPage, $itemsPerPage);
            $pagination = $this->getPagination($paginationClass, $maximumNumberOfLinks, $paginator);
        }

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
        return $this->htmlResponse();
	}

	/**
	 * Initialize method for special action
     * @throws NoSuchArgumentException
	 */
	 public function initializeSearchAction() {
			if ($this->arguments->hasArgument('demand')) {
                $propertyMappingConfiguration = $this->arguments->getArgument('demand')->getPropertyMappingConfiguration();
                $propertyMappingConfiguration->allowAllProperties();
                $propertyMappingConfiguration->setTypeConverterOption(PersistentObjectConverter::class, PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, TRUE);
			}
	 }

	/**
	 * action show
	 *
	 * @param Operation $operation
	 * @return void
	 */
	public function showAction(Operation $operation): ResponseInterface {
		$this->view->assign('operation', $operation);
  return $this->htmlResponse();
	}

    /**
     * action for statistics
     *
     * @param OperationDemand $demand
     * @return void
     * @throws InvalidQueryException
     */
    public function statisticsAction(OperationDemand $demand = NULL): ResponseInterface {
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
        return $this->htmlResponse();
    }

    /**
     * Update demand with current settings, if not exists it creates one
     *
     * @param OperationDemand $demand
     * @return object
     */
	protected function updateDemandObjectFromSettings($demand) {
		if(is_null($demand)){
            $demand = GeneralUtility::makeInstance(OperationDemand::class);
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
            ->executeQuery()
            ->fetchAllAssociative();
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
        $site = $this->getRequest()->getAttribute('site');
        $configuration = $site->getConfiguration();
        $operationsRootCategory = $this->categoryRepository->findByUid((int)$configuration['settings']['operations']['rootCategory']);
        if($operationsRootCategory != null) {
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
     * @return ServerRequestInterface
     */
    protected function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    /**
     * @param $paginationClass
     * @param int $maximumNumberOfLinks
     * @param $paginator
     * @return NumberedPagination|mixed|LoggerAwareInterface|string|SimplePagination|SingletonInterface
     */
    protected function getPagination($paginationClass, int $maximumNumberOfLinks, $paginator)
    {
        if (class_exists(NumberedPagination::class) && $paginationClass === NumberedPagination::class && $maximumNumberOfLinks) {
            $pagination = GeneralUtility::makeInstance(NumberedPagination::class, $paginator, $maximumNumberOfLinks);
        } elseif (class_exists($paginationClass)) {
            $pagination = GeneralUtility::makeInstance($paginationClass, $paginator);
        } else {
            $pagination = GeneralUtility::makeInstance(SimplePagination::class, $paginator);
        }
        return $pagination;
    }
}

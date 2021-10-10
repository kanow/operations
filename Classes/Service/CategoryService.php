<?php
namespace Kanow\Operations\Service;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use Kanow\Operations\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 "Karsten Nowak <captnnowi@gmx.de>"
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
 * @package event
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CategoryService extends GeneralUtility {

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function injectCategoryRepository(CategoryRepository $categoryRepository): void
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
	 * Finds all descendants of an given category
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\Category $parentCategory
	 * @return ObjectStorage $resultStorage
	 */

	public function findAllDescendants (Category $parentCategory){
		$this->categoryRepository->setDefaultOrderings(array('title'=>QueryInterface::ORDER_ASCENDING));
		$allCategories = $this->categoryRepository->findAll();

		$storage = $regions = $this->buildStorageFormQuery($allCategories);
		$resultStorage = new ObjectStorage;
		$stack = array();
		array_push($stack, $parentCategory);
		while(count($stack)>0){
			$currentRoot = array_pop($stack);
			foreach($storage as $category){
				if($category->getParent() === $currentRoot){
					$resultStorage->attach($category);
					array_push($stack, $category);
				}
			}
		}
		return $resultStorage;
	}

	/**
	 * Builds an object storage form query
	 *
	 * @param QueryResultInterface|array
	 * @return ObjectStorage
	 */
	protected function buildStorageFormQuery (QueryResultInterface $query){
		$storage = new ObjectStorage;
		foreach($query as $category){
			if($category->getParent()!=NULL) $storage->attach($category);
		}
		return $storage;
	}

}

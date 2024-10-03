<?php

namespace Kanow\Operations\Service;

use Kanow\Operations\Domain\Model\Category;
use Kanow\Operations\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CategoryService
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Finds all descendants of a given category
     *
     * @param Category $parentCategory
     * @return ObjectStorage
     */
    public function findAllDescendants(Category $parentCategory): ObjectStorage
    {
        $this->categoryRepository->setDefaultOrderings(['title' => QueryInterface::ORDER_ASCENDING]);
        $allCategories = $this->categoryRepository->findAll();

        $storage = $this->buildStorageFromQuery($allCategories);
        return $this->findDescendantsRecursive($parentCategory, $storage);
    }

    /**
     * Recursively finds descendants of a category
     *
     * @param Category $parentCategory
     * @param ObjectStorage $storage
     * @return ObjectStorage
     */
    protected function findDescendantsRecursive(Category $parentCategory, ObjectStorage $storage): ObjectStorage
    {
        $resultStorage = new ObjectStorage();
        $stack = [$parentCategory];

        while (count($stack) > 0) {
            $currentRoot = array_pop($stack);
            $this->attachChildrenToStorage($currentRoot, $storage, $resultStorage, $stack);
        }

        return $resultStorage;
    }

    /**
     * Attaches child categories to result storage and updates the stack
     *
     * @param Category $currentRoot
     * @param ObjectStorage $storage
     * @param ObjectStorage $resultStorage
     * @param array $stack
     * @return void
     */
    protected function attachChildrenToStorage(
        Category $currentRoot,
        ObjectStorage $storage,
        ObjectStorage $resultStorage,
        array &$stack
    ): void {
        foreach ($storage as $category) {
            if ($category->getParent() === $currentRoot) {
                $resultStorage->attach($category);
                $stack[] = $category;
            }
        }
    }

    /**
     * Builds an object storage from a query
     *
     * @param QueryResultInterface|Category[] $query The query or array of categories
     * @return ObjectStorage The resulting object storage
     */
    protected function buildStorageFromQuery(QueryResultInterface $query): ObjectStorage
    {
        $storage = new ObjectStorage();
        foreach ($query as $category) {
            if ($category->getParent() !== null) {
                $storage->attach($category);
            }
        }
        return $storage;
    }
}

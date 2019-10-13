<?php
namespace Kanow\Operations\Domain\Repository;

use TYPO3\CMS\Extbase\Domain\Model\Category;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Karsten Nowak <captnnowi@gmx.de>
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
class CategoryRepository extends \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository {

	/**
	 * Get all sub categories (one level)
	 *
	 * @param Category $category
	 */
	public function findByParent($category){
		$this->setDefaultOrderings(array('title'=>'\TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING'));
		$query = $this->createQuery();
		$query->matching($query->equals("parent", $category));
	}

}
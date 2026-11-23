<?php

declare(strict_types=1);

namespace Kanow\Operations\Domain\Repository;

/*
 * This file is part of the TYPO3 extension `operations`.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Kanow\Operations\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for Category models.
 *
 * @extends Repository<Category>
 */
class CategoryRepository extends Repository
{
    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }
}

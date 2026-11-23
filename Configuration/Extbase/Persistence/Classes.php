<?php

declare(strict_types=1);

use Kanow\Operations\Domain\Model\Category;
use Kanow\Operations\Domain\Model\Operation;

return [
    Category::class => [
        'tableName' => 'sys_category',
    ],
    Operation::class => [
        'properties' => [
            // The column name is not snake_case, so Extbase cannot derive the property name on its own.
            'onlyEld' => [
                'fieldName' => 'onlyEld',
            ],
        ],
    ],
];

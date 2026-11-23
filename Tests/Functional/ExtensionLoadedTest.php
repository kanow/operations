<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversNothing]
final class ExtensionLoadedTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['kanow/operations'];

    // The database is initialized on purpose (other than in the "tea" extension): As long as there are no other
    // functional tests, this test also makes sure that the database schema of the extension can be created on all
    // supported DBMS.
    protected bool $initializeDatabase = true;

    #[Test]
    public function isLoadedWithExtensionKey(): void
    {
        self::assertTrue(ExtensionManagementUtility::isLoaded('operations'));
    }

    #[Test]
    public function isLoadedWithComposerPackageName(): void
    {
        self::assertTrue(ExtensionManagementUtility::isLoaded('kanow/operations'));
    }
}

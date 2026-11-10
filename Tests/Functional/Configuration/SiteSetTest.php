<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Configuration;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Settings\CategoryDefinition;
use TYPO3\CMS\Core\Settings\SettingDefinition;
use TYPO3\CMS\Core\Settings\SettingsTypeRegistry;
use TYPO3\CMS\Core\Site\Set\SetDefinition;
use TYPO3\CMS\Core\Site\Set\SetRegistry;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks the site set "kanow/operations" (Configuration/Sets/Operations).
 */
#[CoversNothing]
final class SiteSetTest extends FunctionalTestCase
{
    private const SET_NAME = 'kanow/operations';

    protected array $testExtensionsToLoad = ['kanow/operations'];

    protected array $coreExtensionsToLoad = ['typo3/cms-fluid-styled-content'];

    protected array $pathsToLinkInTestInstance = [
        'typo3conf/ext/operations/Tests/Functional/Controller/Fixtures/Sites/' => 'typo3conf/sites',
    ];

    private function getSet(): SetDefinition
    {
        $set = $this->get(SetRegistry::class)->getSet(self::SET_NAME);
        self::assertInstanceOf(SetDefinition::class, $set);

        return $set;
    }

    /**
     * @return array<string, SettingDefinition>
     */
    private function getSettingsDefinitionsByKey(): array
    {
        $definitions = [];
        foreach ($this->getSet()->settingsDefinitions as $definition) {
            $definitions[$definition->key] = $definition;
        }

        return $definitions;
    }

    #[Test]
    public function setIsRegistered(): void
    {
        self::assertTrue($this->get(SetRegistry::class)->hasSet(self::SET_NAME));
    }

    #[Test]
    public function setIsValid(): void
    {
        self::assertArrayNotHasKey(self::SET_NAME, $this->get(SetRegistry::class)->getInvalidSets());
    }

    #[Test]
    public function setProvidesTypoScript(): void
    {
        self::assertNotNull($this->getSet()->typoscript);
    }

    #[Test]
    public function settingsDefinitionsContainRootCategory(): void
    {
        $definition = $this->getSettingsDefinitionsByKey()['operations.rootCategory'] ?? null;

        self::assertInstanceOf(SettingDefinition::class, $definition);
        self::assertSame('int', $definition->type);
        self::assertSame(0, $definition->default);
    }

    #[Test]
    public function settingsDefinitionsContainListMediaWidthResource(): void
    {
        $definition = $this->getSettingsDefinitionsByKey()['operations.listMediaWidthResource'] ?? null;

        self::assertInstanceOf(SettingDefinition::class, $definition);
        self::assertSame('string', $definition->type);
        self::assertSame('320', $definition->default);
    }

    #[Test]
    public function allSettingsDefinitionsUseRegisteredTypesAndValidDefaults(): void
    {
        $settingsTypeRegistry = $this->get(SettingsTypeRegistry::class);

        $invalidDefinitions = array_filter(
            $this->getSettingsDefinitionsByKey(),
            static fn(SettingDefinition $definition): bool => !$settingsTypeRegistry->has($definition->type)
                || !$settingsTypeRegistry->get($definition->type)->validate($definition->default, $definition)
        );

        self::assertSame([], array_keys($invalidDefinitions));
    }

    #[Test]
    public function allSettingsDefinitionsUseDefinedCategories(): void
    {
        $categoryKeys = array_map(
            static fn(CategoryDefinition $category): string => $category->key,
            $this->getSet()->categoryDefinitions
        );

        $settingsWithUnknownCategory = array_filter(
            $this->getSettingsDefinitionsByKey(),
            static fn(SettingDefinition $definition): bool => !in_array($definition->category, $categoryKeys, true)
        );

        self::assertSame([], array_keys($settingsWithUnknownCategory));
    }

    #[Test]
    public function siteUsingTheSetProvidesDefaultSettings(): void
    {
        $settings = $this->get(SiteFinder::class)->getSiteByRootPageId(1)->getSettings();

        self::assertSame(0, $settings->get('operations.rootCategory'));
        self::assertSame('320', $settings->get('operations.listMediaWidthResource'));
        self::assertSame(5, $settings->get('operations.lastYears'));
        self::assertSame(200, $settings->get('operations.limit'));
        self::assertFalse($settings->get('operations.hidePagination'));
    }
}

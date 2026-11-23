<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Configuration;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks that all labels referenced by the extension can be resolved for the default language.
 */
#[CoversNothing]
final class LabelTest extends FunctionalTestCase
{
    use TcaPathTrait;

    private const EXTENSION_PATH = __DIR__ . '/../../../';

    private const LABEL_PATTERN = '/LLL:[^;,"\'\s<>]+/';

    protected array $testExtensionsToLoad = ['kanow/operations'];

    private LanguageService $languageService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->languageService = $this->get(LanguageServiceFactory::class)->create('default');
    }

    /**
     * @return list<string>
     */
    private static function findLabelReferences(string $content): array
    {
        preg_match_all(self::LABEL_PATTERN, $content, $matches);

        return array_values(array_unique($matches[0]));
    }

    private static function readFile(string $relativePath): string
    {
        $content = file_get_contents(self::EXTENSION_PATH . $relativePath);
        self::assertIsString($content);

        return $content;
    }

    /**
     * @return list<string>
     */
    private static function globFiles(string $relativePattern): array
    {
        $files = glob(self::EXTENSION_PATH . $relativePattern);
        self::assertIsArray($files);
        self::assertNotSame([], $files);

        return $files;
    }

    /**
     * @param list<string> $files
     */
    private static function readFiles(array $files): string
    {
        return implode(LF, array_map(static fn(string $file): string => (string)file_get_contents($file), $files));
    }

    /**
     * @param list<string> $labels
     *
     * @return list<string>
     */
    private function findUnresolvableLabels(array $labels): array
    {
        self::assertNotSame([], $labels, 'No labels found.');

        return array_values(array_filter(
            $labels,
            fn(string $label): bool => trim($this->languageService->sL($label)) === ''
        ));
    }

    /**
     * @return list<string>
     */
    private static function getTtContentLabelReferences(): array
    {
        $relevantTca = [
            'items' => self::getContentTypeItems(),
            'itemGroup' => self::getTcaValue('tt_content/columns/CType/config/itemGroups/operations'),
            'types' => array_intersect_key(self::getTcaArray('tt_content/types'), array_flip(TcaTest::CONTENT_TYPES)),
        ];

        return self::findLabelReferences(json_encode($relevantTca, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES));
    }

    #[Test]
    public function allLabelsInTcaOfExtensionTablesCanBeResolved(): void
    {
        $tca = array_map(static fn(string $table): array => self::getTcaArray($table), TcaTest::TABLES);

        $labels = self::findLabelReferences(json_encode($tca, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES));

        self::assertSame([], $this->findUnresolvableLabels($labels));
    }

    #[Test]
    public function allLabelsOfContentTypesCanBeResolved(): void
    {
        self::assertSame([], $this->findUnresolvableLabels(self::getTtContentLabelReferences()));
    }

    #[Test]
    public function allLabelsInFlexFormsCanBeResolved(): void
    {
        $files = self::globFiles('Configuration/FlexForms/*.xml');
        self::assertCount(7, $files);

        $content = self::readFiles($files);

        self::assertSame([], $this->findUnresolvableLabels(self::findLabelReferences($content)));
    }

    #[Test]
    public function allLabelsInSiteSetCanBeResolved(): void
    {
        $content = self::readFile('Configuration/Sets/Operations/settings.definitions.yaml')
            . LF . self::readFile('Configuration/Sets/Operations/config.yaml');

        self::assertSame([], $this->findUnresolvableLabels(self::findLabelReferences($content)));
    }

    #[Test]
    public function allLabelsInTypoScriptConstantsCanBeResolved(): void
    {
        $content = self::readFile('Configuration/TypoScript/constants.typoscript');

        self::assertSame([], $this->findUnresolvableLabels(self::findLabelReferences($content)));
    }

    #[Test]
    public function allTranslationKeysUsedInFluidTemplatesCanBeResolved(): void
    {
        $content = self::readFiles(array_merge(
            self::globFiles('Resources/Private/Templates/*/*.html'),
            self::globFiles('Resources/Private/Partials/*/*.html')
        ));
        preg_match_all('/key(?:="|:\s*\'|:\s*")([^"\']+)/', $content, $matches);
        self::assertNotSame([], $matches[1]);

        $labels = array_map(
            static fn(string $key): string => 'LLL:EXT:operations/Resources/Private/Language/locallang.xlf:' . $key,
            array_values(array_unique($matches[1]))
        );

        self::assertSame([], $this->findUnresolvableLabels($labels));
    }
}

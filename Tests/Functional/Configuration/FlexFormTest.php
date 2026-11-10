<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Configuration;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\Schema\TcaSchemaFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Checks that the FlexForm data structures of all plugins can be resolved (Configuration/FlexForms).
 *
 * Any on-the-fly TCA migration of a FlexForm field triggers a deprecation, which makes these tests fail.
 */
#[CoversNothing]
final class FlexFormTest extends FunctionalTestCase
{
    use TcaPathTrait;

    protected array $testExtensionsToLoad = ['kanow/operations'];

    /**
     * @return \Generator<string, array{0: string, 1: string}>
     */
    public static function contentTypeDataProvider(): \Generator
    {
        yield 'operations_operationlist' => ['operations_operationlist', 'flexform_operation_list.xml'];
        yield 'operations_operationshow' => ['operations_operationshow', 'flexform_operation_show.xml'];
        yield 'operations_operationstatistics' => ['operations_operationstatistics', 'flexform_operation_statistics.xml'];
        yield 'operations_vehiclelist' => ['operations_vehiclelist', 'flexform_vehicle_list.xml'];
        yield 'operations_vehicleshow' => ['operations_vehicleshow', 'flexform_vehicle_show.xml'];
        yield 'operations_resourcelist' => ['operations_resourcelist', 'flexform_resource_list.xml'];
        yield 'operations_resourceshow' => ['operations_resourceshow', 'flexform_resource_show.xml'];
    }

    /**
     * @param array<array-key, mixed> $dataStructure
     *
     * @return array<string, list<string>> field names by sheet name
     */
    private function getFieldNamesBySheet(array $dataStructure): array
    {
        $sheets = $dataStructure['sheets'] ?? null;
        self::assertIsArray($sheets);
        $fieldNamesBySheet = [];
        foreach ($sheets as $sheetName => $sheet) {
            $elements = is_array($sheet) && is_array($sheet['ROOT'] ?? null) ? ($sheet['ROOT']['el'] ?? null) : null;
            self::assertIsArray($elements, 'Sheet "' . $sheetName . '" has no elements.');
            $fieldNamesBySheet[(string)$sheetName] = array_map(strval(...), array_keys($elements));
        }

        return $fieldNamesBySheet;
    }

    /**
     * @return array<array-key, mixed>
     */
    private function parseDataStructureOfContentType(string $contentType): array
    {
        $flexFormTools = $this->get(FlexFormTools::class);
        $schema = $this->get(TcaSchemaFactory::class)->get('tt_content');
        $fieldTca = self::getTcaArray('tt_content/columns/pi_flexform');

        $identifier = $flexFormTools->getDataStructureIdentifier(
            $fieldTca,
            'tt_content',
            'pi_flexform',
            ['CType' => $contentType],
            $schema
        );

        return $flexFormTools->parseDataStructureByIdentifier($identifier, $schema);
    }

    #[Test]
    #[DataProvider('contentTypeDataProvider')]
    public function dataStructureIdentifierPointsToContentType(string $contentType): void
    {
        $fieldTca = self::getTcaArray('tt_content/columns/pi_flexform');

        $identifier = $this->get(FlexFormTools::class)->getDataStructureIdentifier(
            $fieldTca,
            'tt_content',
            'pi_flexform',
            ['CType' => $contentType],
            $this->get(TcaSchemaFactory::class)->get('tt_content')
        );

        $decodedIdentifier = json_decode($identifier, true);
        self::assertIsArray($decodedIdentifier);
        self::assertSame($contentType, $decodedIdentifier['dataStructureKey'] ?? null);
    }

    #[Test]
    #[DataProvider('contentTypeDataProvider')]
    public function dataStructureOfContentTypeContainsAllFieldsOfFlexFormFile(string $contentType, string $fileName): void
    {
        $xml = file_get_contents(__DIR__ . '/../../../Configuration/FlexForms/' . $fileName);
        self::assertIsString($xml);
        $expectedDataStructure = GeneralUtility::xml2array($xml);
        self::assertIsArray($expectedDataStructure);

        $dataStructure = $this->parseDataStructureOfContentType($contentType);

        self::assertSame($this->getFieldNamesBySheet($expectedDataStructure), $this->getFieldNamesBySheet($dataStructure));
    }
}

<?php

declare(strict_types=1);

namespace Kanow\Operations\Tests\Functional\Domain\Repository;

use Kanow\Operations\Domain\Model\Operation;
use Kanow\Operations\Domain\Model\OperationDemand;
use Kanow\Operations\Domain\Model\Type;
use Kanow\Operations\Domain\Repository\OperationRepository;
use Kanow\Operations\Domain\Repository\TypeRepository;
use Kanow\Operations\Utility\SqlUtility;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(OperationRepository::class)]
#[CoversClass(SqlUtility::class)]
final class OperationRepositoryTest extends FunctionalTestCase
{
    private const STORAGE_PAGE_UID = 2;

    protected array $testExtensionsToLoad = ['kanow/operations'];

    private OperationRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->get(OperationRepository::class);
        $this->subject->setDefaultQuerySettings($this->createQuerySettingsForStoragePage());
    }

    private function createQuerySettingsForStoragePage(): Typo3QuerySettings
    {
        $querySettings = $this->get(Typo3QuerySettings::class);
        $querySettings->setStoragePageIds([self::STORAGE_PAGE_UID]);

        return $querySettings;
    }

    /**
     * @param array<string, mixed> $settings
     *
     * @return list<string>
     */
    private function findDemandedTitles(OperationDemand $demand, array $settings = []): array
    {
        $titles = [];
        foreach ($this->subject->findDemanded($demand, $settings) as $operation) {
            self::assertInstanceOf(Operation::class, $operation);
            $titles[] = $operation->getTitle();
        }

        return $titles;
    }

    /**
     * @param array<array-key, mixed> $rows
     *
     * @return list<int>
     */
    private function extractUids(array $rows): array
    {
        $uids = [];
        foreach ($rows as $row) {
            self::assertIsArray($row);
            self::assertIsNumeric($row['uid'] ?? null);
            $uids[] = (int)$row['uid'];
        }

        return $uids;
    }

    #[Test]
    public function isRepository(): void
    {
        self::assertInstanceOf(Repository::class, $this->subject);
    }

    #[Test]
    public function findByUidForExistingRecordReturnsModel(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');

        $model = $this->subject->findByUid(1);

        self::assertInstanceOf(Operation::class, $model);
        self::assertSame('Kitchen fire', $model->getTitle());
    }

    #[Test]
    public function findDemandedForNoRecordsReturnsEmptyResult(): void
    {
        self::assertSame([], $this->findDemandedTitles(new OperationDemand()));
    }

    #[Test]
    public function findDemandedWithoutConstraintsFindsVisibleOperationsOnStoragePageSortedByBeginDescending(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');

        $titles = $this->findDemandedTitles(new OperationDemand());

        self::assertSame(['Car accident', 'Kitchen fire', 'Chimney fire', 'Oil spill'], $titles);
    }

    /**
     * @return \Generator<string, array{0: int, 1: list<string>}>
     */
    public static function yearDataProvider(): \Generator
    {
        yield '2023' => [2023, ['Car accident', 'Kitchen fire']];
        yield '2022' => [2022, ['Chimney fire']];
        yield '2021' => [2021, ['Oil spill']];
        yield '2020 (no operations)' => [2020, []];
    }

    /**
     * @param list<string> $expectedTitles
     */
    #[Test]
    #[DataProvider('yearDataProvider')]
    public function findDemandedWithYearFindsOperationsBegunInThatYear(int $year, array $expectedTitles): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');
        $demand = new OperationDemand();
        $demand->setBegin($year);

        self::assertSame($expectedTitles, $this->findDemandedTitles($demand));
    }

    #[Test]
    public function findDemandedWithTypeFindsOperationsOfThatType(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');
        $demand = new OperationDemand();
        $demand->setType(1);

        self::assertSame(['Kitchen fire', 'Chimney fire'], $this->findDemandedTitles($demand));
    }

    #[Test]
    public function findDemandedWithTypeAndYearCombinesBothConstraints(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');
        $demand = new OperationDemand();
        $demand->setType(1);
        $demand->setBegin(2022);

        self::assertSame(['Chimney fire'], $this->findDemandedTitles($demand));
    }

    #[Test]
    public function findDemandedWithDemandCategoryFindsOperationsWithThatCategory(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');
        $demand = new OperationDemand();
        $demand->setCategory(3);

        self::assertSame(['Car accident', 'Chimney fire'], $this->findDemandedTitles($demand));
    }

    /**
     * @return \Generator<string, array{0: string, 1: list<string>}>
     */
    public static function categoryConjunctionDataProvider(): \Generator
    {
        yield 'or' => ['or', ['Car accident', 'Kitchen fire', 'Chimney fire']];
        yield 'and' => ['and', ['Car accident']];
        yield 'notor' => ['notor', ['Oil spill']];
        yield 'notand' => ['notand', ['Kitchen fire', 'Chimney fire', 'Oil spill']];
        yield 'empty conjunction ignores the categories' => ['', ['Car accident', 'Kitchen fire', 'Chimney fire', 'Oil spill']];
    }

    /**
     * @param list<string> $expectedTitles
     */
    #[Test]
    #[DataProvider('categoryConjunctionDataProvider')]
    public function findDemandedWithCategoriesFromSettingsRespectsCategoryConjunction(
        string $conjunction,
        array $expectedTitles
    ): void {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');
        $settings = ['category' => '2,3', 'categoryConjunction' => $conjunction];

        self::assertSame($expectedTitles, $this->findDemandedTitles(new OperationDemand(), $settings));
    }

    #[Test]
    public function findDemandedWithSingleCategoryFromSettingsAndOrConjunctionFindsOperationsWithThatCategory(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');
        $settings = ['category' => '2', 'categoryConjunction' => 'or'];

        self::assertSame(['Car accident', 'Kitchen fire'], $this->findDemandedTitles(new OperationDemand(), $settings));
    }

    /**
     * @return \Generator<string, array{0: string, 1: list<string>}>
     */
    public static function searchStringDataProvider(): \Generator
    {
        yield 'match in title' => ['fire', ['Kitchen fire', 'Chimney fire']];
        yield 'match in location' => ['Thale', ['Kitchen fire', 'Oil spill']];
        yield 'match in teaser' => ['flames', ['Chimney fire']];
        yield 'no match' => ['Avalanche', []];
    }

    /**
     * @param list<string> $expectedTitles
     */
    #[Test]
    #[DataProvider('searchStringDataProvider')]
    public function findDemandedWithSearchStringSearchesInConfiguredSearchFields(
        string $searchString,
        array $expectedTitles
    ): void {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');
        $demand = new OperationDemand();
        $demand->setSearchstring($searchString);

        $settings = ['searchFields' => 'title,teaser,location'];

        self::assertSame($expectedTitles, $this->findDemandedTitles($demand, $settings));
    }

    #[Test]
    public function findDemandedWithSearchStringOnlySearchesInConfiguredSearchFields(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');
        $demand = new OperationDemand();
        $demand->setSearchstring('Thale');

        $settings = ['searchFields' => 'title'];

        self::assertSame([], $this->findDemandedTitles($demand, $settings));
    }

    #[Test]
    public function findDemandedWithSearchStringAndWithoutSearchFieldsThrowsException(): void
    {
        $demand = new OperationDemand();
        $demand->setSearchstring('fire');

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionCode(1506861158);

        $this->subject->findDemanded($demand, []);
    }

    #[Test]
    public function findDemandedWithLimitInDemandLimitsResult(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');
        $demand = new OperationDemand();
        $demand->setLimit(2);

        self::assertSame(['Car accident', 'Kitchen fire'], $this->findDemandedTitles($demand));
    }

    #[Test]
    public function findDemandedWithLimitInSettingsLimitsResult(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');

        $titles = $this->findDemandedTitles(new OperationDemand(), ['limit' => '3']);

        self::assertSame(['Car accident', 'Kitchen fire', 'Chimney fire'], $titles);
    }

    #[Test]
    public function findDemandedPrefersLimitFromDemandOverLimitFromSettings(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');
        $demand = new OperationDemand();
        $demand->setLimit(1);

        self::assertSame(['Car accident'], $this->findDemandedTitles($demand, ['limit' => '3']));
    }

    #[Test]
    public function findDemandedWithDontRespectStoragePageFromTypoScriptAlsoFindsOperationsOnOtherPages(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');

        // TypoScript settings are always strings
        $titles = $this->findDemandedTitles(new OperationDemand(), ['dontRespectStoragePage' => '1']);

        self::assertSame(
            ['Operation on other page', 'Car accident', 'Kitchen fire', 'Chimney fire', 'Oil spill'],
            $titles
        );
    }

    #[Test]
    public function findDemandedWithDisabledDontRespectStoragePageRespectsStoragePage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');

        $titles = $this->findDemandedTitles(new OperationDemand(), ['dontRespectStoragePage' => '0']);

        self::assertSame(['Car accident', 'Kitchen fire', 'Chimney fire', 'Oil spill'], $titles);
    }

    #[Test]
    public function findDemandedWithShowMapOnlyFindsOperationsWithCoordinates(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemanded/Operations.csv');

        $titles = $this->findDemandedTitles(new OperationDemand(), ['showMap' => '1']);

        self::assertSame(['Kitchen fire', 'Chimney fire'], $titles);
    }

    #[Test]
    public function findDemandedForStatisticsReturnsRawRowsSortedByBeginDescending(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemandedForStatistics/Operations.csv');

        $rows = $this->subject->findDemandedForStatistics(new OperationDemand(), []);

        self::assertSame([2, 1, 3, 4], $this->extractUids($rows));
    }

    #[Test]
    public function findDemandedForStatisticsWithNoLimitForStatisticsIgnoresLimit(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemandedForStatistics/Operations.csv');
        $settings = ['limit' => '2', 'noLimitForStatistics' => '1'];

        $rows = $this->subject->findDemandedForStatistics(new OperationDemand(), $settings);

        self::assertSame([2, 1, 3, 4], $this->extractUids($rows));
    }

    #[Test]
    public function findDemandedForStatisticsWithoutNoLimitForStatisticsRespectsLimit(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemandedForStatistics/Operations.csv');
        $settings = ['limit' => '2', 'noLimitForStatistics' => '0'];

        $rows = $this->subject->findDemandedForStatistics(new OperationDemand(), $settings);

        self::assertSame([2, 1], $this->extractUids($rows));
    }

    #[Test]
    public function findDemandedForStatisticsRespectsDemand(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemandedForStatistics/Operations.csv');
        $demand = new OperationDemand();
        $demand->setBegin(2023);

        $rows = $this->subject->findDemandedForStatistics($demand, []);

        self::assertSame([2, 1], $this->extractUids($rows));
    }

    #[Test]
    public function countDemandedForStatisticsCountsAllVisibleOperations(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemandedForStatistics/Operations.csv');

        self::assertSame(4, $this->subject->countDemandedForStatistics(new OperationDemand(), []));
    }

    #[Test]
    public function countDemandedForStatisticsWithNoLimitForStatisticsIgnoresLimit(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemandedForStatistics/Operations.csv');
        $demand = new OperationDemand();
        $demand->setLimit(1);

        $count = $this->subject->countDemandedForStatistics($demand, ['noLimitForStatistics' => '1']);

        self::assertSame(4, $count);
    }

    #[Test]
    public function countDemandedForStatisticsWithoutNoLimitForStatisticsRespectsLimit(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/findDemandedForStatistics/Operations.csv');
        $demand = new OperationDemand();
        $demand->setLimit(1);

        self::assertSame(1, $this->subject->countDemandedForStatistics($demand, []));
    }

    /**
     * @param array<array-key, mixed> $rows
     *
     * @return list<array{year: int, count: int}>
     */
    private function normalizeYearCounts(array $rows): array
    {
        $normalizedRows = [];
        foreach ($rows as $row) {
            self::assertIsArray($row);
            self::assertIsNumeric($row['year'] ?? null);
            self::assertIsNumeric($row['count'] ?? null);
            // Depending on the DBMS, the year is returned as integer or (numeric) string
            $normalizedRows[] = ['year' => (int)$row['year'], 'count' => (int)$row['count']];
        }

        return $normalizedRows;
    }

    /**
     * Years are passed in like the controller creates them (year as string) and as integers.
     *
     * @return \Generator<string, array{0: array<int|string, int|string>}>
     */
    public static function yearsDataProvider(): \Generator
    {
        yield 'years as strings' => [[2023 => '2023', 2022 => '2022', 2021 => '2021']];
        yield 'years as integers' => [[2023, 2022, 2021]];
    }

    /**
     * @param array<int|string, int|string> $years
     */
    #[Test]
    #[DataProvider('yearsDataProvider')]
    public function countGroupedByYearCountsVisibleOperationsPerYearSortedByYearDescending(array $years): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/countGroupedByYear/Operations.csv');

        $result = $this->subject->countGroupedByYear($years);

        $expected = [
            ['year' => 2023, 'count' => 3],
            ['year' => 2022, 'count' => 1],
            ['year' => 2021, 'count' => 1],
        ];
        self::assertSame($expected, $this->normalizeYearCounts($result));
    }

    #[Test]
    public function countGroupedByYearOnlyCountsGivenYears(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/countGroupedByYear/Operations.csv');

        $result = $this->subject->countGroupedByYear(['2022', '2020']);

        $expected = [
            ['year' => 2022, 'count' => 1],
            ['year' => 2020, 'count' => 1],
        ];
        self::assertSame($expected, $this->normalizeYearCounts($result));
    }

    #[Test]
    public function countGroupedByYearWithUidListOnlyCountsGivenOperations(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/countGroupedByYear/Operations.csv');

        $result = $this->subject->countGroupedByYear(['2023', '2022', '2021'], '1,3,7');

        $expected = [
            ['year' => 2023, 'count' => 2],
            ['year' => 2022, 'count' => 1],
        ];
        self::assertSame($expected, $this->normalizeYearCounts($result));
    }

    #[Test]
    public function countGroupedByYearWithoutYearsReturnsEmptyArray(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/countGroupedByYear/Operations.csv');

        self::assertSame([], $this->subject->countGroupedByYear([]));
    }

    /**
     * @return list<Type>
     */
    private function findAllTypes(): array
    {
        $typeRepository = $this->get(TypeRepository::class);
        $typeRepository->setDefaultQuerySettings($this->createQuerySettingsForStoragePage());

        $types = [];
        foreach ($typeRepository->findAll() as $type) {
            self::assertInstanceOf(Type::class, $type);
            $types[] = $type;
        }

        return $types;
    }

    /**
     * Casts the counts to int, as some DBMS return them as strings. The keys are not touched on purpose:
     * Years from the database must end up as the same (integer) array keys as the years added for empty values.
     *
     * @param array<array-key, mixed> $result
     *
     * @return array<array-key, array{title: mixed, color: mixed, years: array<array-key, int>}>
     */
    private function normalizeCountsPerType(array $result): array
    {
        $normalizedResult = [];
        foreach ($result as $typeUid => $item) {
            self::assertIsArray($item);
            self::assertIsArray($item['years'] ?? null);
            $normalizedResult[$typeUid] = [
                'title' => $item['title'] ?? null,
                'color' => $item['color'] ?? null,
                'years' => array_map(static fn(mixed $count): int => is_numeric($count) ? (int)$count : -1, $item['years']),
            ];
        }

        return $normalizedResult;
    }

    #[Test]
    public function countGroupedByYearAndTypeCountsVisibleOperationsPerTypeAndYearIncludingEmptyValues(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/countGroupedByYearAndType/Operations.csv');

        $result = $this->subject->countGroupedByYearAndType(
            [2023 => '2023', 2022 => '2022', 2021 => '2021'],
            $this->findAllTypes()
        );

        $expected = [
            1 => ['title' => 'Fire', 'color' => '#ff0000', 'years' => [2023 => 2, 2022 => 1, 2021 => 0]],
            2 => ['title' => 'Technical assistance', 'color' => '#00ff00', 'years' => [2023 => 1, 2022 => 0, 2021 => 0]],
            3 => ['title' => 'Hazardous materials', 'color' => '#0000ff', 'years' => [2023 => 0, 2022 => 0, 2021 => 0]],
        ];
        self::assertSame($expected, $this->normalizeCountsPerType($result));
    }

    #[Test]
    public function countGroupedByYearAndTypeWithUidListOnlyCountsGivenOperations(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/countGroupedByYearAndType/Operations.csv');

        $result = $this->subject->countGroupedByYearAndType(
            [2023 => '2023', 2022 => '2022', 2021 => '2021'],
            $this->findAllTypes(),
            '1,3'
        );

        $expected = [
            1 => ['title' => 'Fire', 'color' => '#ff0000', 'years' => [2023 => 1, 2022 => 1, 2021 => 0]],
            2 => ['title' => 'Technical assistance', 'color' => '#00ff00', 'years' => [2023 => 0, 2022 => 0, 2021 => 0]],
            3 => ['title' => 'Hazardous materials', 'color' => '#0000ff', 'years' => [2023 => 0, 2022 => 0, 2021 => 0]],
        ];
        self::assertSame($expected, $this->normalizeCountsPerType($result));
    }

    #[Test]
    public function countGroupedByYearAndTypeWithoutYearsReturnsEmptyArray(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/countGroupedByYearAndType/Operations.csv');

        self::assertSame([], $this->subject->countGroupedByYearAndType([], $this->findAllTypes()));
    }

    #[Test]
    public function countGroupedByYearAndTypeWithYearsAsIntegersReturnsSameResult(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/countGroupedByYearAndType/Operations.csv');
        $types = $this->findAllTypes();

        $resultForStrings = $this->subject->countGroupedByYearAndType(['2023', '2022'], $types);
        $resultForIntegers = $this->subject->countGroupedByYearAndType([2023, 2022], $types);

        self::assertSame($this->normalizeCountsPerType($resultForStrings), $this->normalizeCountsPerType($resultForIntegers));
    }
}

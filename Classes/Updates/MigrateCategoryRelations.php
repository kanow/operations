<?php

namespace Kanow\Operations\Updates;

use Doctrine\DBAL\Driver\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Install\Updates\ChattyInterface;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Karsten Nowak <captnnowi@gmx.de>
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

class MigrateCategoryRelations implements  ChattyInterface, UpgradeWizardInterface
{

    protected const OLD_MM_TABLE = 'tx_operations_operation_category_mm';
    protected const NEW_MM_TABLE = 'sys_category_record_mm';
    protected const RELATION_FIELD = 'category';
    protected const RELATION_TABLE = 'tx_operations_domain_model_operation';

    protected OutputInterface $output;
    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier(): string
    {
        return 'operations_migrateCategoryRelations';
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return sprintf('Migrate category relations from "%s" table', self::OLD_MM_TABLE);
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return sprintf('Migrate category relations from old "%s" table to "%s". Please backup your table "%2$s" before executing this wizard. The wizard copies all relations into the new table, everytime the wizard is executed!. The wizard don\'t check whether some relations are already migrated or not. Delete table "%1$s" afterwards if everything is fine.', self::OLD_MM_TABLE, self::NEW_MM_TABLE);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function executeUpdate(): bool
    {
        $queryBuilderForOldMmTable = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable(self::OLD_MM_TABLE);
        $oldRelations = $queryBuilderForOldMmTable->select(
            'uid_foreign AS uid_local',
                'uid_local AS uid_foreign',
                'field AS fieldname',
                'sorting',
                'sorting_foreign'
            )
            ->addSelectLiteral('"tx_operations_domain_model_operation" AS tablenames')
            ->from(self::OLD_MM_TABLE)
            ->executeQuery()->fetchAllAssociative();
        $this->output->writeln(sprintf('%s old category relations found.', count($oldRelations)));

        if(count($oldRelations) > 0) {
            $connectionForNewMmTable = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable(self::NEW_MM_TABLE);
            $migratedRelations = $connectionForNewMmTable->bulkInsert(
                self::NEW_MM_TABLE,
                $oldRelations,
                ['uid_local', 'uid_foreign', 'fieldname', 'sorting', 'sorting_foreign', 'tablenames']);
            $this->output->writeln(sprintf('%s category relations are migrated!', (int)$migratedRelations));
        }
        return true;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function updateNecessary(): bool
    {
        $relationsNotMigrated = [];
        $queryBuilderForOldTable = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable(self::OLD_MM_TABLE);

        if ($queryBuilderForOldTable->getConnection()->getSchemaManager()->tablesExist([self::OLD_MM_TABLE]) === true) {
            $sqlForOldTable = $queryBuilderForOldTable->select('uid_local')
                ->from(self::OLD_MM_TABLE)
                ->groupBy('uid_local')
                ->executeQuery();
            $foreignData = $sqlForOldTable->fetchFirstColumn();
            $this->output->writeln('Found old category relations in operation data with uids: ' . implode(',',$foreignData) . '.');

            if ($foreignData) {
                $queryBuilderForNewTable = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable(self::NEW_MM_TABLE);
                /** @noinspection PhpComposerExtensionStubsInspection */
                $sqlForNewTable = $queryBuilderForNewTable->select('uid_foreign')
                    ->from(self::NEW_MM_TABLE)
                    ->where($queryBuilderForNewTable->expr()->eq('tablenames',
                        $queryBuilderForNewTable->createNamedParameter(self::RELATION_TABLE, \PDO::PARAM_STR)))
                    ->andWhere($queryBuilderForNewTable->expr()->eq('fieldname',
                        $queryBuilderForNewTable->createNamedParameter(self::RELATION_FIELD, \PDO::PARAM_STR)))
                    ->groupBy('uid_foreign')
                    ->executeQuery();
                $foreignDataInNewRelationTable = $sqlForNewTable->fetchFirstColumn();
                $relationsNotMigrated = array_diff($foreignData, $foreignDataInNewRelationTable);

                $this->output->writeln('Uid list of operation data with missing relation in new relation table ' . self::NEW_MM_TABLE . ': ' . implode(',',$relationsNotMigrated) . '.');
            }
            return count($relationsNotMigrated) > 0;
        } else {
            return false;
        }
    }

    /**
     * all tables and fields must be exist
     * @inheritDoc
     */
    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }
}
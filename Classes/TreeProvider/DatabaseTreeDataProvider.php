<?php

namespace Kanow\Operations\TreeProvider;

/**
 * This file is part of the "news" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * TCA tree data provider which considers
 */
class DatabaseTreeDataProvider extends \TYPO3\CMS\Core\Tree\TableConfiguration\DatabaseTreeDataProvider
{

    public function getRootUid()
    {
        return $this->rootUid = $this->getRootCategoryId();
    }

    /**
     * Get tt_content record
     *
     * @param int $uid
     * @return array
     */
    protected function getContentElementRow($uid)
    {
        return BackendUtility::getRecord('tt_content', $uid);
    }

    /*
     * return integer $id
     */
    protected function getRootCategoryId()
    {
        $currentContentElement = $this->getContentElementRow($_REQUEST['uid']);
        $pageTsConfig = BackendUtility::getPagesTSconfig($currentContentElement['pid']);
        if (isset($pageTsConfig['tx_operations.']['categoryRootId']) && is_integer((int)$pageTsConfig['tx_operations.']['categoryRootId']) ) {
            $id = $pageTsConfig['tx_operations.']['categoryRootId'];
        } else {
            $id = 0;
        }
        return $id;
    }

}

<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Georg Ringer <typo3@ringerge.org>
*  (c) 2014 Karsten Nowak <captnnowi@gmx.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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
 * Update class for the extension manager.
 *
 * @package TYPO3
 * @subpackage tx_operations
 */
 
class ext_update {
	const STATUS_WARNING = -1;
	const STATUS_ERROR = 0;
	const STATUS_OK = 1;

	protected $messageArray = array();

	/**
	 * Main update function called by the extension manager.
	 *
	 * @return string
	 */
	public function main() {
		if (\TYPO3\CMS\Core\Utility\GeneralUtility::_POST('submit') != '') {
			$this->renameDatabaseTable('tx_operations_domain_model_resources', 'tx_operations_domain_model_resource');
			$this->renameDatabaseTable('tx_operations_operation_resources_mm', 'tx_operations_operation_resource_mm');
			return $this->generateOutput();
		} else {
			$tables = $GLOBALS['TYPO3_DB']->admin_get_tables();
			if (isset($tables['tx_operations_domain_model_resource']) && isset($tables['tx_operations_operation_resource_mm'])) {
				$content = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('update.NotNeeded', 'operations');
				return $content;
			} else {
				$content = $this->formular();
				return $content;
			}
		}
	}

	/**
		* The entry function
		* Return : TRUE: updatescript im Extension Manager verfügbar
		* FALSE: updatescript nicht verfügbar
		* @return bool
		*/
		public function access() {
			return TRUE;
		}

	/**
	* Shows a formular.
	*
	* @return  string
	*/

		protected function formular() {
			
			$ScriptWillDo = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('update.ScriptDo', 'operations');
			$Rename = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('update.Rename', 'operations');
			$Attention = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('update.Attention', 'operations');
			$Button = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('update.Button', 'operations');
			
			
			$oldTableNames = 'tx_operations_domain_model_resources, tx_operations_operation_resources_mm';
			return
			'<hr><form action="' . \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('REQUEST_URI') . '" method="POST">' .
			'<h3>'. $ScriptWillDo .'</h3>' .
			'<p>'. $Rename .' '.$oldTableNames.'.</p>' .
			'<p>'. $Attention .'</p>' .
			'<input type="submit" name="submit" value="'. $Button .'" /></form><hr>';
		}

	/**
	 * Rename db table
	 *
	 * @param string $oldTableName old table name
	 * @param string $newTableName new table name
	 * @return boolean
	 */
	protected function renameDatabaseTable($oldTableName, $newTableName) {
		$message = '';
		$status = NULL;
		$title = 'Renaming "' . $oldTableName . '" to "' . $newTableName . '" ';

		$tables = $GLOBALS['TYPO3_DB']->admin_get_tables();
		// ab TYPO3 6.2 vielleicht ?
		//$tables = \TYPO3\CMS\Core\Database\DatabaseConnection::admin_get_tables();
		if (isset($tables[$newTableName])) {
			$message = 'Table ' . $newTableName . ' already exists';
			$status = t3lib_FlashMessage::OK;
		} elseif(!isset($tables[$oldTableName])) {
			$message = 'Table ' . $oldTableName . ' does not exist';
			$status = t3lib_FlashMessage::ERROR;
		} else {
			$sql = 'RENAME TABLE ' . $oldTableName . ' TO ' . $newTableName . ';';

			if ($GLOBALS['TYPO3_DB']->admin_query($sql) === FALSE) {
			// ab TYPO3 6.2 vielleicht ?
			//if (\TYPO3\CMS\Core\Database\DatabaseConnection::admin_query($sql) === FALSE) {
				$message = ' SQL ERROR: ' .  $GLOBALS['TYPO3_DB']->sql_error();
				// ab TYPO3 6.2 vielleicht ?
				//$message = ' SQL ERROR: ' .  \TYPO3\CMS\Core\Database\DatabaseConnection::sql_error();
				$status = t3lib_FlashMessage::ERROR;
			} else {
				$message = 'OK!';
				$status = t3lib_FlashMessage::OK;
			}
		}

		$this->messageArray[] = array($status, $title, $message);
		return $status;
	}

	/**
	 * Generates output by using flash messages
	 *
	 * @return string
	 */
	protected function generateOutput() {
		$output = '';
		foreach ($this->messageArray as $messageItem) {
			$flashMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('t3lib_FlashMessage',$messageItem[2],$messageItem[1],$messageItem[0]);
			$output .= $flashMessage->render();
		}

		return $output;
	}

}
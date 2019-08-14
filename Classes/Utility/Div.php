<?php
namespace Kanow\Operations\Utility;

use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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

/**
 *
 * @package operations
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Div {

  /**
  * get part of TYPO3 version
	*
	* @param string $part part of array what is returned
  * @return integer
  */
	public static function getPartOfTypo3Version($part=NULL) {
		$part = ($part==NULL) ? 'main' : $part;
    $currentVersion = VersionNumberUtility::convertVersionStringToArray(VersionNumberUtility::getNumericTypo3Version());
    return $currentVersion['version_'.$part];
  }

  /**
  * get typeicon_classes for TCA in TYPO3 7
	*
	* @param string $identifier
  * @return array
  */
	public static function getTypeIconClasses($identifier) {
    $currentVersion = VersionNumberUtility::convertVersionStringToArray(VersionNumberUtility::getNumericTypo3Version());
		if( $currentVersion['version_main'] > 6) {
			$typeIconClasses = array(
				'default' => $identifier
			);
			return $typeIconClasses;
		}
    return;
  }


	/**
	* get wizard icon
	*
	* @param string $wizard which icon is needed
	* @param integer $version
	* @return string
	*/
	public static function getWizardIcon($wizard,$version) {
		$wizardIconPath = array();

		if($version < 7) {
			switch ($wizard) {
				case 'link':
					$wizardIconPath = 'link_popup.gif';
					break;
				case 'rte':
					$wizardIconPath = 'wizard_rte2.gif';
					break;
				case 'add':
					$wizardIconPath = 'add.gif';
					break;
				case 'edit':
					$wizardIconPath =  'edit2.gif';
					break;
			}
		} else {
			switch ($wizard) {
				case 'link':
					$wizardIconPath = 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_link.gif';
					break;
				case 'rte':
					$wizardIconPath = 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_rte.gif';
					break;
				case 'add':
					$wizardIconPath = 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif';
					break;
				case 'edit':
					$wizardIconPath = 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif';
					break;
			}
		}
		return $wizardIconPath;
	}

}

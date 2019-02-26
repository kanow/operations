<?php
namespace KN\Operations\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Karsten Nowak <captnnowi@gmx.de>
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
 *
 * @package operations
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ResourceController extends \KN\Operations\Controller\BaseController {

	/**
	 * resourceRepository
	 *
	 * @var \KN\Operations\Domain\Repository\ResourceRepository
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $resourceRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$resources = $this->resourceRepository->findAll();
		$this->view->assign('resources', $resources);
	}

	/**
	 * action show
	 *
	 * @param \KN\Operations\Domain\Model\Resources $resources
	 * @return void
	 */
	public function showAction(\KN\Operations\Domain\Model\Resource $resource) {
		$this->view->assign('resource', $resource);
	}
	
	


}
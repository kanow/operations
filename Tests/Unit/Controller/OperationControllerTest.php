<?php
namespace Kanow\Operations\Tests;
use Kanow\Operations\Controller\OperationController;
use Kanow\Operations\Domain\Model\Operation;
use Kanow\Operations\Domain\Repository\OperationRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophecy\ProphecySubjectInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Fluid\View\TemplateView;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

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
 * Test case for class Kanow\Operations\Controller\OperationController.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Operations
 *
 * @author Karsten Nowak <captnnowi@gmx.de>
 */
class OperationControllerTest extends UnitTestCase {

    use ProphecyTrait;

    /**
     * @var OperationController&MockObject&AccessibleObjectInterface
     */
    private $mockedOperation;

    /**
     * @var ObjectProphecy<TemplateView>
     */
    private $viewProphecy;

    /**
     * @var ObjectProphecy<OperationRepository>
     */
    private $operationRepositoryProphecy;

	protected function setUp(): void {
		parent::setUp();

        $this->mockedOperation = $this->getAccessibleMock(OperationController::class,['forward', 'redirect', 'redirectToUri']);

        $this->viewProphecy = $this->prophesize(TemplateView::class);
        $view = $this->viewProphecy->reveal();
        $this->mockedOperation->_set('view', $view);

        $this->operationRepositoryProphecy = $this->prophesize(OperationRepository::class);
        /** @var OperationRepository&ProphecySubjectInterface $operationRepository */
        $operationRepository = $this->operationRepositoryProphecy->reveal();
        $this->mockedOperation->injectOperationRepository($operationRepository);

	}

	/**
	 * @test
	 */
	public function isActionController(): void
    {
		self::assertInstanceOf(ActionController::class, $this->mockedOperation);
	}

    /**
     * @test
     */
    public function showActionAssignsPassedOperationToView(): void
    {
        $operation = new Operation();
        $this->viewProphecy->assign('operation', $operation)->shouldBeCalled();

        $this->mockedOperation->showAction($operation);
    }

}
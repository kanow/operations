<?php

namespace Kanow\Operations\Tests;

use Kanow\Operations\Controller\OperationController;
use Kanow\Operations\Domain\Model\Operation;
use Kanow\Operations\Domain\Repository\CategoryRepository;
use Kanow\Operations\Domain\Repository\OperationRepository;
use Kanow\Operations\Domain\Repository\TypeRepository;
use Kanow\Operations\Service\CategoryService;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
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
 *
 * @author Karsten Nowak <captnnowi@gmx.de>
 */
class OperationControllerTest extends UnitTestCase
{
    /**
     * @var OperationController&MockObject&AccessibleObjectInterface
     */
    private OperationController $subject;

    /**
     * @var TemplateView&MockObject
     */
    private TemplateView $viewMock;

    /**
     * @var OperationRepository&MockObject
     */
    private OperationRepository $operationRepositoryMock;

    /**
     * @var TypeRepository&MockObject
     */
    private TypeRepository $typeRepositoryMock;

    /**
     * @var CategoryRepository&MockObject
     */
    private CategoryRepository $categoryRepositoryMock;
    /**
     * @var CategoryService
     */
    private CategoryService $categoryServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->operationRepositoryMock = $this->createMock(OperationRepository::class);
        $this->typeRepositoryMock = $this->createMock(TypeRepository::class);
        $this->categoryRepositoryMock = $this->createMock(CategoryRepository::class);
        $this->categoryServiceMock = $this->createMock(CategoryService::class);

        // We need to create an accessible mock in order to be able to set the protected `view`.
        $methodsToMock = ['htmlResponse', 'redirect', 'redirectToUri'];
        if ((new Typo3Version())->getMajorVersion() <= 11) {
            $methodsToMock[] = 'forward';
        }
        $this->subject = $this->getAccessibleMock(OperationController::class, $methodsToMock, [
            $this->operationRepositoryMock,
            $this->typeRepositoryMock,
            $this->categoryRepositoryMock,
            $this->categoryServiceMock,
        ]);

        $this->viewMock = $this->createMock(TemplateView::class);
        $this->subject->_set('view', $this->viewMock);

        $this->operationRepositoryMock = $this->getMockBuilder(OperationRepository::class)->disableOriginalConstructor()->getMock();

        $responseMock = $this->createMock(HtmlResponse::class);
        $this->subject->method('htmlResponse')->willReturn($responseMock);
    }

    /**
     * @test
     */
    public function isActionController(): void
    {
        self::assertInstanceOf(ActionController::class, $this->subject);
    }

    /**
     * @test
     */
    public function showActionAssignsPassedOperationToView(): void
    {
        $operation = new Operation();
        $this->viewMock->expects(self::once())->method('assign')->with('operation', $operation);

        $this->subject->showAction($operation);
    }
}

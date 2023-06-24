<?php
namespace Kanow\Operations\Tests;
use Kanow\Operations\Controller\ResourceController;
use Kanow\Operations\Domain\Model\Resource;
use Kanow\Operations\Domain\Repository\ResourceRepository;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Information\Typo3Version;
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
 * Test case for class Kanow\Operations\Controller\ResourceController.
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
class ResourceControllerTest extends UnitTestCase {

    /**
     * @var ResourceController&MockObject&AccessibleObjectInterface
     */
    private ResourceController $subject;

    /**
     * @var TemplateView&MockObject
     */
    private TemplateView $viewMock;

    /**
     * @var ResourceRepository&MockObject
     */
    private ResourceRepository $resourceRepositoryMock;

    protected function setUp(): void {
        parent::setUp();

        // We need to create an accessible mock in order to be able to set the protected `view`.
        $methodsToMock = ['htmlResponse', 'redirect', 'redirectToUri'];
        if ((new Typo3Version())->getMajorVersion() <= 11) {
            $methodsToMock[] = 'forward';
        }
        $this->subject = $this->getAccessibleMock(ResourceController::class, $methodsToMock);

        $this->viewMock = $this->createMock(TemplateView::class);
        $this->subject->_set('view', $this->viewMock);

        $this->resourceRepositoryMock = $this->getMockBuilder(ResourceRepository::class)->disableOriginalConstructor()->getMock();
        $this->subject->injectResourceRepository($this->resourceRepositoryMock);

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
    public function listActionAssignsAllResourceAsResourcesToView(): void
    {
        $resources = $this->createMock(QueryResultInterface::class);
        $this->resourceRepositoryMock->method('findAll')->willReturn($resources);
        $this->viewMock->expects(self::once())->method('assign')->with('resources', $resources);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsPassedResourceToView(): void
    {
        $resource = new Resource();
        $this->viewMock->expects(self::once())->method('assign')->with('resource', $resource);

        $this->subject->showAction($resource);
    }

}
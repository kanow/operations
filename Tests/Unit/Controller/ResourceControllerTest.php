<?php
namespace Kanow\Operations\Tests;
use Kanow\Operations\Controller\ResourceController;
use Kanow\Operations\Domain\Model\Resource;
use Kanow\Operations\Domain\Repository\ResourceRepository;
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

    use ProphecyTrait;

    /**
     * @var ResourceController&MockObject&AccessibleObjectInterface
     */
    private $mockedResource;

    /**
     * @var ObjectProphecy<TemplateView>
     */
    private $viewProphecy;

    /**
     * @var ObjectProphecy<ResourceRepository>
     */
    private $resourceRepositoryProphecy;

    protected function setUp(): void {
        parent::setUp();

        $this->mockedResource = $this->getAccessibleMock(ResourceController::class,['forward', 'redirect', 'redirectToUri']);

        $this->viewProphecy = $this->prophesize(TemplateView::class);
        $view = $this->viewProphecy->reveal();
        $this->mockedResource->_set('view', $view);

        $this->resourceRepositoryProphecy = $this->prophesize(ResourceRepository::class);
        /** @var ResourceRepository&ProphecySubjectInterface $resourceRepository */
        $resourceRepository = $this->resourceRepositoryProphecy->reveal();
        $this->mockedResource->injectResourceRepository($resourceRepository);

    }

    /**
     * @test
     */
    public function isActionController(): void
    {
        self::assertInstanceOf(ActionController::class, $this->mockedResource);
    }

    /**
     * @test
     */
    public function listActionAssignsAllResourceAsResourcesToView(): void
    {
        $resources = $this->prophesize(QueryResultInterface::class)->reveal();
        $this->resourceRepositoryProphecy->findAll()->willReturn($resources);
        $this->viewProphecy->assign('resources', $resources)->shouldBeCalled();

        $this->mockedResource->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsPassedResourceToView(): void
    {
        $resource = new Resource();
        $this->viewProphecy->assign('resource', $resource)->shouldBeCalled();

        $this->mockedResource->showAction($resource);
    }

}
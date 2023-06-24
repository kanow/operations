<?php
namespace Kanow\Operations\Tests;
use Kanow\Operations\Controller\VehicleController;
use Kanow\Operations\Domain\Model\Vehicle;
use Kanow\Operations\Domain\Repository\VehicleRepository;
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
 * Test case for class Kanow\Operations\Controller\VehicleController.
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
class VehicleControllerTest extends UnitTestCase {
    /**
     * @var VehicleController&MockObject&AccessibleObjectInterface
     */
    private VehicleController $subject;

    /**
     * @var TemplateView&MockObject
     */
    private TemplateView $viewMock;

    /**
     * @var VehicleRepository&MockObject
     */
    private VehicleRepository $vehicleRepositoryMock;

    protected function setUp(): void {
        parent::setUp();

        // We need to create an accessible mock in order to be able to set the protected `view`.
        $methodsToMock = ['htmlResponse', 'redirect', 'redirectToUri'];
        if ((new Typo3Version())->getMajorVersion() <= 11) {
            $methodsToMock[] = 'forward';
        }
        $this->subject = $this->getAccessibleMock(VehicleController::class, $methodsToMock);

        $this->viewMock = $this->createMock(TemplateView::class);
        $this->subject->_set('view', $this->viewMock);

        $this->vehicleRepositoryMock = $this->getMockBuilder(VehicleRepository::class)->disableOriginalConstructor()->getMock();
        $this->subject->injectVehicleRepository($this->vehicleRepositoryMock);

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
    public function listActionAssignsAllVehicleAsVehiclesToView(): void
    {
        $vehicles = $this->createMock(QueryResultInterface::class);
        $this->vehicleRepositoryMock->method('findAll')->willReturn($vehicles);
        $this->viewMock->expects(self::once())->method('assign')->with('vehicles', $vehicles);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsPassedVehicleToView(): void
    {
        $vehicle = new Vehicle();
        $this->viewMock->expects(self::once())->method('assign')->with('vehicle', $vehicle);

        $this->subject->showAction($vehicle);
    }

}
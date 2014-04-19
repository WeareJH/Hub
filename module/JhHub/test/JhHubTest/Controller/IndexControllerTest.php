<?php

namespace JhHubTest\Controller;
use JhHub\Controller\IndexController;

/**
 * Class IndexControllerTest
 * @package JhUserTest\Controller
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IndexController
     */
    protected $controller;

    public function setUp()
    {
        $this->controller = new IndexController();
    }

    public function testDashBoardActionReturnsEmptyViewModel()
    {
        $result = $this->controller->dashboardAction();
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertCount(0, $result);
    }
}

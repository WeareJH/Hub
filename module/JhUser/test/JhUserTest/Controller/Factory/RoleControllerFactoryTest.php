<?php

namespace JhUserTest\Controller\Factory;

use JhUser\Controller\Factory\RoleControllerFactory;
use Zend\Mvc\Controller\PluginManager;

/**
 * Class RoleControllerFactoryTest
 * @package JhTimeTest\Controller\Factory
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class RoleControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryProcessesWithoutErrors()
    {

        $services = array(
            'JhUser\ObjectManager'                  => $this->getMock('Doctrine\Common\Persistence\ObjectManager'),
            'JhUser\Repository\UserRepository'      => $this->getMock('JhUser\Repository\UserRepositoryInterface'),
            'JhUser\Repository\RoleRepository'      => $this->getMock('JhUser\Repository\RoleRepositoryInterface'),
        );

        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocator
            ->expects($this->any())
            ->method('get')
            ->will(
                $this->returnCallback(
                    function ($serviceName) use ($services) {
                        return $services[$serviceName];
                    }
                )
            );

        $controllerPluginManager = new PluginManager();
        $controllerPluginManager->setServiceLocator($serviceLocator);

        $factory = new RoleControllerFactory();
        $this->assertInstanceOf('JhUser\Controller\RoleController', $factory->createService($controllerPluginManager));
    }
} 
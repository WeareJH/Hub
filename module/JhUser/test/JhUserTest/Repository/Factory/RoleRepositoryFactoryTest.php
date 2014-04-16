<?php

namespace JhUserTest\Repository\Factory;

use JhUser\Repository\Factory\RoleRepositoryFactory;
/**
 * Class RoleRepositoryFactoryTest
 * @package JhUserTest\Repository\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleRepositoryFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryReturnsRepositoryFromObjectManager()
    {
        $objectManager    = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $serviceLocator   = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $objectManager
            ->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo('JhUser\Entity\Role'))
            ->will($this->returnValue($objectRepository));
        $serviceLocator
            ->expects($this->any())
            ->method('get')
            ->with('JhUser\ObjectManager')
            ->will($this->returnValue($objectManager));

        $factory = new RoleRepositoryFactory();

        $this->assertInstanceOf('JhUser\Repository\RoleRepository', $factory->createService($serviceLocator));
    }
}
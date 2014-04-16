<?php

namespace JhUserTest\Repository\Factory;

use JhUser\Repository\Factory\UserRepositoryFactory;
/**
 * Class UserRepositoryFactoryTest
 * @package JhUserTest\Repository\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class UserRepositoryFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryReturnsRepositoryFromObjectManager()
    {
        $objectManager    = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $serviceLocator   = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $objectManager
            ->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo('JhUser\Entity\User'))
            ->will($this->returnValue($objectRepository));
        $serviceLocator
            ->expects($this->any())
            ->method('get')
            ->with('JhUser\ObjectManager')
            ->will($this->returnValue($objectManager));

        $factory = new UserRepositoryFactory();

        $this->assertInstanceOf('JhUser\Repository\UserRepository', $factory->createService($serviceLocator));
    }
}
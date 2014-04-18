<?php

namespace JhUserTest;

use JhUser\Entity\Role;
use JhUser\Entity\User;
use Zend\ServiceManager\ServiceManager;
use JhUser\Module;

/**
 * Class ModuleTest
 * @package JhUserTest
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Zend\Mvc\Application
     */
    protected $application;

    /**
     * @var \Zend\EventManager\EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var \Zend\EventManager\SharedEventManagerInterface
     */
    protected $sharedEventManager;

    public function testGetConfig()
    {
        $module = new Module();

        $this->assertInternalType('array', $module->getConfig());
        $this->assertSame($module->getConfig(), unserialize(serialize($module->getConfig())), 'Config is serializable');
    }

    public function testDependency()
    {
        $module = new Module();
        $dependencies = [
            'DoctrineModule',
            'DoctrineORMModule',
            'ZfcUser',
            'ZfcUserDoctrineORM',
            'ScnSocialAuthDoctrineORM',
        ];
        $this->assertEquals($dependencies, $module->getModuleDependencies());
    }

    public function testConsoleUsage()
    {
        $mockConsole = $this->getMock('Zend\Console\Adapter\AdapterInterface');
        $module = new Module();

        $expected = ['set role <userEmail> <role>'   => 'Set a user\'s role'];
        $this->assertSame($expected, $module->getConsoleUsage($mockConsole));
    }

    public function testListenersAreRegistered()
    {
        $event = $this->getEvent(true);

        $module = new Module();
        $this->sharedEventManager
             ->expects($this->at(0))
             ->method('attach')
             ->with('ScnSocialAuth\Authentication\Adapter\HybridAuth', 'registerViaProvider', array($module, 'onRegister'));

        $this->sharedEventManager
             ->expects($this->at(1))
             ->method('attach')
             ->with('ZfcUser\Service\User', 'register', array($module, 'onRegister'));

        $module->onBootstrap($event);
    }

    public function testOnRegisterSuccessfullyAddsDefaultRole()
    {
        $event              = $this->getEvent();
        $mockObjectManager  = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $serviceLocator     = new ServiceManager();
        $serviceLocator->setService('JhUser\ObjectManager', $mockObjectManager);
        $this->application->expects($this->any())
            ->method('getServiceManager')
            ->will($this->returnValue($serviceLocator));

        $role = new Role();
        $roleRepository = $this->getMock('JhUser\Repository\RoleRepositoryInterface');
        $roleRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['roleId' => 'user'])
            ->will($this->returnValue($role));

        $mockObjectManager
            ->expects($this->once())
            ->method('getRepository')
            ->with('JhUser\Entity\Role')
            ->will($this->returnValue($roleRepository));

        $mockObjectManager
            ->expects($this->once())
            ->method('flush');

        $user = $this->getMock('JhUser\Entity\User');
        $user
            ->expects($this->once())
            ->method('addRole')
            ->with($role)
            ->will($this->returnSelf());

        $event
            ->expects($this->once())
            ->method('getParam')
            ->with('user')
            ->will($this->returnValue($user));


        $module = new Module();
        $module->onRegister($event);
    }

    /**
     * @param bool $addEventManager
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getEvent($addEventManager = false)
    {

        $this->eventManager         = $this->getMock('Zend\EventManager\EventManagerInterface');
        $this->sharedEventManager   = $this->getMock('Zend\EventManager\SharedEventManagerInterface');
        $this->application          = $this->getMock('Zend\Mvc\Application', [], [], '', false);

        if($addEventManager) {
            $this->application->expects($this->any())
                ->method('getEventManager')
                ->will($this->returnValue($this->eventManager));

            $this->eventManager
                ->expects($this->once())
                ->method('getSharedManager')
                ->will($this->returnValue($this->sharedEventManager));
        }

        $event = $this->getMock('Zend\EventManager\EventInterface');
        $event->expects($this->any())->method('getTarget')->will($this->returnValue($this->application));

        return $event;
    }
}

<?php

namespace JhUserTest\Controller;

use JhUser\Entity\User;
use JhUser\Entity\Role;
use Zend\Console\Request;
use Zend\Http\Request as HttpRequest;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;

/**
 * Class RoleControllerTest
 * @package JhUserTest\Controller
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleControllerTest extends AbstractConsoleControllerTestCase
{

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Role
     */
    protected $role;


    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . "/../../TestConfiguration.php.dist"
        );
        parent::setUp();
    }

    public function testUsersRoleCanBeSet()
    {
        $email  = 'aydin@hotmail.co.uk';
        $roleId = 'admin';

        $this->configureMocks($email, $roleId);

        $this->dispatch(new Request(array('scriptname.php', "set role $email  $roleId")));

        $this->assertResponseStatusCode(0);
        $this->assertModuleName('jhuser');
        $this->assertControllerName('jhuser\controller\role');
        $this->assertControllerClass('rolecontroller');
        $this->assertActionName('set-role');
        $this->assertMatchedRouteName('set-role');

        $this->assertCount(1, $this->user->getRoles());
        $this->assertSame($this->user->getRoles()->first(), $this->role);
    }

    public function testUsersRoleCanBeModified()
    {
        $email  = 'aydin@hotmail.co.uk';
        $roleId = 'admin';

        $this->configureMocks($email, $roleId);
        $role = new Role;
        $role->setRoleId('user');
        $this->user->addRole($role);


        $this->dispatch(new Request(array('scriptname.php', "set role $email  $roleId")));

        $this->assertResponseStatusCode(0);
        $this->assertModuleName('jhuser');
        $this->assertControllerName('jhuser\controller\role');
        $this->assertControllerClass('rolecontroller');
        $this->assertActionName('set-role');
        $this->assertMatchedRouteName('set-role');

        $this->assertCount(1, $this->user->getRoles());
        $this->assertSame($this->user->getRoles()->first(), $this->role);
    }

    public function configureMocks($userEmail, $roleId)
    {
        $userRepoMock       = $this->getMock('JhUser\Repository\UserRepositoryInterface');
        $roleRepoMock       = $this->getMock('JhUser\Repository\RoleRepositoryInterface');
        $objectManagerMock  = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $this->user = new User();
        $this->user->setEmail($userEmail);

        $userRepoMock
            ->expects($this->once())
            ->method('findOneByEmail')
            ->with($userEmail)
            ->will($this->returnValue($this->user));

        $this->role = new Role();
        $this->role->setRoleId($roleId);

        $roleRepoMock
            ->expects($this->once())
            ->method('findByRoleId')
            ->with($roleId)
            ->will($this->returnValue($this->role));

        $objectManagerMock
            ->expects($this->once())
            ->method('flush');

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('JhUser\Repository\UserRepository', $userRepoMock);
        $serviceManager->setService('JhUser\Repository\RoleRepository', $roleRepoMock);
        $serviceManager->setService('JhUser\ObjectManager', $objectManagerMock);
    }


    public function testExceptionIsThrownIfRoleNotExists()
    {
        $email  = 'aydin@hotmail.co.uk';
        $roleId = 'admin';

        $userRepoMock       = $this->getMock('JhUser\Repository\UserRepositoryInterface');
        $roleRepoMock       = $this->getMock('JhUser\Repository\RoleRepositoryInterface');
        $objectManagerMock  = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $user = new User();
        $user->setEmail($email);

        $userRepoMock
            ->expects($this->once())
            ->method('findOneByEmail')
            ->with($email)
            ->will($this->returnValue($user));

        $roleRepoMock
            ->expects($this->once())
            ->method('findByRoleId')
            ->with($roleId)
            ->will($this->returnValue(null));

        $objectManagerMock->expects($this->never())->method('flush');

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('JhUser\Repository\UserRepository', $userRepoMock);
        $serviceManager->setService('JhUser\Repository\RoleRepository', $roleRepoMock);
        $serviceManager->setService('JhUser\ObjectManager', $objectManagerMock);

        $this->dispatch(new Request(array('scriptname.php', "set role $email  $roleId")));
        $this->assertResponseStatusCode(1);
        $this->assertModuleName('jhuser');
        $this->assertControllerName('jhuser\controller\role');
        $this->assertControllerClass('rolecontroller');
        $this->assertActionName('set-role');
        $this->assertMatchedRouteName('set-role');
        $this->assertApplicationException('RuntimeException', sprintf('Role: "%s" could not be found', $roleId));
    }

    public function testExceptionIsThrownIfUserNotExists()
    {
        $email  = 'aydin@hotmail.co.uk';
        $roleId = 'admin';

        $userRepoMock       = $this->getMock('JhUser\Repository\UserRepositoryInterface');
        $roleRepoMock       = $this->getMock('JhUser\Repository\RoleRepositoryInterface');
        $objectManagerMock  = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $userRepoMock
            ->expects($this->once())
            ->method('findOneByEmail')
            ->with($email)
            ->will($this->returnValue(null));

        $roleRepoMock->expects($this->never())->method('findByRoleId');
        $objectManagerMock->expects($this->never())->method('flush');

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('JhUser\Repository\UserRepository', $userRepoMock);
        $serviceManager->setService('JhUser\Repository\RoleRepository', $roleRepoMock);
        $serviceManager->setService('JhUser\ObjectManager', $objectManagerMock);

        $this->dispatch(new Request(array('scriptname.php', "set role $email  $roleId")));
        $this->assertResponseStatusCode(1);
        $this->assertModuleName('jhuser');
        $this->assertControllerName('jhuser\controller\role');
        $this->assertControllerClass('rolecontroller');
        $this->assertActionName('set-role');
        $this->assertMatchedRouteName('set-role');
        $this->assertApplicationException('RuntimeException', sprintf('User with email: "%s" could not be found', $email));
    }
}

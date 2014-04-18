<?php

namespace JhUserTest\Repository;

use JhUserTest\Util\ServiceManagerFactory;
use JhUserTest\Fixture\SingleRole;
use JhUserTest\Fixture\MultipleRole;

/**
 * Class RoleRepositoryTest
 * @package JhUserTest\Repository
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Doctrine\Common\DataFixtures\Executor\AbstractExecutor
     */
    protected $fixtureExectutor;

    /**
     * @var \JhUser\Repository\RoleRepository
     */
    protected $repository;

    public function setUp()
    {
        $sm = ServiceManagerFactory::getServiceManager();
        $this->repository = $sm->get('JhUser\Repository\RoleRepository');
        $this->fixtureExectutor = $sm->get('Doctrine\Common\DataFixtures\Executor\AbstractExecutor');
        $this->assertInstanceOf('JhUser\Repository\RoleRepository', $this->repository);
    }

    public function testGetAllRoles()
    {
        $role = new SingleRole();
        $this->fixtureExectutor->execute(array($role));

        $this->assertCount(1, $this->repository->findAll());
    }

    public function testGetAllRolesWithPagination()
    {
        $role = new SingleRole();
        $this->fixtureExectutor->execute(array($role));

        $this->assertCount(1, $this->repository->findAll(true));
    }

    public function testFindByRoleIdReturnsNullIfNotExists()
    {
        $this->assertNull($this->repository->findByRoleId("super-admin"));
    }

    public function testFindByRoleIdReturnsRoleIfExists()
    {
        $role = new SingleRole();
        $this->fixtureExectutor->execute(array($role));
        $result = $this->repository->findByRoleId($role->getRole()->getRoleId());
        $this->assertInstanceOf('JhUser\Entity\Role', $result);
        $this->assertSame($role->getRole()->getParent(), $result->getParent());
        $this->assertSame($role->getRole()->getRoleId(), $result->getRoleId());
        $this->assertSame($role->getRole()->getId(), $result->getId());
    }

    public function testFindOneByReturnsNullIfNotExists()
    {
        $this->assertNull($this->repository->findOneBy(array("roleId" => "super-admin")));
    }

    public function testFindOneByReturnsRoleIfExists()
    {
        $role = new SingleRole();
        $this->fixtureExectutor->execute(array($role));
        $result = $this->repository->findOneBy(array("roleId" => "admin"));
        $this->assertInstanceOf('JhUser\Entity\Role', $result);
        $this->assertSame($role->getRole()->getParent(), $result->getParent());
        $this->assertSame($role->getRole()->getRoleId(), $result->getRoleId());
        $this->assertSame($role->getRole()->getId(), $result->getId());
    }

    public function testFindByReturnsEmptyIfNonExist()
    {
        $this->assertEmpty($this->repository->findBy(array('roleId' => 'admin')));
    }

    public function testFindByReturnsCollectionIfExist()
    {
        $this->assertEmpty($this->repository->findBy(array('roleId' => 'user')));

        $roles = new MultipleRole();
        $this->fixtureExectutor->execute(array($roles));
        $result = $this->repository->findBy(array("parent" => $roles->getParent()));
        $this->assertSame(count($roles->getRoles()), count($result));
    }

    public function testFindById()
    {
        $role = new SingleRole();
        $this->fixtureExectutor->execute(array($role));
        $result = $this->repository->find($role->getRole()->getId());
        $this->assertInstanceOf('JhUser\Entity\Role', $result);
        $this->assertSame($role->getRole()->getParent(), $result->getParent());
        $this->assertSame($role->getRole()->getRoleId(), $result->getRoleId());
        $this->assertSame($role->getRole()->getId(), $result->getId());
    }

    public function testGetClass()
    {
        $this->assertSame('JhUser\Entity\Role', $this->repository->getClassName());
    }
}

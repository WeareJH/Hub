<?php

namespace JhUserTest\Repository;

use JhUserTest\Util\ServiceManagerFactory;
use JhUserTest\Fixture\SingleUser;
use JhUserTest\Fixture\MultipleUser;

/**
 * Class UserRepositoryTest
 * @package JhUserTest\Repository
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class UserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Doctrine\Common\DataFixtures\Executor\AbstractExecutor
     */
    protected $fixtureExectutor;

    /**
     * @var \JhUser\Repository\UserRepository
     */
    protected $repository;

    public function setUp()
    {
        $sm = ServiceManagerFactory::getServiceManager();
        $this->repository = $sm->get('JhUser\Repository\UserRepository');
        $this->fixtureExectutor = $sm->get('Doctrine\Common\DataFixtures\Executor\AbstractExecutor');
        $this->assertInstanceOf('JhUser\Repository\UserRepository', $this->repository);
    }

    public function testGetAllUsers()
    {
        $user = new SingleUser();
        $this->fixtureExectutor->execute(array($user));

        $this->assertCount(1, $this->repository->findAll());
    }

    public function testGetAllUsersWithPagination()
    {
        $user = new SingleUser();
        $this->fixtureExectutor->execute(array($user));

        $this->assertCount(1, $this->repository->findAll(true));
    }

    public function testFindOneByEmailReturnsNullIfNotExists()
    {
        $this->assertNull($this->repository->findOneByEmail("aydin@hotmail.co.uk"));
    }

    public function testFindOneByEmailReturnsUserIfExists()
    {
        $user = new SingleUser();
        $this->fixtureExectutor->execute(array($user));
        $result = $this->repository->findOneByEmail($user->getUser()->getEmail());
        $this->assertInstanceOf('JhUser\Entity\User', $result);
        $this->assertSame($user->getUser()->getEmail(), $result->getEmail());
        $this->assertSame($user->getUser()->getPassword(), $result->getPassword());
        $this->assertSame($user->getUser()->getId(), $result->getId());
    }

    public function testFindOneByReturnsNullIfNotExists()
    {
        $this->assertNull($this->repository->findOneBy(array("email" => "aydin@hotmail.co.uk")));
    }

    public function testFindOneByReturnsUserIfExists()
    {
        $user = new SingleUser();
        $this->fixtureExectutor->execute(array($user));
        $result = $this->repository->findOneBy(array("email" => "aydin@hotmail.co.uk"));
        $this->assertInstanceOf('JhUser\Entity\User', $result);
        $this->assertSame($user->getUser()->getEmail(), $result->getEmail());
        $this->assertSame($user->getUser()->getPassword(), $result->getPassword());
        $this->assertSame($user->getUser()->getId(), $result->getId());
    }

    public function testFindByReturnsEmptyIfNonExist()
    {
        $this->assertEmpty($this->repository->findBy(array('email' => 'aydin@hotmail.co.uk')));
    }

    public function testFindByReturnsCollectionIfExist()
    {
        $this->assertEmpty($this->repository->findBy(array('email' => 'aydin@hotmail.co.uk')));

        $users = new MultipleUser();
        $this->fixtureExectutor->execute(array($users));
        $result = $this->repository->findBy(array("password" => 'p$ssw0rd'));
        $this->assertSame(count($users->getUsers()), count($result));
    }

    public function testFindById()
    {
        $user = new SingleUser();
        $this->fixtureExectutor->execute(array($user));
        $result = $this->repository->find($user->getUser()->getId());
        $this->assertInstanceOf('JhUser\Entity\User', $result);
        $this->assertSame($user->getUser()->getEmail(), $result->getEmail());
        $this->assertSame($user->getUser()->getPassword(), $result->getPassword());
        $this->assertSame($user->getUser()->getId(), $result->getId());
    }

    public function testGetClass()
    {
        $this->assertSame('JhUser\Entity\User', $this->repository->getClassName());
    }
}

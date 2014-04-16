<?php

namespace JhUserTest\Repository;

use JhUserTest\Util\ServiceManagerFactory;
use JhUser\Repository\UserRepository;
use JhUserTest\Fixture\User;

class UserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Doctrine\Common\DataFixtures\Executor\AbstractExecutor
     */
    protected $fixtureExectutor;

    /**
     * @var PageRepository
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
        $user = new User();
        $this->fixtureExectutor->execute(array($user));
        $this->assertEmpty($this->repository->getRootPages());

        $this->assertCount(1, $this->repository->findAll());
    }
} 
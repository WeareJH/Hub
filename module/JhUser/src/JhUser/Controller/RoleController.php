<?php

namespace JhUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Doctrine\ORM\EntityManager;
use JhUser\Repository\UserRepository;
use JhUser\Repository\RoleRepository;

/**
 * Class RoleController
 * @package JhUser\Controller
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class RoleController extends AbstractActionController
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \JhUser\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * @var \JhUser\Repository\RoleRepository
     */
    protected $roleRepository;

    /**
     * @param EntityManager $entityManager
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        EntityManager $entityManager,
        UserRepository $userRepository,
        RoleRepository $roleRepository
    ) {
        $this->entityManager    = $entityManager;
        $this->userRepository   = $userRepository;
        $this->roleRepository   = $roleRepository;
    }

    /**
     * Set a Users role,
     * Removes all existing roles
     *
     * @throws \RuntimeException
     */
    public function setRoleAction()
    {
        $request = $this->getRequest();
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $email  = $request->getParam('userEmail');
        $roleId = $request->getParam('role');

        $user   = $this->userRepository->findOneByEmail($email);

        if (!$user) {
            throw new \RuntimeException(sprintf('User with email: "%s" could not be found', $email));
        }

        $newRole = $this->roleRepository->findByRoleId($roleId);

        if (!$newRole) {
            throw new \RuntimeException(sprintf('Role: "%s" could not be found', $roleId));
        }

        foreach ($user->getRoles() as $role) {
            $user->getRoles()->removeElement($role);
        }

        $user->addRole($newRole);
        $this->entityManager->flush();
    }
}

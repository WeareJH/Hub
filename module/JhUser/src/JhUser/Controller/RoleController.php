<?php

namespace JhUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Doctrine\Common\Persistence\ObjectManager;
use JhUser\Repository\UserRepositoryInterface;
use JhUser\Repository\RoleRepositoryInterface;

/**
 * Class RoleController
 * @package JhUser\Controller
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class RoleController extends AbstractActionController
{

    /**
     * @var \ObjectManager
     */
    protected $objectManager;

    /**
     * @var \JhUser\Repository\UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var \JhUser\Repository\RoleRepositoryInterface
     */
    protected $roleRepository;

    /**
     * @param ObjectManager $objectManager
     * @param UserRepositoryInterface $userRepository
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->objectManager    = $objectManager;
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
        $this->objectManager->flush();
    }
}

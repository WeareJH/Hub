<?php

namespace JhHub\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use JhUser\Repository\UserRepositoryInterface;
use ZfcRbac\Exception\UnauthorizedException;

/**
 * Class UserRestController
 * @package JhHub\Controller
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class UserRestController extends AbstractRestfulController
{
    /**
     * @var \JhUser\Repository\UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws UnauthorizedException
     * @return JsonModel
     */
    public function getList()
    {
        if (!$this->isGranted('user.list')) {
            throw new UnauthorizedException("Not Allowed!");
        }

        $users = $this->userRepository->findAll(false);

        return new JsonModel([
            'users'  => $users,
        ]);
    }
}

<?php

namespace JhUser\Repository\Factory;

use JhUser\Repository\UserRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserRepositoryFactory
 * @package JhUser\Repository\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class UserRepositoryFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UserRepository(
            $serviceLocator->get('Doctrine\ORM\EntityManager')->getRepository('JhUser\Entity\User')
        );
    }
}
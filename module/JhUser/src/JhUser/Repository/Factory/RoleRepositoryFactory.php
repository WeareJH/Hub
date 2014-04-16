<?php

namespace JhUser\Repository\Factory;

use JhUser\Repository\RoleRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RoleRepositoryFactory
 * @package JhUser\Repository\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleRepositoryFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return RoleRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RoleRepository(
            $serviceLocator->get('JhUser\ObjectManager')->getRepository('JhUser\Entity\Role')
        );
    }
}

<?php

namespace JhUser\Controller\Factory;

use JhUser\Controller\RoleController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Role controller Factory
 *
 * Class RoleRepositoryFactory
 * @package JhUser\Controller\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return RoleController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        //get parent locator
        $serviceLocator = $serviceLocator->getServiceLocator();

        return new RoleController(
            $serviceLocator->get('JhUser\ObjectManager'),
            $serviceLocator->get('JhUser\Repository\UserRepository'),
            $serviceLocator->get('JhUser\Repository\RoleRepository')
        );
    }
}

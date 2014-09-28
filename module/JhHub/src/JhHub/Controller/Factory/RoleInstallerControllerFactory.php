<?php

namespace JhHub\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use JhHub\Controller\RoleInstallerController;

/**
 * Class RoleInstallerControllerFactory
 * @package JhHub\Controller\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleInstallerControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return InstallController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        //get parent locator
        $serviceLocator = $serviceLocator->getServiceLocator();

        return new RoleInstallerController(
            $serviceLocator->get('Console'),
            $serviceLocator->get('JhHub\Installer\RoleInstaller')
        );
    }
}

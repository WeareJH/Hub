<?php

namespace JhHub\Controller\Factory;

use JhHub\Controller\InstallController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class InstallControllerFactory
 * @package JhHub\Controller\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class InstallControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return InstallController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        //get parent locator
        $serviceLocator = $serviceLocator->getServiceLocator();

        return new InstallController(
            $serviceLocator->get('JhHub\Install\Installer'),
            $serviceLocator->get('Console')
        );
    }
}

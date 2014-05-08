<?php

namespace JhHub\Install\Factory;

use JhHub\Install\Installer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class InstallerFactory
 * @package JhHub\Install\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class InstallerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Installer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Installer(
            $serviceLocator->get('ModuleManager')
        );
    }
}

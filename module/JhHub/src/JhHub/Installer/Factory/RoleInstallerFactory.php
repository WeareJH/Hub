<?php

namespace JhHub\Installer\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use JhHub\Installer\RoleInstaller;
use Zend\Console\Console;

/**
 * Class RoleInstallerFactory
 * @package JhHub\Installer\Factory
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleInstallerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return InstallController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $roleConfig = array();

        if (isset($config['jh_hub']['roles'])) {
            $roleConfig = $config['jh_hub']['roles'];
        }

        return new RoleInstaller(
            $roleConfig,
            $serviceLocator->get('JhUser\Repository\RoleRepository'),
            $serviceLocator->get('JhUser\Repository\PermissionRepository'),
            $serviceLocator->get('JhHub\ObjectManager')
        );
    }
}

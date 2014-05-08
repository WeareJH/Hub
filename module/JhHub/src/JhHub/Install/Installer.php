<?php

namespace JhHub\Install;

use Zend\Console\ColorInterface as Color;
use Zend\ModuleManager\ModuleManager;
use Zend\Console\Adapter\AdapterInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Installer implements ServiceLocatorAwareInterface
{
    protected $moduleManager;

    protected $serviceLocator;

    public function __construct(ModuleManager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    public function installModules(AdapterInterface $console)
    {
        foreach($this->moduleManager->getLoadedModules() as $module) {
            if ($module instanceof HubInstallable) {
                $console->writeLine(sprintf("Attempting to install: %s", substr(get_class($module), 0, -7)), Color::GREEN);
                $installerService = $module->getInstallService();


                if (!$this->serviceLocator->has($installerService)) {
                    $console->writeLine(
                        sprintf(
                            "Could Not find Installer Service: %s For Module %s. Skipping.",
                            $installerService,
                            substr(get_class($module), 0, -7)
                        ),
                        Color::RED
                    );
                    continue;
                }

                $moduleInstaller = $this->serviceLocator->get($installerService);

                if (!$moduleInstaller instanceof InstallerInterface) {
                    $console->writeLine(
                        sprintf(
                            "Installer Service Must Implement: %s For Module %s. Skipping.",
                            'JhHub\Install\InstallerInterface',
                            substr(get_class($module), 0, -7)
                        ),
                        Color::RED
                    );
                    continue;
                }

                //run module installer
                $moduleInstaller->install($console);
            }
        }
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
<?php

namespace JhHub;

use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

/**
 * Class Module
 * @package Application
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class Module implements
    ConsoleBannerProviderInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * @param Console $console
     * @return string
     */
    public function getConsoleBanner(Console $console)
    {
        return
            "==------------------------------------------------------==\n" .
            "        Welcome to the Jh Hub Console!                    \n" .
            "==------------------------------------------------------==\n" .
            "Version 0.1.0\n";
    }
}

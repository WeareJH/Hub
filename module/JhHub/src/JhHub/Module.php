<?php

namespace JhHub;

use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;
use Zend\Http\Request as HttpRequest;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

/**
 * Class Module
 * @package Application
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class Module implements
    ConsoleBannerProviderInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface,
    ConsoleUsageProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sl = $e->getApplication()->getServiceManager();

        if ($e->getRequest() instanceof HttpRequest) {
            // Add ACL information to the Navigation view helper
            /*$authorize = $sm->get('BjyAuthorizeServiceAuthorize');
            $acl = $authorize->getAcl();
            $role = $authorize->getIdentity();
            \Zend\View\Helper\Navigation::setDefaultAcl($acl);
            \Zend\View\Helper\Navigation::setDefaultRole($role);*/
        }

        $t = $e->getTarget();

        $t->getEventManager()->attach(
            $t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy')
        );

        if (!$e->getRequest() instanceof HttpRequest) {
            $eventManager->attach($sl->get('JhHub\Installer\RoleInstallerListener'));
        }
    }

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

    /**
     * @param Console $console
     * @return array|null|string
     */
    public function getConsoleUsage(Console $console)
    {
        return [
            'install roles' => 'Install All Roles and permissions which are not yet installed'
        ];
    }
}

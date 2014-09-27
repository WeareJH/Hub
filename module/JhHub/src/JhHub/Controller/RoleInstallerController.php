<?php

namespace JhHub\Controller;

use JhHub\Installer\RoleInstaller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface;

/**
 * Class InstallController
 * @package JhHub\Controller
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class RoleInstallerController extends AbstractActionController
{
    /**
     * @var AdapterInterface
     */
    protected $console;

    /**
     * @var RoleInstaller
     */
    protected $roleInstaller;

    /**
     * @param AdapterInterface $console
     * @param RoleInstaller $roleInstaller
     */
    public function __construct(AdapterInterface $console, RoleInstaller $roleInstaller)
    {
        $this->console          = $console;
        $this->roleInstaller    = $roleInstaller;
    }

    /**
     * Setup Module
     * Create user_flex_settings row for each new User
     */
    public function installRolesAction()
    {
        $this->console->writeLine("Installing Roles", ColorInterface::RED);
        $this->roleInstaller->installRoles();
        $this->console->writeLine("Finished!", ColorInterface::RED);
    }
}

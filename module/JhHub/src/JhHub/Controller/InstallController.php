<?php

namespace JhHub\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface;
use JhHub\Install\Installer;

/**
 * Class InstallController
 * @package JhHub\Controller
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class InstallController extends AbstractActionController
{
    /**
     * @var Installer
     */
    protected $installer;

    /**
     * @var AdapterInterface
     */
    protected $console;

    /**
     * @param Installer $installer
     * @param AdapterInterface $console
     */
    public function __construct(Installer $installer, AdapterInterface $console) {
        $this->installer   = $installer;
        $this->console     = $console;
    }

    /**
     * Setup Module
     * Create user_flex_settings row for each new User
     */
    public function installAction()
    {
        $this->console->writeLine("Starting Installation", ColorInterface::GREEN);
        $this->installer->installModules($this->console);
        $this->console->writeLine("Finished!", ColorInterface::GREEN);
    }
}

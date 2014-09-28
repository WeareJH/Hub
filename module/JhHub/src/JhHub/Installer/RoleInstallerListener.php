<?php

namespace JhHub\Installer;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;

use Zend\Console\ColorInterface as Color;
use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter;

/**
 * Class RoleInstallerListener
 * @package JhHub\Installer
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleInstallerListener extends AbstractListenerAggregate
{

    /**
     * @var \Zend\Console\Adapter\AdapterInterface
     */
    protected $consoleAdapter;

    /**
     * @param ConsoleAdapter $consoleAdapter
     */
    public function __construct(ConsoleAdapter $consoleAdapter)
    {
       $this->consoleAdapter = $consoleAdapter;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach(
            'JhHub\Installer\RoleInstaller',
            'role.create',
            [$this, 'roleCreate'],
            100
        );
        $this->listeners[] = $sharedEvents->attach(
            'JhHub\Installer\RoleInstaller',
            'role.assign',
            [$this, 'roleAssign'],
            100
        );
        $this->listeners[] = $sharedEvents->attach(
            'JhHub\Installer\RoleInstaller',
            'permission.create',
            [$this, 'permissionCreate'],
            100
        );
        $this->listeners[] = $sharedEvents->attach(
            'JhHub\Installer\RoleInstaller',
            'permission.assign',
            [$this, 'permissionAssign'],
            100
        );
    }

    /**
     * @param EventInterface $e
     */
    public function roleCreate(EventInterface $e)
    {
        $message = sprintf("Created Role: '%s'", $e->getParam('role'));
        $this->consoleAdapter->writeLine($message, Color::GREEN);
    }

    /**
     * @param EventInterface $e
     */
    public function roleAssign(EventInterface $e)
    {
        $parent = $e->getParam('parent');
        $role   = $e->getParam('role');

        $message = sprintf(
            "Assigned Role: '%s' as a child of: '%s'",
            $role,
            $parent
        );

        $this->consoleAdapter->writeLine($message, Color::LIGHT_GREEN);
    }

    /**
     * @param EventInterface $e
     */
    public function permissionCreate(EventInterface $e)
    {
        $message = sprintf(
            "Created Permission: '%s'",
            $e->getParam('permission')
        );

        $this->consoleAdapter->writeLine($message, Color::GREEN);
    }

    /**
     * @param EventInterface $e
     */
    public function permissionAssign(EventInterface $e)
    {
        $message = sprintf(
            "Assigned Permission: '%s' to Role: '%s'",
            $e->getParam('permission'),
            $e->getParam('role')
        );

        $this->consoleAdapter->writeLine($message, Color::LIGHT_GREEN);
    }
}

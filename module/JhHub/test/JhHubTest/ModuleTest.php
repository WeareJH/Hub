<?php

namespace JhHubTest;

use JhHub\Module;

/**
 * Class ModuleTest
 * @package JhHubTest
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{

    public function testGetConfig()
    {
        $module = new Module();

        $this->assertInternalType('array', $module->getConfig());
        $this->assertSame($module->getConfig(), unserialize(serialize($module->getConfig())), 'Config is serializable');
    }

    public function testGetAutoloaderConfig()
    {
        $module = new Module;
        $this->assertInternalType('array', $module->getAutoloaderConfig());
    }

    public function testConsoleBanner()
    {
        $mockConsole = $this->getMock('Zend\Console\Adapter\AdapterInterface');
        $module = new Module();

        $expected =
            "==------------------------------------------------------==\n" .
            "        Welcome to the Jh Hub Console!                    \n" .
            "==------------------------------------------------------==\n" .
            "Version 0.1.0\n";
        $this->assertSame($expected, $module->getConsoleBanner($mockConsole));
    }
}

<?php

namespace JhHubTest\Options\Factory;

use JhHub\Options\Factory\ModuleOptionsFactory;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ModuleOptionsFactoryTest
 * @package JhHubTest\Options\Factory
 * @author  Aydin Hassan <aydin@hotmail.co.uk>
 */
class ModuleOptionsFactoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test options injects from config files
     */
    public function testFactoryReturnsInjectedOptions()
    {
        $config = ['app_url' => 'flex.wearejh.com'];

        $locator = new ServiceManager();
        $locator->setService('Config', ['hub' => $config]);

        $factory = new ModuleOptionsFactory();
        $this->assertEquals('flex.wearejh.com', $factory->createService($locator)->getAppUrl());
    }

    /**
     * Test options returns defaults when no config set
     */
    public function testFactoryReturnsDefaultOptionsWithEmptyConfig()
    {
        $config = [];

        $locator = new ServiceManager();
        $locator->setService('Config', ['hub' => $config]);

        $factory = new ModuleOptionsFactory();
        $this->assertNull($factory->createService($locator)->getAppUrl());
    }

    /**
     * Test options returns defaults when no global config
     */
    public function testFactoryReturnsDefaultOptionsWithNoConfig()
    {
        $config = [];

        $locator = new ServiceManager();
        $locator->setService('Config', $config);

        $factory = new ModuleOptionsFactory();
        $this->assertNull($factory->createService($locator)->getAppUrl());
    }
}

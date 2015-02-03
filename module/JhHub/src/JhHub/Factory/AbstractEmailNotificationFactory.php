<?php

namespace JhHub\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AbstractEmailNotificationFactory
 * @package JhHub\Factory
 * @author  Aydin Hassan <aydin@hotmail.co.uk>
 */
class AbstractEmailNotificationFactory implements AbstractFactoryInterface
{

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string                  $name
     * @param string                  $requestedName
     *
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return fnmatch('*EmailNotificationHandler', $requestedName);
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string                  $name
     * @param string                  $requestedName
     *
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (class_exists($requestedName)) {
            return new $requestedName(
                $serviceLocator->get('AcMailer\Service\MailService'),
                $serviceLocator->get('JhHub\Options\ModuleOptions')
            );
        }
        return false;
    }
}

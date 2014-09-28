<?php

namespace JhHub\Listener;

use SpiffyNavigation\NavigationEvent;
use SpiffyNavigation\Service\Navigation;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use ZfcRbac\Service\AuthorizationServiceInterface;

/**
 * Class ZfcRbacListener
 * @package JhHub\Listener
 */
class SpiffyNavigationZfcRbacListener extends AbstractListenerAggregate
{
    /**
     * @var AuthorizationServiceInterface
     */
    protected $authService;

    /**
     * @param AuthorizationServiceInterface $authService
     */
    public function __construct(AuthorizationServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(Navigation::EVENT_IS_ALLOWED, [$this, 'isAllowed']);
    }

    /**
     * @param NavigationEvent $event
     * @return bool
     */
    public function isAllowed(NavigationEvent $event)
    {
        /** @var \SpiffyNavigation\Page\Page $page */
        $page    = $event->getTarget();
        $options = $page->getOptions();

        if (isset($options['permission'])) {
            return $this->authService->isGranted($options['permission']);
        }
        return true;
    }
}
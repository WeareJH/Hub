<?php

namespace JhHub\Notification;

use ZfcUser\Entity\UserInterface;

/**
 * Class NotificationService
 * @package JhHub\Notification
 * @author  Aydin Hassan <aydin@hotmail.co.uk>
 */
class NotificationService
{
    /**
     * @var NotificationHandlerInterface[]
     */
    protected $handlers = [];

    /**
     * @param NotificationHandlerInterface[] $handlers
     */
    public function __construct(array $handlers = [])
    {
        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
    }

    /**
     * @param NotificationHandlerInterface $handler
     */
    public function addHandler(NotificationHandlerInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    /**
     * @param NotificationInterface $notification
     * @param UserInterface         $user
     */
    public function notify(NotificationInterface $notification, UserInterface $user)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->shouldHandle($notification)) {
                $handler->handle($notification, $user);
            }
        }
    }

    /**
     * @param NotificationInterface $notification
     * @param UserInterface[]       $users
     */
    public function notifyMany(NotificationInterface $notification, array $users)
    {
        foreach ($users as $user) {
            $this->notify($notification, $user);
        }
    }
}

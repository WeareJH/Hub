<?php

namespace JhHubTest\Notification;

use JhHub\Notification\Notification;
use JhHub\Notification\NotificationService;
use JhUser\Entity\User;
use PHPUnit_Framework_TestCase;

/**
 * Class NotificationServiceTest
 * @package JhHubTest\Notification
 * @author  Aydin Hassan <aydin@hotmail.co.uk>
 */
class NotificationServiceTest extends PHPUnit_Framework_TestCase
{
    public function testConstructWithHandlers()
    {
        $handler = $this->getMock('JhHub\Notification\NotificationHandlerInterface');
        $notificationService = new NotificationService([$handler]);
        $this->assertSame([$handler], $this->readAttribute($notificationService, 'handlers'));
    }

    public function testAddHandler()
    {
        $handler = $this->getMock('JhHub\Notification\NotificationHandlerInterface');
        $notificationService = new NotificationService;
        $notificationService->addHandler($handler);
        $this->assertSame([$handler], $this->readAttribute($notificationService, 'handlers'));
    }

    public function testNotifyDoesNotGetHandledIfHandlerReturnsFalseForShouldHandle()
    {
        $handler = $this->getMock('JhHub\Notification\NotificationHandlerInterface');
        $notificationService = new NotificationService;
        $notificationService->addHandler($handler);

        $notification = new Notification('some-notification');
        $user = new User;

        $handler
            ->expects($this->once())
            ->method('shouldHandle')
            ->with($notification)
            ->will($this->returnValue(false));

        $handler
            ->expects($this->never())
            ->method('handle');

        $notificationService->notify($notification, $user);
    }

    public function testNotifySendsIfHandlerReturnsTrueForShouldHandle()
    {
        $handler = $this->getMock('JhHub\Notification\NotificationHandlerInterface');
        $notificationService = new NotificationService;
        $notificationService->addHandler($handler);

        $notification = new Notification('some-notification');
        $user = new User;

        $handler
            ->expects($this->once())
            ->method('shouldHandle')
            ->with($notification)
            ->will($this->returnValue(true));

        $handler
            ->expects($this->once())
            ->method('handle')
            ->with($notification, $user);

        $notificationService->notify($notification, $user);
    }

    public function testNotifyMany()
    {
        $handler = $this->getMock('JhHub\Notification\NotificationHandlerInterface');
        $notificationService = new NotificationService;
        $notificationService->addHandler($handler);

        $notification = new Notification('some-notification');
        $user1 = new User;
        $user2 = new User;

        $handler
            ->expects($this->at(0))
            ->method('shouldHandle')
            ->with($notification)
            ->will($this->returnValue(true));

        $handler
            ->expects($this->at(1))
            ->method('handle')
            ->with($notification, $user1);

        $handler
            ->expects($this->at(2))
            ->method('shouldHandle')
            ->with($notification)
            ->will($this->returnValue(true));

        $handler
            ->expects($this->at(3))
            ->method('handle')
            ->with($notification, $user2);

        $notificationService->notifyMany($notification, [$user1, $user2]);
    }
}

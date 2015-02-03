<?php

namespace JhHubTest\Notification;

use JhHub\Notification\Notification;
use PHPUnit_Framework_TestCase;

/**
 * Class NotificationTest
 * @package JhHubTest\Notification
 * @author  Aydin Hassan <aydin@hotmail.co.uk>
 */
class NotificationTest extends PHPUnit_Framework_TestCase
{
    public function testGettersSetters()
    {
        $notification = new Notification('dinner-time');
        $this->assertEquals('dinner-time', $notification->getName());
        $this->assertEquals([], $notification->getParameters());

        $params = ['one' => 1];
        $notification = new Notification('dinner-time', $params);
        $this->assertEquals('dinner-time', $notification->getName());
        $this->assertEquals($params, $notification->getParameters());
    }
}

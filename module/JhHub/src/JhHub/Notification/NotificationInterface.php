<?php

namespace JhHub\Notification;

/**
 * Class NotificationInterface
 * @package JhHub\Notification
 * @author  Aydin Hassan <aydin@hotmail.co.uk>
 */
interface NotificationInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return array
     */
    public function getParameters();
}
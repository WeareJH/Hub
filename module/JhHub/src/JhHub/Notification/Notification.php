<?php

namespace JhHub\Notification;

/**
 * Class Notification
 * @package JhHub\Notification
 * @author  Aydin Hassan <aydin@hotmail.co.uk>
 */
class Notification implements NotificationInterface
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @param        $name
     * @param array  $parameters
     */
    public function __construct($name, array $parameters = [])
    {
        $this->name         = $name;
        $this->parameters   = $parameters;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}

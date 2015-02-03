<?php

namespace JhHub\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 * @package JhHub\Options
 * @author  Aydin Hassan <aydin@hotmail.co.uk>
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $appUrl;

    /**
     * @return string
     */
    public function getAppUrl()
    {
        if (null === $this->appUrl) {
            return null;
        }

        return rtrim($this->appUrl, '/');
    }

    /**
     * @param string $appUrl
     */
    public function setAppUrl($appUrl)
    {
        $this->appUrl = $appUrl;
    }
}
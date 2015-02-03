<?php

namespace JhHubTest\Assets;

use AcMailer\Service\MailServiceInterface;
use JhHub\Options\ModuleOptions;

/**
 * Class AssetEmailNotificationHandler
 * @package JhHubTest\Assets
 * @author  Aydin Hassan <aydin@hotmail.co.uk>
 */
class AssetEmailNotificationHandler
{
    /**
     * @param MailServiceInterface  $service
     * @param ModuleOptions         $options
     */
    public function __construct(MailServiceInterface $service, ModuleOptions $options)
    {
    }
}
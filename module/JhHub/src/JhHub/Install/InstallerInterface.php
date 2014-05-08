<?php

namespace JhHub\Install;

use Zend\Console\Adapter\AdapterInterface;

/**
 * Interface InstallerInterface
 * @package JhHub\Install
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
interface InstallerInterface
{
    /**
     * @param AdapterInterface $console
     * @return void
     */
    public function install(AdapterInterface $console);
}
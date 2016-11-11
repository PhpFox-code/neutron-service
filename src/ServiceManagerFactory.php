<?php

namespace Phpfox\ServiceManager;

/**
 * Class ServiceManagerFactory
 *
 * @package Phpfox\ServiceManager
 */
class ServiceManagerFactory
{
    /**
     * @return ServiceManager
     */
    public function factory()
    {
        return new ServiceManager();
    }

    /**
     * @return bool
     */
    public function shouldCache()
    {
        return false;
    }
}
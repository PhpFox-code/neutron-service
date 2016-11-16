<?php

namespace Phpfox\Service;

/**
 * Class ServiceManagerFactory
 *
 * @package Phpfox\Service
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
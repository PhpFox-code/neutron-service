<?php

namespace {

    use Phpfox\Service\ServiceManager;

    /**
     * @param string $id
     *
     * @return mixed
     */
    function service($id)
    {
        return ServiceManager::instance()->get($id);
    }

    /**
     * @return ServiceManager
     */
    function services()
    {
        return ServiceManager::instance();
    }
}
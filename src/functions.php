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
}
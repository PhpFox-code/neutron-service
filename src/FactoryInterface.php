<?php

namespace Phpfox\Service;

/**
 * Interface FactoryInterface
 *
 * @package Phpfox\Service
 */
interface FactoryInterface
{
    /**
     * Return any service type Service, Model, Table, Etc, ....
     *
     * @param ServiceManager $serviceManager
     * @param                $name
     * @param array          $options
     *
     * @return mixed
     */
    public function factory(
        ServiceManager $serviceManager,
        $name,
        $options = []
    );

    /**
     * Should cached this factory for reuse later.
     *
     * @return bool
     */
    public function shouldCache();
}
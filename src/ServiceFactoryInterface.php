<?php

namespace Phpfox\Service;

/**
 * Interface FactoryInterface
 *
 * @package Phpfox\Service
 */
interface ServiceFactoryInterface
{
    /**
     * Return any service type Service, Model, Table, Etc, ....
     *
     * @param $id
     *
     * @return string
     */
    public function build($id);
}
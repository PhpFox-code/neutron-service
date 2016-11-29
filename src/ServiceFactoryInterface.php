<?php

namespace Neutron\Service;

/**
 * Interface FactoryInterface
 *
 * @package Neutron\Service
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
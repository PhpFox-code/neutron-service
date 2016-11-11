<?php

namespace Phpfox\ServiceManager;

class NullFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     */
    public function factory(
        ServiceManager $serviceManager,
        $name,
        $options = []
    ) {
        return new $name();
    }

    /**
     * @inheritdoc
     */
    public function shouldCache()
    {
        return true;
    }
}
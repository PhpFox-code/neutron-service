<?php

namespace Phpfox\Service;


class ServiceManager
{
    /**
     * @var array
     */
    private $factories = [];

    /**
     * @var array
     */
    private $aliases = [];

    /**
     * @var [mixed]
     */
    private $cachedService = [];

    /**
     * @var [FactoryInterface]
     */
    private $cachedFactories = [];

    /**
     * @var string
     */
    private $nullFactory = NullFactory::class;

    /**
     * Check has config
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->factories[$name]);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function get($id)
    {
        return isset($this->cachedService[$id]) ? $this->cachedService[$id]
            : $this->cachedService[$id] = $this->build($id);
    }

    /**
     * @param string $id
     * @param mixed  $service
     */
    public function set($id, $service)
    {
        $name = isset($this->aliases[$id]) ? $this->aliases[$id] : $id;

        $this->cachedService[$name] = $this->cachedService[$id] = $service;
    }

    /**
     * Register service factories. In case service is built, it may have no
     * affected.
     *
     * @param array $services
     *
     * @return $this
     */
    public function register($services)
    {
        foreach ($services as $name => $factory) {
            $this->factories[$name] = $factory;
        }
        return $this;
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function build($id)
    {
        $name = isset($this->aliases[$id]) ? $this->aliases[$id] : $id;

        if (!is_string($this->factories[$name])) {
            return null;
        }

        $factoryClass = $this->factories[$name];

        if (null == $factoryClass) {
            $factoryClass = $this->nullFactory;
        }

        if (isset($this->cachedFactories[$factoryClass])) {
            return $this->cachedService[$name]
                = $this->cachedService[$id]
                = $this->cachedFactories[$factoryClass]->factory($this, $name,
                []);
        }

        $factory = new $factoryClass();

        if (!$factory instanceof FactoryInterface) {
            throw new \RuntimeException("Invalid factory $factoryClass");
        }

        if ($factory->shouldCache()) {
            $this->cachedFactories[$factoryClass] = $factory;
        }

        return $this->cachedService[$name]
            = $this->cachedService[$id] = $factory->factory($this, $name, []);
    }
}
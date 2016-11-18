<?php

namespace Phpfox\Service;


class ServiceManager
{
    /**
     * @var array
     */
    private $map = [];

    /**
     * @var [mixed]
     */
    private $instances = [];

    /**
     * ServiceManager constructor.
     */
    public function __construct()
    {
        $data = include PHPFOX_DIR . '/config/library.config.php';

        $this->map = $data['services'];
    }

    /**
     * Check has config
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->map[$name]);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function get($id)
    {
        if (null == $id) {
            return $this;
        }

        return isset($this->instances[$id]) ? $this->instances[$id]
            : $this->instances[$id] = $this->build($id);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function build($id)
    {
        if (!is_string($this->map[$id])) {
            return null;
        }

        $ref = $this->map[$id];

        if (is_string($ref)) {
            return $this->instances[$id] = new ($ref)();
        }

        $ref = array_shift($ref);

        return $this->instances[$id]
            = (new ($ref)())->factory($id);
    }

    /**
     * @param string $id
     * @param mixed  $service
     *
     * @return $this
     */
    public function set($id, $service)
    {
        $this->instances[$id] = $service;
        return $this;
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
        foreach ($services as $k => $v) {
            $this->map[$k] = $v;
        }
        return $this;
    }
}
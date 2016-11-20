<?php

namespace Phpfox\Service;


/**
 * Class ServiceManager
 *
 * @package Phpfox\Service
 */
class ServiceManager
{
    /**
     * @var array
     */
    private $map = [];

    /**
     * @var [mixed]
     */
    private $vars = [];

    /**
     * @var ServiceManager
     */
    private static $singleton;

    /**
     * @return ServiceManager|static
     */
    public static function instance()
    {
        if (null == self::$singleton) {
            self::$singleton = new static();
            self::$singleton->reset();
        }

        return self::$singleton;
    }
    

    public function reset()
    {
        $this->map = config('services');
        $this->set('serviceManager', $this);
    }

    /**
     * Check has config
     *
     * @param string $id
     *
     * @return bool
     */
    public function has($id)
    {
        return isset($this->map[$id]);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function get($id)
    {
        return isset($this->vars[$id]) ? $this->vars[$id]
            : $this->vars[$id] = $this->build($id);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function build($id)
    {
        if (!isset($this->map[$id])) {
            throw new \InvalidArgumentException("There are no service alias '{$id}'.");
        }

        $ref = $this->map[$id];

        $factory = array_shift($ref);

        if (is_string($factory)) {
            return $this->vars[$id] = call_user_func_array([
                new $factory(),
                'factory',
            ], $ref);
        }

        $class = array_shift($ref);

        return $this->vars[$id]
            = new $class();

    }

    /**
     * @param string $id
     * @param mixed  $service
     *
     * @return $this
     */
    public function set($id, $service)
    {
        $this->vars[$id] = $service;
        return $this;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function delete($id)
    {
        if (isset($this->vars[$id])) {
            unset($this->vars[$id]);
        }

        return $this;
    }

    /**
     * Register service factories. In case service is built, it may have no
     * affected.
     *
     * @param array $map
     *
     * @return $this
     */
    public function register($map)
    {
        foreach ($map as $k => $v) {
            $this->map[$k] = $v;
        }
        return $this;
    }

    public function onApplicationConfigChanged()
    {
        $this->map = config('services');

        return $this;
    }

    /**
     * @link http://php.net/manual/en/language.oop5.magic.php#object.sleep
     * @return array
     */
    public function __sleep()
    {
        return ['map'];
    }

    /**
     * @link http://php.net/manual/en/language.oop5.magic.php#object.wakeup
     */
    public function __wakeup()
    {

    }
}
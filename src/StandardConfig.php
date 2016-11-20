<?php

namespace Phpfox\Service;

/**
 * Class StandConfig
 *
 * @package Phpfox\Service
 */
class StandardConfig implements ConfigInterface
{
    protected $data = [];

    public function extend($data)
    {
        $this->data = array_merge_recursive($this->data, $data);
        return $this;
    }

    public function get($key)
    {
        if (strpos($key, '.')) {
            list($p0, $p1) = explode('.', $key, 2);
            if (!isset($this->data[$p0])) {
                return null;
            }
            if (!isset($this->data[$p0][$p1])) {
                return null;
            }

            return $this->data[$p0][$p1];
        }

        if (!isset($this->data[$key])) {
            return $this->data[$key];
        }
    }


    public function set($key, $data)
    {
        $this->data[$key] = $data;
        return $this;
    }

}
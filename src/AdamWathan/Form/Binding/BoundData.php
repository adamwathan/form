<?php

namespace AdamWathan\Form\Binding;

class BoundData
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function get($name, $default = null)
    {
        return $this->dotGet($this->transformKey($name), $default);
    }

    protected function dotGet($dotKey, $default)
    {
        $keyParts = array_filter(explode('.', $dotKey));

        return $this->dataGet($this->data, $keyParts, $default);
    }

    protected function dataGet($target, $keyParts, $default)
    {
        if (count($keyParts) == 0) {
            return $target;
        }

        $key = array_shift($keyParts);

        if (is_array($target)) {
            return isset($target[$key]) ? $this->dataGet($target[$key], $keyParts, $default) : $default;
        }

        if (property_exists($target, $key) || method_exists($target, '__get')) {
            return $this->dataGet($target->{$key}, $keyParts, $default);
        }

        return $default;
    }

    protected function transformKey($key)
    {
        return str_replace(['[]', '[', ']'], ['', '.', ''], $key);
    }
}

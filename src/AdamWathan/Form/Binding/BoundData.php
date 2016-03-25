<?php

namespace AdamWathan\Form\Binding;

class BoundData
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function has($name)
    {
        return $this->dotGet($this->transformKey($name)) !== false;
    }

    public function get($name)
    {
        return $this->dotGet($this->transformKey($name));
    }

    protected function dotGet($dotKey)
    {
        $keyParts = array_filter(explode('.', $dotKey));

        return $this->dataGet($this->data, $keyParts);
    }

    protected function dataGet($target, $keyParts)
    {
        if (count($keyParts) == 0) {
            return $target;
        }

        $key = $keyParts[0];
        $remainingKeys = array_slice($keyParts, 1);

        if (is_array($target) && isset($target[$key])) {
            return $this->dataGet($target[$key], $remainingKeys);
        }

        if (property_exists($target, $key) || method_exists($target, '__get')) {
            return $this->dataGet($target->{$key}, $remainingKeys);
        }

        return false;
    }

    protected function transformKey($key)
    {
        return str_replace(['[]', '[', ']'], ['', '.', ''], $key);
    }
}

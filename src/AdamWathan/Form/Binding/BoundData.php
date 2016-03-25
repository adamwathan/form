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

        if (is_array($target)) {
            return isset($target[$key]) ? $this->dataGet($target[$key], $remainingKeys) : false;
        }

        try {
            if (property_exists($target, $key)) {
                $this->dataGet($target->{$key}, $remainingKeys);
            } elseif (method_exists($target, '__get')) {
                $this->dataGet($target->__get($key), $remainingKeys);
            } else {
                return false;
            }
        } catch (Exception $exception) {
            return false;
        }

        return $this->dataGet($target->{$key}, $remainingKeys);
    }

    protected function transformKey($key)
    {
        return str_replace(['[]', '[', ']'], ['', '.', ''], $key);
    }
}

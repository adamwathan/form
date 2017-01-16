<?php

namespace AdamWathan\Form\Elements;

use Illuminate\Contracts\Support\Htmlable;

abstract class Element implements Htmlable
{
    protected $attributes = [];

    protected function setAttribute($attribute, $value = null)
    {
        if (is_null($value)) {
            return;
        }

        $this->attributes[$attribute] = $value;
    }

    protected function removeAttribute($attribute)
    {
        unset($this->attributes[$attribute]);
    }

    public function getAttribute($attribute)
    {
        return $this->attributes[$attribute];
    }

    public function data($attribute, $value = null)
    {
        if (is_array($attribute)) {
            foreach ($attribute as $key => $val) {
                $this->setAttribute('data-'.$key, $val);
            }
        } else {
            $this->setAttribute('data-'.$attribute, $value);
        }

        return $this;
    }

    public function attribute($attribute, $value)
    {
        $this->setAttribute($attribute, $value);

        return $this;
    }

    public function clear($attribute)
    {
        if (! isset($this->attributes[$attribute])) {
            return $this;
        }

        $this->removeAttribute($attribute);

        return $this;
    }

    public function addClass($class)
    {
        if (isset($this->attributes['class'])) {
            $class = $this->attributes['class'] . ' ' . $class;
        }

        $this->setAttribute('class', $class);

        return $this;
    }

    public function removeClass($class)
    {
        if (! isset($this->attributes['class'])) {
            return $this;
        }

        $class = trim(str_replace($class, '', $this->attributes['class']));
        if ($class == '') {
            $this->removeAttribute('class');
            return $this;
        }

        $this->setAttribute('class', $class);

        return $this;
    }

    public function id($id)
    {
        $this->setId($id);

        return $this;
    }

    protected function setId($id)
    {
        $this->setAttribute('id', $id);
    }

    abstract public function render();

    public function __toString()
    {
        return $this->render();
    }

    protected function renderAttributes()
    {
        list($attributes, $values) = $this->splitKeysAndValues($this->attributes);

        return implode(array_map(function ($attribute, $value) {
            return sprintf(' %s="%s"', $attribute, $value);
        }, $attributes, $values));
    }

    protected function splitKeysAndValues($array)
    {
        // Disgusting crap because people might have passed a collection
        $keys = [];
        $values = [];

        foreach ($array as $key => $value) {
            $keys[] = $key;
            $values[] = $value;
        }

        return [$keys, $values];
    }

    public function __call($method, $params)
    {
        $params = count($params) ? $params : [$method];
        $params = array_merge([$method], $params);
        call_user_func_array([$this, 'attribute'], $params);

        return $this;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml() {
        return $this->render();
    }
}

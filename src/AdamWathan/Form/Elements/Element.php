<?php

namespace AdamWathan\Form\Elements;

abstract class Element
{
    protected $attributes = [];

    protected function setAttribute($attribute, $value = null)
    {
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

    public function attribute($attribute, $value = null)
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
        $attributes = array_map(function ($attribute, $value) {
            return $this->renderAttribute($attribute, $value);
        }, array_keys($this->attributes), $this->attributes);

        $attributes = array_merge([''], $attributes);

        return implode(' ', $attributes);
    }

    protected function renderAttribute($attribute, $value = null)
    {
        if ($value === null) {
            return "{$attribute}";
        }

        return sprintf('%s="%s"', $attribute, $value);
    }

    public function __call($method, $params)
    {
        $params = array_merge([$method], $params);
        call_user_func_array([$this, 'attribute'], $params);

        return $this;
    }
}

<?php namespace AdamWathan\Form\Elements;

use AdamWathan\Form\OldInput\OldInputInterface;

abstract class Element
{
    protected $oldInput;

    protected $attributes = array();

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

    public function data($attribute, $value)
    {
        $this->setAttribute('data-'.$attribute, $value);
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
        $result = '';

        foreach ($this->attributes as $attribute => $value) {
            $result .= " {$attribute}=\"{$value}\"";
        }

        return $result;
    }

    public function __call($method, $params)
    {
        $params = array_merge(array($method), $params);
        call_user_func_array(array($this, 'attribute'), $params);
        return $this;
    }


    public function setOldInputProvider(OldInputInterface $oldInputProvider)
    {
        $this->oldInput = $oldInputProvider;
    }

    protected function getOldInput($name)
    {
        return $this->escapeQuotes($this->oldInput->getOldInput($name));
    }

    protected function escapeQuotes($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        return str_replace('"', '&quot;', $value);
    }

    protected function getValueFor($name)
    {
        if ($this->hasOldInput()) {
            return $this->getOldInput($name);
        }

        if ($this->hasModelValue($name)) {
            return $this->getModelValue($name);
        }

        return null;
    }

    protected function hasOldInput()
    {
        if (! isset($this->oldInput)) {
            return false;
        }

        return $this->oldInput->hasOldInput();
    }
}

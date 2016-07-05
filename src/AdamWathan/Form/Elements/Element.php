<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Element
 * @package AdamWathan\Form\Elements
 */
abstract class Element
{
    protected $attributes = [];

	/**
     * @param $attribute
     * @param null $value
     */
    protected function setAttribute($attribute, $value = null)
    {
        if (is_null($value)) {
            return;
        }

        $this->attributes[$attribute] = $value;
    }

	/**
     * @param $attribute
     */
    protected function removeAttribute($attribute)
    {
        unset($this->attributes[$attribute]);
    }

	/**
     * @param $attribute
     * @return mixed
     */
    public function getAttribute($attribute)
    {
        return $this->attributes[$attribute];
    }

	/**
     * @param $attribute
     * @param null $value
     * @return $this
     */
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

	/**
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function attribute($attribute, $value)
    {
        $this->setAttribute($attribute, $value);

        return $this;
    }

	/**
     * @param $attribute
     * @return $this
     */
    public function clear($attribute)
    {
        if (! isset($this->attributes[$attribute])) {
            return $this;
        }

        $this->removeAttribute($attribute);

        return $this;
    }

	/**
     * @param $class
     * @return $this
     */
    public function addClass($class)
    {
        if (isset($this->attributes['class'])) {
            $class = $this->attributes['class'] . ' ' . $class;
        }

        $this->setAttribute('class', $class);

        return $this;
    }

	/**
     * @param $class
     * @return $this
     */
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

	/**
     * @param $id
     * @return $this
     */
    public function id($id)
    {
        $this->setId($id);

        return $this;
    }

	/**
     * @param $id
     */
    protected function setId($id)
    {
        $this->setAttribute('id', $id);
    }

    abstract public function render();

    public function __toString()
    {
        return $this->render();
    }

	/**
     * @return string
     */
    protected function renderAttributes()
    {
        list($attributes, $values) = $this->splitKeysAndValues($this->attributes);

        return implode(array_map(function ($attribute, $value) {
            return sprintf(' %s="%s"', $attribute, $value);
        }, $attributes, $values));
    }

	/**
     * @param $array
     * @return array
     */
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

	/**
     * @param $method
     * @param $params
     * @return $this
     */
    public function __call($method, $params)
    {
        $params = count($params) ? $params : [$method];
        $params = array_merge([$method], $params);
        call_user_func_array([$this, 'attribute'], $params);

        return $this;
    }
}

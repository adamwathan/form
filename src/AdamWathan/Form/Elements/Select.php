<?php

namespace AdamWathan\Form\Elements;

class Select extends FormControl
{
    protected $options;

    protected $selected;

    protected $optAttributes = [];

    public function __construct($name, $options = [])
    {
        $this->setName($name);
        $this->setOptions($options);
    }

    public function select($option)
    {
        $this->selected = $option;

        return $this;
    }

    protected function setOptions($options)
    {
        $this->options = $options;
    }

    public function options($options)
    {
        $this->setOptions($options);

        return $this;
    }

    public function render()
    {
        return implode([
            sprintf('<select%s>', $this->renderAttributes()),
            $this->renderOptions(),
            '</select>',
        ]);
    }

    protected function renderOptions()
    {
        list($values, $labels) = $this->splitKeysAndValues($this->options);

        $tags = array_map(function ($value, $label) {
            if (is_array($label)) {
                return $this->renderOptGroup($value, $label);
            }
            return $this->renderOption($value, $label);
        }, $values, $labels);

        return implode($tags);
    }

    protected function renderOptGroup($label, $options)
    {
        list($values, $labels) = $this->splitKeysAndValues($options);

        $options = array_map(function ($value, $label) {
            return $this->renderOption($value, $label);
        }, $values, $labels);

        return implode([
            sprintf('<optgroup label="%s">', $label),
            implode($options),
            '</optgroup>',
        ]);
    }

    protected function renderOption($value, $label)
    {
        return vsprintf('<option value="%s"%s%s>%s</option>', [
            $this->escape($value),
            $this->isSelected($value) ? ' selected' : '',
            $this->renderOptAttributes($value),
            $this->escape($label),
        ]);
    }

    protected function isSelected($value)
    {
        return in_array($value, (array) $this->selected);
    }

    public function addOption($value, $label)
    {
        $this->options[$value] = $label;

        return $this;
    }

    public function defaultValue($value)
    {
        if (isset($this->selected)) {
            return $this;
        }

        $this->select($value);

        return $this;
    }

    public function multiple()
    {
        $name = $this->attributes['name'];
        if (substr($name, -2) != '[]') {
            $name .= '[]';
        }

        $this->setName($name);
        $this->setAttribute('multiple', 'multiple');

        return $this;
    }

    public function setOptAttributes($optAttributes = [])
    {
        $this->optAttributes = $optAttributes;
        return $this;
    }

    public function addOptAttribute($optValue, $name, $value)
    {
        $this->optAttributes[$optValue][$name] = $value;
        return $this;
    }

    public function removeOptAttribute($optValue, $name = null)
    {
        if ($name === null) {
            unset($this->optAttributes[$optValue]);
        } else {
            unset($this->optAttributes[$optValue][$name]);
        }
        return $this;
    }

    public function getOptAttribute($optValue, $name)
    {
        if (isset($this->optAttributes[$optValue][$name])) {
            return $this->optAttributes[$optValue][$name];
        }
        return null;
    }

    protected function renderOptAttributes($optValue)
    {
        if (empty($this->optAttributes[$optValue])) {
            return '';
        }

        list($attributes, $values) = $this->splitKeysAndValues($this->optAttributes[$optValue]);

        return implode(array_map(function ($attribute, $value) {
            if (is_bool($value)) {
                return $value ? " {$attribute}" : '';
            }
            return sprintf(' %s="%s"', $attribute, $this->escape($value));
        }, $attributes, $values));
    }
}

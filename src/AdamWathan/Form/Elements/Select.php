<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Select
 * @package AdamWathan\Form\Elements
 */
class Select extends FormControl
{
    protected $options;

    protected $selected;

    /**
     * Select constructor.
     * @param $name
     * @param array $options
     */
    public function __construct($name, $options = [])
    {
        $this->setName($name);
        $this->setOptions($options);
    }

    /**
     * @param $option
     * @return $this
     */
    public function select($option)
    {
        $this->selected = $option;

        return $this;
    }

    /**
     * @param $options
     */
    protected function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @param $options
     * @return $this
     */
    public function options($options)
    {
        $this->setOptions($options);

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        return implode([
            sprintf('<select%s>', $this->renderAttributes()),
            $this->renderOptions(),
            '</select>',
        ]);
    }

    /**
     * @return string
     */
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

    /**
     * @param $label
     * @param $options
     * @return string
     */
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

    /**
     * @param $value
     * @param $label
     * @return string
     */
    protected function renderOption($value, $label)
    {
        return implode([
            sprintf('<option value="%s"%s>', $value, $this->isSelected($value) ? ' selected' : ''),
            $label,
            '</option>',
        ]);
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isSelected($value)
    {
        return in_array($value, (array) $this->selected);
    }

    /**
     * @param $value
     * @param $label
     * @return $this
     */
    public function addOption($value, $label)
    {
        $this->options[$value] = $label;

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function defaultValue($value)
    {
        if (isset($this->selected)) {
            return $this;
        }

        $this->select($value);

        return $this;
    }

    /**
     * @return $this
     */
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
}

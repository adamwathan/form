<?php namespace AdamWathan\Form\Elements;

class Select extends FormControl
{
    private $options;
    private $selected;

    public function __construct($name, $options = array())
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
        $result = '<select';
        $result .= $this->renderAttributes();
        $result .= '>';
        $result .= $this->renderOptions();
        $result .= '</select>';

        return $result;
    }

    protected function renderOptions()
    {
        $result = '';

        if (! $this->optionValuesAreSet()) {
            return $this->renderOptionsWithoutValues();
        }

        foreach ($this->options as $value => $label) {
            if (is_array($label)) {
                $result .= $this->renderOptGroup($value, $label);
                continue;
            }
            $result .= $this->renderOption($value, $label);
        }

        return $result;
    }

    protected function renderOptGroup($label, $options)
    {
        $result = "<optgroup label=\"{$label}\">";
        foreach ($options as $value => $label) {
            $result .= $this->renderOption($value, $label);
        }
        $result .= "</optgroup>";
        return $result;
    }

    protected function renderOption($value, $label)
    {
        $option = '<option ';
        $option .= 'value="' . $value . '"';
        $option .= $this->isSelected($value) ? ' selected' : '';
        $option .= '>';
        $option .= $label;
        $option .= '</option>';
        return $option;
    }

    protected function isSelected($value)
    {
        return isset($this->selected) ? $this->selected == $value : false;
    }

    protected function optionValuesAreSet($options = null)
    {
        if (! $options) {
            $options = $this->options;
        }
        $count = 0;
        $keysSet = false;
        foreach ($options as $value => $label) {
            if (is_array($suboptions = $label)) {
                $keysSet = $this->optionValuesAreSet($suboptions) ? true : $keysSet;
            } elseif ($value !== $count) {
                $keysSet = true;
                break;
            }
            $count++;
        }

        return $keysSet;
    }

    protected function renderOptionsWithoutValues()
    {
        $result = '';

        foreach ($this->options as $value => $label) {
            if (is_array($label)) {
                $result .= $this->renderOptGroupWithoutValues($value, $label);
                continue;
            }
            $result .= $this->renderOption($label, $label);
        }

        return $result;
    }

    protected function renderOptGroupWithoutValues($label, $options)
    {
        $options = array_combine($options, $options);
        return $this->renderOptGroup($label, $options);
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
}

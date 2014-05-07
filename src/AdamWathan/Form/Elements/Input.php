<?php namespace AdamWathan\Form\Elements;

abstract class Input extends FormControl
{
    public function render()
    {
        $result  = '<input';

        $result .= $this->renderAttributes();

        $result .= '>';

        return $result;
    }

    public function value($value)
    {
        $this->setValue($value);
        return $this;
    }

    protected function setValue($value)
    {
        $this->setAttribute('value', $value);
        return $this;
    }
}

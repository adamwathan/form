<?php namespace AdamWathan\Form\Elements;

abstract class FormControl extends Element
{
    public function __construct($name)
    {
        $this->setName($name);
    }

    protected function setName($name)
    {
        $this->setAttribute('name', $name);
    }

    public function required()
    {
        $this->setAttribute('required', 'required');
        return $this;
    }

    public function optional()
    {
        $this->removeAttribute('required');
        return $this;
    }

    public function disable()
    {
        $this->setAttribute('disabled', 'disabled');
        return $this;
    }

    public function enable()
    {
        $this->removeAttribute('disabled');
        return $this;
    }

    public function autofocus()
    {
        $this->setAttribute('autofocus', 'autofocus');
        return $this;
    }

    public function unfocus()
    {
        $this->removeAttribute('autofocus');
        return $this;
    }

}

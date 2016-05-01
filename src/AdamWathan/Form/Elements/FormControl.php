<?php

namespace AdamWathan\Form\Elements;

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

    public function required($conditional = true)
    {
        if ($conditional) {
            $this->setAttribute('required', 'required');
        }

        return $this;
    }

    public function optional()
    {
        $this->removeAttribute('required');

        return $this;
    }

    public function disable($conditional = true)
    {
        if ($conditional) {
            $this->setAttribute('disabled', 'disabled');
        }

        return $this;
    }

    public function readonly($conditional = true)
    {
        if ($conditional) {
            $this->setAttribute('readonly', 'readonly');
        }

        return $this;
    }

    public function enable($conditional = true)
    {
        if ($conditional) {
            $this->removeAttribute('disabled');
            $this->removeAttribute('readonly');
        }

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

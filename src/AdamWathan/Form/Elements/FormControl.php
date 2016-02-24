<?php

namespace AdamWathan\Form\Elements;

abstract class FormControl extends Element
{
    public function __construct($name = null)
    {
        if ($name !== null) {
            $this->setName($name);
        }
    }

    protected function setName($name)
    {
        $this->setAttribute('name', $name);
    }

    public function required()
    {
        $this->setAttribute('required');

        return $this;
    }

    public function optional()
    {
        $this->removeAttribute('required');

        return $this;
    }

    public function disable()
    {
        $this->setAttribute('disabled');

        return $this;
    }

    public function readonly()
    {
        $this->setAttribute('readonly');

        return $this;
    }

    public function enable()
    {
        $this->removeAttribute('disabled');
        $this->removeAttribute('readonly');

        return $this;
    }

    public function autofocus()
    {
        $this->setAttribute('autofocus');

        return $this;
    }

    public function unfocus()
    {
        $this->removeAttribute('autofocus');

        return $this;
    }
}

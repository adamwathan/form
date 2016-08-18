<?php

namespace AdamWathan\Form\Elements;

/**
 * Class FormControl
 * @package AdamWathan\Form\Elements
 */
abstract class FormControl extends Element
{
    /**
     * FormControl constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @param $name
     */
    protected function setName($name)
    {
        $this->setAttribute('name', $name);
    }

    /**
     * @return $this
     */
    public function required()
    {
        $this->setAttribute('required', 'required');

        return $this;
    }

    /**
     * @return $this
     */
    public function optional()
    {
        $this->removeAttribute('required');

        return $this;
    }

    /**
     * @return $this
     */
    public function disable()
    {
        $this->setAttribute('disabled', 'disabled');

        return $this;
    }

    /**
     * @return $this
     */
    public function readonly()
    {
        $this->setAttribute('readonly', 'readonly');

        return $this;
    }

    /**
     * @return $this
     */
    public function enable()
    {
        $this->removeAttribute('disabled');
        $this->removeAttribute('readonly');

        return $this;
    }

    /**
     * @return $this
     */
    public function autofocus()
    {
        $this->setAttribute('autofocus', 'autofocus');

        return $this;
    }

    /**
     * @return $this
     */
    public function unfocus()
    {
        $this->removeAttribute('autofocus');

        return $this;
    }
}

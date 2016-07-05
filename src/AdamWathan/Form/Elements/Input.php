<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Input
 * @package AdamWathan\Form\Elements
 */
abstract class Input extends FormControl
{
	/**
     * @return string
     */
    public function render()
    {
        return sprintf('<input%s>', $this->renderAttributes());
    }

	/**
     * @param $value
     * @return $this
     */
    public function value($value)
    {
        $this->setValue($value);

        return $this;
    }

	/**
     * @param $value
     * @return $this
     */
    protected function setValue($value)
    {
        $this->setAttribute('value', $value);

        return $this;
    }
}

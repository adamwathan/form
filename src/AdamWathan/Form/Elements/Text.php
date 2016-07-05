<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Text
 * @package AdamWathan\Form\Elements
 */
class Text extends Input
{
    protected $attributes = [
        'type' => 'text',
    ];

	/**
     * @param $placeholder
     * @return $this
     */
    public function placeholder($placeholder)
    {
        $this->setAttribute('placeholder', $placeholder);

        return $this;
    }

	/**
     * @param $value
     * @return $this
     */
    public function defaultValue($value)
    {
        if (! $this->hasValue()) {
            $this->setValue($value);
        }

        return $this;
    }

	/**
     * @return bool
     */
    protected function hasValue()
    {
        return isset($this->attributes['value']);
    }
}

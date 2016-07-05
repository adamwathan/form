<?php

namespace AdamWathan\Form\Elements;

/**
 * Class TextArea
 * @package AdamWathan\Form\Elements
 */
class TextArea extends FormControl
{
    protected $attributes = [
        'name' => '',
        'rows' => 10,
        'cols' => 50,
    ];

    protected $value;

	/**
     * @return string
     */
    public function render()
    {
        return implode([
            sprintf('<textarea%s>', $this->renderAttributes()),
            $this->value,
            '</textarea>',
        ]);
    }

	/**
     * @param $rows
     * @return $this
     */
    public function rows($rows)
    {
        $this->setAttribute('rows', $rows);

        return $this;
    }

	/**
     * @param $cols
     * @return $this
     */
    public function cols($cols)
    {
        $this->setAttribute('cols', $cols);

        return $this;
    }

	/**
     * @param $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

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
            $this->value($value);
        }

        return $this;
    }

	/**
     * @return bool
     */
    protected function hasValue()
    {
        return isset($this->value);
    }
}

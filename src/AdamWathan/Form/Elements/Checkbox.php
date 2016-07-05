<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Checkbox
 * @package AdamWathan\Form\Elements
 */
class Checkbox extends Input
{
    protected $attributes = [
        'type' => 'checkbox',
    ];

    protected $checked;

    protected $oldValue;

	/**
     * Checkbox constructor.
     * @param $name
     * @param int $value
     */
    public function __construct($name, $value = 1)
    {
        parent::__construct($name);

        $this->setValue($value);
    }

	/**
     * @param $oldValue
     */
    public function setOldValue($oldValue)
    {
        $this->oldValue = $oldValue;
    }

    public function unsetOldValue()
    {
        $this->oldValue = null;
    }

	/**
     * @return $this
     */
    public function defaultToChecked()
    {
        if (! isset($this->checked) && is_null($this->oldValue)) {
            $this->check();
        }

        return $this;
    }

	/**
     * @return $this
     */
    public function defaultToUnchecked()
    {
        if (! isset($this->checked) && is_null($this->oldValue)) {
            $this->uncheck();
        }

        return $this;
    }

	/**
     * @param $state
     * @return $this
     */
    public function defaultCheckedState($state)
    {
        $state ? $this->defaultToChecked() : $this->defaultToUnchecked();

        return $this;
    }

	/**
     * @return $this
     */
    public function check()
    {
        $this->unsetOldValue();
        $this->setChecked(true);

        return $this;
    }

	/**
     * @return $this
     */
    public function uncheck()
    {
        $this->unsetOldValue();
        $this->setChecked(false);

        return $this;
    }

	/**
     * @param bool $checked
     */
    protected function setChecked($checked = true)
    {
        $this->checked = $checked;
        $this->removeAttribute('checked');

        if ($checked) {
            $this->setAttribute('checked', 'checked');
        }
    }

	/**
     * @return Checkbox
     */
    protected function checkBinding()
    {
        $currentValue = (string) $this->getAttribute('value');

        $oldValue = $this->oldValue;
        $oldValue = is_array($oldValue) ? $oldValue : [$oldValue];
        $oldValue = array_map('strval', $oldValue);

        if (in_array($currentValue, $oldValue)) {
            return $this->check();
        }
    }

	/**
     * @return string
     */
    public function render()
    {
        $this->checkBinding();

        return parent::render();
    }
}

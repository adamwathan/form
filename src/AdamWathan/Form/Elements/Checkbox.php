<?php namespace AdamWathan\Form\Elements;

class Checkbox extends Input
{
    protected $attributes = array(
        'type' => 'checkbox',
    );

    private $checked;

    private $oldValue;

    public function __construct($name, $value = 1)
    {
        parent::__construct($name);
        $this->setValue($value);
    }

    public function setOldValue($oldValue)
    {
        $this->oldValue = $oldValue;
    }

    public function unsetOldValue()
    {
        $this->oldValue = null;
    }

    public function defaultToChecked()
    {
        if (! isset($this->checked)) {
            $this->check();
        }

        return $this;
    }

    public function defaultToUnchecked()
    {
        if (! isset($this->checked)) {
            $this->uncheck();
        }

        return $this;
    }

    public function defaultCheckedState($state)
    {
        $state ? $this->defaultToChecked() : $this->defaultToUnchecked();
        return $this;
    }

    public function check()
    {
        $this->unsetOldValue();
        $this->setChecked(true);
        return $this;
    }

    public function uncheck()
    {
        $this->unsetOldValue();
        $this->setChecked(false);
        return $this;
    }

    protected function setChecked($checked = true)
    {
        $this->checked = $checked;
        $this->removeAttribute('checked');

        if ($checked) {
            $this->setAttribute('checked', 'checked');
        }
    }

    protected function checkBinding()
    {
        $currentValue = $this->getAttribute('value');
        $oldValue = $this->oldValue;

        if ($currentValue === $oldValue) {
            $this->check();
        }
    }

    public function render()
    {
        $this->checkBinding();

        return parent::render();
    }
}

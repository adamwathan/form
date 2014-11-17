<?php namespace AdamWathan\Form\Elements;

class Checkbox extends Input
{
    protected $attributes = array(
        'type' => 'checkbox',
    );

    private $checked;

    public function __construct($name, $value = 1)
    {
        parent::__construct($name);
        $this->setValue($value);
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
        $this->setChecked(true);
        return $this;
    }

    public function uncheck()
    {
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

    public function value($value)
    {
        $this->setValue($value);

        $this->checkForOldInput($value);

        return $this;
    }

    public function checkForOldInput($value)
    {
        if (
            $this->hasOldInput($this->attributes['name']) &&
            $value == $this->attributes['name'] ||
            (
                is_array($this->getValueFor($this->attributes['name'])) &&
                in_array($value, $this->getValueFor($this->attributes['name']))
            )
        ) {
            $this->setAttribute('checked', 'checked');
        }
    }
}

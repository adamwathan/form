<?php

namespace AdamWathan\Form\Elements;

class Button extends FormControl
{
    protected $attributes = [
        'type' => 'button',
    ];

    protected $value;

    public function __construct($value, $name = null)
    {
        parent::__construct($name);

        $this->value($value);
    }

    public function render()
    {
        return sprintf('<button%s>%s</button>', $this->renderAttributes(), $this->value);
    }

    public function value($value)
    {
        $this->value = $value;
    }
}

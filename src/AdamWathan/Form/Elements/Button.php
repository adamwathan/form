<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Button
 * @package AdamWathan\Form\Elements
 */
class Button extends FormControl
{
    protected $attributes = [
        'type' => 'button',
    ];

    protected $value;

    /**
	 * Button constructor.
	 * @param string $value
	 * @param null $name
	 */
	public function __construct($value, $name = null)
    {
        parent::__construct($name);

        $this->value($value);
    }

    /**
     * @return string
     */
    public function render()
    {
        return sprintf('<button%s>%s</button>', $this->renderAttributes(), $this->value);
    }

    /**
     * @param $value
     */
    public function value($value)
    {
        $this->value = $value;
    }
}

<?php

namespace AdamWathan\Form\Elements;

/**
 * Class RadioButton
 * @package AdamWathan\Form\Elements
 */
class RadioButton extends Checkbox
{
    protected $attributes = [
        'type' => 'radio',
    ];

	/**
	 * RadioButton constructor.
	 * @param $name
	 * @param null $value
	 */
	public function __construct($name, $value = null)
    {
        parent::__construct($name);

        if (is_null($value)) {
            $value = $name;
        }

        $this->setValue($value);
    }
}

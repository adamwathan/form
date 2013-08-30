<?php namespace AdamWathan\Form\Elements;

class Submit extends Input
{
	protected $attributes = array(
			'type' => 'submit',
		);

	public function __construct($value)
	{
		$this->setValue($value);
	}
}
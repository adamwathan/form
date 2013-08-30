<?php namespace AdamWathan\Form\Elements;

class Text extends Input
{
	protected $attributes = array(
			'type' => 'text',
		);

	public function placeholder($placeholder)
	{
		$this->setAttribute('placeholder', $placeholder);
		return $this;
	}
}
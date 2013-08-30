<?php namespace AdamWathan\Form\Elements;

class Checkbox extends Input
{
	protected $attributes = array(
			'type' => 'checkbox',
		);

	public function __construct($name, $value = 1)
	{
		parent::__construct($name);
		$this->setValue($value);
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
		$this->removeAttribute('checked');

		if ($checked) {
			$this->setAttribute('checked', 'checked');			
		}
	}
}
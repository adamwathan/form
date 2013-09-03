<?php namespace AdamWathan\Form;

use AdamWathan\Form\Elements\Text;
use AdamWathan\Form\Elements\Password;
use AdamWathan\Form\Elements\Checkbox;
use AdamWathan\Form\Elements\RadioButton;
use AdamWathan\Form\Elements\Submit;
use AdamWathan\Form\Elements\Select;
use AdamWathan\Form\Elements\TextArea;
use AdamWathan\Form\Elements\Label;
use AdamWathan\Form\Elements\FormOpen;

class FormBuilder
{
	private $oldInput;

	public function setOldInputProvider(OldInputInterface $provider)
	{
		$this->oldInput = $provider;
	}

	public function open()
	{
		return new FormOpen;
	}

	public function close()
	{
		return '</form>';
	}
	
	public function text($name)
	{
		$text = new Text($name);
		
		$this->restoreElementValue($text, $name);

		return $text;
	}

	protected function restoreElementValue($element, $name)
	{
		$value = $this->getValueFor($name);

		if ($value) {
			$element->value($value);
		}
	}

	protected function getValueFor($name)
	{
		if ($this->hasOldInput($name)) {
			return $this->getOldInput($name);
		}

		return '';
	}

	protected function hasOldInput($name)
	{
		if (isset($this->oldInput) and $this->oldInput->hasOld($name)) {
			return true;
		}

		return false;
	}

	protected function getOldInput($name)
	{
		return $this->oldInput->getOld($name);
	}
	
	public function password($name)
	{
		return new Password($name);
	}
	
	public function checkbox($name, $value = 1)
	{
		return new Checkbox($name, $value);
	}
	
	public function radio($name, $value = null)
	{
		return new RadioButton($name, $value);
	}
	
	public function submit($value = 'Submit')
	{
		return new Submit($value);
	}

	public function select($name, $options = array())
	{
		return new Select($name, $options);
	}

	public function textarea($name)
	{
		return new TextArea($name);
	}

	public function label($label)
	{
		return new Label($label);
	}
}
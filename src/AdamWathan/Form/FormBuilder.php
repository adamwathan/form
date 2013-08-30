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
		return new Text($name);
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
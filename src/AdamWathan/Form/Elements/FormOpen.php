<?php namespace AdamWathan\Form\Elements;

class FormOpen extends Element
{
	protected $attributes = array(
		'method' => 'POST'
		);

	public function render()
	{
		$result  = '<form';

		$result .= $this->renderAttributes();

		$result .= '>';

		return $result;
	}

	public function post()
	{
		$this->setMethod('POST');
		return $this;
	}

	public function get()
	{
		$this->setMethod('GET');
		return $this;
	}

	public function setMethod($method)
	{
		$this->setAttribute('method', $method);
		return $this;
	}

	public function action($action)
	{
		$this->setAttribute('action', $action);
		return $this;
	}
}
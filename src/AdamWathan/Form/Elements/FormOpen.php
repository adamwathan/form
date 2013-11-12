<?php namespace AdamWathan\Form\Elements;

class FormOpen extends Element
{
	protected $attributes = array(
		'method' => 'POST'
		);
	protected $method;

	public function render()
	{
		$result  = '<form';

		$result .= $this->renderAttributes();

		$result .= '>';

		if (isset($this->method)) {
			$result .= $this->method->render();
		}

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

	public function put()
	{
		$this->setMethod('POST');

		$this->method = new Hidden('_method');
		$this->method->value('PUT');

		return $this;
	}

	public function delete()
	{
		$this->setMethod('POST');

		$this->method = new Hidden('_method');
		$this->method->value('DELETE');

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

	public function encodingType($type)
	{
		$this->setAttribute('enctype', $type);
		return $this;
	}

	public function multipart()
	{
		return $this->encodingType('multipart/form-data');
	}
}
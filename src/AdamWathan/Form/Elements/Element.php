<?php namespace AdamWathan\Form\Elements;

abstract class Element
{
	protected $attributes = array();

	public function setAttribute($attribute, $value = null)
	{
		if (is_null($value)) {
			return;
		}
		
		$this->attributes[$attribute] = $value;
	}

	public function removeAttribute($attribute) {
		unset($this->attributes[$attribute]);
	}

	public function addClass($class)
	{
		if (isset($this->attributes['class'])) {
			$class = $this->attributes['class'] . ' ' . $class;
		}

		$this->setAttribute('class', $class);
		return $this;
	}

	public function id($id)
	{
		$this->setId($id);
		return $this;
	}

	protected function setId($id)
	{
		$this->setAttribute('id', $id);
	}	

	public abstract function render();

	public function __toString()
	{
		return $this->render();
	}

	protected function renderAttributes()
	{
		$result = '';

		foreach ($this->attributes as $attribute => $value) {
			$result .= " {$attribute}=\"$value\"";
		}

		return $result;
	}
}
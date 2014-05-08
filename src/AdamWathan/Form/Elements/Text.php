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

    public function defaultValue($value)
    {
        if (! $this->hasValue()) {
            $this->setValue($value);
        }

        return $this;
    }

    protected function hasValue()
    {
        return isset($this->attributes['value']);
    }
}

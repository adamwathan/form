<?php namespace AdamWathan\Form\Elements;

class Submit extends FormControl
{
    protected $attributes = array(
        'type' => 'submit',
    );

    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function render()
    {
        $result = '<button';
        $result .= $this->renderAttributes();
        $result .= '>';
        $result .= $this->value;
        $result .= '</button>';

        return $result;
    }

    public function value($value)
    {
        $this->value = $value;
    }
}

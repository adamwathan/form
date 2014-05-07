<?php namespace AdamWathan\Form\Elements;

class Date extends Text
{
    protected $attributes = array(
        'type' => 'date',
    );

    public function value($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->format('Y-m-d');
        }
        return parent::value($value);
    }
}

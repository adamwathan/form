<?php

namespace AdamWathan\Form\Elements;

class DateTimeLocal extends Text
{
    protected $attributes = [
        'type' => 'datetime-local',
    ];

    public function value($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->format('Y-m-d\TH:i');
        }

        return parent::value($value);
    }
}

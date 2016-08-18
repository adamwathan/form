<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Date
 * @package AdamWathan\Form\Elements
 */
class Date extends Text
{
    protected $attributes = [
        'type' => 'date',
    ];

    /**
	 * @param $value
	 * @return $this
	 */
	public function value($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->format('Y-m-d');
        }

        return parent::value($value);
    }
}

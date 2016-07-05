<?php

namespace AdamWathan\Form\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Form
 * @package AdamWathan\Form\Facades
 */
class Form extends Facade
{
	/**
	 * @return string
	 */
	protected static function getFacadeAccessor()
    {
        return 'adamwathan.form';
    }
}

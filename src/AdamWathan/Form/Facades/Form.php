<?php

namespace AdamWathan\Form\Facades;

use Illuminate\Support\Facades\Facade;

class Form extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'adamwathan.form';
    }
}

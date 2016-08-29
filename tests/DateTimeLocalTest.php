<?php

use AdamWathan\Form\Elements\DateTimeLocal;

class DateTimeLocalTest extends PHPUnit_Framework_TestCase
{
    use InputContractTest;

    protected function newTestSubjectInstance($name)
    {
        return new DateTimeLocal($name);
    }

    protected function getTestSubjectType()
    {
        return 'datetime-local';
    }
}

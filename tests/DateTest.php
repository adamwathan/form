<?php

use AdamWathan\Form\Elements\Date;

class DateTest extends PHPUnit_Framework_TestCase
{
    use InputContractTest;

    protected function newTestSubjectInstance($name)
    {
        return new Date($name);
    }

    protected function getTestSubjectType()
    {
        return 'date';
    }
}

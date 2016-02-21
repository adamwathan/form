<?php

use AdamWathan\Form\Elements\Email;

class EmailTest extends PHPUnit_Framework_TestCase
{
    use TextSubclassContractTest;

    protected function newTestSubjectInstance($name)
    {
        return new Email($name);
    }

    protected function getTestSubjectType()
    {
        return 'email';
    }
}

<?php

use AdamWathan\Form\Elements\Hidden;

class HiddenTest extends PHPUnit_Framework_TestCase
{
    use InputContractTest;

    protected function newTestSubjectInstance($name)
    {
        return new Hidden($name);
    }

    protected function getTestSubjectType()
    {
        return 'hidden';
    }
}

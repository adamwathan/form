<?php

use AdamWathan\Form\Elements\Password;

class PasswordTest extends PHPUnit_Framework_TestCase
{

    use TextSubclassContractTest;

    /**
     * @param string $name
     *
     * @return AdamWathan\Form\Elements\Text
     */
    protected function newTestSubjectInstance($name)
    {
        return new Password($name);
    }

    /**
     * @return string
     */
    protected function getTestSubjectType()
    {
        return "password";
    }
}
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

    public function testDateTimeValuesAreBoundAsFormattedStrings()
    {
        $dateTimeLocal = new DateTimeLocal('dob');
        $dateTimeLocal->value(new DateTime('12-04-1988 10:33'));

        $expected = '<input type="datetime-local" name="dob" value="1988-04-12T10:33">';
        $this->assertSame($expected, $dateTimeLocal->render());
    }
}

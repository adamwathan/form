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

    public function testDateTimeValuesAreBoundAsFormattedStrings()
    {
        $dateTimeLocal = new Date('dob');
        $dateTimeLocal->defaultValue(new DateTime('12-04-1988 10:33'));

        $expected = '<input type="date" name="dob" value="1988-04-12">';
        $this->assertSame($expected, $dateTimeLocal->render());
    }

    public function testDateTimeDefaultValuesAreBoundAsFormattedStrings()
    {
        $dateTimeLocal = new Date('dob');
        $dateTimeLocal->defaultValue(new DateTime('12-04-1988 10:33'));

        $expected = '<input type="date" name="dob" value="1988-04-12">';
        $this->assertSame($expected, $dateTimeLocal->render());
    }
}

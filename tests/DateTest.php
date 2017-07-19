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
        $date = new Date('dob');
        $date->defaultValue(new DateTime('12-04-1988 10:33'));

        $expected = '<input type="date" name="dob" value="1988-04-12">';
        $this->assertSame($expected, $date->render());
    }

    public function testDateTimeDefaultValuesAreBoundAsFormattedStrings()
    {
        $date = new Date('dob');
        $date->defaultValue(new DateTime('12-04-1988 10:33'));

        $expected = '<input type="date" name="dob" value="1988-04-12">';
        $this->assertSame($expected, $date->render());
    }
}

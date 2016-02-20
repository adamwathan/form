<?php

use AdamWathan\Form\Elements\RadioButton;

class RadioButtonTest extends PHPUnit_Framework_TestCase
{
    use InputContractTest;

    protected function newTestSubjectInstance($name)
    {
        return new RadioButton($name);
    }

    protected function getTestSubjectType()
    {
        return 'radio';
    }

    public function testDefaultToChecked()
    {
        $checkbox = new RadioButton('above_18');
        $expected = '<input type="radio" name="above_18" value="above_18" checked="checked">';
        $result = $checkbox->defaultToChecked()->render();

        $this->assertEquals($expected, $result);

        $checkbox = new RadioButton('above_18');
        $expected = '<input type="radio" name="above_18" value="above_18">';
        $result = $checkbox->defaultToChecked()->uncheck()->render();

        $this->assertEquals($expected, $result);

        $checkbox = new RadioButton('above_18');
        $expected = '<input type="radio" name="above_18" value="above_18">';
        $result = $checkbox->uncheck()->defaultToChecked()->render();

        $this->assertEquals($expected, $result);
    }

    public function testDefaultToUnchecked()
    {
        $checkbox = new RadioButton('above_18');
        $expected = '<input type="radio" name="above_18" value="above_18">';
        $result = $checkbox->defaultToUnchecked()->render();

        $this->assertEquals($expected, $result);

        $checkbox = new RadioButton('above_18');
        $expected = '<input type="radio" name="above_18" value="above_18" checked="checked">';
        $result = $checkbox->defaultToUnchecked()->check()->render();

        $this->assertEquals($expected, $result);

        $checkbox = new RadioButton('above_18');
        $expected = '<input type="radio" name="above_18" value="above_18" checked="checked">';
        $result = $checkbox->check()->defaultToUnchecked()->render();

        $this->assertEquals($expected, $result);
    }
}

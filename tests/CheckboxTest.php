<?php

use AdamWathan\Form\Elements\Checkbox;

class CheckboxTest extends PHPUnit_Framework_TestCase
{
    use InputContractTest;

    protected function newTestSubjectInstance($name)
    {
        return new Checkbox($name);
    }

    protected function getTestSubjectType()
    {
        return 'checkbox';
    }

    protected function getTestSubjectTag()
    {
        return 'input';
    }

    public function testCanCheckCheckbox()
    {
        $checkbox = new Checkbox('terms');
        $expected = '<input type="checkbox" name="terms" value="1" checked="checked">';
        $result = $checkbox->check()->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanUncheckCheckbox()
    {
        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1">';
        $result = $checkbox->check()->uncheck()->render();

        $this->assertEquals($expected, $result);
    }

    public function testDefaultToChecked()
    {
        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1" checked="checked">';
        $result = $checkbox->defaultToChecked()->render();

        $this->assertEquals($expected, $result);

        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1">';
        $result = $checkbox->defaultToChecked()->uncheck()->render();

        $this->assertEquals($expected, $result);

        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1">';
        $result = $checkbox->uncheck()->defaultToChecked()->render();

        $this->assertEquals($expected, $result);
    }

    public function testDefaultToUnchecked()
    {
        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1">';
        $result = $checkbox->defaultToUnchecked()->render();

        $this->assertEquals($expected, $result);

        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1" checked="checked">';
        $result = $checkbox->defaultToUnchecked()->check()->render();

        $this->assertEquals($expected, $result);

        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1" checked="checked">';
        $result = $checkbox->check()->defaultToUnchecked()->render();

        $this->assertEquals($expected, $result);
    }

    public function testDefaultCheckedState()
    {
        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1" checked="checked">';
        $result = $checkbox->defaultCheckedState(true)->render();

        $this->assertEquals($expected, $result);

        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1">';
        $result = $checkbox->defaultCheckedState(false)->render();

        $this->assertEquals($expected, $result);

        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1">';
        $result = $checkbox->uncheck()->defaultCheckedState(true)->render();
        $this->assertEquals($expected, $result);

        $checkbox = new Checkbox('above_18');
        $expected = '<input type="checkbox" name="above_18" value="1" checked="checked">';
        $result = $checkbox->check()->defaultCheckedState(false)->render();

        $this->assertEquals($expected, $result);
    }
}

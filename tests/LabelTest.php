<?php

use AdamWathan\Form\Elements\Label;

class LabelTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testLabelCanBeCreated()
    {
        $label = new Label('Email');
    }

    public function testRenderBasicLabel()
    {
        $label = new Label('Email');
        $expected = '<label>Email</label>';
        $result = $label->render();

        $this->assertEquals($expected, $result);

        $label = new Label('Password');
        $expected = '<label>Password</label>';
        $result = $label->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanRenderForId()
    {
        $label = new Label('Email');

        $expected = '<label for="email">Email</label>';
        $result = $label->forId('email')->render();

        $this->assertEquals($expected, $result);
        
        $label = new Label('Password');

        $expected = '<label for="pass">Password</label>';
        $result = $label->forId('pass')->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanWrapBeforeElement()
    {
        $element = Mockery::mock('AdamWathan\Form\Elements\Element');
        $element->shouldReceive('render')->once()->andReturn('<input>');
        $label = new Label('Email');

        $expected = '<label>Email<input></label>';
        $result = $label->before($element)->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanWrapAfterElement()
    {
        $element = Mockery::mock('AdamWathan\Form\Elements\Element');
        $element->shouldReceive('render')->once()->andReturn('<input>');
        $label = new Label('Email');

        $expected = '<label><input>Email</label>';
        $result = $label->after($element)->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveElement()
    {
        $element = Mockery::mock('AdamWathan\Form\Elements\Element');
        $label = new Label('Email');
        $result = $label->after($element)->getControl();
        $this->assertEquals($element, $result);
    }
}

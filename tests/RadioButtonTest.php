<?php

use AdamWathan\Form\Elements\RadioButton;

class RadioButtonTest extends PHPUnit_Framework_TestCase
{
	public function testRadioButtonCanBeCreated()
	{
		$radio = new RadioButton('color');
	}

	public function testRenderBasicRadioButton()
	{
		$radio = new RadioButton('terms');
		$expected = '<input type="radio" name="terms" value="terms">';
		$result = $radio->render();

		$this->assertEquals($expected, $result);

		$radio = new RadioButton('above_18');
		$expected = '<input type="radio" name="above_18" value="above_18">';
		$result = $radio->render();

		$this->assertEquals($expected, $result);
	}

	public function testRenderRadioButtonWithValue()
	{
		$radio = new RadioButton('color', 'green');
		$expected = '<input type="radio" name="color" value="green">';
		$result = $radio->render();

		$this->assertEquals($expected, $result);

		$radio = new RadioButton('color', 'red');
		$expected = '<input type="radio" name="color" value="red">';
		$result = $radio->render();

		$this->assertEquals($expected, $result);
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
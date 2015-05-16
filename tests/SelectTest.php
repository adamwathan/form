<?php

use AdamWathan\Form\Elements\Select;

class SelectTest extends PHPUnit_Framework_TestCase
{
	public function testSelectCanBeCreated()
	{
		$select = new Select('birth_year');
	}

	public function testCanRenderBasicSelect()
	{
		$select = new Select('birth_year');
		$expected = '<select name="birth_year"></select>';
		$result = $select->render();
		$this->assertEquals($expected, $result);

		$select = new Select('color');
		$expected = '<select name="color"></select>';
		$result = $select->render();
		$this->assertEquals($expected, $result);
	}

	public function testSelectCanBeCreatedWithOptions()
	{
		$select = new Select('birth_year', array(1990, 1991, 1992));
		$expected = '<select name="birth_year"><option value="0">1990</option><option value="1">1991</option><option value="2">1992</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);

		$select = new Select('birth_year', array(2001, 2002, 2003));
		$expected = '<select name="birth_year"><option value="0">2001</option><option value="1">2002</option><option value="2">2003</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testSelectCanBeCreatedWithKeyValueOptions()
	{
		$select = new Select('color', array('red' => 'Red', 'blue' => 'Blue'));
		$expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit', array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanAddOption()
	{
		$select = new Select('color', array('red' => 'Red'));
		$select->addOption('blue', 'Blue');
		$expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit', array('apple' => 'Granny Smith'));
		$select->addOption('berry', 'Blueberry');
		$expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanSetOptions()
	{
		$select = new Select('color');
		$select->options(array('red' => 'Red', 'blue' => 'Blue'));
		$expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit');
		$select->options(array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanSetSelectedOption()
	{
		$select = new Select('color');
		$select->options(array('red' => 'Red', 'blue' => 'Blue'));
		$expected = '<select name="color"><option value="red">Red</option><option value="blue" selected>Blue</option></select>';
		$result = $select->select('blue')->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit');
		$select->options(array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="apple" selected>Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = $select->select('apple')->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanSelectNumericKeys()
	{
		$select = new Select('fruit');
		$select->options(array('1' => 'Granny Smith', '2' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="1" selected>Granny Smith</option><option value="2">Blueberry</option></select>';
		$result = $select->select('1')->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit');
		$select->options(array('1' => 'Granny Smith', '2' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="1">Granny Smith</option><option value="2" selected>Blueberry</option></select>';
		$result = $select->select('2')->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanSetDefaultOption()
	{
		$select = new Select('color', array('red' => 'Red', 'blue' => 'Blue'));
		$expected = '<select name="color"><option value="red">Red</option><option value="blue" selected>Blue</option></select>';
		$result = $select->defaultValue('blue')->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit', array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="apple" selected>Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = $select->defaultValue('apple')->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit', array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry" selected>Blueberry</option></select>';
		$result = $select->select('berry')->defaultValue('apple')->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit', array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry" selected>Blueberry</option></select>';
		$result = $select->defaultValue('apple')->select('berry')->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanSetDefaultOptionMultiselect()
	{
		$select = new Select('color', array('red' => 'Red', 'blue' => 'Blue'));
		$expected = '<select name="color"><option value="red" selected>Red</option><option value="blue" selected>Blue</option></select>';
		$result = $select->defaultValue(array('blue', 'red'))->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit', array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="apple" selected>Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = $select->defaultValue(array('apple'))->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit', array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry" selected>Blueberry</option></select>';
		$result = $select->select('berry')->defaultValue(array('apple', 'berry'))->render();

		$this->assertEquals($expected, $result);

		$select = new Select('fruit', array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry" selected>Blueberry</option></select>';
		$result = $select->defaultValue('apple')->select(array('berry'))->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanUseNestedOptions()
	{
		$options = array(
			'Ontario' => array(
				'toronto' => 'Toronto',
				'london' => 'London',
				),
			'Quebec' => array(
				'montreal' => 'Montreal',
				'quebec-city' => 'Quebec City',
				),
			);
		$select = new Select('color', $options);
		$expected = '<select name="color"><optgroup label="Ontario"><option value="toronto">Toronto</option><option value="london">London</option></optgroup><optgroup label="Quebec"><option value="montreal">Montreal</option><option value="quebec-city">Quebec City</option></optgroup></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanUseNestedOptionsWithoutKeys()
	{
		$options = array(
			'Ontario' => array(
				'Toronto',
				'London',
				),
			'Quebec' => array(
				'Montreal',
				'Quebec City',
				),
			);
		$select = new Select('color', $options);
		$expected = '<select name="color"><optgroup label="Ontario"><option value="0">Toronto</option><option value="1">London</option></optgroup><optgroup label="Quebec"><option value="0">Montreal</option><option value="1">Quebec City</option></optgroup></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanMixNestedAndUnnestedOptions()
	{
		$options = array(
			'toronto' => 'Toronto',
			'london' => 'London',
			'Quebec' => array(
				'montreal' => 'Montreal',
				'quebec-city' => 'Quebec City',
				),
			);
		$select = new Select('color', $options);
		$expected = '<select name="color"><option value="toronto">Toronto</option><option value="london">London</option><optgroup label="Quebec"><option value="montreal">Montreal</option><option value="quebec-city">Quebec City</option></optgroup></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testSelectCanBeCreatedWithIntegerKeyValueOptions()
	{
		$select = new Select('color', array('0' => 'Red', '1' => 'Blue'));
		$expected = '<select name="color"><option value="0">Red</option><option value="1">Blue</option></select>';
		$result = $select->render();
		$this->assertEquals($expected, $result);

		$select = new Select('fruit', array('1' => 'Granny Smith', '0' => 'Blueberry'));
		$expected = '<select name="fruit"><option value="1">Granny Smith</option><option value="0">Blueberry</option></select>';
		$result = $select->render();
		$this->assertEquals($expected, $result);
	}

	public function testSelectCanBeMultiple()
	{
		$select = new Select('people');
		$expected = '<select name="people[]" multiple="multiple"></select>';
		$result = $select->multiple()->render();

		$this->assertEquals($expected, $result);

		$select = new Select('people[]');
		$expected = '<select name="people[]" multiple="multiple"></select>';
		$result = $select->multiple()->render();

		$this->assertEquals($expected, $result);
	}
}

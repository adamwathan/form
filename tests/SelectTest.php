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
		$expected = '<select name="birth_year"><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
		
		$select = new Select('birth_year', array(2001, 2002, 2003));
		$expected = '<select name="birth_year"><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option></select>';
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
		$expected = '<select name="color"><optgroup label="Ontario"><option value="Toronto">Toronto</option><option value="London">London</option></optgroup><optgroup label="Quebec"><option value="Montreal">Montreal</option><option value="Quebec City">Quebec City</option></optgroup></select>';
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
}
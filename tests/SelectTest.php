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
		$expected = '<select name="birth_year" id="birth_year"></select>';
		$result = $select->render();
		$this->assertEquals($expected, $result);

		$select = new Select('color');
		$expected = '<select name="color" id="color"></select>';
		$result = $select->render();
		$this->assertEquals($expected, $result);
	}

	public function testSelectCanBeCreatedWithOptions()
	{
		$select = new Select('birth_year', array(1990, 1991, 1992));
		$expected = '<select name="birth_year" id="birth_year"><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
		
		$select = new Select('birth_year', array(2001, 2002, 2003));
		$expected = '<select name="birth_year" id="birth_year"><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testSelectCanBeCreatedWithKeyValueOptions()
	{
		$select = new Select('color', array('red' => 'Red', 'blue' => 'Blue'));
		$expected = '<select name="color" id="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
		
		$select = new Select('fruit', array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit" id="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanAddOption()
	{
		$select = new Select('color', array('red' => 'Red'));
		$select->addOption('blue', 'Blue');
		$expected = '<select name="color" id="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);	
		
		$select = new Select('fruit', array('apple' => 'Granny Smith'));
		$select->addOption('berry', 'Blueberry');
		$expected = '<select name="fruit" id="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanSetOptions()
	{
		$select = new Select('color');
		$select->options(array('red' => 'Red', 'blue' => 'Blue'));
		$expected = '<select name="color" id="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);	
		
		$select = new Select('fruit');
		$select->options(array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$expected = '<select name="fruit" id="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}

	public function testCanSetSelectedOption()
	{
		$select = new Select('color');
		$select->options(array('red' => 'Red', 'blue' => 'Blue'));
		$select->select('blue');
		$expected = '<select name="color" id="color"><option value="red">Red</option><option value="blue" selected>Blue</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);	
		
		$select = new Select('fruit');
		$select->options(array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$select->select('apple');
		$expected = '<select name="fruit" id="fruit"><option value="apple" selected>Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = $select->render();

		$this->assertEquals($expected, $result);
	}
}
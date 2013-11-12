<?php

use AdamWathan\Form\Elements\Date;

class DateTest extends PHPUnit_Framework_TestCase
{
	public function testDateCanBeCreated()
	{
		$date = new Date('birthday');
	}

	public function testRenderDateInput()
	{
		$date = new Date('birthday');
		$expected = '<input type="date" name="birthday">';
		$result = $date->render();
		$this->assertEquals($expected, $result);
	}
}
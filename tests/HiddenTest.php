<?php

use AdamWathan\Form\Elements\Hidden;

class HiddenTest extends PHPUnit_Framework_TestCase
{
	public function testTextCanBeCreated()
	{
		$hidden = new Hidden('_token');
	}

	public function testCanRenderBasicHidden()
	{
		$hidden = new Hidden('_token');

		$expected = '<input type="hidden" name="_token">';
		$result = $hidden->render();
		$this->assertEquals($expected, $result);

		$hidden = new Hidden('_secret');

		$expected = '<input type="hidden" name="_secret">';
		$result = $hidden->render();
		$this->assertEquals($expected, $result);
	}

	public function testCanRenderWithValue()
	{
		$hidden = new Hidden('_token');

		$expected = '<input type="hidden" name="_token" value="12345">';
		$result = $hidden->value('12345')->render();
		$this->assertEquals($expected, $result);

		$hidden = new Hidden('_secret');

		$expected = '<input type="hidden" name="_secret" value="abcdefg">';
		$result = $hidden->value('abcdefg')->render();
		$this->assertEquals($expected, $result);
	}
}
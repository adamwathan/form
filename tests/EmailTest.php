<?php

use AdamWathan\Form\Elements\Email;

class EmailTest extends PHPUnit_Framework_TestCase
{
	public function testEmailCanBeCreated()
	{
		$email = new Email('email');
	}

	public function testRenderEmailInput()
	{
		$email = new Email('email');
		$expected = '<input type="email" name="email">';
		$result = $email->render();
		$this->assertEquals($expected, $result);
	}
}
<?php

use AdamWathan\Form\Elements\Password;

class PasswordTest extends PHPUnit_Framework_TestCase
{
	public function testPasswordCanBeCreated()
	{
		$password = new Password('password');
	}
}
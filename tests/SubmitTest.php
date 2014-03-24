<?php

use AdamWathan\Form\Elements\Submit;

class SubmitTest extends PHPUnit_Framework_TestCase
{
	public function testSubmitCanBeCreated()
	{
		$submit = new Submit('Sign Up');
	}

	public function testRenderBasicSubmit()
	{
		$submit = new Submit('Sign Up');
		$expected = '<button type="submit">Sign Up</button>';
		$result = $submit->render();

		$this->assertEquals($expected, $result);

		$submit = new Submit('Log In');
		$expected = '<button type="submit">Log In</button>';
		$result = $submit->render();

		$this->assertEquals($expected, $result);
	}
}

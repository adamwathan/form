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
		$expected = '<input type="submit" value="Sign Up">';
		$result = $submit->render();

		$this->assertEquals($expected, $result);

		$submit = new Submit('Log In');
		$expected = '<input type="submit" value="Log In">';
		$result = $submit->render();

		$this->assertEquals($expected, $result);
	}
}
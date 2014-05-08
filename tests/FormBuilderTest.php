<?php

use AdamWathan\Form\FormBuilder;

class FormBuilderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->form = new FormBuilder;
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testFormBuilderCanBeCreated()
	{
		$formBuilder = new FormBuilder;
	}

	public function testFormOpen()
	{
		$expected = '<form method="POST" action="">';
		$result = $this->form->open();
		$this->assertEquals($expected, $result);
	}

	public function testCanCloseForm()
	{
		$expected = '</form>';
		$result = $this->form->close();
		$this->assertEquals($expected, $result);
	}

	public function testTextBox()
	{
		$expected = '<input type="text" name="email">';
		$result = (string)$this->form->text('email');
		$this->assertEquals($expected, $result);

		$expected = '<input type="text" name="first_name">';
		$result = (string)$this->form->text('first_name');
		$this->assertEquals($expected, $result);
	}

	public function testPassword()
	{
		$expected = '<input type="password" name="password">';
		$result = (string)$this->form->password('password');
		$this->assertEquals($expected, $result);

		$expected = '<input type="password" name="password_confirmed">';
		$result = (string)$this->form->password('password_confirmed');
		$this->assertEquals($expected, $result);
	}

	public function testCheckbox()
	{
		$expected = '<input type="checkbox" name="terms" value="1">';
		$result = (string)$this->form->checkbox('terms');
		$this->assertEquals($expected, $result);

		$expected = '<input type="checkbox" name="terms" value="agree">';
		$result = (string)$this->form->checkbox('terms', 'agree');
		$this->assertEquals($expected, $result);
	}

	public function testRadio()
	{
		$expected = '<input type="radio" name="terms" value="terms">';
		$result = (string)$this->form->radio('terms');
		$this->assertEquals($expected, $result);

		$expected = '<input type="radio" name="terms" value="agree">';
		$result = (string)$this->form->radio('terms', 'agree');
		$this->assertEquals($expected, $result);
	}

	public function testSubmit()
	{
		$expected = '<button type="submit">Sign In</button>';
		$result = (string)$this->form->submit('Sign In');
		$this->assertEquals($expected, $result);

		$expected = '<button type="submit">Log In</button>';
		$result = (string)$this->form->submit('Log In');
		$this->assertEquals($expected, $result);
	}

	public function testSelect()
	{
		$expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
		$result = (string)$this->form->select('color', array('red' => 'Red', 'blue' => 'Blue'));
		$this->assertEquals($expected, $result);

		$expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = (string)$this->form->select('fruit', array('apple' => 'Granny Smith', 'berry' => 'Blueberry'));
		$this->assertEquals($expected, $result);
	}

	public function testTextArea()
	{
		$expected = '<textarea name="bio" rows="10" cols="50"></textarea>';
		$result = (string)$this->form->textarea('bio');
		$this->assertEquals($expected, $result);

		$expected = '<textarea name="description" rows="10" cols="50"></textarea>';
		$result = (string)$this->form->textarea('description');
		$this->assertEquals($expected, $result);
	}

	public function testLabel()
	{
		$expected = '<label>Email</label>';
		$result = (string)$this->form->label('Email');
		$this->assertEquals($expected, $result);

		$expected = '<label>First Name</label>';
		$result = (string)$this->form->label('First Name');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->with('email')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('email')->andReturn('example@example.com');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="text" name="email" value="example@example.com">';
		$result = (string)$this->form->text('email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderCheckboxWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->with('terms')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('terms')->andReturn('agree');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="checkbox" name="terms" value="agree" checked="checked">';
		$result = (string)$this->form->checkbox('terms', 'agree');
		$this->assertEquals($expected, $result);
	}

	public function testRenderRadioWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->with('color')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('color')->andReturn('green');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="radio" name="color" value="green" checked="checked">';
		$result = (string)$this->form->radio('color', 'green');
		$this->assertEquals($expected, $result);
	}

	public function testRenderSelectWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->with('color')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('color')->andReturn('blue');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<select name="color"><option value="red">Red</option><option value="blue" selected>Blue</option></select>';
		$result = (string)$this->form->select('color', array('red' => 'Red', 'blue' => 'Blue'));
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextAreaWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->with('bio')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('bio')->andReturn('This is my bio');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<textarea name="bio" rows="10" cols="50">This is my bio</textarea>';
		$result = (string)$this->form->textarea('bio');
		$this->assertEquals($expected, $result);
	}

	public function testNoErrorStoreReturnsNull()
	{
		$expected = '';
		$result = (string)$this->form->getError('email');
		$this->assertEquals($expected, $result);
	}

	public function testCanCheckForErrorMessage()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->with('email')->andReturn(true);

		$this->form->setErrorStore($errorStore);

		$result = $this->form->hasError('email');
		$this->assertTrue($result);

		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->with('email')->andReturn(false);

		$this->form->setErrorStore($errorStore);

		$result = $this->form->hasError('email');
		$this->assertFalse($result);
	}

	public function testCanRetrieveErrorMessage()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->with('email')->andReturn('The e-mail address is invalid.');

		$this->form->setErrorStore($errorStore);

		$expected = 'The e-mail address is invalid.';
		$result = $this->form->getError('email');
		$this->assertEquals($expected, $result);
	}

	public function testCanRetrieveFormattedErrorMessage()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->with('email')->andReturn('The e-mail address is invalid.');

		$this->form->setErrorStore($errorStore);

		$expected = '<span class="error">The e-mail address is invalid.</span>';
		$result = $this->form->getError('email', '<span class="error">:message</span>');
		$this->assertEquals($expected, $result);
	}

	public function testFormattedErrorMessageReturnsNothingIfNoError()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->with('email')->andReturn(false);

		$this->form->setErrorStore($errorStore);

		$expected = '';
		$result = $this->form->getError('email', '<span class="error">:message</span>');
		$this->assertEquals($expected, $result);
	}

	public function testHidden()
	{
		$expected = '<input type="hidden" name="secret">';
		$result = (string)$this->form->hidden('secret');
		$this->assertEquals($expected, $result);

		$expected = '<input type="hidden" name="token">';
		$result = (string)$this->form->hidden('token');
		$this->assertEquals($expected, $result);
	}

	public function testFile()
	{
		$expected = '<input type="file" name="photo">';
		$result = (string)$this->form->file('photo');
		$this->assertEquals($expected, $result);

		$expected = '<input type="file" name="document">';
		$result = (string)$this->form->file('document');
		$this->assertEquals($expected, $result);
	}

	public function testDate()
	{
		$expected = '<input type="date" name="date_of_birth">';
		$result = (string)$this->form->date('date_of_birth');
		$this->assertEquals($expected, $result);

		$expected = '<input type="date" name="start_date">';
		$result = (string)$this->form->date('start_date');
		$this->assertEquals($expected, $result);
	}

	public function testEmail()
	{
		$expected = '<input type="email" name="email">';
		$result = (string)$this->form->email('email');
		$this->assertEquals($expected, $result);

		$expected = '<input type="email" name="alternate_email">';
		$result = (string)$this->form->email('alternate_email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderDateWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->with('date_of_birth')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('date_of_birth')->andReturn('1999-04-06');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="date" name="date_of_birth" value="1999-04-06">';
		$result = (string)$this->form->date('date_of_birth');
		$this->assertEquals($expected, $result);
	}

	public function testRenderEmailWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->with('email')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('email')->andReturn('example@example.com');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="email" name="email" value="example@example.com">';
		$result = (string)$this->form->email('email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderHiddenWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->with('secret')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('secret')->andReturn('my-secret-string');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="hidden" name="secret" value="my-secret-string">';
		$result = (string)$this->form->hidden('secret');
		$this->assertEquals($expected, $result);
	}

	public function testCanSetCsrfToken()
	{
		$this->form->setToken('12345');
	}

	public function testCanRenderCsrfToken()
	{
		$this->form->setToken('12345');

		$expected = '<input type="hidden" name="_token" value="12345">';
		$result = (string)$this->form->token();
		$this->assertEquals($expected, $result);
	}

	public function testSelectMonth()
	{
		$expected = '<select name="month"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>';
		$result = (string)$this->form->selectMonth('month');
		$this->assertEquals($expected, $result);
	}

	public function testCanBindObject()
	{
		$this->assertTrue(method_exists($this->form, 'bind'));
	}

	public function testBindEmail()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);
		$expected = '<input type="email" name="email" value="johndoe@example.com">';
		$result = (string)$this->form->email('email');
		$this->assertEquals($expected, $result);
	}

	public function testBindText()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);
		$expected = '<input type="text" name="first_name" value="John">';
		$result = (string)$this->form->text('first_name');
		$this->assertEquals($expected, $result);
	}

	public function testBindDate()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);
		$expected = '<input type="date" name="date_of_birth" value="1985-05-06">';
		$result = (string)$this->form->date('date_of_birth');
		$this->assertEquals($expected, $result);
	}

	public function testBindSelect()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);
		$expected = '<select name="gender"><option value="male" selected>Male</option><option value="female">Female</option></select>';
		$result = (string)$this->form->select('gender', array('male' => 'Male', 'female' => 'Female'));
		$this->assertEquals($expected, $result);
	}

	public function testBindHidden()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);
		$expected = '<input type="hidden" name="last_name" value="Doe">';
		$result = (string)$this->form->hidden('last_name');
		$this->assertEquals($expected, $result);
	}

	public function testOldInputTakesPrecedenceOverBinding()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->with('first_name')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('first_name')->andReturn('Steve');
		$this->form->setOldInputProvider($oldInput);

		$object = $this->getStubObject();
		$this->form->bind($object);
		$expected = '<input type="text" name="first_name" value="Steve">';
		$result = (string)$this->form->text('first_name');
		$this->assertEquals($expected, $result);
	}

	public function testBindCheckbox()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);
		$expected = '<input type="checkbox" name="terms" value="agree" checked="checked">';
		$result = (string)$this->form->checkbox('terms', 'agree');
		$this->assertEquals($expected, $result);
	}

	public function testValueTakesPrecedenceOverBinding()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);
		$expected = '<input type="text" name="first_name" value="Mike">';
		$result = (string)$this->form->text('first_name')->value('Mike');
		$this->assertEquals($expected, $result);
	}

	public function testBindUnsetProperty()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);
		$expected = '<input type="text" name="not_set">';
		$result = (string)$this->form->text('not_set');
		$this->assertEquals($expected, $result);
	}

	public function testBindMagicProperty()
	{
		$object = new MagicGetter;
		$this->form->bind($object);
		$expected = '<input type="text" name="not_set" value="foo">';
		$result = (string)$this->form->text('not_set');
		$this->assertEquals($expected, $result);
	}

	private function getStubObject()
	{
		$obj = new stdClass;
		$obj->email = 'johndoe@example.com';
		$obj->first_name = 'John';
		$obj->last_name = 'Doe';
		$obj->date_of_birth = new \DateTime('1985-05-06');
		$obj->gender = 'male';
		$obj->terms = 'agree';
		return $obj;
	}
}

class MagicGetter
{
	public function __get($key)
	{
		return 'foo';
	}
}

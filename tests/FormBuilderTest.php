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
		$result = (string) $this->form->open();
		$this->assertEquals($expected, $result);
	}

	public function testCanCloseForm()
	{
		$expected = '</form>';
		$result = (string) $this->form->close();
		$this->assertEquals($expected, $result);
	}

	public function testTextBox()
	{
		$expected = '<input type="text" name="email">';
		$result = (string) $this->form->text('email');
		$this->assertEquals($expected, $result);

		$expected = '<input type="text" name="first_name">';
		$result = (string) $this->form->text('first_name');
		$this->assertEquals($expected, $result);
	}

	public function testPassword()
	{
		$expected = '<input type="password" name="password">';
		$result = (string) $this->form->password('password');
		$this->assertEquals($expected, $result);

		$expected = '<input type="password" name="password_confirmed">';
		$result = (string) $this->form->password('password_confirmed');
		$this->assertEquals($expected, $result);
	}

	public function testCheckbox()
	{
		$expected = '<input type="checkbox" name="terms" value="1">';
		$result = (string) $this->form->checkbox('terms');
		$this->assertEquals($expected, $result);

		$expected = '<input type="checkbox" name="terms" value="agree">';
		$result = (string) $this->form->checkbox('terms', 'agree');
		$this->assertEquals($expected, $result);

		$expected = '<input type="checkbox" name="terms" value="agree">';
		$result = (string) $this->form->checkbox('terms')->value('agree');
		$this->assertEquals($expected, $result);
	}

	public function testRadio()
	{
		$expected = '<input type="radio" name="terms" value="terms">';
		$result = (string) $this->form->radio('terms');
		$this->assertEquals($expected, $result);

		$expected = '<input type="radio" name="terms" value="agree">';
		$result = (string) $this->form->radio('terms', 'agree');
		$this->assertEquals($expected, $result);

		$expected = '<input type="radio" name="terms" value="agree">';
		$result = (string) $this->form->radio('terms')->value('agree');
		$this->assertEquals($expected, $result);
	}

	public function testSubmit()
	{
		$expected = '<button type="submit">Sign In</button>';
		$result = (string) $this->form->submit('Sign In');
		$this->assertEquals($expected, $result);
	}

	/**
	 * @dataProvider buttonProvider
	 */
	public function testButton($value, $name, $expected)
	{
		$result = (string) $this->form->button($value, $name);
		$this->assertEquals($expected, $result);
	}

	public function buttonProvider()
	{
		return [
			['Click Me', 'click-me', '<button type="button" name="click-me">Click Me</button>'],
			['Click Me', null, '<button type="button">Click Me</button>'],
		];
	}

	public function testSelect()
	{
		$expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
		$result = (string) $this->form->select('color', ['red' => 'Red', 'blue' => 'Blue']);
		$this->assertEquals($expected, $result);

		$expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
		$result = (string) $this->form->select('fruit', ['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
		$this->assertEquals($expected, $result);
	}

	public function testTextArea()
	{
		$expected = '<textarea name="bio" rows="10" cols="50"></textarea>';
		$result = (string) $this->form->textarea('bio');
		$this->assertEquals($expected, $result);

		$expected = '<textarea name="description" rows="10" cols="50"></textarea>';
		$result = (string) $this->form->textarea('description');
		$this->assertEquals($expected, $result);
	}

	public function testLabel()
	{
		$expected = '<label>Email</label>';
		$result = (string) $this->form->label('Email');
		$this->assertEquals($expected, $result);

		$expected = '<label>First Name</label>';
		$result = (string) $this->form->label('First Name');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('title')->andReturn('Hello "quotes"');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="text" name="title" value="Hello &quot;quotes&quot;">';
		$result = (string) $this->form->text('title');
		$this->assertEquals($expected, $result);
	}

	public function testRenderCheckboxWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('terms')->andReturn('agree');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="checkbox" name="terms" value="agree" checked="checked">';
		$result = (string) $this->form->checkbox('terms', 'agree');
		$this->assertEquals($expected, $result);

		$expected = '<input type="checkbox" name="terms" value="agree" checked="checked">';
		$result = (string) $this->form->checkbox('terms')->value('agree');
		$this->assertEquals($expected, $result);
	}

	public function testRenderCheckboxArrayWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('favourite_foods')->andReturn(['fish', 'chips']);

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="checkbox" name="favourite_foods[]" value="fish" checked="checked">';
		$result = (string) $this->form->checkbox('favourite_foods[]', 'fish');
		$this->assertEquals($expected, $result);

		$expected = '<input type="checkbox" name="favourite_foods[]" value="tofu">';
		$result = (string) $this->form->checkbox('favourite_foods[]', 'tofu');
		$this->assertEquals($expected, $result);

		$expected = '<input type="checkbox" name="favourite_foods[]" value="chips" checked="checked">';
		$result = (string) $this->form->checkbox('favourite_foods[]', 'chips');
		$this->assertEquals($expected, $result);
	}

	public function testRenderRadioWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('color')->andReturn('green');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="radio" name="color" value="green" checked="checked">';
		$result = (string) $this->form->radio('color', 'green');
		$this->assertEquals($expected, $result);

		$expected = '<input type="radio" name="color" value="green" checked="checked">';
		$result = (string) $this->form->radio('color')->value('green');
		$this->assertEquals($expected, $result);
	}

	public function testExplicitUncheckOnCheckboxTakesPrecedenceOverOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('terms')->andReturn('agree');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="checkbox" name="terms" value="agree">';
		$result = (string) $this->form->checkbox('terms', 'agree')->uncheck();
		$this->assertEquals($expected, $result);
	}

	public function testExplicitUncheckOnRadioTakesPrecedenceOverOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('color')->andReturn('green');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="radio" name="color" value="green">';
		$result = (string) $this->form->radio('color', 'green')->uncheck();
		$this->assertEquals($expected, $result);
	}

	public function testExplicitCheckOnCheckboxTakesPrecedenceOverOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('terms')->andReturn('agree');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="checkbox" name="terms" value="agree" checked="checked">';
		$result = (string) $this->form->checkbox('terms', 'agree')->check();
		$this->assertEquals($expected, $result);
	}

	public function testExplicitCheckOnRadioTakesPrecedenceOverOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('color')->andReturn('green');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="radio" name="color" value="green" checked="checked">';
		$result = (string) $this->form->radio('color', 'green')->check();
		$this->assertEquals($expected, $result);
	}

    public function testOldInputOnCheckboxTakesPrecedenceOverDefaultToChecked()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('published')->andReturn('0');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="checkbox" name="published" value="1">';
		$result = (string) $this->form->checkbox('published', 1)->defaultToChecked();
		$this->assertEquals($expected, $result);
	}

	public function testOldInputOnCheckboxTakesPrecedenceOverDefaultToUnchecked()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('published')->andReturn('1');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="checkbox" name="published" value="1" checked="checked">';
		$result = (string) $this->form->checkbox('published', 1)->defaultToUnchecked();
		$this->assertEquals($expected, $result);
	}

	public function testOldInputOnRadioTakesPrecedenceOverDefaultToChecked()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('published')->andReturn('0');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="radio" name="published" value="1">';
		$result = (string) $this->form->radio('published', 1)->defaultToChecked();
		$this->assertEquals($expected, $result);
	}

	public function testOldInputOnRadioTakesPrecedenceOverDefaultToUnchecked()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('published')->andReturn('1');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="radio" name="published" value="1" checked="checked">';
		$result = (string) $this->form->radio('published', 1)->defaultToUnchecked();
		$this->assertEquals($expected, $result);
	}

	public function testRenderCheckboxAgainstBinaryZero()
	{
		$expected = '<input type="checkbox" name="boolean" value="0">';
		$result = (string) $this->form->checkbox('boolean', 0);
		$this->assertEquals($expected, $result);
	}

	public function testRenderCheckboxAgainstBinaryOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('agree_to_terms')->andReturn('1');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="checkbox" name="agree_to_terms" value="1" checked="checked">';
		$result = (string) $this->form->checkbox('agree_to_terms', 1);
		$this->assertEquals($expected, $result);
	}

	public function testRenderRadioAgainstBinaryZero()
	{
		$expected = '<input type="radio" name="boolean" value="0">';
		$result = (string) $this->form->radio('boolean', 0);
		$this->assertEquals($expected, $result);
	}

	public function testRenderSelectWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('color')->andReturn('blue');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<select name="color"><option value="red">Red</option><option value="blue" selected>Blue</option></select>';
		$result = (string) $this->form->select('color', ['red' => 'Red', 'blue' => 'Blue']);
		$this->assertEquals($expected, $result);

		$expected = '<select name="color"><option value="red">Red</option><option value="blue" selected>Blue</option></select>';
		$result = (string) $this->form->select('color')->options(['red' => 'Red', 'blue' => 'Blue']);
		$this->assertEquals($expected, $result);
	}

	public function testRenderMultipleSelectWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
	    $oldInput->shouldReceive('hasOldInput')->andReturn(true);
	    $oldInput->shouldReceive('getOldInput')->with('favourite_foods')->andReturn(['fish', 'chips']);

	    $this->form->setOldInputProvider($oldInput);

		$expected  = '<select name="favourite_foods[]" multiple="multiple">';
		$expected .= '<option value="fish" selected>Fish</option>';
		$expected .= '<option value="tofu">Tofu</option>';
		$expected .= '<option value="chips" selected>Chips</option>';
		$expected .= '</select>';
		$result = (string) $this->form->select('favourite_foods', ['fish' => 'Fish', 'tofu' => 'Tofu', 'chips' => 'Chips'])->multiple();
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextAreaWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('bio')->andReturn('This is my bio');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<textarea name="bio" rows="10" cols="50">This is my bio</textarea>';
		$result = (string) $this->form->textarea('bio');
		$this->assertEquals($expected, $result);
	}

	public function testRenderingTextAreaWithOldInputEscapesDangerousCharacters()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('bio')->andReturn('<script>alert("xss!");</script>');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<textarea name="bio" rows="10" cols="50">&lt;script&gt;alert(&quot;xss!&quot;);&lt;/script&gt;</textarea>';
		$result = (string) $this->form->textarea('bio');
		$this->assertEquals($expected, $result);
	}

	public function testNoErrorStoreReturnsNull()
	{
		$expected = '';
		$result = (string) $this->form->getError('email');
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
		$result = (string) $this->form->hidden('secret');
		$this->assertEquals($expected, $result);

		$expected = '<input type="hidden" name="token">';
		$result = (string) $this->form->hidden('token');
		$this->assertEquals($expected, $result);
	}

	public function testFile()
	{
		$expected = '<input type="file" name="photo">';
		$result = (string) $this->form->file('photo');
		$this->assertEquals($expected, $result);

		$expected = '<input type="file" name="document">';
		$result = (string) $this->form->file('document');
		$this->assertEquals($expected, $result);
	}

	public function testDate()
	{
		$expected = '<input type="date" name="date_of_birth">';
		$result = (string) $this->form->date('date_of_birth');
		$this->assertEquals($expected, $result);

		$expected = '<input type="date" name="start_date">';
		$result = (string) $this->form->date('start_date');
		$this->assertEquals($expected, $result);
	}

	public function testEmail()
	{
		$expected = '<input type="email" name="email">';
		$result = (string) $this->form->email('email');
		$this->assertEquals($expected, $result);

		$expected = '<input type="email" name="alternate_email">';
		$result = (string) $this->form->email('alternate_email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderDateWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('date_of_birth')->andReturn('1999-04-06');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="date" name="date_of_birth" value="1999-04-06">';
		$result = (string) $this->form->date('date_of_birth');
		$this->assertEquals($expected, $result);
	}

	public function testRenderEmailWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('email')->andReturn('example@example.com');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="email" name="email" value="example@example.com">';
		$result = (string) $this->form->email('email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderHiddenWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('secret')->andReturn('my-secret-string');

		$this->form->setOldInputProvider($oldInput);

		$expected = '<input type="hidden" name="secret" value="my-secret-string">';
		$result = (string) $this->form->hidden('secret');
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
		$result = (string) $this->form->token();
		$this->assertEquals($expected, $result);
	}

	public function testTokenIsRenderedAutomaticallyOnOpenIfSet()
	{
		$this->form->setToken('12345');

		$expected = '<form method="POST" action=""><input type="hidden" name="_token" value="12345">';
		$result = (string) $this->form->open();
		$this->assertEquals($expected, $result);
	}

	public function testTokenIsNotRenderedAutomaticallyOnOpenFormWithGetMethodIfSet()
	{
		$this->form->setToken('12345');

		$expected = '<form method="GET" action="">';
		$result = (string) $this->form->open()->get();
		$this->assertEquals($expected, $result);
	}

	public function testSelectMonth()
	{
		$expected = '<select name="month"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>';
		$result = (string) $this->form->selectMonth('month');
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
		$result = (string) $this->form->email('email');
		$this->assertEquals($expected, $result);
	}

	public function testBindText()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="text" name="first_name" value="John">';
		$result = (string) $this->form->text('first_name');
		$this->assertEquals($expected, $result);
	}

	public function testBindTextWithIntegerZero()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="text" name="number" value="0">';
		$result = (string) $this->form->text('number');
		$this->assertEquals($expected, $result);
	}

	public function testBindDate()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="date" name="date_of_birth" value="1985-05-06">';
		$result = (string) $this->form->date('date_of_birth');
		$this->assertEquals($expected, $result);
	}

	public function testBindSelect()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<select name="gender"><option value="male" selected>Male</option><option value="female">Female</option></select>';
		$result = (string) $this->form->select('gender', ['male' => 'Male', 'female' => 'Female']);
		$this->assertEquals($expected, $result);
	}

	public function testBindMultipleSelect()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected  = '<select name="favourite_foods[]" multiple="multiple">';
		$expected .= '<option value="fish" selected>Fish</option>';
		$expected .= '<option value="tofu">Tofu</option>';
		$expected .= '<option value="chips" selected>Chips</option>';
		$expected .= '</select>';
		$result = (string) $this->form->select('favourite_foods', ['fish' => 'Fish', 'tofu' => 'Tofu', 'chips' => 'Chips'])->multiple();
		$this->assertEquals($expected, $result);
	}

	public function testBindHidden()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="hidden" name="last_name" value="Doe">';
		$result = (string) $this->form->hidden('last_name');
		$this->assertEquals($expected, $result);
	}

	public function testOldInputTakesPrecedenceOverBinding()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->with('first_name')->andReturn('Steve');
		$this->form->setOldInputProvider($oldInput);

		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="text" name="first_name" value="Steve">';
		$result = (string) $this->form->text('first_name');
		$this->assertEquals($expected, $result);
	}

	public function testBindCheckbox()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="checkbox" name="terms" value="agree" checked="checked">';
		$result = (string) $this->form->checkbox('terms', 'agree');
		$this->assertEquals($expected, $result);
	}

	public function testBindCheckboxArray()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="checkbox" name="favourite_foods[]" value="fish" checked="checked">';
		$result = (string) $this->form->checkbox('favourite_foods[]', 'fish');
		$this->assertEquals($expected, $result);

		$expected = '<input type="checkbox" name="favourite_foods[]" value="tofu">';
		$result = (string) $this->form->checkbox('favourite_foods[]', 'tofu');
		$this->assertEquals($expected, $result);

		$expected = '<input type="checkbox" name="favourite_foods[]" value="chips" checked="checked">';
		$result = (string) $this->form->checkbox('favourite_foods[]', 'chips');
		$this->assertEquals($expected, $result);
	}

	public function testValueTakesPrecedenceOverBinding()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="text" name="first_name" value="Mike">';
		$result = (string) $this->form->text('first_name')->value('Mike');
		$this->assertEquals($expected, $result);
	}

	public function testExplicitUncheckOnCheckboxTakesPrecedenceOverBinding()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="radio" name="terms" value="agree">';
		$result = (string) $this->form->radio('terms', 'agree')->uncheck();
		$this->assertEquals($expected, $result);
	}

	public function testExplicitUncheckOnRadioTakesPrecedenceOverBinding()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="radio" name="color" value="green">';
		$result = (string) $this->form->radio('color', 'green')->uncheck();
		$this->assertEquals($expected, $result);
	}

	public function testExplicitCheckOnCheckboxTakesPrecedenceOverBinding()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="radio" name="terms" value="agree" checked="checked">';
		$result = (string) $this->form->radio('terms', 'agree')->check();
		$this->assertEquals($expected, $result);
	}

	public function testExplicitCheckOnRadioTakesPrecedenceOverBinding()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="radio" name="color" value="green" checked="checked">';
		$result = (string) $this->form->radio('color', 'green')->check();
		$this->assertEquals($expected, $result);
	}

	public function testBindingOnCheckboxTakesPrecedenceOverDefaultToChecked()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected  = '<input type="checkbox" name="published[]" value="1" checked="checked">';
		$expected .= '<input type="checkbox" name="published[]" value="0">';
		$result  = (string) $this->form->checkbox('published[]', 1);
		$result .= (string) $this->form->checkbox('published[]', 0)->defaultToChecked();
		$this->assertEquals($expected, $result);
	}

	public function testBindingOnCheckboxTakesPrecedenceOverDefaultToUnchecked()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected  = '<input type="checkbox" name="published[]" value="1" checked="checked">';
		$expected .= '<input type="checkbox" name="published[]" value="0">';
		$result  = (string) $this->form->checkbox('published[]', 1)->defaultToUnchecked();
		$result .= (string) $this->form->checkbox('published[]', 0);
		$this->assertEquals($expected, $result);
	}

	public function testBindingOnRadioTakesPrecedenceOverDefaultToChecked()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected  = '<input type="radio" name="published[]" value="1" checked="checked">';
		$expected .= '<input type="radio" name="published[]" value="0">';
		$result  = (string) $this->form->radio('published[]', 1);
		$result .= (string) $this->form->radio('published[]', 0)->defaultToChecked();
		$this->assertEquals($expected, $result);
	}

	public function testBindingOnRadioTakesPrecedenceOverDefaultToUnchecked()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected  = '<input type="radio" name="published[]" value="1" checked="checked">';
		$expected .= '<input type="radio" name="published[]" value="0">';
		$result  = (string) $this->form->radio('published[]', 1)->defaultToUnchecked();
		$result .= (string) $this->form->radio('published[]', 0);
		$this->assertEquals($expected, $result);
	}

	public function testBindUnsetProperty()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);

		$expected = '<input type="text" name="not_set">';
		$result = (string) $this->form->text('not_set');
		$this->assertEquals($expected, $result);
	}

	public function testBindMagicProperty()
	{
		$object = new MagicGetter;
		$this->form->bind($object);

		$expected = '<input type="text" name="not_set" value="foo">';
		$result = (string) $this->form->text('not_set');
		$this->assertEquals($expected, $result);
	}

	public function testBindArray()
	{
		$model = ['first_name' => 'John'];
		$this->form->bind($model);

		$expected = '<input type="text" name="first_name" value="John">';
		$result = (string) $this->form->text('first_name');
		$this->assertEquals($expected, $result);
	}

	public function testCloseUnbindsModel()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);
		$this->form->close();

		$expected = '<input type="text" name="first_name">';
		$result = (string) $this->form->text('first_name');
		$this->assertEquals($expected, $result);
	}

	public function testAgainstXSSAttacksInBoundModels()
	{
		$object = $this->getStubObject();
		$object->first_name = '" onmouseover="alert(\'xss\')';
		$this->form->bind($object);

		$expected = '<input type="text" name="first_name" value="&quot; onmouseover=&quot;alert(&#039;xss&#039;)">';
		$result = (string) $this->form->text('first_name');
		$this->assertEquals($expected, $result);
	}

	public function testRemoveClass()
	{
		$expected = '<input type="text" name="food">';
		$result = (string) $this->form->text('food')->addClass('sandwich pizza')->removeClass('sandwich')->removeClass('pizza');
		$this->assertEquals($expected, $result);
	}

	public function testGetTypeAttribute()
	{
		$expected = 'radio';
		$result = $this->form->radio('fm-transmission')->getAttribute('type');
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
		$obj->color = 'green';
		$obj->number = '0';
		$obj->favourite_foods = ['fish', 'chips'];
		$obj->published = '1';
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

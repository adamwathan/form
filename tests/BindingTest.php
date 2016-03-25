<?php

use AdamWathan\Form\FormBuilder;

class BindingTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->form = new FormBuilder;
    }

    public function tearDown()
    {
        Mockery::close();
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

        $expected  = '<select name="favourite_foods[]" multiple>';
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

    public function testBindCheckbox()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);

        $expected = '<input type="checkbox" name="terms" value="agree" checked>';
        $result = (string) $this->form->checkbox('terms', 'agree');
        $this->assertEquals($expected, $result);
    }

    public function testBindCheckboxArray()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);

        $expected = '<input type="checkbox" name="favourite_foods[]" value="fish" checked>';
        $result = (string) $this->form->checkbox('favourite_foods[]', 'fish');
        $this->assertEquals($expected, $result);

        $expected = '<input type="checkbox" name="favourite_foods[]" value="tofu">';
        $result = (string) $this->form->checkbox('favourite_foods[]', 'tofu');
        $this->assertEquals($expected, $result);

        $expected = '<input type="checkbox" name="favourite_foods[]" value="chips" checked>';
        $result = (string) $this->form->checkbox('favourite_foods[]', 'chips');
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

    public function testValueTakesPrecedenceOverBinding()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);

        $expected = '<input type="text" name="first_name" value="Mike">';
        $result = (string) $this->form->text('first_name')->value('Mike');
        $this->assertEquals($expected, $result);
    }

    public function testBindingOnCheckboxTakesPrecedenceOverDefaultToChecked()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);

        $expected  = '<input type="checkbox" name="published[]" value="1" checked>';
        $expected .= '<input type="checkbox" name="published[]" value="0">';
        $result  = (string) $this->form->checkbox('published[]', 1);
        $result .= (string) $this->form->checkbox('published[]', 0)->defaultToChecked();
        $this->assertEquals($expected, $result);
    }

    public function testBindingOnCheckboxTakesPrecedenceOverDefaultToUnchecked()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);

        $expected  = '<input type="checkbox" name="published[]" value="1" checked>';
        $expected .= '<input type="checkbox" name="published[]" value="0">';
        $result  = (string) $this->form->checkbox('published[]', 1)->defaultToUnchecked();
        $result .= (string) $this->form->checkbox('published[]', 0);
        $this->assertEquals($expected, $result);
    }

    public function testBindingOnRadioTakesPrecedenceOverDefaultToChecked()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);

        $expected  = '<input type="radio" name="published[]" value="1" checked>';
        $expected .= '<input type="radio" name="published[]" value="0">';
        $result  = (string) $this->form->radio('published[]', 1);
        $result .= (string) $this->form->radio('published[]', 0)->defaultToChecked();
        $this->assertEquals($expected, $result);
    }

    public function testBindingOnRadioTakesPrecedenceOverDefaultToUnchecked()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);

        $expected  = '<input type="radio" name="published[]" value="1" checked>';
        $expected .= '<input type="radio" name="published[]" value="0">';
        $result  = (string) $this->form->radio('published[]', 1)->defaultToUnchecked();
        $result .= (string) $this->form->radio('published[]', 0);
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

        $expected = '<input type="radio" name="terms" value="agree" checked>';
        $result = (string) $this->form->radio('terms', 'agree')->check();
        $this->assertEquals($expected, $result);
    }

    public function testExplicitCheckOnRadioTakesPrecedenceOverBinding()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);

        $expected = '<input type="radio" name="color" value="green" checked>';
        $result = (string) $this->form->radio('color', 'green')->check();
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

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

    public function testBindDateTimeLocal()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);

        $expected = '<input type="datetime-local" name="date_and_time_of_birth" value="1985-05-06T16:39">';
        $result = (string) $this->form->dateTimeLocal('date_and_time_of_birth');
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

        $expected = '<input type="text" name="not_magic" value="foo">';
        $result = (string) $this->form->text('not_magic');
        $this->assertEquals($expected, $result);

        $expected = '<input type="text" name="magic" value="bar">';
        $result = (string) $this->form->text('magic');
        $this->assertEquals($expected, $result);
    }

    public function testBindArray()
    {
        $array = ['first_name' => 'John'];
        $this->form->bind($array);

        $expected = '<input type="text" name="first_name" value="John">';
        $result = (string) $this->form->text('first_name');
        $this->assertEquals($expected, $result);
    }

    public function testBindArrayWithMissingKey()
    {
        $array = ['first_name' => 'John'];
        $this->form->bind($array);

        $expected = '<input type="text" name="last_name">';
        $result = (string) $this->form->text('last_name');
        $this->assertEquals($expected, $result);
    }

    public function testBindNestedArray()
    {
        $array = [
            'address' => [
                'city' => 'Roswell',
                'tree' => [
                    'has' => [
                        'nested' => 'Bird'
                    ]
                ],
            ],
        ];
        $this->form->bind($array);

        $expected = '<input type="text" name="address[city]" value="Roswell">';
        $result = (string) $this->form->text('address[city]');
        $this->assertEquals($expected, $result);

        $expected = '<input type="text" name="address[tree][has][nested]" value="Bird">';
        $result = (string) $this->form->text('address[tree][has][nested]');
        $this->assertEquals($expected, $result);
    }

    public function testBindNestedArrayWithMissingKey()
    {
        $array = [
            'address' => [
                'tree' => [
                    'nested' => 'Bird'
                ],
            ],
        ];

        $this->form->bind($array);

        $expected = '<input type="text" name="address[notSet]">';
        $result = (string) $this->form->text('address[notSet]');
        $this->assertEquals($expected, $result);
    }

    public function testBindArrayWithZeroAsKey()
    {
        $array = [
            'hotdog' => [
                0 => 'Tube',
                1 => 'Steak',
            ],
        ];

        $this->form->bind($array);

        $expected = '<input type="text" name="hotdog[0]" value="Tube">';
        $result = (string) $this->form->text('hotdog[0]');
        $this->assertEquals($expected, $result);

        $expected = '<input type="text" name="hotdog[1]" value="Steak">';
        $result = (string) $this->form->text('hotdog[1]');
        $this->assertEquals($expected, $result);
    }

    public function testBindNestedObject()
    {
        $object = json_decode(json_encode([
            'address' => [
                'city' => 'Roswell',
                'tree' => [
                    'has' => [
                        'nested' => 'Bird'
                    ]
                ],
            ],
        ]));
        $this->form->bind($object);

        $expected = '<input type="text" name="address[city]" value="Roswell">';
        $result = (string) $this->form->text('address[city]');
        $this->assertEquals($expected, $result);

        $expected = '<input type="text" name="address[tree][has][nested]" value="Bird">';
        $result = (string) $this->form->text('address[tree][has][nested]');
        $this->assertEquals($expected, $result);
    }

    public function testBindNestedMixed()
    {
        $object = [
            'address' => [
                'city' => 'Roswell',
                'tree' => json_decode(json_encode([
                    'has' => [
                        'nested' => 'Bird'
                    ]
                ])),
            ],
        ];
        $this->form->bind($object);

        $expected = '<input type="text" name="address[city]" value="Roswell">';
        $result = (string) $this->form->text('address[city]');
        $this->assertEquals($expected, $result);

        $expected = '<input type="text" name="address[tree][has][nested]" value="Bird">';
        $result = (string) $this->form->text('address[tree][has][nested]');
        $this->assertEquals($expected, $result);
    }

    public function testCloseUnbindsData()
    {
        $object = $this->getStubObject();
        $this->form->bind($object);
        $this->form->close();

        $expected = '<input type="text" name="first_name">';
        $result = (string) $this->form->text('first_name');
        $this->assertEquals($expected, $result);
    }

    public function testAgainstXSSAttacksInBoundData()
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
        $object = (object) ['published' => 1];
        $this->form->bind($object);

        $expected  = '<input type="checkbox" name="published[]" value="1" checked="checked">';
        $result  = (string) $this->form->checkbox('published[]', 1);
        $this->assertEquals($expected, $result);

        $object = (object) ['published' => 0];
        $this->form->bind($object);

        $expected = '<input type="checkbox" name="published[]" value="1">';
        $result = (string) $this->form->checkbox('published[]', 1)->defaultToChecked();
        $this->assertEquals($expected, $result);

        $object = (object) ['published' => true];
        $this->form->bind($object);

        $expected = '<input type="checkbox" name="published[]" value="1" checked="checked">';
        $result = (string) $this->form->checkbox('published[]', 1);
        $this->assertEquals($expected, $result);

        $object = (object) ['published' => false];
        $this->form->bind($object);

        $expected = '<input type="checkbox" name="published[]" value="1">';
        $result = (string) $this->form->checkbox('published[]', 1)->defaultToChecked();
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

    private function getStubObject()
    {
        $obj = new stdClass;

        $obj->email = 'johndoe@example.com';
        $obj->first_name = 'John';
        $obj->last_name = 'Doe';
        $obj->date_of_birth = new \DateTime('1985-05-06');
        $obj->date_and_time_of_birth = new \DateTime('1985-05-06 16:39');
        $obj->gender = 'male';
        $obj->terms = 'agree';
        $obj->color = 'green';
        $obj->number = '0';
        $obj->favourite_foods = ['fish', 'chips'];
        $obj->published = '1';
        $obj->private = false;

        return $obj;
    }
}

class MagicGetter
{
    public $not_magic = 'foo';

    public function __get($key)
    {
        return 'bar';
    }
}

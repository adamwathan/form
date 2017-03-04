<?php

trait InputContractTest
{
    abstract protected function newTestSubjectInstance($name);

    abstract protected function getTestSubjectType();

    protected function elementRegExp($attributes)
    {
        return '/\A<input type="' . $this->getTestSubjectType() . '" .*?' . $attributes . '( .*?|)>\z/';
    }

    public function testTextCanBeCreated()
    {
        $this->assertNotNull($this->newTestSubjectInstance('email'));
    }

    public function testRequired()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->required()->render();

        $message = "required attribute should be set";
        $this->assertRegExp($this->elementRegExp('required="required"'), $result, $message);
    }

    public function testConditionalRequired()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->required(false)->render();

        $message = "required attribute shouldnt be set";
        $this->assertNotRegExp($this->elementRegExp('required="required"'), $result, $message);
    }

    public function testAutofocus()
    {
        $text = $this->newTestSubjectInstance('');
        $result = $text->autofocus()->render();

        $message = "autofocus attribute should be set";
        $this->assertRegExp($this->elementRegExp('autofocus="autofocus"'), $result, $message);
    }

    public function testUnfocus()
    {
        $pattern = 'autofocus="autofocus"';

        $text = $this->newTestSubjectInstance('');
        $result = $text->unfocus()->render();

        $message = "autofocus attribute should not be set";
        $this->assertNotRegExp($this->elementRegExp($pattern), $result, $message);

        $text = $this->newTestSubjectInstance('');
        $result = $text->autofocus()->unfocus()->render();

        $message = "autofocus attribute should be removed";
        $this->assertNotRegExp($this->elementRegExp($pattern), $result, $message);
    }

    public function testOptional()
    {
        $pattern = 'required="required"';

        $text = $this->newTestSubjectInstance('email');
        $result = $text->optional()->render();

        $message = 'required attribute should not be set';
        $this->assertNotRegExp($this->elementRegExp($pattern), $result, $message);

        $text = $this->newTestSubjectInstance('email');
        $result = $text->required()->optional()->render();

        $message = 'required attribute should be removed';
        $this->assertNotRegExp($this->elementRegExp($pattern), $result, $message);
    }

    public function testDisable()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->disable()->render();

        $message = 'disabled attribute should be set';
        $this->assertRegExp($this->elementRegExp('disabled="disabled"'), $result, $message);
    }

    public function testConditionalDisable()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->required(false)->render();

        $message = "disabled attribute shouldnt be set";
        $this->assertNotRegExp($this->elementRegExp('disabled="disabled"'), $result, $message);
    }

    public function testReadyOnly()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->readonly()->render();

        $message = 'readonly attribute should be set';
        $this->assertRegExp($this->elementRegExp('readonly="readonly"'), $result, $message);
    }

    public function testConditionalReadyOnly()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->required(false)->render();

        $message = "readonly attribute shouldnt be set";
        $this->assertNotRegExp($this->elementRegExp('readonly="readonly"'), $result, $message);
    }

    public function testEnableDisabled()
    {
        $pattern = 'disabled="disabled"';

        $text = $this->newTestSubjectInstance('email');
        $result = $text->enable()->render();

        $message = 'disabled attribute should not be set';
        $this->assertNotRegExp($this->elementRegExp($pattern), $result, $message);

        $text = $this->newTestSubjectInstance('email');
        $result = $text->disable()->enable()->render();

        $message = 'disabled attribute should not be removed';
        $this->assertNotRegExp($this->elementRegExp('disabled="disabled"'), $result, $message);
    }

    public function testEnableReadOnly()
    {
        $pattern = 'readonly="readonly"';

        $text = $this->newTestSubjectInstance('email');
        $result = $text->enable()->render();

        $message = 'readonly attribute should not be set';
        $this->assertNotRegExp($this->elementRegExp($pattern), $result, $message);

        $text = $this->newTestSubjectInstance('email');
        $result = $text->readonly()->enable()->render();

        $message = 'readonly attribute should not be removed';
        $this->assertNotRegExp($this->elementRegExp('readonly="readonly"'), $result, $message);
    }

    public function testCanBeCastToString()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = $text->render();
        $result = (string) $text;
        $message = 'Casting input element to string should return the rendered element';
        $this->assertEquals($expected, $result, $message);
    }

    public function testCanRenderBasicFormControl()
    {
        $text = $this->newTestSubjectInstance('email');

        $result = $text->render();
        $message = 'name attribute should be set';
        $this->assertRegExp($this->elementRegExp('name="email"'), $result, $message);

        $text = $this->newTestSubjectInstance('first_name');

        $result = $text->render();
        $message = 'name attribute should be changed';
        $this->assertRegExp($this->elementRegExp('name="first_name"'), $result, $message);
    }

    public function testCanRenderWithId()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->id('email_field');

        $result = $text->render();
        $message = 'id attribute should be set';
        $this->assertRegExp($this->elementRegExp('id="email_field"'), $result, $message);

        $text = $this->newTestSubjectInstance('first_name');
        $text = $text->id('name_field');

        $result = $text->render();
        $message = 'id attribute should be changed';
        $this->assertRegExp($this->elementRegExp('id="name_field"'), $result, $message);
    }

    public function testCanRenderWithValue()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->value('example@example.com');

        $result = $text->render();
        $message ='value attribute should be set';
        $this->assertRegExp($this->elementRegExp('value="example@example.com"'), $result, $message);

        $text = $this->newTestSubjectInstance('first_name');
        $text = $text->value('test@test.com');

        $result = $text->render();
        $message = 'value attribute should be changed';
        $this->assertRegExp($this->elementRegExp('value="test@test.com"'), $result, $message);

        $text = $this->newTestSubjectInstance('first_name');
        $text = $text->value(null);

        $result = $text->render();
        $message = 'value attribute should be removed';
        $this->assertNotRegExp($this->elementRegExp('value="test@test.com"'), $result, $message);
    }

    public function testCanRenderWithClass()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->addClass('error');

        $result = $text->render();
        $message = 'class attribute should be set';
        $this->assertRegExp($this->elementRegExp('class="error"'), $result, $message);

        $text = $this->newTestSubjectInstance('email');
        $text = $text->addClass('success');

        $result = $text->render();
        $message = 'class attribute should be changed';
        $this->assertRegExp($this->elementRegExp('class="success"'), $result, $message);
    }

    public function testCanRenderWithPlaceholder()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->placeholder('error');

        $result = $text->render();
        $message = 'placeholder attribute should be set';
        $this->assertRegExp($this->elementRegExp('placeholder="error"'), $result, $message);

        $text = $this->newTestSubjectInstance('email');
        $text = $text->placeholder('success');

        $result = $text->render();
        $message = 'placeholder attribute should be removed';
        $this->assertRegExp($this->elementRegExp('placeholder="success"'), $result, $message);
    }

    public function testCustomAttribute()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->attribute('custom', 'test-value')->render();

        $message = 'custom attribute should be set';
        $this->assertRegExp($this->elementRegExp('custom="test-value"'), $result, $message);
        $result = $text->clear('custom')->render();

        $message = 'custom attribute should be removed';
        $this->assertNotRegExp($this->elementRegExp('custom="test-value"'), $result, $message);
    }

    public function testDataAttribute()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->data('sample', 'test-value')->render();

        $message = 'data-sample attribute should be set';
        $this->assertRegExp($this->elementRegExp('data-sample="test-value"'), $result, $message);

        $text = $this->newTestSubjectInstance('email');
        $result = $text->data('custom', 'another-value')->render();

        $message = 'data-custom attribute should be set';
        $this->assertRegExp($this->elementRegExp('data-custom="another-value"'), $result, $message);
    }

    public function testArrayOfDataAttributes()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->data(['custom' => 'value', 'other' => 'value2'])->render();

        $message = 'data-custom attribute should be set';
        $this->assertRegExp($this->elementRegExp('data-custom="value"'), $result, $message);
        $message = 'data-other attribute should be set';
        $this->assertRegExp($this->elementRegExp('data-other="value2"'), $result, $message);
    }

    public function testCanRemoveClass()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->addClass('error');

        $result = $text->render();
        $message = 'class attribute should be set';
        $this->assertRegExp($this->elementRegExp('class="error"'), $result, $message);

        $text = $text->addClass('large');

        $result = $text->render();
        $message = 'large class should be added to the class attribute';
        $this->assertRegExp($this->elementRegExp('class="error large"'), $result, $message);

        $text = $text->removeClass('error');

        $result = $text->render();
        $message = 'error class should be removed from the class attribute';
        $this->assertRegExp($this->elementRegExp('class="large"'), $result, $message);

        $text = $text->removeClass('large');

        $result = $text->render();
        $message = 'class attribute should be removed';
        $this->assertNotRegExp($this->elementRegExp('class'), $result, $message);
    }

    public function testCanAddAttributesThroughMagicMethods()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->maxlength('5')->render();

        $message = 'maxlength attribute should be set through magic method';
        $this->assertRegExp($this->elementRegExp('maxlength="5"'), $result, $message);
    }

    public function testCanAddAttributesThroughMagicMethodsWithOptionalParameter()
    {
        $text = $this->newTestSubjectInstance('cow');
        $result = $text->moo()->render();

        $message = 'moo attribute should be set through magic method without parameter';
        $this->assertRegExp($this->elementRegExp('moo="moo"'), $result, $message);
    }
}

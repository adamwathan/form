<?php

/**
 * @method assertNotNull($value)
 * @method assertRegExp($pattern, $value, $message)
 * @method assertNotRegExp($pattern, $value, $message)
 * @method assertEquals($expected, $value, $message)
 * @method placeholder($value) : AdamWathan\Form\Elements\Input
 */
trait InputContractTest
{

    /**
     * @param string $name
     *
     * @return AdamWathan\Form\Elements\Input
     */
    protected abstract function newTestSubjectInstance($name);

    /**
     * @return string
     */
    protected abstract function getTestSubjectType();

    /**
     * @param string $attributes
     *
     * @return string
     */
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

    public function testAutofocus()
    {
        $text = $this->newTestSubjectInstance('');
        $result = $text->autofocus()->render();

        $message = "autofocus attribute should be set";
        $this->assertRegExp($this->elementRegExp('autofocus="autofocus"'), $result, $message);
    }

    public function testUnfocus() {
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

        $this->assertNotRegExp($this->elementRegExp($pattern), $result);

        $text = $this->newTestSubjectInstance('email');
        $result = $text->required()->optional()->render();

        $this->assertNotRegExp($this->elementRegExp($pattern), $result);
    }

    public function testDisable()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->disable()->render();

        $this->assertRegExp($this->elementRegExp('disabled="disabled"'), $result);
    }

    public function testEnable()
    {
        $pattern = 'disabled="disabled"';

        $text = $this->newTestSubjectInstance('email');
        $result = $text->enable()->render();

        $this->assertNotRegExp($this->elementRegExp($pattern), $result);

        $text = $this->newTestSubjectInstance('email');
        $result = $text->disable()->enable()->render();

        $this->assertNotRegExp($this->elementRegExp('disabled="disabled"'), $result);
    }

    public function testCanBeCastToString()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = $text->render();
        $result = (string)$text;
        $this->assertEquals($expected, $result);
    }

    public function testCanRenderBasicFormControl()
    {
        $text = $this->newTestSubjectInstance('email');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('name="email"'), $result);

        $text = $this->newTestSubjectInstance('first_name');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('name="first_name"'), $result);
    }

    public function testCanRenderWithId()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->id('email_field');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('id="email_field"'), $result);

        $text = $this->newTestSubjectInstance('first_name');
        $text = $text->id('name_field');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('id="name_field"'), $result);
    }

    public function testCanRenderWithValue()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->value('example@example.com');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('value="example@example.com"'), $result);

        $text = $this->newTestSubjectInstance('first_name');
        $text = $text->value('test@test.com');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('value="test@test.com"'), $result);

        $text = $this->newTestSubjectInstance('first_name');
        $text = $text->value(null);

        $result = $text->render();
        $this->assertNotRegExp($this->elementRegExp('value="test@test.com"'), $result);
    }

    public function testCanRenderWithClass()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->addClass('error');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('class="error"'), $result);

        $text = $this->newTestSubjectInstance('email');
        $text = $text->addClass('success');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('class="success"'), $result);
    }

    public function testCanRenderWithPlaceholder()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->placeholder('error');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('placeholder="error"'), $result);

        $text = $this->newTestSubjectInstance('email');
        $text = $text->placeholder('success');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('placeholder="success"'), $result);
    }

    public function testCustomAttribute()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->attribute('custom', 'test-value')->render();

        $this->assertRegExp($this->elementRegExp('custom="test-value"'), $result);
        $result = $text->clear('custom')->render();

        $this->assertNotRegExp($this->elementRegExp('custom="test-value"'), $result);
    }

    public function testDataAttribute()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->data('sample', 'test-value')->render();

        $this->assertRegExp($this->elementRegExp('data-sample="test-value"'), $result);

        $text = $this->newTestSubjectInstance('email');
        $result = $text->data('custom', 'another-value')->render();

        $this->assertRegExp($this->elementRegExp('data-custom="another-value"'), $result);
    }

    public function testCanRemoveClass()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->addClass('error');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('class="error"'), $result);

        $text = $text->addClass('large');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('class="error large"'), $result);

        $text = $text->removeClass('error');

        $result = $text->render();
        $this->assertRegExp($this->elementRegExp('class="large"'), $result);
    }

    public function testCanAddAttributesThroughMagicMethods()
    {
        $text = $this->newTestSubjectInstance('email');
        $result = $text->maxlength('5')->render();

        $this->assertRegExp($this->elementRegExp('maxlength="5"'), $result);
    }

    public function testCanAddAttributesThroughMagicMethodsWithOptionalParameter()
    {
        $text = $this->newTestSubjectInstance('cow');
        $result = $text->moo()->render();

        $this->assertRegExp($this->elementRegExp('moo="moo"'), $result);
    }
}
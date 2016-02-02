<?php

trait TextSubclassContractTest
{
    /**
     * @param string $name
     *
     * @return AdamWathan\Form\Elements\Text
     */
    protected abstract function newTestSubjectInstance($name);

    /**
     * @return string
     */
    protected abstract function getTestSubjectType();

    public function testTextCanBeCreated()
    {
        $text = $this->newTestSubjectInstance('email');
    }

    public function testCanRenderBasicText()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email">';
        $result = $text->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('first_name');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="first_name">';
        $result = $text->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanRenderWithId()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->id('email_field');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" id="email_field">';
        $result = $text->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('first_name');
        $text = $text->id('name_field');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="first_name" id="name_field">';
        $result = $text->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanRenderWithValue()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->value('example@example.com');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" value="example@example.com">';
        $result = $text->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('first_name');
        $text = $text->value('test@test.com');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="first_name" value="test@test.com">';
        $result = $text->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('first_name');
        $text = $text->value(null);

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="first_name">';
        $result = $text->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanRenderWithClass()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->addClass('error');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" class="error">';
        $result = $text->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('email');
        $text = $text->addClass('success');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" class="success">';
        $result = $text->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanRenderWithPlaceholder()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->placeholder('error');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" placeholder="error">';
        $result = $text->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('email');
        $text = $text->placeholder('success');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" placeholder="success">';
        $result = $text->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanBeCastToString()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = $text->render();
        $result = (string)$text;
        $this->assertEquals($expected, $result);
    }

    public function testRequired()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" required="required">';
        $result = $text->required()->render();
        $this->assertEquals($expected, $result);
    }

    public function testAutofocus()
    {
        $text = $this->newTestSubjectInstance('');

        $result = $text->autofocus()->render();
        $message = "autofocus attribute should be set";
        $this->assertContains('autofocus="autofocus"', $result, $message);
    }

    public function testUnfocus() {
        $pattern = 'autofocus="autofocus"';
        $text = $this->newTestSubjectInstance('');

        $result = $text->unfocus()->render();
        $message = "autofocus attribute should not be set";
        $this->assertNotContains($pattern, $result, $message);

        $text = $this->newTestSubjectInstance('');

        $result = $text->autofocus()->unfocus()->render();
        $message = "autofocus attribute should be removed";
        $this->assertNotContains($pattern, $result, $message);
    }

    public function testOptional()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email">';
        $result = $text->optional()->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email">';
        $result = $text->required()->optional()->render();
        $this->assertEquals($expected, $result);
    }

    public function testDisable()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" disabled="disabled">';
        $result = $text->disable()->render();
        $this->assertEquals($expected, $result);
    }

    public function testEnable()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email">';
        $result = $text->enable()->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email">';
        $result = $text->disable()->enable()->render();
        $this->assertEquals($expected, $result);
    }

    public function testDefaultValue()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" value="example@example.com">';
        $result = $text->defaultValue('example@example.com')->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" value="test@test.com">';
        $result = $text->value('test@test.com')->defaultValue('example@example.com')->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" value="test@test.com">';
        $result = $text->defaultValue('example@example.com')->value('test@test.com')->render();
        $this->assertEquals($expected, $result);
    }

    public function testCustomAttribute()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" data-sample="test-value">';
        $result = $text->attribute('data-sample', 'test-value')->render();
        $this->assertEquals($expected, $result);

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email">';
        $result = $text->clear('data-sample')->render();
        $this->assertEquals($expected, $result);
    }

    public function testDataAttribute()
    {
        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" data-sample="test-value">';
        $result = $text->data('sample', 'test-value')->render();
        $this->assertEquals($expected, $result);

        $text = $this->newTestSubjectInstance('email');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" data-custom="another-value">';
        $result = $text->data('custom', 'another-value')->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanRemoveClass()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->addClass('error');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" class="error">';
        $result = $text->render();
        $this->assertEquals($expected, $result);

        $text = $text->addClass('large');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" class="error large">';
        $result = $text->render();
        $this->assertEquals($expected, $result);

        $text = $text->removeClass('error');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" class="large">';
        $result = $text->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanAddAttributesThroughMagicMethods()
    {
        $text = $this->newTestSubjectInstance('email');
        $text = $text->maxlength('5');

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="email" maxlength="5">';
        $result = $text->render();
        $this->assertEquals($expected, $result);
    }

    public function testCanAddAttributesThroughMagicMethodsWithOptionalParameter()
    {
        $text = $this->newTestSubjectInstance('cow');
        $text = $text->moo();

        $expected = '<input type="' . $this->getTestSubjectType() . '" name="cow" moo="moo">';
        $result = $text->render();
        $this->assertEquals($expected, $result);
    }

}
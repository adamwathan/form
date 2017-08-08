<?php

use AdamWathan\Form\Elements\Select;

class SelectTest extends PHPUnit_Framework_TestCase
{
    use InputContractTest;

    protected function newTestSubjectInstance($name)
    {
        return new Select($name);
    }

    protected function getTestSubjectType()
    {
    }

    protected function elementRegExp($attributes)
    {
        return '/\A<select .*?' . $attributes . '( .*?|)><\/select>\z/';
    }

    public function testSelectCanBeCreatedWithOptions()
    {
        $select = new Select('birth_year', [1990, 1991, 1992]);
        $expected = '<select name="birth_year"><option value="0">1990</option><option value="1">1991</option><option value="2">1992</option></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);

        $select = new Select('birth_year', [2001, 2002, 2003]);
        $expected = '<select name="birth_year"><option value="0">2001</option><option value="1">2002</option><option value="2">2003</option></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);
    }

    public function testSelectCanBeCreatedWithKeyValueOptions()
    {
        $select = new Select('color', ['red' => 'Red', 'blue' => 'Blue']);
        $expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit', ['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanAddOption()
    {
        $select = new Select('color', ['red' => 'Red']);
        $select->addOption('blue', 'Blue');
        $expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit', ['apple' => 'Granny Smith']);
        $select->addOption('berry', 'Blueberry');
        $expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanSetOptions()
    {
        $select = new Select('color');
        $select->options(['red' => 'Red', 'blue' => 'Blue']);
        $expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit');
        $select->options(['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanSetSelectedOption()
    {
        $select = new Select('color');
        $select->options(['red' => 'Red', 'blue' => 'Blue']);
        $expected = '<select name="color"><option value="red">Red</option><option value="blue" selected>Blue</option></select>';
        $result = $select->select('blue')->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit');
        $select->options(['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="apple" selected>Granny Smith</option><option value="berry">Blueberry</option></select>';
        $result = $select->select('apple')->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanSelectNumericKeys()
    {
        $select = new Select('fruit');
        $select->options(['1' => 'Granny Smith', '2' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="1" selected>Granny Smith</option><option value="2">Blueberry</option></select>';
        $result = $select->select('1')->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit');
        $select->options(['1' => 'Granny Smith', '2' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="1">Granny Smith</option><option value="2" selected>Blueberry</option></select>';
        $result = $select->select('2')->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanSetDefaultOption()
    {
        $select = new Select('color', ['red' => 'Red', 'blue' => 'Blue']);
        $expected = '<select name="color"><option value="red">Red</option><option value="blue" selected>Blue</option></select>';
        $result = $select->defaultValue('blue')->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit', ['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="apple" selected>Granny Smith</option><option value="berry">Blueberry</option></select>';
        $result = $select->defaultValue('apple')->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit', ['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry" selected>Blueberry</option></select>';
        $result = $select->select('berry')->defaultValue('apple')->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit', ['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry" selected>Blueberry</option></select>';
        $result = $select->defaultValue('apple')->select('berry')->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanSetDefaultOptionMultiselect()
    {
        $select = new Select('color', ['red' => 'Red', 'blue' => 'Blue']);
        $expected = '<select name="color"><option value="red" selected>Red</option><option value="blue" selected>Blue</option></select>';
        $result = $select->defaultValue(['blue', 'red'])->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit', ['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="apple" selected>Granny Smith</option><option value="berry">Blueberry</option></select>';
        $result = $select->defaultValue(['apple'])->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit', ['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry" selected>Blueberry</option></select>';
        $result = $select->select('berry')->defaultValue(['apple', 'berry'])->render();

        $this->assertEquals($expected, $result);

        $select = new Select('fruit', ['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry" selected>Blueberry</option></select>';
        $result = $select->defaultValue('apple')->select(['berry'])->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanUseNestedOptions()
    {
        $options = [
            'Ontario' => [
                'toronto' => 'Toronto',
                'london' => 'London',
            ],
            'Quebec' => [
                'montreal' => 'Montreal',
                'quebec-city' => 'Quebec City',
            ],
        ];
        $select = new Select('color', $options);
        $expected = '<select name="color"><optgroup label="Ontario"><option value="toronto">Toronto</option><option value="london">London</option></optgroup><optgroup label="Quebec"><option value="montreal">Montreal</option><option value="quebec-city">Quebec City</option></optgroup></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanUseNestedOptionsWithoutKeys()
    {
        $options = [
            'Ontario' => [
                'Toronto',
                'London',
            ],
            'Quebec' => [
                'Montreal',
                'Quebec City',
            ],
        ];
        $select = new Select('color', $options);
        $expected = '<select name="color"><optgroup label="Ontario"><option value="0">Toronto</option><option value="1">London</option></optgroup><optgroup label="Quebec"><option value="0">Montreal</option><option value="1">Quebec City</option></optgroup></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanMixNestedAndUnnestedOptions()
    {
        $options = [
            'toronto' => 'Toronto',
            'london' => 'London',
            'Quebec' => [
                'montreal' => 'Montreal',
                'quebec-city' => 'Quebec City',
            ],
        ];
        $select = new Select('color', $options);
        $expected = '<select name="color"><option value="toronto">Toronto</option><option value="london">London</option><optgroup label="Quebec"><option value="montreal">Montreal</option><option value="quebec-city">Quebec City</option></optgroup></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);
    }

    public function testSelectCanBeCreatedWithIntegerKeyValueOptions()
    {
        $select = new Select('color', ['0' => 'Red', '1' => 'Blue']);
        $expected = '<select name="color"><option value="0">Red</option><option value="1">Blue</option></select>';
        $result = $select->render();
        $this->assertEquals($expected, $result);

        $select = new Select('fruit', ['1' => 'Granny Smith', '0' => 'Blueberry']);
        $expected = '<select name="fruit"><option value="1">Granny Smith</option><option value="0">Blueberry</option></select>';
        $result = $select->render();
        $this->assertEquals($expected, $result);
    }

    public function testSelectCanBeMultiple()
    {
        $select = new Select('people');
        $expected = '<select name="people[]" multiple="multiple"></select>';
        $result = $select->multiple()->render();

        $this->assertEquals($expected, $result);

        $select = new Select('people[]');
        $expected = '<select name="people[]" multiple="multiple"></select>';
        $result = $select->multiple()->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanSelectMultipleElementsInMultiselects()
    {
        $select = new Select('color', ['red' => 'Red', 'blue' => 'Blue']);
        $expected = '<select name="color[]" multiple="multiple"><option value="red" selected>Red</option><option value="blue" selected>Blue</option></select>';
        $result = $select->multiple()->select(['red', 'blue'])->render();

        $this->assertEquals($expected, $result);
    }

    public function testAgainstXSSAttacksInSelectOptions()
    {
        $select = new Select('animals', ['0"><script>alert("xss")</script>' => '<script>alert("xss")</script>']);
        $expected = '<select name="animals"><option value="0&quot;&gt;&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;">&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;</option></select>';
        $result = $select->render();

        $this->assertEquals($expected, $result);
    }

    public function testSetOptAttributes()
    {
        $select = new Select('color', ['red' => 'Red', 'blue' => 'Blue']);
        $select->setOptAttributes([
            'red' => [
                'data-attribute' => 'some value',
                'label' => 'This is Red',
                'disabled' => true,
            ],
        ]);
        $expected = '<select name="color"><option value="red" data-attribute="some value" label="This is Red" disabled>Red</option><option value="blue">Blue</option></select>';
        $result = $select->render();
        $this->assertEquals($expected, $result);
    }

    public function testAddOptAttribute()
    {
        $select = new Select('color', ['red' => 'Red', 'blue' => 'Blue']);
        $select->setOptAttributes([
            'red' => [
                'data-attribute' => 'some value',
                'label' => 'This is Red',
                'disabled' => true,
            ],
        ]);
        $select->addOptAttribute('blue', 'label', 'This is Blue');
        $expected = '<select name="color"><option value="red" data-attribute="some value" label="This is Red" disabled>Red</option><option value="blue" label="This is Blue">Blue</option></select>';
        $result = $select->render();
        $this->assertEquals($expected, $result);
    }

    public function testRemoveOptAttributes()
    {
        $select = new Select('color', ['red' => 'Red', 'blue' => 'Blue']);
        $select->setOptAttributes([
            'red' => [
                'data-attribute' => 'some value',
                'label' => 'This is Red',
                'disabled' => true,
            ],
        ]);
        $select->removeOptAttribute('red', 'disabled');
        $expected = '<select name="color"><option value="red" data-attribute="some value" label="This is Red">Red</option><option value="blue">Blue</option></select>';
        $result = $select->render();
        $this->assertEquals($expected, $result);

        $select->removeOptAttribute('red');
        $expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
        $result = $select->render();
        $this->assertEquals($expected, $result);
    }

    public function testGetOptAttribute()
    {
        $select = new Select('color', ['red' => 'Red', 'blue' => 'Blue']);
        $select->setOptAttributes([
            'red' => [
                'data-attribute' => 'some value',
                'label' => 'This is Red',
                'disabled' => true,
            ],
        ]);
        $this->assertEquals('some value', $select->getOptAttribute('red', 'data-attribute'));
        $this->assertEquals(null, $select->getOptAttribute('blue', 'disabled'));
        $this->assertEquals(null, $select->getOptAttribute('red', 'data-invalid-attribute'));
    }

    public function testBoolTypeOptAttribute()
    {
        $select = new Select('color', ['red' => 'Red', 'blue' => 'Blue']);
        $select->setOptAttributes([
            'red' => ['disabled' => true],
        ]);
        $expected = '<select name="color"><option value="red" disabled>Red</option><option value="blue">Blue</option></select>';
        $result = $select->render();
        $this->assertEquals($expected, $result);

        $select->setOptAttributes([
            'red' => ['disabled' => false],
        ]);
        $expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
        $result = $select->render();
        $this->assertEquals($expected, $result);
    }
}

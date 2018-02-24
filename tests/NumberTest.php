<?php

use AdamWathan\Form\Elements\Number;

class NumberTest extends PHPUnit_Framework_TestCase
{
        public function testNumberCanBeCreated()
        {
                $date = new Number('age');
        }

        public function testRenderNumberInput()
        {
                $age = new Number('age');
                $expected = '<input type="number" name="age">';
                $result = $age->render();
                $this->assertEquals($expected, $result);
        }
}

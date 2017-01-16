<?php

use AdamWathan\Form\Elements\FormClose;

class FormCloseTest extends PHPUnit_Framework_TestCase
{
    public function testFormCanBeCreated()
    {
        $form = new FormClose;
    }

    public function testRenderBasicFormClose()
    {
        $form = new FormClose;
        $expected = '</form>';
        $result = $form->render();

        $this->assertEquals($expected, $result);
    }
}

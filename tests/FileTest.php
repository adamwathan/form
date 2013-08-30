<?php

use AdamWathan\Form\Elements\File;

class FileTest extends PHPUnit_Framework_TestCase
{
	public function testFileCanBeCreated()
	{
		$file = new File('article');
	}

	public function testRenderFileInput()
	{
		$file = new File('article');
		$expected = '<input type="file" name="article">';
		$result = $file->render();
		$this->assertEquals($expected, $result);
	}
}
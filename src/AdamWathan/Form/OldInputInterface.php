<?php namespace AdamWathan\Form;

interface OldInputInterface
{
	public function hasOldInput($key);
	public function getOldInput($key);
}
<?php namespace AdamWathan\Form;

interface ErrorMessageInterface
{
	public function hasFormError($key);
	public function getFormError($key);
}
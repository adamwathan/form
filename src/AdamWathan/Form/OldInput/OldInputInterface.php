<?php namespace AdamWathan\Form\OldInput;

interface OldInputInterface
{
    public function hasOldInputs();
    public function hasOldInput($key);
    public function getOldInput($key);
}

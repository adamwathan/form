<?php namespace AdamWathan\Form\OldInput;

use AdamWathan\Form\OldInput\OldInputInterface;

class HttpRequestOldInput implements OldInputInterface {

    public function hasOldInput()
    {
        if(isset($_REQUEST)) {
            return true;
        } else {
            return false;
        }
    }

    public function getOldInput($key,$value=false)
    {
        $key = $this->transformKey($key);

        if(isset($_REQUEST[$key])) {

            if(is_array($_REQUEST[$key]) && in_array($value, $_REQUEST[$key])){
                return $value;
            } else {
                return $_REQUEST[$key];
            }
        } else {
            return '';
        }
    }

    protected function transformKey($key)
    {
        return str_replace(array('.', '[]', '[', ']'), array('_', '', '.', ''), $key);
    }
}
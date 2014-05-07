<?php namespace AdamWathan\Form\ErrorStore;

interface ErrorStoreInterface
{
    public function hasError($key);
    public function getError($key);
}

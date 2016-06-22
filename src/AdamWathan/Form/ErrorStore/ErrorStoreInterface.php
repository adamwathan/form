<?php

namespace AdamWathan\Form\ErrorStore;

interface ErrorStoreInterface
{
    public function hasErrors();

    public function hasError($key);

    public function getErrors();

    public function getError($key);
}

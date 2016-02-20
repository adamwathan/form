<?php

namespace AdamWathan\Form\ErrorStore;

use Illuminate\Session\Store as Session;

class IlluminateErrorStore implements ErrorStoreInterface
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function hasError($key)
    {
        if (! $this->hasErrors()) {
            return false;
        }

        $key = $this->transformKey($key);

        return $this->getErrors()->has($key);
    }

    public function getError($key)
    {
        if (! $this->hasError($key)) {
            return null;
        }

        $key = $this->transformKey($key);

        return $this->getErrors()->first($key);
    }

    protected function hasErrors()
    {
        return $this->session->has('errors');
    }

    protected function getErrors()
    {
        return $this->hasErrors() ? $this->session->get('errors') : null;
    }

    protected function transformKey($key)
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }
}

<?php

namespace AdamWathan\Form\ErrorStore;

use Illuminate\Session\Store as Session;

/**
 * Class IlluminateErrorStore
 * @package AdamWathan\Form\ErrorStore
 */
class IlluminateErrorStore implements ErrorStoreInterface
{
    private $session;

    /**
     * IlluminateErrorStore constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasError($key)
    {
        if (! $this->hasErrors()) {
            return false;
        }

        $key = $this->transformKey($key);

        return $this->getErrors()->has($key);
    }

    /**
     * @param $key
     * @return null
     */
    public function getError($key)
    {
        if (! $this->hasError($key)) {
            return null;
        }

        $key = $this->transformKey($key);

        return $this->getErrors()->first($key);
    }

    /**
     * @return mixed
     */
    protected function hasErrors()
    {
        return $this->session->has('errors');
    }

    /**
     * @return null
     */
    protected function getErrors()
    {
        return $this->hasErrors() ? $this->session->get('errors') : null;
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function transformKey($key)
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }
}

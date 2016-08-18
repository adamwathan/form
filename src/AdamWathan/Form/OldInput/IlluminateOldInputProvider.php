<?php

namespace AdamWathan\Form\OldInput;

use Illuminate\Session\Store as Session;

/**
 * Class IlluminateOldInputProvider
 * @package AdamWathan\Form\OldInput
 */
class IlluminateOldInputProvider implements OldInputInterface
{
    private $session;

    /**
     * IlluminateOldInputProvider constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @return bool
     */
    public function hasOldInput()
    {
        return ($this->session->get('_old_input')) ? true : false ;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getOldInput($key)
    {
        return $this->session->getOldInput($this->transformKey($key));
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

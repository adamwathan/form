<?php

namespace AdamWathan\Form\OldInput;

use Illuminate\Session\Store as Session;

class IlluminateOldInputProvider implements OldInputInterface
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function hasOldInput()
    {
        return ($this->session->get('_old_input')) ? true : false ;
    }

    public function getOldInput($key)
    {
        return $this->session->getOldInput($key);
    }
}

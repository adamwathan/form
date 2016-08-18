<?php

namespace AdamWathan\Form\Elements;

/**
 * Class FormOpen
 * @package AdamWathan\Form\Elements
 */
class FormOpen extends Element
{
    protected $attributes = [
        'method' => 'POST',
        'action' => '',
    ];

    protected $token;

    protected $hiddenMethod;

    /**
     * @return string
     */
    public function render()
    {
        $tags = [sprintf('<form%s>', $this->renderAttributes())];

        if ($this->hasToken() && ($this->attributes['method'] !== 'GET')) {
            $tags[] = $this->token->render();
        }

        if ($this->hasHiddenMethod()) {
            $tags[] = $this->hiddenMethod->render();
        }

        return implode($tags);
    }

    /**
     * @return bool
     */
    protected function hasToken()
    {
        return isset($this->token);
    }

    /**
     * @return bool
     */
    protected function hasHiddenMethod()
    {
        return isset($this->hiddenMethod);
    }

    /**
     * @return $this
     */
    public function post()
    {
        $this->setMethod('POST');

        return $this;
    }

    /**
     * @return $this
     */
    public function get()
    {
        $this->setMethod('GET');

        return $this;
    }

    /**
     * @return FormOpen
     */
    public function put()
    {
        return $this->setHiddenMethod('PUT');
    }

    /**
     * @return FormOpen
     */
    public function patch()
    {
        return $this->setHiddenMethod('PATCH');
    }

    /**
     * @return FormOpen
     */
    public function delete()
    {
        return $this->setHiddenMethod('DELETE');
    }

    /**
     * @param $token
     * @return $this
     */
    public function token($token)
    {
        $this->token = new Hidden('_token');
        $this->token->value($token);

        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    protected function setHiddenMethod($method)
    {
        $this->setMethod('POST');
        $this->hiddenMethod = new Hidden('_method');
        $this->hiddenMethod->value($method);

        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->setAttribute('method', $method);

        return $this;
    }

    /**
     * @param $action
     * @return $this
     */
    public function action($action)
    {
        $this->setAttribute('action', $action);

        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function encodingType($type)
    {
        $this->setAttribute('enctype', $type);

        return $this;
    }

    /**
     * @return FormOpen
     */
    public function multipart()
    {
        return $this->encodingType('multipart/form-data');
    }
}

<?php

namespace AdamWathan\Form\Elements;

class FormOpen extends Element
{
    protected $attributes = [
        'method' => 'POST',
        'action' => '',
    ];

    protected $token;

    protected $hiddenMethod;

    protected $hiddenNamespace;

    public function __construct($namespace = null)
    {
        if ($namespace) {
            $this->setHiddenNamespace($namespace);
        }
    }

    public function render()
    {
        $tags = [sprintf('<form%s>', $this->renderAttributes())];

        if ($this->hasToken() && ($this->attributes['method'] !== 'GET')) {
            $tags[] = $this->token->render();
        }

        if ($this->hasHiddenMethod()) {
            $tags[] = $this->hiddenMethod->render();
        }

        if ($this->hasHiddenNamespace()) {
            $tags[] = $this->hiddenNamespace->render();
        }

        return implode($tags);
    }

    protected function hasToken()
    {
        return isset($this->token);
    }

    protected function hasHiddenMethod()
    {
        return isset($this->hiddenMethod);
    }

    protected function hasHiddenNamespace()
    {
        return isset($this->hiddenNamespace);
    }

    public function post()
    {
        $this->setMethod('POST');

        return $this;
    }

    public function get()
    {
        $this->setMethod('GET');

        return $this;
    }

    public function put()
    {
        return $this->setHiddenMethod('PUT');
    }

    public function patch()
    {
        return $this->setHiddenMethod('PATCH');
    }

    public function delete()
    {
        return $this->setHiddenMethod('DELETE');
    }

    public function token($token)
    {
        $this->token = new Hidden('_token');
        $this->token->value($token);

        return $this;
    }

    protected function setHiddenMethod($method)
    {
        $this->setMethod('POST');
        $this->hiddenMethod = new Hidden('_method');
        $this->hiddenMethod->value($method);

        return $this;
    }

    protected function setHiddenNamespace($namespace)
    {
        $this->hiddenNamespace = new Hidden('_namespace');
        $this->hiddenNamespace->value($namespace);

        return $this;
    }

    public function setMethod($method)
    {
        $this->setAttribute('method', $method);

        return $this;
    }

    public function action($action)
    {
        $this->setAttribute('action', $action);

        return $this;
    }

    public function encodingType($type)
    {
        $this->setAttribute('enctype', $type);

        return $this;
    }

    public function multipart()
    {
        return $this->encodingType('multipart/form-data');
    }
}

<?php namespace AdamWathan\Form\Elements;

class FormOpen extends Element
{
    protected $attributes = array(
        'method' => 'POST',
        'action' => '',
    );

    protected $hiddenMethod;

    public function render()
    {
        $result  = '<form';
        $result .= $this->renderAttributes();
        $result .= '>';
        if ($this->hasHiddenMethod()) {
            $result .= $this->hiddenMethod->render();
        }
        return $result;
    }

    protected function hasHiddenMethod()
    {
        return isset($this->hiddenMethod);
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

    public function delete()
    {
        return $this->setHiddenMethod('DELETE');
    }

    protected function setHiddenMethod($method)
    {
        $this->setMethod('POST');
        $this->hiddenMethod = new Hidden('_method');
        $this->hiddenMethod->value($method);
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

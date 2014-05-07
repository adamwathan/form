<?php namespace AdamWathan\Form\Elements;

class Label extends Element
{
    private $element;
    private $labelBefore;

    public function __construct($label)
    {
        $this->label = $label;
    }

    public function render()
    {
        $result = '<label';
        $result .= $this->renderAttributes();
        $result .= '>';

        if ($this->labelBefore) {
            $result .= $this->label;
        }

        $result .= $this->renderElement();

        if (! $this->labelBefore) {
            $result .= $this->label;
        }

        $result .= '</label>';

        return $result;
    }

    public function forId($name)
    {
        $this->setAttribute('for', $name);
        return $this;
    }

    public function before(Element $element)
    {
        $this->element = $element;
        $this->labelBefore = true;
        return $this;
    }

    public function after(Element $element)
    {
        $this->element = $element;
        $this->labelBefore = false;
        return $this;
    }

    protected function renderElement()
    {
        if (! $this->element) {
            return '';
        }

        return $this->element->render();
    }

    public function getControl()
    {
        return $this->element;
    }
}

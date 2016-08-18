<?php

namespace AdamWathan\Form\Elements;

/**
 * Class Label
 * @package AdamWathan\Form\Elements
 */
class Label extends Element
{
    protected $element;

    protected $labelBefore;

    protected $label;

    /**
     * Label constructor.
     * @param $label
     */
    public function __construct($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function render()
    {
        $tags = [sprintf('<label%s>', $this->renderAttributes())];

        if ($this->labelBefore) {
            $tags[] = $this->label;
        }

        $tags[] = $this->renderElement();

        if (! $this->labelBefore) {
            $tags[] = $this->label;
        }

        $tags[] = '</label>';

        return implode($tags);
    }

    /**
     * @param $name
     * @return $this
     */
    public function forId($name)
    {
        $this->setAttribute('for', $name);

        return $this;
    }

    /**
     * @param Element $element
     * @return $this
     */
    public function before(Element $element)
    {
        $this->element = $element;
        $this->labelBefore = true;

        return $this;
    }

    /**
     * @param Element $element
     * @return $this
     */
    public function after(Element $element)
    {
        $this->element = $element;
        $this->labelBefore = false;

        return $this;
    }

    /**
     * @return string
     */
    protected function renderElement()
    {
        if (! $this->element) {
            return '';
        }

        return $this->element->render();
    }

    /**
     * @return mixed
     */
    public function getControl()
    {
        return $this->element;
    }
}

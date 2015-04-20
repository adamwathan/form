<?php namespace AdamWathan\Form\Traits;

use AdamWathan\Form\OldInput\OldInputInterface;

trait OldInputTrait
{

	public $oldInput;

    public function setOldInputProvider(OldInputInterface $oldInputProvider)
    {
        $this->oldInput = $oldInputProvider;
    }

    protected function getOldInput($name)
    {
        return $this->escapeQuotes($this->oldInput->getOldInput($name));
    }

    protected function escapeQuotes($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        return str_replace('"', '&quot;', $value);
    }

    protected function getValueFor($name)
    {
        if ($this->hasOldInput()) {
            return $this->getOldInput($name);
        }

        if ($this->hasModelValue($name)) {
            return $this->getModelValue($name);
        }

        return null;
    }

    protected function hasOldInput()
    {
        if (! isset($this->oldInput)) {
            return false;
        }

        return $this->oldInput->hasOldInput();
    }
}

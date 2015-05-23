<?php namespace AdamWathan\Form;

use AdamWathan\Form\Elements\Text;
use AdamWathan\Form\Elements\Password;
use AdamWathan\Form\Elements\Checkbox;
use AdamWathan\Form\Elements\RadioButton;
use AdamWathan\Form\Elements\Button;
use AdamWathan\Form\Elements\Select;
use AdamWathan\Form\Elements\TextArea;
use AdamWathan\Form\Elements\Label;
use AdamWathan\Form\Elements\FormOpen;
use AdamWathan\Form\Elements\Hidden;
use AdamWathan\Form\Elements\File;
use AdamWathan\Form\Elements\Date;
use AdamWathan\Form\Elements\Email;
use AdamWathan\Form\OldInput\OldInputInterface;
use AdamWathan\Form\ErrorStore\ErrorStoreInterface;

class FormBuilder
{
    private $oldInput;
    private $errorStore;
    private $csrfToken;
    private $model;

    public function setOldInputProvider(OldInputInterface $oldInputProvider)
    {
        $this->oldInput = $oldInputProvider;
    }

    public function setErrorStore(ErrorStoreInterface $errorStore)
    {
        $this->errorStore = $errorStore;
    }

    public function setToken($token)
    {
        $this->csrfToken = $token;
    }

    public function open()
    {
        $open = new FormOpen;

        if ($this->hasToken()) {
            $open->token($this->csrfToken);
        }

        return $open;
    }

    protected function hasToken()
    {
        return isset($this->csrfToken);
    }

    public function close()
    {
        $this->unbindModel();
        return '</form>';
    }

    public function text($name)
    {
        $text = new Text($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $text->value($value);
        }

        return $text;
    }

    public function date($name)
    {
        $date = new Date($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $date->value($value);
        }

        return $date;
    }

    public function email($name)
    {
        $email = new Email($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $email->value($value);
        }

        return $email;
    }

    public function hidden($name)
    {
        $hidden = new Hidden($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $hidden->value($value);
        }

        return $hidden;
    }

    public function textarea($name)
    {
        $textarea = new TextArea($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $textarea->value($value);
        }

        return $textarea;
    }

    public function password($name)
    {
        return new Password($name);
    }

    public function checkbox($name, $value = 1)
    {
        $checkbox = new Checkbox($name, $value);

        $oldValue = $this->getValueFor($name);

        if ($value == $oldValue) {
            $checkbox->check();
        }

        return $checkbox;
    }

    public function radio($name, $value = null)
    {
        $value = is_null($value) ? $name : $value;

        $radio = new RadioButton($name, $value);

        $oldValue = $this->getValueFor($name);

        if ($value == $oldValue) {
            $radio->check();
        }

        return $radio;
    }

    public function button($value, $name = null)
    {
        return new Button($value, $name);
    }

    public function submit($value = 'Submit')
    {
        $submit = new Button($value);
        $submit->attribute('type', 'submit');

        return $submit;
    }

    public function select($name, $options = array())
    {
        $select = new Select($name, $options);

        $selected = $this->getValueFor($name);
        $select->select($selected);

        return $select;
    }

    public function label($label)
    {
        return new Label($label);
    }

    public function file($name)
    {
        return new File($name);
    }

    public function token()
    {
        $token = $this->hidden('_token');

        if (isset($this->csrfToken)) {
            $token->value($this->csrfToken);
        }

        return $token;
    }

    public function hasError($name)
    {
        if (! isset($this->errorStore)) {
            return false;
        }

        return $this->errorStore->hasError($name);
    }

    public function getError($name, $format = null)
    {
        if (! isset($this->errorStore)) {
            return null;
        }

        if (! $this->hasError($name)) {
            return '';
        }

        $message = $this->errorStore->getError($name);

        if ($format) {
            $message = str_replace(':message', $message, $format);
        }

        return $message;
    }

    public function bind($model)
    {
        $this->model = is_array($model) ? (object) $model : $model;
    }

    public function getValueFor($name)
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

    protected function getOldInput($name)
    {
        return $this->escape($this->oldInput->getOldInput($name));
    }

    protected function hasModelValue($name)
    {
        if (! isset($this->model)) {
            return false;
        }
        return isset($this->model->{$name}) || method_exists($this->model, '__get');
    }

    protected function getModelValue($name)
    {
        return $this->escape($this->model->{$name});
    }

    protected function escape($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        return htmlentities($value, ENT_QUOTES, 'UTF-8');
    }

    protected function unbindModel()
    {
        $this->model = null;
    }

    public function selectMonth($name)
    {
        $options = array(
            "1" => "January",
            "2" => "February",
            "3" => "March",
            "4" => "April",
            "5" => "May",
            "6" => "June",
            "7" => "July",
            "8" => "August",
            "9" => "September",
            "10" => "October",
            "11" => "November",
            "12" => "December",
        );

        return $this->select($name, $options);
    }
}

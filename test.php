<?php

require 'vendor/autoload.php';

use AdamWathan\Form\FormBuilder;

$builder = new FormBuilder;

echo $builder->file('avatar')->class('file');

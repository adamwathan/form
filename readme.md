Form
========

Boring name for a boring package. Builds form HTML with a fluent-ish, hopefully intuitive syntax.

- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Remembering Old Input](#remembering-old-input)
- [Error Messages](#error-messages)
- [CSRF Protection](#csrf-tokens)
- [Model Binding](#model-binding)

<a href="#installation"></a>
## Installation

You can install this package via Composer by including the following in your `composer.json`:

```json
{
    "require": {
        "adamwathan/form": "0.2"
    }
}
```
*Note: you could also require `dev-master` to test the latest version, but make sure you drop your `minimum-stability` to `dev`.*

### Laravel 4

If you are using Laravel 4, you can also register the FormServiceProvider to automatically gain access to the Old Input and Error Message functionality.

To do so, just update the `providers` array in your `app/config/app.php`:

```php
'providers' => array(
        //...
        'AdamWathan\Form\FormServiceProvider'
    ),
```

<a href="#basic-usage"></a>
## Basic Usage

- [Getting Started](#getting-started)
- [Opening a Form](#opening-a-form)
- [Text and Password Fields](#text-and-password-fields)
- [Textareas](#textareas)
- [Checkboxes and Radio Buttons](#checkboxes-and-radio-buttons)
- [Selects](#selects)
- [Submit Buttons](#submit-buttons)
- [Hidden Inputs](#hidden-inputs)
- [Labels](#labels)

<a href="#getting-started"></a>
### Getting Started
First, instantiate a FormBuilder...

```php
$builder = new AdamWathan\Form\FormBuilder;
```

Next, use the FormBuilder to build an element. For example:
```php
// <input type="text" name="email" value="example@example.com" required="required">
$builder->text('email')->value('example@example.com')->required();
```

- All elements support method chaining, so you can add as many options to an element as you need.
- All elements implement `__toString()` so there is no need to manually render.


<a href="#opening-a-form"></a>
### Opening a Form

```php
// <form method="POST">
$builder->open();

// <form method="GET">
$builder->open()->get();

// <form method="POST">
// <input type="hidden" name="_method" value="PUT">
$builder->open()->put();

// <form method="POST">
// <input type="hidden" name="_method" value="DELETE">
$builder->open()->delete();

// <form method="POST" action="/test">
$builder->open()->action('/test')->render();
```
<a href="#text-and-password-fields"></a>
### Text and Password Fields

Text and password fields share the same interface.

```php
// <input type="text" name="email">
$builder->text('email');

// <input type="text" name="email" id="email_field">
$builder->text('email')->id('email_field');

// <input type="password" name="password" class="required">
$builder->password('password')->addClass('required');

// <input type="text" name="email" value="example@example.com" required="required">
$builder->text('email')->value('example@example.com')->required();
```

Other available methods:

- `placeholder($string)`
- `optional()`
- `defaultValue($string)`
- `disable()`
- `enable()`

<a href="#textareas"></a>
### Textareas

Textareas share the same interface as regular text fields, with a couple of extra useful methods.

```php
// <textarea name="bio" rows="5" cols="50"></textarea>
$builder->textarea('bio')->rows(5);

// <textarea name="bio" rows="10" cols="20"></textarea>
$builder->textarea('bio')->cols(20);

// <textarea name="bio" rows="5" cols="20" class="important">My biography</textarea>
$builder->textarea('bio')->rows(5)->cols(20)->addClass('important')->value('My biography');
```

<a href="#checkboxes-and-radio-buttons"></a>
### Checkboxes and Radio Buttons

```php
// <input type="checkbox" name="terms" value="1">
$builder->checkbox('terms');

// <input type="checkbox" name="terms" value="1" checked="checked">
$builder->checkbox('terms')->check();

// <input type="checkbox" name="terms" value="1">
$builder->checkbox('terms')->uncheck();

// <input type="checkbox" name="terms" value="1" checked="checked">
$builder->checkbox('terms')->defaultToChecked();

// <input type="checkbox" name="terms" value="agree">
$builder->checkbox('terms')->value('agree');

// <input type="radio" name="color" value="red">
$builder->radio('color', 'red');
```

<a href="#selects"></a>
### Selects

```php
// <select name="birth_year"></select>
$builder->select('birth_year');

// <select name="birth_year">
//   <option value="1990">1990</option>
//   <option value="1991">1991</option>
//   <option value="1992">1992</option>
// </select>
$builder->select('birth_year', [1990, 1991, 1992]);

// <select name="birth_year">
//   <option value="1">1990</option>
//   <option value="2">1991</option>
//   <option value="3">1992</option>
// </select>
$builder->select('birth_year', ['1' => 1990, '2' => 1991, '3' => 1992]);

// <select name="birth_year">
//   <optgroup label="Ontario">
//     <option value="toronto">Toronto</option>
//     <option value="ottawa">Ottawa</option>
//   </optgroup>
//   <optgroup label="Quebec">
//     <option value="montreal">Montreal</option>
//     <option value="quebec_city">Quebec City</option>
//   </optgroup>
// </select>
$options = [
	'Ontario' => [
		'toronto' => 'Toronto',
		'ottawa' => 'Ottawa',
	],
	'Quebec' => [
		'montreal' => 'Montreal',
		'quebec_city' => 'Quebec City',
	]
];
$builder->select('birth_year', $options);

// <select name="birth_year">
//   <option value="1">1990</option>
// </select>
$builder->select('birth_year')->addOption('1', 1990);

// <select name="birth_year">
//   <option value="1">1990</option>
//   <option value="2">1991</option>
//   <option value="3" selected>1992</option>
// </select>
$builder->select('birth_year', ['1' => 1990, '2' => 1991, '3' => 1992])->select('3');
```

<a href="#submit-buttons"></a>
### Submit Buttons

```php
// <button type="submit">Sign Up</button>
$builder->submit('Sign Up');

// <button type="submit" class="js-submit">Sign Up</button>
$builder->submit('Sign Up')->addClass('js-submit');
```

<a href="#hidden-inputs"></a>
### Hidden Inputs

```php
// <input type="hidden" name="secret" value="my-secret-value">
$builder->hidden('secret')->value('my-secret-value');
```

<a href="#labels"></a>
### Labels

**Basic Label**
```php
// <label>Email</label>
$builder->label('Email');

// <label for="email">Email</label>
$builder->label('Email')->forId('email');
```

**Wrapping another element**
```php
// <label>Email<input type="text" name="email"></label>
$builder->label('Email')->before($emailElement);

// <label><input type="text" name="email">Email</label>
$builder->label('Email')->after($emailElement);
```

<a href="#remembering-old-input"></a>
## Remembering Old Input

The FormBuilder can remember old input and prepopulate your form fields if you redirect back to the form because of a validation error.

To make this work, you must create a class that implements the `OldInputInterface` and pass it to the FormBuilder:

```php
$builder->setOldInputProvider($myOldInputProvider);
```

Now, your form elements will automatically populate with the user's old input data if it is available.

This works well with the `defaultValue()` methods, allowing you to set a default value that will be overridden by old input if the user has already submitted the form.

> This package ships with a Laravel 4 implementation out of the box, called `IlluminateOldInput`.

<a href="#error-messages"></a>
## Error Messages

FormBuilder also allows you to easily retrieve error messages for your form elements. To do so, just implement the `ErrorStoreInterface` and pass it to the FormBuilder:

```php
$builder->setErrorStore($myErrorStore);
```

> This package ships with a Laravel 4 implementation out of the box, called `IlluminateErrorStore`.

```php
// Check if the form has an error for an element
$builder->hasError('email');

// Retrieve the error message for an element
$builder->getError('email');
```

You can also supply a `format` parameter to `getError()` to cleanup your markup. Instead of doing this:

```php
<?php if ($builder->hasError('email')): ?>
	<span class="error"><?= $builder->getError('email'); ?></span>
<?php endif; ?>
```

...you can simply do this, which will display the formatted message if it exists, or nothing otherwise.
```php
<?= $builder->getError('email', '<span class="error">:message</span'); ?>
```

<a href="#csrf-tokens"></a>
## CSRF Protection

Assuming you set a CSRF token when instantiating the Formbuilder (or you are using Laravel 4), add a CSRF token to your form easily like so:

```php
$builder->token();
```

<a href="#model-binding"></a>
## Model Binding

Sometimes you might have a form where all of the fields match properties on some sort of object in your system, and you want the user to be able to edit those properties. Model binding makes this really easy by allowing you to bind a model to your form that will be used to automatically provide all of the default values for your fields.

```php
$model->first_name = "John";
$model->last_name = "Doe";
$model->email = "john@example.com";
$model->date_of_birth = new DateTime('1985-05-06');

$builder->open();
$builder->bind($model);
$builder->text('first_name');
$builder->text('last_name');
$builder->email('email');
$builder->date('date_of_birth');
$builder->close();
```

> This will work out of the box with Laravel's Eloquent models.

When using model binding, old input will still take priority over any values on your model, so you can still easily redirect the user back to the form with any validation errors without losing any of the data they entered.

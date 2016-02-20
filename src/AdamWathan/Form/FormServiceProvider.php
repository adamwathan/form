<?php

namespace AdamWathan\Form;

use AdamWathan\Form\ErrorStore\IlluminateErrorStore;
use AdamWathan\Form\OldInput\IlluminateOldInputProvider;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->registerErrorStore();
        $this->registerOldInput();
        $this->registerFormBuilder();
    }

    protected function registerErrorStore()
    {
        $this->app['adamwathan.form.errorstore'] = $this->app->share(function ($app) {
            return new IlluminateErrorStore($app['session.store']);
        });
    }

    protected function registerOldInput()
    {
        $this->app['adamwathan.form.oldinput'] = $this->app->share(function ($app) {
            return new IlluminateOldInputProvider($app['session.store']);
        });
    }

    protected function registerFormBuilder()
    {
        $this->app['adamwathan.form'] = $this->app->share(function ($app) {
            $formBuilder = new FormBuilder;
            $formBuilder->setErrorStore($app['adamwathan.form.errorstore']);
            $formBuilder->setOldInputProvider($app['adamwathan.form.oldinput']);
            $formBuilder->setToken($app['session.store']->getToken());

            return $formBuilder;
        });
    }

    public function provides()
    {
        return ['adamwathan.form'];
    }
}

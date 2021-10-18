<?php

namespace Datalogix\Translation;

use Illuminate\Translation\TranslationServiceProvider as IlluminateTranslationServiceProvider;
use Illuminate\Translation\Translator;

class TranslationServiceProvider extends IlluminateTranslationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Translator::macro('addPath', function ($path, $jsonPath = true) {
            $this->loader->addPath($path, $jsonPath);
        });
    }

    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            return new FileLoader($app['files'], $app['path.lang']);
        });
    }
}

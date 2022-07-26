# Laravel Translation

[![Latest Stable Version](https://poser.pugx.org/datalogix/laravel-translation/version)](https://packagist.org/packages/datalogix/laravel-translation)
[![Total Downloads](https://poser.pugx.org/datalogix/laravel-translation/downloads)](https://packagist.org/packages/datalogix/laravel-translation)
[![tests](https://github.com/datalogix/laravel-translation/workflows/tests/badge.svg)](https://github.com/datalogix/laravel-translation/actions)
[![StyleCI](https://github.styleci.io/repos/418695011/shield?style=flat)](https://github.styleci.io/repos/418695011)
[![codecov](https://codecov.io/gh/datalogix/laravel-translation/branch/main/graph/badge.svg)](https://codecov.io/gh/datalogix/laravel-translation)
[![License](https://poser.pugx.org/datalogix/laravel-translation/license)](https://packagist.org/packages/datalogix/laravel-translation)

> Laravel translation is a package the power of register paths of translations.

## Features

- Manipulate the paths of your translations as you like
- Register many paths to translations

## Installation

You can install the package via composer:

```bash
composer require datalogix/laravel-translation
```

The package will automatically register itself.

## Usage

```php
// app/Providers/AppServiceProvider.php

public function boot()
{
    $this->callAfterResolving('translator', function ($translator) {
        $translator->addPath(__DIR__.'/../lang');
    });
}
```

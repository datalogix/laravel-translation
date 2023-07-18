<?php

namespace Datalogix\Translation\Tests;

use Datalogix\Translation\TranslationServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class TestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     */
    protected static function getServiceProviderClass(): string
    {
        return TranslationServiceProvider::class;
    }
}

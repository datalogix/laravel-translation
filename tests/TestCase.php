<?php

namespace Datalogix\Translation\Tests;

use Datalogix\Translation\TranslationServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class TestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected function getServiceProviderClass()
    {
        return TranslationServiceProvider::class;
    }
}

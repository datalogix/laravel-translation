<?php

namespace Datalogix\Translation\Tests;

class TranslationTest extends TestCase
{
    public function testPaths()
    {
        $t = $this->app['translator'];
        $t->addPath(__DIR__ . '/new-path1');
        $t->addPath(__DIR__ . '/new-path2', false);

        $this->assertEquals($t->getLoader()->paths(), [__DIR__ . '/new-path1', __DIR__ . '/new-path2']);
        $this->assertEquals($t->getLoader()->jsonPaths(), [__DIR__ . '/new-path1']);
    }
}

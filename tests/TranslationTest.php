<?php

namespace Datalogix\Translation\Tests;

class TranslationTest extends TestCase
{
    public function testPaths()
    {
        $t = $this->app['translator'];
        $t->addPath(__DIR__.'/new-path1');
        $t->addPath(__DIR__.'/new-path2', false);

        $this->assertInArray(__DIR__.'/new-path1', $t->getLoader()->paths());
        $this->assertInArray(__DIR__.'/new-path2', $t->getLoader()->paths());
        $this->assertEquals($t->getLoader()->jsonPaths(), [__DIR__.'/new-path1']);
    }
}

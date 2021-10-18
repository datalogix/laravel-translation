<?php

namespace Datalogix\Translation\Tests;

use Datalogix\Translation\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Mockery as m;

class FileLoaderTest extends TestCase
{
    public function testLoadMethodWithNamespacesProperlyCallsLoader()
    {
        $loader = new FileLoader($files = m::mock(Filesystem::class), __DIR__);
        $files->shouldReceive('exists')->once()->with('bar/en/foo.php')->andReturn(true);
        $files->shouldReceive('exists')->once()->with(__DIR__.'/vendor/namespace/en/foo.php')->andReturn(false);
        $files->shouldReceive('getRequire')->once()->with('bar/en/foo.php')->andReturn(['foo' => 'bar']);
        $loader->addNamespace('namespace', 'bar');

        $this->assertEquals(['foo' => 'bar'], $loader->load('en', 'foo', 'namespace'));
    }

    public function testLoadMethodWithoutPaths()
    {
        $loader = new FileLoader($files = m::mock(Filesystem::class), __DIR__);
        $files->shouldReceive('exists')->once()->with(__DIR__.'/en/foo.php')->andReturn(true);
        $files->shouldReceive('getRequire')->once()->with(__DIR__.'/en/foo.php')->andReturn(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $loader->load('en', 'foo'));
    }

    public function testLoadMethodWithPaths()
    {
        $loader = new FileLoader($files = m::mock(Filesystem::class), __DIR__);
        $files->shouldReceive('exists')->once()->with(__DIR__.'/new-path/en/foo.php')->andReturn(true);
        $files->shouldReceive('getRequire')->once()->with(__DIR__.'/new-path/en/foo.php')->andReturn(['foo' => 'bar']);
        $loader->addPath(__DIR__.'/new-path');

        $this->assertEquals(['foo' => 'bar'], $loader->load('en', 'foo'));
    }

    public function testLoadMethodWithMultiplePaths()
    {
        $loader = new FileLoader($files = m::mock(Filesystem::class), __DIR__);
        $files->shouldReceive('exists')->once()->with(__DIR__.'/new-path1/en/foo.php')->andReturn(false);
        $files->shouldReceive('exists')->once()->with(__DIR__.'/new-path2/en/foo.php')->andReturn(true);
        $files->shouldReceive('getRequire')->once()->with(__DIR__.'/new-path2/en/foo.php')->andReturn(['foo' => 'bar']);
        $loader->addPath(__DIR__.'/new-path1');
        $loader->addPath(__DIR__.'/new-path2');

        $this->assertEquals(['foo' => 'bar'], $loader->load('en', 'foo'));
    }

    public function testLoadMethdoWithInvalidPaths()
    {
        $loader = new FileLoader($files = m::mock(Filesystem::class), __DIR__);
        $files->shouldReceive('exists')->once()->with(__DIR__.'/new-path1/en/foo.php')->andReturn(false);
        $files->shouldReceive('exists')->once()->with(__DIR__.'/new-path2/en/foo.php')->andReturn(false);
        $files->shouldReceive('exists')->once()->with(__DIR__.'/en/foo.php')->andReturn(true);
        $files->shouldReceive('getRequire')->once()->with(__DIR__.'/en/foo.php')->andReturn(['foo' => 'bar']);
        $loader->addPath(__DIR__.'/new-path1');
        $loader->addPath(__DIR__.'/new-path2');

        $this->assertEquals(['foo' => 'bar'], $loader->load('en', 'foo'));
    }

    public function testLoadMethodForJSONWithoutPaths()
    {
        $loader = new FileLoader($files = m::mock(Filesystem::class), __DIR__);
        $loader->addPath(__DIR__.'/new-path', false);

        $files->shouldReceive('exists')->once()->with(__DIR__.'/en.json')->andReturn(true);
        $files->shouldReceive('get')->once()->with(__DIR__.'/en.json')->andReturn('{"foo":"bar"}');

        $this->assertEquals(['foo' => 'bar'], $loader->load('en', '*', '*'));
    }

    public function testLoadMethodForJSONWithPaths()
    {
        $loader = new FileLoader($files = m::mock(Filesystem::class), __DIR__);
        $loader->addPath(__DIR__.'/new-path');

        $files->shouldReceive('exists')->once()->with(__DIR__.'/en.json')->andReturn(false);
        $files->shouldReceive('exists')->once()->with(__DIR__.'/new-path/en.json')->andReturn(true);
        $files->shouldReceive('get')->once()->with(__DIR__.'/new-path/en.json')->andReturn('{"foo":"bar"}');

        $this->assertEquals(['foo' => 'bar'], $loader->load('en', '*', '*'));
    }
}

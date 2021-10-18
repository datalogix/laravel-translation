<?php

namespace Datalogix\Translation;

use Illuminate\Contracts\Translation\Loader as BaseLoader;

interface Loader extends BaseLoader
{
    /**
     * Add a new path to the loader.
     *
     * @param  string  $path
     * @param  bool  $jsonPath
     * @return void
     */
    public function addPath($path, $jsonPath = true);

    /**
     * Get an array of all the registered paths.
     *
     * @return array
     */
    public function paths();
}
